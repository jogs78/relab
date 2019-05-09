$(function(){
	alert('hey');
	buscar_datos();
});

function buscar_datos(consulta){
	var request = $.ajax({
		url: 'http://relab.isc.ittg.mx/users/search',
		type: 'POST',
		dataType: 'html',
		data: {consulta: consulta},
		success: function (output) {
        // aqui tu respuesta se enseña en consola
        console.log(output);
    }

	});
	request.done(function(respuesta){
		 console.log('La peticion AJAX se ha enviado correctamente ');
		$("#datos").html(respuesta);
	});
	request.fail(function( jqXHR, textStatus, errorThrown ) {

  	console.log(jqXHR);
  	console.log(textStatus);
  	console.log(errorThrown);
});
}

$(document).on('keyup','#search', function(){
	var valor = $(this).val();

	if (valor != "") {
		buscar_datos(valor);
	}else{
		buscar_datos();
	}
});