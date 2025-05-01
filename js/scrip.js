
$(document).ready(function () {
	$("#bien").hide();
	$("#adve").hide();
	$("#mal").hide();
	$("#Bienvenido").hide();
	$('#Bienvenido').fadeOut(9000);

});


// ----------------------alertas---------------------------

function exito(texto) {
	$('#bien').html("<strong>Excelente!</strong> <br>  " + texto);
	$("#bien").show();
	$('#bien').fadeOut(9000);
}

function error(texto) {
	$('#mal').html(texto);
	$("#mal").show();
	$('#mal').fadeOut(9000);
}
function alerta(texto) {
	$('#adve').html("<strong>Alerta!!...</strong>  <br> " + texto);
	$("#adve").show();
	$('#adve').fadeOut(8000);
}



// -------------------------------
