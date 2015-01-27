<?php
    session_start();
    include "lib/cVerOrganizacion.php";
    include "vHeader.php";
    $all = true;
?>   

  <style type="text/css">
    @import "http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/css/bootstrap-combined.min.css";
    @import "datatable-bootstrap.css";
  </style>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.1.1/js/bootstrap.min.js"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script src="datatable-bootstrap.js"></script>
    <script type="text/javascript" charset="utf-8">
      $(document).ready( function () {
        $('#example').dataTable( {
          "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
          "oTableTools": {
            "aButtons": [
              {
                "sExtends": "copy",
                "sButtonText": "Copiar al Portapapeles <img src='img/iconos/permiso.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "csv",
                "sTitle": "lista_empresas",
                "sButtonText": "Guardar en CSV <img src='img/iconos/csv_hover.png' width='20' height='20' border=0 />"
              },
              {
                "sExtends": "pdf",
                "sTitle": "lista_empresas",
                "sButtonText": "Guardar en PDF <img src='img/iconos/pdf_hover.png' width='20' height='20' border=0 />"
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
  if ($LISTA_ORG['max_res']==0){
    if(!isAdmin())
      echo "<br><br><br><br><br><br><br><br><div align='center' >Hasta el momento no has realizado ninguna solicitud.</div><br><br><br><br><br><br><br><br>";
    else
      echo "<br><br><br><br><br><br><br><br><div align='center' >Hasta el momento no han realizado ninguna solicitud.</div><br><br><br><br><br><br><br><br>";   
  }else{
  ?>
  <legend>Organizaci&oacute;n</legend>  
  <?   
    if (isset($_GET['success'])){
      echo "  <div class='alert alert-success'>
                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                <strong>Registro Exitoso!</strong> Los datos de la organizaci&oacute;n se borraron con &eacute;xito.
            </div>";
    }
  ?>

  <div class= "row">
    <div class="span12 offset2">
      <div class="well span6" style="text-align: center">
        <?
          if (!isAdmin())
            echo "<a href='vOrganizacion.php' class='btn btn-info'>Registrar Nueva</a><br><br>";
        ?>
        <div class="row">
          <div class="span6">
            <p class="text-center"><strong style="color:#06F">Sugerencia:</strong> <small>Se le recomienda utilizar el campo de "B&uacute;squeda" y seleccionar 
                sobre las columnas de su preferencia para organizar los Estudiantes en forma ascendente o descendente. Si desea ordenarlo en 
                funci&oacute;n a m&aacute;s de un campo, debe presionar la tecla "SHIFT" y darle a la(s) columnas.</small>
            </p>
          </div>
        </div> 
        <div id="demo">
          <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
            <thead>
              <tr>
                <th>C&oacute;digo</th>
                <th>Nombre</th>
                <th>Superior</th>
                <th>Acci&oacute;n</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>C&oacute;digo</th>
                <th>Nombre</th>
                <th>Superior</th>
                <th>Acci&oacute;n</th>
              </tr>
            </tfoot>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
              <?php
                for ($i=0;$i<$LISTA_ORG['max_res'];$i++){
              ?>
              <tr class="<?php echo $color_tabla; ?>" >
                <td class="center" nowrap><strong><?php echo $LISTA_ORG['Org']['codigo'][$i]?></strong></td>
                <td class="center"><a <? echo "href='vOrganizacion.php?view&id=".$LISTA_ORG['Org']['id'][$i]."'" ?>><? echo $LISTA_ORG['Org']['nombre'][$i]?></a></td>
                <td class="center"><a <? echo "href='vOrganizacion.php?view&id=".$LISTA_ORG['Org']['idsup'][$i]."'" ?>><? echo $ORG_ID[$LISTA_ORG['Org']['idsup'][$i]]?></a></td>
                <td class="center" nowrap>
                <?
                  echo "<a href='vOrganizacion.php?action=edit&id=";
                  echo $LISTA_ORG['Org']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit.gif' width='20' height='20' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                  echo "<a href='vOrganizacion.php?action=copy&id=";
                  echo $LISTA_ORG['Org']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/edit-copy.png' width='20' height='20' border=0 /></a> &nbsp;&nbsp;&nbsp;"; 
                  echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cOrganizacion.php?action=delete&id=";
                  echo $LISTA_ORG['Org']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/eliminar.gif'/></a>&nbsp;&nbsp;&nbsp;"; 
                ?>
                </td>
              </tr>
              <? } ?>     
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
  }//cierra el else

  include "vFooter.php";
  ?>
