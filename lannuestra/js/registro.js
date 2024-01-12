//cambios
$("#salida").css('display', 'inline');
$("#h2").html("Registro");
document.getElementById("login").style.display = ("none");
//eventos
$("#registro").click(function() {
	//validar los datos si todo bien enviar los datos
	if(vNombre() & vPas1() & vPas2() & vMail() == true) {
		data = (jQuery("#fregistro").serialize());
		$.post(jQuery("#fregistro").attr("action"), data, function(respuesta) {
			if(respuesta) {
				if(respuesta == 0) {
					alert("Cuenta creada satisfactoriamente");
					redireccion();
				}
				if(respuesta == 1) {
					alert("El usuario ya existe");
					$("#rcod").next("span").css('display', 'inline');
					$("#srcod").html('Ya existe el usuario.');
					$("#rcod").next("span").css('color', 'red');
				}
				if(respuesta == 2) {
					alert("El mail ya se usó");
					$("#mail").next("span").css('display', 'inline');
					$("#smail").html('El mail ya se usó.');
					$("#mail").next("span").css('color', 'red');
				}
			} else
				alert("Ha ocurrido un error :(");
		});
	} else {
		alert("Los datos son invalidos");
	}
})

$("#rcod").focus(function() {
	vTodo();
})

$("#pas1").focus(function() {
	vTodo();
})

$("#pas2").focus(function() {
	vTodo();
})

$("#mail").focus(function() {
	vTodo();
})
//funciones
function validarEmail(valor) {
	if(/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/.test(valor)) {
		return true;
	} else {
		return false;
	}
}

function validarNombre(valor) {
	if((/^[A-Za-z0-9ñÑ][A-Za-z0-9_ñÑ]{2,12}$/.test(valor))) {
		return true;
	} else {
		return false;
	}
}

function vNombre() {
	vnombre = validarNombre(document.getElementById("rcod").value);
	if(vnombre == false) {
		//Mostrar que el nombre está mal
		$("#rcod").next("span").css('display', 'inline');
	} else {
		$("#rcod").next("span").css('display', 'none');
	}
	return vnombre;
}

function vPas1() {
	vpas1 = validarNombre(document.getElementById("pas1").value);
	if(vpas1 == false) {
		//Mostrar que el nombre está mal
		$("#pas1").next("span").css('display', 'inline');
	} else {
		$("#pas1").next("span").css('display', 'none');
	}
	return vpas1;
}

function vPas2() {
	pas1 = document.getElementById("pas1").value;
	pas2 = document.getElementById("pas2").value;
	if(pas1 == pas2) {
		$("#pas2").next("span").css('display', 'none');
		out = true;
		if(pas1 == "") {
			$("#spas2").html('Reescribe tu contraseña.');
			$("#pas2").next("span").css('display', 'inline');
			out = false;
		}
	} else {
		$("#spas2").html('Las contraseñas no coinciden.');
		$("#pas2").next("span").css('display', 'inline');
		out = false;
	}
	return out;
}

function vMail() {
	vmail = validarEmail(document.getElementById("mail").value);
	if(vmail == true) {
		$("#mail").next("span").css('display', 'none');
	} else {
		$("#mail").next("span").css('display', 'inline');
	}
	return vmail;
}

function vTodo() {
	vNombre();
	vPas1();
	vPas2();
	vMail();
}