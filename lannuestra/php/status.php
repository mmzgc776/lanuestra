<?
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<meta http-equiv="last-modified" content="0">
		<meta http-equiv="expires" content="0">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="pragma" content="no-cache">
		<META HTTP-EQUIV="Expires" CONTENT="-1">
		<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
		<meta http-equiv="Last-Modified" content="Sun, 25 Jul 2004 16:12:09 GMT">
		<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
		<meta http-equiv="Pragma" content="nocache">
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<title>Lan-Nuestra</title>
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/status.js"></script>
		<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
	</head>
	<body id="statusbody">
		<div class="header">
			<div class="header_resize_small">
				<div class="clr"></div>
				<div class="logo">
					<h1 id="small"><small>PHP + iptables + tc + Portal Captivo</small><a href="index.html">LANuestra<span> beta</span></a></h1>
				</div>
			</div>
			<div id="salida">
				<table width="70%" cellpadding="0" cellspacing="0" id="tablastatus">
					<?php
					//Script global
					require_once ('gconf.php');
					//Script de funciones
					require_once ('functions.php');
					//Pintará la tabla con los datos necesarios
					//$ip
					$ip = $_SERVER['REMOTE_ADDR'];
					if (isset($_SESSION['logged'])) {
						$segundos = 0;
						$minutos = 0;
						$horas = 0;
						$segundos = time() - $_SESSION['logged'];
						$horas = floor($segundos / (60 * 60));
						$minutos = floor($segundos / 60);
						$segundos = $segundos % 60;
						//$horas=$minutos/60;
						$horas = $horas . ":" . $minutos . ":" . $segundos;
					} else {
						$_SESSION['logged'] = time();
						$horas = "0:0:0";
					}
					//Preguntamos a tc la velocidad de bajada y subida de cada ip usando sus interfaces.
					$ipspeeds = getipSpeed($ip);
					//Descriptivo
					$ratedown = truncateFloat($ipspeeds[0], 1);					
					$rateup = truncateFloat($ipspeeds[1], 1);					
					//Preguntamos por el valor de las transferencias.
					$iptrans = getTransferred($ip);
					$down = $iptrans[0];
					if (isset($_SESSION["down"])) {
						//Se resta y se trunca
						$down = truncateFloat($down - $_SESSION["down"], 1);
					} else {
						$_SESSION["down"] = $down;
						$down = 0;
					}
					$up = $iptrans[1];
					if (isset($_SESSION["up"])) {
						//Se resta y se trunca
						$up = truncateFloat($up - $_SESSION["up"], 1);
					} else {
						$_SESSION["up"] = $up;
						$up = 0;
					}
					for ($y = 0; $y < 7; $y++) {
						//Filas
						echo "<tr>";
						for ($x = 0; $x < 2; $x++) {
							echo '<td>';
							if ($x == 0) {
								switch($y) {
									case 0 :
										echo("Dirección");
										break;
									case 1 :
										echo("Tiempo");
										break;
									case 2 :
										echo("V. Bajada");
										break;
									case 3 :
										echo("V. Subida");
										break;
									case 4 :
										echo("Bajado");
										break;
									case 5 :
										echo("Subido");
										break;
									case 6 :
										echo("T. Restante");
										break;
								}
							}
							if ($x == 1) {
								switch($y) {
									case 0 :
										//IP
										echo "<div>" . $ip . "</div>";
										break;
									case 1 :
										//Tiempo, aquí sería bueno agregar un cronometro en javascript
										echo "<div>" . $horas . "</div>";
										break;
									case 2 :
										echo "<div>De " . $ratedown . " a " . $totaldn * .8 . "KB/s</div>";
										break;
									case 3 :
										echo "<div>De " . $rateup . " a " . $totalup * .8 . "KB/s</div>";
										break;
									case 4 :
										echo "<div>" . $down . "KBs</div>";
										break;
									case 5 :
										echo "<div>" . $up . "KBs</div>";
										break;
									case 6 :
										echo "<div>-------</div>";
										break;
								}
							}
							echo '</td>';
						}
						echo '</tr>';
					}
					echo '</table>';
					?>
					<div id="upanel">
						<input type="button" value="Desconectarme" id="logoff" />
						<br>
						<input type="button" value="Cambiar contraseña" id="buttoncpass" />
					</div>
			</div>
			<div id="cpass">
				<form method="post" action="" id="cpassform">
					<fieldset>
						<label for="oldpass">Contraseña anterior</label>
						<input type="password" value="" name="oldpass" id="oldpass" />
						<label for="newpass1">Contraseña nueva</label>
						<input type="password" value="" name="newpass1" id="newpass1" />
						<label for="newpass2">Repite tu contraseña</label>
						<input type="password" value="" name="newpass2" id="newpass2" />
						<p>
							<input type="submit" value="Ok" id="changepass"/>
							<input type="button" value="Cancelar" id="cancelcpass" />
						</p>
					</fieldset>
				</form>
			</div>
			<div class="clr"></div>
		</div>
	</body>
</html>
