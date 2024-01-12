<?php
require_once ("db.php");
$dbhandler = new db;
$consulta = 'DELETE FROM conectados';
$respuesta = $dbhandler -> query($consulta);
$dbhandler -> close();
?>