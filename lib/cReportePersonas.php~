<?php
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);

    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();

    $ORG_ID = obtenerIds($conexion, "ORGANIZACION", false);
    $SUP_ID = obtenerIds($conexion, "PERSONA", true);
    $EVA_ID = obtenerIds($conexion, "PERSONA", true);
    $CAR_ID = obtenerIds($conexion, "CARGO", false);
    $CON_ID = obtenerIds($conexion, "CONDICIONES", false);
    $ROL_ID = obtenerIds($conexion, "FAMILIA_ROL", false);

    if (isset($_GET['report'])) {
	switch ($_GET['report']) {
	     case "cargo":

		$atts = array("id", "nombre", "apellido", "cedula", "email");
		$sql ="SELECT * ";
		$sql.="FROM PERSONA ";
		$sql.="WHERE id!='0'";
		$sql.="ORDER BY id ";
		$LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

		for ($i = 0;$i<$LISTA_PER['max_res'];$i++) {

			$atts = array("codigo", "nombre");
			$sql = "SELECT CODIGO, NOMBRE ";
			$sql.= "FROM CARGO ";
			$sql.= "WHERE ID IN ";
			$sql.= "(SELECT ID_CAR FROM PERSONA_CARGO WHERE ID_PER='".(int)$LISTA_PER['Per']['id'][$i]."' AND actual=TRUE)";
			$LISTA_TMP = obtenerDatos($sql, $conexion, $atts, "Car");
			$LISTA_CAR['Car']['codigo'][$i] = $LISTA_TMP['Car']['codigo'][0];
			$LISTA_CAR['Car']['nombre'][$i] = $LISTA_TMP['Car']['nombre'][0];

		}

	      break;
	     case "unidad":

		$atts = array("id", "nombre", "apellido", "cedula", "email", "unidad");
		$sql ="SELECT * ";
		$sql.="FROM PERSONA ";
		$sql.="WHERE id!='0'";
		$sql.="ORDER BY id ";
		$LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

		for ($i = 0;$i<$LISTA_PER['max_res'];$i++) {

			$atts = array("nombre");
			$sql = "SELECT NOMBRE ";
			$sql.= "FROM ORGANIZACION ";
			$sql.= "WHERE CODIGO='".$LISTA_PER['Per']['unidad'][$i]."'";
			$LISTA_TMP = obtenerDatos($sql, $conexion, $atts, "Uni");
			$LISTA_UNI['Uni']['nombre'][$i] = $LISTA_TMP['Uni']['nombre'][0];

		}

	      break;
	     case "rol":

		$atts = array("id", "nombre", "apellido", "cedula", "email", "tipo", "rol");
		$sql ="SELECT * ";
		$sql.="FROM PERSONA ";
		$sql.="WHERE id!='0'";
		$sql.="ORDER BY id ";
		$LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

	      break;
	     case "sincargo":

		$atts = array("id", "nombre", "apellido", "cedula", "email", "unidad");
		$sql ="SELECT * ";
		$sql.="FROM PERSONA ";
		$sql.="WHERE id!='0'";
		$sql.="ORDER BY id ";
		$LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

		for ($i = 0;$i<$LISTA_PER['max_res'];$i++) {

			$atts = array("codigo", "nombre");
			$sql = "SELECT CODIGO, NOMBRE ";
			$sql.= "FROM CARGO ";
			$sql.= "WHERE ID IN ";
			$sql.= "(SELECT ID_CAR FROM PERSONA_CARGO WHERE ID_PER='".(int)$LISTA_PER['Per']['id'][$i]."' AND actual=TRUE)";
			$LISTA_TMP = obtenerDatos($sql, $conexion, $atts, "Car");
			$LISTA_CAR['Car']['codigo'][$i] = $LISTA_TMP['Car']['codigo'][0];
			$LISTA_CAR['Car']['nombre'][$i] = $LISTA_TMP['Car']['nombre'][0];
		
			$atts = array("nombre");
			$sql = "SELECT NOMBRE ";
			$sql.= "FROM ORGANIZACION ";
			$sql.= "WHERE CODIGO='".$LISTA_PER['Per']['unidad'][$i]."'";
			$LISTA_TMP = obtenerDatos($sql, $conexion, $atts, "Uni");
			$LISTA_UNI['Uni']['nombre'][$i] = $LISTA_TMP['Uni']['nombre'][0];

		}

	      break;
	      case "sinsupervisor":
		$atts = array("id", "nombre", "apellido", "cedula", "email", "unidad");
		$sql ="SELECT * ";
		$sql.="FROM PERSONA ";
		$sql.="WHERE id!='0'";
		$sql.="ORDER BY id ";
		$LISTA_PER = obtenerDatos($sql, $conexion, $atts, "Per");

		for ($i = 0;$i<$LISTA_PER['max_res'];$i++) {
			$atts = array("id_per", "id_eva", "actual", "fecha_ini","fecha_fin", "observacion");
			$sql ="SELECT * ";
			$sql.="FROM PERSONA_EVALUADOR ";
			$sql.="WHERE id_per='".$LISTA_PER['Per']['id'][$i]."'";
			$sql.="AND actual=TRUE ";
			$sql.="ORDER BY fecha_fin DESC";
			$LISTA_PER_EVA = obtenerDatos($sql, $conexion, $atts, "Per_Eva"); 
			$LISTA_PER['Per']['supervisores'][$i] = count($LISTA_PER_EVA['Per_Eva']['id_per']);

			$atts = array("nombre");
			$sql = "SELECT NOMBRE ";
			$sql.= "FROM ORGANIZACION ";
			$sql.= "WHERE CODIGO='".$LISTA_PER['Per']['unidad'][$i]."'";
			$LISTA_TMP = obtenerDatos($sql, $conexion, $atts, "Uni");
			$LISTA_UNI['Uni']['nombre'][$i] = $LISTA_TMP['Uni']['nombre'][0];

		}
	      break;

	}
    }

    cerrarConexion($conexion);
//    include_once("cEnviarCorreo.php");
    
?>
