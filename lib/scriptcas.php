<?php
	session_start();

// ********** Script para Autenticar con el CAS y validar usuario en LDAP **********
// ********** Adaptado por Joan Zamora, Departamento SOS DST **********

/*********** Modificado por Yenny Villalba ***********\
* Para integración con el Sistema de Servicio Comunitario *
 ********** */


/*** Aqui comienza la autenticacion con el CAS  ***/
//import phpCAS lib
include_once('CAS.php');

phpCAS::setDebug();

// inicializa sesion phpCAS
phpCAS::client(CAS_VERSION_2_0,'secure.dst.usb.ve',443,'');

phpCAS::setNoCasServerValidation();

// Forza la autenticacion CAS
phpCAS::forceAuthentication();

// Para cerrar la cesion
if (isset($_REQUEST['logout'])) {
     phpCAS::logout();
}
/*** Aqui termina la autenticación con el CAS ***/

/*** Comienzo de Validacion con LDAP ***/

// Se obtiene el login del usuario invocando phpCAS::getUser();
$usuario=phpCAS::getUser();
$_SESSION['usuario_validado']=0;

// Se establece una conexion anónima al servidor LDAP
$ds=ldap_connect("ldap-master.usb.ve, ldap1.usb.ve, ldap2.usb.ve");


if ($ds) {
           //busqueda con el filtro a la base de datos LDAP
           $r=ldap_bind($ds);
           $sr=ldap_search($ds,"ou=People,dc=usb,dc=ve", "(&(uid=".$usuario.")(objectclass=inetOrgPerson))");
           $info = ldap_get_entries($ds, $sr);
           if ($info['count'] > 0)
           {
             if ($r)
               {
               //Campo Nombre de usuario "cn"
               $nombre_completo=$info[0]["cn"][0];
               //Campo cedula del usuario "personalid"
               $cedula=$info[0]["personalid"][0];
               //Campo Tipo de usuario "homedirectory"
               $tipo_per=$info[0]["homedirectory"][0];
               $carrera=$info[0]["career"][0];
               $carnet=$info[0]["studentid"][0];
			   $email = $info[0]["mail"][0];
 
			   $nombre_separado = explode(" ", $nombre_completo);
			   $nombre1 = $nombre_separado[0];
			   $nombre2 = $nombre_separado[1];
			   $nombres = $nombre1." ".$nombre2;
			   $apellido1 = $nombre_separado[2];
			   $apellido2 = $nombre_separado[3];
			   $apellidos = $apellido1." ".$apellido2;
			   
               $_SESSION['usuario_validado']=1;
	           $_SESSION['USBID']=phpCAS::getUser();
               $_SESSION['nombres']=$nombres;
			   $_SESSION['apellidos']=$apellidos; 
			   $_SESSION['cedula']=$cedula;
			   $_SESSION['carrera']=$carrera;
			   $_SESSION['carnet']=$carnet;
               $_SESSION['email']=$email;	   

                

               //Seguridad para evitar CSRF
               $_SESSION['csrf'] = sha1($_SESSION['USBID'].date("Ymd H:i:s"));
                           
			   $tipo=explode("/",$tipo_per);
			   $_SESSION['tipo']=$tipo[2];    
               if($_SESSION['tipo']=="pregrado" || $_SESSION['tipo']=="postgrado"){
                    //	"Error tipo de usuario\n";
			$_SESSION['usuario_validado']=-2;
               }                 
			   }
               else
               {
               //	"Error en el bind\n";
			   $_SESSION['usuario_validado']=-1;
               }
           }
           else
           {
           //	"No se encontro datos del usuario\n";
		   $_SESSION['usuario_validado']=0;
           }
         }
         else
         {
        //	"Error en la conexion del servidor\n";
		$_SESSION['usuario_validado']=-1;
         }
ldap_close($ds);

/*** Aqui termina ala validacion LDAP ***/

/* Se elige a donde redireccionar al usuario,
 * Dependiendo del resultado obtenido en la autenticación.
*/

if ($_SESSION['usuario_validado']==0){
	?>
	<script>
	alert("USBID o password incorrecto, por favor verifique sus datos y vuelva a intentarlo.");
	window.location="salir.php";
	</script>	
	<?
}
if ($_SESSION['usuario_validado']==-1){
	?>
	<script>
	alert("Ocurrio un error al autenticar, por favor intente mas tarde.");
	window.location="salir.php";
	</script>	
	<?
}
/*
if ($_SESSION['usuario_validado']==-2){
	?>
	<script>
	alert("Los estudiantes no tienen acceso a este sistema, puedes acceder desde la cuenta de una agrupaci\u00f3n estudiantil.");
	window.location="salir.php";
	</script>	
	<?
}
if ($_SESSION['usuario_validado']==1){*/
	header("Location: cVerificarUsuario.php?tok=$_SESSION[csrf]");
//}
	
?>
