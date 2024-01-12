<?php
$ip = $_POST['ip'];
$rated = $_POST['rated'];
$rateu = $_POST['rateu'];
if ($ip&$rated&$rateu) {
	//Variables gobales
	require_once ('gconf.php');
	require_once ("db.php");
	updateCustomstatus($ip, 0);
	$octetos = explode(".", $ip);
	$classid = $octetos[3];
	//Modificamos las clases de subida y bajada
	exec("tc class change dev " . $ifclan . " classid 1:" . $classid . " htb rate " . $rated . "kbps ceil " . ($rated * 2) . "kbps", $return);
	exec("tc class change dev " . $ifcisp . " classid 1:" . $classid . " htb rate " . $rateu . "kbps ceil " . ($rateu * 2) . "kbps", $return);
	echo "1";
}else{
	echo "2";
}
?>