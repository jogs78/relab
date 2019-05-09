$(document).on('click', '.edit-rev', function(event){
              event.preventDefault();
              var id = $(this).attr('id');
              
              $.ajax({
                url: "/rev_fetchdata/"+id,
                method: "get",
                dataType: 'json',
                success:function(data){
                  var html ='';
                  var htmlRap  = '';
                  var tipoHtml = '';
                  
                  if (data.tipo != '') {

                    if (data.tipo == 'Detallada' || data.tipo == 'detallada') {
                      $("#user_id_edit").val(data.user_id);
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#tipo_edit").val(data.tipo);
                      $("#momento_edit").val(data.momento);
                      $("#observaciones_edit").val(data.observaciones);
                      $("#created_at_edit").val(data.created_at);
                      $("#updated_at_edit").val(data.updated_at);
                      html += '<label for="last_name">Id del Item</label>';
                      html += '<input type="text" class="form-control" name="item_id_edit" id="item_id_edit" value="'+data.item_id+'" disabled>';
                      html += '<label for="last_name">Número de Maquina</label>';
                      html += '<input type="text" class="form-control" name="num_maquina_edit" id="num_maquina_edit" value="'+data.num_maquina+'" disabled>';
                      if (data.tiene_camara == 1) {
                        html += '<label for="last_name">Tiene Cámara</label>';
                        html += '<input type="text" class="form-control" name="tiene_camara_edit" id="tiene_camara_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Tiene Cámara</label>';
                        html += '<input type="text" class="form-control" name="tiene_camara_edit" id="tiene_camara_edit" value="No" disabled>';
                      }
                      if (data.tiene_bocinas == 1) {
                        html += '<label for="last_name">Tiene Bocinas</label>';
                        html += '<input type="text" class="form-control" name="tiene_bocinas_edit" id="tiene_bocinas_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Tiene Bocinas</label>';
                        html += '<input type="text" class="form-control" name="tiene_bocinas_edit" id="tiene_bocinas_edit" value="No" disabled>';
                      }
                      html += '<label for="last_name">Número de Serie CPU</label>';
                      html += '<input type="text" class="form-control" name="num_serie_cpu_edit" id="num_serie_cpu_edit" value="'+data.num_serie_cpu+'" disabled>';
                      html += '<label for="last_name">RAM</label>';
                      html += '<input type="text" class="form-control" name="ram_edit" id="ram_edit" value="'+data.ram+'" disabled>';
                      html += '<label for="last_name">Disco Duro</label>';
                      html += '<input type="text" class="form-control" name="disco_duro_edit" id="disco_duro_edit" value="'+data.disco_duro+'" disabled>';
                      html += '<label for="last_name">Sistema Operativo</label>';
                      html += '<input type="text" class="form-control" name="sistema_operativo_edit" id="sistema_operativo_edit" value="'+data.sistema_operativo+'" disabled>';
                      if (data.sistema_operativo_activado == 1) {
                        html += '<label for="last_name">Sistema Operativo Activado</label>';
                        html += '<input type="text" class="form-control" name="sitema_operativo_activado_edit" id="sitema_operativo_activado_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Sistema Operativo Activado</label>';
                        html += '<input type="text" class="form-control" name="sitema_operativo_activado_edit" id="sitema_operativo_activado_edit" value="No" disabled>';
                      }
                      if (data.cable_vga == 1) {
                        html += '<label for="last_name">Cable VGA</label>';
                        html += '<input type="text" class="form-control" name="cable_vga_edit" id="cable_vga_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Cable VGA</label>';
                        html += '<input type="text" class="form-control" name="cable_vga_edit" id="cable_vga_edit" value="No" disabled>';
                      }
                      if (data.tiene_monitor == 1) {
                        html += '<label for="last_name">Tiene Monitor</label>';
                        html += '<input type="text" class="form-control" name="tiene_monitor_edit" id="tiene_monitor_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Tiene Monitor</label>';
                        html += '<input type="text" class="form-control" name="tiene_monitor_edit" id="tiene_monitor_edit" value="No" disabled>';
                      }
                      if (data.tiene_teclado == 1) {
                        html += '<label for="last_name">Tiene Teclado</label>';
                        html += '<input type="text" class="form-control" name="tiene_teclado_edit" id="tiene_teclado_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Tiene Teclado</label>';
                        html += '<input type="text" class="form-control" name="tiene_teclado_edit" id="tiene_teclado_edit" value="No" disabled>';
                      }
                      if (data.tiene_raton == 1) {
                        html += '<label for="last_name">Tiene Ratón</label>';
                        html += '<input type="text" class="form-control" name="tiene_raton_edit" id="tiene_raton_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Tiene Ratón</label>';
                        html += '<input type="text" class="form-control" name="tiene_raton_edit" id="tiene_raton_edit" value="No" disabled>';
                      }
                      if (data.controlador_red == 1) {
                        html += '<label for="last_name">Controlador de Red</label>';
                        html += '<input type="text" class="form-control" name="controlador_red_edit" id="controlador_red_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Controlador de Red</label>';
                        html += '<input type="text" class="form-control" name="controlador_red_edit" id="controlador_red_edit" value="No" disabled>';
                      }
                      html += '<label for="last_name">Versión de Office</label>';
                      html += '<input type="text" class="form-control" name="paq_office_version_edit" id="paq_office_version_edit" value="'+data.paq_office_version+'" disabled>';
                      if (data.paq_office_activado == 1) {
                        html += '<label for="last_name">Office Activado</label>';
                        html += '<input type="text" class="form-control" name="paq_office_activado_edit" id="paq_office_activado_edit" value="Si" disabled>';
                      }else{
                        html += '<label for="last_name">Office Activado</label>';
                        html += '<input type="text" class="form-control" name="paq_office_activado_edit" id="paq_office_activado_edit" value="No" disabled>';
                      }
                      html += '<label for="last_name">Observaciones</label>';
                      html += '<input type="text" class="form-control" name="observaciones_edit" id="observaciones_edit" value="'+data.observaciones+'" disabled>';
                      $("#select_tipo").html(tipoHtml);
                      $('#rev_rapida_form').html(html);
                      
                    }else if(data.tipo == 'Rápida' || data.tipo == 'Rapida' ||data.tipo == 'rapida'){
                        $("#user_id_edit").val(data.user_id);
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#tipo_edit").val(data.tipo);
                      $("#momento_edit").val(data.momento);
                      $("#observaciones_edit").val(data.observaciones);
                      $("#created_at_edit").val(data.created_at);
                      $("#updated_at_edit").val(data.updated_at);
                      htmlRap += '<table class="table table-striped table-bordered" id="revs_table">';
                      htmlRap += '<thead>';
                      htmlRap += '<tr>';
                      htmlRap += '<th>Clasificación</th>';
                      htmlRap += '<th>Cantidad</th>';
                      htmlRap += '</tr>';
                      htmlRap += '</thead>';
                      htmlRap += '<tbody>';
                      
                      for (var i = 0; i < data.cantidad.length; i++) {
                        htmlRap += '<tr>';
                        htmlRap += '<td>'+data.clasificacion[i]+'</td><td>'+data.cantidad[i]+'</td>';
                        htmlRap += '</tr>';
                      }
                      
                      htmlRap += '</tbody>';
                      htmlRap += '</table>';
                      $('#rev_rapida_form').html(htmlRap);
                    }
                    
                    
                  }else{
                      $("#user_id_edit").val(data.user_id);
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#tipo_edit").val(data.tipo);
                      $("#momento_edit").val(data.momento);
                      $("#observaciones_edit").val(data.observaciones);
                      $("#created_at_edit").val(data.created_at);
                      $("#updated_at_edit").val(data.updated_at);
                    
                  }
                    //$("#revisionEditModal").css('z-index','100');
                    $("#informationModal").modal('hide');
                    $("#revisionEditModal").modal('show');
                    $("#action").val('Editar');

                    $("#rev_id_edit").val(data.id);
                    //console.log(data.id);
                    $("#revdet_id_edit").val(data.id);
                }
        });

    $('#rev_rapida_form').html('');
});


