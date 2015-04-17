<?php

try{
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    //include "cMail.php";
//  del post
//  asun, fecha , tipo, descrip

    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

//    if( !$_POST['tipo'] OR !$_POST['asun'] OR !$_POST['descrip'] ){
//	    $_ERRORES[] = 'Todos los campos son obligatorios';
//    }

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
            case 'add':
                $sql="INSERT INTO ORGANIZACION (idsup, nombre, codigo, descripcion, observacion) VALUES(".
                "'$_POST[org]', ". //id superior
                "'$_POST[oname]', ". //nombre organizacion
                "'$_POST[cod]', ". //codigo organizacion
                "'$_POST[desc]', ". //descripcion
                "'$_POST[obs]' ". //observacion
                ")";
                break;

            case 'delete':
                $sql="DELETE FROM ORGANIZACION WHERE id='".$_GET['id']."'";
                break;

            case 'edit':
                $sql = "UPDATE ORGANIZACION SET idsup='$_POST[org]', nombre='$_POST[oname]', codigo='$_POST[cod]', 
                        descripcion='$_POST[desc]', observacion='$_POST[obs]' WHERE id='$_GET[id]'";
                break;
            
            default:
                # code...
                break;
        }

    }

    $resultado=ejecutarConsulta($sql, $conexion);

    cerrarConexion($conexion);

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
            case 'delete':
                $_SESSION['MSJ'] = "Los datos fueron eliminados";
                header("Location: ../vListarUnidades.php?success"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "Los datos fueron registrados";
                header("Location: ../vListarUnidades.php?success"); 
                break;
        }

    }

}catch (ErrorException $e) {
    $error = $e->getMessage();
    $resultado=ejecutarConsulta($sql, $conexion);

    cerrarConexion($conexion);

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
            case 'delete':
                $_SESSION['MSJ'] = "No se pudo eliminar la organizacion";
                header("Location: ../vListarCargos.php?error"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "No se pudo registrar la organizacion";
                header("Location: ../vCargo.php?error"); 
                break;
        }

    }
}

?>
