<?php
   session_start();
   $Legend = "Datos de persona";
   include "lib/cVerPersona.php";
   include "vHeader.php";
   extract($_GET);
   extract($_POST);
   date_default_timezone_set('America/Caracas');
?>
<style type="text/css">
   @import "css/bootstrap.css";
   @import "css/dataTables.bootstrap.css";
</style>
<!-- <script type="text/javascript" charset="utf-8" src="js/DataTable/js/jquery.js"></script> -->
<script type="text/javascript" charset="utf-8" src="js/DataTable/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8" src="js/DataTools/js/ZeroClipboard.js"></script>
<!--<script type="text/javascript" charset="utf-8" src="js/DataTools/js/TableTools.js"></script>-->
<script type="text/javascript" charset="utf-8" src="js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
   
      $('#example').dataTable( {
          "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "language": {
            "emptyTable": "No se han asignado evaluadores"
          }
      });
      
      $("#newPer").validate({
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
               ced: "required",
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
               ced: "Campo Requerido.",
               tel: "Campo Requerido.",
               dir: "Campo Requerido.",
               email:{
                  required:"Campo Requerido",
                  email: "Formato de email incorrecto"
               },   
            },

            errorClass: "help-inline"

      });

      $("#newSup").validate({
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
               ced: "required",
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
               ced: "Campo Requerido.",
               tel: "Campo Requerido.",
               dir: "Campo Requerido.",
               email:{
                  required:"Campo Requerido",
                  email: "Formato de email incorrecto"
               },   
            },

            errorClass: "help-inline"

      });
      
      $("#newEva").validate({
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
               ced: "required",
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
               ced: "Campo Requerido.",
               tel: "Campo Requerido.",
               dir: "Campo Requerido.",
               email:{
                  required:"Campo Requerido",
                  email: "Formato de email incorrecto"
               },   
            },

            errorClass: "help-inline"

      });
      
      $("#updateEva").validate({
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
               ced: "required",
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
               ced: "Campo Requerido.",
               tel: "Campo Requerido.",
               dir: "Campo Requerido.",
               email:{
                  required:"Campo Requerido",
                  email: "Formato de email incorrecto"
               },   
            },

            errorClass: "help-inline"

      });

      $("#newCar").validate({
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
               ced: "required",
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
               ced: "Campo Requerido.",
               tel: "Campo Requerido.",
               dir: "Campo Requerido.",
               email:{
                  required:"Campo Requerido",
                  email: "Formato de email incorrecto"
               },   
            },

            errorClass: "help-inline"

      });

      <?  if (isset($_GET['id'])){
               echo "$('.org-sel').select2('val', '".$LISTA_PER['Per']['unidad']['0']."');";
            }

            if (isset($LISTA_PER_CAR) && $LISTA_PER_CAR['max_res']>0){
               echo "$('.car-sel').select2('val', '".$LISTA_PER_CAR['Per_Car']['id_car']['0']."');";
            }

            if (isset($LISTA_PER_SUP) && $LISTA_PER_SUP['max_res']>0){
               echo "$('.sup-sel').select2('val', '".$LISTA_PER_SUP['Per_Sup']['id_sup']['0']."');";
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

<div class="tabbable"> <!-- Only required for left/right tabs -->
<ul class="nav nav-tabs">
   <li class="<? if(!(isset($_GET['tab'])) || ($_GET['tab'])==1 ) echo'active'?>"><a href="#tab1" data-toggle="tab">Persona</a></li>
   <li class="<? if(($_GET['tab'])==2 ) echo'class=active'?>"><a href="#tab2" data-toggle="tab">Cargo</a></li>
   <li class="<? if(($_GET['tab'])==3 ) echo'class=active'?>"><a href="#tab3" data-toggle="tab">Evaluador</a></li>
   <li class="<? if(($_GET['tab'])==4 ) echo'class=active'?>"><a href="#tab4" data-toggle="tab">Supervisor Jerárquico</a></li>
</ul>
<div class="tab-content">
   <div class="tab-pane <? if(!(isset($_GET['tab']))) echo'active'?>" id="tab1">
      <!-- Formulario primera pestaña, Crear Persona-->
      <div class="well" align="center">
      <form id="newPer" class="form-horizontal" method="post" 
            <?  if (isset($_GET['action']) && $_GET['action']=='edit') echo 'action="lib/cPersona.php?action=edit&id='.$_GET['id'].'"'; 
               else echo 'action="lib/cPersona.php?action=add"' ?> >
            <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
            <div class="row">
            <div class="span2"></div>
            <div class="span4">
            <div class="control-group">
               <label class="control-label">Nombre</label>
               <div class="controls">
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-user's></i></span>
                        <input required type="text" class="input-xlarge" id="name" name="name" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['nombre']['0']; ?>" placeholder="Nombre" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                  </div>
               
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Apellido</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        <input  required  type="text" class="input-xlarge" id="lname" name="lname" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['apellido']['0'];?>" placeholder="Apellido" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                  </div>
               </div>
            </div>
            <div class="control-group ">
               <label class="control-label">C&eacute;dula</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-th-list"></i></span>
                        <input  required  id="ced" name="ced" type="text" class="input-xlarge bfh-phone" data-format="dddddddd" data-number="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['cedula']['0'];?>" placeholder="12345678" <? if (isset($_GET['view'])) echo 'disabled'; ?>>
                  </div>
               </div>
            </div>
            <div class="control-group ">
               <label class="control-label">G&eacute;nero</label>
               <div class="controls">
                        <div class="btn-group" data-toggle-name="sex" data-toggle="buttons-radio" >
                           <?
                           if (isset($_GET['view'])) {
                              switch ($LISTA_PER['Per']['sexo']['0']) {
                                    case 'F':
                                       echo "
                              <button type='button' value='F' disabled class='btn data-toggle='button'>Femenino</button>
                                          ";
                                       break;
                                    case 'M':
                                       echo "
                              <button type='button' value='M' disabled class='btn data-toggle='button'>Masculino</button>
                                          ";
                                       break;
                                    default:
                                       break;
                              }

                           } else {
                           echo "
                              <button type='button' value='F' class='btn data-toggle='button'>Femenino</button>
                              <button type='button' value='M' class='btn data-toggle='button'>Masculino</button>
                           ";
                           }
                           ?>
                        </div>
                        <input type="hidden" id="sex" name="sex" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['sexo']['0']; else echo "F"?>" />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Email</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input type="email" required class="input-xlarge" id="email" name="email" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['email']['0'];?>" placeholder="Direcci&oacute;n de Correo" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Unidad adscrita</label>
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
            <?
               if (isset($_GET['id'])) {
                  echo "
            <div class='control-group'>
               <label class='control-label'>Sede</label>
               <div class='controls'>
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-comment'></i></span>
                        <input  type='text' class='input-xlarge' value='".$sede."' disabled>
                  </div>
               </div>
            </div>
                        ";
               }
            ?>
            <div class="control-group ">
               <label class="control-label">Tipo personal</label>
               <div class="controls">
                        <div class="btn-group" data-toggle-name="tipo" data-toggle="buttons-radio" >
                           <?
                           if (isset($_GET['view'])) {
                              switch ($LISTA_PER['Per']['tipo']['0']) {
                                    case '1':
                                       echo "
                              <button type='button' value='1' disabled class='btn data-toggle='button'>Académico</button>
                                          ";
                                       break;
                                    case '2':
                                       echo "
                              <button type='button' value='2' disabled class='btn data-toggle='button'>Administrativo</button>
                                          ";
                                       break;
                                    case '3':
                                       echo "
                              <button type='button' value='3' disabled class='btn data-toggle='button'>Obrero</button>
                                          ";
                                       break;
                                    case '4':
                                       echo "
                              <button type='button' value='4' disabled class='btn data-toggle='button'>Otro</button>
                                          ";
                                       break;
                                    default:
                                       break;
                              }

                           } else {
                           echo "
                              <button type='button' value='1' class='btn data-toggle='button'>Académico</button>
                              <button type='button' value='2' class='btn data-toggle='button'>Administrativo</button>
                              <button type='button' value='3' class='btn data-toggle='button'>Obrero</button>
                              <button type='button' value='4' class='btn data-toggle='button'>Otro</button>
                           ";
                           }
                           ?>
                        </div>
                        <input type="hidden" id="tipo" name="tipo" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['tipo']['0']; else echo "1"?>" />
               </div>
            </div>
            
            
            <div class="control-group ">
               <label class="control-label">Activo</label>
               <div class="controls">
                        <div class="btn-group" data-toggle-name="activo" data-toggle="buttons-radio" >
                           <?
                           if (isset($_GET['view'])) {
                              switch ($LISTA_PER['Per']['activo']['0']) {
                                    case 't':
                                       echo "
                              <button type='button' value='t' disabled class='btn data-toggle='button'>Activo</button>
                                          ";
                                       break;
                                    case 'f':
                                       echo "
                              <button type='button' value='f' disabled class='btn data-toggle='button'>No Activo</button>
                                          ";
                                       break;
                                    default:
                                       break;
                              }

                           } else {
                           echo "
                              <button type='button' value='t' class='btn data-toggle='button'>Activo</button>
                              <button type='button' value='f' class='btn data-toggle='button'>No Activo</button>
                           ";
                           }
                           ?>
                        </div>
                        <input type="hidden" id="activo" name="activo" value="<? if(isset($_GET['id'])) echo $LISTA_PER['Per']['activo']['0']; else echo "t"?>" />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Rol</label>
               <div class="controls">
                  <select style="width:200px" id="rol" name="rol" class="select2 show-tick org-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
			<?
			if (isset($_GET['view'])) {
			    switch ($LISTA_PER['Per']['rol']['0']) {
				case '1':
					echo "<option value=1>Apoyo</option>";
					break;
				case '2':
					echo "<option value=2>Operativas</option>";
					break;
				case '3':
					echo "<option value=3>Supervisorio Administrativo</option>";
					break;
				case '4':
					echo "<option value=4>Obrero</option>";
					break;
				case '5':
					echo "<option value=5>Supervisorio Obrero</option>";
					break;
				default:
					break;
			     }
			} else {
                       
                           while (list($key, $val) = each($ROL_ID)){
			      if($LISTA_PER['Per']['rol']['0']==$key) {
				   echo "<option selected value=".$key.">".$val."</option>";
		    	      } else {
				   echo "<option value=".$key.">".$val."</option>";
			      } 
                           }
			}
                        ?>
                  </select>
		
               </div>
            </div>            

            <div class="control-group">
               <label class="control-label">Condiciones</label>
               <div class="controls">
                  <select style="width:200px" id="condicion" name="condicion" class="select2 show-tick org-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
			<?
			if (isset($_GET['view'])) {
			    switch ($LISTA_PER['Per']['condicion']['0']) {
				case '0':
					echo "<option value=0>Ninguno</option>";
					break;
				case '1':
					echo "<option value=1>Reposo Medico</option>";
					break;
				case '2':
					echo "<option value=2>Permiso Pre y Post</option>";
					break;
				case '3':
					echo "<option value=3>Averiguaciones Administrativas</option>";
					break;
				case '4':
					echo "<option value=4>Proceso Disciplinario</option>";
					break;
				case '5':
					echo "<option value=5>Jubilado</option>";
					break;
				case '6':
					echo "<option value=6>Pensionado</option>";
					break;
				case '7':
					echo "<option value=7>Permiso No Remunerado</option>";
					break;
				case '8':
					echo "<option value=8>Permiso Remunerado</option>";
					break;
				default:
					break;
			     }
			} else {
                       
                           while (list($key, $val) = each($CON_ID)){
			      if($LISTA_PER['Per']['condicion']['0']==$key) {
				   echo "<option selected value=".$key.">".$val."</option>";
		    	      } else {
				   echo "<option value=".$key.">".$val."</option>";
			      } 
                           }
			}
                        ?>
                  </select>
		
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Secci&oacute;n</label>
               <div class="controls">
                  <select style="width:200px" id="seccion" name="seccion" class="select2 show-tick org-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                        <?
                           while (list($key, $val) = each($ORG_ID)){
                              echo "<option value=".$key.">".$val."</option>";
                           }
                        ?>
                  </select>
               </div>
            </div>
            
            <div class="control-group">
                  <div class="row">
                  <div class="span5"></div>
                  <div class="span6">
                  <p>
                  <a class="btn btn-info" href="vListarPersonas.php">Listar Personas</a>
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
   </div>
   <div class="tab-pane <? if(($_GET['tab'])==2 ) echo'active'?>" id="tab2">

   <!-- Formulario segunda pestaña, Asociar Persona Cargo-->
   <div class="well" align="center">
      <form id="newCar" class="form-horizontal" method="post" action="lib/cPersona.php?action=add_car" >
            <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
            <div class="row">
            <div class="span2"></div>
            <div class="span4">

            <?

            if (isset($_GET['action']) && $_GET['action'] == "edit"){

               if(isset($LISTA_PER_CAR) && $LISTA_PER_CAR['max_res']>0 && $LISTA_PER_CAR['Per_Car']['id_car']['0']!=0){
                  echo "
            <p class='lsmall muted'>Al cambiar el cargo es necesario guardar la fecha fin del cargo anterior, nombre y fecha del nuevo cargo. Por defecto aparece la fecha actual.</p>
            <div class='control-group'>
               <label class='control-label'>Fecha Fin viejo cargo</label>
               <div class='controls'>
                  <div class='input-prepend date datepicker'".date('d-m-Y')."' data-date-language='es' data-date-today-Btn='true' data-date-start-View='2' data-date-today-Highlight='true' data-date-autoclose='true' data-date-format='dd-mm-yyyy'>
                        <span class='add-on'><i class='icon-calendar'></i></span>
                        <input size='12' id='fin' name='fin' class='input-xlarge' type='text' value='".date('d-m-Y')."' readonly>
                  </div>
               </div>
            </div>
                  ";
               }

            }
            ?>

            <div class="control-group">
               <label class="control-label">Nuevo Cargo</label>
               <div class="controls">
                        <select style="width:200px" id="car" name="car" class="select2  car-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                           <?
                              while (list($key, $val) = each($CAR_ID)){
                                    echo "<option value=".$key.">".$val."</option>";
                              }
                           ?>
                        </select>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Fecha Inicio Nuevo Cargo</label>
               <div class="controls">
                  <div class="input-prepend date datepicker" data-date="<? echo date("d-m-Y") ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <input size="12" id="fech" name="fech" class="input-xlarge" type="text" value="<? echo date("d-m-Y") ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                  </div>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Observaci&oacute;n</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="obs" name="obs" placeholder="Observaciones"<? if (isset($_GET['view'])) echo 'disabled' ?>><? if(isset($LISTA_PER_CAR) && $LISTA_PER_CAR['max_res']>0) echo $LISTA_PER_CAR['Per_Car']['observacion']['0'];?></textarea>
                  </div>
               </div>
            </div>
            
            </div>
         </div>
         
         <div class="control-group">
            <div class="row">
               <div class="span2"></div>
               <div class="span6">
                  <p>
                  <a class="btn btn-info" href="vListarPersonas.php">Listar Personas</a>
                  <?                         
                     if (isset($_GET['id']) & !isset($_GET['view'])) {
                        echo '<a class="btn btn-info" href="vListarCargosPersona.php?id='.$_GET["id"].'">Histórico</a>
			      <a href="?view&id='.$_GET['id'].'&tab=2" class="btn">Cancelar</a>
                              <button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>';
                         
                     }else if (isset($_GET['id']) & isset($_GET['view'])){
                        echo '<a href="?action=edit&id='.$_GET['id'].'&tab=2" class="btn btn-warning">Editar</a>' ;
                     } else{
			// <a class="btn btn-info" href="vListarCargosPersona.php?id='.$_GET["id"].'">Histórico</a>
                        echo '<a href="?view&id='.$_GET['id'].' class="btn">Cancelar</a>
                              <button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>';

                     }
                  ?>
                  </p>
               </div>
            </div>   
         </div>
      </form>
      
   </div>
      
   </div>
   
   
   <div class="tab-pane <? if(($_GET['tab'])==3 ) echo'active'?>" id="tab3">
   
   <!-- Formulario tercera pestaña, Asociar Evaluador a Persona-->
   <?php
      if (isset($_GET['action']) && $_GET['action']=='try'){
   ?>
   <!-- Formulario Nuevo Evaluador-->
   <div class="well" align="center">
      <form id="newEva" class="form-horizontal" method="post" action="lib/cPersona.php?action=add_eval" >
      <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
      <div class="row">
         <div class="span2"></div>
         <div class="span4">
            <div class="control-group">
               <label class="control-label">Evaluador</label>
               <div class="controls">
                        <select style="width:200px" id="eval" name="eval" class="select2" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                           <?
                              while (list($key, $val) = each($EVA_ID)){
                                    echo "<option value=".$key.">".$val."</option>";
                              }
                              reset($EVA_ID);
                           ?>
                        </select>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Fecha Inicio del Evaluador</label>
               <div class="controls">
                  <div class="input-prepend date datepicker" data-date="<? echo date("d-m-Y") ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <input size="12" id="fech" name="fech" class="input-xlarge" type="text" value="<? echo date("d-m-Y") ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                  </div>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Observaci&oacute;n</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="obs" name="obs" placeholder="Observaciones"<? if (isset($_GET['view'])) echo ' disabled' ?>></textarea>
                  </div>
               </div>
            </div>
            
            <div class="control-group">
               <div class="row">
                  <div class="span5"></div>
                  <div class="span6">
                  <p>
                  <a class="btn btn-info" href="vListarPersonas.php">Listar Personas</a>
                  <?                         
                     if (isset($_GET['id']) & !isset($_GET['view'])) {
                        echo '<a class="btn btn-info" href="vListarEvaluadoresPersona.php?id='.$_GET["id"].'">Histórico</a>
                              <a class="btn" href="?action=edit&id='.$_GET['id'].'&tab=3" >Cancelar</a>
                              <button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>';
                     }else if (isset($_GET['id']) & isset($_GET['view'])){
                        echo '<a class="btn btn-info" href="vListarEvaluadoresPersona.php?id='.$_GET["id"].'">Histórico</a>
                              <a href="?action=try&id='.$_GET['id'].'&tab=3" class="btn btn-warning">Editar</a>' ;
                     } else{
                        echo '<button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>
                              <a href="?action=edit&id='.$_GET['id'].'&tab=3" class="btn">Cancelar</a>';
                     }
                  ?>
                  </p>
                  </div>
               </div>   
            </div>
         </div>
      </div>
      </form>
   </div>
   
   </div>
   
   <?php
      } elseif (isset($_GET['action']) && $_GET['action']=='update_eval'){
   ?>
   <!-- Formulario Modificar Evaluador-->
   <div class="well" align="center">
      <form id="updateEva" class="form-horizontal" method="post" action="lib/cPersona.php?action=set_eval" >
         <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
         <input type="hidden" id="id_eva" name="id_eva" value="<? echo $LISTA_PER_EVA['Per_Eva']['id_eva'][$_GET["nro_eva"]]; ?>"/>
         <div class="row">
         <div class="span2"></div>
         <div class="span4">
            
            <div class="control-group">
               <label class="control-label">Evaluador</label>
               <div class="controls">
                        <select style="width:200px" id="eval" name="eval" class="select2  eva-sel" data-size="auto" disabled>
                           <?
                              while (list($key, $val) = each($EVA_ID)){
                                 $selected = ($key ==  $LISTA_PER_EVA['Per_Eva']['id_eva'][$_GET["nro_eva"]]) ? " selected='selected'" : ""; 
                                 echo "<option value=".$key."".$selected.">".$val."</option>";
                              }
                              reset($EVA_ID);
                           ?>
                        </select>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Fecha Inicio del Evaluador</label>
               <div class="controls">
                  <div class="input-prepend date datepicker" data-date="<? echo $LISTA_PER_EVA['Per_Eva']['fecha_ini'][$_GET["nro_eva"]] ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <input size="12" id="fecha_ini" name="fecha_ini" class="input-xlarge" type="text" value="<? echo $LISTA_PER_EVA['Per_Eva']['fecha_ini'][$_GET["nro_eva"]] ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                  </div>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Fecha Fin del <br>Evaluador</label>
               <div class="controls">
                  <div class="input-prepend date datepicker" data-date="<? echo $LISTA_PER_EVA['Per_Eva']['fecha_fin'][$_GET["nro_eva"]] ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <input size="12" id="fecha_fin" name="fecha_fin" class="input-xlarge" type="text" value="<? echo $LISTA_PER_EVA['Per_Eva']['fecha_fin'][$_GET["nro_eva"]] ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                  </div>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Observaci&oacute;n</label>
               <div class="controls">
                  <div class="input-prepend">
                        <span class="add-on"><i class="icon-edit"></i></span>
                        <textarea class="input-xlarge" rows="3" id="obs" name="obs" placeholder="Observaciones"><? echo $LISTA_PER_EVA['Per_Eva']['observacion'][$_GET["nro_eva"]] ?></textarea>
                  </div>
               </div>
            </div>
             
            <div class="control-group">
               <div class="row">
                  <div class="span5"></div>
                  <div class="span6">
                     <p>                     
                        <button class="btn" type="reset">Borrar</button>
                        <a class="btn" href="?action=edit&id=<?echo $_GET['id']?>&tab=3" >Cancelar</a>
                        <button type="submit" id="confirmButton" class="btn btn-success">Registrar</button>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         </div>   
      </form>
   </div>
   
   </div>
   
   <?php
      } elseif (isset($_GET['action']) && $_GET['action']=='remove_eval'){
   ?>
   <!-- Formulario Remover Evaluador-->
   <div class="well" align="center">
      <form id="removeEva" class="form-horizontal" method="post" action="lib/cPersona.php?action=remove_eval" >
         <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
         <input type="hidden" id="id_eva" name="id_eva" value="<? echo $LISTA_PER_EVA['Per_Eva']['id_eva'][$_GET["nro_eva"]]; ?>"/>
         
         <div class="row">
            <div class="span9">
               <p class="text-center muted lsmall">
                  <strong style="color:#06F">Nota:</strong> 
                  <small>
                     Al remover un evaluador, es necesario asignar la fecha de finalización correspondiente.
                  </small>
               </p>
            </div>
         </div>
         <div class="row">
         <div class="span2"></div>
         <div class="span4">
            
            <div class="control-group">
               <label class="control-label">Evaluador</label>
               <div class="controls">
                        <select style="width:200px" id="eval" name="eval" class="select2  eva-sel" data-size="auto" disabled>
                           <?
                              while (list($key, $val) = each($EVA_ID)){
                                 $selected = ($key ==  $LISTA_PER_EVA['Per_Eva']['id_eva'][$_GET["nro_eva"]]) ? " selected='selected'" : ""; 
                                 echo "<option value=".$key."".$selected.">".$val."</option>";
                              }
                              reset($EVA_ID);
                           ?>
                        </select>
               </div>
            </div>
            
            <div class="control-group">
               <label class="control-label">Fecha Fin del <br>Evaluador</label>
               <div class="controls">
                  <div class="input-prepend date datepicker" data-date="<? echo date("d-m-Y") ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                        <span class="add-on"><i class="icon-calendar"></i></span>
                        <input size="12" id="fecha_fin" name="fecha_fin" class="input-xlarge" type="text" value="<? echo date("d-m-Y") ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                  </div>
               </div>
            </div>
             
            <div class="control-group">
               <div class="row">
                  <div class="span5"></div>
                  <div class="span6">
                     <p>
                        <a class="btn" href="?action=edit&id=<?echo $_GET['id']?>&tab=3" >Cancelar</a>
                        <button type="submit" id="confirmButton" class="btn btn-success">Aceptar</button>
                     </p>
                  </div>
               </div>
            </div>
         </div>
         </div>   
      </form>
   </div>
   
   </div>
 
   <?php
      } else {
   ?>
   <!-- Inicio Nuevo Codigo Listar Evaluadores-->
   <div class="well span9 offset1">
      <div class="row">
         <div class="span9">
            <p class="text-center muted lsmall"><strong style="color:#06F">Sugerencia:</strong> <small>Se le recomienda utilizar el campo de "B&uacute;squeda" y seleccionar 
               sobre las columnas de su preferencia para organizar las entidades en forma ascendente o descendente. Si desea ordenarlo en 
               funci&oacute;n a m&aacute;s de un campo, debe presionar la tecla "SHIFT" y darle a la(s) columnas.</small>
            </p>
         </div>
      </div>
       
      <div id="demo">
         <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
         <thead>
            <tr>
               <th class="lsmallT"><small>Evaluadores Actuales</small></th>
               <th class="lsmallT"><small>Inicio</small></th>
               <th class="lsmallT"><small>Fin</small></th>
               <th class="lsmallT"><small>Observaciones</small></th>
               <? if (isset($_GET['action']) && $_GET['action'] == "edit"){ ?>
                  <th class="lsmallT"><small>Acciones</small></th>
               <? } ?>
            </tr>
         </thead>
         <tfoot>
            <tr>
               <th class="lsmallT"><small>Evaluadores Actuales</small></th>
               <th class="lsmallT"><small>Inicio</small></th>
               <th class="lsmallT"><small>Fin</small></th>
               <th class="lsmallT"><small>Observaciones</small></th>
               <? if (isset($_GET['action']) && $_GET['action'] == "edit"){ ?>
                  <th class="lsmallT"><small>Acciones</small></th>
               <? } ?>
            </tr>
         </tfoot>
         <tbody role="alert" aria-live="polite" aria-relevant="all">
         <?
            for ($i=0;$i<$LISTA_PER_EVA['max_res'];$i++){
         ?>
            <tr class="<?php echo $color_tabla; ?>" >
            <td class="center lsmallT" nowrap><small><a href='vPersona.php?view&id=<? echo $LISTA_PER_EVA['Per_Eva']['id_eva'][$i];?>'> <? echo $EVA_ID[$LISTA_PER_EVA['Per_Eva']['id_eva'][$i]];?></a> </small></td>
            <td class="center lsmallT"><small><? echo $LISTA_PER_EVA['Per_Eva']['fecha_ini'][$i];?></small></td>
            <td class='center lsmallT'><small><? echo $LISTA_PER_EVA['Per_Eva']['fecha_fin'][$i];?></small></td>
            <td class='center lsmallT'><small><? echo $LISTA_PER_EVA['Per_Eva']['observacion'][$i];?></small></td>
            <? if (isset($_GET['action']) && $_GET['action'] == "edit"){ ?>
            <td class='center lsmallT'>
               <a href="?action=update_eval&id=<?echo $_GET['id']?>&nro_eva=<?echo $i?>&tab=3" title="Editar Evaluador" >
                  <img src="./img/iconos/edit-16.png" style="margin-left:5px;">
               </a>
               <a href="?action=remove_eval&id=<?echo $_GET['id']?>&&nro_eva=<?echo $i?>&tab=3" title="Remover Evaluador" >
                  <img src="./img/iconos/delete-16.png" style="margin-left:5px;">
               </a>
            </td>
            <? } ?>
            </tr>
          <? } ?>     
         </tbody>
         </table>
      </div>

      <div class="row">
         <div class="span3"></div>
         <div class="span4">
            <div class="control-group">
               <? 
                  if (isset($_GET['action']) && $_GET['action'] == "edit"){
                     echo '<a href="?action=try&id='.$_GET['id'].'&tab=3" class="btn btn-success">Agregar Nuevo Evaluador</a>';
                  }
               ?>
            </div>
         </div>
      </div>
   </div>
   <div class="well" align="center">
      <div class="row">
         <div class="span3"></div>
         <div class="span5">
            <p>
               <a class="btn btn-info" href="vListarPersonas.php">Listar Personas</a>
               <a class="btn btn-info" href="vListarEvaluadoresPersona.php?id=<?echo $_GET["id"]?>">Histórico</a>
               <?                         
                  if (isset($_GET['id']) & isset($_GET['view'])){
                     echo '<a class="btn btn-warning" href="?action=edit&id='.$_GET['id'].'&tab=3">Editar</a>' ;
                  }
               ?>
            </p>
         </div>
      </div>
   </div>
   <!-- Fin Nuevo Codigo Listar Evaluadores-->
   </div>
   
   <?php
      }//cierra el else
   ?>

      <div class="tab-pane <? if(($_GET['tab'])==4 ) echo'active'?>" id="tab4">
      <!-- Formulario cuarta pestaña, Asociar Supervisor a Persona-->
         <div class="well" align="center">
            <form id="newSup" class="form-horizontal" method="post" action="lib/cPersona.php?action=add_sup" >
               <input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
               <div class="row">
               <div class="span2"></div>
               <div class="span4">
         
            <?
            if (isset($_GET['action']) && $_GET['action'] == "edit"){
            
               
               if(isset($LISTA_PER_SUP) && $LISTA_PER_SUP['max_res']>0 && $LISTA_PER_SUP['Per_Sup']['id_sup']['0']!=0){
                  echo "
            <p class='lsmall muted'>Al cambiar el supervisor es necesario guardar la fecha fin del supervisor anterior, nombre y fecha del nuevo supervisor. Por defecto aparece la fecha actual.</p>
            <div class='control-group'>
               <label class='control-label'>Fecha Fin antiguo Supervisor</label>
               <div class='controls'>
                  <div class='input-prepend date datepicker'".date('d-m-Y')."' data-date-language='es' data-date-today-Btn='true' data-date-start-View='2' data-date-today-Highlight='true' data-date-autoclose='true' data-date-format='dd-mm-yyyy'>
                        <span class='add-on'><i class='icon-calendar'></i></span>
                        <input size='12' id='fin' name='fin' class='input-xlarge' type='text' value='".date('d-m-Y')."' readonly>
                  </div>
               </div>
            </div>
                  ";
               }
            }
            ?>
            
            
            <div id="area-supervisores">
            
               <div id="bloque-supervisor" class="bloque-supervisor">
               
               <div class="control-group">
                  <label class="control-label">Supervisor Jerárquico</label>
                  <div class="controls">
                           <select style="width:200px" id="sup" name="sup" class="select2 sup-sel" data-size="auto" <? if (isset($_GET['view'])) echo 'disabled' ?>>
                              <?
                                    while (list($key, $val) = each($SUP_ID)){
                                       echo "<option value=".$key.">".$val."</option>";
                                    }
                                    reset($SUP_ID);
                              ?>
                           </select>
                  </div>
               </div>
               
               <div class="control-group">
                  <label class="control-label">Fecha Inicio del Supervisor</label>
                  <div class="controls">
                     <div class="input-prepend date datepicker" data-date="<? echo date("d-m-Y") ?>" data-date-language="es" data-date-today-Btn="true" data-date-start-View="2" data-date-today-Highlight="true" data-date-autoclose="true" data-date-format="dd-mm-yyyy">
                     <span class="add-on"><i class="icon-calendar"></i></span>
                     <input size="12" id="fecha_sup" name="fecha_sup" class="input-xlarge" type="text" value="<? echo date("d-m-Y") ?>" <? if (isset($_GET['view'])) echo 'disabled' ?>  readonly>
                     </div>
                  </div>
               </div>
               
               <div class="control-group">
                  <label class="control-label">Observaci&oacute;n</label>
                  <div class="controls">
                        <div class="input-prepend">
                           <span class="add-on"><i class="icon-edit"></i></span>
                           <textarea class="input-xlarge" rows="3" id="obs_sup" name="obs_sup" placeholder="Observaciones"<? if (isset($_GET['view'])) echo ' disabled' ?>><? if(isset($LISTA_PER_SUP) && $LISTA_PER_SUP['max_res']>0) echo $LISTA_PER_SUP['Per_Sup']['observacion']['0'];?></textarea>
                        </div>
                  </div>
               </div>

               </div>
            </div>
            
               <div class="control-group">
                        <div class="row">
                        <div class="span5"></div>
                        <div class="span6">
                        <p>
                        <a class="btn btn-info" href="vListarPersonas.php">Listar Personas</a>
                        <?                         
                           if (isset($_GET['id']) & !isset($_GET['view'])) {
                              echo '<a class="btn btn-info" href="vListarSupervisoresPersona.php?id='.$_GET["id"].'">Histórico</a>
                                    <input class="btn" type="reset" value="Borrar">
                                    <button type="submit" id="confirmButton" class="btn btn-success" >Registrar</button>';
                           }else if (isset($_GET['id']) & isset($_GET['view'])){
                              echo '<a class="btn btn-info" href="vListarSupervisoresPersona.php?id='.$_GET["id"].'">Histórico</a>
                                    <a href="?action=edit&id='.$_GET['id'].'&tab=4" class="btn btn-warning">Editar</a>' ;
                           } else{
                              echo '<button type="submit" id="confirmButton" class="btn btn-success" disabled>Registrar</button>';
                              echo ' Debe registrar una Persona';
                           }
                        ?>
                        </p>
                        </div>
                        </div>
               </div>
            </div>

            </div>

      </form>

   </div>
   </div>
</div>
</div>

<?php
include "vFooter.php";
?>
