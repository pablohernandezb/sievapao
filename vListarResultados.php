<?php
    session_start();
    $all = true;
    $Legend = "Listar Resultados";
    include "lib/cListarResultados.php";
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

  if (count($LISTA_RES)==0){
      if(!isAdmin())
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay persona registrada.</p><br><br><br><br><br><br>";
      else
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay persona registrada.</p><br><br><br><br><br><br>";
  }else{
  ?>
  <div class="well span11">

    <div class="row">
      <div class="span11">
        <p class="text-justified muted lsmall"><small>Se le recomienda utilizar el campo de <i>b&uacute;squeda</i> y seleccionar 
            sobre las columnas de su preferencia para organizar las entidades en forma ascendente o descendente. Si desea ordenarlo en 
            funci&oacute;n a m&aacute;s de un campo, debe presionar la tecla <i>SHIFT</i> y hacer click en la(s) columna(s) correspondiente(s).</small>
        </p><br>
      </div>

    </div>
       
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Unidad de Adscripci&oacute;n</small></th>
      <th class="lsmallT"><small>Rol</small></th> ?>
      <th class="lsmallT"><small>ID</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Unidad de Adscripci&oacute;n</small></th>
      <th class="lsmallT"><small>Rol</small></th> ?>
      <th class="lsmallT"><small>ID</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<count($LISTA_RES['cedula']);$i++){
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_RES['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_RES['nombre'][$i] ?></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_RES['unidad'][$i]?></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_RES['rol'][$i]?></small></td>
	  <td class="center lsmallT"><small><? echo $LISTA_RES['id'][$i]?>%</small></td>
          <td class="center lsmallT" nowrap><a href='./vResultados.php?token_ls=<? echo $LISTA_RES["token"][$i];?>' title='Ver resultados'><img src='./img/iconos/visible-16.png' style=' margin-left:5px;'></a></td>
          </tr>
          <? } ?>     
        </tbody>
</table>
</div>
  </div>
<?php
}//cierra el else

include "vFooter.php";
?>
