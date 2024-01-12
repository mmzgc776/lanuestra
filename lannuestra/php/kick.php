<?php
/******************************************/
//Se deben de dar de baja las reglas
//Se debe borrar el registro de conectados
/******************************************/
require_once ("db.php");
$ip = $_POST['ip'];
//Se quitan las reglas de iptables
$iprules = fopen("iptrules.csv", "r");
while (($regla = fgetcsv($iprules, ";")) != false) {
	system($regla[0] . "D " . $regla[1] . " " . $ip . " " . $regla[2], $return);
}
$octetos = explode(".", $ip);
$classid = $octetos[3];
//Quitamos la aceptacion del 80
exec("iptables -t nat -D PREROUTING -s ".$ip." -p tcp --dport 80 -j ACCEPT",$return);
//Quitamos dos filtros a la tabla mangle
//exec("sudo iptables -t mangle -D POSTROUTING -s " . $ip . " ! -p ICMP -j MARK --set-mark " . $classid, $return);
//exec("sudo iptables -t mangle -D POSTROUTING -d " . $ip . " ! -p ICMP -j MARK --set-mark " . $classid, $return);
fclose($iprules);
//Se da de baja el usuario
bajaConectados($ip);
require_once ("bqos.php");
echo "1";
?>