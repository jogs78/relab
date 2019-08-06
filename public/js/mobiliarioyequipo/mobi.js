let valor_ram = ''
let unidad_ram = ''
let valor_disco_duro = ''
let unidad_disco_duro = ''
let paqueteria_office = ''
let so = ''
let tipo_otro_office = ''
let tipo_otro_so = ''

//Variables para editar pc
let new_cant_ram = ''
let new_cant_dd = ''

//Function to know the quantity of each item
function itemsQuantity(lugar_id){
  let id = lugar_id
  let all_mobi_html = ''

  $.ajax({
    url: '/cant_items',
    method: 'get',
    data: {id: id},
    dataType: 'json',
    success: function(data){
      if(data.pc_cant != 0){
        all_mobi_html += `<div class="col">
        <p class="text-success text-justify">Computadoras Totales</p>
        <p class="text-justify">`+data.pc_cant+`</p>
        </div>`
      }
      if(data.mesa_cant != 0){
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Mesas Totales</p>
        <p class="text-justify">`+data.mesa_cant+`</p>
        </div>`
      }
      if (data.silla_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Sillas Totales</p>
        <p class="text-justify">`+data.silla_cant+`</p>
        </div>`
      }
      if (data.piz_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Pizarrones Totales</p>
        <p class="text-justify">`+data.piz_cant+`</p>
        </div>`

      }
      if (data.television_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Televisiones Totales</p>
        <p class="text-justify">`+data.television_cant+`</p>
        </div>`
      }
      if (data.termostato_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Termostatos Totales</p>
        <p class="text-justify">`+data.termostato_cant+`</p>
        </div>`
      }
      if (data.ruteador_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Ruteadores Totales</p>
        <p class="text-justify">`+data.ruteador_cant+`</p>
        </div>`
      }
      if (data.swith_cant != 0) {
        all_mobi_html += `<div class="col text-justify">
        <p class="text-success text-justify">Switches Totales</p>
        <p class="text-justify">`+data.swith_cant+`</p>
        </div>`
      }
      $("#cant_mobi_all").html(all_mobi_html)
      $("#itemsCantModal").modal('show')
    }
  })
}

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
            html += '<input type="number" class="form-control" name="num_maquina" id="num_maquina" min="1" placeholder="Escribe el número de maquina">';
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
            
            html += `<div class="form-group">`
            html += '<label for="last_name">RAM</label>';
            html += '<input type="number" class="form-control" id="valor_ram" min="1" placeholder="Ejemplo: 500" required>';
            html += `<select id="unidad_ram" class="form-control">
                        <option value="Megabyte">Megabyte</option>
                        <option value="Gigabyte">Gigabyte</option>
                        <option value="Terabyte">Terabyte</option>
                     </select>
                     <input type="hidden" name="ram" id="ram" />
                     </div>`; 
                    
            html += `<label for="last_name">Disco Duro</label>
                    <input type="number" class="form-control" id="valor_disco_duro" min="1" placeholder="Ejemplo: 500" required>
                    <select id="unidad_disco_duro" class="form-control">
                        <option value="Megabyte">Megabyte</option>
                        <option value="Gigabyte">Gigabyte</option>
                        <option value="Terabyte">Terabyte</option>
                        <option value="PetaByte">PetaByte</option>
                        <option value="ExaByte">ExaByte</option>
                        <option value="ZettaByte">ZettaByte</option>
                        <option value="YottaByte">YottaByte</option>
                     </select>
                     <input type="hidden" name="disco_duro" id="disco_duro"/>`;
                    
            html += '<label for="last_name">Sistema Operativo</label>';
            html += `<select class="form-control" id="select_so">
                        <option value="Windows 7">Windows 7</option>
                        <option value="Windows 8">Windows 8</option>
                        <option value="Windows 8.1">Windows 8.1</option>
                        <option value="Windows 10">Windows 10</option>
                        <option value="otro">Otro</option>
                     </select>
                     <input type="hidden" class="form-control" id="otro_so" placeholder="Escribe el SO, ejemplo: Linux Ubuntu 18.10" />
                     <input type="hidden" name="sistema_operativo" id="sistema_operativo">`;
            
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
            html += '<input type="text" class="form-control" name="num_serie_monitor" id="num_serie_monitor" placeholder="Escribe el número de serie del monitor">';

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
            html += `<select class="form-control" id="select_paq_office_version">
                       <option value="Office 2007">Office 2007</option>
                       <option value="Office 2010">Office 2010</option>
                       <option value="Office 2013">Office 2013</option>
                       <option value="Office 2016">Office 2016</option>
                       <option value="Office 2019">Office 2019</option>
                       <option value="otro">Otro</option>
                     </select>
                     <input type="hidden" class="form-control" id="otro_office" placeholder="Escribe el nombre de la paqueria, ejemplo: OpenOffice 2019"/>
                     <input type="hidden" class="form-control" name="paq_office_version" id="paq_office_version">`;
            
            html += '<label for="last_name">Paqueteria Office Activado</label>';
                      html += '<select class="form-control" name="paq_office_activado" id="paq_office_activado">';
                      html += '<option value="1">Si</option>';
                      html += '<option value="0">No</option>';
                      html += '</select>';

            html += '<label for="last_name">Observaciones</label>';
            html += '<input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Escribe las observaciones de la Pc">';


            $('#pc_data').html(html);
          }else{
            $('#pc_data').html(html);
          }

          $("#valor_ram").blur(function(){
              valor_ram = $("#valor_ram").val()
              if (valor_ram == '') {
                 alert("Ups no puedes dejar este campo sin una cantidad, ejemplo: 500")
              }
            });

          $("#valor_disco_duro").blur(function(){
              valor_disco_duro = $("#valor_disco_duro").val()
              if (valor_disco_duro == '') {
                 alert("Ups no puedes dejar este campo sin una cantidad, ejemplo: 500")
              }
            });

          $("#select_paq_office_version").on('change', function(){
            if ($("#select_paq_office_version").val() == 'otro') {
              $("#otro_office").get(0).type = 'text';
              tipo_otro_office = $("#otro_office").get(0).type
            }else{
              $("#otro_office").get(0).type = 'hidden';
              tipo_otro_office = $("#otro_office").get(0).type
            }
          })

          $("#select_so").on('change', function(){
            if($("#select_so").val() == 'otro') {
              $("#otro_so").get(0).type = 'text'
              tipo_otro_so = $("#otro_so").get(0).type
            }else{
              $("#otro_so").get(0).type = 'hidden'
              tipo_otro_so = $("#otro_so").get(0).type
            }
          })

      });
      $("#mobiAddModal").modal('show');
   });

