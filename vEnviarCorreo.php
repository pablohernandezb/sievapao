<?php
    session_start();
    $all = true;
    $Legend = "Enviar Correo";
    include "lib/cEnviarCorreo.php";
    include "vHeader.php";
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
        $('#example').dataTable( {
          "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "oTableTools": {
            "aButtons": [
              {
                "sExtends": "copy",
                "sButtonText": "Copiar <img src='img/iconos/copy-dark.png' border=0 style='margin-left:2px;'/>"
              },
              {
                "sExtends": "csv",
                "sTitle": "lista_personas",
                "sButtonText": "CSV <img src='img/iconos/csv-dark.png' border=0 style='margin-left:2px;'/>"
              },
              {
                "sExtends": "pdf",
                "sTitle": "lista_personas",
                "sButtonText": "PDF <img src='img/iconos/pdf-dark.png' border=0 style='margin-left:2px;'/>"
              },
              {
                "sExtends": "print",
                "sButtonText": "Imprimir <img src='img/iconos/printer-dark.png' border=0 style='margin-left:2px;'/>"
              },
            ]
          }
          } );
      } );
    </script>
        

<!-- Codigo importante -->
<?php

      if(isAdmin()) {
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Usted no tiene permisos en el sistema para enviar mensajes de correo electrónico masivos.</p><br><br><br><br><br><br>";
      } else {

  ?>
<div class="well" align="center">
      <div class="span11">
        <p class="text-justified muted lsmall"><small>Se le recomienda utilizar el campo de <i>b&uacute;squeda</i> y seleccionar 
            sobre las columnas de su preferencia para seleccionar la(s) persona(s), unidad(es) o el(los) cargo(s) a los cuales desea enviar el correo electrónico .</small>
        </p><br>
      </div>

      <div class="row">
	 <form id="newPer" class="form-horizontal" method="post" action="lib/cEnviarCorreo.php?action=send">
		<input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>
            <div class="span2"></div>
            <div class="span4">

            <div class="control-group">
               <label class="control-label">Destinatario</label>
               <div class="controls">
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-user'></i></span>
                        <input required type="text" class="input-xlarge" id="destinatario" name="destinatario" placeholder="Ingrese correos electrónicos" value="<? if (isset($correo)) echo correo; else echo ''?>">
                  </div>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Asunto</label>
               <div class="controls">
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-envelope'></i></span>
                        <input required type="text" class="input-xlarge" id="asunto" name="asunto" placeholder="Asunto">
                  </div>
               </div>
            </div>

               <div class="control-group">
                  <label class="control-label">Mensaje</label>
                  <div class="controls">
                        <div class="input-prepend">
                           <span class="add-on"><i class="icon-edit"></i></span>
                           <textarea class="input-xlarge" rows="5" id="mensaje" name="mensaje" placeholder="Mensaje"></textarea>
                        </div>
                  </div>
               </div>
            </div>

	 </form>
      </div>
  
<?
    echo "<br><br><div align='center'><button type='submit' id='confirmButton' class='btn btn-success'>Enviar mensaje</button></div>";
?>
         

  </div>
<?php
}//cierra el else

include "vFooter.php";
?>
