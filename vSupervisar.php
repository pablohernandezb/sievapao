<?php
    session_start();
    $Legend = "Evaluaciones a supervisar";
    include "lib/cSupervisar.php";
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
    if ($LISTA_SUPERVISION_ACTUAL['max_res']==0){
      echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay evaluaciones por supervisar para el usuario.</p><br><br><br><br><br><br>";
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
	    <th class="lsmallT"><small>Persona evaluada</small></th>
	    <th class="lsmallT"><small>Evaluador</small></th>
	    <th class="lsmallT"><small>Estado</small></th>
	    <th class="lsmallT"><small>Acción</small></th>
	  </tr>
      </thead>
      <tfoot>
	<tr>
	  <th class="lsmallT"><small>Periodo del proceso de evaluación</small></th>
	    <th class="lsmallT"><small>Tipo de evaluación</small></th>
	    <th class="lsmallT"><small>Persona evaluada</small></th>
	    <th class="lsmallT"><small>Evaluador</small></th>
	    <th class="lsmallT"><small>Estado</small></th>
	    <th class="lsmallT"><small>Acción</small></th>
	</tr>
      </tfoot>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
	<!-- Encuestas del usuario -->
        <?php
	  if ($LISTA_SUPERVISION_ACTUAL['max_res']>0){
          for ($i=0;$i<$LISTA_SUPERVISION_ACTUAL['max_res'];$i++){
        ?>
	    <tr class="<?php echo $color_tabla; ?>" >
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_SUPERVISION_ACTUAL['Sup']['nombre_periodo'][$i];echo " ";
	      ?></small></td>
	      <td class="center lsmallT" nowrap><small><? 
		if ($LISTA_SUPERVISION_ACTUAL['Sup']['tipo'][$i]=="autoevaluacion") echo 'Encuesta de autoevaluación';
		if ($LISTA_SUPERVISION_ACTUAL['Sup']['tipo'][$i]=="evaluador") echo 'Encuesta de evaluación';
	      ?></small></td>     
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_NOMBRE_EVALUADO[$i];
	      ?></small></td>
	      <td class="center lsmallT" nowrap><small><? 
		echo $LISTA_NOMBRE_ENCUESTADO[$i];
	      ?></small></td>
	      <? switch ($LISTA_SUPERVISION_ACTUAL['Sup']['estado'][$i]){ 
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
		echo $LISTA_SUPERVISION_ACTUAL['Sup']['estado'][$i];
	      ?></small></td>
	      <td class="center lsmallT" nowrap>
		<? switch ($LISTA_SUPERVISION_ACTUAL['Sup']['estado'][$i]){
		case 'Pendiente': 
		  echo "<small>No hay acciones disponibles</small>"; 
		  break;
		case 'En proceso': 
		  echo "<small>No hay acciones disponibles</small>"; 
		  break;  
		case 'Finalizada': 
		  echo "<a href='./vResultados.php?token_ls=".$LISTA_SUPERVISION_ACTUAL['Sup']['token_ls'][$i]."&action=supervisar' title='Supervisar evaluación'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
		  break;
		case 'Aprobada': 
        echo "<a href='./vResultados.php?token_ls=".$LISTA_SUPERVISION_ACTUAL['Sup']['token_ls'][$i]."&action=revisarA' title='Visualizar evaluación'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
        break;
      case 'Rechazada': 
        echo "<a href='./vResultados.php?token_ls=".$LISTA_SUPERVISION_ACTUAL['Sup']['token_ls'][$i]."&action=revisarR' title='Visualizar evaluación'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a>"; 
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
  include "vFooter.php";
  ?>
