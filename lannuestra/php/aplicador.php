<?php
//Implementamos un "bloqueo" de la script si "paso" no es 2
if (isset($_SESSION["paso"]) && $_SESSION["paso"] == 2) {
	//Actualizamos la fecha
	updateDate($user, date("Y-m-d"));
	//Aqui registraremos y aplicaremos unas regla para cierta ip
	//Variable de Insert o Delete
	$IoD = "I";
	//Lee iptrules y saca el comando a agregar
	$iprules = fopen("iptrules.csv", "r");
	while (($regla = fgetcsv($iprules, ";")) != false) {
		system($regla[0] . $IoD . " " . $regla[1] . " " . $ipaddr . " " . $regla[2], $return);
	}
	fclose($iprules);
	//Cargamos la configuración global
	require_once ('gconf.php');
	//Cargamos las funciones generales
	require_once ('functions.php');
	//Preguntamos el total actual de transferencia de tal ip
	$iptrans = getTransferred($ipaddr);
	//Truncamos para que quede corto y manejable
	$down = $iptrans[0];
	$up = $iptrans[1];
	$down = truncateFloat($down, 2);
	$up = truncateFloat($up, 2);
	//Los campos se escriben en conectados, son descriptivos
	//Sentencia en sql para agregar el usuario a conectados...
	registraConectado($user,$ipaddr,$priv,$navegador,$down,$up);
	//Usuario normal
	if ($priv == 1) {
		//Se reasigna el ancho de banda
		require_once ("bqos.php");
		if ($showStatus == 'on') {
			//Aquí debo crear variables de sesion para el usuario y su ventanita
			echo '4';
		} else {
			echo $priv;
		}
	}
	//En caso de ser administrador
	if ($priv == 0) {
		//Se crea una sesion y una variable llamada admin
		if (!isset($_SESSION["admin"])) {
			$_SESSION["admin"] = 1;
		}
		require_once ("bqos.php");
		require_once ("atable.php");
	}
	//Squid
	//echo shell_exec("sudo iptables -t nat -I PREROUTING -s ".$ipaddr." -p TCP --dport 80 -j DNAT --to 192.168.1.66:3128");
	//echo shell_exec("sudo iptables -t nat -I PREROUTING -s ".$ipaddr." -p tcp --dport 80 -j ACCEPT");
} else {
	echo "Ha ocurrido un error";
}
?>