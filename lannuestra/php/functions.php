<?php
/***************************************************/
/*	Este archivo será de funciones comunes   	   */
/***************************************************/
//Variables gloables y configuración
require_once ('gconf.php');
//Vamos a consultar solo una vez tc!
class tctable {
	function __construct() {
		$returnlan = null;
		$returnisp = null;
	}

	//Creamos una tabla con ip, ratedn, down, rateup, up
	function creatabla($ifclan, $ifcisp) {
		$conteo = 0;
		$elemento = 0;
		exec('tc -s class show dev ' . $ifclan . ' ', $returnlan);
		//Purgar $return para obtener una matriz con los datos que nos importan...
		while ($elemento < 254) {
			$renglon = $returnlan[$conteo];
			$palabra = explode(" ", $renglon);
			$classid = $palabra[2];
			$cidcortada = explode(":", $classid);
			$ip = "10.42.43." . $cidcortada[1];
			$ratedn = $palabra[8];
			$renglon = $returnlan[$conteo + 1];
			$palabra = explode(" ", $renglon);
			$down = $palabra[2];
			if ($cidcortada[1] != 555) {
				$tabla[$elemento][0] = $ip;
				$tabla[$elemento][1] = $ratedn;
				$tabla[$elemento][2] = $down;
				$elemento++;
				$conteo = $conteo + 6;
			}
		}
		$conteo = 0;
		$elemento = 0;
		exec('tc -s class show dev ' . $ifcisp . ' ', $returnisp);
		while ($elemento < 254) {
			$renglon = $returnisp[$conteo];
			$palabra = explode(" ", $renglon);
			$classid = $palabra[2];
			$cidcortada = explode(":", $classid);
			$ip = "10.42.43." . $cidcortada[1];
			//echo $ip."_";
			$rateup = $palabra[8];
			//echo $rateup."<br>";
			$renglon = $returnisp[$conteo + 1];
			$palabra = explode(" ", $renglon);
			$up = $palabra[2];
			if ($ip == $tabla[$elemento][0]) {
				$tabla[$elemento][3] = $rateup;
				$tabla[$elemento][4] = $up;
				//echo $tabla[$elemento][0] . " " . $tabla[$elemento][1] . " " . $tabla[$elemento][2] . " " . $tabla[$elemento][3] . " " . $tabla[$elemento][4] . "<br>";
				$elemento++;				
			}
			$conteo = $conteo + 6;
		}
		return $tabla;
	}

}

//Instanciamos la tabla, y la manejamos según la funcion
$tc = new tctable;
$tablatc = $tc -> creatabla($ifclan, $ifcisp);
//Consulta tc para ver la velocidad de determinada ip
function getipSpeed($ip) {
	$conteo = 0;
	global $tablatc;
	while ($conteo < 254) {
		if ($tablatc[$conteo][0] == $ip) {
			//Detectar si la exprecion est� dada por bits o kbits
			$patronk = "/[0-9]Kbit/";
			if (preg_match($patronk, $tablatc[$conteo][1])) {
				//Revisar estructura
				$rate_kbits = explode("K", $tablatc[$conteo][1]);
				//Convertimos a kpbs
				$ratedown = ($rate_kbits[0] / 8);
			}
			$patronb = "/[0-9]bit/";
			if (preg_match($patronb, $tablatc[$conteo][1])) {
				$rate_bits = explode("b", $tablatc[$conteo][1]);
				//Convertimos a kpbs
				$ratedown = ($rate_bits[0] / 8) / 1000;
			}
			$conteo = 255;
		}
		$conteo++;
	}
	$conteo = 0;
	while ($conteo < 254) {
		if ($tablatc[$conteo][0] == $ip) {
			//Detectar si la exprecion est� dada por bits o kbits
			$patronk = "/[0-9]Kbit/";
			if (preg_match($patronk, $tablatc[$conteo][3])) {
				//Revisar estructura
				$rate_kbits = explode("K", $tablatc[$conteo][3]);
				//Convertimos a kpbs
				$rateup = ($rate_kbits[0] / 8);
			}
			$patronb = "/[0-9]bit/";
			if (preg_match($patronb, $tablatc[$conteo][3])) {
				$rate_bits = explode("b", $tablatc[$conteo][3]);
				//Convertimos a kpbs
				$rateup = ($rate_bits[0] / 8) / 1000;
			}
			$conteo = 255;
		}
		$conteo++;
	}
	return array($ratedown, $rateup);
}

//Preguntamos por lo que hemos descargado a tc.
function getTransferred($ip) {
	$conteo = 0;
	global $tablatc;
	while ($conteo < 254) {
		if ($tablatc[$conteo][0] == $ip) {
			$down = ($tablatc[$conteo][2] / 1024);
			$up = ($tablatc[$conteo][4] / 1024);
			$conteo = 255;
		}
		$conteo++;
	}
	return array($down, $up);
}

//Trunca una cantidad $number a tantos $digitos
function truncateFloat($number, $digitos) {
	$raiz = 10;
	$multiplicador = pow($raiz, $digitos);
	$resultado = ((int)($number * $multiplicador)) / $multiplicador;
	return number_format($resultado, $digitos, '.', '');
}
?>
