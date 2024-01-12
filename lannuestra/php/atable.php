<?php
if(!isset($_SESSION["admin"])){
	session_start();
}
//Reviza que exista la session y en ese caso procede con todo
if(isset($_SESSION["admin"])){	
	if($_SESSION["admin"]==1){
		//Contestamos con la tabla de usuarios conectados
		require_once ("db.php");
?>
<script type="text/javascript" src="js/atable.js"></script>
<div id="menu">
	<ul>
		<li>
			<a id="m1">Conectados</a>
		</li>
		<li>
			<a id="m2">U. Sesiones</a>
		</li>
	</ul>
</div>
<div id="menu2">
	<ul>
		<li>
			<a id="reset">Reset</a>
		</li>
		<li>
			<a id="cambiar">Editar</a>
		</li>
		<li>
			<a id="kick">Kick</a>
		</li>
	</ul>
</div>
<div class="clr"></div>
<div class="admin">
	<table width="70%" cellpadding="0" cellspacing="0" id="tabla">
		<thead>
			<tr>
				<th scope="col">
				<input type="checkbox" name="allbox" id="allbox" onclick="checkAll()">
				</th>
				<th scope="col">Usuario</th>
				<th scope="col">IP</th>
				<th scope="col">Privilegios</th>
				<th scope="col">Hora</th>
				<th scope="col">Navegador</th>
				<th scope="col">Banda D.</th>
				<th scope="col">Banda S.</th>
				<th scope="col">Bajado</th>
				<th scope="col">Subido</th>
			</tr>
		</thead>
		<?php
		//Sentencias para formar la tabla a partir de los datos de sql
		$arreglot = getAllconnected();
		//El numero de campos que debe haber en cada linea de conectados, cambiar para mas campos
		$columnas = 8;
		require_once ("sbqos.php");
		//Recorremos el arreglo para ponerle los rates y los totales del trafico
		for ($filas = 0; $filas < sizeof($arreglot); $filas++) {
			$arreglot[$i][5] = "Desconocido";
			$arreglot[$i][6] = "Desconocido";
			if (isset($iprates)) {
				for ($i = 0; $i < count($iprates); $i++) {
					if ($iprates[$i][0] == $arreglot[$filas][1]) {
						//Asignamos los rates a sus correspondientes
						$arreglot[$filas][5] = $iprates[$i][1] . "kbps";
						$arreglot[$filas][6] = $iprates[$i][2] . "kbps";
						//Se resta a la lectura actual la de la entrada para sacar el total
						$totaldescargado = $iprates[$i][3] - $arreglot[$filas][6];
						$totalsubido = $iprates[$i][4] - $arreglot[$filas][7];
						if ($totaldescargado < 1024) {
							$arreglot[$filas][7] = truncateFloat($totaldescargado, 2) . "kbs";
						} else if ($totaldescargado > 1024) {
							$arreglot[$filas][7] = (truncateFloat($totaldescargado / 1024, 2)) . "mbs";
						}
						if ($totalsubido < 1024) {
							$arreglot[$filas][8] = truncateFloat($totalsubido, 2) . "kbs";
						} else if ($totalsubido > 1024) {
							$arreglot[$filas][8] = (truncateFloat($totalsubido / 1024, 2)) . "mbs";
						}

					}
				}
			}
		}

		//$columna vuelve a ser 0 para manejar las columnas del arreglo comodamente
		$columna = 0;
		//Recorremos el $arreglot imprimiendo la estructura de la tabla
		//Debemos agregar una estructura que evite que se genere el elemento para 127.0.0.1,
		//pues una regla de iptables que maneje esa direccion podria dejar el servidor offline
		for ($x = 0; $x < ($filas - 1); ++$x) {
			//Filas
			echo '
		<tr>
			';
			$columna = 0;
			for ($y = 0; $y < $columnas + 1; ++$y) {
				//Columnas
				if ($y == 0) {
					echo '<td>
			<input type="checkbox" name="allbox" class="signbox" id="' . $arreglot[$x][1] . '">
			</td>';
				}
				echo '<td>';
				if ($arreglot[$x][2] == '0') {
					$arreglot[$x][2] = 'Administrador';
				}
				if ($arreglot[$x][2] == '1') {
					$arreglot[$x][2] = 'Usuario';
				}
				echo $arreglot[$x][$columna] . '</td>';
				$columna++;
			}
			// cerramos X
			echo '
		</tr>
		';
		}
		echo '
	</table>
	';
		?>
<div class="clr"></div>
</div>
<div id="uconectados">
	<p>Elije una fecha para ver quienes se conectaron ese dia</p>
	<div class="clr"></div>
	<input type="text" name="fecha" id="campofecha">
</div>
<div class="clr"></div>
<?php
echo '
<p>
Hay: '; echo ($filas-1).' Usuarios navegando.
</p>
';
?>
<div id="edialog" title="Editar">
	<div>
	<form method="post" action="javascript: sendEdit()" id="ajuste">
		<fieldset>
			<label for="rated">Bajada</label>
			<input type="text" value="" name="rated" id="rated" />
			<label for="rateu">Subida</label>
			<input type="text" value="" name="rateu" id="rateu" />
			<p>
				<input type="submit" value="Ok" id="esend"/>
				<input type="button" value="Cancelar" id="cedit" />
			</p>
		</fieldset>
	</form>
	</div>
</div>
<?php
}
else{
//En caso de que se intente acceder a la script sin administrador
echo "
<script>
alert('Ha ocurrido un error');
</script>
";
}
}
else{
//En caso de que se intente acceder a la script sin una session
echo "
<script>
alert('Ha ocurrido un error');
</script>
";
}
?> 