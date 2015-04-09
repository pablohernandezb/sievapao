<?php
    session_start();
    $all = true;
    $Legend = "Reporte de Personal";
    include "lib/cReportePersonas.php";
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
                "sTitle": "reporte_personas",
                "sButtonText": "CSV <img src='img/iconos/csv-dark.png' border=0 style='margin-left:2px;'/>"
              },
              {
                "sExtends": "pdf",
                "sTitle": "reporte_personas",
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

  if ($LISTA_PER['max_res']==0){
      if(!isAdmin())
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay personas registradas.</p><br><br><br><br><br><br>";
      else
        echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay personas registradas.</p><br><br><br><br><br><br>";
  }else{
  ?>
  <div class="well span11">

    <div class="row">
      <div class="span11">
    <?switch($_GET['report']) {
	case 'cargo':
	    echo "<h4>Por Cargos</h4>";
	    break;
	case 'unidad':
	    echo "<h4>Por Unidad</h4>";
	    break;
	case 'rol':
	    echo "<h4>Por Rol</h4>";
	    break;
	case 'sincargo':
	    echo "<h4>Sin Cargo</h4>";
	    break;
	case 'sinsupervisor':
	    echo "<h4>Sin Supervisor</h4>";
	    break;
    }?>
        <p class="text-justified muted lsmall"><small>Se le recomienda utilizar el campo de <i>b&uacute;squeda</i> y seleccionar 
            sobre las columnas de su preferencia para organizar las entidades en forma ascendente o descendente. Si desea ordenarlo en 
            funci&oacute;n a m&aacute;s de un campo, debe presionar la tecla <i>SHIFT</i> y hacer click en la(s) columna(s) correspondiente(s).</small>
        </p><br>
      </div>

    </div>
       <? if(isset($_GET['report'])) { 
		if($_GET['report']=='cargo') {?>
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo del Cargo</small></th>
      <th class="lsmallT"><small>Cargo</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo del Cargo</small></th>
      <th class="lsmallT"><small>Cargo</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_PER['max_res'];$i++){
		if(isset($LISTA_CAR['Car']['codigo'][$i]) && isset($LISTA_CAR['Car']['nombre'][$i])) {
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_PER['Per']['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vPersona.php?view&id=".$LISTA_PER['Per']['id'][$i]."'" ?>><? echo $LISTA_PER['Per']['nombre'][$i]." ".$LISTA_PER['Per']['apellido'][$i]?></a></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_CAR['Car']['codigo'][$i]?></small></td>
	  <td class="center lsmallT"><small><? echo $LISTA_CAR['Car']['nombre'][$i]?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vPersona.php?action=edit&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a href='vPersona.php?action=copy&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cPersona.php?action=delete&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;";

		echo "<a href='vEnviarCorreo.php?action=compose&id=".$LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Enviar mensaje'><img src='img/iconos/mail-16.png' border=0 /></a>";

            ?>
          </td>
          </tr>
	          <? } //Cierro el if ?>     
          <? } //Cierro el for ?>     
        </tbody>
</table>
</div>      
	<? } else if($_GET['report']=='unidad') { ?>
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_PER['max_res'];$i++){
		if(isset($LISTA_UNI['Uni']['nombre'][$i])) {
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_PER['Per']['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vPersona.php?view&id=".$LISTA_PER['Per']['id'][$i]."'" ?>><? echo $LISTA_PER['Per']['nombre'][$i]." ".$LISTA_PER['Per']['apellido'][$i]?></a></small></td>
          <td class="center lsmallT"><small><? echo $LISTA_PER['Per']['unidad'][$i]?></small></td>
	  <td class="center lsmallT"><small><? echo $LISTA_UNI['Uni']['nombre'][$i]?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vPersona.php?action=edit&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a href='vPersona.php?action=copy&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cPersona.php?action=delete&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;";

		echo "<a href='vEnviarCorreo.php?action=compose&id=".$LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Enviar mensaje'><img src='img/iconos/mail-16.png' border=0 /></a>";

            ?>
          </td>
          </tr>
	          <? } // Cierro el if ?>     
          <? } // Cierro el for ?>     
        </tbody>
</table>
</div>     
	<? } else if($_GET['report']=='rol') { ?>
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Gremio</small></th>
      <th class="lsmallT"><small>Rol</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>Gremio</small></th>
      <th class="lsmallT"><small>Rol</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_PER['max_res'];$i++){		
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_PER['Per']['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vPersona.php?view&id=".$LISTA_PER['Per']['id'][$i]."'" ?>><? echo $LISTA_PER['Per']['nombre'][$i]." ".$LISTA_PER['Per']['apellido'][$i]?></a></small></td>
	  <? switch($LISTA_PER['Per']['tipo'][$i]) {
		case '1':
			echo "<td class='center lsmallT'><small>ACAD&Eacute;MICO</small></td>";
			break;
		case '2':
			echo "<td class='center lsmallT'><small>ADMINISTRATIVO</small></td>";
			break;
		case '3':
			echo "<td class='center lsmallT'><small>OBRERO</small></td>";
			break;
		case '4':
			echo "<td class='center lsmallT'><small>OTRO</small></td>";
			break;
		default:
			break;
	  } ?>
	  <? switch($LISTA_PER['Per']['rol'][$i]) {
		case '1':
			echo "<td class='center lsmallT'><small>APOYO</small></td>";
			break;
		case '2':
			echo "<td class='center lsmallT'><small>OPERATIVAS</small></td>";
			break;
		case '3':
			echo "<td class='center lsmallT'><small>SUPERVISORIO ADMINISTRATIVO</small></td>";
			break;
		case '4':
			echo "<td class='center lsmallT'><small>OBRERO</small></td>";
			break;
		case '5':
			echo "<td class='center lsmallT'><small>SUPERVISORIO OBRERO</small></td>";
			break;
		default:
			break;
	  } ?>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vPersona.php?action=edit&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a href='vPersona.php?action=copy&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cPersona.php?action=delete&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;";
		echo "<a href='vEnviarCorreo.php?action=compose&id=".$LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Enviar mensaje'><img src='img/iconos/mail-16.png' border=0 /></a>";

            ?>
          </td>
          </tr>     
          <? } // Cierro el for ?>     
        </tbody>
</table>
</div>     
	<? } else if($_GET['report']=='sincargo') {?>
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_PER['max_res'];$i++){
		if(!isset($LISTA_CAR['Car']['codigo'][$i]) || !isset($LISTA_CAR['Car']['nombre'][$i])) {
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_PER['Per']['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vPersona.php?view&id=".$LISTA_PER['Per']['id'][$i]."'" ?>><? echo $LISTA_PER['Per']['nombre'][$i]." ".$LISTA_PER['Per']['apellido'][$i]?></a></small></td>
          <td class="center lsmallT"><small><?php echo $LISTA_PER['Per']['unidad'][$i]?></small></td>
	  <td class="center lsmallT"><small><?php echo $LISTA_UNI['Uni']['nombre'][$i]?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vPersona.php?action=edit&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a href='vPersona.php?action=copy&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cPersona.php?action=delete&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;";

		echo "<a href='vEnviarCorreo.php?action=compose&id=".$LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Enviar mensaje'><img src='img/iconos/mail-16.png' border=0 /></a>";

            ?>
          </td>
          </tr>
	          <? } //Cierro el if ?>     
          <? } //Cierro el for ?>     
        </tbody>
</table>
</div>      
	<? } else if($_GET['report']=='sinsupervisor') { ?>
          <div id="demo">
<table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" width="100%">
  <thead>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th class="lsmallT"><small>C&eacute;dula</small></th>
      <th class="lsmallT"><small>Nombre</small></th>
      <th class="lsmallT"><small>C&oacute;digo de la Unidad</small></th>
      <th class="lsmallT"><small>Unidad</small></th>
      <th class="lsmallT"><small>Acci&oacute;n</small></th>
    </tr>
  </tfoot>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php
            for ($i=0;$i<$LISTA_PER['max_res'];$i++){
		if($LISTA_PER['Per']['supervisores'][$i]==0) {
          ?>
          <tr class="<?php echo $color_tabla; ?>" >
          <td class="center lsmallT" nowrap><small><?php echo $LISTA_PER['Per']['cedula'][$i]?></small></td>
          <td class="center lsmallT"><small><a <? echo "href='vPersona.php?view&id=".$LISTA_PER['Per']['id'][$i]."'" ?>><? echo $LISTA_PER['Per']['nombre'][$i]." ".$LISTA_PER['Per']['apellido'][$i]?></a></small></td>
          <td class="center lsmallT"><small><?php echo $LISTA_PER['Per']['unidad'][$i]?></small></td>
	  <td class="center lsmallT"><small><?php echo $LISTA_UNI['Uni']['nombre'][$i]?></small></td>
          <td class="center lsmallT" nowrap>
            <?
                echo "<a href='vPersona.php?action=edit&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Editar'><img src='img/iconos/edit-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a href='vPersona.php?action=copy&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Copiar'><img src='img/iconos/copy-16.png' border=0 /></a> &nbsp;&nbsp;"; 
                echo "<a data-toggle='modal' data-data='Sebuah Data' href='#confirm' data-url='lib/cPersona.php?action=delete&id=";
                echo $LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Eliminar' onclick='return confirmar()'><img src='img/iconos/delete-16.png'/></a>&nbsp;&nbsp;";

		echo "<a href='vEnviarCorreo.php?action=compose&id=".$LISTA_PER['Per']['id'][$i]."' rel='tooltip' title='Enviar mensaje'><img src='img/iconos/mail-16.png' border=0 /></a>";

            ?>
          </td>
          </tr>
	          <? } //Cierro el if ?>     
          <? } //Cierro el for ?>     
        </tbody>
</table>
</div>      
	<? } ?>  
   
<? } ?>    

  </div>
<?php
}//cierra el else

include "vFooter.php";
?>
