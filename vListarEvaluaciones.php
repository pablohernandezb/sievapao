<?php
    session_start();
    $Legend = "Evaluaciones";
    include "lib/cListarEvaluaciones.php";
    include "vHeaderEvaluaciones.php";
    extract($_GET);
    $all = true;
?>   

  <style type="text/css">
     @import "css/bootstrap.css";
     @import "css/dataTables.bootstrap.css";
   </style>

  <script type="text/javascript" charset="utf-8" src="js/DataTable/js/jquery.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/DataTable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/DataTools/js/ZeroClipboard.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/DataTools/js/TableTools.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>
      <script type="text/javascript" charset="utf-8">
      $(document).ready( function () {
        $('.lista').dataTable( {
          "sDom": "<'row-fluid'<'span6'><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
          } );
          
         
      } );
    </script>

  <!-- Codigo importante -->
  <?php
    if ($LISTA_EVALUACION_ACTUAL['max_res']==0){
      echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay evaluaciones para el usuario.</p><br><br><br><br><br><br>";
    }else{
  ?>
      <br><p class="lead"><small>Lista de evaluaciones</small></p>
      <p class="lsmall muted"> Evaluaciones correspondientes al proceso de evaluación actual</p>
      <div id="demo">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered lista" id="table_1" width="100%">
	<thead>
	  <tr>
	    <th class="lsmallT"><small>Periodo del proceso de evaluación</small></th>
	    <th class="lsmallT"><small>Tipo de evaluación</small></th>
	    <th class="lsmallT"><small>Persona a evaluar</small></th>
	    <th class="lsmallT"><small>Estado</small></th>
	    <th class="lsmallT"><small>Acción</small></th>
	  </tr>
      </thead>
      <tfoot>
	<tr>
	  <th class="lsmallT"><small>Periodo del proceso de evaluación</small></th>
	  <th class="lsmallT"><small>Tipo de evaluación</small></th>
	  <th class="lsmallT"><small>Persona a evaluar</small></th>
	  <th class="lsmallT"><small>Estado</small></th>
	  <th class="lsmallT"><small>Acción</small></th>
	</tr>
      </tfoot>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
	<!-- Encuestas del usuario -->
        <?php
	  if ($LISTA_EVALUACION_ACTUAL['max_res']>0){
          for ($i=0;$i<$LISTA_EVALUACION_ACTUAL['max_res'];$i++){
        ?>
	    <tr class="<?php echo $color_tabla; ?>" >
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_EVALUACION_ACTUAL['Enc']['nombre_periodo'][$i];echo " ";
	      ?></small></td>
	      <td class="center lsmallT" nowrap><small><? 
		if ($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="autoevaluacion") echo 'Encuesta de autoevaluación';
		if ($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="evaluador") echo 'Encuesta como evaluador';
	      ?></small></td>     
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_EVALUACION_ACTUAL['Enc']['nombre'][$i];echo " ";echo $LISTA_EVALUACION_ACTUAL['Enc']['apellido'][$i];
	      ?></small></td>
	      <? switch ($LISTA_EVALUACION_ACTUAL['Enc']['estado'][$i]){ 
            case 'Pendiente': 
               $color='#ffe1d9'; 
               break; 
            case 'En proceso':
               $color='rgb(252,248,227)';
               break; 
            case 'Finalizada': 
               $color='rgb(223,240,216)'; 
               break;
            case 'Aprobada':
               $color='rgb(204,229,255)';
               break;
            case 'Rechazada':
               $color='rgb(255,229,209)';
               break;
         }?>
	      <td class="center lsmallT" style="background-color: <?echo $color;?>;" nowrap><small><?
		echo $LISTA_EVALUACION_ACTUAL['Enc']['estado'][$i];
	      ?></small></td>
	      <td class="center lsmallT" nowrap>
		<? switch ($LISTA_EVALUACION_ACTUAL['Enc']['estado'][$i]){
		case 'Pendiente':
		  echo "<a href='http://localhost/limesurvey/index.php?token=".$LISTA_EVALUACION_ACTUAL['Enc']['token_ls'][$i]."&sid=".$LISTA_EVALUACION_ACTUAL['Enc']['id_encuesta_ls'][$i]."&lang=es' title='Realizar evaluación'><img src='./img/iconos/edit-16.png' style='margin-left:5px;'></a>";
		  if($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="evaluacion"){
		    echo "<a href='./lib/cDescargarEncuesta.php?id_encuesta_ls=".$LISTA_EVALUACION_ACTUAL['Enc']['id_encuesta_ls'][$i]."&id_fam=".$LISTA_EVALUACION_ACTUAL['Enc']['id_fam'][$i]."' title='Descargar encuesta en PDF'><img src='./img/iconos/pdf-16.png' style='margin-left:5px;'></a>"; 
		  }
		  break;
		case 'En proceso': 
		  echo "<a href='http://localhost/limesurvey/index.php?token=".$LISTA_EVALUACION_ACTUAL['Enc']['token_ls'][$i]."&sid=".$LISTA_EVALUACION_ACTUAL['Enc']['id_encuesta_ls'][$i]."&lang=es' title='Continuar evaluación'><img src='./img/iconos/edit-16.png' style='margin-left:5px;'></a>";
		  if($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="evaluacion"){
		    echo "<a href='./lib/cDescargarEncuesta.php?id_encuesta_ls=".$LISTA_EVALUACION_ACTUAL['Enc']['id_encuesta_ls'][$i]."&id_fam=".$LISTA_EVALUACION_ACTUAL['Enc']['id_fam'][$i]."' title='Descargar encuesta en PDF'><img src='./img/iconos/pdf-16.png' style='margin-left:5px;'></a>"; 
		  }
		  break;  
		case 'Finalizada':
		  if($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="autoevaluacion"){
		    echo "<small>No hay acciones disponibles</small>";
		  }else{
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_ACTUAL['Enc']['token_ls'][$i]."' title='Ver resultados'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
		  }
		  break;
		case 'Aprobada': 
		  if($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="autoevaluacion"){
		    echo "<small>No hay acciones disponibles</small>";
		  }else{
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_ACTUAL['Enc']['token_ls'][$i]."' title='Ver resultados'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
		  }
		  break;
		case 'Rechazada':
		  if($LISTA_EVALUACION_ACTUAL['Enc']['tipo'][$i]=="autoevaluacion"){
		    echo "<small>No hay acciones disponibles</small>";
		  }else{
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_ACTUAL['Enc']['token_ls'][$i]."' title='Ver resultados'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
		  }
		  break;
		}?>
	      </td>
	      
          </tr>
        <? } //cierre del for
	   } //cierre del if
	?>
      </tbody>
      </table>
      </div>
         

  <?php
    }//cierra el else
    //Listado de evaluaciones antiguas
    if (!($LISTA_EVALUACION_PASADA['max_res']==0)){
  ?>
      <br><p class="lead"><small>Lista de evaluaciones pasadas</small></p>
      <p class="lsmall muted"> Puede consultar el estado y los resultados de evaluaciones pasadas</p>
      <div id="demo">
      <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered lista" id="table_2" width="100%">
	<thead>
	  <tr>
	    <th class="lsmallT"><small>Periodo del proceso de evaluación</small></th>
	    <th class="lsmallT"><small>Tipo de evaluación</small></th>
	    <th class="lsmallT"><small>Persona a evaluar</small></th>
	    <th class="lsmallT"><small>Estado</small></th>
	    <th class="lsmallT"><small>Acción</small></th>
	  </tr>
      </thead>
      <tfoot>
	<tr>
	  <th class="lsmallT"><small>Periodo del proceso de evaluación</small></th>
	  <th class="lsmallT"><small>Tipo de evaluación</small></th>
	  <th class="lsmallT"><small>Persona a evaluar</small></th>
	  <th class="lsmallT"><small>Estado</small></th>
	  <th class="lsmallT"><small>Acción</small></th>
	</tr>
      </tfoot>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
	<!-- Encuestas del usuario -->
        <?php
	  if ($LISTA_EVALUACION_PASADA['max_res']>0){
          for ($i=0;$i<$LISTA_EVALUACION_PASADA['max_res'];$i++){
        ?>
	    <tr class="<?php echo $color_tabla; ?>" >
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_EVALUACION_PASADA['Enc']['nombre_periodo'][$i];echo " ";
	      ?></small></td>
	      <td class="center lsmallT" nowrap><small><? 
		if ($LISTA_EVALUACION_PASADA['Enc']['tipo'][$i]=="autoevaluacion") echo 'Encuesta de autoevaluación';
		if ($LISTA_EVALUACION_PASADA['Enc']['tipo'][$i]=="evaluador") echo 'Encuesta como evaluador';
	      ?></small></td>     
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_EVALUACION_PASADA['Enc']['nombre'][$i];echo " ";echo $LISTA_EVALUACION_PASADA['Enc']['apellido'][$i];
	      ?></small></td>
	      <? switch ($LISTA_EVALUACION_PASADA['Enc']['estado'][$i]){
            case 'Pendiente':
               $color='#ffe1d9'; 
               $mensaje='No la realizó'; 
               break;
            case 'En proceso':
               $color='#ffffcc'; 
               $mensaje='No la terminó'; 
               break;
            case 'Finalizada': 
               $color='rgb(223,240,216)'; 
               $mensaje='Se realizó'; 
               break;
            case 'Aprobada':
               $color='rgb(204,229,255)';
               $mensaje='Se aprobó';
               break;
            case 'Rechazada':
               $color='rgb(255,229,209)';
               $mensaje='Se rechazó';
               break;
         }?>
	      <td class="center lsmallT" style="background-color: <?echo $color;?>;" nowrap><small><?
		echo $mensaje;
	      ?></small></td>
	      <td class="center lsmallT" nowrap><small>
		<? switch ($LISTA_EVALUACION_PASADA['Enc']['estado'][$i]){
		case 'Finalizada':
		  if ($LISTA_EVALUACION_PASADA['Enc']['tipo'][$i]=="autoevaluacion" && $LISTA_EVALUACION_PASADA['Enc']['periodo_quejas'][$i]==TRUE){
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."&action=revisarE' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  } else {
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  }
		  break;
		case 'Aprobada': 
		  if ($LISTA_EVALUACION_PASADA['Enc']['tipo'][$i]=="autoevaluacion" && $LISTA_EVALUACION_PASADA['Enc']['periodo_quejas'][$i]==TRUE){
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."&action=revisarE' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  } else {
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  }
		  break; 
		case 'Rechazada': 
		  if ($LISTA_EVALUACION_PASADA['Enc']['tipo'][$i]=="autoevaluacion" && $LISTA_EVALUACION_PASADA['Enc']['periodo_quejas'][$i]==TRUE){
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."&action=revisarE' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  } else {
		    echo "<a href='./vResultados.php?token_ls=".$LISTA_EVALUACION_PASADA['Enc']['token_ls'][$i]."' title='Ver resultados' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>"; 
		  }
		  break; 
		default: 
		  echo "No hay acciones disponibles"; 
		  break;
		}?>
	      </small></td>
	    </tr>
        <? } //cierre del for
	   } //cierre del if
	?>
      </tbody>
      </table>
      </div>
  <?
  }// cierra el if
  include "vFooter.php";
  ?>