$('#rev_edit_form').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url: "/rev_update",
            method: "post",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success:function(data){
              var html = '';
              if (data.errors) {
                html = '<div class="alert alert-danger">';
                for (var i = 0; i < data.errors.length; i++) {
                  html += '<p>'+ data.errors[i] +'</p>'
                }
                html += '</div>';
              }
              if (data.success) {
                html = '<div class="alert alert-success">'+ data.success +'</div>';
                $("#rev_edit_form")[0].reset();
                $("#form-output").html(html); 
                $("#revisionEditModal").modal('hide');
              }
              $("#revs_table").DataTable().ajax.reload();
              alert('Revisión Actualizada Correctamente');
              //console.log(data);
            }
          });
      });




//Function to delete a Mobiliario
    $(document).on('click', '.delete-rev', function(){
      event.preventDefault();
      /*var id = $(this).attr('id');
      $("#confirmation_modal").modal('show');
      $("#modalTitleDelete").text('Eliminar Revisión');
      $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar esta Revisión?');
      $("#confirm_yes").on('click', function(){
        $.ajax({
          url: "/mobi_destroy",
          method: "get",
          data: {id: id},
          success: function(data){
            $("#confirmation_modal").modal('hide');
            $("#mobis_table").DataTable().ajax.reload();
            alert(data);
            //console.log(data);
          }
        });
      });*/
      alert('Ups opción en desarrollo....');
    });