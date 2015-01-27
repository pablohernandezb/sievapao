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

    $atts = array("id","nombre","descripcion" );

    $sql ="SELECT * ";
    $sql.="FROM FAMILIA_CARGO ";

    if (isset($_GET['id'])) {
        $sql.="WHERE id='".$_GET['id']."'";
    }else{
        $sql.="WHERE id!='0'";
        $sql.="ORDER BY id ";
    }

    $LISTA_FC = obtenerDatos($sql, $conexion, $atts, "Fc");

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
