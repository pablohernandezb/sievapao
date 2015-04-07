<?php
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);

    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

    $ORG_ID = obtenerIds($conexion, "ORGANIZACION", false);
    $SUP_ID = obtenerIds($conexion, "PERSONA", true);
    $EVA_ID = obtenerIds($conexion, "PERSONA", true);
    $CAR_ID = obtenerIds($conexion, "CARGO", false);
    $CON_ID = obtenerIds($conexion, "CONDICIONES", false);
    $ROL_ID = obtenerIds($conexion, "FAMILIA_ROL", false);

    if (isset($_GET['id'])) {
        $atts = array("id", "tipo", "nombre", "apellido", "cedula", "sexo", "fecha_nac", "unidad", "email", "activo", "condicion", "seccion", "rol");

        $sql ="SELECT * ";
        $sql.="FROM PERSONA ";
        $sql.="WHERE id='".$_GET['id']."'";

        $LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

        if (intval($LISTA_PER['Per']['unidad']['0']) > 8000) {
            $sede = "Litoral";
        } else {
            $sede = "Sartenejas";
        }

        switch ($LISTA_PER['Per']['tipo']['0']) {
            case '1':
                $tipo = "Académico";
                break;
            case '2':
                $tipo = "Administrativo";
                break;
            case '3':
                $tipo = "Obrero";
                break;
            default:
                $tipo = "Otro";
                break;
        }

        $atts = array("id_per", "id_car", "fecha_ini", "observacion");

        $sql ="SELECT * ";
        $sql.="FROM PERSONA_CARGO ";
        $sql.="WHERE id_per='".$_GET['id']."' AND actual='t' ";

        $LISTA_PER_CAR = obtenerDatos($sql, $conexion, $atts, "Per_Car");        

        $atts = array("id_per", "id_sup", "fecha_ini", "observacion");

        $sql ="SELECT * ";
        $sql.="FROM PERSONA_SUPERVISOR ";
        $sql.="WHERE id_per='".$_GET['id']."'";
        $sql.="ORDER BY fecha_fin DESC";

        $LISTA_PER_SUP = obtenerDatos($sql, $conexion, $atts, "Per_Sup"); 

        $atts = array("id_per", "id_eva", "actual", "fecha_ini","fecha_fin", "observacion");

        $sql ="SELECT * ";
        $sql.="FROM PERSONA_EVALUADOR ";
        $sql.="WHERE id_per='".$_GET['id']."'";
        $sql.="AND actual=TRUE ";
        $sql.="ORDER BY fecha_fin DESC";

        $LISTA_PER_EVA = obtenerDatos($sql, $conexion, $atts, "Per_Eva"); 

    }else if (isset($all)){
        $atts = array("id", "nombre", "apellido", "cedula", "sexo", "fecha_nac", "unidad", "direccion", "telefono", "email", "activo", "condicion", "seccion", "rol");

        $sql ="SELECT * ";
        $sql.="FROM PERSONA ";
        $sql.="WHERE id!='0'";
        $sql.="ORDER BY id ";

        $LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");
    }

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
