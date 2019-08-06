$(document).ready(function(){
    var cont_always = sessionStorage['conta'];
    var contador = 0;
    var _token = $('input[name="_token"]').val();
            
    function load_unseen_revisions(view = ''){
        var conte = cont_always;
        var conte1 = contador;

        $.ajax({
        url: "/notify_revs",
        method: "POST",
        data: {view:view,_token:_token},
        dataType: "json",
        success:function(data){
            $("#drop_notificaciones").html(`<a class="dropdown-item text-primary" id="mark_all_seen" href="#">Marcar todos como leídas</a>
                                <div class="dropdown-divider"></div>`+data.notification);
            if (data.unseen_notification > 0) {
                if (conte > 1 || conte1 > 1) {
                                $(".count").html('');
                                $(".elemento_noti").css('background-color','#c3cde6');
                                $(".elemento_noti").css('margin','5px');
                                $("#visto_0").css('background-color','#f5f7fb');
                                $("#visto_1").css('background-color','#ffc');
                            }else{
                                $(".count").html(data.unseen_notification);
                                $(".elemento_noti").css('background-color','#c3cde6');
                                $(".elemento_noti").css('margin','5px');
                                $("#visto_1").css('background-color','#ffc');
                                $("#visto_0").css('background-color','#f5f7fb');
                            }
            }
            if (data.unseen_notification == 0) {
                            $(".count").html('');
                            //$(".elemento_noti").css('background-color','#c3cde6');
                            $(".elemento_noti").css('margin','5px');
                            //$(".elemento_noti").css('background-color','#c3cde6');
                            $(".elemento_noti").css('margin','5px');
            }

            $("#mark_all_seen").on('click', function(e){
                e.preventDefault()
                load_unseen_revisions('yes');
            })
        }
        });
                
    }

    load_unseen_revisions();

    $("#drop-mundo").on('click', function(event){
        event.preventDefault();
        desactivarCampanita();
    });

    function desactivarCampanita(){
        $(".count").html('');
        load_unseen_revisions();
        contador++;
        if (contador >= 2) {
            sessionStorage['conta'] = contador;
        }
    }

    $(document).on('click', ".not_visto",function(event){
        event.preventDefault();
        var id = $(".not_visto").attr("id");
                
        load_unseen_revisions(id);
        
        // do delete item
        location.href = "http://relab.isc.ittg.mx/rev_ultimas";
    });

    $( ".not_visto" ).hover(function() {
        //$( this ).fadeOut( 100 );
        //$( this ).fadeIn( 500 );}
        $(this).css('background', '#bfc4dc');
        $(this).css('margin','10px');
    });

    setInterval(function(){
        load_unseen_revisions();
    }, 10000);

});