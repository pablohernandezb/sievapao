<?
    session_start();
    require "cAutorizacion.php";
    use  SimpleExcel\SimpleExcel;
    session_start();
    require "cAutorizacion.php";
    require "SimpleCSV/src/SimpleExcel/SimpleExcel.php";
    extract($_GET);
    extract($_POST);

    $csv_mimetypes = array(
        'text/csv',
        'text/plain',
        'application/csv',
        'text/comma-separated-values',
        'application/excel',
        'application/vnd.ms-excel',
        'application/vnd.msexcel',
        'text/anytext',
        'application/octet-stream',
        'application/txt',
        'text/tsv'
    );

    if (in_array($_FILES['file']['type'], $csv_mimetypes)) {
	    
	      //Limit upload size (5MB)
	      $max_upload_size = 5 * 1048576;
	      if ($_FILES['file']['size'] > $max_upload_size) {
		$_SESSION['MSJ'] = "El archivo excede el tamaño límite (5MB)";
		header("Location: ../SubirArchivo.php?error");
		break;
	      }
	     
	      // Randomfile name
	      $filename = $_FILES["file"]["name"];
	      $extension = end(explode('.',$filename));
	      $renamed = md5($filename);
	    
	      //Stores file
	      move_uploaded_file($_FILES["file"]["tmp_name"],
	      "../files/" . $renamed.".".$extension);
	    
              $file = "../files/"  . $renamed.".".$extension;

              $excel = new SimpleExcel('CSV');
              $excel->parser->loadFile($file);  // Load CSV file

              echo "Eliminar la cabecera del archivo ".$_POST['cab'];
              if ($_POST['cab'] == 't') {
                $i = 2;
		echo "SI";
              }else {
                $i = 1;  
		echo "NO";
              }

	      switch ($_POST['BD']) {
		case 'Per':
		  $BD = "PERSONA";

		  if ($tam = sizeof($excel->parser->getRow(1)) > 1){
		    $columna = sizeof($excel->parser->getColumn(1));
		    $id = 1;
		    while ($i <= $columna){
		      $fila = $excel->parser->getRow($i);        

		      $direccion = $fila[43]." , ".$fila[44]." , ".$fila[45]." , ".$fila[46];
		      $unidad = $fila[51];

		      $email = $fila[7]."@cedula.usb.ve";

		      $sql="INSERT INTO PERSONA (id, tipo, nombre, apellido, cedula, sexo, fecha_nac, unidad, direccion, email) VALUES(".
		      "'$id', ".  //id persona              
		      "'$fila[0]', ".  //tipo personal              
		      "'$fila[9]', ".  //nombre persona              
		      "'$fila[8]', ".  //apellido persona
		      "'$fila[7]', ".  //cedula
		      "'$fila[10]', ". //sexo
		      "'$fila[19]', ". //fecha nacimiento
		      "'$unidad', ". // unidad 
		      "'$direccion', ". //direccion
		      "'$email' ". //email
		      ")";
		      
		      $resultado=ejecutarConsulta($sql, $conexion);

		      $sql = "SELECT id FROM CARGO WHERE codigo = '$fila[16]';";

		      $resultado=ejecutarConsulta($sql, $conexion);

		      if ($rows = numResultados($resultado) > 0 ) {
			$fila=obtenerResultados($resultado);

			$sql="INSERT INTO PERSONA_CARGO (id_per, id_car, actual, fecha_ini, observacion) VALUES(".
			"'$id', ".  //id organizacion              
			"'$fila[id]', ".  //id organizacion              
			"'t', ".  //id organizacion              
			"'', ".  //id familia de cargo
			"'' ".  //observacion
			//observacion
			")";
			$resultado=ejecutarConsulta($sql, $conexion);
		      }
		      $id++;
		      $i++;
		    }
		    $sql = "ALTER SEQUENCE PERSONA_ID_SEQ RESTART WITH $id;";
		    $resultado=ejecutarConsulta($sql, $conexion);

		  }

		  //echo $sql;
		  break;
		case 'Org':
		  $BD = "ORGANIZACION";         
		  if ($tam = sizeof($excel->parser->getRow(1)) > 1){
		    $columna = sizeof($excel->parser->getColumn(1));
		    while ($i <= $columna){
		      $fila = $excel->parser->getRow($i);

		      $codigo = $fila[0].$fila[1].$fila[2];

		      $sql="INSERT INTO ORGANIZACION (id, idsup, nombre, codigo, descripcion, observacion) VALUES(";
		      $sql.="'$codigo', ";  //id organizacion   
		      if (substr($codigo, 1) == '000') {
			$sql.="'0', ";  //id organizacion                
		      }elseif (substr($codigo, 2) == '00'){
			$sup = substr($codigo, 0, 1)."000";
			$sql.="'$sup', ";  //id organizacion   
		      } else {
			$sup = substr($codigo, 0, 2)."00";
			$sql.="'$sup', ";  //id organizacion   
		      }
		
		      $sql.= "'$fila[3]', ".  //nombre de la organizacion
		      "'$codigo', ".  //codigo de la organizacion
		      "'', ".  //descripcion de la organizacion
		      "'' ".  //observacion de la organizacion
		      ")";

		      $i++;
		      $resultado=ejecutarConsulta($sql, $conexion);
		    }

		  }

		  break;
		case 'Car':
		  $BD = "CARGO";              
		  if ($tam = sizeof($excel->parser->getRow(1)) > 1){
		    $columna = sizeof($excel->parser->getColumn(1));
		    while ($i <= $columna){
		      $fila = $excel->parser->getRow($i);

		      if ($fila[4] == "x") {
			$familia = "1";
		      }else if ($fila[5] == "x") {
			$familia = "2";
		      }else if ($fila[6] == "x") {
			$familia = "3";
		      }else if ($fila[7] == "x") {
			$familia = "4";
		      }else if ($fila[8] == "x") {
			$familia = "5";
		      }else {
			$familia = "0";
		      }

		      $sql="INSERT INTO CARGO (id_fam, codigo, codtno, codgra, nombre, clave, descripcion, funciones) VALUES(".
		      "$familia, ".  //id familia de cargo
		      "'$fila[1]', ".  //codigo cargo
		      "'$fila[3]', ". //nombre cargo
		      "'$fila[0]', ". //nombre cargo
		      "'$fila[2]', ". //nombre cargo
		      "'f', ". //clave para la organizacion                
		      "'', ". //descripcion
		      "'' ".   //funciones
		      ")";

		      $i++;
		      $resultado=ejecutarConsulta($sql, $conexion);
		    }

		  }

		  break;
		case 'Rol':
		  $BD = "ROL";
		  break;
		default:
		  header("Location: ../SubirArchivo.php?error"); 
		  break;
		}
        cerrarConexion($conexion);
        unlink($file);
        echo "<br>BASE DE DATOS ".$BD."<br>";
        
    $_SESSION['MSJ'] = "Los datos fueron registrados";
    header("Location: ../SubirArchivo.php?success");

    }else{
      $_SESSION['MSJ'] = "Tipo de archivo incorrecto";
      header("Location: ../SubirArchivo.php?error"); 
    }

 

?>
