<?php
  session_start();
   
  $_SESSION[usuario_validado]=1;
  $_SESSION[USBID]="tjporco";
  //$_SESSION[USBID]="07-41336";
  $_SESSION[nombres]="Teresa";
  $_SESSION[apellidos]="Porco";
  $_SESSION[cedula]="6208709";
  //$_SESSION[cedula]="11555391";
  // $_SESSION[carnet]="05-38242";
  $_SESSION[tipo]="administrativos";
  
  $_SESSION[cct]=1;
  
  if ($_SESSION[usuario_validado]==1){
    header("Location: cVerificarUsuario.php");
  }
  
?>
