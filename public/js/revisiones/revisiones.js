$(document).on('click', '.edit-rev', function(event){
              event.preventDefault();
              var id = $(this).attr('id');
              
              verDetallesRevisiones(id)
});

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
      $("#titleDetailsMobi").text('Cantidades en ')
      $("#itemsCantModal").modal('show')
    }
  })
}

function verDetallesRevisiones(id){
  $.ajax({
                url: "/rev_fetchdata/"+id,
                method: "get",
                dataType: 'json',
                success:function(data){
                  var html ='';
                  var htmlRap  = '';
                  
                  if (data.tipo != '') {

                    if (data.tipo == 'Detallada' || data.tipo == 'detallada') {
                      $("#user_id_edit").val(data.user_id);
                      $("#label_user_edit").addClass('col-md-1');
                      $("#user_id_edit").addClass('col-md-4');
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#label_lugar_edit").addClass('col-md-1 ml-auto');
                      $("#lugar_id_edit").addClass('col-md-4 ml-auto');
                      $("#tipo_edit").val(data.tipo);
                      $("#label_tipo_edit").addClass('col-md-1');
                      $("#tipo_edit").addClass('col-md-4');
                      $("#momento_edit").val(data.momento);
                      $("#label_momento_edit").addClass('col-md-1 ml-auto');
                      $("#momento_edit").addClass('col-md-4 ml-auto');
                      $("#observaciones_edit").val(data.observaciones);
                      //$("#updated_at_edit").val(data.updated_at);

                      html += '<div class="table-responsive">';
                      html += '<table class="table table-sm table-dark">';
                      html += '<thead>';
                      html += '<tr>';
                      html += '<h4>Datos Pcs Existentes</h4>';
                      html += '<th>Marca</th>';
                      html += '<th>N# de Maquina</th><th>Tiene Cámara</th><th>Tiene Bocinas</th><th>N# Serie CPU</th><th>RAM</th>';
                      html += '<th>Disco Duro</th><th>Sistema Operativo</th><th>SO Activado</th><th>Cable VGA</th>';
                      html += '<th>Tiene Monitor</th><th>N# Serie Monitor</th><th>Tiene Teclado</th><th>Tiene Ratón</th>';
                      html += '<th>Controlador de Red</th><th>Versión Office</th><th>Ofiice Activado</th><th>Observaciones</th>';
                      html += '</tr>';
                      html += '</thead>';
                      html += '<tbody>';
                      
                      for (var i = 0; i < data.item_id.length; i++) {
                        html += '<tr>';
                        html += '<td>'+data.items_all[i]+'</td>';
                        html += '<td>'+data.pc_num_maquina[i]+'</td>';
                        if (data.pc_tiene_camara == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        if (data.pc_tiene_bocinas == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        html += '<td>'+data.pc_num_serie_cpu[i]+'</td>';
                        html += '<td>'+data.pc_ram[i]+'</td>';
                        html += '<td>'+data.pc_disco_duro[i]+'</td><td>'+data.pc_sistema_operativo[i]+'</td>';
                        if (data.pc_sistema_operativo_activado[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        if (data.pc_cable_vga[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        if (data.pc_tiene_monitor[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        html += '<td>'+data.pc_num_serie_monitor[i]+'</td>';
                        if (data.pc_tiene_teclado[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        if (data.pc_tiene_raton[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        if (data.pc_controlador_red[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        html += '<td>'+data.pc_paq_office_version[i]+'</td>';
                        if (data.pc_paq_office_activado[i] == 1) {
                          html += '<td>Si</td>';
                        }else{
                          html += '<td>No</td>';
                        }
                        html += '<td>'+data.pc_observaciones[i]+'</td>';
                      }
                      
                      html += '</tbody>';
                      html += '</table>';

                      
                      
                      html += '<table class="table table-sm" id="revs_table">';
                      html += '<thead class="thead-dark">';
                      html += '<tr>';
                      html += '<h4>Datos de Revisión Detallada</h4>';
                      html += '<th>Marca</th>';
                      html += '<th>N# de Maquina</th><th>Tiene Cámara</th><th>Tiene Bocinas</th><th>N# Serie CPU</th><th>RAM</th>';
                      html += '<th>Disco Duro</th><th>Sistema Operativo</th><th>SO Activado</th><th>Cable VGA</th>';
                      html += '<th>Tiene Monitor</th><th>N# Serie Monitor</th><th>Tiene Teclado</th><th>Tiene Ratón</th>';
                      html += '<th>Controlador de Red</th><th>Versión Office</th><th>Ofiice Activado</th><th>Observaciones</th>';
                      html += '</tr>';
                      html += '</thead>';
                      html += '<tbody>';
                      
                      for (var i = 0; i < data.item_id.length; i++) {
                        html += '<tr>';
                        
                          html += '<td class="table-success">'+data.items_all[i]+'</td>';
                        
                        if (data.num_maquina[i] == data.pc_num_maquina[i]) {
                          html += '<td class="table-success">'+data.num_maquina[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.num_maquina[i]+'</td>';
                        }
                        if (data.tiene_camara[i] == 1 && data.pc_tiene_camara[i] != data.tiene_camara[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.tiene_camara[i] == 1 && data.pc_tiene_camara[i] == data.tiene_camara[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.tiene_camara[i] == 0 && data.pc_tiene_camara[i] != data.tiene_camara[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.tiene_bocinas[i] == 1 && data.pc_tiene_bocinas[i] != data.tiene_bocinas[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.tiene_bocinas[i] == 1 && data.pc_tiene_bocinas[i] == data.tiene_bocinas[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.tiene_bocinas[i] == 0 && data.pc_tiene_bocinas[i] != data.tiene_bocinas[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.num_serie_cpu[i] == data.pc_num_serie_cpu[i]) {
                          html += '<td class="table-success">'+data.num_serie_cpu[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.num_serie_cpu[i]+'</td>';
                        }
                        if (data.ram[i] == data.pc_ram[i]) {
                          html += '<td class="table-success">'+data.ram[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.ram[i]+'</td>';
                        }
                        if (data.disco_duro[i] == data.pc_disco_duro[i]) {
                          html += '<td class="table-success">'+data.disco_duro[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.disco_duro[i]+'</td>';
                        }
                        if (data.sistema_operativo[i] == data.pc_sistema_operativo[i]) {
                          html += '<td class="table-success">'+data.sistema_operativo[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.sistema_operativo[i]+'</td>';
                        }
                        if (data.sistema_operativo_activado[i] == 1 && data.pc_sistema_operativo_activado[i] != data.sistema_operativo_activado[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.sistema_operativo_activado[i] == 1 && data.pc_sistema_operativo_activado[i] == data.sistema_operativo_activado[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.sistema_operativo_activado[i] == 0 && data.pc_sistema_operativo_activado[i] != data.sistema_operativo_activado[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.cable_vga[i] == 1 && data.pc_cable_vga[i] != data.cable_vga[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.cable_vga[i] == 1 && data.pc_cable_vga[i] == data.cable_vga[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.cable_vga[i] == 0 && data.pc_cable_vga[i] != data.cable_vga[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.tiene_monitor[i] == 1 && data.pc_tiene_monitor[i] != data.tiene_monitor[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.tiene_monitor[i] == 1 && data.pc_tiene_monitor[i] == data.tiene_monitor[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.tiene_monitor[i] == 0 && data.pc_tiene_monitor[i] != data.tiene_monitor[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.num_serie_monitor[i] == data.pc_num_serie_monitor[i]) {
                          html += '<td class="table-success">'+data.num_serie_monitor[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.num_serie_monitor[i]+'</td>';
                        }
                        if (data.tiene_teclado[i] == 1 && data.pc_tiene_teclado[i] != data.tiene_teclado) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.tiene_teclado[i] == 1 && data.pc_tiene_teclado[i] == data.tiene_teclado){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.tiene_teclado[i] == 0 && data.pc_tiene_teclado[i] != data.tiene_teclado){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.tiene_raton[i] == 1 && data.pc_tiene_raton[i] != data.tiene_raton[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.tiene_raton[i] == 1 && data.pc_tiene_raton[i] == data.tiene_raton[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.tiene_raton[i] == 0 && data.pc_tiene_raton[i] != data.tiene_raton[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.controlador_red[i] == 1 && data.pc_controlador_red[i] != data.controlador_red[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.controlador_red[i] == 1 && data.pc_controlador_red[i] == data.controlador_red[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.controlador_red[i] == 0 && data.pc_controlador_red[i] != data.controlador_red[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        if (data.paq_office_version[i] == data.pc_paq_office_version[i]) {
                          html += '<td class="table-success">'+data.paq_office_version[i]+'</td>';
                        }else{
                          html += '<td class="table-danger">'+data.paq_office_version[i]+'</td>';
                        }
                        if (data.paq_office_activado[i] == 1 && data.pc_paq_office_activado[i] != data.paq_office_activado[i]) {
                          html += '<td class="table-danger">Si</td>';
                        }else if(data.paq_office_activado[i] == 1 && data.pc_paq_office_activado[i] == data.paq_office_activado[i]){
                          html += '<td class="table-success">Si</td>';
                        }else if(data.paq_office_activado[i] == 0 && data.pc_paq_office_activado[i] != data.paq_office_activado[i]){
                          html += '<td class="table-danger">No</td>';
                        }else{
                          html += '<td class="table-success">No</td>';
                        }
                        html += '<td class="table-success">'+data.observaciones[i]+'</td>';
                        html += '</tr>';
                      }
                      
                      html += '</tbody>';
                      html += '</table>';

                      html += '<div>';
                      //for (var i = 0; i < data.items_all.length; i++) {
                        console.log(data.items_all);
                      //}
                      $('#rev_rapida_form').html(html);
                      
                    }else if(data.tipo == 'Rápida' || data.tipo == 'Rapida' ||data.tipo == 'rapida'){
                      $("#user_id_edit").val(data.user_id);
                      $("#label_user_edit").addClass('col-md-1');
                      $("#user_id_edit").addClass('col-md-4');
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#label_lugar_edit").addClass('col-md-1 ml-auto');
                      $("#lugar_id_edit").addClass('col-md-4 ml-auto');
                      $("#tipo_edit").val(data.tipo);
                      $("#label_tipo_edit").addClass('col-md-1');
                      $("#tipo_edit").addClass('col-md-4');
                      $("#momento_edit").val(data.momento);
                      $("#label_momento_edit").addClass('col-md-1 ml-auto');
                      $("#momento_edit").addClass('col-md-4 ml-auto');
                      $("#observaciones_edit").val(data.observaciones);

                      htmlRap += '<table class="table table-sm table-dark" id="revs_table">';
                      htmlRap += '<thead>';
                      htmlRap += '<h4 class="center">Cantidades Items Existentes</h4>';
                      htmlRap += '<tr>';
                      htmlRap += '<th>PC</th>'
                      htmlRap += '<th>Mesa</th>';
                      htmlRap += '<th>Silla</th>';
                      htmlRap += '<th>Pizarrones</th>';
                      htmlRap += '<th>Televisión</th>';
                      htmlRap += '<th>Termostato</th>';
                      htmlRap += '<th>Ruteador</th>';
                      htmlRap += '<th>Switch</th>';
                      htmlRap += '</tr>';
                      htmlRap += '</thead>';
                      htmlRap += '<tbody>';
                      htmlRap += '<tr>';
                      htmlRap += '<td>'+data.pc_cant+'</td>'
                      
                        htmlRap += '<td>'+data.mesa_cant+'</td><td>'+data.silla_cant+'</td><td>'+data.piz_cant+'</td>';
                        htmlRap += '<td>'+data.television_cant+'</td><td>'+data.termostato_cant+'</td>';
                        htmlRap += '<td>'+data.ruteador_cant+'</td><td>'+data.swith_cant+'</td>';
                        htmlRap += '</tr>';
                      
                      
                      htmlRap += '</tbody>';
                      htmlRap += '</table>';
                      
                      htmlRap += '<table class="table table-striped table-bordered" id="revs_table">';
                      htmlRap += '<thead>';
                      htmlRap += '<h4 alight="center">Datos Revisión Rápida</h4>';
                      htmlRap += '<tr>';
                      htmlRap += '<th>Clasificación</th>';
                      htmlRap += '<th>Cantidad Revisada</th>';
                      htmlRap += '<th>Cantidad de Faltantes</th>';
                      htmlRap += '<th>Cantidad de Sobrantes</th>';
                      htmlRap += '</tr>';
                      htmlRap += '</thead>';
                      htmlRap += '<tbody>';
                      htmlRap += '<tr>';
                      
                      for (var i = 0; i < data.cantidad.length; i++) {
                        if (data.clasificacion[i] == 'Pc') {
                          if (data.cantidad[i] != data.pc_cant && data.cantidad[i] > data.pc_cant) {
                            var falta_pc = data.cantidad[i] - data.pc_cant;
                            htmlRap += '<td class="table-danger">Pc</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_pc+'</td>';                            }else if(data.cantidad[i] != data.pc_cant && data.cantidad[i] < data.pc_cant){
                            var falta_pc = data.pc_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Pc</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_pc+'</td><td class="table-danger">0</td>';  
                          }else{
                            htmlRap += '<td class="table-success">Pc</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Mesa') {
                          if (data.cantidad[i] != data.mesa_cant && data.cantidad[i] > data.mesa_cant) {
                            var falta_cant = data.cantidad[i] - data.mesa_cant;
                            htmlRap += '<td class="table-danger">Mesa</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.mesa_cant && data.cantidad[i] < data.mesa_cant){
                            var falta_cant = data.mesa_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Mesa</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';  
                          }else{
                            htmlRap += '<td class="table-success">Mesa</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Silla') {
                          if (data.cantidad[i] != data.silla_cant && data.cantidad[i] > data.silla_cant) {
                            var falta_cant = data.cantidad[i] - data.silla_cant;
                            htmlRap += '<td class="table-danger">Silla</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.silla_cant && data.cantidad[i] < data.silla_cant){
                            var falta_cant = data.silla_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Silla</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';  
                          }else{
                            htmlRap += '<td class="table-success">Silla</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Pizarrón') {
                          if (data.cantidad[i] != data.piz_cant && data.cantidad[i] > data.piz_cant) {
                            var falta_cant = data.cantidad[i] - data.piz_cant;
                            htmlRap += '<td class="table-danger">Pizarrnes</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.piz_cant && data.cantidad[i] < data.piz_cant){
                            var falta_cant = data.silla_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Pizarrones</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';  
                          }else{
                            htmlRap += '<td class="table-success">Pizarrones</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Television' || data.clasificacion[i] == 'Televisión') {
                          if (data.cantidad[i] != data.television_cant && data.cantidad[i] > data.television_cant) {
                            var falta_cant = data.cantidad[i] - data.television_cant;
                            htmlRap += '<td class="table-danger">Televisión</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.television_cant && data.cantidad[i] < data.television_cant){
                            var falta_cant = data.television_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Televisión</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';  
                          }else{
                            htmlRap += '<td class="table-success">Televisión</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Termostato') {
                          if (data.cantidad[i] != data.termostato_cant && data.cantidad[i] > data.termostato_cant) {
                            var falta_cant = data.cantidad[i] - data.termostato_cant;
                            htmlRap += '<td class="table-danger">Termostato</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.termostato_cant && data.cantidad[i] < data.termostato_cant){
                            var falta_cant = data.termostato_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Termostato</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';
                          }else{
                            htmlRap += '<td class="table-success">Termostato</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Ruteador') {
                          if (data.cantidad[i] != data.ruteador_cant && data.cantidad[i] > data.ruteador_cant) {
                            var falta_cant = data.cantidad[i] - data.ruteador_cant;
                            htmlRap += '<td class="table-danger">Ruteador</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.ruteador_cant && data.cantidad[i] < data.ruteador_cant){
                            var falta_cant = data.ruteador_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Ruteador</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';
                          }else{
                            htmlRap += '<td class="table-success">Ruteador</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        if (data.clasificacion[i] == 'Switch') {
                          if (data.cantidad[i] != data.swith_cant && data.cantidad[i] > data.swith_cant) {
                            var falta_cant = data.cantidad[i] - data.swith_cant;
                            htmlRap += '<td class="table-danger">Switch</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">0</td><td class="table-danger">'+falta_cant+'</td>';  
                          }else if(data.cantidad[i] != data.swith_cant && data.cantidad[i] < data.swith_cant){
                            var falta_cant = data.swith_cant - data.cantidad[i];
                            htmlRap += '<td class="table-danger">Switch</td><td class="table-danger">'+data.cantidad[i]+'</td><td class="table-danger">'+falta_cant+'</td><td class="table-danger">0</td>';
                          }else{
                            htmlRap += '<td class="table-success">Switch</td><td class="table-success">'+data.cantidad[i]+'</td><td class="table-success">0</td><td class="table-success">0</td>';  
                          }
                        }
                        //htmlRap += '<td>'+data.clasificacion[i]+'</td><td>'+data.cantidad[i]+'</td>';
                        htmlRap += '</tr>';
                      }
                      
                      htmlRap += '</tbody>';
                      htmlRap += '</table>';
                      $('#rev_rapida_form').html(htmlRap);
                    }
                    
                    
                  }else{
                      $("#user_id_edit").val(data.user_id);
                      $("#label_user_edit").addClass('col-md-1');
                      $("#user_id_edit").addClass('col-md-4');
                      $("#lugar_id_edit").val(data.lugar_id);
                      $("#label_lugar_edit").addClass('col-md-1 ml-auto');
                      $("#lugar_id_edit").addClass('col-md-4 ml-auto');
                      $("#tipo_edit").val(data.tipo);
                      $("#label_tipo_edit").addClass('col-md-1');
                      $("#tipo_edit").addClass('col-md-4');
                      $("#momento_edit").val(data.momento);
                      $("#label_momento_edit").addClass('col-md-1 ml-auto');
                      $("#momento_edit").addClass('col-md-4 ml-auto');
                      $("#observaciones_edit").val(data.observaciones);
                      //$("#updated_at_edit").val(data.updated_at);
                    
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
}


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