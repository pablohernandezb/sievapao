<?php
    session_start();
    $Legend = "Datos de Grupo de Cargo";
    include "lib/cVerFamiliaC.php";
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
                name:"required"
            },
            messages: {
                name:"Campo Requerido."
            },

            errorClass: "help-inline"

        });
    });
</script>

    <div class="well" align="center">
        <form id="newOrg" class="form-horizontal" method="post" 
            <?  if (isset($_GET['action']) && $_GET['action']=='edit') echo 'action="lib/cFamiliaC.php?action=edit&id='.$_GET['id'].'"'; 
                else echo 'action="lib/cFamiliaC.php?action=add"' ?> >
            <div class="row">
            <div class="span2"></div>
            <div class="span4">
            <div class="control-group">
                <label class="control-label">Nombre de los Grupos de Cargos</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-briefcase"></i></span>
                        <input type="text" class="input-xlarge" id="name" name="name" value="<? if(isset($_GET['id'])) echo $LISTA_ORG['Fc']['nombre']['0'];?>" placeholder="Grupo de Cargos" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Descripci&oacute;n</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="desc" name="desc" placeholder="Descripci&oacute;n" <? if (isset($_GET['view'])) echo 'disabled' ?>><? if(isset($_GET['id'])) echo $LISTA_ORG['Fc']['descripcion']['0'];?></textarea>
                    </div>
                </div>
            </div>
            <div class="control-group">
                    <div class="row">
                    <div class="span9">
                    <p>
                    <a class="btn btn-info" href="vListarFamiliaC.php">Listar Grupo de Cargos</a>
                    <?  if (isset($_GET['view'])) 
                            echo '<a href="?action=edit&id='.$_GET['id'].'" class="btn btn-warning">Editar</a>' ;
                        else 
                            echo '<input class="btn" type="reset" value="Borrar">
                                  <button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>';
                    ?>
                    </p>
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
