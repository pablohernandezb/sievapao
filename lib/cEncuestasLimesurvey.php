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
    
    // Obtención de las familias de cargos
    for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){    
      $sql ="SELECT nombre FROM FAMILIA_CARGO WHERE id='".$LISTA_ENCUESTA['Enc']['id_fam'][$i]."'";   
      $atts = array("nombre"); 
      $aux= obtenerDatos($sql, $conexion, $atts, "Car");
      $LISTA_CARGOS[$i]=$aux['Car']['nombre'][0];
    }    
    
    if (isset($_GET['action']) && $_GET['action']=='delete'){
   
      //Actualizar vigencia de la encuesta (antigua)
      $sql="UPDATE ENCUESTA_LS SET actual='f' WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."'";
      $resultado_sql=ejecutarConsulta($sql,$conexion);
      $sql="UPDATE ENCUESTA SET actual='f' WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."'";
      $_SESSION['MSJ'] = "La encuesta fue eliminada";
      header("Location: ../vEncuestas.php?success");  
    }
 
?> 


