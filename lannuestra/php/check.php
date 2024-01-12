<?php
/************************************
 /* Esta script constituye gran parte
 * del trabajo a manera de "daemon"
 * ejecuta labores criticas de
 * mantenimiento de qos y control
 * de conectados
 * *********************************/
require_once ("db.php");
//Variables gobales
require_once ('gconf.php');
//Anotamos la hora
echo date("H:i:s") . "\n";
//Checamos los conectados con ip neigh
$arreglot = getAllconnected();
for ($i = 0; $i < sizeof($arreglot); $i++) {
	$estado = null;
	//Hace ping a un cliente que viene de "conectados"
	//Con esto actualizamos la tabla de vecinos
	system("ping -c 1 " . $arreglot[$i][1]);
	//Bandera si está en linea
	$out = 0;
	//Consultamos la tabla y cortamos la linea al campo 5
	exec("ip neigh show " . $arreglot[$i][1] . " |cut -d\" \" -f 5", $estado);
	//echo $estado[0];
	if ($estado[0] == "FAILED") {
		$out = 1;
	}
	if ($out == 1) {
		//Se dará de baja de las reglas, y de la lista de conectados...
		//Aqui baja de iptables
		//Variable de Insert o Delete
		$IoD = "D";
		//Lee iptrules y saca el comando a ejecutar
		//Datos[1]=ip
		$iprules = fopen("/www/lannuestra/php/iptrules.csv", "r");
		while (($regla = fgetcsv($iprules, ";")) != false) {
			system($regla[0] . $IoD . " " . $regla[1] . " " . $arreglot[$i][1] . " " . $regla[2], $return);
		}
		fclose($iprules);
		//Baja de conectados
		bajaConectados($arreglot[$i][1]);
	}
}
//Pedimos las ips
$ips=getConectedips();
for($i=0;$i<sizeof($ips);$i++){
	echo $ips[$i];
}
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
	if ($ip != 0) {
		$octetos = explode(".", $ip);
		$classid = $octetos[3];
		exec("tc class change dev " . $ifclan . " classid 1:" . $classid . " htb rate " . $individualdn . "kbps ceil " . $ceildn . "kbps", $return);
		exec("tc class change dev " . $ifcisp . " classid 1:" . $classid . " htb rate " . $individualup . "kbps ceil " . $ceilup . "kbps", $return);
	}
}
?>
