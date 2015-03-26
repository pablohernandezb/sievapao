<?php
    session_start();
    $Legend = "Administrar Evaluaciones";
    include "lib/cEncuestas.php";
    include "vHeader.php";
    extract($_GET);
    $all = true;
?>   

<script type="text/javascript">
    $(document).ready(function(){
        $("#newEnc").validate({
            submitHandler : function(form) {
                bootbox.dialog('¿Esta seguro de continuar?', [{
                         'label':'No',
                         'class':'btn'
                        },
                        {
                         'label':'Sí',
                         'class':'btn',
                         'callback':function() {
                                return form.submit();
                         }
                        }]);
            },
            rules:{
                unidad:"required",
                encuesta:"requires",
            },
            messages: {
                unidad:"Campo Requerido.",
                encuesta:"Campo Requerido.",
            },
            errorClass: "help-inline"
        });
        $("#setWeight").validate({
            submitHandler : function(form) {
                bootbox.dialog('¿Esta seguro de continuar?', [{
                         'label':'No',
                         'class':'btn'
                        },
                        {
                         'label':'Sí',
                         'class':'btn',
                         'callback':function() {
                                return form.submit();
                         }
                        }]);
            },
            rules:{
                peso:"required",
            },
            messages: {
                peso:"Campo Requerido.",
            },
            errorClass: "help-inline"
        });
        $("#newWeight").validate({
            submitHandler : function(form) {
                bootbox.dialog('¿Esta seguro de continuar?', [{
                         'label':'No',
                         'class':'btn'
                        },
                        {
                         'label':'Sí',
                         'class':'btn',
                         'callback':function() {
                                return form.submit();
                         }
                        }]);
            },
            rules:{
                peso:"required",
            },
            messages: {
                peso:"Campo Requerido.",
            },
            errorClass: "help-inline"
        })
    });
    
</script>


<div class="tabbable"> <!-- Only required for left/right tabs -->
<ul class="nav nav-tabs">
   <li class="<? if(!(isset($_GET['tab'])) || ($_GET['tab'])==1 ) echo'active'?>"><a href="#tab1" data-toggle="tab">Por Unidad</a></li>
   <li class="<? if(($_GET['tab'])==2 ) echo'class=active'?>"><a href="#tab2" data-toggle="tab">Por Grupos de Roles</a></li>
   <li class="<? if(($_GET['tab'])==3 ) echo'class=active'?>"><a href="#tab3" data-toggle="tab">Por Cargos</a></li>
   <li class="<? if(($_GET['tab'])==4 ) echo'class=active'?>"><a href="#tab4" data-toggle="tab">Por Persona</a></li>
</ul>
<div class="tab-content">
   <div class="tab-pane <? if(!(isset($_GET['tab']))) echo'active'?>" id="tab1">
      <!-- Tab para Evaluaciones por Unidad -->
      <div class="well" align="center">

<?php
  if (!(isset($_GET['action']))){
    if ($NUM_ENC_UNIDAD==0){
	  echo "<br><br><br><br><p class='text-center text-info'>Hasta el momento no hay evaluaciones en el sistema.</p><br><br><br><br>";
    }else{
    ?>
	
    <div id="demo" align="center">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
    <thead>
      <tr>
	<th class="lsmallT"><small>Grupos de roles evaluados</small></th>
	<th class="lsmallT"><small>Unidad evaluada</small></th>
	<th class="lsmallT"><small>Estado</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
	<th class="lsmallT"><small>Grupo de roles evaluados</small></th>
	<th class="lsmallT"><small>Unidad evaluada</small></th>
	<th class="lsmallT"><small>Estado</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </tfoot>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
	
    <!-- Listado de encuestas definidas -->
    <?php
      if ($LISTA_ENCUESTA['max_res']>0){
          for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){
		if($LISTA_UNIDADES[$i]!='USB') {	
    ?>
    <tr>
      <td class="center lsmallT" nowrap><small> <? echo $LISTA_CARGOS[$i];?></small></td>   
      <td class="center lsmallT" nowrap><small> <? echo $LISTA_UNIDADES[$i];?></small></td>
      <td class="center lsmallT" nowrap><small><? if (($LISTA_ENCUESTA['Enc']['estado'][$i])=='f') { echo "Evaluación inactiva"; } else { echo "Evaluación activa";}?></small></td>
      <td class="center lsmallT" nowrap><small><? 
	if (($LISTA_ENCUESTA['Enc']['estado'][$i])=='f') {
	  echo '<a href="?action=modificar&id_encuesta='; echo $LISTA_ENCUESTA['Enc']['id'][$i];echo '" title="Editar pesos de la evaluación"> <img src="./img/iconos/edit-16.png" style="margin-left:5px;"></a></a>';
	  echo '<a href="lib/cEncuestas.php?action=delete&id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id'][$i]; echo '" title="Eliminar evaluación"><img src="./img/iconos/delete-16.png" style="margin-left:7px;"></a>';
	  echo '<a href="lib/cDescargarEncuesta.php?id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '&id_fam='; echo $LISTA_ENCUESTA['Enc']['id_fam'][$i]; echo '" title="Descargar evaluación en PDF"><img src="./img/iconos/pdf-16.png" style="margin-left:9px;"></a>';
	  } else {
	  echo '<a href="lib/cDescargarEncuesta.php?id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '&id_fam='; echo $LISTA_ENCUESTA['Enc']['id_fam'][$i]; echo '" title="Descargar evaluación en PDF"><img src="./img/iconos/pdf-16.png" style="margin-left:5px;"></a>';
	  }
	  ?></small></td>
    </tr>

    <?    } // cierre del if
	} //cierre del for
      } //cierre del if  
    ?>
	
    </tbody>
	    
  </table>
  </div>

  <?php
    }//cierra el else 
  ?>
    <div align="center">
      <a href="./vEncuestas.php?action=try&tipo=unidad" class="btn btn-info">Agregar Evaluación</a>
    </div>

      </div> <!--Cierra el div del Contenido del tab1-->
    </div> <!--Cierra el div del Tab1-->

