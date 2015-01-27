<?php
    session_start();
    $Legend = "Cargar CSV";
    if(isset($_GET['id']))
        include "lib/cVerPersona.php";
    else
        include "lib/cAutorizacion.php";
    include "vHeader.php";
    extract($_GET);
    extract($_POST);
    date_default_timezone_set('America/Caracas');
?>  
<script type="text/javascript">
    $(document).ready(function(){
        $("#newOrg").validate({
            submitHandler : function(form) {
                bootbox.dialog('Esta Seguro de continuar?', [{
                         'label':'No',
                         'class':'btn'
                        },
                        {
                         'label':'Si',
                         'class':'btn',
                         'callback':function() {
                                return form.submit();
                         }
                        }]);
            },
            rules:{
                name:"required",
                lname:"required",
                file: "required",
                tel: "required",
                dir: "required",
                email:{
                    required:true,
                    email: true
                },              
            },
            messages: {
                name:"Campo Requerido.",
                lname:"Campo Requerido.",
                file: "Campo Requerido.",
                tel: "Campo Requerido.",
                dir: "Campo Requerido.",
                email:{
                    required:"Campo Requerido",
                    email: "Formato de email incorrecto"
                },   
            },

            //errorClass: "help-inline"

        });
        <? if (isset($_GET['id'])){
            //echo "$('.org-sel').selectpicker('val', '".$LISTA_ROL['Rol']['id_org']['0']."');";
            //echo "$('.fam-sel').selectpicker('val', '".$LISTA_ROL['Rol']['id_fam']['0']."');";
        }
        ?>
    });
</script>
<script>
$(function() {
    $('div.btn-group[data-toggle-name]').each(function() {
        var group = $(this);
        var form = group.parents('form').eq(0);
        var name = group.attr('data-toggle-name');
        var hidden = $('input[name="' + name + '"]', form);
        $('button', group).each(function() {
            var button = $(this);
            button.live('click', function() {
                hidden.val($(this).val());
            });
            if (button.val() == hidden.val()) {
                button.addClass('active');
            }
        });
    });
});
   </script>

<script>
$(document).ready(function() {
   $(":radio[name='BD']").click(function(){
       $("#hideCategory1, #hideCategory2, #hideCategory3, #hideCategory4").hide(); //Show all paragraphs first.
       switch($(this).attr("id")){
          case "Radio1": $("#hideCategory1").show(); break;
          case "Radio2": $("#hideCategory2").show(); break;
          case "Radio3": $("#hideCategory3").show(); break;        
          case "Radio4": $("#hideCategory4").show(); break;        
       }
   });
});
</script>
    <div class="well" align="center">
        <form method="post" enctype="multipart/form-data" id="newOrg" class="form-horizontal" action="lib/cImportarDatos.php">
            <p class="muted">Según la tabla, el archivo debe contar con las siguientes columnas:</p>

            <p class="muted" id="hideCategory1"><small>Primera Fila del Archivo: "Cédula" , "Nombre" , "Teléfono" , "Email"</small></p>
            <p class="muted" id="hideCategory2" hidden><small>Primera Fila del Archivo: "codigo" , "idsup" , "Nombre" (Opcionales: , "Descripción" , "Observaciones")</small></p>
            <p class="muted" id="hideCategory3" hidden><small>Primera Fila del Archivo: "codtno" , "codigo" , "nombre" , "codgra" , "familia" (Opcionales: "clave" , "Descripción" , "funciones")</small></p>
            <p class="muted" id="hideCategory4" hidden><small>Primera Fila del Archivo: "codtno" , "codigo" , "nombre" , "codgra" , "familia" (Opcionales: "clave" , "Descripción" , "funciones")</small></p>

            <div class="row">
            <div class="span2"></div>
            <div class="span4">
            
            <div class="control-group">
                <label class="control-label">Base de Datos</label>
                
                <div class="controls"> 
		  <label class="radio">
		      <input type="radio" name="BD" id="Radio1" value="Per" checked>
			  Persona
		  </label>
		  <label class="radio">
		      <input type="radio" name="BD" id="Radio2" value="Org">
			  Unidad
		  </label>
		  <label class="radio">
		      <input type="radio" name="BD" id="Radio3" value="Car">
			  Cargo
		  </label>
                </div>
                
            </div>

            <div class="control-group ">
                <label class="control-label">Eliminar Cabecera</label>
                <div class="controls">
                        <div class="btn-group" data-toggle-name="cab" data-toggle="buttons-radio" >
                                <button type="button" value="t" class="btn" data-toggle="button">Si</button>
                                <button type="button" value="f" class="btn" data-toggle="button">No</button>
                        </div>
                        <input type="hidden" id="cab" name="cab" value="f" />
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">Archivo CSV <img src='img/iconos/csv-dark.png' border=0 style='margin-left: 2px;' /></label>
                <div class="controls">
                    <input title="Seleccione el Archivo" type="file" class="input-xlarge" name="file" id="file">
                </div>
            </div>

            <div class="control-group">
                <div class="row">
                <div class="span5"></div>
                <div class="span6">
 
                <button type="submit" id="confirmButton" class="btn btn-success" >Cargar</button>

                </div>
                </div>
            </div>
            </div>
            </div>
        </form>
    </div>


<?php
include "vFooter.php";
?>
