<?php
require_once ("db.php");
$date= new DateTime("now");
$date->modify(" - 3 month");
$datetoDelete = $date->format("Y-m-d");
$dbhandler = new db;
//$consulta = 'DELETE FROM usuarios WHERE fecha="'.$datetoDelete.'"';
//$respuesta = $dbhandler -> query($consulta);
$dbhandler -> close();
?>