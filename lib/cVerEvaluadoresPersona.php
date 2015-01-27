<?php
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
//  include "cMail.php";
//  del post
//  asun, fecha , tipo, descrip
    $_ERRORES = array(); 
    $_WARNING = array();
    $_SUCCESS = array();

    $EVA_ID = obtenerIds($conexion, "PERSONA", true);

    $atts = array("id_eva", "actual", "fecha_ini", "fecha_fin", "observacion" );

    $sql ="SELECT * ";
    $sql.="FROM PERSONA_EVALUADOR ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id_per='".$_GET['id']."'";
    }

    $LISTA_EVA = obtenerDatos($sql, $conexion, $atts, "Eva");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
