<?php
    session_start();
    $Legend = "Datos de la Unidad";
    include "lib/cVerOrganizacion.php";
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
                oname:"required",
                sup: "required",
                cod: "required",
                desc: "required",
                obs: "required"
            },
            messages: {
                oname:"Campo Requerido.",
                sup: "Campo Requerido.",
                cod: "Campo Requerido.",
                desc: "Campo Requerido.",
                obs: "Campo Requerido."
            },

            errorClass: "help-inline"

        });
        <? if (isset($_GET['id']))
            echo "$('.org-sel').select2('val', '".$LISTA_ORG['Org']['idsup']['0']."');";
        ?>
    });
</script>

    <div class="well" align="center">
        <form id="newOrg" class="form-horizontal" method="post" 
            <?  if (isset($_GET['action']) && $_GET['action']=='edit') echo 'action="lib/cOrganizacion.php?action=edit&id='.$_GET['id'].'"'; 
                else echo 'action="lib/cOrganizacion.php?action=add"' ?> >
            <div class="row">
            <div class="span2"></div>
            <div class="span4">
            <div class="control-group">
                <label class="control-label">Nombre Unidad</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-briefcase"></i></span>
                        <input type="text" class="input-xlarge" id="oname" name="oname" value="<? if(isset($_GET['id'])) echo $LISTA_ORG['Org']['nombre']['0'];?>" placeholder="Unidad" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Entidad Superior</label>
                <div class="controls">
                        <select style="width:200px" id="org" name="org" class="select2 show-tick org-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                            <?
                                while (list($key, $val) = each($ORG_ID)){
                                    echo "<option value=".$key.">".$val."</option>";
                                }
                            ?>
                        </select>
                </div>
            </div>

            <div class="control-group ">
                <label class="control-label">C&oacute;digo</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-th-list"></i></span>
                        <input type="text" class="input-xlarge" id="cod" name="cod" value="<? if(isset($_GET['id'])) echo $LISTA_ORG['Org']['codigo']['0'];?>" placeholder="C&oacute;digo" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Descripci&oacute;n</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="desc" name="desc" placeholder="Descripci&oacute;n" <? if (isset($_GET['view'])) echo 'disabled' ?>><? if(isset($_GET['id'])) echo $LISTA_ORG['Org']['descripcion']['0'];?></textarea>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Observaci&oacute;n</label>
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="obs" name="obs" placeholder="Observaciones"<? if (isset($_GET['view'])) echo 'disabled' ?>><? if(isset($_GET['id'])) echo $LISTA_ORG['Org']['observacion']['0'];?></textarea>
                    </div>
                </div>
            </div>

            <div class="control-group">
                    <div class="row">
                    <div class="span5"></div>
                    <div class="span6">
                    <p>
                    <a class="btn btn-info" href="vListarUnidades.php">Listar Unidades</a>
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
