<script type="text/javascript" src="/js/registro.js"></script>
<form method="post" action="php/registro.php" id="fregistro">
	<fieldset>
		<div>
			<label for="cod">Nombre</label>
		</div>
		<div class="clr"></div>
		<input type="text" value="" maxlength="12" name="rcod" id="rcod" />
		<span id="srcod">3 a 12 caracteres, sin espacios.</span>
		<div>
			<label for="pas">Contraseña</label>
		</div>
		<div class="clr"></div>
		<input type="password" value="" name="pas1" id="pas1" />
		<span>Debe ser de 3 a 12 caracteres, sin espacios.</span>
		<div>
			<label for="pas">Repite tu contraseña</label>
		</div>
		<div class="clr"></div>
		<input type="password" value="" name="pas2" id="pas2" />
		<span id="spas2">Reescribe tu contraseña.</span>
		<div>
			<label for="pas">Email</label>
		</div>
		<div class="clr"></div>
		<input type="text" value="" name="mail" id="mail" />
		<span id="smail">Escribe un email valido.</span>
		<div class="clr"></div>
		<p>
			<input type="button" value="Registrate" id="registro" />
		</p>
	</fieldset>
</form>
