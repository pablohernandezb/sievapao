<?
    $Legend='Cheat Inicio';
    
    //include_once "lib/cConstantes.php";
    
    if (isset($_REQUEST['dgch'])) {
        include_once("lib/scriptcas-dgch.php");
        header("Location: index.php");  
    }
    if (isset($_REQUEST['evaluado'])) {
        include_once("lib/scriptcas-evaluado.php");
        header("Location: index.php");  
    }
    if (isset($_REQUEST['evaluador'])) {
        include_once("lib/scriptcas-evaluador.php");
        header("Location: index.php");  
    }
    if (isset($_REQUEST['otro'])) {
        include_once("lib/scriptcas-roberto.php");
        header("Location: index.php");  
    }
    if (isset($_REQUEST['supervisor'])) {
        include_once("lib/scriptcas-supervisor.php");
        header("Location: index.php");  
    }
    include_once("vHeaderCheat.php");
?>
	<div class="well" align="center">
	  <p>
	   <h4>Mediante este sistema se puede hacer seguimiento de la evaluación de personal de la Universidad Simón Bolívar.</h4>
	  </p><br><br>
            <div class="row">
		  <div>
		    Ingresar al sistema como usuario administrador
		    <a class="btn btn-info" href="?dgch=">Haga click aquí</a>
		  </div><br><br>
		  <div>
		    Ingresar al sistema como personal evaluado
		    <a class="btn btn-info" href="?evaluado=">Haga click aquí</a>
		  </div><br><br>
		  <div>
		    Ingresar al sistema como evaluador (supervisor inmediato)
		    <a class="btn btn-info" href="?evaluador=">Haga click aquí</a>
		  </div><br><br>
		  <div>
		    Ingresar al sistema como <i>otro</i> evaluador (supervisor inmediato)
		    <a class="btn btn-info" href="?otro=">Haga click aquí</a>
		  </div><br><br>
		  Ingresar al sistema como supervisor jerarquico
		    <a class="btn btn-info" href="?supervisor=">Haga click aquí</a>
		  </div><br><br>

            </div> <!-- row -->
	</div>
<?
    include_once("vFooter.php");
?>



