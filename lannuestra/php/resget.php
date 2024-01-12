<?php
/*******************************************/
/*Esta script deberá obtener copia del log */
/*de iptables para fin de que se generen   */
/* estadisticas							   */
/*******************************************/

//Debemos generar un log más limpio, por tanto más pequeño
$filehandle2 = fopen("/var/www/php/logs/" . date("Y-m-d") . ".log", "a");
//Archivo con los logs de iptables
$file_handle = fopen("/var/log/iptables.log", "r");
while (!feof($file_handle)) {
	//Al parecer aunque especifique que separe por = no funciona por eso explode adelante
	$line = fgetcsv($file_handle, "=");
	//echo $line[0] . "\n";
	$datos = explode("=", $line[0]);
	//Aislamos la fuente
	if (isset($datos[4])) {
		$srcfull = $datos[4];
		$srcdirty = explode(" ", $srcfull);
		$src = $srcdirty[0];
		//echo $src . "\n";
	}

	//Aislamos el destino
	if (isset($datos[5])) {
		$dstfull = $datos[5];
		$dstdirty = explode(" ", $dstfull);
		$dst = $dstdirty[0];
		//echo $dst . "\n";
	}
	fwrite($filehandle2, $src . "," . $dst . chr(13) . chr(10));
}
fclose($file_handle);
fclose($filehandle2);
exec("rm /var/log/iptables.log", $return);
?>