<?php
    session_start();
    include "lib/cNotificaciones.php";
    $Legend = "Notificaciones del sistema";
    include "vHeader.php";
    extract($_GET);
    extract($_POST);
    $all = true;
    date_default_timezone_set('America/Caracas');
?>  

  <br><br>
    <? if ($LISTA_NOTIFICACIONES['max_res']){?>
      <p class="lead"><small>Nuevas notificaciones</small></p>
      <div class="well" align="center" style="background-color: #fff; box-shadow: none;">
	<!--Tabla de notificaciones-->
	<table class="table table-hover" style="margin-left: 0; max-width: 900px;">
	  <thead>
	    <tr>
	      <th class="lsmallT"><small>Fecha y hora</small></th>
	      <th class="lsmallT"><small>Notificación</small></th>
	      <th class="lsmallT"><small>Mensaje</small></th>
	      <th class="lsmallT"><small>Acción</small></th>
	    </tr>
	  </thead>
	  
	  <tbody role="alert" aria-live="polite" aria-relevant="all">   
	  <?php
	    for ($i=0;$i<$LISTA_NOTIFICACIONES['max_res'];$i++){
	  ?>
	    <tr>
	      <!--Fecha-->
	      <td class="center lsmallT" ><small><? echo $LISTA_NOTIFICACIONES['Not']['fecha'][$i];?></small></td> 
	      <!--Notificación-->
	      <td class="center lsmallT" ><small><? echo $LISTA_NOTIFICACIONES['Not']['notificacion'][$i];?></small></td>  
	      <!--Mensaje-->
	      <td class="center lsmallT" ><small><? echo $LISTA_NOTIFICACIONES['Not']['mensaje'][$i];?></small></td>   
	      <!--Acción-->
	      <td class="center lsmallT" nowrap>
		<a href='./vResultados.php?token_ls=<? echo $LISTA_NOTIFICACIONES['Not']['token_ls_per'][$i];?>' title='Revisar evaluación' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>
		<a href='./lib/cNotificaciones.php?action=check&id=<?echo $LISTA_NOTIFICACIONES['Not']['id'][$i];?>' title='Marcar como leída'><img src='./img/iconos/check-16.png' style='margin-left:5px;'></a>
	    </td>
	    </tr>
	  <? } //cierre del for
	  ?>   
	  </tbody>
	</table>
	<!--Fin de la tabla de notificaciones-->
      </div><!--Fin del contenedor-->

    <? } else {?>
	 <br><br><br><br><br><br><p class='text-center text-info lsmall'>Hasta el momento no hay nuevas notificaciones para el administrador.</p><br><br><br><br><br><br>
    <? } 
      if($HISTORIAL_NOTIFICACIONES['max_res']){?>
	<p class="lead"><small>Historial de notificaciones</small></p>
	<div class="well" align="center" style="background-color: #fbfbfb; box-shadow: none;">
	<!--Tabla de notificaciones-->
	<table class="table table-hover" style="margin-left: 0; max-width: 900px;">
	  <thead>
	    <tr>
	      <th class="lsmallT"><small>Fecha y hora</small></th>
	      <th class="lsmallT"><small>Notificación</small></th>
	      <th class="lsmallT"><small>Mensaje</small></th>
	      <th class="lsmallT"><small>Acción</small></th>
	    </tr>
	  </thead>
	  
	  <tbody role="alert" aria-live="polite" aria-relevant="all">   
	  <?php
	    for ($i=0;$i<$HISTORIAL_NOTIFICACIONES['max_res'] && $i<10;$i++){
	  ?>
	    <tr>
	      <!--Fecha-->
	      <td class="center lsmallT" ><small><? echo $HISTORIAL_NOTIFICACIONES['Not']['fecha'][$i];?></small></td> 
	      <!--Notificación-->
	      <td class="center lsmallT" ><small><? echo $HISTORIAL_NOTIFICACIONES['Not']['notificacion'][$i];?></small></td>  
	      <!--Mensaje-->
	      <td class="center lsmallT" ><small><? echo $HISTORIAL_NOTIFICACIONES['Not']['mensaje'][$i];?></small></td>   
	      <!--Acción-->
	      <td class="center lsmallT" nowrap>
		<a href='./vResultados.php?token_ls=<? echo $HISTORIAL_NOTIFICACIONES['Not']['token_ls_per'][$i];?>' title='Revisar evaluación' ><img src='./img/iconos/visible-16.png' style='margin-left:5px;'></a>
	    </td>
	    </tr>
	  <? } //cierre del for
	  ?>   
	  </tbody>
	</table>
	<!--Fin de la tabla de notificaciones-->
      </div><!--Fin del contenedor-->
    <?
      }
    ?>
    

   
<?
include "vFooter.php";
?>
