$(document).ready(function() {
	let html = ''
	
	function usersConectados()	{
		$.get("/users_conected", function(data, status){
			html = ''
			for(var i = 0; i < data.length; i++){
				html += `<a href="#" id="`+data[i].id+`" class="dropdown-item mr-5 user_msg">
								<img src="/imguser/`+data[i].path+`" width="35" class="img-thumbnail">
                                <strong class="text-primary">`+data[i].nombre+`</strong>
                                <span class="badge badge-success badge-pill"><i class="fas fa-check"></i></span>
                            </a>`;
				$("#drop_conectados").html(html)
			}
			$(".user_msg").on('click', function(e){
				e.preventDefault()
				alert('Ups opción en desarrollo')
			})
		});

	}

	usersConectados()

	setInterval(function(){
        usersConectados();
    }, 10000);

});