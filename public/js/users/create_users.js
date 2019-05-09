function cargarFormualrioUser(arg){
	if (arg == 1) {
		
		var url = "/users/registraruser";
	}

	//$('#contenido-principal').html($("#cargador-usuario").html());

	/*$.get(url, function(result){
		$("#contenido-principal").html(result);
	});*/
}

$(document).on("submit",".form-entrada", function(e){
	e.preventDefault();

	$('html, body').animate({scrollTop: '0px'}, 200);

	var formu = $(this);
	var quien = $(this).attr("id");

	if (quien == "f_nuevo_usuario") {
		var varurl = "/users/agregaruser";
		var divresult = "notificacion_result_fanu";
	}

	$("#"+divresult+"").html($("#cargador-usuario").html());

	$.ajax({
		type: "POST",
		url: varurl,
		datatype: "json",
		data: formu.serialize(),
		success: function(result){
			$("#"+divresult+"").html(result);
			$("#"+quien+"").trigger("reset");
		}
	});
});