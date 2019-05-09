//Function to create a new place
    $("#agregar_mobi,#agregar_mobi_2").on('click', function(event){
      event.preventDefault();
      $("#mobi_store_form")[0].reset();
      $("#form_output").html('');
      $("#modalTitleMobi").text('Agregar Nuevo Mobiliario');
      $("#action").val('Guardar');
      $("#select_clasificacion").on('change', function(event){
        event.preventDefault();
        html = '';
        
          if ($("#select_clasificacion").val() == 'Pc') {
            $('#pc_data').html(html);
            html += '<label for="last_name">Número de Maquina</label>';
            html += '<input type="text" class="form-control" name="num_maquina" id="num_maquina">';
            html += '<label for="last_name">Tiene Cámara</label>';
            html += '<select class="form-control" name="tiene_camara" id="tiene_camara">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
            html += '<label for="last_name">Tiene Bocinas</label>';
                      html += '<select class="form-control" name="tiene_bocinas" id="tiene_bocinas">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
            html += '<label for="last_name">Número de Serie CPU</label>';
            html += '<input type="text" class="form-control" name="num_serie_cpu" id="num_serie_cpu">';
                    
            html += '<label for="last_name">RAM</label>';
            html += '<input type="text" class="form-control" name="ram" id="ram">';
                    
            html += '<label for="last_name">Disco Duro</label>';
            html += '<input type="text" class="form-control" name="disco_duro" id="disco_duro">';
                    
            html += '<label for="last_name">Sistema Operativo</label>';
            html += '<input type="text" class="form-control" name="sistema_operativo" id="sistema_operativo">';
            
            html += '<label for="last_name">Sistema Operativo Activado</label>';
                      html += '<select class="form-control" name="sistema_operativo_activado" id="sistema_operativo_activado">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Cable VGA</label>';
                      html += '<select class="form-control" name="cable_vga" id="cable_vga">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Tiene Monitor</label>';
                      html += '<select class="form-control" name="tiene_monitor" id="tiene_monitor">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Número de Serie Monitor</label>';
            html += '<input type="text" class="form-control" name="num_serie_monitor" id="num_serie_monitor">';

            html += '<label for="last_name">Tiene Teclado</label>';
                      html += '<select class="form-control" name="tiene_teclado" id="tiene_teclado">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Tiene Ratón</label>';
                      html += '<select class="form-control" name="tiene_raton" id="tiene_raton">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Controlador de Red</label>';
                      html += '<select class="form-control" name="controlador_red" id="controlador_red">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Versión del Paquete Office</label>';
            html += '<input type="text" class="form-control" name="paq_office_version" id="paq_office_version">';
            
            html += '<label for="last_name">Paqueteria Office Activado</label>';
                      html += '<select class="form-control" name="paq_office_activado" id="paq_office_activado">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Observaciones</label>';
            html += '<input type="text" class="form-control" name="observaciones" id="observaciones">';
            $('#pc_data').html(html);
          }else{
            $('#pc_data').html(html);
          }
      });
      $("#mobiAddModal").modal('show');
    });

//Add new Mobiliario
$("#mobi_store_form").on('submit', function(event){
      event.preventDefault();

      $.ajax({
        url: "/mobi_agregarnuevo",
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
              html += '<p>'+data.errors[i]+'</p>';
            }
            html += '</div';
          }
          if (data.success) {
            html = '<div class="alert alert-success">'+data.success+'</div>'
            $("#mobi_store_form")[0].reset();
            $("#mobis_table").DataTable().ajax.reload();
            alert(data.success);
          }
          $("#form-output-store").html(html);

          //console.log(data);
        }
      });

    });

//Function to place change differents items
$(document).on('click', '.move-mobi', function(event){
  event.preventDefault();
  var id = $(this).attr('id');
  
  $.ajax({
      url: "/mobi_change",
      method: "get",
      data: {id: id},
      dataType: "json",
      success:function(data){
        $("#lugar_actual").val(data);
        $("#mobiChangeModal").modal('show');
        $("#action_change_lugar").on('click', function(){
          var lugar_id = $("#select_change_lugar").val();
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "/mobi_move",
            method: "post",
            data: {id:id, lugar_id: lugar_id},
            dataType: "json",
            success:function(html){
              $("#mobiChangeModal").modal('hide');
              $("#informationModal").modal('show');
              if (html.success) {
                $("#msj_information_modal").text(html.success);
              }
              if (html.error) {
                $("#msj_information_modal").text(html.error);
              }
              $("#mobis_table").DataTable().ajax.reload();
            }
          });
        });
      }
    });

});


