<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    
    if(isset($_GET['token_ls'])){
      
      //Determinar a quién pertenece el token suministrado
      $sql="SELECT tipo, id_evaluado, id_encuesta, periodo FROM PERSONA_ENCUESTA WHERE token_ls='".$_GET['token_ls']."'";
      $atts=array("tipo", "id_evaluado", "id_encuesta", "periodo");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      
      //Determinar nombre del periodo
      $sql="SELECT periodo FROM EVALUACION WHERE id='".$aux['Aux']['periodo'][0]."'";
      $atts=array("periodo");
      $resultado=obtenerDatos($sql, $conexion, $atts, "Per");
      $PERIODO=$resultado['Per']['periodo'][0];

      
      if ($aux['Aux']['tipo'][0]=='evaluador'){
	//Si el token pertenece a un evaluador, buscamos el token del evaluado
	$sql="SELECT token_ls FROM PERSONA_ENCUESTA WHERE ";
	$sql.="id_encuesta='".$aux['Aux']['id_encuesta'][0]."' AND ";
	$sql.="periodo='".$aux['Aux']['periodo'][0]."' AND ";
	$sql.="id_evaluado='".$aux['Aux']['id_evaluado'][0]."' AND ";
	$sql.="id_encuestado='".$aux['Aux']['id_evaluado'][0]."'";
	$atts=array("token_ls");
	$resultado=obtenerDatos($sql, $conexion, $atts, "Tok");
	$token_ls_evaluado=$resultado['Tok']['token_ls'][0];
      } else {
	//Si el token pertenece al evaluado trabajamos con su token
	$token_ls_evaluado=$_GET['token_ls'];
      }
      
      //Obtención del ID para: encuesta, usuario evaluador, cargo evaluado, unidad asociada
      $sql="SELECT id_encuesta, id_encuesta_ls, id_evaluado, id_car, id_unidad, periodo FROM PERSONA_ENCUESTA WHERE token_ls='".$token_ls_evaluado."'";
      $atts = array("id_encuesta", "id_encuesta_ls", "id_evaluado", "id_car", "id_unidad", "periodo");
      $resultado= obtenerDatos($sql, $conexion, $atts, "Enc"); 
     
      $id_evaluado=$resultado['Enc']['id_evaluado'][0];//ID del usuario evaluado
      //Obtención del nombre del evaluado
      $sql="SELECT nombre, apellido, cedula FROM PERSONA WHERE id='".$id_evaluado."'";
      $atts = array("nombre", "apellido", "cedula");
      $aux= obtenerDatos($sql, $conexion, $atts, "Nom");
      $NOMBRE=$aux['Nom']['nombre'][0].' '.$aux['Nom']['apellido'][0]; //Nombre y apellido del usuario
      $CEDULA=$aux['Nom']['cedula'][0];
      
      $id_car=$resultado['Enc']['id_car'][0];//ID del cargo evaluado
      //Obtención del nombre del cargo evaluado
      $sql="SELECT nombre FROM CARGO WHERE id='".$id_car."'";
      $atts = array("nombre");
      $aux= obtenerDatos($sql, $conexion, $atts, "Car");
      $CARGO=$aux['Car']['nombre'][0]; //Nombre del cargo
      
      $id_unidad=$resultado['Enc']['id_unidad'][0];//ID de la unidad adscrita del evaluado
      //Obtención del nombre de la unidad a la que está adscrito el usuario
      $sql="SELECT nombre FROM ORGANIZACION WHERE id='".$id_unidad."'";
      $atts = array("nombre");
      $aux= obtenerDatos($sql, $conexion, $atts, "Org");
      $UNIDAD=$aux['Org']['nombre'][0]; //Nombre de la unidad
      
      $id_encuesta=$resultado['Enc']['id_encuesta'][0];//ID de la encuesta para el token del usuario
      $id_encuesta_ls=$resultado['Enc']['id_encuesta_ls'][0];//ID de la encuesta en Limesurvey para el token del usuario
      $id_proceso=$resultado['Enc']['periodo'][0];//ID del proceso de evaluación correspondiente al token del usuario
      
      //Obtención de las preguntas de la encuesta
      $sql="SELECT id_pregunta, titulo FROM PREGUNTA WHERE id_encuesta_ls='".$id_encuesta_ls."' AND seccion='competencia' AND id_pregunta_root_ls IS NOT NULL ORDER BY id_pregunta";
      $atts = array("id_pregunta", "titulo", "resultado");
      $LISTA_COMPETENCIAS= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas de la sección de competencias
      $sql="SELECT id_pregunta, titulo FROM PREGUNTA WHERE id_encuesta_ls='".$id_encuesta_ls."' AND seccion='factor' AND id_pregunta_root_ls IS NOT NULL ORDER BY id_pregunta";
      $atts = array("id_pregunta", "titulo", "peso", "resultado");
      $LISTA_FACTORES= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas de la sección de competencias

      //Obtención de resultados para la sección de competencias
      for($i=0; $i<$LISTA_COMPETENCIAS[max_res] ;$i++){
	$id_pregunta_i=$LISTA_COMPETENCIAS['Preg']['id_pregunta'][$i];
	$sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$id_pregunta_i."' AND token_ls='".$token_ls_evaluado."'";
	$atts = array("respuesta");
	$aux= obtenerDatos($sql, $conexion, $atts, "Res");
	$LISTA_COMPETENCIAS['Preg']['resultado'][$i]=$aux['Res']['respuesta'][0];
      }
      
      //Obtención de resultados y pesos para la sección de factores 
      for($i=0; $i<$LISTA_FACTORES[max_res] ;$i++){
	$id_pregunta_i=$LISTA_FACTORES['Preg']['id_pregunta'][$i];
	$sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$id_pregunta_i."' AND token_ls='".$token_ls_evaluado."'";
	$atts = array("respuesta");
	$aux= obtenerDatos($sql, $conexion, $atts, "Res");
	$LISTA_FACTORES['Preg']['resultado'][$i]=$aux['Res']['respuesta'][0];
	$sql="SELECT peso FROM PREGUNTA_PESO WHERE id_pregunta='".$id_pregunta_i."' AND id_encuesta='".$id_encuesta."'";
	$atts = array("peso");
	$aux= obtenerDatos($sql, $conexion, $atts, "Aux");
	$LISTA_FACTORES['Preg']['peso'][$i]=$aux['Aux']['peso'][0];
      }
      
      
      //Obtención del ID y token de cada evaluador
      $sql="SELECT id_encuestado, token_ls FROM PERSONA_ENCUESTA WHERE periodo='".$id_proceso."' AND id_encuesta='".$id_encuesta."' AND tipo='evaluador' AND estado!='En proceso' AND estado!='Pendiente' AND id_evaluado='".$id_evaluado."'";
      $atts = array("id_encuestado", "token_ls", "nombre", "re_competencia", "re_factor");
      $LISTA_EVALUADORES=obtenerDatos($sql, $conexion, $atts, "Eva");
      $PROMEDIO_EVALUADORES=array("re_competencia", "re_factor");//Arreglo donde se lleva la suma de los resultados de los evaluadores
      
      //Obtener respuestas de los evaluadores
      for($i=0; $i<$LISTA_EVALUADORES[max_res]; $i++){
	
	$sql="SELECT nombre, apellido FROM PERSONA WHERE id='".$LISTA_EVALUADORES['Eva']['id_encuestado'][$i]."'";
	$atts=array("nombre", "apellido");
	$aux= obtenerDatos($sql, $conexion, $atts, "Nom");
	$LISTA_EVALUADORES['Eva']['nombre'][$i]=$aux['Nom']['nombre'][0].' '.$aux['Nom']['apellido'][0];
	$LISTA_EVALUADORES['Eva']['re_competencia'][$i]=array();
	$LISTA_EVALUADORES['Eva']['re_factor'][$i]=array();
	
	//Obtener resultados para la sección de competencias
	for ($j=0; $j<$LISTA_COMPETENCIAS[max_res] ;$j++){
	  $id_pregunta_j=$LISTA_COMPETENCIAS['Preg']['id_pregunta'][$j];
	  $sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$id_pregunta_j."' AND token_ls='".$LISTA_EVALUADORES['Eva']['token_ls'][$i]."'";
	  $atts = array("respuesta");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Res");
	  $LISTA_EVALUADORES['Eva']['re_competencia'][$i][$j]=$aux['Res']['respuesta'][0];
	  
	  switch($aux['Res']['respuesta'][0]){
	  
	    case 'Siempre':
	      if(isset($PROMEDIO_EVALUADORES['re_competencia'][$j])) {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]+=3;
	      } else {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]=3;
	      }
	      break;
	    case 'Casi siempre':
	      if(isset($PROMEDIO_EVALUADORES['re_competencia'][$j])) {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]+=2;
	      } else {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]=2;
	      }
	      break;
	    case 'Pocas veces':
	      if(isset($PROMEDIO_EVALUADORES['re_competencia'][$j])) {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]+=1;
	      } else {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]=1;
	      }
	      break;;
	    case 'Nunca':
	      if(!(isset($PROMEDIO_EVALUADORES['re_competencia'][$j]))) {
		$PROMEDIO_EVALUADORES['re_competencia'][$j]=0;
	      }
	      break;
	  }//cierre del switch
	}//cierre del for
	
	//Obtener resultados para la sección de factores
	for ($j=0; $j<$LISTA_FACTORES[max_res] ;$j++){
	  $id_pregunta_j=$LISTA_FACTORES['Preg']['id_pregunta'][$j];
	  $sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$id_pregunta_j."' AND token_ls='".$LISTA_EVALUADORES['Eva']['token_ls'][$i]."'";
	  $atts = array("respuesta");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Res");
	  $LISTA_EVALUADORES['Eva']['re_factor'][$i][$j]=$aux['Res']['respuesta'][0];
	  
	  switch($aux['Res']['respuesta'][0]){
	    case 'Excelente':
	      if(isset($PROMEDIO_EVALUADORES['re_factor'][$j])) {
		$PROMEDIO_EVALUADORES['re_factor'][$j]+=3;
	      } else {
		$PROMEDIO_EVALUADORES['re_factor'][$j]=3;
	      }
	      break;
	    case 'Sobre lo esperado':
	      if(isset($PROMEDIO_EVALUADORES['re_factor'][$j])) {
		$PROMEDIO_EVALUADORES['re_factor'][$j]+=2;
	      } else {
		$PROMEDIO_EVALUADORES['re_factor'][$j]=2;
	      }
	      break;
	    case 'En lo esperado':
	      if(isset($PROMEDIO_EVALUADORES['re_factor'][$j])) {
		$PROMEDIO_EVALUADORES['re_factor'][$j]+=1;
	      } else {
		$PROMEDIO_EVALUADORES['re_factor'][$j]=1;
	      }
	      break;;
	    case 'Por debajo de lo esperado':
	      if(!(isset($PROMEDIO_EVALUADORES['re_factor'][$j]))) {
		$PROMEDIO_EVALUADORES['re_factor'][$j]=0;
	      }
	      break;
	  }//cierre del switch
	}//cierre de iteración sobre factores
      }//cierre iteración sobre evaluadores
      
      //Obtener puntaje de la evaluación del supervisor inmediato (promedio)
      if ($LISTA_EVALUADORES['max_res']>0){
      
	$n=$LISTA_EVALUADORES['max_res'];
	
	$PUNTAJE_COMPETENCIAS_MAX=0;//Puntaje maximo de la seccion de competencias
	$PUNTAJE_COMPETENCIAS=0;//Puntaje total de la sección de competencias
	for($i=0; $i<$LISTA_COMPETENCIAS[max_res] ;$i++){
	  $PUNTAJE_COMPETENCIAS_MAX+=3;
	  $PUNTAJE_COMPETENCIAS+=($PROMEDIO_EVALUADORES['re_competencia'][$i])/$n;
	}
	
	$PUNTAJE_FACTORES_MAX=0;//Puntaje maximo de la seccion de competencias
	$PUNTAJE_FACTORES=0;//Puntaje total de la sección de competencias
	for($i=0; $i<$LISTA_FACTORES[max_res] ;$i++){
	  $PUNTAJE_FACTORES_MAX+=3*$LISTA_FACTORES['Preg']['peso'][$i];
	  $PUNTAJE_FACTORES+=($PROMEDIO_EVALUADORES['re_factor'][$i]*$LISTA_FACTORES['Preg']['peso'][$i])/$n;
	}
	
	//Brecha del resultado (porcentaje)
	$BRECHA=(($PUNTAJE_COMPETENCIAS_MAX-$PUNTAJE_COMPETENCIAS)/$PUNTAJE_COMPETENCIAS_MAX)*100;
      }
      
      
     
    }//cierre del if
    
    //Validación Resultados en caso de Supervisor
    if(isset($_GET['action'])){
    
      $token_ls=$_GET['token_ls'];
      $ip=$_SERVER['REMOTE_ADDR']; //Dirección IP del usuario registrado
      $fecha=date("d/m/Y.H:i"); //Fecha y hora de la supervisación
	    
      //Determinar el ID del supervisor jerárquico
      $sql="SELECT id FROM PERSONA WHERE cedula='".$_SESSION['cedula']."'";
      $atts=array("id");
      $aux=obtenerDatos($sql, $conexion, $atts, "Sup");
      $id_sup=$aux['Sup']['id'][0];
      
      //Determinar datos de la evaluación supervisada 
      $sql="SELECT periodo, id_encuesta, id_evaluado, id_encuestado, token_ls ";
      $sql.="FROM PERSONA_ENCUESTA ";
      $sql.="WHERE token_ls='".$token_ls."'";
      $atts=array("periodo", "id_encuesta", "id_evaluado", "id_encuestado","token_ls");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
    
      switch($_GET['action']){
	case 'validar':
	  if ($aux['max_res']) {
	      //Insertar en tabla de supervisaciones
	      $sql="INSERT INTO SUPERVISOR_ENCUESTA (id_sup, token_ls_eva, aprobado, fecha, ip) VALUES (";
	      $sql.="'$id_sup', '$token_ls', 'TRUE', '$fecha', '$ip')";
	      $resultado_sql=ejecutarConsulta($sql, $conexion);
	      //Actualizar estado
	      $sql = "UPDATE PERSONA_ENCUESTA SET ".
	      "estado='Aprobada' ".
	      "WHERE token_ls='$_GET[token_ls]'";
	      $resultado=ejecutarConsulta($sql, $conexion);
	  }
	  break;
         case 'rechazar':
	  if ($aux['max_res']){
	      //Insertar en tabla de supervisaciones
	      $sql="INSERT INTO SUPERVISOR_ENCUESTA (id_sup, token_ls_eva, aprobado, fecha, ip) VALUES (";
	      $sql.="'$id_sup', '$token_ls', 'FALSE', '$fecha', '$ip')";
	      $resultado_sql=ejecutarConsulta($sql, $conexion);
	      //Determinar identificador del supervisor jerárquico
	      $sql="SELECT id FROM PERSONA WHERE cedula='".$_SESSION['cedula']."'";
	      $atts=array("id");
	      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	      $id_supervisor=$aux['Aux']['id'][0];
	      //Determinar fecha y hora actual
	      $fecha=date("d-m-Y.H:i");
	      //Agregar notificación al administrador
	      $sql="INSERT INTO NOTIFICACION (tipo, id_per, token_ls_per, fecha) VALUES (";
	      $sql.="'0', '$id_supervisor', '$token_ls', '$fecha')";
	      $resultado_sql=ejecutarConsulta($sql, $conexion);
	      //Actualizar estado
	      $sql = "UPDATE PERSONA_ENCUESTA SET ".
	      "estado='Rechazada' ".
	      "WHERE token_ls='$_GET[token_ls]'";
	      $resultado=ejecutarConsulta($sql, $conexion);
	  }
	  break;
         case 'notificarE':      
	  $mensaje=$_POST['msg'];
	  $token_ls=$_GET['token_ls'];
	  //Determinar nombre del evaluado
	  $sql="SELECT id_evaluado FROM PERSONA_ENCUESTA WHERE token_ls='".$token_ls."'";
	  $atts=array("id_evaluado");
	  $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	  $id_evaluado=$aux['Aux']['id_evaluado'][0];
	  //Determinar fecha y hora actual
	  $fecha=date("d-m-Y.H:i");
	  //Agregar notificación al administrador
	  $sql="INSERT INTO NOTIFICACION (tipo, id_per, token_ls_per, mensaje, fecha) VALUES (";
	  $sql.="'1', '$id_evaluado', '$token_ls', '$mensaje', '$fecha')";
	  $resultado_sql=ejecutarConsulta($sql, $conexion);
	  $_SESSION['MSJ'] = "Se ha notificado su caso a la DGCH, el personla iniciará el estudio del mismo. Podrá ser contactado próximamente";
	  header("Location: ../vListarEvaluaciones.php?warning");
	  break;
	 case 'validarR':
	  //Insertar en tabla de supervisaciones
	  $sql="UPDATE aprobado=TRUE WHERE token_ls_eva='".$_GET['token_ls']."'";
	  //Determinar id del supervisor jerárquico
	  $sql="SELECT id FROM PERSONA WHERE cedula='".$_SESSION['cedula']."'";
	  $atts=array("id");
	  $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	  $id_supervisor=$aux['Aux']['id'][0];
	  //Determinar fecha y hora actual
	  $fecha=date("d-m-Y.H:i");
	  //Agregar notificación al administrador
	  $sql="INSERT INTO NOTIFICACION (tipo, id_per, token_ls_per, fecha) VALUES (";
	  $sql.="'2', '$id_supervisor', '$token_ls', '$fecha')";
	  $resultado_sql=ejecutarConsulta($sql, $conexion);
	  //Actualizar estado
	  $sql = "UPDATE PERSONA_ENCUESTA SET ".
	  "estado='Aprobada' ".
	  "WHERE token_ls='$_GET[token_ls]'";
	  $resultado=ejecutarConsulta($sql, $conexion);
	  break;
	 }//cierre del switch
	 
      
    }//Cierre del if de Validación de Resultados
    
    //Cierre conexión a la BD
    cerrarConexion($conexion);

    if (isset($_GET['action'])){
        switch ($_GET['action']) {
                
            case 'validar':
               $_SESSION['MSJ'] = "Se ha aprobado la evaluación correspondiente";
               header("Location: ../vSupervisar.php?success");
               break;
               
            case 'validarR':
               $_SESSION['MSJ'] = "Se ha aprobado la evaluación previamente rechazada";
               header("Location: ../vSupervisar.php?success");
               break;
            
            case 'rechazar':
               $_SESSION['MSJ'] = "Se ha rechazado la evaluación correspondiente";
               header("Location: ../vSupervisar.php?success");
               break;
		
            default:
                # code...
                break;            
        }
    }
  
?> 


