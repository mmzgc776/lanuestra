<?php
$nombre = $_POST["rcod"];
$pas1 = $_POST["pas1"];
$pas2 = $_POST["pas2"];
$mail = $_POST["mail"];
require_once ("db.php");
$flag = 0;
$datos = buscarUseromail($nombre, $mail);
if ($datos) {
	if ($datos[1] == $mail) {
		$flag = 2;
	}
	if ($datos[0] == $nombre) {
		$flag = 1;
	}
}
if ($flag == 0) {
	altaUsuario($nombre, $pas1, 1, $mail, date("Y-m-d"));
	echo $flag;
} else {
	echo $flag;
}
?>