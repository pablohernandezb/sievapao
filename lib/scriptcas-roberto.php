<?php
  session_start();
   
  $_SESSION[usuario_validado]=1;
  $_SESSION[USBID]="roberto";
  //$_SESSION[USBID]="07-41336";
  $_SESSION[nombres]="Roberto";
  $_SESSION[apellidos]="Omaña"; 
  $_SESSION[cedula]="11222333";
  // $_SESSION[carnet]="05-38242";
  $_SESSION[tipo]="administrativos";
  
  $_SESSION[cct]=1;
  
  if ($_SESSION[usuario_validado]==1){
    header("Location: cVerificarUsuario.php");
  }
  
?>
