<?php
class db extends SQLite3 {
	function __construct() {
		$this -> open("lannuestra.db");
	}
}

//Agrega un usuario a la bd
function altaUsuario($nombre, $password, $priv, $mail, $fecha) {
	$dbhandler = new db;
	$consulta = 'INSERT INTO usuarios (nombre, password, privilegio, email, fecha)
 								VALUES("' . $nombre . '","' . $password . '","' . $priv . '","' . $mail . '","' . $fecha . '")';
	$dbhandler -> query($consulta);
	$dbhandler -> close();
}

//Elimina un usuario de la base de datos
function bajaUsuario($nombre) {

}

//Busca un usuario en la base de datos
function buscaUsuario($nombre) {
	$dbhandler = new db;
	$consulta = 'SELECT * FROM usuarios WHERE nombre="' . $nombre . '"';
	$respuesta = $dbhandler -> query($consulta);
	$array = $respuesta -> fetchArray(SQLITE3_NUM);
	$dbhandler -> close();
	return $array;
}

//Buscar el nombre o correo
function buscarUseromail($nombre, $mail) {
	$dbhandler = new db;
	$consulta = "SELECT nombre, email FROM usuarios WHERE nombre='" . $nombre . "' OR email='" . $mail . "'";
	$respuesta = $dbhandler -> query($consulta);
	$array = $respuesta -> fetchArray(SQLITE3_NUM);
	$dbhandler -> close();
	return $array;
}

//La contraseña de un usuario en la base de datos
function updatePass($nombre, $password) {

}

//Cambia la fecha de la ultima entrada
function updateDate($nombre, $fecha) {
	$dbhandler = new db;
	$consulta = 'UPDATE usuarios SET fecha="' . $fecha . '" WHERE nombre="' . $nombre . '"';
	$respuesta = $dbhandler -> query($consulta);
	$dbhandler -> close();
}

//Funciones que tienen que ver con conectados.csv
//Reviza la tabla de conectados para ver si existe un nombre
function checaConectado($nombre) {
	$dbhandler = new db;
	$consulta = 'SELECT EXISTS (SELECT 1 FROM conectados WHERE nombre="' . $nombre . '")';
	$respuesta = $dbhandler -> query($consulta);
	$renglon = $respuesta -> fetchArray();
	$existe = $renglon[0];
	$dbhandler -> close();
	return $existe;
}

//Registra un usuario como conectado para su uso más delante
function registraConectado($user, $ipaddr, $priv, $navegador, $down, $up) {
	$dbhandler = new db;
	$consulta = 'INSERT INTO conectados (nombre, ip, privilegio, entrada, navegador, editado, dantes, santes)
 							  VALUES("' . $user . '","' . $ipaddr . '","' . $priv . '","' . date("H:i:s") . '","' . $navegador . '",0,"' . $down . '","' . $up . '")';
	$dbhandler -> query($consulta);
	$dbhandler -> close();
}

//Obtiene un arreglo con las ips conectadas
function getConectedips() {
	$dbhandler = new db;
	$ips = array(0);
	$consulta = 'SELECT ip FROM conectados where editado="0"';
	$respuesta = $dbhandler -> query($consulta);
	$contador = 0;
	while ($renglon = $respuesta -> fetchArray()) {
		$ips[$contador] = $renglon[0];
		$contador++;
	}
	return $ips;
}

//Leer todo conectados para generar la tabla de administracion
function getAllconnected() {
	$dbhandler = new db;
	$contador = 0;
	$consulta = 'SELECT * FROM conectados';
	$respuesta = $dbhandler -> query($consulta);
	while ($renglon = $respuesta -> fetchArray()) {
		for ($i = 0; $i < sizeof($renglon); $i++) {
			$arreglot[$contador][$i] = $renglon[$i];
		}
		$contador++;
	}
	return $arreglot;
}

//Elimina un usuario por ip
function bajaConectados($ip) {
	$dbhandler = new db;
	$consulta = 'DELETE FROM conectados WHERE ip="' . $ip . '"';
	$respuesta = $dbhandler -> query($consulta);
	$dbhandler -> close();
}

//Cambia la bandera de editado
function updateCustomstatus($ip, $status) {
	$dbhandler = new db;
	if ($status == 1) {
		$status = 0;
	} else {
		$status = 1;
	}
	$consulta = 'UPDATE conectados SET editado="' . $status . '" WHERE ip="' . $ip . '"';
	$respuesta = $dbhandler -> query($consulta);
	$dbhandler -> close();
}
?>