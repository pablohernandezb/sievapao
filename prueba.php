<?php
    extract($_GET);
    extract($_POST);
    include_once "./lib/cConstantes.php";
    date_default_timezone_set('America/Caracas');
    
   	    //Agregar cronjob para el día de expiración de la encuesta
   	    //$fecha=date("d-m-Y");
	    //$aux= explode("-",$fecha);
	    //$output=file_put_contents('./tmp/vernier_jobs.txt', '00 00 '.'20'.' '.$aux[1].' * wget -O -q -t 1 http://localhost/vernier/lib/cEvaluaciones.php?action=desactivar'.PHP_EOL);
	    //$output=shell_exec('crontab ./tmp/vernier_jobs.txt');
	    
    echo shell_exec('crontab -l');
    
/*    
    $path='../tmp/vernier_jobs.txt';
    $remove='08-01-2014';
    $lines = file($path);
    foreach($lines as $key => $line)
    if(stristr($line, $remove)) unset($lines[$key]);
    $data = implode('\n', array_values($lines));
    $aux=file_put_contents($path, $data);
    
*/


?>
