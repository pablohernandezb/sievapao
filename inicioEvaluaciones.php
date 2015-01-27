<?
    session_start();

    if (isset($_SESSION['USBID'])){
        include("lib/cAutorizacion.php");
    }

    $Legend = "Inicio/Evaluaciones";
    include_once("vHeaderEvaluaciones.php");
?>
<br><br><br>
<div class="well text-center">
    <?

    if (isset($_SESSION['USBID'])){
        echo "    
    <p>
        <h4>Bienvenido</h4>
    </p><br><br>

    <p>
	A través de este sistema podrás gestionar tu evaluación.
    </p><br><br>

    <p>
	Podrás ver las diferentes evaluaciones que debes realizar y ver los resultados.   
    </p><br><br><br>";
    }
    ?>
</div>

<?
    include_once("vFooter.php");
?>
