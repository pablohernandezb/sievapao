<?php
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    //include "cMail.php";
//  del post
//  asun, fecha , tipo, descrip
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

    $CAR_ID = obtenerIds($conexion, "CARGO", false);

    $atts = array("id_car", "actual", "fecha_ini", "fecha_fin", "observacion" );

    $sql ="SELECT * ";
    $sql.="FROM PERSONA_CARGO ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id_per='".$_GET['id']."'";
    }

    $LISTA_CAR = obtenerDatos($sql, $conexion, $atts, "Car");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
