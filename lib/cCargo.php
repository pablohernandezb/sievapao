<?php
try {

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
                $sql="INSERT INTO CARGO (id_fam, codigo, nombre, clave, descripcion, funciones) VALUES(".
                "'$_POST[fam]', ".  //id familia de cargo
                "'$_POST[cod]', ".  //codigo cargo
                "'$_POST[name]', ". //nombre cargo
                "'$_POST[clav]', ". //clave para la organizacion                
                "'$_POST[desc]', ". //descripcion
                "'$_POST[obs]' ".   //funciones
                ")";
                //echo $sql;
                break;

            case 'delete':
                $sql="DELETE FROM CARGO WHERE id='".$_GET['id']."'";
                break;

            case 'edit':
                $sql = "UPDATE CARGO SET id_fam='$_POST[fam]', codigo='$_POST[cod]', nombre='$_POST[name]', 
                        clave='$_POST[clav]', descripcion='$_POST[desc]', funciones='$_POST[obs]' WHERE id='$_GET[id]'";
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
                header("Location: ../vListarCargos.php?success"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "Los datos fueron registrados";
                header("Location: ../vListarCargos.php?success"); 
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
                $_SESSION['MSJ'] = "No se pudo eliminar el cargo, revise la bitacora";
                header("Location: ../vListarCargos.php?error"); 
                break;
            
            default:
                $_SESSION['MSJ'] = "No se pudo registrar el cargo, revise la bitacora";
                header("Location: ../vCargo.php?error"); 
                break;
        }

    }
}
?>
