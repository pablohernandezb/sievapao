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

    $ORG_ID = obtenerIds($conexion, "ORGANIZACION", false);

    $atts = array("id", "idsup", "nombre", "codigo", "descripcion", "observacion" );

    $sql ="SELECT * ";
    $sql.="FROM ORGANIZACION ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id='".$_GET['id']."'";
    }else{
        $sql.="WHERE id!='0'";
        $sql.="ORDER BY id ";
    }

    $LISTA_ORG = obtenerDatos($sql, $conexion, $atts, "Org");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