//Add new Mobiliario
$("#mobi_store_form").on('submit', function(event){
      event.preventDefault();
      //Asignacion del valor al input tipo hidden
      unidad_ram = $("#unidad_ram").val()
      $("#ram").val(valor_ram+' '+unidad_ram)

      unidad_disco_duro = $("#unidad_disco_duro").val()
      $("#disco_duro").val(valor_disco_duro+' '+unidad_disco_duro)

      //Paqueteria office
      if(tipo_otro_office == 'text'){
        if($('#otro_office').val() == ''){
            alert('Debes escribir una paqueteria, ejemplo: OpenOffice 2019')
        }else{
            paqueteria_office = $("#otro_office").val()
            $("#paq_office_version").val(paqueteria_office)
        }
      }else{
          paqueteria_office = $("#select_paq_office_version").val()
          $("#paq_office_version").val(paqueteria_office)
      }

      //Version y sistema operativo
      if (tipo_otro_so == 'text') {
        if ($("#otro_so").val() == '') {
                 alert('Tienes que escribir un sistema operativo por favor')
        }else{
          so = $("#otro_so").val()
          $("#sistema_operativo").val(so)
        }
      }else{
        so = $("#select_so").val()
        $("#sistema_operativo").val(so)
      }

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
          if (data.cla) {
            html = '<div class="alert alert-danger">';
            html += '<p>'+data.cla+'</p>';
            html += '</div';
          }
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
$("#mobis_table").on('click', '.move-mobi', function(event){
  event.preventDefault();
  event.stopPropagation();
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

//Function to place change all items
$("#mobis_table").on('click', '#move_all', function(event){
  event.preventDefault();
  var id_1 = [];
  var id = $(".move-mobi").attr('id');
      
        $('.mobi_checkbox:checked').each(function(){
          id_1.push($(this).val());
        });

        if (id_1.length > 0) {

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
                $("#mobiChangeModal").modal('hide');
                $("#confirmation_modal").modal('show');
                $("#modalTitleDelete").text('Mover Varios Mobiliarios');
                $("#msj_confirmation_modal").text('¿Estás seguro de que quieres mover estos Mobiliarios?');
                $("#confirm_yes").on('click', function(){
                  
                    $.ajax({
                      url: "/mobi_several_change",
                      method: "get",
                      data: {id_1: id_1, lugar_id: lugar_id},
                      dataType: "json",
                      success: function(data){
                        $("#confirmation_modal").modal('hide');
                        $("#informationModal").modal('show');
                        if (data.success) {
                          $("#msj_information_modal").text(data.success);
                        }
                        if (data.error) {
                          $("#msj_information_modal").text(data.error);
                        }
                        $("#mobis_table").DataTable().ajax.reload();
                        
                        console.log(data)
                      }
                    });
                  
                });
              });
            }
          });

        }else{
          alert("Por favor, seleccione al menos una casilla de verificación");
        }

});


