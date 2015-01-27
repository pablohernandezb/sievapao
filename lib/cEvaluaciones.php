<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    require_once 'XML/RPC2/Client.php';
    
    if (isset($_GET['action'])){
      switch ($_GET['action']) {
      
	case 'add':

	  if (isset($_POST[ini]) & isset($_POST[fin])){
	  
	    $aux= explode("-",$_POST[ini]);
	    $periodo=determinarPeriodo($aux[1], $aux[2]);
	  
	    //Agregar nuevo periodo de evaluación
	    $sql="INSERT INTO EVALUACION (periodo, fecha_ini, fecha_fin, actual) VALUES(";
	    $sql.="'$periodo', ";  //periodo de evaluacion    
	    $sql.="'$_POST[ini]', ";  //fecha_ini            
	    $sql.="'$_POST[fin]', ";  //fecha_fin         
	    $sql.="'f')";  //periodo actual            
	    $resultado=ejecutarConsulta($sql, $conexion);
	    
	    //Agregar cronjob para el día de expiración de la encuesta
	    $aux= explode("-",$_POST[fin]);
	    $output=file_put_contents('../tmp/vernier_jobs.txt', "00 00 ".$aux[0]." ".$aux[1]." * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=desactivar&inicio=$_POST[ini]'".PHP_EOL, FILE_APPEND);
	    //$output=file_put_contents('../tmp/vernier_jobs.txt', "07 00 25 11 * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=desactivar&inicio=$_POST[ini]'".PHP_EOL, FILE_APPEND);
	    $output=shell_exec('crontab ../tmp/vernier_jobs.txt');
	    
	    if ($_POST[ini]==date("d-m-Y")){
	      //No breaks to case "activar"
	    } else {
	      //Agregar cronjob para el día de inicio de la encuesta
	      $aux= explode("-",$_POST[ini]);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', "00 00 ".$aux[0]." ".$aux[1]." * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=activar&inicio=$_POST[ini]'".PHP_EOL, FILE_APPEND);
	      //$output=file_put_contents('../tmp/vernier_jobs.txt', "06 00 25 11 * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=activar&inicio=$_POST[ini]'".PHP_EOL, FILE_APPEND);
	      $output=shell_exec('crontab ../tmp/vernier_jobs.txt');
	      break;
	    }
	  }//cierre del if
	  
	case 'activar':
	
	    //Activación de la evaluación
	    if (isset($_POST[ini])) {
	      $fecha_ini=$_POST[ini];
	      $sql = "UPDATE EVALUACION SET actual= 't' WHERE fecha_ini='".$fecha_ini."'";
	      $resultado=ejecutarConsulta($sql, $conexion);
	    } else if (isset($_GET['inicio'])){
	      $fecha_ini=$_GET['inicio'];
	      $sql = "UPDATE EVALUACION SET actual= 't' WHERE fecha_ini='".$fecha_ini."'";
	      $resultado=ejecutarConsulta($sql, $conexion);
	      //Eliminar cronjob ejecutado
	      $remove= '=activar&inicio='.$_GET['inicio'];
	      $lines = file('../tmp/vernier_jobs.txt');
	      foreach($lines as $key => $line)
		if(stristr($line,$remove)) unset($lines[$key]);
		  $data = array_values($lines);
	      $aux=file_put_contents('../tmp/vernier_jobs.txt', $data);
	      $output=shell_exec('crontab ../tmp/vernier_jobs.txt');  
	    }
	    
	    //Determinar ID del proceso de evaluacion
	    $sql= "SELECT id FROM EVALUACION ORDER BY id DESC";
	    $atts = array("id");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $id_evaluacion=$aux['Aux']['id'][0];
	    
	    //Buscar fecha de finalización del proceso
	    $sql= "SELECT fecha_fin FROM EVALUACION WHERE fecha_ini='".$fecha_ini."'";
	    $atts = array("fecha_fin");
	    $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	    $fecha_fin=$aux["Aux"]["fecha_fin"][0];
	    
	    //Actualización de las encuestas
	    $sql = "UPDATE ENCUESTA SET estado= 't'";
	    $resultado=ejecutarConsulta($sql, $conexion);
	    
	    // Obtención de las encuestas definidas
	    $sql ="SELECT id_fam, id_unidad, id, id_encuesta_ls ";
	    $sql.="FROM ENCUESTA ORDER BY id_fam";        
	    $atts = array("id_fam", "id_unidad", "id", "id_encuesta_ls");
	    $LISTA_ENCUESTA= obtenerDatos($sql, $conexion, $atts, "Enc");
	    
	    //Crear un cliente para comunicarse con Limesurvey
	    $client_ls = XML_RPC2_Client::create(PATH_LS); 
	    //Pedir llave de acceso a Limesurvey
	    $session_key = $client_ls->get_session_key(USER_LS, PSWD_LS);
	    
	    for($i=0; $i<$LISTA_ENCUESTA[max_res]; $i++){
	      $id_encuesta=$LISTA_ENCUESTA["Enc"]["id"][$i];
	      $id_encuesta_ls=intval($LISTA_ENCUESTA["Enc"]["id_encuesta_ls"][$i]);//Encuesta de i-ésima iteración
	      $id_fam=$LISTA_ENCUESTA["Enc"]["id_fam"][$i];//Familia de cargos asociada a la encuesta de la i-ésima iteración
	      $id_unidad=$LISTA_ENCUESTA["Enc"]["id_unidad"][$i];//Unidad asociada a la encuesta de la i-ésima iteración
	      $fecha_ini_ls=date("Y-m-d", strtotime($fecha_ini)); //Fecha de inicio
	      $fecha_fin_ls=date("Y-m-d", strtotime($fecha_fin)); //Fecha de finalización
	      
	      //Activación de la encuesta en Limesurvey
	      $resultado= $client_ls->activate_survey($session_key, $id_encuesta_ls);//Activar la encuesta
	      
	      //Actualizar la fecha de inicio y la fecha de finalizacion en Limesurvey
	      $properties=array("startdate"=> $fecha_ini_ls, "expires"=>$fecha_fin_ls);
	      $resultado= $client_ls->set_survey_properties($session_key, $id_encuesta_ls, $properties);
	      $resultado= $client_ls->activate_tokens($session_key, $id_encuesta_ls);//Se abre la encuesta solo para usuarios con token
	      
	      //Buscar personas con el cargo de la familia de cargos de la encuesta de la i-ésima iteración
	      $sql= "SELECT id_per, id_car, fecha_ini FROM PERSONA_CARGO WHERE actual=TRUE AND id_car IN (";
	      $sql.="SELECT id FROM CARGO WHERE id_fam='".$id_fam."') AND id_per IN (";
	      $sql.="SELECT id FROM PERSONA WHERE unidad='".$id_unidad."')";
	      $atts= array("id_per","id_car","fecha_ini");
	      $LISTA_PERSONA= obtenerDatos($sql, $conexion, $atts, "Per");
	      
	      echo "El sql de interés es: $sql<br>";
	      echo "El resultado de la consulta es: <br>";
	      print_r($LISTA_PERSONA);
	      
	      
	      //Agregar las encuestas correspondientes a cada usuario
	      for($j=0; $j<$LISTA_PERSONA[max_res]; $j++){
		  
		  //Identificador de la persona
		  $id_per=$LISTA_PERSONA["Per"]["id_per"][$j];
		  //Identificador del cargo
		  $id_car=$LISTA_PERSONA["Per"]["id_car"][$j];
		  
		  //Buscar datos de la persona
		  $sql= "SELECT id, nombre, apellido, email FROM PERSONA WHERE id='";
		  $sql.= $id_per."'";
		  $atts= array("id","nombre","apellido","email");
		  
		  $DATOS= obtenerDatos($sql, $conexion, $atts, "Dat");
		  $email=$DATOS["Dat"]["email"][0];
		  $nombre=$DATOS["Dat"]["nombre"][0];
		  $apellido=$DATOS["Dat"]["apellido"][0];

		  
		    //Verificar que las personas tengan al menos 150 días (5 meses) en el cargo
		    //QUEDA PENDIENTE VERIFICAR CONDICION ESPECIAL
		    if(obtenerDiferenciaDias($fecha_ini, $LISTA_PERSONA["Per"]["fecha_ini"][$j])>150){
		      //Se agrega el usuario a la encuesta en Limesurvey
		      $usuario=array("usuario"=> array("email"=>$email,"firstname"=>$nombre,"lastname"=>$apellido));
		      $resultado= $client_ls->add_participants($session_key, $id_encuesta_ls, $usuario);//Agregar participante
		      $token_ls=$resultado["usuario"]["token"];//Obtener token asignado al usuario por limesurvey
		      $tid_ls=$resultado["usuario"]["tid"];//Obtener ID del token asignado al usuario por limesurvey
		      
		      $ip=$_SERVER['REMOTE_ADDR'];
		      $fecha_intento=date("d/m/Y.H:i");
		      
		      //Se agrega encuesta de autoevaluación
		      $sql="INSERT INTO PERSONA_ENCUESTA (id_encuesta, id_encuesta_ls, token_ls, tid_ls, periodo, id_car, id_unidad, tipo, id_encuestado, id_evaluado, estado, actual, fecha, ip) VALUES(";
		      $sql.="'$id_encuesta', "; //id de la encuesta en el sistema
		      $sql.="'$id_encuesta_ls', "; //id de la encuesta en Limesurvey
		      $sql.="'$token_ls', ";  //token asignado al encuestado por limesurvey
		      $sql.="'$tid_ls', "; //id del encuestado en Limesurvey
		      $sql.="'$id_evaluacion', "; //proceso de evaluación correspondiente
		      $sql.="'$id_car', ";  //id cargo actual    
		      $sql.="'$id_unidad', ";  //id de la unidad     
		      $sql.="'autoevaluacion', ";  //tipo de encuesta              
		      $sql.="'$id_per', ";  //id persona encuestada    
		      $sql.="'$id_per', ";  //id persona evaluada             
		      $sql.="'Pendiente', "; //estado de la encuesta
		      $sql.="'t', "; //proceso de evaluación actual
		      $sql.="'$fecha_intento', ";//fecha y hora de último intento
		      $sql.="'$ip')";//dirección ip del usuario
		      $resultado=ejecutarConsulta($sql, $conexion); 
		      
		      //Se buscan los evaluadores del usuario
		      $sql= "SELECT id_eva, fecha_ini FROM PERSONA_EVALUADOR ";
		      $sql.= "WHERE actual=TRUE AND id_per=$id_per";
		      $atts= array("id_eva","fecha_ini");
		      
		      $LISTA_EVALUADOR=obtenerDatos($sql, $conexion, $atts, "Eva");
		      
		      //Agregar las encuestas de evaluador correspondientes a cada usuario
		      for($k=0; $k<$LISTA_EVALUADOR[max_res]; $k++){ 
		      
			$id_eva=$LISTA_EVALUADOR["Eva"]["id_eva"][$k];
			//Buscar datos del evaluador
			$sql= "SELECT id, nombre, apellido, email FROM PERSONA ";
			$sql.= "WHERE id='";
			$sql.= $id_eva."'";
			$atts= array("id","nombre","apellido","email");
			$DATOS= obtenerDatos($sql, $conexion, $atts, "Dat");
			$email=$DATOS["Dat"]["email"][0];
			$nombre=$DATOS["Dat"]["nombre"][0];
			$apellido=$DATOS["Dat"]["apellido"][0];
			
			//Verificar que tenga al menos 150 días (5 meses) como evaluador
			//QUEDA PENDIENTE VERIFICAR CONDICION ESPECIAL
			if(obtenerDiferenciaDias($fecha_ini, $LISTA_EVALUADOR["Eva"]["fecha_ini"][$k])>150) {
			
			  //Se agrega el usuario a la encuesta en Limesurvey
			  $usuario=array("usuario"=> array("email"=>$email,"firstname"=>$nombre,"lastname"=>$apellido));
			  $resultado= $client_ls->add_participants($session_key, $id_encuesta_ls, $usuario);//Agregar participante
			  $token_ls=$resultado["usuario"]["token"];//Obtener token asignado al usuario por limesurvey
			  $tid_ls=$resultado["usuario"]["tid"];//Obtener ID del token asignado al usuario por limesurvey
			  
			  $sql="INSERT INTO PERSONA_ENCUESTA (id_encuesta, id_encuesta_ls, token_ls, tid_ls, periodo, id_car, id_unidad, tipo, id_encuestado, id_evaluado, estado, actual, fecha, ip) VALUES(";
			  $sql.="'$id_encuesta', "; //id de la encuesta en el sistema
			  $sql.="'$id_encuesta_ls', "; //id de la encuesta en Limesurvey
			  $sql.="'$token_ls', ";  //token asignado al encuestado por limesurvey
			  $sql.="'$tid_ls', "; //id del encuestado en Limesurvey
			  $sql.="'$id_evaluacion', "; //proceso de evaluación correspondiente
			  $sql.="'$id_car', ";  //id cargo actual    
			  $sql.="'$id_unidad', ";  //id de la unidad     
			  $sql.="'evaluador', ";  //tipo de encuesta              
			  $sql.="'$id_eva', ";  //id persona encuestada    
			  $sql.="'$id_per', ";  //id persona evaluada             
			  $sql.="'Pendiente', "; //estado de la encuesta
			  $sql.="'t', "; //proceso de evaluación actual
			  $sql.="'$fecha_intento', ";//fecha y hora de último intento
			  $sql.="'$ip')";//dirección ip del usuario
			  $resultado=ejecutarConsulta($sql, $conexion); 
			  
			} //cierre if (tiempo como evaluador)
		     } //cierre iteración sobre los evaluadores
		     
		    } //cierre if (tiempo en el cargo)     
	      }//cierre iteración sobre las personas	      
	    } //cierre iteración sobre las encuestas
	    //Devolver llave de acceso a Limesurvey
	    $resultado=$client_ls->release_session_key($session_key);
	    
	  break;
	
	case 'desactivar':
	
	  $sql= "UPDATE EVALUACION SET actual='f' WHERE fecha_ini='".$_GET['inicio']."'";
	  $resultado= ejecutarConsulta($sql, $conexion);
	  $sql= "UPDATE ENCUESTA SET estado='f'";
	  $resultado= ejecutarConsulta($sql, $conexion);
	  $sql= "UPDATE PERSONA_ENCUESTA SET actual='f'";
	  $resultado= ejecutarConsulta($sql, $conexion);
	  //Eliminar cronjob ejecutado
	  $remove= '=desactivar&inicio='.$_GET['inicio'];
	  $lines = file('../tmp/vernier_jobs.txt');
	  foreach($lines as $key => $line)
	    if(stristr($line,$remove)) unset($lines[$key]);
	      $data = array_values($lines);
	  $aux=file_put_contents('../tmp/vernier_jobs.txt', $data);
	  $output=shell_exec('crontab ../tmp/vernier_jobs.txt');
	  break;
	  
	case 'edit':
	
	  if (isset($_GET['proceso']) && isset($_POST['nuevo_ini']) && isset($_POST['nuevo_fin'])){
	  $sql ="SELECT actual, fecha_ini FROM EVALUACION WHERE id='".$_GET['proceso']."'"; 
	  $atts = array("actual", "fecha_ini");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Aux");
	  $fecha_original = $aux["Aux"]["fecha_ini"][0];
	  
	    if ($aux["Aux"]["actual"][0]=='t'){
	    
	      $sql= "UPDATE EVALUACION SET fecha_fin='".$_POST['nuevo_fin']."' WHERE id='".$_GET['proceso']."'";
	      $resultado= ejecutarConsulta($sql, $conexion);
	      
	      //Editar cronjob para desactivar el proceso de evaluación
	      ////////////////////////////////////////////////////////
	      
	      //Eliminar antiguo cronjob
	      $remove= '=desactivar&inicio='.$fecha_original;
	      $lines = file('../tmp/vernier_jobs.txt');
	      foreach($lines as $key => $line)
	      if(stristr($line,$remove)) unset($lines[$key]);
		 $data = array_values($lines);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', $data);
	      //Agregar nuevo cronjob
	      $aux= explode("-",$_POST['nuevo_fin']);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', "00 00 ".$aux[0]." ".$aux[1]." * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=desactivar&inicio=$fecha_original'".PHP_EOL, FILE_APPEND);
	      $output=shell_exec('crontab ../tmp/vernier_jobs.txt');
	      
	      //Cambiar la fecha de expiración en Limesurvey
	      //////////////////////////////////////////////
	      $client_ls = XML_RPC2_Client::create(PATH_LS);//Crear un cliente para comunicarse con Limesurvey
	      $session_key = $client_ls->get_session_key(USER_LS, PSWD_LS); //Pedir llave de acceso a Limesurvey
	      $fecha_fin_ls=date("Y-m-d", strtotime($_POST['nuevo_fin']));
	      $properties=array("expires"=>$fecha_fin_ls);
	     
	      // Obtención de las encuestas definidas
	      $sql ="SELECT id_encuesta_ls FROM ENCUESTA ORDER BY id_fam";        
	      $atts = array("id_encuesta_ls");
	      $LISTA_ENCUESTA= obtenerDatos($sql, $conexion, $atts, "Enc");
	      for ($j=0; $j<$LISTA_ENCUESTA[max_res]; $j++){
		$id_encuesta_ls=intval($LISTA_ENCUESTA["Enc"]["id_encuesta_ls"][$j]);
		$resultado= $client_ls->set_survey_properties($session_key, $id_encuesta_ls, $properties);
	      }
	      $resultado=$client_ls->release_session_key($session_key); //Devolver llave de acceso a Limesurvey
	      
	    } else {
	      $sql= "UPDATE EVALUACION SET fecha_ini='".$_POST['nuevo_ini']."', fecha_fin='".$_POST['nuevo_fin']."' WHERE id='".$_GET['proceso']."'";
	      $resultado= ejecutarConsulta($sql, $conexion);
	      
	      //Editar cronjobs para activar/desactivar el proceso de evaluación
	      ////////////////////////////////////////////////////////
	      
	      //Eliminar antiguos cronjob
	      $remove= '=activar&inicio='.$fecha_original;
	      $lines = file('../tmp/vernier_jobs.txt');
	      foreach($lines as $key => $line)
		if(stristr($line,$remove)) unset($lines[$key]);
		  $data = array_values($lines);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', $data);
	      $remove= '=desactivar&inicio='.$fecha_original;
	      foreach($lines as $key => $line)
		if(stristr($line,$remove)) unset($lines[$key]);
		  $data = array_values($lines);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', $data);
	      //Agregar nuevo cronjob
	      $aux= explode("-",$_POST['nuevo_ini']);
	      $aux_1= explode("-",$_POST['nuevo_fin']);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', "00 00 ".$aux[0]." ".$aux[1]." * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=activar&inicio=$_POST[nuevo_ini]'".PHP_EOL, FILE_APPEND);
	      $output=file_put_contents('../tmp/vernier_jobs.txt', "00 00 ".$aux_1[0]." ".$aux_1[1]." * wget -O -q -t 1 'http://localhost/vernier/lib/cEvaluaciones.php?action=desactivar&inicio=$_POST[nuevo_ini]'".PHP_EOL, FILE_APPEND);
	      $output=shell_exec('crontab ../tmp/vernier_jobs.txt');      
	    }
	  }
	  
	  break;
	
	case 'delete':
	
	  if (isset($_GET['proceso'])){
	    $sql ="SELECT actual, fecha_ini FROM EVALUACION WHERE id='".$_GET['proceso']."'"; 
	    $atts = array("actual", "fecha_ini", "periodo");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Aux");
	    $fecha_original = $aux["Aux"]["fecha_ini"][0];
	    if ($aux["Aux"]["actual"][0]=='t'){
	    
	      //Eliminar evaluaciones de usuarios
	      $sql= "DELETE FROM PERSONA_ENCUESTA WHERE periodo='".$_GET['proceso']."'";
	      $resultado= ejecutarConsulta($sql, $conexion);
	      
	      //Desactivar en Limesurvey
	      //////////////////////////
	      $client_ls = XML_RPC2_Client::create(PATH_LS);//Crear un cliente para comunicarse con Limesurvey
	      $session_key = $client_ls->get_session_key(USER_LS, PSWD_LS); //Pedir llave de acceso a Limesurvey
	      $fecha_fin_ls=date("Y-m-d");
	      $properties=array("expires"=>$fecha_fin_ls);
	      // Obtención de las encuestas definidas
	      $sql ="SELECT id_encuesta_ls FROM ENCUESTA ORDER BY id_fam";        
	      $atts = array("id_encuesta_ls");
	      $LISTA_ENCUESTA= obtenerDatos($sql, $conexion, $atts, "Enc");
	      for ($j=0; $j<$LISTA_ENCUESTA[max_res]; $j++){
		$id_encuesta_ls=intval($LISTA_ENCUESTA["Enc"]["id_encuesta_ls"][$j]);
		$resultado= $client_ls->set_survey_properties($session_key, $id_encuesta_ls, $properties);
	      }
	      $resultado=$client_ls->release_session_key($session_key); //Devolver llave de acceso a Limesurvey
	      
	    }
	    //Eliminar proceso de evaluación
	    $sql= "DELETE FROM EVALUACION WHERE id='".$_GET['proceso']."'";
	    $resultado= ejecutarConsulta($sql, $conexion);
	    //Eliminar antiguos cronjobs
	    $remove= '&inicio='.$fecha_original;
	    $lines = file('../tmp/vernier_jobs.txt');
	    foreach($lines as $key => $line)
	      if(stristr($line,$remove)) unset($lines[$key]);
		$data = array_values($lines);
	    $output=file_put_contents('../tmp/vernier_jobs.txt', $data);
	    $output=shell_exec('crontab ../tmp/vernier_jobs.txt'); 
	  }
	  break;
	  
	case 'default':    
	  #code
	  break;
      } //cierre switch
    } //cierre if
    
    // Obtención de los procesos de evaluacion del sistema
    $sql ="SELECT * ";
    $sql.="FROM EVALUACION ORDER BY id ";        
    $atts = array("id","periodo", "fecha_ini", "fecha_fin", "actual", "total","pendiente", "en_proceso", "finalizada", "supervisada");
    $LISTA_EVALUACION= obtenerDatos($sql, $conexion, $atts, "Proc");
    
    for($i=0; $i<$LISTA_EVALUACION[max_res]; $i++){ 
    
      $periodo= $LISTA_EVALUACION["Proc"]["id"][$i];//periodo de evaluación de la i-ésima iteración
      
      //Obtención del número total de evaluaciones
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo;
      $sql.="'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["total"][$i]=$aux[max_res];
      
      //Obtención del número de evaluaciones pendientes
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo."' AND estado='Pendiente'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["pendiente"][$i]=$aux[max_res];
      
      //Obtención del número de evaluaciones en proceso
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo."' AND estado='En proceso'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["en_proceso"][$i]=$aux[max_res];
      
      //Obtención del número de evaluaciones finalizadas
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo."' AND estado='Finalizada'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["finalizada"][$i]=$aux[max_res];
      
      //Obtención del número de evaluaciones aprobadas
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo."' AND estado='Aprobada'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["aprobada"][$i]=$aux[max_res];
      
      //Obtención del número de evaluaciones rechazadas
      $sql="SELECT estado FROM PERSONA_ENCUESTA WHERE periodo='";
      $sql.=$periodo."' AND estado='Rechazada'";
      $atts= array("estado");
      $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
      $LISTA_EVALUACION["Proc"]["rechazada"][$i]=$aux[max_res];
      
      // Obtención de la fecha fin del último proceso de evaluacion
      $ULTIMA_FECHA= $LISTA_EVALUACION["Proc"]["fecha_fin"][$i];
      
    } //cierre iteración sobre los procesos de evaluación
    
    //Próxima fecha permitida para el inicio de un nuevo periodo
    if (isset($ULTIMA_FECHA)){
      $ULTIMA_FECHA=strtotime($ULTIMA_FECHA);
      $ULTIMA_FECHA = strtotime("+1 day", $ULTIMA_FECHA);
      $ULTIMA_FECHA = date("d-m-Y", $ULTIMA_FECHA);
    } else {
      $ULTIMA_FECHA=date("d-m-Y");
    }
    
    //Cierre conexión a la BD
    cerrarConexion($conexion);
    
    if (isset($_GET['action'])){
        switch ($_GET['action']) {
        
            case 'add':
                $_SESSION['MSJ'] = "Se ha agregado un nuevo proceso de evaluación";
                header("Location: ../vEvaluaciones.php?success"); 
                break;
                
            case 'edit':
		$_SESSION['MSJ'] = "Se ha modificado el periodo de duración del proceso de evaluación";
                header("Location: ../vEvaluaciones.php?success"); 
		break;
                
            case 'delete':
		$_SESSION['MSJ'] = "Se ha eliminado el proceso de evaluación y todas las evaluaciones asociadas al mismo";
                header("Location: ../vEvaluaciones.php?success"); 
		break;
		
            default:
                # code...
                break;            
        }
    }
  
?> 


