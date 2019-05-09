$(function(){
	
	$("#clasificacion-mobi").on('change', onSelectItemChange);

});

function onSelectItemChange(){
		var clasi = $(this).val();

		if (clasi == "Pc") {
			alert('Pc');
			//$("#btn-guardaritem").html('value="Siguiente"');
			//html_boton += '<input type="submit" value="Siguiente" />';
		}

	}
