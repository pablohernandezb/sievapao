<?php
  session_start();
   
  $_SESSION[usuario_validado]=1;
  $_SESSION[USBID]="kdoming";
  //$_SESSION[USBID]="07-41336";
  $_SESSION[nombres]="Kenyer";
  $_SESSION[apellidos]="Dominguez"; 
  $_SESSION[cedula]="12345678";
  // $_SESSION[carnet]="05-38242";
  $_SESSION[tipo]="administrativos";
  
  $_SESSION[cct]=1;
  
  if ($_SESSION[usuario_validado]==1){
    header("Location: cVerificarUsuario.php");
  }
  
?>
