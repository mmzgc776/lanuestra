<?php
require_once ("db.php");

//echo checaConectado("melissa");
/***Vacum para compactar la base 
 $dbhandler = new db;
 $consulta = 'VACUUM';
 $respuesta = $dbhandler -> query($consulta);
 $array = $respuesta -> fetchArray(SQLITE3_NUM);
 for ($i = 0; $i < sizeof($array); $i++) {
 echo $array[$i] . "|";
 }
 $dbhandler -> close();
*/

/*Muestra los conectados cierta fecha*/
$date = new DateTime("now");
//$date -> modify(" -  day");
$dateNow=$date ->format('Y-m-d');
echo $dateNow;
echo "<br>";
//$date -> modify(" - 4 month");
//$datetoDelete=$date ->format('Y-m-d');
$dbhandler = new db;
$numero = 0;
$consulta = 'SELECT * FROM usuarios WHERE fecha="'.$dateNow.'"';
echo $consulta;
echo "<br>";
$respuesta = $dbhandler -> query($consulta);
while ($renglon = $respuesta -> fetchArray()) {
	for ($i = 0; $i < sizeof($renglon); $i++) {
		echo $renglon[$i] . "|";
	}
	echo "<br>";
	$numero++;
}
echo $numero;
/*
 * $consulta = 'ALTER TABLE boletos ADD COLUMN usadopor TEXT';
$respuesta = $dbhandler -> query($consulta);
while ($renglon = $respuesta -> fetchArray()) {
	for ($i = 0; $i < sizeof($renglon); $i++) {
		echo $renglon[$i] . "|";
	}
	echo "<br>";
}
 * */

/***********Eliminamos todos los usuarios viejos de las listas de comas
$consulta = 'DELETE FROM usuarios WHERE fecha="2013-01-10"';
$respuesta = $dbhandler -> query($consulta);
while ($renglon = $respuesta -> fetchArray()) {
	for ($i = 0; $i < sizeof($renglon); $i++) {
		echo $renglon[$i] . "|";
	}
	echo "<br>";
	$numero++;
}
echo $numero;
*/

/*echo "<br>";
 $otraconsulta = 'UPDATE usuarios SET fecha="2012-12-12" WHERE nombre="Cr7"';
 $respuesta = $dbhandler -> query($otraconsulta);
 $array = $respuesta -> fetchArray(SQLITE3_NUM);
 for ($i = 0; $i < sizeof($array); $i++) {
 echo $array[$i] . "|";
 }
 $consulta = 'SELECT * FROM usuarios WHERE nombre="Cr7"';
 $respuesta = $dbhandler -> query($consulta);
 $array = $respuesta -> fetchArray(SQLITE3_NUM);
 for ($i = 0; $i < sizeof($array); $i++) {
 echo $array[$i] . "|";
 }
 $dbhandler -> close();

 //------------Leer usuarios.csv para realizar una inserción de todo a la tabla usuarios
 /*$gestor = fopen("usuarios.csv", "r");
 if ($gestor) {
 while (!feof($gestor)) {
 $datos = fgetcsv($gestor, ",");
 $comando = 'INSERT INTO usuarios (nombre, password, privilegio, email, fecha)
 VALUES("' . $datos[0] . '","' . $datos[1] . '","' . $datos[2] . '","' . $datos[3] . '","' . $datos[4] . '")';
 echo $comando . "<br>";
 $respuesta = $dbhandler -> query($comando);
 //$array= $respuesta -> fetchArray(SQLITE3_ASSOC);
 //for($i=0;$i<sizeof($array);$i++){
 //	echo $array[$i];
 //}
 }
 }*/

//------------Leer usuarios.csv para realizar borrado de todo a la tabla usuarios
/*$gestor = fopen("usuarios.csv", "r");
 if ($gestor) {
 while (!feof($gestor)) {
 $datos = fgetcsv($gestor, ",");
 $comando = 'DELETE FROM usuarios WHERE nombre="'.$datos[0].'"';
 echo $comando . "<br>";
 $dbresponse = $dbhandler -> query($comando);
 }
 }*/

//------------Leer usuarios.csv para ver contenido de la tabla usuarios
/*$gestor = fopen("usuarios.csv", "r");
 if ($gestor) {
 while (!feof($gestor)) {
 $datos = fgetcsv($gestor, ",");
 $comando = 'SELECT * FROM usuarios WHERE nombre="'.$datos[0].'"';
 echo $comando . "<br>";
 $respuesta = $dbhandler -> query($comando);
 $array = $respuesta -> fetchArray(SQLITE3_NUM);
 for($i=0;$i<sizeof($array);$i++){
 echo $array[$i]."|";
 }
 echo "<br>";
 echo sizeof($array);
 echo "<br>";
 }
 }*/
?>