<?php
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
//      $_ERRORES[] = 'Todos los campos son obligatorios';
//    }

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
            case 'compose':
                
                break;

            case 'send':
                
		break;
            default:
                # code...
                break;
        }

    }

    // Activar cuando se haga una consulta para cerrar la conexion

    // $resultado=ejecutarConsulta($sql, $conexion);
    // cerrarConexion($conexion);

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
            case 'compose':
                $_SESSION['MSJ'] = "Los datos fueron registrados";
                header("Location: ../vListarPersonas.php?success");
                break;
      
            case 'send':
                $_SESSION['MSJ'] = "El mensaje fué enviado exitosamente.";
                header("Location: ../vListarPersonas.php?success"); 
                break;
                                
            default:
               
                break;
        }

    } 
?>
