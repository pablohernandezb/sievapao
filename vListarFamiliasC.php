<?php
    session_start();
    $Legend = "Grupos de Cargo";
    include "lib/cVerFamiliaC.php";
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
                "sTitle": "lista_familia_cargo",
                "sButtonText": "CSV <img src='img/iconos/csv-dark.png' border=0 style='margin-left:2px;'/>"
              },
              {
                "sExtends": "pdf",
                "sTitle": "lista_familia_cargo",
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

  if ($LISTA_FC['max_res']==0){
      if(!isAdmin())
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay grupo de cargo registrada.</p><br><br><br><br><br><br>";
      else
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay grupo de cargo registrada.</p><br><br><br><br><br><br>";
  }else{
  ?>
  <div class="well span9 offset1">
    <div class="row">
      <div class="span9">
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
      <th class="lsmallT"><small>id</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Descripción</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>id</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Descripción</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_FC['max_res'];$i++){
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_FC['Fc']['id'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vFamiliaC.php?view&id=".$LISTA_FC['Fc']['id'][$i]."'" ?>><? echo $LISTA_FC['Fc']['nombre'][$i]?></a></small></td>
          <td class="center lsmallT"><small> <? echo $LISTA_FC['Fc']['descripcion'][$i] ?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vFamiliaC.php?action=edit&id=";
                echo $LISTA_FC['Fc']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                echo "<a href='vFamiliaC.php?action=copy&id=";
                echo $LISTA_FC['Fc']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cFamiliaC.php?action=delete&id=";
                echo $LISTA_FC['Fc']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;&nbsp;"; 
            ?>
          </td>
          </tr>
          <? } ?>     
        </tbody>
</table>
</div>
         
<?
    echo "<div  align='center'><a href='vFamiliaC.php' class='btn btn-info'>Agregar Grupo de Cargo</a></div>";
?>
  </div>
<?php
}//cierra el else

include "vFooter.php";
?>
