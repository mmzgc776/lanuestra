<?php
require_once ("db.php");
$flag = 0;
$showStatus = '';
if (isset($_POST['showStatus'])) {
	$showStatus = $_POST['showStatus'];
	//echo $showStatus;
}
if ($_POST['cod'] != "") {
	$user = $_POST['cod'];
	$datos = buscaUsuario($user);
	if (($datos[0] == $user) && ($datos[1] == $_POST['pas'])) {
		$user = $datos[0];
		$priv = $datos[2];
		$ipaddr = $_SERVER['REMOTE_ADDR'];
		$navegador = "Indefinido";
		if (isset($_POST['nav'])) {
			$navegador = explode(" ", $_POST['nav']);
			$navegador = $navegador[0];
		}
		$url = $_POST['url'];
		//echo("Los datos son correctos ");
		//Está la cuenta en uso?
		session_start();
		$_SESSION["paso"] = 1;
		require_once ('valida2.php');
		$flag = 1;
	}
}
if ($flag == 0) {
	echo "2";
}
?>