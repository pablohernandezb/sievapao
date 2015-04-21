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
    <script type="text/javascript">
	var numero = -1; 
	evento = function (evt) { 
	   return (!evt) ? event : evt;
	}

	
	agregarCampoArchivo = function () { 

           if(numero==-1) {

		   nDivP = document.createElement('div');
		   nDivP.className = 'control-group';
		   nDivP.id = 'contenedor-adjuntos';
		   nLabelP = document.createElement('label');
	 	   nLabelP.className = 'control-label';
	  	   nLabelP.innerHTML = 'Archivos adjuntos';
		   nDivS = document.createElement('div');
		   nDivS.className = 'controls';
		   nDivS.id = 'adjuntos';

		   nDivP.appendChild(nLabelP);
	     	   nDivP.appendChild(nDivS);

		   container = document.getElementById('enviarCorreo');
	 	   container.appendChild(nDivP);

    	   }

	   nDiv = document.createElement('div');
	   nDiv.className = 'input-prepend';
	   nDiv.id = 'file' + (++numero);

	   nIcono = document.createElement('span');
	   nIcono.className = 'add-on';
           nIcono.innerHTML = '<i class="icon-file"></i>';

	   nCampo = document.createElement('input');
	   nCampo.name = 'archivos[]';
	   nCampo.type = 'file';

	   // Enlace para borrar el archivo adjunto
	   a = document.createElement('a');
	   a.name = nDiv.id;
	   a.href = '#';
	   a.className='btn btn-danger';
	   a.onclick = eliminarCampoArchivo;
	   a.innerHTML = 'Eliminar';
	
           // Agregamos los elementos creados a la div
           nDiv.appendChild(nIcono);
	   nDiv.appendChild(nCampo);
	   nDiv.appendChild(a);
	                
                       
           // Agregamos el nuevo div junto a los otros
	   container = document.getElementById('adjuntos');
	   container.appendChild(nDiv);
	}
	//con esta función eliminamos el campo cuyo link de eliminación sea presionado
	eliminarCampoArchivo = function (evt){
	   evt = evento(evt);
	   nCampo = rObj(evt);
	   div = document.getElementById(nCampo.name);
	   div.parentNode.removeChild(div);

 	   numero--;

	   if(numero==-1) {
		div = document.getElementById('contenedor-adjuntos');
 		div.parentNode.removeChild(div);
	   }

	}
	//con esta función recuperamos una instancia del objeto que disparo el evento
	rObj = function (evt) { 
	   return evt.srcElement ?  evt.srcElement : evt.target;
	}
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
	 <form id="newPer" class="form-horizontal" method="post" action="lib/cEnviarCorreo.php?action=send" enctype="multipart/form-data">
		<input type="hidden" id="tipo" name="tipo" value="plain"/>
		<input type="hidden" id="id" name="id" value="<? if (isset($_GET['id'])) echo $_GET['id']; ?>"/>

		<input type="hidden" id="dest_nombre" name="dest_nombre" value="<? if (isset($LISTA_EMAIL)) echo $LISTA_EMAIL['Per']['nombre'][0].' '.$LISTA_EMAIL['Per']['apellido'][0]; else echo ''?>"/>
	  	<input type="hidden" id="dest_correo" name="dest_correo" value="<? if (isset($LISTA_EMAIL)) echo $LISTA_EMAIL['Per']['email'][0]; else echo ''?>"/>

		<?php
		if (isset($LISTA_EMAIL) && (count($LISTA_EMAIL['Per']['email']))>1) {
			for($i=1;$i<count($LISTA_EMAIL['Per']['email']);$i++) {
				if($i==count($LISTA_EMAIL['Per']['email'])-1) {
					$CC = $CC.$LISTA_EMAIL['Per']['email'][$i]; 
				} else { 
					$CC = $CC.$LISTA_EMAIL['Per']['email'][$i].', ';
				}
			}
		} else { 
			$CC = null;
		}
		?>
		<input type="hidden" id="cc" name="cc" value="<? if (isset($CC)) echo $CC; else echo ''?>"/>

            <div class="span1"></div>
            <div class="span4" id="enviarCorreo">

            <div class="control-group">
               <label class="control-label">Destinatario</label>
               <div class="controls">
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-user'></i></span>


			<? if (isset($LISTA_EMAIL) && count($LISTA_EMAIL['Per']['email'])==1) { 
			echo "<input required type='text' class='input-xxxlarge' id='destinatario' name='destinatario' placeholder='Ingrese correos electrónicos' value='".$LISTA_EMAIL['Per']['email'][0]."' />";
			} else if (isset($LISTA_EMAIL) && count($LISTA_EMAIL['Per']['email'])>1) { 
			echo "<input required type='text' class='input-xxxlarge' id='destinatario' name='destinatario' placeholder='Ingrese correos electrónicos' value='".$LISTA_EMAIL['Per']['email'][0].", ".$CC."' />";
			 } else { 
			echo "<input required type='text' class='input-xxxlarge' id='destinatario' name='destinatario' placeholder='Ingrese correos electrónicos' value='' />";
			 } ?>      
                  </div>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Asunto</label>
               <div class="controls">
                  <div class='input-prepend'>
                        <span class='add-on'><i class='icon-envelope'></i></span>
                        <input required type="text" class="input-xxxlarge" id="asunto" name="asunto" placeholder="Asunto">
                  </div>
               </div>
            </div>

               <div class="control-group">
                  <label class="control-label">Mensaje</label>
                  <div class="controls">
                        <div class="input-prepend">
                           <span class="add-on"><i class="icon-edit"></i></span>
                           <textarea class="input-xxlarge" rows="5" id="mensaje" name="mensaje" placeholder="Mensaje"></textarea>
                        </div>
                  </div>
               </div>

            </div> 
	    <div class="row">
		<div class="control-group">
                  <div class="row">
                  <div class="span7"></div>
                  <div class="span8">
<?
    echo "<br><br><a href='#' class='btn btn-warning' onClick='agregarCampoArchivo()'>Agregar archivo</a>";
    echo "&nbsp;&nbsp; <button type='submit' id='confirmButton' class='btn btn-success'>Enviar mensaje</button>";
?>                  
                  </div>
                  </div>
                </div>
	    </div>

	 </form>
      </div>
  </div>
<?php
}//cierra el else

include "vFooter.php";
?>
