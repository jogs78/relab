function desaparecerFormulario(){
			$("#registrarMobi").fadeOut(300, desapareceRegistro);
		}

		function mostrarFormulario(){
			$("#registrarMobi").fadeIn();
			$("#oscurecerMobi").click(desaparecerFormulario);
			$("#cerrarRegistroMobi").click(desaparecerFormulario);
		}

		function apareceRegistro(e){
			//Para prevenir que la pagina se recargue
			e.preventDefault();
			$("#oscurecerMobi").fadeIn(500, mostrarFormulario);
		}

		function desapareceRegistro(){
			$("#oscurecerMobi").fadeOut();
		}

		function mostrarloginyregistro(){
			/*$("#activarlogin").click(aparecerlogin);
			$("#cerrar").click(desaparecerlogin);*/

			$("#btnChooseMobi").click(apareceRegistro);
			
		}

		$(document).ready(mostrarloginyregistro);