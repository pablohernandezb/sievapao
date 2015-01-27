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
    $FAM_ID = obtenerIds($conexion, "FAMILIA_CARGO", false);

    $atts = array("id", "id_fam", "codigo", "codtno" ,"codgra", "nombre", "clave","descripcion", "funciones" );

    $sql ="SELECT * ";
    $sql.="FROM CARGO ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id='".$_GET['id']."'";
    }else{
        $sql.="WHERE id!='0'";
        $sql.="ORDER BY id ";
    }

    $LISTA_CARG = obtenerDatos($sql, $conexion, $atts, "Carg");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
