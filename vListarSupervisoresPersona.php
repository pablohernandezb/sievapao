<?php
    session_start();
    $Legend = "Historial de Supervisores";
    include "lib/cVerSupervisoresPersona.php";
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
                "sButtonText": "Copiar <img src='img/iconos/permiso.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "csv",
                "sTitle": "lista_supervisores",
                "sButtonText": "CSV <img src='img/iconos/csv_hover.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "pdf",
                "sTitle": "lista_supervisores",
                "sButtonText": "PDF <img src='img/iconos/pdf_hover.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "print",
                "sButtonText": "Imprimir <img src='img/iconos/print_hover.png' width='20' height='20' border=0 />"
              },
            ]
          }
          } );
      } );
    </script>
        

<!-- Codigo importante -->
<?php

  if ($LISTA_SUP['max_res']==0){
      if(!isAdmin())
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento esta persona no tiene supervisores registrados.</p><br><br><br><br><br><br>";
      else
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento esta persona no tiene supervisores registrados.</p><br><br><br><br><br><br>";
  }else{
  ?>
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
      <th class="lsmallT"><small>Supervisor</small></th>
      <th class="lsmallT"><small>Inicio</small></th>
      <th class="lsmallT"><small>Fin</small></th>
      <th class="lsmallT"><small>Observaciones</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>Supervisor</small></th>
      <th class="lsmallT"><small>Inicio</small></th>
      <th class="lsmallT"><small>Fin</small></th>
      <th class="lsmallT"><small>Observaciones</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?
            for ($i=0;$i<$LISTA_SUP['max_res'];$i++){
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><a href='vPersona.php?view&id=<? echo $LISTA_SUP['Sup']['id_sup'][$i];?>'> <? echo $SUP_ID[$LISTA_SUP['Sup']['id_sup'][$i]];?></a> <? if ($LISTA_SUP['Sup']['actual'][$i] == 't') echo " (actual)"; ?></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_SUP['Sup']['fecha_ini'][$i];?></small></td>
          <td class='center lsmallT'><small><? echo $LISTA_SUP['Sup']['fecha_fin'][$i];?></small></td>
          <td class='center lsmallT'><small><? echo $LISTA_SUP['Sup']['observacion'][$i];?></small></td>
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
