<?php
    session_start();
    $Legend = "Búsqueda avanzada de resultados";
    include "lib/cBusquedaResultados.php";
    include "vHeader.php";
    extract($_GET);
    extract($_POST);
    $all = true;
    date_default_timezone_set('America/Caracas');
?>
<style type="text/css">
  @import "css/bootstrap.css";
  @import "css/dataTables.bootstrap.css";
</style>

<script type="text/javascript" charset="utf-8" src="js/DataTable/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>


<link href="js/jQuery-Visualize/css/basic.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="js/jQuery-Visualize/js/enhance.js"></script>		
<script type="text/javascript">
  // Run capabilities test
  enhance({
  loadScripts: [
    'js/jQuery-Visualize/js/excanvas.js',
    'https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js',
    'js/jQuery-Visualize/js/visualize.jQuery.js',
    'js/jQuery-Visualize/js/example.js'
  ],
  loadStyles: [
    'js/jQuery-Visualize/css/visualize.css',
    'js/jQuery-Visualize/css/visualize-light.css'
  ]
  });   
</script> 

<script type="text/javascript">
  function showDiv(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'block')
      e.style.display = 'none';
    else
      e.style.display = 'block';
  }
</script>
    
  

<!-- Contenedor formulario principal-->
<div class="well" align="center" style="background-color: #fff">

  <!--INICIO: Resultados por persona o por unidad-->
  <br><p class="lsmall"> Para realizar una búsqueda <i>haga click</i> en el tipo de resultados de su interés y siga las instrucciones.</p><br>
  <div class="btn-group">
	<button type="button" class="btn btn-default <?if (isset($_GET['action']) && $_GET['action']=='stats_persona') echo 'active';?>" id="persona" onclick="showDiv('statsPersona')">Persona</button>
	<button type="button" class="btn btn-default <?if (isset($_GET['action']) && $_GET['action']=='stats_unidad') echo 'active';?>" id="unidad" onclick="showDiv('statsUnidad')">Unidad</button>
  </div>
  
  <!--BÚSQUEDA DE RESULTADOS POR PERSONA-->
  
  <!--PASO 1/3: Seleccionar el nombre de la persona-->
  <form id="statsPersona" class="form-horizontal" method="post" style="display: none" action="lib/cBusquedaResultados.php?action=stats_persona&input=1" >
    <br><br>
    <div class="control-group well" style="width:300px">
      <span class="label label-primary">Paso 1/3</span><br><br>
      <p class="lsmall"> Seleccione el nombre de la persona</p>
      <select style="width:200px" id="per" name="per" class="select2  per-sel" data-size="auto">
	  <? while (list($key, $val) = each($PERSONA_ID)){
	      echo "<option value=".$key.">".$val."</option>";
	  }?>
      </select><br><br>
      <button type="submit" id="confirmButton" class="btn btn-default" ><span class="icon-ok"></span></button>
    </div>
  </form>

  <!--PASO 1: OK-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_persona' && isset($_GET['step'])){
      echo '<br><br><div class="well well-small" style="width:250px">
	    <span class="label label-success">Paso 1/3</span><br><br>
	    <p class="lsmall">'.$NOMBRE.'&nbsp;&nbsp;<span class="icon-ok"></span></p></div>';
      }
  ?>
  
  <!--PASO 2/3: Seleccionar el cargo de la persona-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_persona' && isset($_GET['step']) && $_GET['step']==1) {?>
      <form class="form-horizontal" method="post" action="lib/cBusquedaResultados.php?action=stats_persona&input=2&id=<?echo $_GET['id'];?>">
	<div class="control-group well" style="width:300px">
	  <span class="label label-primary">Paso 2/3</span><br><br>
	  <p class="lsmall"> Seleccione el cargo evaluado</p>
	  <select style="width:200px" id="car" name="car" class="select2  car-sel" data-size="auto">';
	    <?for ($i=0; $i<$LISTA_CARGO['max_res']; $i++){
	      echo "<option value=".$LISTA_CARGO['Car']['id_car'][$i].">".$LISTA_CARGO['Car']['nombre'][$i]."</option>";
	    }?>
	  </select><br><br>
	  <button type="submit" id="confirmButton" class="btn btn-default" ><span class="icon-ok"></span></button>
	</div>
      </form>
  <? } ?>
  
  <!--PASO 2: OK-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_persona' && isset($_GET['step']) && $_GET['step']==2){
      echo '<div class="well well-small" style="width:250px">
	    <span class="label label-success">Paso 2/3</span><br><br>
	    <p class="lsmall">'.$CARGO.'&nbsp;&nbsp;<span class="icon-ok"></span></p></div>';
      }
  ?>
  
  <!--PASO 3/3: Seleccionar el proceso de evaluación-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_persona' && isset($_GET['step']) && $_GET['step']==2) { ?>
      <form class="form-horizontal" method="post" action="lib/cBusquedaResultados.php?action=stats_persona&input=3&id=<?echo $_GET['id'];?>&car=<?echo $_GET['car'];?>">
	<div class="control-group well" style="width:350px">
	  <span class="label label-primary">Paso 3/3</span><br><br>
	  <p class="lsmall"> Seleccione el proceso de evaluación para el que desea visualizar los resultados</p>
	  <select style="width:200px" id="proc" name="proc" class="select2  proc-sel" data-size="auto">';
	    <?for ($i=0; $i<count($LISTA_ENCUESTA['Enc']['periodo']); $i++){
	      echo "<option value=".$LISTA_ENCUESTA['Enc']['periodo'][$i].">".$LISTA_ENCUESTA['Enc']['nombre'][$i]."</option>";
	    }?>
	  </select><br><br>
	  <p class="lsmall muted"><i>Atención: al seleccionar la opción 'Histórico' se mostrará una síntesis de los resultados de la persona en los procesos de evaluación en los que ha participado</i></p>
	  <button type="submit" id="confirmButton" class="btn btn-default" >Ver resultados&nbsp;&nbsp;<span class="icon-signal"></span></button>
	</div>
      </form>
  <? } ?>
  
  <!--FIN DE BÚSQUEDA DE RESULTADOS POR PERSONA-->
  
  <!--BÚSQUEDA DE RESULTADOS POR UNIDAD-->
  
  <!--PASO 1/2: Seleccionar el nombre de la unidad-->
  <form id="statsUnidad" class="form-horizontal" method="post" style="display: none" action="lib/cBusquedaResultados.php?action=stats_unidad&input=1">
    <br><br>
    <div class="control-group well" style="width:300px">
      <span class="label label-primary">Paso 1/2</span><br><br>
      <p class="lsmall"> Seleccione el nombre de la unidad</p>
      <select style="width:200px" id="uni" name="uni" class="select2  uni-sel" data-size="auto">
	  <? while (list($key, $val) = each($UNIDAD_ID)){
	      echo "<option value=".$key.">".$val."</option>";
	  }?>
      </select><br><br>
      <button type="submit" id="confirmButton" class="btn btn-default" ><span class="icon-ok"></span></button>  
    </div>
  </form>
  
  <!--PASO 1: OK-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_unidad' && isset($_GET['step'])){
      echo '<br><br><div class="well well-small" style="width:250px">
	    <span class="label label-success">Paso 1/2</span><br><br>
	    <p class="lsmall">'.$NOMBRE_UNIDAD.'&nbsp;&nbsp;<span class="icon-ok"></span></p></div>';
      }
  ?>
  
  <!--PASO 2/2: Seleccionar el proceso de evaluación-->
  <? if (isset($_GET['action']) && $_GET['action']=='stats_unidad' && isset($_GET['step']) && $_GET['step']==1) {?>
      <form class="form-horizontal" method="post" action="lib/cBusquedaResultados.php?action=stats_unidad&input=2&id=<?echo $_GET['id'];?>">
	<div class="control-group well" style="width:350px">
	  <span class="label label-primary">Paso 2/2</span><br><br>
	  <p class="lsmall"> Seleccione el proceso de evaluación para el que desea visualizar los resultados</p>
	  <select style="width:200px" id="proc" name="proc" class="select2  proc-sel" data-size="auto">';
	    <?for ($i=0; $i<count($LISTA_ENCUESTA['Enc']['periodo']); $i++){
	      echo "<option value=".$LISTA_ENCUESTA['Enc']['periodo'][$i].">".$LISTA_ENCUESTA['Enc']['nombre'][$i]."</option>";
	    }?>
	  </select><br><br>
	  <p class="lsmall muted"><i>Atención: al seleccionar la opción 'Histórico' se mostrará una síntesis de los resultados de la persona en los procesos de evaluación en los que ha participado</i></p>
	  <button type="submit" id="confirmButton" class="btn btn-default" >Ver resultados&nbsp;&nbsp;<span class="icon-signal"></span></button>
	</div>
      </form>
  <? } ?>

  <!--FIN DE BÚSQUEDA DE RESULTADOS POR UNIDAD-->
  
