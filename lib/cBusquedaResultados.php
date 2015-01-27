<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

    //Lista de personas
    $PERSONA_ID = obtenerIds($conexion, "PERSONA", true);
    
    //Lista de unidades
    $UNIDAD_ID = obtenerIds($conexion, "ORGANIZACION", false);
    
 
    if (isset($_GET['action'])){
      switch ($_GET['action']) {
      
	//------------------------------------------------
	//------------------------------------------------
	//MANEJO DE LA BÚSQUEDA DE RESULTADOS POR PERSONA
	//------------------------------------------------
	//------------------------------------------------
	case 'stats_persona':
	   //Manejo de errores en la entrada
	   if (isset($_GET['input'])){
	    switch ($_GET['input']) {
	      case '1':
		if ($_POST['per']==0) {
		
		  $_SESSION['MSJ']="Por favor seleccione una persona o unidad valida";
		  header("Location: ../vBusquedaResultados.php?error");
		  
		} else {
		
		  //Determinar cargos de la persona
		  $sql="SELECT id_car, fecha_ini, fecha_fin FROM PERSONA_CARGO WHERE id_per='".$_POST['per']."'";
		  $atts= array("id_car", "fecha_ini", "fecha_fin", "nombre");
		  $LISTA_CARGO=obtenerDatos($sql, $conexion, $atts, "Car");
		  
		  //La persona no tiene ningún cargo registrado
		  if(!count($LISTA_CARGO['Car']['id_car'])){
		    $_SESSION['MSJ']="La persona seleccionada no tiene un histórico de cargos registrado en el sistema";
		    header("Location: ../vBusquedaResultados.php?error");
		  } else {
		    header("Location: ../vBusquedaResultados.php?action=stats_persona&step=1&id=".$_POST['per']);
		  }
		  
		}//Fin del condicional (persona válida)
	      //Fin case input=0
	      break;
	      
	      case '2':
	      
		//Determinar los procesos en los que ha participado la persona
		$sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_evaluado='".$_GET['id']."' AND id_car='".$_POST['car']."' AND estado!='Pendiente' AND estado!='En proceso'";
		$atts= array("periodo", "nombre");
		$LISTA_ENCUESTA=obtenerDatos($sql, $conexion, $atts, "Enc");
	    
		if(count($LISTA_ENCUESTA['Enc']['periodo'])){
		  header("Location: ../vBusquedaResultados.php?action=stats_persona&step=2&id=".$_GET['id'].'&car='.$_POST['car']);
		} else {
		  $_SESSION['MSJ']="No se han registrado en el sistema resultados para la evaluación del cargo seleccionado";
		  header("Location: ../vBusquedaResultados.php?error");
		}
	      //Fin case input=1
	      break;
	      
	      case '3':

		if($_POST['proc']){
		  //Escogió un proceso de evaluación en particular
		  
		  //Determinar token_ls para ir a la vista de resultados particulares
		  $sql="SELECT token_ls FROM PERSONA_ENCUESTA WHERE id_evaluado='".$_GET['id']."' AND id_encuestado='".$_GET['id']."'AND id_car='".$_GET['car']."' AND periodo='".$_POST['proc']."'";
		  $atts= array("token_ls");
		  $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
		  $token_ls=$aux['Aux']['token_ls'][0];
		  header("Location: ../vResultados.php?token_ls=".$token_ls);
		  
		} else {
		
		  //Escogió la opción de histórico de resultados
		  //Mostrar vista de histórico de resultados
		  header("Location: ../vBusquedaResultados.php?action=hist_per&id=".$_GET['id']."&car=".$_GET['car']."&proc=".$_POST['proc']);
		  
		}	
		
	      break;
	    }//cierre del case (entradas del formulario)
	   }//cierre del if
	   //Fin del manejo de errores en la entrada
	   
	   if(isset($_GET['step']) && isset($_GET['id'])){
    
	      //Determinar nombre de la persona seleccionada
	      $sql="SELECT nombre, apellido, cedula FROM PERSONA WHERE id='".$_GET['id']."'";
	      $atts= array("nombre", "apellido", "cedula");
	      $aux=obtenerDatos($sql, $conexion, $atts, "Nom");
	      $NOMBRE=$aux['Nom']['nombre'][0].' '.$aux['Nom']['apellido'][0];
	      $CEDULA=$aux['Nom']['cedula'][0];
	      
	      //Datos
	      if ($_GET['step']==1){
		//Determinar cargos de la persona seleccionada
		$sql="SELECT id_car, fecha_ini, fecha_fin FROM PERSONA_CARGO WHERE id_per='".$_GET['id']."'";
		$atts= array("id_car", "fecha_ini", "fecha_fin", "nombre");
		$LISTA_CARGO=obtenerDatos($sql, $conexion, $atts, "Car");
		
		for($i=0; $i<count($LISTA_CARGO['Car']['id_car']); $i++){
		  $sql="SELECT nombre FROM CARGO WHERE id='".$LISTA_CARGO['Car']['id_car'][$i]."'";
		  $atts= array("nombre");
		  $aux=obtenerDatos($sql, $conexion, $atts, "Car");
		  $LISTA_CARGO['Car']['nombre'][$i]=$aux['Car']['nombre'][0];
		}
	      }//PASO 1
	      
	      if($_GET['step']==2){
		//Determinar nombre del cargo seleccionado
		$sql="SELECT nombre FROM CARGO WHERE id='".$_GET['car']."'";
		$atts= array("nombre");
		$aux=obtenerDatos($sql, $conexion, $atts, "Car");
		$CARGO=$aux['Car']['nombre'][0];
		
		//Determinar los procesos de evaluación en los que ha participado
		$sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_evaluado='".$_GET['id']."' AND id_car='".$_GET['car']."' AND estado!='Pendiente' AND estado!='En proceso'";
		$atts= array("periodo", "nombre");
		$LISTA_ENCUESTA=obtenerDatos($sql, $conexion, $atts, "Enc");
		
		for($i=0; $i<count($LISTA_ENCUESTA['Enc']['periodo']); $i++){
		  $sql="SELECT periodo FROM EVALUACION WHERE id='".$LISTA_ENCUESTA['Enc']['periodo'][$i]."'";
		  $atts= array("periodo");
		  $aux=obtenerDatos($sql, $conexion, $atts, "Eva");
		  $LISTA_ENCUESTA['Enc']['nombre'][$i]=$aux['Eva']['periodo'][0];
		}
		
		//Agregar la opción de histórico
		array_push($LISTA_ENCUESTA['Enc']['periodo'], 0);
		array_push($LISTA_ENCUESTA['Enc']['nombre'], 'Histórico');

	      }//PASO 2
	      
	    }

	break;
	//------------------------------------------------------- 
	//-------------------------------------------------------
	//FIN DEL MANEJO DE LA BÚSQUEDA DE RESULTADOS POR PERSONA  
	//-------------------------------------------------------
	//-------------------------------------------------------
	
 
	//----------------------------------------------
	//----------------------------------------------
	//MANEJO DE LA BÚSQUEDA DE RESULTADOS POR UNIDAD
	//----------------------------------------------
	//----------------------------------------------
	case 'stats_unidad':
	  if (isset($_GET['input'])){
	    switch ($_GET['input']) {
	    
	      case '1':
	      
		if ($_POST['uni']==0) {
		  $_SESSION['MSJ']="Por favor seleccione una persona o unidad valida";
		  header("Location: ../vBusquedaResultados.php?error");
		} else {
		  //Determinar si la unidad ha sido evaluada
		  $sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_unidad='".$_POST['uni']."' AND estado!='Pendiente' AND estado!='En proceso'";
		  $atts= array("periodo");
		  $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
		
		  if(count($aux['Aux']['periodo'])){
		    header("Location: ../vBusquedaResultados.php?action=stats_unidad&step=1&id=".$_POST['uni']);
		  } else {
		    $_SESSION['MSJ']="No se han registrado en el sistema resultados para la evaluación de la unidad seleccionada";
		    header("Location: ../vBusquedaResultados.php?error");
		  }
		}
	      //Fin case input=1
	      break;
	      
	      case '2';
	      
		if($_POST['proc']){
		  //Escogió un proceso de evaluación en particular
		  header("Location: ../vBusquedaResultados.php?action=view_uni&id=".$_GET['id']."&proc=".$_POST['proc']);
		} else {
		  //Mostrar vista de resultados
		  header("Location: ../vBusquedaResultados.php?action=hist_uni&id=".$_GET['id']."&proc=".$_POST['proc']);
		}
		
		
	      break;
	      
	    }// cierre del case (entradas del formulario)
	  }//cierre if
	  
	  if(isset($_GET['step']) && isset($_GET['id'])){
    
	      //Determinar nombre de la unidad seleccionada
	      $sql="SELECT nombre FROM ORGANIZACION WHERE id='".$_GET['id']."'";
	      $atts= array("nombre");
	      $aux=obtenerDatos($sql, $conexion, $atts, "Uni");
	      $NOMBRE_UNIDAD=$aux['Uni']['nombre'][0];
	      
	      //Determinar los procesos de evaluación en los que ha participado
	      $sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id']."' AND estado!='Pendiente' AND estado!='En proceso'";
	      $atts= array("periodo", "nombre");
	      $LISTA_ENCUESTA=obtenerDatos($sql, $conexion, $atts, "Enc");
	      
	      for($i=0; $i<count($LISTA_ENCUESTA['Enc']['periodo']); $i++){
		$sql="SELECT periodo FROM EVALUACION WHERE id='".$LISTA_ENCUESTA['Enc']['periodo'][$i]."'";
		$atts= array("periodo");
		$aux=obtenerDatos($sql, $conexion, $atts, "Eva");
		$LISTA_ENCUESTA['Enc']['nombre'][$i]=$aux['Eva']['periodo'][0];
	      }
	      //Agregar la opción de histórico
	      array_push($LISTA_ENCUESTA['Enc']['periodo'], 0);
	      array_push($LISTA_ENCUESTA['Enc']['nombre'], 'Histórico'); 
	    }
	  
	break;
	//----------------------------------------
	//----------------------------------------
	//FIN DEL MANEJO DE LA BÚSQUEDA POR UNIDAD
	//----------------------------------------
	//----------------------------------------
	
	//----------------------------------------
	//----------------------------------------
	//HISTORICO DE RESULTADOS PARA UNA PERSONA
	//----------------------------------------
	//----------------------------------------
	case 'hist_per':
	  
	  //Determinar datos de la persona seleccionada
	  $sql="SELECT nombre, apellido, cedula FROM PERSONA WHERE id='".$_GET['id']."'";
	  $atts= array("nombre", "apellido", "cedula");
	  $aux=obtenerDatos($sql, $conexion, $atts, "Nom");
	  $NOMBRE=$aux['Nom']['nombre'][0].' '.$aux['Nom']['apellido'][0];
	  $CEDULA=$aux['Nom']['cedula'][0];
	  
	  //Determinar datos del cargo seleccionado
	  $sql="SELECT nombre FROM CARGO WHERE id='".$_GET['car']."'";
	  $atts= array("nombre");
	  $aux_1=obtenerDatos($sql, $conexion, $atts, "Car");
	  $sql="SELECT fecha_ini, fecha_fin FROM PERSONA_CARGO WHERE id_car='".$_GET['car']."' AND id_per='".$_GET['id']."'";
	  $atts= array("fecha_ini", "fecha_fin");
	  $aux_2=obtenerDatos($sql, $conexion, $atts, "Fech");
	  $CARGO['nombre']=$aux_1['Car']['nombre'][0];
	  $CARGO['fecha_ini']=$aux_2['Fech']['fecha_ini'][0];
	  $CARGO['fecha_fin']=$aux_2['Fech']['fecha_fin'][0];
	  
	  //Obtener datos de las procesos en los que ha participado la persona para el cargo seleccionado
	  $sql="SELECT id_encuesta, token_ls, estado, id_unidad, periodo FROM PERSONA_ENCUESTA WHERE id_evaluado='".$_GET['id']."' AND id_car='".$_GET['car']."' AND tipo='autoevaluacion'";
	  $atts= array("id_encuesta", "token_ls", "estado", "nombre", "id_unidad", "periodo");
	  $LISTA_PROCESOS=obtenerDatos($sql, $conexion, $atts, "Proc");
	  
	  //Obtener nombres de los procesos
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	    $sql="SELECT periodo FROM EVALUACION WHERE id='".$LISTA_PROCESOS['Proc']['periodo'][$i]."'";
	    $atts= array("periodo");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Per");
	    $LISTA_PROCESOS['Proc']['nombre'][$i]=$aux['Per']['periodo'][0];
	  }
	  
	  //Determinar nombre de la unidad a la que está adscrita el trabajador
	  $sql="SELECT nombre FROM ORGANIZACION WHERE id='".$LISTA_PROCESOS['Proc']['id_unidad'][0]."'";
	  $atts=array("nombre");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Org");
	  $UNIDAD=$aux['Org']['nombre'][0]; //Nombre de la unidad
	  
	  //Iteración sobre las evaluaciones por proceso
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	  
	    //--------------------------------------------------------------------
	    //CALCULO DE RESULTADOS PARA LA AUTOEVALUACIÓN DEL TRABAJADOR EVALUADO
	    //--------------------------------------------------------------------
	    
	    //Cálculo de resultados para la sección de competencias      
	    $resultado= calcularPuntaje($LISTA_PROCESOS['Proc']['id_encuesta'][$i], 'competencia', $LISTA_PROCESOS['Proc']['token_ls'][$i]);
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i]=$resultado['maximo'];//puntaje máximo en la sección de competencias
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['puntaje'][$i]=$resultado['puntaje'];//puntaje obtenido en la sección de competencias

	    //Cálculo de resultados para la sección de factores
	    $resultado= calcularPuntaje($LISTA_PROCESOS['Proc']['id_encuesta'][$i], 'factor', $LISTA_PROCESOS['Proc']['token_ls'][$i]);
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i]=$resultado['maximo'];//puntaje máximo en la sección de factores
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['puntaje'][$i]=$resultado['puntaje'];//puntaje obtenido en la sección de factores
	    
	    //----------------------------------------------------------
	    //CALCULO DE RESULTADOS PARA LAS EVALUACIONES DEL TRABAJADOR
	    //----------------------------------------------------------
	    
	    //Obtener datos de las evaluaciones de los supervisores inmediatos del trabajador evaluado
	    $sql="SELECT id_encuesta, token_ls, estado FROM PERSONA_ENCUESTA WHERE id_evaluado='".$_GET['id']."' AND periodo='".$LISTA_PROCESOS['Proc']['periodo'][$i]."' AND tipo='evaluador'";
	    $atts= array("id_encuesta", "token_ls", "estado");
	    $LISTA_EVALUACIONES=obtenerDatos($sql, $conexion, $atts, "Eva");
	    
	    $numero_evaluadores=0;
	    $competencias_total=0;
	    $factores_total=0;
	    for($j=0; $j<$LISTA_EVALUACIONES['max_res']; $j++){
	      
	      if($LISTA_EVALUACIONES['Eva']['estado'][$j]!='Pendiente' && $LISTA_EVALUACIONES['Eva']['estado'][$j]!='En proceso'){
		//Cálculo de resultados para la sección de competencias      
		$resultado= calcularPuntaje($LISTA_EVALUACIONES['Eva']['id_encuesta'][$j], 'competencia', $LISTA_EVALUACIONES['Eva']['token_ls'][$j]);
		$competencias_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		//Cálculo de resultados para la sección de factores
		$resultado= calcularPuntaje($LISTA_EVALUACIONES['Eva']['id_encuesta'][$j], 'factor', $LISTA_EVALUACIONES['Eva']['token_ls'][$j]);
		$factores_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		$numero_evaluadores++;
	      } //Fin del condicional (evaluación finalizada)
	      
	    }//Fin del ciclo sobre evaluaciones de los supervisores inmediatos
	    
	    $LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]=$competencias_total/$numero_evaluadores;
	    $LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]=$factores_total/$numero_evaluadores;
	    
	  }//Fin de la iteración (procesos)
	  
	  $PROMEDIO_COMPETENCIAS=0;
	  $PROMEDIO_FACTORES=0;
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	    if($LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]){
	      $PROMEDIO_COMPETENCIAS+=$LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i];
	      $PROMEDIO_FACTORES+=$LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i];
	      $trabajadores_evaluados++;
	    }
	  }
	  $PROMEDIO_COMPETENCIAS=$PROMEDIO_COMPETENCIAS/$trabajadores_evaluados;
	  $PROMEDIO_FACTORES=$PROMEDIO_FACTORES/$trabajadores_evaluados;

	break;
	//-----------------------------------------------
	//-----------------------------------------------
	//FIN DE HISTORICO DE RESULTADOS PARA UNA PERSONA
	//-----------------------------------------------
	//-----------------------------------------------
	
	//----------------------------------------
	//----------------------------------------
	//MUESTRA DE RESULTADOS PARA UNA UNIDAD
	//----------------------------------------
	//----------------------------------------
	case 'view_uni':
	  
	  //Determinar datos de la unidad seleccionada
	  $sql="SELECT nombre FROM ORGANIZACION WHERE id='".$_GET['id']."'";
	  $atts= array("nombre");
	  $UNIDAD=obtenerDatos($sql, $conexion, $atts, "Uni");
	  
	  //Determinar datos del proceso de evaluación seleccionado
	  $sql="SELECT periodo FROM EVALUACION WHERE id='".$_GET['proc']."'";
	  $atts= array("periodo");
	  $PROCESO=obtenerDatos($sql, $conexion, $atts, "Proc");
	  
	  //Obtener datos de las evaluaciones de la unidad para el proceso seleccionado
	  $sql="SELECT id_encuesta, id_evaluado, token_ls, estado FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id']."' AND periodo='".$_GET['proc']."' AND tipo='autoevaluacion'";
	  $atts= array("id_encuesta", "id_evaluado", "token_ls", "estado", "nombre", "deficiencia");
	  $LISTA_EVALUADOS=obtenerDatos($sql, $conexion, $atts, "Eva");
  
	  //Obtener nombres de los evaluados
	  for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
	    $sql="SELECT nombre, apellido FROM PERSONA WHERE id='".$LISTA_EVALUADOS['Eva']['id_evaluado'][$i]."'";
	    $atts= array("nombre", "apellido");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Nom");
	    $LISTA_EVALUADOS['Eva']['nombre'][$i]=$aux['Nom']['nombre'][0].' '.$aux['Nom']['apellido'][0];
	  }

	  //Obtener los resultados para cada evaluado
	  for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
	  
	    //--------------------------------------------------------------------
	    //CALCULO DE RESULTADOS PARA LA AUTOEVALUACIÓN DEL TRABAJADOR EVALUADO
	    //--------------------------------------------------------------------
	    
	    //Cálculo de resultados para la sección de competencias      
	    $resultado= calcularPuntaje($LISTA_EVALUADOS['Eva']['id_encuesta'][$i], 'competencia', $LISTA_EVALUADOS['Eva']['token_ls'][$i]);
	    $LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i]=$resultado['maximo'];//puntaje máximo en la sección de competencias
	    $LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$i]=$resultado['puntaje'];//puntaje obtenido en la sección de competencias

	    //Cálculo de resultados para la sección de factores
	    $resultado= calcularPuntaje($LISTA_EVALUADOS['Eva']['id_encuesta'][$i], 'factor', $LISTA_EVALUADOS['Eva']['token_ls'][$i]);
	    $LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i]=$resultado['maximo'];//puntaje máximo en la sección de factores
	    $LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$i]=$resultado['puntaje'];//puntaje obtenido en la sección de factores
	    
	    //----------------------------------------------------------
	    //CALCULO DE RESULTADOS PARA LAS EVALUACIONES DEL TRABAJADOR
	    //----------------------------------------------------------
	    
	    //Obtener datos de las evaluaciones de los supervisores inmediatos del trabajador evaluado
	    $sql="SELECT id_encuesta, id_encuestado, token_ls, estado FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id'];
	    $sql.="' AND periodo='".$_GET['proc']."' AND tipo='evaluador' AND id_evaluado='".$LISTA_EVALUADOS['Eva']['id_evaluado'][$i]."'";
	    $atts= array("id_encuesta", "id_encuestado", "token_ls", "estado");
	    $LISTA_EVALUADORES=obtenerDatos($sql, $conexion, $atts, "Eva");
	    
	    $numero_evaluadores=0;
	    $competencias_total=0;
	    $factores_total=0;
	    
	    for($j=0; $j<$LISTA_EVALUADORES['max_res']; $j++){
	      
	      if($LISTA_EVALUADORES['Eva']['estado'][$j]!='Pendiente' && $LISTA_EVALUADORES['Eva']['estado'][$j]!='En proceso'){
		//Cálculo de resultados para la sección de competencias      
		$resultado= calcularPuntaje($LISTA_EVALUADORES['Eva']['id_encuesta'][$j], 'competencia', $LISTA_EVALUADORES['Eva']['token_ls'][$j]);
		$competencias_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		//$LISTA_EVALUADORES['Eva']['competencias']['deficiencia'][$j]=$resultado['deficiencia'];
		//Cálculo de resultados para la sección de factores
		$resultado= calcularPuntaje($LISTA_EVALUADORES['Eva']['id_encuesta'][$j], 'factor', $LISTA_EVALUADORES['Eva']['token_ls'][$j]);
		$factores_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		//$LISTA_EVALUADORES['Eva']['factores']['deficiencia']=$resultado['respuestas'];
		$numero_evaluadores++;
	      } //Fin del condicional (evaluación finalizada)
	      
	    }//Fin del ciclo sobre supervisores inmediatos
	 
	    $LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]=$competencias_total/$numero_evaluadores;
	    $LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]=$factores_total/$numero_evaluadores;
    
	  }//Fin del ciclo sobre los evaluados 
	  
	  //Determinar deficiencias en la unidad
	  $DEFICIENCIAS=determinarDeficiencias($_GET['id'], $_GET['proc']);
	  
	  //Cálculo del promedio de los resultados
	  $PROMEDIO_COMPETENCIAS=0;
	  $PROMEDIO_FACTORES=0;
	  for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
	    if($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]){
	      $PROMEDIO_COMPETENCIAS+=$LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i];
	      $PROMEDIO_FACTORES+=$LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i];
	      $trabajadores_evaluados++;
	    }
	  }
	  $PROMEDIO_COMPETENCIAS=$PROMEDIO_COMPETENCIAS/$trabajadores_evaluados;
	  $PROMEDIO_FACTORES=$PROMEDIO_FACTORES/$trabajadores_evaluados;
	  
	break;
	//-----------------------------------------------
	//-----------------------------------------------
	//FIN DE LA MUESTRA DE RESULTADOS PARA UNA UNIDAD
	//-----------------------------------------------
	//-----------------------------------------------
	
	//---------------------------------------
	//---------------------------------------
	//HISTORICO DE RESULTADOS PARA UNA UNIDAD
	//---------------------------------------
	//---------------------------------------
	case 'hist_uni':
		  
	  //Determinar datos de la unidad seleccionada
	  $sql="SELECT nombre, descripcion FROM ORGANIZACION WHERE id='".$_GET['id']."'";
	  $atts= array("nombre", "descripcion");
	  $UNIDAD=obtenerDatos($sql, $conexion, $atts, "Uni");
	  
	  //Obtener datos de las procesos en los que ha sido evaluada la unidad seleccionada
	  $sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id']."'";
	  $atts= array("periodo", "nombre");
	  $LISTA_PROCESOS=obtenerDatos($sql, $conexion, $atts, "Proc");
	  
	  //Obtener nombres de los procesos
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	    $sql="SELECT periodo FROM EVALUACION WHERE id='".$LISTA_PROCESOS['Proc']['periodo'][$i]."'";
	    $atts= array("periodo");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Per");
	    $LISTA_PROCESOS['Proc']['nombre'][$i]=$aux['Per']['periodo'][0];
	  }
	  
	  //Iteración sobre la lista de procesos de evaluación
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	  
	    //Obtener datos de los evaluados de la unidad para el proceso de la iteración
	    $sql="SELECT id_encuesta, id_evaluado, token_ls, estado FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id']."' AND periodo='".$LISTA_PROCESOS['Proc']['periodo'][$i]."' AND tipo='autoevaluacion'";
	    $atts= array("id_encuesta", "id_evaluado", "token_ls", "estado", "nombre");
	    $LISTA_EVALUADOS=obtenerDatos($sql, $conexion, $atts, "Eva");
	    
	    //Obtener los resultados para cada evaluado
	    for($j=0; $j<$LISTA_EVALUADOS['max_res']; $j++){
	   
	      //--------------------------------------------------------------------
	      //CALCULO DE RESULTADOS PARA LA AUTOEVALUACIÓN DEL TRABAJADOR EVALUADO
	      //--------------------------------------------------------------------
	      
	      //Cálculo de resultados para la sección de competencias      
	      $resultado= calcularPuntaje($LISTA_EVALUADOS['Eva']['id_encuesta'][$j], 'competencia', $LISTA_EVALUADOS['Eva']['token_ls'][$j]);
	      $LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$j]=$resultado['maximo'];//puntaje máximo en la sección de competencias
	      $LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$j]=$resultado['puntaje'];//puntaje obtenido en la sección de competencias

	      //Cálculo de resultados para la sección de factores
	      $resultado= calcularPuntaje($LISTA_EVALUADOS['Eva']['id_encuesta'][$j], 'factor', $LISTA_EVALUADOS['Eva']['token_ls'][$j]);
	      $LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$j]=$resultado['maximo'];//puntaje máximo en la sección de factores
	      $LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$j]=$resultado['puntaje'];//puntaje obtenido en la sección de factores
	      
	      //----------------------------------------------------------
	      //CALCULO DE RESULTADOS PARA LAS EVALUACIONES DEL TRABAJADOR
	      //----------------------------------------------------------
	      
	      //Obtener datos de las evaluaciones de los supervisores inmediatos del trabajador evaluado
	      $sql="SELECT id_encuesta, id_encuestado, token_ls, estado FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id'];
	      $sql.="' AND periodo='".$LISTA_PROCESOS['Proc']['periodo'][$i]."' AND tipo='evaluador' AND id_evaluado='".$LISTA_EVALUADOS['Eva']['id_evaluado'][$j]."'";
	      $atts= array("id_encuesta", "id_encuestado", "token_ls", "estado");
	      $LISTA_EVALUADORES=obtenerDatos($sql, $conexion, $atts, "Eva");
	      
	      $numero_evaluadores=0;
	      $competencias_total=0;
	      $factores_total=0;	      
	      for($k=0; $k<$LISTA_EVALUADORES['max_res']; $k++){
		if($LISTA_EVALUADORES['Eva']['estado'][$k]!='Pendiente' && $LISTA_EVALUADORES['Eva']['estado'][$k]!='En proceso'){
		  //Cálculo de resultados para la sección de competencias      
		  $resultado= calcularPuntaje($LISTA_EVALUADORES['Eva']['id_encuesta'][$k], 'competencia', $LISTA_EVALUADORES['Eva']['token_ls'][$k]);
		  $competencias_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		  //Cálculo de resultados para la sección de factores
		  $resultado= calcularPuntaje($LISTA_EVALUADORES['Eva']['id_encuesta'][$k], 'factor', $LISTA_EVALUADORES['Eva']['token_ls'][$k]);
		  $factores_total+=$resultado['puntaje'];//puntaje obtenido en la sección de competencias
		  $numero_evaluadores++;
		} //Fin del condicional (evaluación finalizada)
		
	      }//Fin del ciclo sobre supervisores inmediatos
	      $LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$j]=$competencias_total/$numero_evaluadores;
	      $LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$j]=$factores_total/$numero_evaluadores;
	     
	    }//Fin del ciclo sobre los evaluados
	    	    
	    $PROMEDIO_COMPETENCIAS_1=0; $PROMEDIO_FACTORES_1=0;
	    $PROMEDIO_COMPETENCIAS_2=0; $PROMEDIO_FACTORES_2=0;
	    $trabajadores_evaluados_1=0; $trabajadores_evaluados_2=0;
	    for($j=0; $j<$LISTA_EVALUADOS['max_res']; $j++){

	      if($LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$j]){
		$PROMEDIO_COMPETENCIAS_1+=$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$j]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$j];
		$PROMEDIO_FACTORES_1+=$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$j]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$j];
		$trabajadores_evaluados_1++;
	      }
	      if($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$j]){
		$PROMEDIO_COMPETENCIAS_2+=$LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$j]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$j];
		$PROMEDIO_FACTORES_2+=$LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$j]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$j];
		$trabajadores_evaluados_2++;
	      }
	    }
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['competencias'][$i]=$PROMEDIO_COMPETENCIAS_1/$trabajadores_evaluados_1;
	    $LISTA_PROCESOS['Proc']['autoevaluacion']['factores'][$i]=$PROMEDIO_FACTORES_1/$trabajadores_evaluados_1;
	    $LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]=$PROMEDIO_COMPETENCIAS_2/$trabajadores_evaluados_2;
	    $LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i]=$PROMEDIO_FACTORES_2/$trabajadores_evaluados_2;
	    
	  }//Fin de la iteración (procesos)
	  
	  //Determinar deficiencias de la unidad
	  $DEFICIENCIAS=historicoDeficiencias($_GET['id']);
	  
	  //Cálculo del promedio del histórico de resultados
	  $PROMEDIO_COMPETENCIAS=0;
	  $PROMEDIO_FACTORES=0;
	  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
	    if($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]){
	      $PROMEDIO_COMPETENCIAS+=$LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i];
	      $PROMEDIO_FACTORES+=$LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i];
	      $trabajadores_evaluados++;
	    }
	  }
	  $PROMEDIO_COMPETENCIAS=$PROMEDIO_COMPETENCIAS/$trabajadores_evaluados;
	  $PROMEDIO_FACTORES=$PROMEDIO_FACTORES/$trabajadores_evaluados;
	  
	break;
	//----------------------------------------------
	//----------------------------------------------
	//FIN DE HISTORICO DE RESULTADOS PARA UNA UNIDAD
	//----------------------------------------------
	//----------------------------------------------
	
      } //cierre del switch 
    } //cierre del condicional

    //Cierre conexión a la BD
    cerrarConexion($conexion);

?> 