//Function to edit differents items
$(document).on('click', '.edit-mobi', function(event){
              event.preventDefault();
              var id = $(this).attr('id');
              
              $.ajax({
                url: "/mobi_fetchdata/"+id,
                method: "get",
                dataType: 'json',
                success:function(data){
                  var html  = '';
                  
                  if (data.clasificacion == 'Pc') {
                    $("#path_edit").val(data.path);
                    $("#store_image_edit").html('<img src="/imgmobi/'+data.path+'" width="70" class="img-thumbnail">');
                    $("#clasificacion_disabled").val(data.clasificacion);
                    $("#clasificacion_hidden").val(data.clasificacion);
                    $("#descripcion_edit").val(data.descripcion);
                    $("#modelo_edit").val(data.modelo);
                    $("#estado_edit").val(data.estado);
                    $("#marca_edit").val(data.marca);
                    $("#numero_inventario_edit").val(data.numero_inventario);
                    $("#numero_serie_edit").val(data.numero_serie);
                    html += '<label for="last_name">Número de Maquina</label>';
                    html += '<input type="text" class="form-control" name="num_maquina_edit" id="num_maquina_edit" value="'+data.num_maquina+'">';
                    if (data.tiene_camara == 1) {
                      html += '<label for="last_name">Tiene Camara</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="tiene_camara_edit" id="tiene_camara_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0"></option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Tiene Camara</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="tiene_camara_edit" id="tiene_camara_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    if (data.tiene_bocinas == 1) {
                      html += '<label for="last_name">Tiene Bocinas</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="tiene_bocinas_edit" id="tiene_bocinas_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Tiene Bocinas</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="tiene_bocinas_edit" id="tiene_bocinas_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    
                    html += '<label for="last_name">Número de Serie CPU</label>';
                    html += '<input type="text" class="form-control" name="num_serie_cpu_edit" id="num_serie_cpu_edit" value="'+data.num_serie_cpu+'">';
                    
                    html += '<label for="last_name">RAM</label>';
                    html += '<input type="text" class="form-control" name="ram_edit" id="ram_edit" value="'+data.ram+'">';
                    
                    
                    html += '<label for="last_name">Disco Duro</label>';
                    html += '<input type="text" class="form-control" name="disco_duro_edit" id="disco_duro_edit" value="'+data.disco_duro+'">';
                    
                    html += '<label for="last_name">Sistema Operativo</label>';
                    html += '<input type="text" class="form-control" name="sistema_operativo_edit" id="sistema_operativo_edit" value="'+data.sistema_operativo+'">';
                    
                    if (data.sistema_operativo_activado == 1) {
                      html += '<label for="last_name">Sistema Operativo Activado</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="sistema_operativo_activado_edit" id="sistema_operativo_activado_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Sistema Operativo Activado</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="sistema_operativo_activado_edit" id="sistema_operativo_activado_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    if (data.cable_vga == 1) {
                      html += '<label for="last_name">Cable VGA</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="cable_vga_edit" id="cable_vga_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Cable VGA</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="cable_vga_edit" id="cable_vga_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    if (data.tiene_monitor == 1) {
                      html += '<label for="last_name">Tiene Monitor</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="tiene_monitor_edit" id="tiene_monitor_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Tiene Monitor</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="tiene_monitor_edit" id="tiene_monitor_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    html += '<label for="last_name">Número de Serie Monitor</label>';
                    html += '<input type="text" class="form-control" name="num_serie_monitor_edit" id="num_serie_monitor_edit" value="'+data.num_serie_monitor+'">';
                    if (data.tiene_teclado == 1) {
                      html += '<label for="last_name">Tiene Teclado</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="tiene_teclado_edit" id="tiene_teclado_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Tiene Teclado</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="tiene_teclado_edit" id="tiene_teclado_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    if (data.tiene_raton == 1) {
                      html += '<label for="last_name">Tiene Ratón</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="tiene_raton_edit" id="tiene_raton_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Tiene Ratón</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="tiene_raton_edit" id="tiene_raton_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    if (data.controlador_red == 1) {
                      html += '<label for="last_name">Controlador de Red</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="controlador_red_edit" id="controlador_red_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Controlador de Red</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="controlador_red_edit" id="controlador_red_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    html += '<label for="last_name">Versión del Paquete Office</label>';
                    html += '<input type="text" class="form-control" name="paq_office_version_edit" id="paq_office_version_edit" value="'+data.paq_office_version+'">';
                    if (data.paq_office_activado == 1) {
                      html += '<label for="last_name">Paqueteria Office Activado</label>';
                      html += '<input type="text" class="form-control" value="Si" disabled>';
                      html += '<select class="form-control" name="paq_office_activado_edit" id="paq_office_activado_edit">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';
                    }else{
                      html += '<label for="last_name">Paqueteria Office Activado</label>';
                      html += '<input type="text" class="form-control" value="No" disabled>';
                      html += '<select class="form-control" name="paq_office_activado_edit" id="paq_office_activado_edit">';
                      html += '<option value="0">No</option>';
                      html += '<option value="1">Si</option>';
                      html += '</select>';
                    }
                    html += '<label for="last_name">Observaciones</label>';
                    html += '<input type="text" class="form-control" name="observaciones_edit" id="observaciones_edit" value="'+data.observaciones+'">';

                    $('#pc_data_edit').html(html);

                    if ($("#num_maquina_edit").val() == 'undefined') {
                      alert("Este mobiliario no tiene datos en la tabla Pc, se necesita eliminar");
                    }
                    
                  }else{
                    $("#path_edit").val(data.path);
                    $("#store_image_edit").html('<img src="public/imgmobi/'+data.path+'" width="70" class="img-thumbnail">');
                    $("#clasificacion_disabled").val(data.clasificacion);
                    $("#clasificacion_hidden").val(data.clasificacion);
                    $("#descripcion_edit").val(data.descripcion);
                    $("#modelo_edit").val(data.modelo);
                    $("#estado_edit").val(data.estado);
                    $("#marca_edit").val(data.marca);
                    $("#numero_inventario_edit").val(data.numero_inventario);
                    $("#numero_serie_edit").val(data.numero_serie);
                    
                  }

                    $("#mobiEditModal").modal('show');
                    $("#action").val('Editar');

                    $("#mobi_id_edit").val(data.id);
                    $("#pc_id_edit").val(data.id_pc);
                }
              });

              $('#pc_data_edit').html('');
            });


$('#mobi_edit_form').on('submit', function(event){
        event.preventDefault();

        $.ajax({
            url: "/mobi_update",
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
                $("#mobi_edit_form")[0].reset();
                $("#store_image").html('');
                $("#form-output").html(html); 
                $("#mobiEditModal").modal('hide');
              }
              $("#mobis_table").DataTable().ajax.reload();
              alert('Mobiliario Actualizado Correctamente');
              //console.log(data);
            }
          });
      });




//Function to delete a Mobiliario
    $(document).on('click', '.delete-mobi', function(){
      event.preventDefault();
      var id = $(this).attr('id');

      $("#confirmation_modal").modal('show');
      $("#modalTitleDelete").text('Eliminar Mobiliario');
      $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar este Mobiliario? También las revisiones realizadas para este mobiliario se eliminaran permanentemente!');
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
      });
    });


//Function to delete multiples Users to the same time
    $(document).on('click','#bulk_delete_mobi', function(){
      event.preventDefault();
      var id = [];
      
        $('.mobi_checkbox:checked').each(function(){
          id.push($(this).val());
        });

        if (id.length > 0) {
          $("#confirmation_modal").modal('show');
          $("#modalTitleDelete").text('Eliminar Mobiliarios');
          $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar estos Mobiliarios permanentemente?');
          $("#confirm_yes").on('click', function(){
            
              $.ajax({
                url: "/mobi_multipledestroy",
                method: "get",
                data: {id: id},
                success: function(data){
                  $("#confirmation_modal").modal('hide');
                  $("#mobis_table").DataTable().ajax.reload();
                  alert(data);
                }
              });
            
          });
        }else{
          alert("Por favor, seleccione al menos una casilla de verificación");
        }

    });