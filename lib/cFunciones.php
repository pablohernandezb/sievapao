<?

/*----------------------------------------------------------
------------ Funciones para la gestión de la BD ------------ 
------------------------------------------------------------*/

/*--------- MySQL ---------*/
if (MANEJADOR_BD == "mysql") {

    function crearConexion($servidor, $usuario, $contrasena) {
        $conexion = mysql_connect($servidor, $usuario, $contrasena) or die("No se pudo conectar al servidor" . mysql_error());
        return $conexion;
    }

    function cerrarConexion($conexion) {
        mysql_close($conexion);
    }

    function numResultados($resultado) {
        return mysql_num_rows($resultado);
    }

    function ejecutarConsulta($consulta, $conexion) {
        mysql_select_db(NOMBRE_BD) or die("No se pudo seleccionar la BD " . mysql_error());
        $resultado = mysql_query($consulta) or die("No se pudo ejecutar la consulta $consulta <br>" . mysql_error());
        return $resultado;
    }
   
    function obtenerResultados($resultado) {
        return mysql_fetch_array($resultado, MYSQL_ASSOC);
    }



    /*---------------------------------------------------------------
    ------ Convierte fecha del formato mysql al formato normal ------
    -----------------------------------------------------------------*/
    function cambiaf_a_normal($fecha) {
        ereg("([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
        return $lafecha;
    }

    /*-----------------------------------------------------------------
    ------- Convierte fecha del formato normal al formato mysql -------
    -------------------------------------------------------------------*/

    function cambiaf_a_mysql($fecha) {
        ereg("([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha);
        $lafecha = $mifecha[3] . "-" . $mifecha[2] . "-" . $mifecha[1];
        return $lafecha;
    }
    
/*--------- PostgreSQL ---------*/
}else if (MANEJADOR_BD == "postgres"){
    function crearConexion($servidor, $bd, $user, $contrasena) {
        $conexion = pg_connect("host=".$servidor." dbname=".$bd." user=".$user." password=".$contrasena) or die("No se pudo conectar al servidor" . pg_last_error());
        return $conexion;
    }

    function cerrarConexion($conexion) {
        pg_close($conexion);
    }

    function numResultados($resultado) {
        return pg_num_rows($resultado);
    }

    function ejecutarConsulta($consulta, $conexion) {
        $resultado = pg_query($consulta) or die("No se pudo ejecutar la consulta $consulta <br>" . pg_last_error());
        return $resultado;
    }
   
    function obtenerResultados($resultado) {
        return pg_fetch_array($resultado);
    }

    function liberarResultado($resultado){
        return pg_free_result($result);
    }
}


function escaparString($string) {
    return pg_escape_string($string);
}

/*
    obtenerDatos. funcion para la consulta de datos sobre la BD
    $conexion   - conexion a la BD
    $sql        - consulta sobre la BD
    $tabla      - nombre de la tabla a consultar
    $atts       - atributos (columnas) a obtener
*/
function obtenerDatos($sql, $conexion, $atts, $tabla){
    
    $LISTA=array();
    $resultado=ejecutarConsulta($sql, $conexion);
    $i=0;
    
    while ($fila=obtenerResultados($resultado)){
	$n = count($atts);
	$j = 0;
	while ($j < $n){
	    $LISTA[$tabla][$atts[$j]][$i]=$fila[$atts[$j]];  
	    $j++;
	}
	$i++;
    }
    
    $LISTA['max_res']=$i;
    return $LISTA;
}

/*
    obtenerIds. funcion para la obtención de los identificadores
		de los elementos de una tabla de la BD
    $conexion   - conexion a la BD
    $tabla      - nombre de la tabla a consultar
    $persona    - boolean
*/
function obtenerIds($conexion, $tabla, $persona){

    $sql ="SELECT * ";
    $sql.="FROM ".$tabla;
    $FAM_ID=array();
    $resultado=ejecutarConsulta($sql, $conexion);
    $i=0;
    
    while ($fila=obtenerResultados($resultado)){
    
      if ($persona) {
	  $FAM_ID[$fila['id']] = $fila['nombre'].' '.$fila['apellido'];
      } else
	  $FAM_ID[$fila['id']]  = $fila['nombre'];
    }
    $i++;   
    
    return $FAM_ID;
}

/*---------------------------------------------------
------------ Fin del bloque de funciones ------------ 
-----------------------------------------------------*/

/*-----------------------------------------------------------------------
------------ Funciones para la gestión de usuario registrado ------------ 
-------------------------------------------------------------------------*/

function isAdmin() {
    if ($_SESSION['USBID'] == "dgch" or $_SESSION['USBID'] == "evaluaciones")
        return true;
    else
        return false;
}

function isEmpleado() {
    if ($_SESSION[tipo] == "empleados")
        return true;
    else
        return false;
}

function isAsistente() {
    if ($_SESSION[ROL] == "asistente")
        return true;
    else
        return false;
}

function isSecretariaAtenEstudiante() {
    if ($_SESSION[ROL] == "secretaria_atencion_estudiante")
        return true;
    else
        return false;
}

function isSecretariaAtenProfesor() {
    if ($_SESSION[ROL] == "secretaria_atencion_profesor")
        return true;
    else
        return false;
}

function isEstudiante() {
    if ($_SESSION['tipo'] == "pregrado" or $_SESSION['tipo'] == "postgrado")
        return true;
    else
        return false;
}

function isProfesor() {
    if ($_SESSION['tipo'] == "profesores")
        return true;
    else
        return false;
}

function mostrarDatosUsuario(){
	if (isset($_SESSION['USBID'])){
        include_once('CAS.php');
	/*
        phpCAS::setDebug();
        // inicializa sesion phpCAS
        phpCAS::client(CAS_VERSION_2_0,'secure.dst.usb.ve',443,'');
        phpCAS::setNoCasServerValidation();
        // Forza la autenticacion CAS
        phpCAS::forceAuthentication();
	*/
        // Para cerrar la cesion
        if (isset($_REQUEST['logout'])) {
            $_SESSION=array();
	    session_unset();
	    session_destroy();

	    $parametros_cookies = session_get_cookie_params();
	    setcookie(session_name(),0,1,$parametros_cookies["path"]);
            phpCAS::logout();
        }
	?><strong style="font-size:12px"><?php echo "$_SESSION[USBID]"; if (isAdmin()) echo " |<i> Administrador</i>"; ?></strong>
	  <strong style="font-size: 12px"> <?
	  if ($_SESSION['tipo']=="pregrado" or $_SESSION['tipo']=="postgrado") echo " |<i> Estudiante</i> ";
	    if ($_SESSION['tipo']=="profesores") echo " |<i> Miembro USB - Profesor</i>";
	    if ($_SESSION['tipo']=="empleados") echo " |<i> Miembro USB - Empleado</i>";
	    if ($_SESSION['tipo']=="administrativos") echo " |<i> Miembro USB - Instituci&oacute;n</i>";
	    if ($_SESSION['tipo']=="organizaciones") echo " |<i> Organizaci&oacute;n Estudiantil</i>"; ?> 
	</strong><?
	}
}

/*---------------------------------------------------
------------ Fin del bloque de funciones ------------ 
----------------------------------------------------*/

/*---------------------------------------
------------ Otras funciones ------------ 
---------------------------------------*/

function MostrarLegenda($text){
    echo "<legend>".$text."</legend>";
}

/*
    obtenerDiferenciaDias. Determina la diferencia en días entre dos fechas
    -----------------------------------------------------------------------
    $fecha_1 - fecha inicial (dd-mm-yyyy)
    $fecha_2 - fecha final (dd-mm-yyyy)
*/
function obtenerDiferenciaDias ($fecha_1, $fecha_2){
    //Días de la primera fecha
    $aux=explode("-", $fecha_1);
    $fecha_1_dias=$aux[0]+($aux[1]*30)+($aux[2]*365);
    //Días de la segunda fecha
    $aux=explode("-", $fecha_2);
    $fecha_2_dias=$aux[0]+($aux[1]*30)+($aux[2]*365);
    return ($fecha_1_dias-$fecha_2_dias);
}

/*
    isSupervisor. Determina si el identificador suministrado pertenece o no a un
    a un usuario que es supervisor jerárquico en el sistema 
    ---------------------------------------------------------------------------
    $conexion - conexión a la base de datos
*/
function isSupervisor ($conexion){
  if(!isAdmin()){
    $sql= "SELECT id FROM PERSONA WHERE cedula='".$_SESSION['cedula']."'";
    $resultado=ejecutarConsulta($sql, $conexion);
    $resultado=obtenerResultados($resultado);
    $id_usuario=$resultado[0];
    
    $sql= "SELECT * FROM PERSONA_SUPERVISOR WHERE id_sup='".$id_usuario."'";
    $resultado=ejecutarConsulta($sql, $conexion);
    $resultado=obtenerResultados($resultado);
    if (is_array($resultado)){
      return true;
    } else {
      return false;
    }
  }
  else {
      return false;
  }
}

/*
    countNotifications. Determina el número de notificaciones al administrador
    del sistema que aún no se han revisado
    ---------------------------------------------------------------------------
    $conexion - conexión a la base de datos
*/
function countNotifications ($conexion){
    $sql= "SELECT id FROM NOTIFICACION WHERE revisado=FALSE";
    $atts= array("id");
    $resultado=obtenerDatos($sql, $conexion, $atts, 'Res');
    return $resultado['max_res'];
}

/*
    isEvaluador. Determina si el identificador suministrado pertenece o no a un
    a un usuario que es evaluador (supervisor inmediato) en el sistema
    ---------------------------------------------------------------------------
    $conexion - conexión a la base de datos

function isEvaluador ($ci_usuario, $conexion){

    $sql= "SELECT id FROM PERSONA WHERE cedula='".$_SESSION['cedula']."'";
    $atts=array('id');
    $resultado=obtenerDatos($sql, $conexion, $atts, 'Res');
    $id_usuario=$resultado['Res']['id'][0];
 
    $sql= "SELECT * FROM PERSONA_EVALUADOR WHERE id_eva='".$id_usuario."'";
    $resultado=ejecutarConsulta($sql, $conexion);
    $resultado=obtenerResultados($resultado);
    if (is_array($resultado)){
      return true;
    } else {
      return false;
    }
}
*/

/*
    determinarPeriodo. Transforma una fecha de la forma mm/yyyy a su forma textual
    ------------------------------------------------------------------------------
    $month - mes del año "mm"
    $year - año "yyyy"
*/
function determinarPeriodo ($month, $year){
  switch ($month){
    case '01':
      $periodo="Enero ".$year;
      break;
    case '02':
      $periodo="Febrero ".$year;
      break;
    case '03':
      $periodo="Marzo ".$year;
      break;
    case '04':
      $periodo="Abril ".$year;
      break;
    case '05':
      $periodo="Mayo ".$year;
      break;
    case '06':
      $periodo="Junio ".$year;
      break;
    case '07':
      $periodo="Julio ".$year;
      break;
    case '08':
      $periodo="Agosto ".$year;
      break;
    case '09':
      $periodo="Septiembre ".$year;
      break;
    case '10':
      $periodo="Octubre ".$year;
      break;
    case '11':
      $periodo="Noviembre ".$year;
      break;
    case '12':
      $periodo="Diciembre ".$year;
      break;
  }
  return $periodo;
}

/*
    calcularPuntaje. Determina el puntaje máximo y el puntaje obtenido de una evaluación
    -------------------------------------------------------------------------------------
    $id_encuesta - (integer) identificador de la encuesta correspondiente a la evaluación
    $seccion - (string) sección de la evaluación a analizar
    $token_ls - (string) token de Limesurvey de la persona encuestada
*/
function calcularPuntaje ($id_encuesta, $seccion, $token_ls){
  $resultado= array('maximo','puntaje');
  //Determinar identificador de la encuesta de Limesurvey
  $sql="SELECT id_encuesta_ls FROM ENCUESTA WHERE id='".$id_encuesta."'";
  $atts= array("id_encuesta_ls");
  $aux=obtenerDatos($sql, $conexion, $atts, "Aux");
  $id_encuesta_ls=$aux['Aux']['id_encuesta_ls'][0];
  switch($seccion){
    case 'competencia': 
      $sql="SELECT id_pregunta FROM PREGUNTA WHERE id_encuesta_ls='".$id_encuesta_ls."' AND seccion='competencia' AND id_pregunta_root_ls IS NOT NULL";
      $atts= array("id_pregunta", "respuesta");
      $LISTA_COMPETENCIAS=obtenerDatos($sql, $conexion, $atts, "Comp");     
      $resultado['maximo']=$LISTA_COMPETENCIAS['max_res']*3;//puntaje máximo en la sección de competencias
      $resultado['puntaje']=0; //inicialización
      for($j=0; $j<$LISTA_COMPETENCIAS['max_res']; $j++){
	$sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$LISTA_COMPETENCIAS['Comp']['id_pregunta'][$j]."' AND token_ls='".$token_ls."'";
	$atts= array("respuesta");
	$aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	
	$LISTA_COMPETENCIAS['Comp']['respuesta'][$j]=$aux['Aux']['respuesta'][0];
	switch($LISTA_COMPETENCIAS['Comp']['respuesta'][$j]){
	  case 'Siempre':
	    $resultado['puntaje']+=3;
	  break;
	  case 'Casi siempre':
	    $resultado['puntaje']+=2;
	  break;
	  case 'Pocas veces':
	    $resultado['puntaje']+=1;
	  break;
	} //Fin del switch
      }//Cierre del ciclo sobre las preguntas de competencias
      break; //Fin del case (competencia)
    case 'factor':
      $sql="SELECT id_pregunta FROM PREGUNTA WHERE id_encuesta_ls='".$id_encuesta_ls."' AND seccion='factor' AND id_pregunta_root_ls IS NOT NULL";
      $atts= array("id_pregunta", "respuesta", "peso");
      $LISTA_FACTORES=obtenerDatos($sql, $conexion, $atts, "Fac");
      
      $resultado['puntaje']=0; //inicialización
      $resultado['maximo']=0;
      for($j=0; $j<$LISTA_FACTORES['max_res']; $j++){
	//Determinar peso del factor
	$id_pregunta_j=$LISTA_FACTORES['Fac']['id_pregunta'][$j];
	$sql="SELECT peso FROM PREGUNTA_PESO WHERE id_pregunta='".$id_pregunta_j."' AND id_encuesta='".$id_encuesta."'";
	$atts = array("peso");
	$aux= obtenerDatos($sql, $conexion, $atts, "Aux");
	$LISTA_FACTORES['Fac']['peso'][$j]=$aux['Aux']['peso'][0];
	$resultado['maximo']+=3*$LISTA_FACTORES['Fac']['peso'][$j];
	//Determinar respuesta
	$sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$id_pregunta_j."' AND token_ls='".$token_ls."'";
	$atts= array("respuesta");
	$aux=obtenerDatos($sql, $conexion, $atts, "Aux");
	$LISTA_FACTORES['Fac']['respuesta'][$j]=$aux['Aux']['respuesta'][0];
	switch($LISTA_FACTORES['Fac']['respuesta'][$j]){
	  case 'Excelente':
	    $resultado['puntaje']+=3*$LISTA_FACTORES['Fac']['peso'][$j];
	  break;
	  case 'Sobre lo esperado':
	    $resultado['puntaje']+=2*$LISTA_FACTORES['Fac']['peso'][$j];
	  break;
	  case 'En lo esperado':
	    $resultado['puntaje']+=1*$LISTA_FACTORES['Fac']['peso'][$j];
	  break;
	} //Fin del switch
      }//Cierre del ciclo sobre las preguntas de factores
      break; //Fin del case (competencia)
  }
  return $resultado;
}

/*
    determinarDeficiencias. Determina las competencias y factores deficientes para una
    unidad determinada según sus los resultados obtenidos en el proceso de evaluación
    ----------------------------------------------------------------------------------
    $id_unidad - (integer) identificador de la unidad evaluada
    $id_proceso - (integer) identificador del proceso de evaluación correspondiente
*/
function determinarDeficiencias ($id_unidad, $id_proceso){

  $resultado= array('individual','grupal');
  
  //Obtener datos del personal evaluado
  $sql="SELECT id_evaluado FROM PERSONA_ENCUESTA WHERE id_unidad='".$id_unidad."' AND periodo='".$id_proceso."' AND tipo='autoevaluacion'";
  $atts= array("id_evaluado", "competencias", "factores");
  $LISTA_EVALUADOS=obtenerDatos($sql, $conexion, $atts, "Eva");
  
  //Obtener los resultados para cada evaluado
  for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
    
    //Obtener datos de las evaluaciones de los supervisores inmediatos del trabajador evaluado
    $sql="SELECT id_encuesta, id_encuesta_ls, id_encuestado, token_ls FROM PERSONA_ENCUESTA WHERE id_unidad='".$id_unidad."' AND periodo='".$id_proceso."'";
    $sql.=" AND tipo='evaluador' AND id_evaluado='".$LISTA_EVALUADOS['Eva']['id_evaluado'][$i]."' AND estado!='Pendiente' AND estado!='En proceso'";
    $atts= array("id_encuesta", "id_encuesta_ls", "id_encuestado", "token_ls");
    $LISTA_EVALUADORES=obtenerDatos($sql, $conexion, $atts, "Eva");
    
    if($LISTA_EVALUADORES['max_res']){
      //Lista de preguntas de la sección de competencias
      $sql="SELECT id_pregunta, titulo FROM PREGUNTA WHERE id_encuesta_ls='".$LISTA_EVALUADORES['Eva']['id_encuesta_ls'][0];
      $sql.="' AND seccion='competencia' AND id_pregunta_root_ls IS NOT NULL ORDER BY id_pregunta";
      $atts = array("id_pregunta", "titulo", "resultado_promedio", "deficiente");
      $LISTA_COMPETENCIAS= obtenerDatos($sql, $conexion, $atts, "Comp");
      
      //Lista de preguntas de la sección de factores
      $sql="SELECT id_pregunta, titulo FROM PREGUNTA WHERE id_encuesta_ls='".$LISTA_EVALUADORES['Eva']['id_encuesta_ls'][0];
      $sql.="' AND seccion='factor' AND id_pregunta_root_ls IS NOT NULL ORDER BY id_pregunta";
      $atts = array("id_pregunta", "titulo", "resultado_promedio", "deficiente");
      $LISTA_FACTORES= obtenerDatos($sql, $conexion, $atts, "Fac");
      
      for($j=0; $j<$LISTA_EVALUADORES['max_res']; $j++){
      
	//Cálculo de resultados para la sección de competencias
	for($k=0; $k<$LISTA_COMPETENCIAS['max_res']; $k++){
	  $sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$LISTA_COMPETENCIAS['Comp']['id_pregunta'][$k];
	  $sql.="' AND token_ls='".$LISTA_EVALUADORES['Eva']['token_ls'][$j]."'";
	  $atts = array("respuesta");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Res");
	  switch($aux['Res']['respuesta'][0]){
	    case 'Siempre':
	      $LISTA_COMPETENCIAS['Comp']['resultado_promedio'][$k]+=3;
	      break;
	    case 'Casi siempre':
	      $LISTA_COMPETENCIAS['Comp']['resultado_promedio'][$k]+=2;
	      break;
	    case 'Pocas veces':
	      $LISTA_COMPETENCIAS['Comp']['resultado_promedio'][$k]+=1;
	      break;
	    case 'Nunca':
	      $LISTA_COMPETENCIAS['Comp']['resultado_promedio'][$k]+=0;
	      break;
	  }//cierre del switch
	}//cierre del ciclo sobre la lista de competencias
	
	//Cálculo de resultados para la sección de factores
	for($k=0; $k<$LISTA_FACTORES['max_res']; $k++){
	  $sql="SELECT respuesta FROM RESPUESTA WHERE id_pregunta='".$LISTA_FACTORES['Fac']['id_pregunta'][$k];
	  $sql.="' AND token_ls='".$LISTA_EVALUADORES['Eva']['token_ls'][$j]."'";
	  $atts = array("respuesta");
	  $aux= obtenerDatos($sql, $conexion, $atts, "Res");
	  switch($aux['Res']['respuesta'][0]){
	    case 'Excelente':
	      $LISTA_FACTORES['Fac']['resultado_promedio'][$k]+=3;
	      break;
	    case 'Sobre lo esperado':
	      $LISTA_FACTORES['Fac']['resultado_promedio'][$k]+=2;
	      break;
	    case 'En lo esperado':
	      $LISTA_FACTORES['Fac']['resultado_promedio'][$k]+=1;
	      break;
	    case 'Por debajo de lo esperado':
	      $LISTA_FACTORES['Fac']['resultado_promedio'][$k]+=0;
	      break;
	  }//cierre del switch
	}//cierre del ciclo sobre la lista de factores
      }//Fin del ciclo sobre supervisores inmediatos
      
      //Determinar competencias deficientes
      for($j=0; $j<$LISTA_COMPETENCIAS['max_res']; $j++){
	$puntaje=$LISTA_COMPETENCIAS['Comp']['resultado_promedio'][$j]/$LISTA_EVALUADORES['max_res'];
	//La competencia es considerada deficiente cuando el resultado oscila entre 'Pocas veces' (1) y 'Nunca'(0)
	if($puntaje<=1){
	  $LISTA_COMPETENCIAS['Comp']['deficiente'][$j]=TRUE;
	} else {
	  $LISTA_COMPETENCIAS['Comp']['deficiente'][$j]=FALSE;
	}
      }//cierre del ciclo sobre la lista de competencias
      
      //Determinar factores deficientes
      for($j=0; $j<$LISTA_FACTORES['max_res']; $j++){
	$puntaje=$LISTA_FACTORES['Fac']['resultado_promedio'][$j]/$LISTA_EVALUADORES['max_res'];
	$LISTA_FACTORES['Fac']['resultado_promedio'][$j]=$puntaje;
	//El factor es considerado deficiente cuando el resultado oscila entre 'En lo esperado' (1) y 'Por debajo de lo esperado'(0)
	if($puntaje<=1){
	  $LISTA_FACTORES['Fac']['deficiente'][$j]=TRUE;
	} else {
	  $LISTA_FACTORES['Fac']['deficiente'][$j]=FALSE;
	}
      }//cierre del ciclo sobre la lista de competencias
      $LISTA_EVALUADOS['Eva']['competencias'][$i]=$LISTA_COMPETENCIAS['Comp'];
      $LISTA_EVALUADOS['Eva']['factores'][$i]=$LISTA_FACTORES['Fac'];
    
    } else {
      //No hay resultados
    }
  }//Fin del ciclo sobre los evaluados 
  
  $numero_competencias=32;//Número máximo de competencias
  $numero_factores=12;//Número máximo de factores
  //Determinar el número de deficiencias
  for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
    if($LISTA_EVALUADOS['Eva']['competencias'][$i]){
      $EVALUADO_DEFICIENCIAS['competencias'][$i]['puntaje']=array();
      $EVALUADO_DEFICIENCIAS['competencias'][$i]['competencia']=array();
      $EVALUADO_DEFICIENCIAS['factores'][$i]['puntaje']=array();
      $EVALUADO_DEFICIENCIAS['factores'][$i]['factor']=array();
      
	for($j=0; $j<$numero_competencias; $j++){
	  //Inicializar
	  if(!($UNIDAD_DEFICIENCIAS['competencias'][$j]['count'])){
	    $UNIDAD_DEFICIENCIAS['competencias'][$j]['count']=0;
	    $UNIDAD_DEFICIENCIAS['competencias'][$j]['competencia']=$LISTA_EVALUADOS['Eva']['competencias'][$i]['titulo'][$j];
	  }
	  if($LISTA_EVALUADOS['Eva']['competencias'][$i]['deficiente'][$j]){
	    array_push($EVALUADO_DEFICIENCIAS['competencias'][$i]['puntaje'], $LISTA_EVALUADOS['Eva']['competencias'][$i]['resultado_promedio'][$j]);
	    array_push($EVALUADO_DEFICIENCIAS['competencias'][$i]['competencia'], $LISTA_EVALUADOS['Eva']['competencias'][$i]['titulo'][$j]);
	    $UNIDAD_DEFICIENCIAS['competencias'][$j]['count']++;
	  }
	}//Fin de ciclo sobre competencias
	
	for($j=0; $j<$numero_factores; $j++){
	  //Inicializar
	  if(!($UNIDAD_DEFICIENCIAS['factores'][$j]['count'])){
	    $UNIDAD_DEFICIENCIAS['factores'][$j]['count']=0;
	    $UNIDAD_DEFICIENCIAS['factores'][$j]['factor']=$LISTA_EVALUADOS['Eva']['factores'][$i]['titulo'][$j];
	  }
	  if($LISTA_EVALUADOS['Eva']['factores'][$i]['deficiente'][$j]){
	    array_push($EVALUADO_DEFICIENCIAS['factores'][$i]['puntaje'], $LISTA_EVALUADOS['Eva']['factores'][$i]['resultado_promedio'][$j]);
	    array_push($EVALUADO_DEFICIENCIAS['factores'][$i]['factor'], $LISTA_EVALUADOS['Eva']['factores'][$i]['titulo'][$j]);
	    $UNIDAD_DEFICIENCIAS['factores'][$j]['count']++;
	  }
	}//Fin de ciclo sobre competencias
	
	//Organizar por puntaje
	asort($EVALUADO_DEFICIENCIAS['competencias'][$i]['puntaje']);    
	asort($EVALUADO_DEFICIENCIAS['factores'][$i]['puntaje']);
    }
  }//Fin del ciclo sobre los evaluados
  
  //Organizar por número de deficiencias
  sort($UNIDAD_DEFICIENCIAS['competencias']);
  sort($UNIDAD_DEFICIENCIAS['factores']);
  
  $UNIDAD_DEFICIENCIAS['competencias']=array_slice($UNIDAD_DEFICIENCIAS['competencias'], -5);//Tomar los 5 más deficientes
  $UNIDAD_DEFICIENCIAS['factores']=array_slice($UNIDAD_DEFICIENCIAS['factores'], -5);//Tomar los 5 más deficientes
  
  $resultado['individual']=$EVALUADO_DEFICIENCIAS;
  $resultado['grupal']=$UNIDAD_DEFICIENCIAS;
  
  return $resultado;
}

/*
    historicoDeficiencias. Determina las competencias y factores deficientes para una
    unidad determinada según su histórico de  los resultados
    ----------------------------------------------------------------------------------
    $id_unidad - (integer) identificador de la unidad evaluada
*/
function historicoDeficiencias ($id_unidad){

  $resultado= array('individual','grupal');
    
  //Obtener datos de las procesos en los que ha sido evaluada la unidad seleccionada
  $sql="SELECT DISTINCT periodo FROM PERSONA_ENCUESTA WHERE id_unidad='".$_GET['id']."'";
  $atts= array("periodo", "deficiencias");
  $LISTA_PROCESOS=obtenerDatos($sql, $conexion, $atts, "Proc");
    
  //Iteración sobre la lista de procesos de evaluación
  for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
    $aux=determinarDeficiencias($id_unidad, $LISTA_PROCESOS['Proc']['periodo'][$i]);
    $LISTA_PROCESOS['Proc']['deficiencias'][$i]=$aux['grupal']; 
  }
  return $LISTA_PROCESOS['Proc']['deficiencias'];
}

/*
function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

set_error_handler('handleError');
*/

?> 

