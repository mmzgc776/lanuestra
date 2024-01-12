<?php
//Incluimos la script de db
require_once ("db.php");
//Variables gobales
require_once ('gconf.php');
//Se obtienen las ips desde conectados sql
$ips = getConectedips();
//Dividimos el ancho de banda entre el total de usuarios
$usuarios = count($ips);
if (count($ips) == 0) {
	$usuarios = 1;
}

$individualdn = $totaldn / $usuarios;
$individualup = $totalup / $usuarios;
$ceildn = $totaldn * 3;
$ceilup = $totalup * 3;
//Cambiamos las clases usando el ultimo octeto de la ip como identificador
foreach ($ips as $ip) {
	$octetos = explode(".", $ip);
	$classid = $octetos[3];
	system("tc class change dev " . $ifclan . " classid 1:" . $classid . " htb rate " . $individualdn . "kbps ceil " . $ceildn . "kbps", $return);
	system("tc class change dev " . $ifcisp . " classid 1:" . $classid . " htb rate " . $individualup . "kbps ceil " . $ceilup . "kbps", $return);
}
?>