<?
    session_start();

    if (isset($_SESSION['USBID'])){
        include("lib/cAutorizacion.php");
    }

    $Legend = "Inicio";
    include_once("vHeaderInicio.php");
?>
<br><br><br>

<div class="well text-center">
    <?

    if (!isset($_SESSION['USBID'])){
        echo "    
    <p>
        <h4>Mediante este sistema se puede hacer seguimiento de la evaluación de personal de la Universidad Simón Bolívar.</h4>
    </p><br><br>

    <p>
        Si eres parte de la Dirección de Gestión de Capital Humano (DGCH) inicia sesión para administrar 
        los datos y los procesos de evaluación.
    </p><br><br>

    <p>
        Si eres empleado o evaluador inicia sesión para ver las diferentes evaluaciones que debes realizar.
    </p><br><br><br>";
    echo "<a href='lib/scriptcas.php' class='btn btn-info'>Iniciar sesión</a><br><br>";

    } else {

	echo "
	<p>
	<h4>
      ¡Bienvenido!<br><br><br>
	</h4>
	<div class='container'>
	   <div clas='row'>
	   
	    <div class='span5'>
	      <a class='btn' href='inicioVernier.php'>
		<br>
		Si formas parte de la DGCH y deseas administrar los datos y los procesos de evaluación<br><br><strong>Haz click aquí</strong><br>
		<br>
	      </a>
	    </div>
	    
	    <div class='span5 offset1'>
	      <a  class='btn' href='inicioEvaluaciones.php'>
		<br>
		Si formas parte del personal de la USB y deseas gestionar tus evaluaciones<br><br><strong>Haz click aquí</strong><br>
		<br>
	     </a>
	    </div>
	   </div>
	  
	</div>";

    }
    ?>
</div>

<?
    include_once("vFooter.php");
?>
