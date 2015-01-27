<?php
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    date_default_timezone_set('America/Caracas');
    
    // Obtención de datos del usuario
    $atts = array("id");
    $sql ="SELECT id ";
    $sql.="FROM PERSONA ";
    if (isset($_SESSION['cedula'])) {
	$cedula= $_SESSION['cedula'];
        $sql.="WHERE cedula='".$cedula."'";
    }
    
    $PERSONA = obtenerDatos($sql, $conexion, $atts, "Per");
    
    //Inicialización de variables
    $LISTA_SUPERVISION_ACTUAL[max_res]=0;
    if(isset($PERSONA['Per']['id'][0])) {
      
      $id_usuario=$PERSONA['Per']['id'][0];

      //Evaluaciones a supervisar para el periodo de evaluación actual
      ////////////////////////////////////////////////////////////////
      
	// Obtención de la lista de supervisados
	$sql ="SELECT id_per FROM PERSONA_SUPERVISOR WHERE id_sup='".$id_usuario."' AND actual='t'";
	$atts = array("id_per");
	$LISTA_SUPERVISADOS= obtenerDatos($sql, $conexion, $atts, "Sup");
	
	// Obtención del identificador, tipo, estado, periodo y token de Limesurvey de las encuestas de los supervisados
	$sql ="SELECT id_encuesta_ls, id_evaluado, id_encuestado, token_ls, tipo, estado, periodo FROM PERSONA_ENCUESTA WHERE actual='t' AND tipo='evaluador' AND ("; 
	for($i=0; $i<$LISTA_SUPERVISADOS[max_res]; $i++){
	  $sql.="id_evaluado='".$LISTA_SUPERVISADOS['Sup']['id_per'][$i]."'";
	  if($i<$LISTA_SUPERVISADOS[max_res]-1){
	    $sql.=" OR ";
	  }
	}
	$sql.=") ORDER BY tipo DESC";
	$atts = array("id_encuesta_ls", "id_evaluado", "id_encuestado", "token_ls", "tipo", "estado", "periodo", "nombre_periodo");
	$LISTA_SUPERVISION_ACTUAL= obtenerDatos($sql, $conexion, $atts, "Sup");

	$LISTA_NOMBRE_EVALUADO=array();
	$LISTA_NOMBRE_ENCUESTADO=array();
	//Obtención de los nombres de los evaluados y encuestados y el nombre del proceso de evaluación
	for ($i=0; $i<$LISTA_SUPERVISION_ACTUAL[max_res]; $i++){
	  $atts = array("nombre", "apellido");
	  //Nombre del evaluado
	  $sql ="SELECT nombre, apellido FROM PERSONA WHERE ";
	  $sql.= "id='".$LISTA_SUPERVISION_ACTUAL["Sup"]["id_evaluado"][$i]."'";
	  $resultado= obtenerDatos($sql, $conexion, $atts, "Nom");
	  $LISTA_NOMBRE_EVALUADO[$i]=$resultado["Nom"]["nombre"][0].' '.$resultado["Nom"]["apellido"][0];
	  //Nombre del encuestado
	  $sql ="SELECT nombre, apellido FROM PERSONA WHERE ";
	  $sql.= "id='".$LISTA_SUPERVISION_ACTUAL["Sup"]["id_encuestado"][$i]."'";
	  $resultado= obtenerDatos($sql, $conexion, $atts, "Nom");
	  $LISTA_NOMBRE_ENCUESTADO[$i]=$resultado["Nom"]["nombre"][0].' '.$resultado["Nom"]["apellido"][0];
	  //Nombre del proceso
	  $sql ="SELECT periodo FROM EVALUACION WHERE id='".$LISTA_SUPERVISION_ACTUAL["Sup"]["periodo"][$i]."'";
	  $atts = array("periodo");
	  $NOMBRE_PERIODO= obtenerDatos($sql, $conexion, $atts, "Nom");
	  $LISTA_SUPERVISION_ACTUAL["Sup"]["nombre_periodo"][$i]=$NOMBRE_PERIODO["Nom"]["periodo"][0];//Nombre del proceso de evaluación
	}
      }

    cerrarConexion($conexion);
    
?>
