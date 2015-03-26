<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    require_once 'XML/RPC2/Client.php';
        
    //Lista de familias de roles
    $ROL_ID = obtenerIds($conexion, "FAMILIA_ROL", false);
        
    //Obtención de la lista de encuestas registradas en Limesurvey
    $client_ls = XML_RPC2_Client::create(PATH_LS); //Crear un cliente para comunicarse con Limesurvey
    $session_key = $client_ls->get_session_key(USER_LS, PSWD_LS);//Pedir llave de acceso a Limesurvey
    $resultado = $client_ls->list_surveys($session_key);//Lista de encuestas registradas en Limesurvey
    $ENCUESTAS_LS=array();//Listado de encuestas
    for($i=0; $i<count($resultado); $i++){
      $ENCUESTAS_LS['id_encuesta_ls'][$i]=$resultado[$i]['sid'];
      $ENCUESTAS_LS['nombre'][$i]=$resultado[$i]['surveyls_title'];
    }

     //Banderas     
     $numGrupos = 0;
     $numPreguntas = array();

if (isset($_GET['action'])) {
  switch($_GET['action']){
  
    case 'import': 

	  //Verificar si la encuesta ya existe o si ya existe una encuesta para ese cargo
	  $sql ="SELECT id_encuesta_ls FROM ENCUESTA_LS WHERE id_encuesta_ls='".$_POST[encuesta]."'";        
	  $atts = array("id_encuesta_ls");
	  $ENCUESTA_IMPORTADA= obtenerDatos($sql, $conexion, $atts, "Enc");
	  $sql ="SELECT id_fam FROM ENCUESTA_LS WHERE id_fam='".$_POST[rol]."'";        
	  $atts = array("id_fam");
	  $FAMILIA_CARGO_EVALUADO= obtenerDatos($sql, $conexion, $atts, "Fam");
	  
	  
	  if ($ENCUESTA_IMPORTADA[max_res]){
	    $_SESSION['MSJ']="La encuesta indicada ya ha sido importada al sistema";
	    header("Location: ../vImportarEncuesta.php?error"); 
	  } else if ($FAMILIA_CARGO_EVALUADO[max_res]){
	    $_SESSION['MSJ']="El grupo de roles indicada ya tiene una encuesta asociada";
	    header("Location: ../vImportarEncuesta.php?error");
	  } else {
	  
	    $id_encuesta_ls=intval($_POST['encuesta']);
	    //Solicitar las secciones de preguntas de la encuesta
	    $resultado= $client_ls->list_groups($session_key, $id_encuesta_ls);
	    
	    //Agregar nueva encuesta
	    $sql="INSERT INTO ENCUESTA_LS (id_encuesta_ls, id_fam) VALUES (";
	    $sql.="'$_POST[encuesta]', ";  //id de la encuesta en limesurvey           
	    $sql.="'$_POST[rol]')"; //id de la familia de cargos  
	    $resultado_sql=ejecutarConsulta($sql, $conexion);

	    $numGrupos = count($resultado);
	
	    //Pedir preguntas de cada sección
	    for($i=0; $i<count($resultado); $i++){
	    
	      if ($i==0){
		$seccion="competencia";
	      } else {
		$seccion="factor";
	      }
	  
	      $group_id=intval($resultado[$i]['id']['gid']); //ID de la sección de preguntas
	      $preguntas= $client_ls->list_questions($session_key, $id_encuesta_ls, $group_id);
	      
	      $numPreguntas[$i] = count($preguntas);	
	      //Pedir la información de cada pregunta
	      for($j=0; $j<count($preguntas); $j++){
				
		$question_id=intval($preguntas[$j]['id']['qid']);
		$question= $preguntas[$j]['question'];
		$properties=array("subquestions");
		$subpreguntas= $client_ls->get_question_properties($session_key, $question_id, $properties);
		
		if(is_array($subpreguntas['subquestions'])){
		
		  //INSERT DE LA PREGUNTA
		  $sql="INSERT INTO PREGUNTA (id_pregunta_ls, id_encuesta_ls, titulo, seccion) VALUES (";
		  $sql.="'$question_id','$id_encuesta_ls', '$question', '$seccion')";
		  $resultado_sql=ejecutarConsulta($sql, $conexion);
		  
		  //Pedir la información de las subpreguntas de cada pregunta
		  while (current($subpreguntas['subquestions'])) {
		    $id_subquestion=key($subpreguntas['subquestions']);
		    $subquestion= $subpreguntas['subquestions'][$id_subquestion]['question'];
		    
		    //INSERT DE LA SUBPREGUNTA
		    $sql="INSERT INTO PREGUNTA (id_pregunta_ls, id_pregunta_root_ls, id_encuesta_ls, titulo, seccion) VALUES (";
		    $sql.="'$id_subquestion', '$question_id', '$id_encuesta_ls','$subquestion', '$seccion')";
		    $resultado_sql=ejecutarConsulta($sql, $conexion);
		    
		    next($subpreguntas['subquestions']);
		  } // cierre ciclo sobre subpreguntas
		} else {
		
		   // REVISAR ESTO LUEGO CON MAS CALMA
		  
		  //$sql="INSERT INTO PREGUNTA (id_pregunta_ls, id_encuesta_ls, titulo, seccion) VALUES (";
		  //$sql.="'$question_id', '$id_encuesta_ls', '$question', '$seccion')";
		  //$resultado_sql=ejecutarConsulta($sql, $conexion);
		}
		
	      } //cierre ciclo sobre preguntas
	    } //cierre ciclo sobre secciones de preguntas
	    
	  $_SESSION['MSJ']="La encuesta ha sido importada.";
	  header("Location: ../vImportarEncuesta.php?success"); 

	  } //cierre else (verificación de datos no repetidos)
	  
	  break;
                
  } //cierre switch
} //cierre if
  
  $resultado = $client_ls->release_session_key($session_key);//Devolver llave de acceso a Limesurvey
  cerrarConexion($conexion);

?>