<div class="tab-pane <? if(($_GET['tab'])==2 ) echo'active'?>" id="tab2">
   <!-- Tab para Evaluaciones por Grupo de Cargos -->
   <div class="well" align="center">

<?php
  
    if ($NUM_ENC_ROL==0){
	  echo "<br><br><br><br><p class='text-center text-info'>Hasta el momento no hay evaluaciones en el sistema.</p><br><br><br><br>";
    }else{
    ?>
	
    <div id="demo" align="center">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
    <thead>
      <tr>
	<th class="lsmallT"><small>Grupos de cargos evaluada</small></th>
	<th class="lsmallT"><small>Unidad evaluada</small></th>
	<th class="lsmallT"><small>Estado</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
	<th class="lsmallT"><small>Grupo de cargos evaluada</small></th>
	<th class="lsmallT"><small>Unidad evaluada</small></th>
	<th class="lsmallT"><small>Estado</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </tfoot>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
	
    <!-- Listado de encuestas definidas -->
    <?php
      if ($LISTA_ENCUESTA['max_res']>0 && in_array('USB',$LISTA_UNIDADES)){
      for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){
    
	if($LISTA_UNIDADES[$i]=='USB') {
    ?>
    <tr>
      <td class="center lsmallT" nowrap><small><? echo $LISTA_CARGOS[$i];?></small></td>   
      <td class="center lsmallT" nowrap><small><? echo $LISTA_UNIDADES[$i];?></small></td>
      <td class="center lsmallT" nowrap><small><? if (($LISTA_ENCUESTA['Enc']['estado'][$i])=='f') { echo "Evaluación inactiva"; } else { echo "Evaluación activa";}?></small></td>
      <td class="center lsmallT" nowrap><small><? 
	if (($LISTA_ENCUESTA['Enc']['estado'][$i])=='f') {
	  echo '<a href="?action=modificar&id_encuesta='; echo $LISTA_ENCUESTA['Enc']['id'][$i];echo '" title="Editar pesos de la evaluación"> <img src="./img/iconos/edit-16.png" style="margin-left:5px;"></a></a>';
	  echo '<a href="lib/cEncuestas.php?action=delete&id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id'][$i]; echo '" title="Eliminar evaluación"><img src="./img/iconos/delete-16.png" style="margin-left:7px;"></a>';
	  echo '<a href="lib/cDescargarEncuesta.php?id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '&id_fam='; echo $LISTA_ENCUESTA['Enc']['id_fam'][$i]; echo '" title="Descargar evaluación en PDF"><img src="./img/iconos/pdf-16.png" style="margin-left:9px;"></a>';
	  } else {
	  echo '<a href="lib/cDescargarEncuesta.php?id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '&id_fam='; echo $LISTA_ENCUESTA['Enc']['id_fam'][$i]; echo '" title="Descargar evaluación en PDF"><img src="./img/iconos/pdf-16.png" style="margin-left:5px;"></a>';
	  }
	  ?></small></td>
    </tr>

    <?    
	  } //cierre del if
	} //cierre del for
      } //cierre del if  
    ?>
	
    </tbody>
	    
  </table>
  </div>

  <?php
    }//cierra el else 
  ?>

    <div align="center">
      <a href="./vEncuestas.php?action=try&tipo=gruporoles" class="btn btn-info">Agregar Evaluación</a>
    </div>

   </div>
</div>

