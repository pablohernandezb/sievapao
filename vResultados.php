<?php
    session_start();
    include "lib/cResultados.php";
    $Legend = "Resultados de la Evaluación | $PERIODO";
    if(isAdmin()){
      include "vHeader.php";
    } else {
      include "vHeaderEvaluaciones.php";
    }
    extract($_GET);
    extract($_POST);
    $all = true;
    date_default_timezone_set('America/Caracas');
?>  

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
  
  <!--ALERTAS-->
  <?php 
    $EVALUADO_OK=1;//Estatus de la autoevaluación
    $EVALUADOR_OK=1;//Estatus de la evaluación
    if(!isset($LISTA_EVALUADORES['Eva']['id_encuestado'])){
      echo "<div class='alert alert-warning'>
		<button type='button' class='close' data-dismiss='alert'>&times;</button>
		<strong>Atención: </strong>Ningún supervisor inmediato ha finalizado la evaluación del trabajador
	    </div>";
      $EVALUADOR_OK=0;//No hay evaluaciones finalizadas
    } else if (count($LISTA_COMPETENCIAS['Preg']['resultado'][0])==0) {
      echo "<div class='alert alert-warning'>
	      <button type='button' class='close' data-dismiss='alert'>&times;</button>
	      <strong>Atención: </strong>El trabajador no ha finalizado su autoevaluación
	    </div>";
      $EVALUADO_OK=0;//La autoevaluación no se finalizó
    }
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
       <p class="lsmall"><? echo $CARGO?></p>
       <p class="lsmall"><? echo $UNIDAD?></p>

    </blockquote>
    </div>
  </div>
  <br>

  <!--RESULTADOS PARA LA SECCION DE COMPETENCIAS-->
  <p class="lead"><small>Evaluación de competencias</small></p>
  <p class="lsmall muted"> Resultados obtenidos para la evaluación de competencias</p>
  
    <div class="row">
    <div class="span1"></div>
    <div class="span10"><br>
    
    <!--Tabla para el gŕafico-->
    <table class="tabla_competencias" style="display: none">
    <caption><small>Gráfico de los resultados</small></caption>
    <thead><tr>
	<td></td>
	<?php for($i=0; $i<$LISTA_COMPETENCIAS['max_res']; $i++){ ?>
	  <th scope="row">C<? echo $i+1;?></th>
	<?php } ?>
    </tr></thead>
    
    <tbody>
      <?php if($EVALUADO_OK){ ?>
	<tr>
	    <th scope="col">Auto-evaluación</th>
	    <?php for($i=0; $i<$LISTA_COMPETENCIAS['max_res']; $i++){
	      switch($LISTA_COMPETENCIAS['Preg']['resultado'][$i]){
	      case 'Siempre':
		echo  '<td>3</td>';
		break;
	      case 'Casi siempre':
		echo  '<td>2</td>';
		break;
	      case 'Pocas veces':
		echo  '<td>1</td>';
		break;
	      case 'Nunca':
		echo  '<td>0</td>';
		break;
	      }//cierra switch
	    }?>
	<td>3</td><!--Truco para definir el máximo-->
	</tr>
      <?php } ?>
      
      <?php if($EVALUADOR_OK){ ?>
	<tr>
	  <th scope="col">Evaluación del supervisor inmediato</th>
	  <?php 
	    $n=count($LISTA_EVALUADORES['Eva']['id_encuestado']);
	    for($i=0; $i<count($PROMEDIO_EVALUADORES['re_competencia']); $i++){
	      echo '<td>'.($PROMEDIO_EVALUADORES['re_competencia'][$i]/$n).'</td>';
	    }  
	  ?>
	<td>3</td><!--Truco para definir el máximo-->
	</tr>
      <?php }?>
      
    </tbody>
    </table>
    <!--Fin de la tabla para el gŕafico-->
    </div> <!--Cierre span10-->
    <div class="span1"></div>
    </div><br><br><!-- Cierre row-->
    
    <!--Tabla de detalles-->
    <table class="table table-hover" style="margin-left: 0;">
      <thead>
	<tr>
	  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Competencia</small></th>
	  <?php if($EVALUADO_OK) {?>
	    <th class="lsmallT" style="border-top: 1px solid #dddddd">
	      <small>Resultado auto-evaluación</small>
	      <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	    </th>
	  <?php } 
	  if($EVALUADOR_OK){
	    for ($j=0; $j<count($LISTA_EVALUADORES['Eva']['nombre']); $j++){
	    echo "<th class='lsmallT' style='border-top: 1px solid #dddddd'>
		  <small>Resultado evaluación<br>(".$LISTA_EVALUADORES['Eva']['nombre'][$j].") </small>
		  <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span></th>";
	    }
	  } ?>
	  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	</tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">   
      <!-- Listado de evaluaciones finalizadas -->
      <?php
	for ($i=0;$i<$LISTA_COMPETENCIAS['max_res'];$i++){
      ?>
	<tr class="<?php echo $color_tabla; ?>" >
	  <!--Competencia-->
	  <td class="center lsmallT" nowrap><small><? echo $LISTA_COMPETENCIAS['Preg']['titulo'][$i]." (C".($i+1).")";?></small></td>  
	  <!--Resultado auto-evaluación-->
	  <? if ($EVALUADO_OK){ ?>
	  <td class="center lsmallT" nowrap><small><? echo $LISTA_COMPETENCIAS['Preg']['resultado'][$i]?></small></td>   
	  <? } ?>
	  <!--Resultado de las evaluaciones-->
	  <?if ($EVALUADOR_OK){
	    for ($j=0; $j<count($LISTA_EVALUADORES['Eva']['id_encuestado']); $j++){
	      echo "<td class='center lsmallT' nowrap><small>".$LISTA_EVALUADORES['Eva']['re_competencia'][$j][$i]."</small></td>";
	    }
	    }?>
	  <!--Resultado esperado-->
	  <td class="center lsmallT" nowrap><small><? echo "Siempre"?></small></td>
	</tr>
      <? } //cierre del for
      ?>   
      </tbody>
    </table>
    <!--Fin de la tabla de detalles-->
    
    <!--Estadísticas-->
    <div class="well" style="padding:8px;">
      <p style="font-size:11px"><b>Puntaje obtenido en la sección de competencias (índice aptitudinal)</b></p>
      <?if ($EVALUADOR_OK){?>
      <a title="<?echo (round(($PUNTAJE_COMPETENCIAS/$PUNTAJE_COMPETENCIAS_MAX)*100)).'%'?> (<?echo $PUNTAJE_COMPETENCIAS?> de <?echo $PUNTAJE_COMPETENCIAS_MAX?> puntos)" style="text-decoration: none;">
      <div class="progress" style="height: 20px;">
	<div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo (($PUNTAJE_COMPETENCIAS/$PUNTAJE_COMPETENCIAS_MAX)*100).'%'?>; height: 100%;">
	  <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo (round(($PUNTAJE_COMPETENCIAS/$PUNTAJE_COMPETENCIAS_MAX)*100)).'%'?></span>
	</div>
      </div>
      </a>
      
      <p style="font-size:11px"><b>Brecha del resultado</b></p>
      <a title="<?echo round($BRECHA).'% ('.($PUNTAJE_COMPETENCIAS_MAX-$PUNTAJE_COMPETENCIAS).' de '.$PUNTAJE_COMPETENCIAS_MAX.' puntos)'?>" style="text-decoration: none;">
      <div class="progress" style="height: 20px;">
	<div class="progress-bar bar-danger" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo round($BRECHA,2).'%'?>; height: 100%;">
	  <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo round($BRECHA).'%'?></span>
	</div>
      </div>
      </a>
      
      <?} else {
	echo "<p align='center' style='font-size:11px;'>No hay resultados disponibles para la evaluación del trabajador</p>";
      }?>
    </div>
    <!--FIN DE LA SECCION DE COMPETENCIAS-->
    
    <!--RESULTADOS PARA LA SECCION DE FACTORES-->
    <br>
    <p class="lead"><small>Evaluación de factores</small></p>
    <p class="lsmall muted"> Resultados obtenidos para la evaluación de factores desempeño</p>
    <div class="row">
    <div class="span1"></div>
    <div class="span10">
    <br>
    <!--Tabla para el gŕafico-->
    <table class="tabla_factores" style="display: none">
    <caption>Gráfico de los resultados</caption>
    <thead>
      <tr>
	<td></td>
	<?php
	  for($i=0; $i<$LISTA_FACTORES['max_res']; $i++){
	?>
	  <th scope="row">F<? echo $i+1;?></th>
	<?php
	  }
	?>
      </tr>
    </thead>
    <tbody>
      <?php if($EVALUADO_OK){ ?>
	<tr>
	    <th scope="col">Auto-evaluación</th>
	    <?php
	      for($i=0; $i<$LISTA_FACTORES['max_res']; $i++){
		switch($LISTA_FACTORES['Preg']['resultado'][$i]){
		  case 'Excelente':
		    echo  '<td>3</td>';
		    break;
		  case 'Sobre lo esperado':
		    echo  '<td>2</td>';
		    break;
		  case 'En lo esperado':
		    echo  '<td>1</td>';
		    break;
		  case 'Por debajo de lo esperado':
		    echo  '<td>0</td>';
		    break;
		}//cierra switch
	      }//cierra iteración
	    ?>
	</tr>
      <? }
      if($EVALUADOR_OK){
      ?>
	<tr>
	  <th scope="col">Evaluación del supervisor inmediato</th>
	  <?php 
	    $n=count($LISTA_EVALUADORES['Eva']['id_encuestado']);
	    for($i=0; $i<count($PROMEDIO_EVALUADORES['re_factor']); $i++){
	      echo '<td>'.($PROMEDIO_EVALUADORES['re_factor'][$i]/$n).'</td>';
	    }
	  ?>
	<td>3</td><!--Truco para definir el máximo-->
	</tr>
      <? } ?>
	
    </tbody>
    </table>
    <!--Fin de la tabla para el gŕafico-->
    </div> <!--Cierre span10-->
    <div class="span1"></div>
    </div><br><br> <!-- Cierre row-->
    
    <!--Tabla de detalles-->
    <table class="table table-hover" style="margin-left: 0;">
      <thead>
	<tr>
	  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Factor de desempeño</small></th>
	  <?php if($EVALUADO_OK) {?>
	  <th class="lsmallT" style="border-top: 1px solid #dddddd">
	    <small>Resultado auto-evaluación</small>
	    <span style="font-size:8px; padding-left:8px; background:#62c462;">&nbsp;</span>
	  </th>
	  <?}?>
	  <?if($EVALUADOR_OK){
	    for ($j=0; $j<count($LISTA_EVALUADORES['Eva']['nombre']); $j++){
	    echo "<th class='lsmallT' style='border-top: 1px solid #dddddd'>
		  <small>Resultado evaluación<br>(".$LISTA_EVALUADORES['Eva']['nombre'][$j].") </small>
		  <span style='font-size:8px; padding-left:8px; background:#0088cc;'>&nbsp;</span></th>";
	    }
	  } ?>
	  <th class="lsmallT" style="border-top: 1px solid #dddddd"><small>Resultado esperado</small></th>
	</tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">   
      <!-- Listado de evaluaciones finalizadas -->
      <?php
	for ($i=0;$i<$LISTA_FACTORES['max_res'];$i++){
      ?>
	<tr class="<?php echo $color_tabla; ?>" >
	  <!--Competencia-->
	  <td class="center lsmallT" style="width: 40%"><small><? echo $LISTA_FACTORES['Preg']['titulo'][$i]." (F".($i+1).")";?></small></td>  
	  <!--Resultado auto-evaluación-->
	  <? if ($EVALUADO_OK){ ?>
	  <td class="center lsmallT" nowrap><small><? echo $LISTA_FACTORES['Preg']['resultado'][$i]?></small></td>   
	  <? }?>
	  <!--Resultado de las evaluaciones-->
	  <?if($EVALUADOR_OK){ 
	    for ($j=0; $j<count($LISTA_EVALUADORES['Eva']['id_encuestado']); $j++){
	      echo "<td class='center lsmallT' nowrap><small>".$LISTA_EVALUADORES['Eva']['re_factor'][$j][$i]."</small></td>";
	    }
	    } ?>
	  <!--Resultado esperado-->
	  <td class="center lsmallT" nowrap><small><? echo "Excelente"?></small></td>
	</tr>
      <? } //cierre del for
      ?>   
      </tbody>
    </table>
    <!--Fin de la tabla de detalles-->
   
    <!--Estadísticas-->
    <div class="well" style="padding:8px;">
      <p style="font-size:11px"><b>Puntaje obtenido en la sección de factores</b></p>
      <? if ($EVALUADOR_OK) {?>
      <a title="<?echo (round(($PUNTAJE_FACTORES/$PUNTAJE_FACTORES_MAX)*100)).'%'?> (<?echo $PUNTAJE_FACTORES?> de <?echo $PUNTAJE_FACTORES_MAX?> puntos)" style="text-decoration: none;">
      <div class="progress" style="height: 20px;">
	<div class="progress-bar bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?echo (($PUNTAJE_FACTORES/$PUNTAJE_FACTORES_MAX)*100).'%'?>; height: 100%;">
	  <span class="sr-only" style="font-size:11px; color:#fff; line-height: 175%; font-weight: bold;">&nbsp;<?echo (round(($PUNTAJE_FACTORES/$PUNTAJE_FACTORES_MAX)*100)).'%'?></span>
	</div>
      </div>
      </a>
      <?} else {
	echo "<p align='center' style='font-size:11px;'>No hay resultados disponibles para la evaluación del trabajador</p>";
      }?>
    </div>
    <!--FIN DE LA SECCION DE FACTORES-->
    
    <? if(isset($_GET['action']) ) {
	switch($_GET['action']){
	  case 'supervisar':?>
	  <div class="well" style="padding:8px; background-color: #fff; box-shadow:none" align="center">
	    <br><small>Haga click en el botón <i>Validar</i> para aprobar la evaluación del supervisor inmediato o en el botón <i>Rechazar</i> para rechazar la misma</small><br><br>
	    <p>
		<a class="btn btn-success" href="lib/cResultados.php?token_ls=<?echo $_GET['token_ls']?>&action=validar">Validar</a>
		<a class="btn" href="lib/cResultados.php?token_ls=<?echo $_GET['token_ls']?>&action=rechazar">Rechazar</a>
	    </p><br> 
	  </div>
	  <? break;
	  case 'revisarR': ?>
	  <div class="well" style="padding:8px; background-color: #fff; box-shadow:none" align="center">
	    <br>
	    <p class="lsmall less">Actualmente la evaluación se encuentra rechazada, <i>haga click</i> en el siguiente botón si desea validarla ahora</p><br>
	    <a class="btn btn-success" href="lib/cResultados.php?token_ls=<?echo $_GET['token_ls']?>&action=validarR">Validar</a>	
	    <br>
	  </div>
	  <? break;
	  case 'revisarE': ?>
	  <form id="newCar" class="form-horizontal" method="post" action="lib/cResultados.php?action=notificarE&token_ls=<?echo $_GET['token_ls']?>" >
	    <div class="well" style="padding:8px; background-color: #fff; box-shadow:none" align="center">
	      <br><small>Si no se encuentra conforme con los resultados de su evaluación explique sus razones en el siguiente recuadro y <i>haga click</i> en el botón <i>Notificar</i></small><br><br>
	      <div class="control-group">
		    <div class="input-prepend">
			  <textarea class="input-xlarge" rows="6" id="msg" name="msg" placeholder="Justifique aquí..." style="width:500px"></textarea>
		    </div>
	      </div>
	      <div class="well well-small" align="justify" style="max-width:500px">
		<small class="muted"><img src="./img/iconos/help-16.png"> Al notificar su disconformidad con los resultados de su evaluación se iniciará el estudio de su caso por parte de la <i>Dirección de Gestión de Capital Humano</i>. Se recomienda explicar los motivos por los cuales no se encuentra conforme de forma clara y precisa para facilitar la gestión de su caso</small>
	      </div>
	      <button type="submit" class="btn btn-warning">Notificar</button><br><br>
	    </div>
	  </form>
	<?}?>
   
      
      
   <? } ?>

   
<?
include "vFooter.php";
?>
