//Esta script contiene las funciones principales de la pagina del proyecto

//Recarga la pagina para redirigir o mantener los datos actualizados
function redireccion() {
	location.reload(true);
}

//Este segmento es para obtener el nombre y version del navegador
function getNombre() {
	var nVer = navigator.appVersion;
	var nAgt = navigator.userAgent;
	var browserName = navigator.appName;
	var nameOffset, verOffset, ix;
	var fullVersion = '' + parseFloat(navigator.appVersion);

	if(( verOffset = nAgt.indexOf("MSIE")) != -1) {
		browserName = "Explorer";
	} else if(( verOffset = nAgt.indexOf("Opera")) != -1) {
		browserName = "Opera";
	} else if(( verOffset = nAgt.indexOf("Chrome")) != -1) {
		browserName = "Chrome";
	} else if(( verOffset = nAgt.indexOf("Safari")) != -1) {
		browserName = "Safari";
	} else if(( verOffset = nAgt.indexOf("Firefox")) != -1) {
		browserName = "Firefox";
	}
	// para otros navegadores busca el nombre al final del userAgent
	else if(( nameOffset = nAgt.lastIndexOf(' ') + 1) < ( verOffset = nAgt.lastIndexOf('/'))) {
		browserName = nAgt.substring(nameOffset, verOffset);
		fullVersion = nAgt.substring(verOffset + 1);
		if(browserName.toLowerCase() == browserName.toUpperCase()) {
			browserName = navigator.appName;
		}
	}
	if(( ix = fullVersion.indexOf(";")) != -1)
		fullVersion = fullVersion.substring(0, ix);
	if(( ix = fullVersion.indexOf(" ")) != -1)
		fullVersion = fullVersion.substring(0, ix);
	return (browserName);
}

//Reviza si existe una session
function checksession() {
	$.get('php/scheck.php', function(data) {
		if(data == 1) {
			$.get("php/atable.php", function(tresp) {
				jQuery('#salida').html(tresp);
			});
			$("#salida").css('display', 'inline');
		}
	});
}
//Envia el formulario de inicio de sesion
function send() {
	success = false;
	nNombre = getNombre();	
	datos = ($('#login').serialize() + "&url=" + encodeURI(url) + "&nav=" + nNombre);	
	//alert(datos);
	$.ajax({
		type : 'POST',
		url : "/php/validar.php",
		data : datos,
		async : false, //Aquí está la magia para esperar hasta la respuesta
		success : function(respuesta) {
			if(respuesta) {
				if(respuesta == 1) {
					setTimeout("redireccion()", 5000);
					alert("Si tu navegador no redirije automaticamente en 5 segundos, actualiza la pagina");
					$("#login").css('display', 'none');
					$("#salida").css('display', 'none');
				}
				if(respuesta == 2) {
					alert('Nombre de usuario no existe, o contraseña incorrecta');
					$("#salida").css('display', 'none');
					$("#cod").val('');
					$("#pas").val('');
				}
				if(respuesta == 3) {
					alert("La cuenta está en uso, prueba con otra");
					$("#salida").css('display', 'none');
					$("#cod").val('');
					$("#pas").val('');
				}
				if(respuesta == 4) {
					setTimeout("redireccion()", 5000);
					alert("Si tu navegador no redirije automaticamente en 5 segundos, actualiza la pagina");
					$("#login").css('display', 'none');
					$("#salida").css('display', 'none');
					success = true;
				}
				$('#salida').html(respuesta);
			} else
				alert('Ha ocurrido un error :(');
		}
	});
	if(success) {
			window.open('http://10.42.43.254/php/status.php', 'pag', 'width=250,height=320	,menubar=no,scrollbars=no,resizable=no');
	}
	//Solia usar $.post en ves de $.ajax
	/*$.post('php/validar.php', datos, function(respuesta) {
	 if(respuesta) {
	 if(respuesta == 1)...
	 */
}

$('document').ready(function() {
	url = document.URL;
	checksession();
	$('#bregistro').click(function() {
		$.get("/php/fregistro.php", function(tresp) {
			$('#salida').html(tresp);
		});
	});
	$('#login').submit(function() {
		send();
		return false;
	});
	setTimeout("redireccion()", 300000);
});
