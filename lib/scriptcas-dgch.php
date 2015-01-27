<?php
	session_start();
	$_SESSION[usuario_validado]=1;
	$_SESSION[USBID]="dgch";
	$_SESSION[nombres]="Dirección";
	$_SESSION[apellidos]="de Gestión de Capital Humano"; 
	$_SESSION[cedula]="1000000";
	$_SESSION[tipo]="administrativos";

	$_SESSION[cct]=1;
	if ($_SESSION[usuario_validado]==1){
	  header("Location: cVerificarUsuario.php");
	}
?>
