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
                $sql="INSERT INTO FAMILIA_CARGO (nombre, descripcion) VALUES(".
                "'$_POST[name]', ". //nombre organizacion
                "'$_POST[desc]' ". //descripcion
                ")";
                break;

            case 'delete':
                $sql="DELETE FROM FAMILIA_CARGO WHERE id='".$_GET['id']."'";
                break;

            case 'edit':
                $sql = "UPDATE FAMILIA_CARGO SET nombre='$_POST[name]', descripcion='$_POST[desc]' WHERE id='$_GET[id]'";
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
                header("Location: ../vListarFamiliasC.php?success"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "Los datos fueron registrados";
                header("Location: ../vListarFamiliasC.php?success"); 
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
                $_SESSION['MSJ'] = "No se pudo eliminar la familia de cargos";
                header("Location: ../vListarFamiliasC.php?error"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "No se pudo registrar la familia de cargos";
                header("Location: ../vFamiliaC.php?error"); 
                break;
        }

    }
}

?>