</div> <!--Cierre del contenedor-->


<?php 
if(isset($_GET['action'])) {
  switch($_GET['action']){
    case 'view_uni':
    //-------------------------------------
    //MUESTRA DE RESULTADOS: UNIDADxPROCESO
    //-------------------------------------
?>
      <!--ENCABEZADO REPORTE DE RESULTADOS-->
      <br><p class="lsmall muted"> Datos de la unidad</p><br>
      <div class="row">
	<div class="span1" align="right">
	  <img src="./img/iconos/unidad.png" class="img-circle">
	</div>
	<div class="span10">
	<blockquote>
	  <p><?echo $UNIDAD['Uni']['nombre'][0]?></p>
	  <p class="lsmall">Periodo del proceso de evaluación:&nbsp;<i><? echo $PROCESO['Proc']['periodo'][0]?></i></p>
	  <p class="lsmall">Número de trabajadores evaluados:&nbsp;<i><? echo $LISTA_EVALUADOS['max_res']?></i></p>
	</blockquote>
	</div>
      </div>

      <!--RESULTADOS PARA LA SECCION DE COMPETENCIAS-->
      <br>
      <p class="lead"><small>Evaluación de competencias</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de competencias</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		  echo '<th scope="row">T'.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		      if($LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		      if($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Trabajador</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Competencias deficientes</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_EVALUADOS['max_res'];$i++){
	?>
	  <tr class="<?php echo $color_tabla; ?>" >
	    <!--Trabajador-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación en detalle" href="./vResultados.php?token_ls=<? echo $LISTA_EVALUADOS['Eva']['token_ls'][$i]?>"><? echo $LISTA_EVALUADOS['Eva']['nombre'][$i]." (T".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i])*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['competencias']['maximo'][$i])*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	    <!--Competencias deficientes-->
	    <td class="center lsmallT" style="min-width: 400px"><small>
	    <? if(!($LISTA_EVALUADOS['Eva']['evaluacion']['competencias']['puntaje'][$i])){
		  echo "No aplica";
	       } else {
		  if(count($DEFICIENCIAS['individual']['competencias'][$i]['puntaje'])){
		    echo "El trabajador presentó las siguientes deficiencias:<br>";
		    for($j=0; $j<count($DEFICIENCIAS['individual']['competencias'][$i]['puntaje']) && $j<3; $j++){
		      $aux=each($DEFICIENCIAS['individual']['competencias'][$i]['puntaje']);
		      if($j<2){
			echo "&nbsp;&nbsp;- ".$DEFICIENCIAS['individual']['competencias'][$i]['competencia'][$aux['key']]."<br>";
		      } else {
			echo "&nbsp;&nbsp;- ".$DEFICIENCIAS['individual']['competencias'][$i]['competencia'][$aux['key']];
			if(count($DEFICIENCIAS['individual']['competencias'][$i]['puntaje'])>$j){
			echo "<br>&nbsp;&nbsp;- Entre otras";
			}
		      }
		    }
		  } else {
		    echo "El trabajador no presentó competencias deficientes";
		  }
	       }      
	    ?>
	    </small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Porcentaje promedio obtenido por la unidad en la sección de competencias</b></p>
	<a title="<?echo round($PROMEDIO_COMPETENCIAS*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_COMPETENCIAS*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_COMPETENCIAS*100).'%'?></span>
	  </div>
	</div>
	</a>
	
	<p style="font-size:11px"><b>Brecha promedio del resultado</b></p>
	<a title="<?echo (100-round($PROMEDIO_COMPETENCIAS*100))?>% de la evaluación" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?></span>
	  </div>
	</div>
	</a>
	
	<p style="font-size:11px"><b>Competencias deficientes en la unidad</b></p>
	<? if($DEFICIENCIAS['grupal']['competencias'][0]['count'] && $DEFICIENCIAS['grupal']['competencias'][4]['count']){?>
	    <table class="table table-hover" style="margin-left: 0; background-color: #fff">
	      <thead>
		<tr>
		  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Descripción</small></th>
		  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Porcentaje de deficiencia</small></th>
		</tr>
	      </thead>	
	      <tbody role="alert" aria-live="polite" aria-relevant="all">   
	      <?php
		for ($i=0;$i<count($DEFICIENCIAS['grupal']['competencias']);$i++){
	      ?>
		<tr>
		  <!--Competencia-->
		  <td class="center lsmallT"><small><? echo $DEFICIENCIAS['grupal']['competencias'][$i]['competencia'];?></a></small></td>  
		  <!--Porcentaje de deficiencia-->
		  <td class="center lsmallT" nowrap>
		    <small>
		      <a title="<?echo $DEFICIENCIAS['grupal']['competencias'][$i]['count']?> de <?echo $LISTA_EVALUADOS['max_res']?> trabajadores" style="text-decoration: none;">
		      <div class="progress" style="height: 20px;">
			<div class="progress-bar bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round(($DEFICIENCIAS['grupal']['competencias'][$i]['count']/$LISTA_EVALUADOS['max_res'])*100).'%'?>; height: 100%;">
			  <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round(($DEFICIENCIAS['grupal']['competencias'][$i]['count']/$LISTA_EVALUADOS['max_res'])*100).'%'?></span>
			</div>
		      </div>
		      </a>
		    </small>
		  </td>
		</tr>
	      <? } //cierre del for
	      ?>   
	      </tbody>
	    </table>
	<? } else {
	      echo "<p align='center' style='font-size:11px;'>La unidad no presentó competencias deficientes en este proceso de evaluación</p>";
	}?>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE COMPETENCIAS--> 
      
      <!--RESULTADOS PARA LA SECCION DE FACTORES-->
      <br>
      <p class="lead"><small>Evaluación de factores</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de factores desempeño</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		  echo '<th scope="row">T'.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		      if($LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_EVALUADOS['max_res']; $i++){
		      if($LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Trabajador</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Factores deficientes</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_EVALUADOS['max_res'];$i++){
	?>
	  <tr class="<?php echo $color_tabla; ?>" >
	    <!--Trabajador-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación en detalle" href="./vResultados.php?token_ls=<? echo $LISTA_EVALUADOS['Eva']['token_ls'][$i]?>"><? echo $LISTA_EVALUADOS['Eva']['nombre'][$i]." (T".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i])*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i]/$LISTA_EVALUADOS['Eva']['autoevaluacion']['factores']['maximo'][$i])*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	    <!--Factores deficientes-->
	    <td class="center lsmallT" style="min-width: 400px"><small>
	    <? if(!($LISTA_EVALUADOS['Eva']['evaluacion']['factores']['puntaje'][$i])){
		  echo "No aplica";
	       } else {
		  if(count($DEFICIENCIAS['individual']['factores'][$i]['puntaje'])){
		  echo "El trabajador presentó las siguientes deficiencias:<br>";
		  for($j=0; $j<count($DEFICIENCIAS['individual']['factores'][$i]['puntaje']) && $j<3; $j++){
		    $aux=each($DEFICIENCIAS['individual']['factores'][$i]['puntaje']);
		    if($j<2){
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS['individual']['factores'][$i]['factor'][$aux['key']]."<br>";
		    } else {
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS['individual']['factores'][$i]['factor'][$aux['key']];
		      if(count($DEFICIENCIAS['individual']['factores'][$i]['puntaje'])>$j){
		      echo "<br>&nbsp;&nbsp;- Entre otras";
		      }
		    }
		  }
		} else {
		  echo "El trabajador no presentó factores de desempeño deficientes";
		}
	      } 
	    ?>
	    </small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Porcentaje promedio obtenido en la sección de factores por la unidad</b></p>
	<a title="<?echo round($PROMEDIO_FACTORES*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_FACTORES*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_FACTORES*100).'%'?></span>
	  </div>
	</div>
	</a>
	
	<p style="font-size:11px"><b>Factores de desempeño deficientes en la unidad</b></p>
	<? if($DEFICIENCIAS['grupal']['factores'][0]['count'] && $DEFICIENCIAS['grupal']['factores'][4]['count']){?>
	      <table class="table table-hover" style="margin-left: 0; background-color: #fff">
	      <thead>
		<tr>
		  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Descripción</small></th>
		  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Porcentaje de deficiencia</small></th>
		</tr>
	      </thead>	
	      <tbody role="alert" aria-live="polite" aria-relevant="all">   
	      <?php
		for ($i=0;$i<count($DEFICIENCIAS['grupal']['factores']);$i++){
	      ?>
		<tr>
		  <!--Competencia-->
		  <td class="center lsmallT"><small><? echo $DEFICIENCIAS['grupal']['factores'][$i]['factor'];?></a></small></td>  
		  <!--Porcentaje de deficiencia-->
		  <td class="center lsmallT" nowrap>
		    <small>
		      <a title="<?echo $DEFICIENCIAS['grupal']['factores'][$i]['count']?> de <?echo $LISTA_EVALUADOS['max_res']?> trabajadores" style="text-decoration: none;">
		      <div class="progress" style="height: 20px;">
			<div class="progress-bar bar-warning" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round(($DEFICIENCIAS['grupal']['factores'][$i]['count']/$LISTA_EVALUADOS['max_res'])*100).'%'?>; height: 100%;">
			  <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round(($DEFICIENCIAS['grupal']['factores'][$i]['count']/$LISTA_EVALUADOS['max_res'])*100).'%'?></span>
			</div>
		      </div>
		      </a>
		    </small>
		  </td>
		</tr>
	      <? } //cierre del for
	      ?>   
	      </tbody>
	    </table>
      <? } else {
	    echo "<p align='center' style='font-size:11px;'>La unidad no presentó factores de desempeño deficientes en este proceso de evaluación</p>";
	 } ?>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE FACTORES-->
      
<? 
    break;
    //-----------------------------------------------
    //FIN DE LA MUESTRA DE RESULTADOS: UNIDADxPROCESO
    //-----------------------------------------------

    case 'hist_per':
    //----------------------------------------
    //MUESTRA DE RESULTADOS: PERSONAxHISTORICO
    //----------------------------------------
?>
      <!--ENCABEZADO REPORTE DE RESULTADOS-->
      <br>
      <p class="lsmall muted"> Datos del trabajador evaluado</p>
      <br>
      <div class="row">
	<div class="span1" align="right">
	  <img src="./img/iconos/user-new.jpg" class="img-circle">
	</div>
	<div class="span11">
	<blockquote>
	  <p><?echo $NOMBRE?></p>
	  <p class="lsmall">C.I. <? echo $CEDULA?></p>
	  <p class="lsmall"><? echo $CARGO['nombre']." (<i>".$CARGO['fecha_ini']." - "; if($CARGO['fecha_fin']) {echo $CARGO['fecha_fin']."</i>)";} else {echo "actualidad</i>)";}?></p>
	  <p class="lsmall"><? echo $UNIDAD?></p>

	</blockquote>
	</div>
      </div>

      <!--RESULTADOS PARA LA SECCION DE COMPETENCIAS-->
      <br>
      <p class="lead"><small>Evaluación de competencias</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de competencias</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		  echo '<th scope="row">Proceso '.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['puntaje'][$i]){
			echo  '<td>'.(($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Proceso de evaluación</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_PROCESOS['max_res'];$i++){
	?>
	  <tr>
	    <!--Proceso-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación en detalle" href="./vResultados.php?token_ls=<? echo $LISTA_PROCESOS['Proc']['token_ls'][$i]?>"><? echo $LISTA_PROCESOS['Proc']['nombre'][$i]." (Proceso ".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i])*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_PROCESOS['Proc']['evaluacion']['competencias']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['competencias']['maximo'][$i])*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Porcentaje promedio obtenido por la persona en la sección de competencias</b></p>
	<a title="<?echo round($PROMEDIO_COMPETENCIAS*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_COMPETENCIAS*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_COMPETENCIAS*100).'%'?></span>
	  </div>
	</div>
	</a>
	
	<p style="font-size:11px"><b>Brecha promedio del resultado</b></p>
	<a title="<?echo (100-round($PROMEDIO_COMPETENCIAS*100))?>% de la evaluación" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?></span>
	  </div>
	</div>
	</a>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE COMPETENCIAS--> 
      
      <!--RESULTADOS PARA LA SECCION DE FACTORES-->
      <br>
      <p class="lead"><small>Evaluación de factores</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de factores desempeño</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		  echo '<th scope="row">Proceso '.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]!=0){
			echo  '<td>'.(($LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i])*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Proceso de evaluación</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_PROCESOS['max_res'];$i++){
	?>
	  <tr class="<?php echo $color_tabla; ?>" >
	    <!--Proceso de evaluación-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación en detalle" href="./vResultados.php?token_ls=<? echo $LISTA_PROCESOS['Proc']['token_ls'][$i]?>"><? echo $LISTA_PROCESOS['Proc']['nombre'][$i]." (Proceso ".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i])*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round(($LISTA_PROCESOS['Proc']['evaluacion']['factores']['puntaje'][$i]/$LISTA_PROCESOS['Proc']['autoevaluacion']['factores']['maximo'][$i])*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Porcentaje promedio obtenido por la persona en la sección de factores</b></p>
	<a title="<?echo round($PROMEDIO_FACTORES*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_FACTORES*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_FACTORES*100).'%'?></span>
	  </div>
	</div>
	</a>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE FACTORES-->
      
<?
    //--------------------------------------------------
    //FIN DE LA MUESTRA DE RESULTADOS: PERSONAxHISTORICO
    //--------------------------------------------------
    break;

    //--------------------------------------------------
    //MUESTRA DE RESULTADOS: UNIDADxHISTORICO
    //--------------------------------------------------
    case 'hist_uni':
?>
      <!--ENCABEZADO REPORTE DE RESULTADOS-->
      <br><p class="lsmall muted"> Datos de la unidad</p><br>
      <div class="row">
	<div class="span1" align="right">
	  <img src="./img/iconos/unidad.png" class="img-circle">
	</div>
	<div class="span10">
	<blockquote>
	  <p><?echo $UNIDAD['Uni']['nombre'][0]?></p>
	  <p class="lsmall"><? echo $UNIDAD['Uni']['descripcion'][0]?></p>
	</blockquote>
	</div>
      </div>
      
      <!--RESULTADOS PARA LA SECCION DE COMPETENCIAS-->
      <br>
      <p class="lead"><small>Evaluación de competencias</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de competencias</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		  echo '<th scope="row">Proceso '.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias'][$i]){
			echo  '<td>'.($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias'][$i]*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]){
			echo  '<td>'.($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Proceso de evaluación</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Competencias deficientes</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_PROCESOS['max_res'];$i++){
	?>
	  <tr>
	    <!--Proceso-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación la unidad en detalle" href="./vBusquedaResultados.php?action=view_uni&id=<?echo $_GET['id']?>&proc=<? echo $LISTA_PROCESOS['Proc']['periodo'][$i]?>"><? echo $LISTA_PROCESOS['Proc']['nombre'][$i]." (Proceso ".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round($LISTA_PROCESOS['Proc']['autoevaluacion']['competencias'][$i]*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i]*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	    <!--Competencias deficientes-->
	    <td class="center lsmallT" style="min-width: 400px"><small>
	    <? if(!($LISTA_PROCESOS['Proc']['evaluacion']['competencias'][$i])){
		  echo "No aplica";
	       } else {
		  if($DEFICIENCIAS[$i]['competencias'][0]['count'] && $DEFICIENCIAS[$i]['competencias'][4]['count']){
		  echo "La unidad presentó las siguientes deficiencias:<br>";
		  for($j=0; $j<count($DEFICIENCIAS[$i]['competencias']) && $j<3; $j++){
		    if($j<2){
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS[$i]['competencias'][$j]['competencia']."<br>";
		    } else {
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS[$i]['competencias'][$j]['competencia'];
		      if(count($DEFICIENCIAS[$i]['competencias'])>$j){
		      echo "<br>&nbsp;&nbsp;- Entre otras";
		      }
		    }
		  }
		} else {
		  echo "La unidad no presentó competencias deficientes";
		}
	      } 
	    ?>
	    </small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Promedio del histórico de porcentajes obtenidos por la unidad en la sección de competencias</b></p>
	<a title="<?echo round($PROMEDIO_COMPETENCIAS*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_COMPETENCIAS*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_COMPETENCIAS*100).'%'?></span>
	  </div>
	</div>
	</a>
	
	<p style="font-size:11px"><b>Brecha promedio del resultado</b></p>
	<a title="<?echo (100-round($PROMEDIO_COMPETENCIAS*100))?>% de la evaluación" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo (100-round($PROMEDIO_COMPETENCIAS*100)).'%'?></span>
	  </div>
	</div>
	</a>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE COMPETENCIAS--> 
      
      <!--RESULTADOS PARA LA SECCION DE FACTORES-->
      <br>
      <p class="lead"><small>Evaluación de factores</small></p>
      <p class="lsmall muted"> Resultados obtenidos para la evaluación de factores desempeño</p>
      <br>
      
      <div class="row">
      <div class="span1"></div>
      <div class="span10"><br>
	<!--Tabla para el gŕafico-->
	<table class="tabla_factores" style="display: none">
	  <caption>Gráfico de los resultados</caption>
	  <thead>
	    <tr>
	      <td></td>
	      <?php 
		for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		  echo '<th scope="row">Proceso '.($i+1).'</th>';
		}
	      ?>
	    </tr>
	  </thead>
	  <tbody>
	      <tr>
		  <th scope="col">Auto-evaluación</th>
		  <?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['autoevaluacion']['factores'][$i]){
			echo  '<td>'.($LISTA_PROCESOS['Proc']['autoevaluacion']['factores'][$i]*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      </tr>

	      <tr>
		<th scope="col">Evaluación del supervisor inmediato</th>
		<?php
		    for($i=0; $i<$LISTA_PROCESOS['max_res']; $i++){
		      if($LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i]!=0){
			echo  '<td>'.($LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i]*100).'</td>';
		      } else {
			echo  '<td>0</td>';
		      }
		    }//cierra iteración
		  ?>
	      <td>100</td><!--Truco para definir el máximo-->
	      </tr>

	  </tbody>
	</table><br><br>
	<!--Fin de la tabla para el gŕafico-->
      </div> <!--Cierre del span10-->
      </div> <!--Cierre del row-->
      
      <!--Tabla de detalles-->
      <table class="table table-hover" style="margin-left: 0;">
	<thead>
	  <tr>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Proceso de evaluación</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	    <th class='lsmallT' style='border-top: 1px solid #dddddd'>
	      <small>Resultado evaluación</small>
	      <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span>
	    </th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Factores deficientes</small></th>
	  </tr>
	</thead>
	
	<tbody role="alert" aria-live="polite" aria-relevant="all">   

	<?php
	  for ($i=0;$i<$LISTA_PROCESOS['max_res'];$i++){
	?>
	  <tr class="<?php echo $color_tabla; ?>" >
	    <!--Proceso de evaluación-->
	    <td class="center lsmallT"><small><a title="Haga click para ver los resultados de la evaluación de la unidad en detalle" href="./vBusquedaResultados.php?action=view_uni&id=<?echo $_GET['id']?>&proc=<? echo $LISTA_PROCESOS['Proc']['periodo'][$i]?>"><? echo $LISTA_PROCESOS['Proc']['nombre'][$i]." (Proceso ".($i+1).")";?></a></small></td>  
	    <!--Resultado auto-evaluación-->
	    <? if($LISTA_PROCESOS['Proc']['autoevaluacion']['factores'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round($LISTA_PROCESOS['Proc']['autoevaluacion']['factores'][$i]*100)?>%</small></td>   
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado de las evaluaciones-->
	    <? if($LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i]){?>
		<td class="center lsmallT" nowrap><small><? echo round($LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i]*100)?>%</small></td>
	    <? } else {?>
		<td class="center lsmallT" nowrap><small>La evaluación no fue realizada</small></td>   
	    <? } ?>
	    <!--Resultado esperado-->
	    <td class="center lsmallT" nowrap><small>100%</small></td>
	    <!--Factores deficientes-->
	    <td class="center lsmallT" style="min-width: 400px"><small>
	    <? if(!($LISTA_PROCESOS['Proc']['evaluacion']['factores'][$i])){
		  echo "No aplica";
	       } else {
		  if($DEFICIENCIAS[$i]['factores'][0]['count'] && $DEFICIENCIAS[$i]['factores'][4]['count']){
		  echo "La unidad presentó las siguientes deficiencias:<br>";
		  for($j=0; $j<count($DEFICIENCIAS[$i]['factores']) && $j<3; $j++){
		    if($j<2){
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS[$i]['factores'][$j]['factor']."<br>";
		    } else {
		      echo "&nbsp;&nbsp;- ".$DEFICIENCIAS[$i]['factores'][$j]['factor'];
		      if(count($DEFICIENCIAS[$i]['factores'])>$j){
		      echo "<br>&nbsp;&nbsp;- Entre otras";
		      }
		    }
		  }
		} else {
		  echo "La unidad no presentó factores de desempeño deficientes";
		}
	      } 
	    ?>
	    </small></td>
	  </tr>
	<? } //cierre del for
	?>   
	</tbody>
      </table>
      <!--Fin de la tabla de detalles-->
      
      <!--Estadísticas-->
      <div class="well" style="padding:8px;">
      
	<p style="font-size:11px"><b>Promedio del histórico de porcentajes obtenidos por la unidad en la sección de factores</b></p>
	<a title="<?echo round($PROMEDIO_FACTORES*100).'% de la evaluación'?>" style="text-decoration: none;">
	<div class="progress" style="height: 20px;">
	  <div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($PROMEDIO_FACTORES*100).'%'?>; height: 100%;">
	    <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($PROMEDIO_FACTORES*100).'%'?></span>
	  </div>
	</div>
	</a>
	
      </div>
      <!--FIN DE RESULTADOS PARA LA SECCION DE FACTORES-->
<?
    //--------------------------------------------------
    //FIN DE LA MUESTRA DE RESULTADOS: UNIDADxHISTORICO
    //--------------------------------------------------
    break;
  }//cierre del switch
} //cierre condicional (vista de resultados)
?>

<?php
include "vFooter.php";
?>