<?php
	session_start();
require_once "cConstantes.php";

$login = $_SESSION['USBID'];
$tipo = $_SESSION['tipo'];
$email=$_SESSION['email'];
/*
if ($_SESSION['tipo'] == "empleados") {
    $sql7 = "SELECT * FROM Usuario WHERE usbid='$login'";
    $resultado7 = ejecutarConsulta($sql7, $conexion);
    $fila = obtenerResultados($resultado7);
    $num = numResultados($resultado7);

    if ($num != 0) {
        $_SESSION[ROL] = $fila['rol'];
    }
}
*/


//$sql = "SELECT * FROM Usuario WHERE usbid='$login'";
//$resultado = ejecutarConsulta($sql, $conexion);

//Se verifica que el USBID est� almacenado en la BD local al Sistema, si no est�, se incluyen los datos b�sicos
//if (numResultados($resultado) == 0) {
//    $resultado=insertarUsuario($login,$email,$tipo,$conexion);
//}
cerrarConexion($conexion);

header("Location: ../");
?>

