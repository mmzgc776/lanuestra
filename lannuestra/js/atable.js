//Esta script contiene las funciones del panel de andministración
$("#h2").html("Panel de Administración");
$("#salida").css('display', 'inline');
$("#login").css('display', 'none');
$("#welcome").css('display', 'none');
$("#uconectados").css('display', 'none');
checked = false;

//Genera el calendario
/*$("#campofecha").datepicker({
dateFormat : "yy-mm-dd",
changeYear : true
});*/

/////Eventos click
//Muestra los informes de ultimos conectados
$("#m2").click(function() {
	$("#tabla").css('display', 'none');
	$("#uconectados").css('display', 'inline');
});
//Muestra el panel de conectados
$("#m1").click(function() {
	$("#tabla").css('display', 'inline');
	$("#uconectados").css('display', 'none');
	//$("#m2").css('background-color', '#e8e3e3');
});
//Cancela la edicion en el dialogo
$("#cedit").click(function() {
	edialogShow();
});
//Abre el dialogo de edicion de qos..
$("#cambiar").click(function() {
	//Mostramos el dialog, con su formulario para asignar el ancho de banda
	//getIps devuelve una matriz con las ips seleccionadas...
	if(getIps().length > 0) {
		edialogShow();
		//alert(getIps());
	} else {
		alert("Selecciona uno o varios elementos");
	}
});
//Resetear las configuraciones de qos...
$("#reset").click(function() {
	if(getIps().length > 0) {
		creset = confirm('Está seguro que quiere reestablecer los elementos seleccionados?');
		if(creset == true) {
			//alert("Llamar a la script");
			ips = getIps();
			for( i = 0; i < ips.length; i++) {
				data = ("ip=" + ips[i]);
				$.post('php/reset.php', data, function(respuesta) {
					if(respuesta) {
						if(respuesta == 1) {
							alert("Se ha intentado modificar satisfactoriamente (" + respuesta + ")");
						} else {
							alert("Ha ocurrido un error (" + respuesta + ")");
						}
					}
				});
			}
		} else {
			//alert("No llamar a la script");
		}
	} else {
		alert("Selecciona uno o varios elementos");
	}
});
//Cerrar el trafico y obligar a reautentificarse
$("#kick").click(function() {
	if(getIps().length > 0) {
		ckick = confirm('Está seguro que quiere negar el acceso a los elementos seleccionados?');
		if(ckick == true) {
			//alert("Llamar a la script");
			ips = getIps();
			for( i = 0; i < ips.length; i++) {
				data = ("ip=" + ips[i]);
				$.post('php/kick.php', data, function(respuesta) {
					if(respuesta) {
						alert("Se ha intentado modificar satisfactoriamente (" + respuesta + ")");
					}
				});
			}
		} else {
			//alert("No llamar a la script");
		}
	} else {
		alert("Selecciona uno o varios elementos");
	}
});
/////Funciones

//Devuelve una matriz con las ips seleccionadas...
function getIps() {
	ips = [];
	i = 0;
	$(".signbox").each(function() {
		if($(this).attr('checked')) {
			ips[i] = $(this).attr("id");
			i++;
		}
	});
	return (ips);
}

//Quita la palomita a todas las chkboxes
function uncheckAll() {
	if(checked == true) {
		$(".signbox").removeAttr("checked");
		$("#allbox").unbind("click");
		$("#allbox").click(function() {
			checkAll();
		});
		checked = false;
	}
}

//Pone la palomita a todas las chkboxes
function checkAll() {
	if(checked == false) {
		$(":checkbox:not(:checked)").attr("checked", "checked");
		$("#allbox").unbind("click");
		$("#allbox").click(function() {
			uncheckAll();
		});
		checked = true;
	}
}

//Prepara y envia los cambios a aplicar
function sendEdit() {
	ips = getIps();
	for( i = 0; i < ips.length; i++) {
		data = ("ip=" + ips[i] + "&" + $('#ajuste').serialize());
		//alert(data);
		$.post('php/ajustar.php', data, function(respuesta) {
			if(respuesta) {
				if(respuesta == 1) {
					alert("Se ha intentado modificar satisfactoriamente (" + respuesta + ")");
				} else {
					alert("Ha ocurrido un error (" + respuesta + ")");
				}

			}
		});
	}
	edialogShow();
}

//Muestra el dialogo de edicion
function edialogShow() {
	el = document.getElementById("edialog");
	el.style.visibility = (el.style.visibility == "visible") ? "hidden" : "visible";
}