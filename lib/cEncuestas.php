<?php
    session_start();
    require "cAutorizacion.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
    $_ERRORES = array();
    $_WARNING = array();
    $_SUCCESS = array();
    
    // Obtención de las encuestas definidas
    $sql ="SELECT * ";
    $sql.="FROM ENCUESTA WHERE actual='t' ORDER BY id_fam";        
    $atts = array("id", "id_encuesta", "id_encuesta_ls", "id_fam", "id_unidad", "estado");
    $LISTA_ENCUESTA= obtenerDatos($sql, $conexion, $atts, "Enc");
    
    
    // Obtención de las familias de cargos y las unidades
    for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){    
      $sql ="SELECT nombre FROM FAMILIA_CARGO WHERE id='".$LISTA_ENCUESTA['Enc']['id_fam'][$i]."'"; 
      $sql_1 ="SELECT nombre FROM ORGANIZACION WHERE id='".$LISTA_ENCUESTA['Enc']['id_unidad'][$i]."'"; 
      $atts = array("nombre"); 
      $aux= obtenerDatos($sql, $conexion, $atts, "Car");
      $LISTA_CARGOS[$i]=$aux['Car']['nombre'][0];
      $aux= obtenerDatos($sql_1, $conexion, $atts, "Uni");
      $LISTA_UNIDADES[$i]=$aux['Uni']['nombre'][0];
    }    
    
     if (isset($_GET['action'])){
      switch ($_GET['action']) {
      
	case 'try':
	  //Obtención de las unidades registradas
	  $UNIDAD_ID = obtenerIds($conexion, "ORGANIZACION", false);
	  //Obtención de las encuestas importadas
	  $sql ="SELECT id_fam, id_encuesta_ls FROM ENCUESTA_LS"; 
	  $atts = array("id_fam", "id_encuesta_ls", "nombre"); 
	  $ENCUESTA_ID= obtenerDatos($sql, $conexion, $atts, "Enc");
	  for($i=0; $i<$ENCUESTA_ID['max_res']; $i++){
	    $sql ="SELECT nombre FROM FAMILIA_CARGO WHERE id='".$ENCUESTA_ID['Enc']['id_fam'][$i]."'"; 
	    $atts = array("nombre"); 
	    $aux= obtenerDatos($sql, $conexion, $atts, "Car");
	    $ENCUESTA_ID['Enc']['nombre'][$i]=$aux['Car']['nombre'][0];
	  }
	break;
	
	case 'add':
	  if(in_array($_POST['encuesta'],$LISTA_ENCUESTA['Enc']['id_encuesta_ls']) && in_array($_POST['unidad'],$LISTA_ENCUESTA['Enc']['id_unidad'])){
	      $_SESSION['MSJ'] = "Ya existe una evaluación del personal seleccionado para la unidad seleccionada";
              header("Location: ../vEncuestas.php?action=try");
	  } else {
	    //Determinar cargo asociado a la encuesta
	    $sql ="SELECT id_fam FROM ENCUESTA_LS WHERE id_encuesta_ls='".$_POST['encuesta']."'"; 
	    $atts = array("id_fam"); 
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    $id_fam=$aux['Enc']['id_fam'][0];
	    //Agregar nueva encuesta
	    $sql="INSERT INTO ENCUESTA (id_encuesta_ls, id_fam, id_unidad, estado, actual) VALUES (";
	    $sql.="'$_POST[encuesta]', ";  //id de la encuesta en limesurvey           
	    $sql.="'$id_fam', "; //id de la familia de cargos
	    $sql.="'$_POST[unidad]', "; //id de la unidad
	    $sql.="'f', "; //estado de la encuesta (inactiva)
	    $sql.="'t')"; //vigencia de la encuesta (actual)   
	    $resultado_sql=ejecutarConsulta($sql, $conexion);
	    //Determinar identificador de la encuesta
	    $sql ="SELECT id FROM ENCUESTA WHERE id_encuesta_ls='".$_POST['encuesta']."'";
	    $atts = array("id");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    //Ir al segundo paso
	    header("Location: ../vEncuestas.php?action=pesos&id_encuesta=".$aux['Enc']['id'][0]);
	  }  
	break;
	
	case 'pesos':
	  //Obtener las preguntas de la sección de factores de la encuesta
	  if (isset($_GET['id_encuesta'])){
	    //Determinar identificador de la encuesta
	    $sql ="SELECT id_encuesta_ls FROM ENCUESTA WHERE id='".$_GET['id_encuesta']."'";
	    $atts = array("id_encuesta_ls");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    //Buscar las preguntas de la sección de factores
	    $sql ="SELECT id_encuesta_ls, id_pregunta_ls, id_pregunta_root_ls, titulo, seccion, id_pregunta ";
	    $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$aux['Enc']['id_encuesta_ls'][0]."' AND seccion='factor' ORDER BY id_pregunta";        
	    $atts = array("id_encuesta_ls","id_pregunta_ls", "id_pregunta_root_ls", "titulo", "seccion", "id_pregunta");
	    $LISTA_PREGUNTA= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas
	  }
	break;
	
	case 'set':
	  if (isset($_GET['id_encuesta'])){
	    //Determinar identificador de la encuesta
	    $sql ="SELECT id_encuesta_ls FROM ENCUESTA WHERE id='".$_GET['id_encuesta']."'";
	    $atts = array("id_encuesta_ls");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    //Buscar las preguntas de la sección de factores
	    $sql ="SELECT id_encuesta_ls, id_pregunta_ls, id_pregunta_root_ls, titulo, seccion, id_pregunta ";
	    $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$aux['Enc']['id_encuesta_ls'][0]."' AND seccion='factor' ORDER BY id_pregunta";        
	    $atts = array("id_encuesta_ls","id_pregunta_ls", "id_pregunta_root_ls", "titulo", "seccion", "id_pregunta");
	    $LISTA_PREGUNTA= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas
	    //Modificar los pesos de los factores
	    for ($i=0; $i<$LISTA_PREGUNTA[max_res]; $i++){
	      $id_pregunta=$LISTA_PREGUNTA['Preg']['id_pregunta'][$i];
	      $tag='peso_'.$id_pregunta;
	      if($_POST[$tag]!='-'){
		$peso=$_POST[$tag]/100;
		$sql="INSERT INTO PREGUNTA_PESO (id_pregunta, id_encuesta, peso) VALUES ('".$id_pregunta."', '".$_GET['id_encuesta']."', '".$peso."')";
		$resultado_sql=ejecutarConsulta($sql,$conexion);
	      }
	    } //cierre iteración sobre las preguntas
	  }
	break;
	
	case 'modificar':
	  //Obtener las preguntas de la sección de factores de la encuesta
	  if (isset($_GET['id_encuesta'])){
	    //Determinar identificador de la encuesta
	    $sql ="SELECT id_encuesta_ls FROM ENCUESTA WHERE id='".$_GET['id_encuesta']."'";
	    $atts = array("id_encuesta_ls");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    //Buscar las preguntas de la sección de factores
	    $sql ="SELECT id_encuesta_ls, id_pregunta_ls, id_pregunta_root_ls, titulo, seccion, id_pregunta ";
	    $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$aux['Enc']['id_encuesta_ls'][0]."' AND seccion='factor' ORDER BY id_pregunta";        
	    $atts = array("id_encuesta_ls","id_pregunta_ls", "id_pregunta_root_ls", "titulo", "seccion", "id_pregunta", "peso");
	    $LISTA_PREGUNTA= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas
	    //Determinar los pesos definidos para la evaluación
	    for($i=0; $i<$LISTA_PREGUNTA['max_res']; $i++){
	      $sql ="SELECT peso FROM PREGUNTA_PESO WHERE id_encuesta='".$_GET['id_encuesta']."' AND id_pregunta='".$LISTA_PREGUNTA['Preg']['id_pregunta'][$i]."'";
	      $atts = array("peso");
	      $aux= obtenerDatos($sql, $conexion, $atts, "Aux");
	      $LISTA_PREGUNTA['Preg']['peso'][$i]=$aux['Aux']['peso'][0];
	    }
	  }
	break;
	
	case 'edit':
	  if (isset($_GET['id_encuesta'])){
	    //Determinar identificador de la encuesta
	    $sql ="SELECT id_encuesta_ls FROM ENCUESTA WHERE id='".$_GET['id_encuesta']."'";
	    $atts = array("id_encuesta_ls");
	    $aux= obtenerDatos($sql, $conexion, $atts, "Enc");
	    //Buscar las preguntas de la sección de factores
	    $sql ="SELECT id_encuesta_ls, id_pregunta_ls, id_pregunta_root_ls, titulo, seccion, id_pregunta ";
	    $sql.="FROM PREGUNTA WHERE id_encuesta_ls='".$aux['Enc']['id_encuesta_ls'][0]."' AND seccion='factor' ORDER BY id_pregunta";        
	    $atts = array("id_encuesta_ls","id_pregunta_ls", "id_pregunta_root_ls", "titulo", "seccion", "id_pregunta");
	    $LISTA_PREGUNTA= obtenerDatos($sql, $conexion, $atts, "Preg"); //Lista de preguntas
	    //Modificar los pesos de los factores
	    for ($i=0; $i<$LISTA_PREGUNTA[max_res]; $i++){
	      $id_pregunta=$LISTA_PREGUNTA['Preg']['id_pregunta'][$i];
	      $tag='peso_'.$id_pregunta;
	      if($_POST[$tag]!='-'){
		$peso=$_POST[$tag]/100;
		$sql="UPDATE PREGUNTA_PESO SET peso='".$peso."' WHERE id_encuesta='".$_GET['id_encuesta']."' AND id_pregunta='".$id_pregunta."'";
		$resultado_sql=ejecutarConsulta($sql,$conexion);
	      }
	    } //cierre iteración sobre las preguntas
	  }
	break;
    
	case 'delete':
	  //Actualizar vigencia de la encuesta (antigua)
	  $sql="UPDATE ENCUESTA SET actual='f' WHERE id='".$_GET['id_encuesta']."'";
	  $resultado_sql=ejecutarConsulta($sql,$conexion);
	  break;
	  
	default:
	  # code...
	  break;
	    }
        
    }
    
    if (isset($_GET['action'])){
        switch ($_GET['action']) {
        
            case 'set':
                $_SESSION['MSJ'] = "La evaluación ha sido agregada";
                header("Location: ../vEncuestas.php?success"); 
                break;
                
            case 'edit':
                $_SESSION['MSJ'] = "Los pesos asociados a los factores han sido modificados";
                header("Location: ../vEncuestas.php?success"); 
                break;
                
            case 'delete':
                $_SESSION['MSJ'] = "La evaluación fue eliminada";
                header("Location: ../vEncuestas.php?success"); 
                break;
               
            default:
                # code...
                break;            
        }

    }
  
?> 


