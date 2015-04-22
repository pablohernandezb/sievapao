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
		if (isset($_GET['id']) && $_GET['id']<3000) { // Es una persona
                	$atts = array("nombre", "apellido", "email");
			$sql ="SELECT nombre, apellido, email ";
			$sql.="FROM PERSONA ";
			$sql.="WHERE id='".$_GET['id']."'";

			$LISTA_EMAIL = obtenerDatos($sql, $conexion, $atts, "Per");
		} else if (isset($_GET['id']) && $_GET['id']>=3000) { // Es una unidad
                	$atts = array("nombre", "apellido", "email");
			$sql ="SELECT nombre, apellido, email ";
			$sql.="FROM PERSONA ";
			$sql.="WHERE unidad='".$_GET['id']."'";

			$LISTA_EMAIL = obtenerDatos($sql, $conexion, $atts, "Per");
		}
                break;
            case 'send':

		// Datos de envío del correo electrónico

		$destEmail = $_POST['dest_correo']; 
		$destNombre = $_POST['dest_nombre'];
		$remEmail = "evaluacion@usb.ve"; 
		$remNombre = "Dirección de Gestión del Capital Humano USB";

		$asunto = $_POST['asunto'];
		$mensaje = $_POST['mensaje'];

		if(isset($_POST['cc'])) {
			$cc = $_POST['cc']; 
		}
		if(isset($_POST['bcc'])) {
			$bcc = $_POST['bcc'];
		}

		if(isset($_POST['tipo']) && $_POST['tipo']=='html') {
			$tipo = "";
		} else {
			$type = "plain";	
		}

		$adjuntos = array();

		// Manejo de archivos adjuntos

                if (isset($_FILES['archivos'])) {

		 for ($i = 0; $i < count($_FILES['archivos']['name']); $i++){
			if (is_uploaded_file($_FILES['archivos']['tmp_name'][$i])) {
				 $nombreDirectorio = "../tmp";
				 $nombreArchivo = $_FILES['archivo']['name'][$i];

				 $nombreCompleto = $nombreDirectorio."/".$nombreArchivo;
				 if (is_file($nombreCompleto))
				 {
				 	$idUnico = time();
					$nombreArchivo = $idUnico . "-" . $nombreFichero;
				 }

				 move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $nombreDirectorio."/".$nombreArchivo);
				 $adjuntos[$i] = $nombreCompleto.":".$_FILES['archivo']['type'][$i].":".$_FILES['archivo']['name'][$i];

			} else {
			 	print ("No se ha podido subir el fichero");
			}       
		 }
	        }   

		$envioOK = enviarEmail($destEmail, 
				       $destNombre, 
				       $remEmail, 
				       $remName, 
				       $cc, 
				       $bcc, 
				       $asunto, 
				       $mensaje, 
				       $adjuntos, 
				       $prioridad, 
				       $tipo);

		break;
            default:
                # code...
                break;
        }

    }

    //$resultado=ejecutarConsulta($sql, $conexion);
    cerrarConexion($conexion);

    if (isset($_GET['action'])){

        switch ($_GET['action']) {
      
            case 'send':
		if($envioOK) {
		        $_SESSION['MSJ'] = "El mensaje fué enviado exitosamente.";
		        header("Location: ../vEnviarCorreo.php?success"); 
		} else {
			$_SESSION['MSJ'] = "El mensaje no pudo ser enviado. Intente nuevamente.";
			header("Location: ../vEnviarCorreo.php?error");	
		}
                break;
                                
            default:
               
                break;
        }

    }

?>
