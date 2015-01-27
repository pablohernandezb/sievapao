<?php
    session_start();
    $Legend = "Administrar Encuestas de Limesurvey";
    include "lib/cEncuestasLimesurvey.php";
    include "vHeader.php";
    extract($_GET);
?>   

<?php
  if (!(isset($_GET['action']))){
    if ($LISTA_ENCUESTA['max_res']==0){
	  echo "<br><br><br><br><br><br><p class='text-center text-info'>Hasta el momento no hay encuestas en el sistema.</p><br><br><br><br><br><br>";
    }else{
    ?>
	
    <div id="demo" align="center">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example" style="max-width:60%">
    <thead>
      <tr>
	<th class="lsmallT"><small>Familia de cargo evaluada por la encuesta</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
	<th class="lsmallT"><small>Familia de cargo evaluada por la encuesta</small></th>
	<th class="lsmallT"><small>Acción</small></th>
      </tr>
    </tfoot>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
	
    <!-- Listado de encuestas definidas -->
    <?php
      if ($LISTA_ENCUESTA['max_res']>0){
      for ($i=0;$i<$LISTA_ENCUESTA['max_res'];$i++){
    ?>
    <tr>
      <td class="center lsmallT" nowrap><small> <? echo $LISTA_CARGOS[$i];?></small></td>   
      <td class="center lsmallT" nowrap><small><? 
	  echo '<a href="lib/cEncuestas?action=delete&id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '" title="Desactivar encuesta"><img src="./img/iconos/delete-16.png" style="margin-left:7px;"></a>';
	  echo '<a href="lib/cDescargarEncuesta?id_encuesta_ls='; echo $LISTA_ENCUESTA['Enc']['id_encuesta_ls'][$i]; echo '&id_fam='; echo $LISTA_ENCUESTA['Enc']['id_fam'][$i]; echo '" title="Descargar encuesta en PDF"><img src="./img/iconos/pdf-16.png" style="margin-left:9px;"></a>';
	  ?></small></td>
    </tr>

    <? } //cierre del for
      } //cierre del if  
    ?>
	
    </tbody>
	    
  </table>
  </div>

  <?php
    }//cierra el else 
  ?>
    <div align="center">
      <a href="./vImportarEncuesta.php" class="btn btn-info">Importar Nueva Encuesta</a>
    </div>
  <?php
  } 
  include "vFooter.php";
  ?>
