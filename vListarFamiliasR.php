<?php
    session_start();
    $Legend = "Familia de Rol";
    include "lib/cVerFamiliaR.php";
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
                "sTitle": "lista_familia_rol",
                "sButtonText": "CSV <img src='img/iconos/csv_hover.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "pdf",
                "sTitle": "lista_familia_rol",
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

  if ($LISTA_FR['max_res']==0){
      if(!isAdmin())
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay familia de rol registrada.</p><br><br><br><br><br><br>";
      else
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay familia de rol registrada.</p><br><br><br><br><br><br>";
  }else{
  ?>
  <div class="well span9 offset1">
    <?
      if (!isAdmin())
        echo "<div  align='center'><a href='vFamiliaR.php' class='btn btn-info'>Registrar Nueva</a></div>";
    ?>
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
            for ($i=0;$i<$LISTA_FR['max_res'];$i++){
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_FR['Fr']['id'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vFamiliaR.php?view&id=".$LISTA_FR['Fr']['id'][$i]."'" ?>><? echo $LISTA_FR['Fr']['nombre'][$i]?></a></small></td>
          <td class="center lsmallT"><small> <? echo $LISTA_FR['Fr']['descripcion'][$i] ?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vFamiliaR.php?action=edit&id=";
                echo $LISTA_FR['Fr']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit.gif' width='20' height='20' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                echo "<a href='vFamiliaR.php?action=copy&id=";
                echo $LISTA_FR['Fr']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/edit-copy.png' width='20' height='20' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cFamiliaR.php?action=delete&id=";
                echo $LISTA_FR['Fr']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/eliminar.gif'/></a>&nbsp;&nbsp;&nbsp;"; 
            ?>
          </td>
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
