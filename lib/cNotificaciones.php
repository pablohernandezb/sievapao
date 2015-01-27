<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    
      //Buscar las notificaciones no leídas por el administrador
      $sql="SELECT id, tipo, id_per, token_ls_per, mensaje, fecha FROM NOTIFICACION WHERE revisado=FALSE";
      $atts=array("id", "tipo", "id_per", "token_ls_per", "mensaje", "fecha", "notificacion");
      $LISTA_NOTIFICACIONES=obtenerDatos($sql, $conexion, $atts, "Not");
 
      
      for($i=0; $i<$LISTA_NOTIFICACIONES['max_res']; $i++){
	 
	 //Determinar nombre del generador de la notificacion
	 $sql="SELECT nombre, apellido FROM PERSONA WHERE id='".$LISTA_NOTIFICACIONES['Not']['id_per'][$i]."'";
	 $atts=array("nombre", "apellido");
	 $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	 $nombre=$aux['Aux']['nombre'][0].' '.$aux['Aux']['apellido'][0];
	 
	switch($LISTA_NOTIFICACIONES['Not']['tipo'][$i]){
	  case '1':
	    $LISTA_NOTIFICACIONES['Not']['notificacion'][$i]="El trabajador ".$nombre." registró su disconformidad con los resultados de su evaluación";
	    break;
	  case '0':
	    //Determinar datos de los involucrados en la evaluación rechazada
	    $sql="SELECT id_evaluado, id_encuestado FROM PERSONA_ENCUESTA WHERE token_ls='".$LISTA_NOTIFICACIONES['Not']['token_ls_per'][$i]."'";
	    $atts=array("id_evaluado", "id_encuestado");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $sql_1="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_evaluado'][0]."'";
	    $sql_2="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_encuestado'][0]."'";
	    $atts=array("nombre", "apellido");
	    $aux_1=obtenerDatos($sql_1, $conexion, $atts, "Aux");
	    $aux_2=obtenerDatos($sql_2, $conexion, $atts, "Aux");
	    $nombre_evaluado=$aux_1['Aux']['nombre'][0].' '.$aux_1['Aux']['apellido'][0];
	    $nombre_encuestado=$aux_2['Aux']['nombre'][0].' '.$aux_2['Aux']['apellido'][0];
	    
	    $LISTA_NOTIFICACIONES['Not']['notificacion'][$i]="El supervisor jerárquico <i>".$nombre."</i> rechazó la evaluación del trabajador <i>".$nombre_evaluado."</i> realizada por <i>".$nombre_encuestado."</i>";
	    $LISTA_NOTIFICACIONES['Not']['mensaje'][$i]="No aplica";
	    break;
	  case '2':
	    //Determinar datos de los involucrados en la evaluación aprobada
	    $sql="SELECT id_evaluado, id_encuestado FROM PERSONA_ENCUESTA WHERE token_ls='".$LISTA_NOTIFICACIONES['Not']['token_ls_per'][$i]."'";
	    $atts=array("id_evaluado", "id_encuestado");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $sql_1="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_evaluado'][0]."'";
	    $sql_2="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_encuestado'][0]."'";
	    $atts=array("nombre", "apellido");
	    $aux_1=obtenerDatos($sql_1, $conexion, $atts, "Aux");
	    $aux_2=obtenerDatos($sql_2, $conexion, $atts, "Aux");
	    $nombre_evaluado=$aux_1['Aux']['nombre'][0].' '.$aux_1['Aux']['apellido'][0];
	    $nombre_encuestado=$aux_2['Aux']['nombre'][0].' '.$aux_2['Aux']['apellido'][0];
	    
	    $LISTA_NOTIFICACIONES['Not']['notificacion'][$i]="El supervisor jerárquico <i>".$nombre."</i> aprobó la evaluación previamente rechazada del trabajador <i>".$nombre_evaluado."</i> realizada por <i>".$nombre_encuestado."</i>";
	    $LISTA_NOTIFICACIONES['Not']['mensaje'][$i]="No aplica";
	    break;	  
	}
      }
      
      //Buscar las notificaciones leídas por el administrador
      $sql="SELECT id, tipo, id_per, token_ls_per, fecha, mensaje FROM NOTIFICACION WHERE revisado=TRUE ORDER BY id DESC";
      $atts=array("id", "tipo", "id_per", "token_ls_per", "fecha", "mensaje", "notificacion");
      $HISTORIAL_NOTIFICACIONES=obtenerDatos($sql, $conexion, $atts, "Not");
      
      for($i=0; $i<$HISTORIAL_NOTIFICACIONES['max_res']; $i++){
      
	//Determinar nombre del generador de la notificacion
	 $sql="SELECT nombre, apellido FROM PERSONA WHERE id='".$HISTORIAL_NOTIFICACIONES['Not']['id_per'][$i]."'";
	 $atts=array("nombre", "apellido");
	 $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	 $nombre=$aux['Aux']['nombre'][0].' '.$aux['Aux']['apellido'][0];
	 
	switch($HISTORIAL_NOTIFICACIONES['Not']['tipo'][$i]){
	  case '1':
	    $HISTORIAL_NOTIFICACIONES['Not']['notificacion'][$i]="El trabajador ".$nombre." registró su disconformidad con los resultados de su evaluación";
	    break;
	  case '0':
	    //Determinar datos de los involucrados en la evaluación rechazada
	    $sql="SELECT id_evaluado, id_encuestado FROM PERSONA_ENCUESTA WHERE token_ls='".$HISTORIAL_NOTIFICACIONES['Not']['token_ls_per'][$i]."'";
	    $atts=array("id_evaluado", "id_encuestado");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $sql_1="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_evaluado'][0]."'";
	    $sql_2="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_encuestado'][0]."'";
	    $atts=array("nombre", "apellido");
	    $aux_1=obtenerDatos($sql_1, $conexion, $atts, "Aux");
	    $aux_2=obtenerDatos($sql_2, $conexion, $atts, "Aux");
	    $nombre_evaluado=$aux_1['Aux']['nombre'][0].' '.$aux_1['Aux']['apellido'][0];
	    $nombre_encuestado=$aux_2['Aux']['nombre'][0].' '.$aux_2['Aux']['apellido'][0];
	    
	    $HISTORIAL_NOTIFICACIONES['Not']['notificacion'][$i]="El supervisor jerárquico <i>".$nombre."</i> rechazó la evaluación del trabajador <i>".$nombre_evaluado."</i> realizada por <i>".$nombre_encuestado."</i>";
	    $HISTORIAL_NOTIFICACIONES['Not']['mensaje'][$i]="No aplica";
	    break;
	  case '2':
	    //Determinar datos de los involucrados en la evaluación aprobada
	    $sql="SELECT id_evaluado, id_encuestado FROM PERSONA_ENCUESTA WHERE token_ls='".$HISTORIAL_NOTIFICACIONES['Not']['token_ls_per'][$i]."'";
	    $atts=array("id_evaluado", "id_encuestado");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $sql_1="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_evaluado'][0]."'";
	    $sql_2="SELECT nombre, apellido FROM PERSONA WHERE id='".$aux['Aux']['id_encuestado'][0]."'";
	    $atts=array("nombre", "apellido");
	    $aux_1=obtenerDatos($sql_1, $conexion, $atts, "Aux");
	    $aux_2=obtenerDatos($sql_2, $conexion, $atts, "Aux");
	    $nombre_evaluado=$aux_1['Aux']['nombre'][0].' '.$aux_1['Aux']['apellido'][0];
	    $nombre_encuestado=$aux_2['Aux']['nombre'][0].' '.$aux_2['Aux']['apellido'][0];
	    
	    $HISTORIAL_NOTIFICACIONES['Not']['notificacion'][$i]="El supervisor jerárquico <i>".$nombre."</i> aprobó la evaluación previamente rechazada del trabajador <i>".$nombre_evaluado."</i> realizada por <i>".$nombre_encuestado."</i>";
	    $HISTORIAL_NOTIFICACIONES['Not']['mensaje'][$i]="No aplica";
	    break;	  
	}
      }
   
    
    if (isset($_GET['action']) && $_GET['action']=='check'){

      $sql="UPDATE NOTIFICACION SET revisado=TRUE WHERE id='".$_GET['id']."'";       
      $resultado=ejecutarConsulta($sql, $conexion);
      header("Location: ../vNotificaciones.php");

    }
    
    //Cierre conexión a la BD
    cerrarConexion($conexion);
  
?> 