//Function to edit differents items
$("#mobis_table").on('click', '.edit-mobi', function(event){
              event.stopPropagation();
              event.preventDefault();
              var id = $(this).attr('id');
              
              $.ajax({
                url: "/mobi_fetchdata/"+id,
                method: "get",
                dataType: 'json',
                success:function(data){
                  var html  = '';
                  $("#form-output").html('');
                  
                  if (data.clasificacion == 'Pc') {
                    $("#path_edit").val(data.path);
                    $("#store_image_edit").html('<img src="/imguser/'+data.path+'" width="70" class="img-thumbnail">');
                    $("#clasificacion_disabled").val(data.clasificacion);
                    $("#clasificacion_hidden").val(data.clasificacion);
                    $("#descripcion_edit").val(data.descripcion);
                    $("#modelo_edit").val(data.modelo);
                    $("#estado_edit").val(data.estado);
                    $("#marca_edit").val(data.marca);
                    $("#numero_inventario_edit").val(data.numero_inventario);
                    $("#numero_serie_edit").val(data.numero_serie);
                    html += '<label for="last_name">Número de Maquina</label>';
                    html += '<input type="text" class="form-control" name="num_maquina_edit" id="num_maquina_edit" value="'+data.num_maquina+'" required>';
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
                    html += '<input type="text" class="form-control" name="num_serie_cpu_edit" id="num_serie_cpu_edit" value="'+data.num_serie_cpu+'" required>';
                    
                    //Cantidad de Ram a editar -------
                    var cant_ram = data.ram
                    separador = " "
                    var parteunoram = cant_ram.split(separador);
                    html += `<label for="last_name">Cantidad de RAM</label>
                            <div class="form-group">
                              <div class="row">
                                <div class="col-md-6">
                                  <input type="number" class="form-control" id="valor_ram_edit" min="1" value="`+parteunoram[0]+`" required>
                                </div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control" id="unidad_ram_edit" value="`+parteunoram[1]+`" disabled>
                                </div>
                              </div>
                            </div>`
                    html += `<select id="new_unidad_ram_edit" class="form-control">
                              <option value="Megabyte">Megabyte</option>
                              <option value="Gigabyte">Gigabyte</option>
                              <option value="Terabyte">Terabyte</option>
                              </select>`
                    html += `<input type="hidden" name="ram_edit" id="ram_edit"/>`;
                    
                    //Disco duro -----------------------------------------
                    var cant_disco_duro = data.disco_duro
                    separador = " "
                    var parteunodd = cant_disco_duro.split(separador);
                    html += '<label for="last_name">Cantidad de Disco Duro</label>';
                    html += `
                              <div class="row">
                                <div class="col-md-6">
                                <input type="number" class="form-control" id="new_valor_dd" min="1" value="`+parteunodd[0]+`" required>
                                </div>
                                <div class="col-md-6">
                                  <input type="text" class="form-control" id="unidad_dd_edit" value="`+parteunodd[1]+`" disabled>
                                </div>
                              </div>
                             
                             <select id="unidad_disco_duro" class="form-control">
                                <option value="Megabyte">Megabyte</option>
                                <option value="Gigabyte">Gigabyte</option>
                                <option value="Terabyte">Terabyte</option>
                                <option value="PetaByte">PetaByte</option>
                                <option value="ExaByte">ExaByte</option>
                                <option value="ZettaByte">ZettaByte</option>
                                <option value="YottaByte">YottaByte</option>
                             </select>
                    <input type="hidden" class="form-control" name="disco_duro_edit" id="disco_duro_edit">`

                    //Sistema operativo a editar-------------------------------------
                    
                    html += '<label for="last_name">Sistema Operativo</label>';
                    html += `<input type="text" class="form-control" id="sistema_operativo_edit_disabled" value="`+data.sistema_operativo+`" disabled>
                            <select class="form-control" id="select_so_edit">
                              <option value="Windows 7">Windows 7</option>
                              <option value="Windows 8">Windows 8</option>
                              <option value="Windows 8.1">Windows 8.1</option>
                              <option value="Windows 10">Windows 10</option>
                              <option value="otro">Otro</option>
                           </select>
                           <input type="hidden" name="sistema_operativo_edit" id="sistema_operativo_edit" value="`+data.sistema_operativo+`"/>`
                    
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
                    html += '<input type="text" class="form-control" name="num_serie_monitor_edit" id="num_serie_monitor_edit" value="'+data.num_serie_monitor+'" required>';
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

                    //Vaersión de la paqueteria Office -------------
                    html += '<label for="last_name">Versión del Paquete Office</label>';
                    html += `<input type="text" class="form-control"  id="paq_office_version_edit_disabled" value="`+data.paq_office_version+`" disabled>
                    <div class="form-group">
                      <select class="form-control" id="select_paq_office_version_edit">
                         <option value="Office 2007">Office 2007</option>
                         <option value="Office 2010">Office 2010</option>
                         <option value="Office 2013">Office 2013</option>
                         <option value="Office 2016">Office 2016</option>
                         <option value="Office 2019">Office 2019</option>
                         <option value="otro">Otro</option>
                       </select>
                    </div>
                    <input type="hidden" name="paq_office_version_edit" id="paq_office_version_edit" value="`+data.paq_office_version+`"/>`;

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
                      alert("Este mobiliario no tiene datos en la tabla Pc, actualiza los datos por favor!");
                    }
                    
                  }else{
                    $("#path_edit").val(data.path);
                    $("#store_image_edit").html('<img src="/imguser/'+data.path+'" width="70" class="img-thumbnail">');
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
                     
                    //Nueva unidad de medida del la memoria Ram
                    var nueva_unidad_ram_edit = '';
                    $("#new_unidad_ram_edit").on('change',function(){
                      nueva_unidad_ram_edit = $("#new_unidad_ram_edit").val()
                      $("#unidad_ram_edit").val(nueva_unidad_ram_edit);
                    });
                    

                     //Nueva unidad de medida del DD
                    var nueva_unidad_dd_edit = '';
                    $("#unidad_disco_duro").on('change',function(){
                      nueva_unidad_dd_edit = $("#unidad_disco_duro").val()
                      $("#unidad_dd_edit").val(nueva_unidad_dd_edit);
                    });
                    

                    //Nuevo sistema operativo --------
                    var new_so = ''
                    $("#select_so_edit").on('change', function(){
                      new_so = $("#select_so_edit").val()
                      if($("#select_so_edit").val() == 'otro') {
                        $("#sistema_operativo_edit_disabled").attr('placeholder', "Ejemplo: Linux Ubuntu 18.10");
                        $("#sistema_operativo_edit_disabled").prop('disabled', false);
                        $("#sistema_operativo_edit_disabled").attr('required');
                      }else{
                        $("#sistema_operativo_edit_disabled").prop('disabled', true);
                        $("#sistema_operativo_edit_disabled").val(new_so);
                        $("#sistema_operativo_edit").val(new_so);
                      }
                    });

                    //Nuwva versión de la paquetería ofiice -------
                    var new_paq_office = ''
                    $("#select_paq_office_version_edit").on('change', function(){
                      new_paq_office = $("#select_paq_office_version_edit").val()
                      if($("#select_paq_office_version_edit").val() == 'otro') {
                        $("#paq_office_version_edit_disabled").attr('placeholder', "Ejemplo: Linux Ubuntu 18.10");
                        $("#paq_office_version_edit_disabled").prop('disabled', false);
                        $("#paq_office_version_edit_disabled").attr('required');
                      }else{
                        $("#paq_office_version_edit_disabled").prop('disabled', true);
                        $("#paq_office_version_edit_disabled").val(new_paq_office);
                        $("#paq_office_version_edit").val(new_paq_office);
                      }
                    });

                    $("#mobi_id_edit").val(data.id);
                    $("#pc_id_edit").val(data.id_pc);
                }
              });

              $('#pc_data_edit').html('');
            });


