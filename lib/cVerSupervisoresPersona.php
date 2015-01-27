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

    $SUP_ID = obtenerIds($conexion, "PERSONA", true);

    $atts = array("id_sup", "actual", "fecha_ini", "fecha_fin", "observacion" );

    $sql ="SELECT * ";
    $sql.="FROM PERSONA_SUPERVISOR ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id_per='".$_GET['id']."'";
    }

    $LISTA_SUP = obtenerDatos($sql, $conexion, $atts, "Sup");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
