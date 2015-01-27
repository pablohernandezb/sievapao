<?php
  require "cAutorizacion.php";
  extract($_GET);
  extract($_POST);
  $_ERRORES = array();
  $_WARNING = array();
  $_SUCCESS = array();
  date_default_timezone_set('America/Caracas');

  require_once 'XML/RPC2/Client.php';
      
  /*---------------------------------------------------------
  ---- Importación de resultados de Limesurvey (cronjob) ----
  -----------------------------------------------------------*/
  if (isset($_GET['token_ls']) && isset($_GET['id_encuesta_ls'])) {
  
	$client_ls = XML_RPC2_Client::create(PATH_LS); //Crear un cliente para comunicarse con Limesurvey
	$session_key = $client_ls->get_session_key(USER_LS, PSWD_LS);//Pedir llave de acceso a Limesurvey
	
	$id_encuesta_ls=intval($_GET['id_encuesta_ls']);
	$token_ls=$_GET['token_ls'];
	
	//Hallar token ID
	$sql ="SELECT tid_ls FROM PERSONA_ENCUESTA WHERE token_ls='".$token_ls."'";
	$atts = array("tid_ls");
	$resultado= obtenerDatos($sql, $conexion, $atts, "Tok");
	$tid_ls=intval($resultado['Tok']['tid_ls'][0]);
	  
	//Obtención del ID de la encuesta en el sistema
	$sql="SELECT id_encuesta FROM PERSONA_ENCUESTA WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."'";
	$atts= array("id_encuesta");
	$aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	$id_encuesta=$aux['Aux']['id_encuesta'][0];
	  
	//Obtención de los resultados
	////////////////////////////
	
	$sql ="SELECT id_pregunta_ls, id_pregunta_root_ls, id_pregunta FROM PREGUNTA WHERE id_encuesta_ls='".$_GET['id_encuesta_ls']."' ORDER BY id_pregunta";        
	$atts = array("id_pregunta_ls", "id_pregunta_root_ls","id_pregunta");
	$LISTA_PREGUNTA= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas
	$n=0; //indice del numero de preguntas con resultados
	
	//Obtener la lista de preguntas con resultados/respuestas
	for ($i=0; $i<$LISTA_PREGUNTA[max_res]; $i++){
	
	  //Si no es una subpregunta
	  if ($LISTA_PREGUNTA['Preg']['id_pregunta_root_ls'][$i]==NULL){
	    $aux=intval($LISTA_PREGUNTA['Preg']['id_pregunta_ls'][$i]);
	    
	    //Pedir tipos de respuesta a Limesurvey para la pregunta
	    $properties=array("answeroptions");
	    $id_pregunta_ls=intval($LISTA_PREGUNTA['Preg']['id_pregunta_ls'][$i]);
	    $tipo_respuesta= $client_ls->get_question_properties($session_key, $aux, $properties);
	    
	    //Verificar si tiene o no subpreguntas
	    if (!(in_array($aux,$LISTA_PREGUNTA['Preg']['id_pregunta_root_ls']))) {
	      //La pregunta no tiene subpreguntas, necesitamos su resultado
	      $PREGUNTA_CON_RESPUESTA['id_pregunta_ls'][$n]=$LISTA_PREGUNTA['Preg']['id_pregunta_ls'][$i];
	      $PREGUNTA_CON_RESPUESTA['id_pregunta'][$n]=$LISTA_PREGUNTA['Preg']['id_pregunta'][$i];
	      $PREGUNTA_CON_RESPUESTA['tipo_respuesta'][$n]=NULL;//Este es el caso en que la respuesta es del tipo "campo de texto"; la respuesta se obtiene directamente
	      $n++;
	    }
	  } else { //Es una subpregunta, necesitamos su resultado
	    $PREGUNTA_CON_RESPUESTA['id_pregunta_ls'][$n]=$LISTA_PREGUNTA['Preg']['id_pregunta_ls'][$i];
	    $PREGUNTA_CON_RESPUESTA['id_pregunta'][$n]=$LISTA_PREGUNTA['Preg']['id_pregunta'][$i];
	    $PREGUNTA_CON_RESPUESTA['tipo_respuesta'][$n]=$tipo_respuesta;//Tipos de respuesta de la pregunta padre
	    $n++;
	  }
	} //cierra el for
	  
	//Pedir resultados a Limesurvey	    
	$resultado= $client_ls->export_responses_by_token($session_key, $id_encuesta_ls, 'csv',$token_ls);//Obtener respuestas para la encuesta
	$resultado=base64_decode($resultado); //decode   
	$aux= explode("\",",$resultado); //colocar en arreglo
	$RESPUESTAS = array_slice($aux, -$n); //tomar las respuestas (al final del arreglo)
	
	for ($i=0; $i<count($RESPUESTAS); $i++){
	
	  $id_pregunta_i=$PREGUNTA_CON_RESPUESTA['id_pregunta'][$i];
	  $tipo_respuesta_i= trim($RESPUESTAS[$i], '"');     
	  if(isset($PREGUNTA_CON_RESPUESTA['tipo_respuesta'][$i]['answeroptions'])){
	    $respuesta_i=$PREGUNTA_CON_RESPUESTA['tipo_respuesta'][$i]['answeroptions'][$tipo_respuesta_i]['answer'];
	  } else {
	    $respuesta_i=$tipo_respuesta_i;//Caso en que la respuesta es del tipo "campo de texto"
	  }

	  //Guardar las respuestas
	  $sql="INSERT INTO RESPUESTA (token_ls, id_pregunta, respuesta) VALUES (";
	  $sql.="'$token_ls', '$id_pregunta_i', '$respuesta_i')";
	  $resultado_sql=ejecutarConsulta($sql, $conexion);
	}
		
      $resultado=$client_ls->release_session_key($session_key);//Devolver llave de acceso a Limesurvey
      
      //Eliminar cronjob ejecutado
      $remove= 'cImportarResultados.php?token_ls='.$_GET['token_ls'].'&id_encuesta_ls='.$_GET['id_encuesta_ls'];
      $lines = file('../tmp/vernier_jobs.txt');
      foreach($lines as $key => $line)
	if(stristr($line,$remove)) unset($lines[$key]);
	  $data = array_values($lines);
      $aux=file_put_contents('../tmp/vernier_jobs.txt', $data);
      $output=shell_exec('crontab ../tmp/vernier_jobs.txt');
      
  }
  cerrarConexion($conexion);
    
?>