$('#mobi_edit_form').on('submit', function(event){
        event.preventDefault();
        new_cant_ram = $("#valor_ram_edit").val();
        new_cant_dd = $("#new_valor_dd").val();
        $("#ram_edit").val(new_cant_ram+' '+$("#unidad_ram_edit").val())
        $("#disco_duro_edit").val(new_cant_dd+' '+$("#unidad_dd_edit").val())
        console.log(new_cant_ram+' '+$("#unidad_ram_edit").val())
        console.log(new_cant_dd+' '+$("#unidad_dd_edit").val())

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
              console.log(data)
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
            }
          });
      });




//Function to delete a Mobiliario
    $("#mobis_table").on('click', '.delete-mobi', function(){
      event.preventDefault();
      event.stopPropagation();
      var id = $(this).attr('id');

      $("#confirmation_modal").modal('show');
      $("#modalTitleDelete").text('Eliminar Mobiliario');
      $("#msj_confirmation_modal").text('¿Estás seguro de que quieres borrar este Mobiliario?');
      $("#msj_confirmation_modal2").text('También las revisiones realizadas para este mobiliario se eliminaran permanentemente!');
      $("#confirm_yes").on('click', function(){
        $.ajax({
          url: "/mobi_destroy",
          method: "get",
          data: {id: id},
          success: function(data){
            $("#confirmation_modal").modal('hide');
            $("#mobis_table").DataTable().ajax.reload();
            alert(data);
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