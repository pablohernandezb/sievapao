<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    
    // Obtención de las encuestas definidas
    $sql ="SELECT * ";
    $sql.="FROM ENCUESTA_LS WHERE actual='t' ORDER BY id_fam";        
    $atts = array("id_encuesta_ls", "id_fam", "actual");
    $LISTA_ENCUESTA= obtenerDatos($sql, $conexion, $atts, "Enc");
    
    // Obtención de las familias de roles
    for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){    
      $sql ="SELECT nombre FROM FAMILIA_rol WHERE id='".$LISTA_ENCUESTA['Enc']['id_fam'][$i]."'";   
      $atts = array("nombre"); 
      $aux= obtenerDatos($sql, $conexion, $atts, "Rol");
      $LISTA_ROLES[$i]=$aux['Rol']['nombre'][0];
    }        

    if (isset($_GET['action']) && $_GET['action']=='delete'){
   
      //Actualizar vigencia de la encuesta (antigua)
      $sql="DELETE FROM ENCUESTA_LS WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."'";
      $resultado_sql=ejecutarConsulta($sql,$conexion);
      $sql="DELETE FROM ENCUESTA WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."'";
      $_SESSION['MSJ'] = "La encuesta fue eliminada";
      header("Location: ../vEncuestasLimesurvey.php?success");  
    }
 
?> 


