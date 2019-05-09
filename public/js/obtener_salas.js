$(function(){
	
	$("#select-lugar").on('change', onSelectLugarChange);

});

function onSelectLugarChange(){
		var lugar_id = $(this).val();

		if (!lugar_id) {
			$("#select-item_lugar").html('<option value="">Selecciona Mobiliario</option>');
			return;
		}



		//ajax
		$.get('/api/lugar/'+lugar_id+'/mobi', function(data){
			var html_select = '<option value="">Selecciona</option>';
			var html_tabla = '<td></td>';
			for(var i=0; i < data.length; i++){
				html_select += '<option value="'+data[i].lugar_id+'">'+data[i].item_id+'</option>';

				if (!data[i].item_id) {
						$("#filas-tabla_pcs").html('<td></td>');
					}

				$.get('/api/mobi/'+data[i].item_id+'/items', function(pcs){
					
						for(var j = 0; j < pcs.length; j++){
							html_tabla += '<td>'+pcs[j].num_maquina+'</td>';
							html_tabla += '<td>'+pcs[j].tiene_camara+'</td>';
							html_tabla += '<td>'+pcs[j].num_serie_cpu+'</td>';
							$("#filas-tabla_pcs").html(html_tabla);
						}
					
				});
					
			}
			$("#select-item_lugar").html(html_select);
		});

	}