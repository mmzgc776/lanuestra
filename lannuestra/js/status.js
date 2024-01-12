$('document').ready(function() {
	$("#cpass").css('display', 'none');	
	$('#logoff').click(function() {
		//yes no para desconectarme
		
	});
	$('#buttoncpass').click(function() {	
		//Mostrar formulario de cambio.
		$("#salida").css('display', 'none');
		$("#cpass").css('display', 'inline');
	});
	
	$('#cancelcpass').click(function() {	
		//Mostrar formulario de cambio.
		$("#salida").css('display', 'inline');
		$("#cpass").css('display', 'none');
	});
	
	
});