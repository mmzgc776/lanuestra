<?php
/************************************
 * De esta script obtendremos un
 * arreglo ($ips_rates) de [n][3]
 * que nos representará las ips,
 * rates de subida y bajada
 * **********************************/
//Variables gobales
require_once ('gconf.php');
require_once ('functions.php');
//Recorremos el arreglo que definimos antes en atable, para obtener las ips desde sql
for($i=0;$i<sizeof($arreglot);$i++){
	$ips[$i]=$arreglot[$i][1];
}
$i = 0;
//Si hay registros
if (sizeof($ips) != null) {
	foreach ($ips as $ip) {
		//Preguntamos a tc la velocidad de bajada y subida de cada ip usando sus interfaces
		$ipspeeds = getipSpeed($ip);
		//Descriptivo
		$ratedown = $ipspeeds[0];
		$rateup = $ipspeeds[1];
		//Preguntamos a tc por la cantidad transferida
		$iptrans = getTransferred($ip);
		$down = $iptrans[0];
		$up = $iptrans[1];
		//Asignamos los valores al arreglo
		$iprates[$i][0] = $ip;
		$iprates[$i][1] = truncateFloat($ratedown, 2);
		$iprates[$i][2] = truncateFloat($rateup, 2);
		$iprates[$i][3] = truncateFloat($down,2);
		$iprates[$i][4] = truncateFloat($up,2);
		$i++;
	}
}
?>