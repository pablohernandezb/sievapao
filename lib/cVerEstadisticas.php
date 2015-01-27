<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    
    if (isset($_GET['periodo'])){
    
      // Obtención del proceso de evaluacion
      $sql ="SELECT periodo ";
      $sql.="FROM EVALUACION WHERE id='".$_GET['periodo']."'";        
      $atts = array("periodo");
      $aux= obtenerDatos($sql, $conexion, $atts, "Proc");
      $nombre_periodo= $aux["Proc"]["periodo"][0];//nombre del periodo de evaluación
      
      //Obtención del número total de evaluaciones
      $sql="SELECT tipo, token_ls, id_encuesta_ls, id_encuestado, id_evaluado, estado, ip, fecha, id_unidad FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$_GET['periodo'];
      $sql.="'";
      $atts= array("tipo", "token_ls", "id_encuesta_ls", "id_encuestado", "id_evaluado", "estado", "ip", "fecha", "id_unidad");
      $LISTA_EVALUACION=obtenerDatos($sql, $conexion, $atts, "Aux");
      
      //Sorting de las evaluaciones según su estado
      /////////////////////////////////////////////
      $j=0; $k=0; $l=0; $m=0; $n=0;
      
      
      for ($i=0; $i<$LISTA_EVALUACION[max_res]; $i++){
      
	//Obtención del nombre del evaluado
	$sql ="SELECT nombre, apellido ";
	$sql.="FROM PERSONA ";
	$sql.="WHERE ";
	$sql.= "id='".$LISTA_EVALUACION["Aux"]["id_evaluado"][$i]."'";
	$atts = array("nombre", "apellido");
	$aux= obtenerDatos($sql, $conexion, $atts, "Nom");
	$nombre_evaluado=$aux["Nom"]["nombre"][0]." ".$aux["Nom"]["apellido"][0];
	
	//Obtención del nombre del evaluador
	$sql ="SELECT nombre, apellido ";
	$sql.="FROM PERSONA ";
	$sql.="WHERE ";
	$sql.= "id='".$LISTA_EVALUACION["Aux"]["id_encuestado"][$i]."'";
	$atts = array("nombre", "apellido");
	$aux= obtenerDatos($sql, $conexion, $atts, "Nom");
	$nombre_evaluador=$aux["Nom"]["nombre"][0]." ".$aux["Nom"]["apellido"][0];
   
	//Obtención del nombre de la unidad adscrita
	$sql ="SELECT nombre ";
	$sql.="FROM ORGANIZACION ";
	$sql.="WHERE ";
	$sql.= "id='".$LISTA_EVALUACION["Aux"]["id_unidad"][$i]."'";
	$atts = array("nombre");
	$aux= obtenerDatos($sql, $conexion, $atts, "Uni");
	$nombre_unidad=$aux["Uni"]["nombre"][0];

	//Agregar a la lista correspondiente
	switch($LISTA_EVALUACION["Aux"]["estado"][$i]){
	  case 'Pendiente':
	    $LISTA_PENDIENTE["tipo"][$j]= $LISTA_EVALUACION["Aux"]["tipo"][$i];
	    $LISTA_PENDIENTE["nombre_evaluado"][$j]= $nombre_evaluado;
	    $LISTA_PENDIENTE["nombre_evaluador"][$j]= $nombre_evaluador;
	    $LISTA_PENDIENTE["unidad"][$j]=$nombre_unidad;
	    $j++;
	    break;
	  case 'En proceso':
	    $LISTA_EN_PROCESO["tipo"][$k]= $LISTA_EVALUACION["Aux"]["tipo"][$i];
	    $LISTA_EN_PROCESO["nombre_evaluado"][$k]= $nombre_evaluado;
	    $LISTA_EN_PROCESO["nombre_evaluador"][$k]= $nombre_evaluador;
	    $LISTA_EN_PROCESO["fecha"][$k]= $LISTA_EVALUACION["Aux"]["fecha"][$i];
	    $LISTA_EN_PROCESO["ip"][$k]= $LISTA_EVALUACION["Aux"]["ip"][$i];
	    $LISTA_EN_PROCESO["unidad"][$k]=$nombre_unidad;
	    $k++;
	    break;
	  case 'Aprobada':
	  case 'Rechazada':
	  case 'Finalizada':
	    $LISTA_FINALIZADA["tipo"][$n]= $LISTA_EVALUACION["Aux"]["tipo"][$i];
	    $LISTA_FINALIZADA["nombre_evaluado"][$n]= $nombre_evaluado;
	    $LISTA_FINALIZADA["nombre_evaluador"][$n]= $nombre_evaluador;
	    $LISTA_FINALIZADA["fecha"][$n]= $LISTA_EVALUACION["Aux"]["fecha"][$i];
	    $LISTA_FINALIZADA["ip"][$n]= $LISTA_EVALUACION["Aux"]["ip"][$i];
	    $LISTA_FINALIZADA["token_ls"][$n]= $LISTA_EVALUACION["Aux"]["token_ls"][$i];
	    $LISTA_FINALIZADA["unidad"][$n]=$nombre_unidad;
	    $n++;  
	    if($LISTA_EVALUACION["Aux"]["estado"][$i]=='Aprobada') {
	    
	      $sql ="SELECT id_sup, fecha, ip FROM SUPERVISOR_ENCUESTA WHERE token_ls_eva='".$LISTA_EVALUACION["Aux"]["token_ls"][$i]."'";
	      $atts = array("id_sup", "fecha", "ip");
	      $aux= obtenerDatos($sql, $conexion, $atts, "Sup");
	      
	      $sql ="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Sup']['id_sup'][0]."'";
	      $atts = array("nombre", "apellido");
	      $aux_1= obtenerDatos($sql, $conexion, $atts, "Nom");
	      $nombre_supervisor=$aux_1["Nom"]["nombre"][0]." ".$aux_1["Nom"]["apellido"][0];
	      
	      $LISTA_APROBADA["nombre_supervisor"][$l]= $nombre_supervisor;
	      $LISTA_APROBADA["nombre_evaluado"][$l]= $nombre_evaluado;
	      $LISTA_APROBADA["nombre_evaluador"][$l]= $nombre_evaluador;
	      $LISTA_APROBADA["token_ls"][$l]= $LISTA_EVALUACION["Aux"]["token_ls"][$i];
	      $LISTA_APROBADA["unidad"][$l]=$nombre_unidad;
	      $LISTA_APROBADA["ip"][$l]=$aux['Sup']['ip'][0];
	      $LISTA_APROBADA["fecha"][$l]=$aux['Sup']['fecha'][0];
	      $l++;
	    } else if($LISTA_EVALUACION["Aux"]["estado"][$i]=='Rechazada') {
	    
	      $sql ="SELECT id_sup, fecha, ip FROM SUPERVISOR_ENCUESTA WHERE token_ls_eva='".$LISTA_EVALUACION["Aux"]["token_ls"][$i]."'";
	      $atts = array("id_sup", "fecha", "ip");
	      $aux= obtenerDatos($sql, $conexion, $atts, "Sup");
	      
	      $sql ="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Sup']['id_sup'][0]."'";
	      $atts = array("nombre", "apellido");
	      $aux_1= obtenerDatos($sql, $conexion, $atts, "Nom");
	      $nombre_supervisor=$aux_1["Nom"]["nombre"][0]." ".$aux_1["Nom"]["apellido"][0];
	      
	      $LISTA_RECHAZADA["nombre_supervisor"][$m]= $nombre_supervisor;
	      $LISTA_RECHAZADA["nombre_evaluado"][$m]= $nombre_evaluado;
	      $LISTA_RECHAZADA["nombre_evaluador"][$m]= $nombre_evaluador;
	      $LISTA_RECHAZADA["token_ls"][$m]= $LISTA_EVALUACION["Aux"]["token_ls"][$i];
	      $LISTA_RECHAZADA["unidad"][$m]=$nombre_unidad;
	      $LISTA_RECHAZADA["ip"][$m]=$aux['Sup']['ip'][0];
	      $LISTA_RECHAZADA["fecha"][$m]=$aux['Sup']['fecha'][0];
	      $m++;
	    }
	    break;
	} //cierre del switch  
      } //cierre de la iteración
    }
    
    //Cierre conexión a la BD
    cerrarConexion($conexion);

  
?> 