<div class="tab-pane <? if(($_GET['tab'])==3 ) echo'active'?>" id="tab3">
   <!-- Tab para Evaluaciones por Cargos -->
   <div class="well" align="center">
   </div>
</div>

<div class="tab-pane <? if(($_GET['tab'])==4 ) echo'active'?>" id="tab4">
   <!-- Tab para Evaluaciones por Personas -->
   <div class="well" align="center">
   </div>
</div>


  </div> <!--Cierra el div del TabContent-->
</div> <!--Cierra el div del Tabbable-->

  <?
  } elseif ($_GET['action']=='try'){
  ?>
  
  <? if($_GET['tipo']=='unidad') { ?>

  <!-- Formulario nueva evaluación-->
  <div class="well" align="center">
    <p class='muted'><small>Por favor escoja el tipo de encuesta y la unidad asociada a la nueva evaluación.</small></p><br>
      <form id="newEnc" class="form-horizontal" method="post" action="lib/cEncuestas.php?action=add&tipo=unidad" >
	  <div class="row">
	  <div class="span3"></div>
	  <div class="span4">
	    <div class="control-group">
		<label class="control-label">Encuesta de evaluación del personal</label>
		<div class="controls">
		  <select style="width:200px" id="encuesta" name="encuesta" class="select2" data-size="auto">
		      <?
			  for ($i=0; $i<$ENCUESTA_ID['max_res']; $i++){
			      echo "<option value=".$ENCUESTA_ID['Enc']['id_encuesta_ls'][$i].">".$ENCUESTA_ID['Enc']['nombre'][$i]."</option>";
			  }
		      ?>
		  </select>
		</div>
		<br>
		<label class="control-label">Unidad</label>
		<div class="controls">
		  <select style="width:200px" id="unidad" name="unidad" class="select2" data-size="auto">
		      <?
			  while (list($key, $val) = each($UNIDAD_ID)){
			      echo "<option value=".$key.">".$val."</option>";
			  }
		      ?>
		  </select>
		</div>
	    </div>
	  </div><!--Cierre del span4-->
	  </div><!--Cierre del row-->
	<button type="submit" id="confirmButton" class="btn btn-success" >Continuar</button>
	<a href="?" class="btn">Cancelar</a>
      </form>
  </div>
  <? } elseif ($_GET['tipo']=='gruporoles') { ?>

<div class="well" align="center">
    <p class='muted'><small>Por favor escoja el grupo de cargos asociado a la nueva evaluación. <br>Recuerde que serán evaluados todos los trabajadores pertenecientes a este grupo de cargos sin distingo de sede o unidad.</small></p><br>
      <form id="newEnc" class="form-horizontal" method="post" action="lib/cEncuestas.php?action=add&tipo=gruporoles" >
	  <div class="row">
	  <div class="span3"></div>
	  <div class="span4">
	    <div class="control-group">
		<label class="control-label">Encuesta de evaluación del personal</label>
		<div class="controls">
		  <select style="width:200px" id="encuesta" name="encuesta" class="select2" data-size="auto">
		      <?
			  for ($i=0; $i<$ENCUESTA_ID['max_res']; $i++){
			      echo "<option value=".$ENCUESTA_ID['Enc']['id_encuesta_ls'][$i].">".$ENCUESTA_ID['Enc']['nombre'][$i]."</option>";
			  }
		      ?>
		  </select>
		</div>
	    </div>
	  </div><!--Cierre del span4-->
	  </div><!--Cierre del row-->
	<button type="submit" id="confirmButton" class="btn btn-success" >Continuar</button>
	<a href="?" class="btn">Cancelar</a>
      </form>
  </div>

  <? } elseif ($_GET['tipo']=='cargo') { ?>

  <? } elseif ($_GET['tipo']=='persona') { ?>
  
  <? } ?>

  <? } elseif ($_GET['action']=='pesos'){?>
    <div class="span2"></div>
    <div class="span7">
      <br><p class="lead"><small>Pesos de factores</small></p>
      <p class='muted'><small>Por favor ingrese los pesos asociados a los factores de esta evaluación. Recuerde que el rango de valores posibles es: 0 - 100</small></p>
      
      <div class="well" style="background-color:#fff">
      <form id="setWeight" class="form-horizontal" method="post" action="lib/cEncuestas.php?action=set&id_encuesta=<? echo $_GET['id_encuesta'];?>" >
      <table class="table table-hover" >
      
	  <thead>
	      <tr>
		<th class="lsmallT"><small>Pregunta</small></th>
		<th class="lsmallT"><small>Peso</small></th>
	      </tr>
	  </thead>

	  <tbody role="alert" aria-live="polite" aria-relevant="all">
	    <!-- Encuestas del usuario -->
	    <?php
	      for ($i=0;$i<$LISTA_PREGUNTA['max_res'];$i++){
	    ?>
		<tr>
		  <? if ($LISTA_PREGUNTA['Preg']['id_pregunta_root_ls'][$i]==NULL) { ?> 
		    <td class="center lsmallT" ><small><? echo $LISTA_PREGUNTA['Preg']['titulo'][$i] ?></small></td>
		    <td class="center lsmallT" style="width: 30px" nowrap>
		      <input class="peso" type="text" required name="peso_<?echo $LISTA_PREGUNTA['Preg']['id_pregunta'][$i]?>" id="peso_<?echo $i?>" data-format="d.d" value="-" maxLength="3" style="width: 30px;" readonly/>
		    </td>
		    </td> 
		  <? } else { ?>
		    <td class="center lsmallT" ><small>&nbsp;&nbsp;&nbsp;&nbsp;&rarr;<? echo $LISTA_PREGUNTA['Preg']['titulo'][$i] ?></small></td>
		    <td class="center lsmallT" style="width: 30px" nowrap>
		      <input class="peso" type="text" required name="peso_<?echo $LISTA_PREGUNTA['Preg']['id_pregunta'][$i]?>" id="peso_<?echo $i?>" data-format="d.d" placeholder="0" maxLength="3" style="width: 30px;" />
		    </td>
		    </td> 		
		  <? }?>
		</tr>
	    <? } //cierre del for
	    ?>
	  </tbody>

      </table>
      </div>
      <div align="center">
	<button type="submit" id="confirmButton" class="btn">Finalizar</button>
      </div>
      </form>
    </div> <!--Cierre span7-->
  
  <? } elseif ($_GET['action']=='modificar'){
  ?>
    <div class="span2"></div>
    <div class="span7">
      <!--Sección de factores-->
      <br><p class="lead"><small>Pesos de factores</small></p>
      <p class='muted'><small>A continuación se listan los pesos definidos para cada uno de los factores evaluados en esta encuesta. Si desea modificar alguno de los pesos tan sólo <i>haga click</i> sobre el campo correspondiente e ingrese el nuevo valor. Recuerde que el rango de valores posibles es: 0 - 100</small></p>      
      <div class="well" style="background-color:#fff">
      <form id="newWeight" class="form-horizontal" method="post" action="lib/cEncuestas.php?action=edit&id_encuesta=<? echo $_GET['id_encuesta'];?>" >
      <table class="table table-hover" >
	<thead>
	    <tr>
	      <th class="lsmallT"><small>Pregunta</small></th>
	      <th class="lsmallT"><small>Peso</small></th>
	    </tr>
	</thead>
	<tbody role="alert" aria-live="polite" aria-relevant="all">
	  <!-- Preguntas de la sección de factores -->
	  <?php
	    for ($i=0;$i<$LISTA_PREGUNTA['max_res'];$i++){
	  ?>
	      <tr>
		<? if ($LISTA_PREGUNTA['Preg']['id_pregunta_root_ls'][$i]==NULL) { ?> 
		  <td class="center lsmallT" ><small><? echo $LISTA_PREGUNTA['Preg']['titulo'][$i] ?></small></td>
		  <td class="center lsmallT" style="width: 30px" nowrap>
		    <input class="peso" type="text" required name="peso_<?echo $LISTA_PREGUNTA['Preg']['id_pregunta'][$i]?>" id="peso_<?echo $i?>" data-format="d.d" value="-" maxLength="3" style="width: 30px;" readonly/>
		  </td>
		  </td> 
		<? } else { ?>
		  <td class="center lsmallT" ><small>&nbsp;&nbsp;&nbsp;&nbsp;&rarr;<? echo $LISTA_PREGUNTA['Preg']['titulo'][$i] ?></small></td>
		  <td class="center lsmallT" style="width: 30px" nowrap>
		    <input class="peso" type="text" required name="peso_<?echo $LISTA_PREGUNTA['Preg']['id_pregunta'][$i]?>" id="peso_<?echo $i?>" data-format="d.d" value="<?if ($LISTA_PREGUNTA['Preg']['peso'][$i]!=NULL) echo ($LISTA_PREGUNTA['Preg']['peso'][$i]*100); ?>" placeholder="0.0" maxLength="3" style="width: 30px;" />
		  </td>
		  </td> 		
		<? }?>
	      </tr>
	  <? } //cierre del for
	  ?>
	</tbody>

      </table>
      </div>
      <div align="center">
	<button type="submit" id="confirmButton" class="btn">Modificar</button>
	<a href="?" class="btn">Cancelar</a>
      </div>
      </form>
    </div> <!--Cierre span7-->
  
  <?php
  } //cierre del else (action: modificar)
  include "vFooter.php";
  ?>

