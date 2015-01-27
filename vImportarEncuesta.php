<?php
    session_start();
    $Legend = "Importar encuesta de Limesurvey";
    include "lib/cImportarEncuesta.php";
    include "vHeader.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
?>

  <style type="text/css">
     @import "css/bootstrap.css";
  </style>


<script type="text/javascript">
    $(document).ready(function(){
        $("#newSurvey").validate({
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
                encuesta:"required",
                car:"required",
                unidad: "required",
            },
            messages: {
                encuesta:"Campo Requerido.",
                car:"Campo Requerido.",
                unidad: "Campo Requerido.",
            },
            errorClass: "help-inline"
        })
    });
    
</script>


<?
  if(!(isset($_GET['action']) && $_GET['action']=='pesos')) { 
?>
    <!-- Formulario-->
    <div class="well" align="center">
      <p class='muted'><small>Por favor escoja la encuesta que desea importar y el grupo de cargos y unidad asociadas a la nueva encuesta de evaluación.</small></p><br>
      <form id="newSurvey" class="form-horizontal" method="post" action="lib/cImportarEncuesta.php?action=import" >
	  
      <div class="row">
	  <div class="span3"></div>
	  
	  <div class="span4">
	  


	    <div class="control-group">
		<label class="control-label">Encuesta de evaluación</label>
		<div class="controls">
			<select style="width:200px" id="encuesta" name="encuesta" class="select2" data-size="auto">
			    <?
				for ($i=0; $i<count($ENCUESTAS_LS['id_encuesta_ls']); $i++){
				    echo "<option value=".$ENCUESTAS_LS['id_encuesta_ls'][$i].">".$ENCUESTAS_LS['nombre'][$i]."</option>";
				}
			    ?>
			</select>
		</div>
	    </div> 
	    
	    <div class="control-group">
		<label class="control-label">Grupo de cargos</label>
		<div class="controls">
			<select style="width:200px" id="car" name="car" class="select2  car-sel" data-size="auto">
			    <?
				while (list($key, $val) = each($CAR_ID)){
				    echo "<option value=".$key.">".$val."</option>";
				}
			    ?>
			</select>
		</div>
	    </div> 

	  </div> <!--cierre span4-->

      </div> <!--cierre row-->

      <button type="submit" id="confirmButton" class="btn btn-success" >Importar</button>
      <a href="?" class="btn">Cancelar</a>	
      
      </form>      
    </div>
    <div align="center">
      <a href="./vEncuestasLimesurvey.php" class="btn btn-info">Administrar Encuestas de Limesurvey</a>	
    </div>


<?
  } 
include "vFooter.php";
?>
