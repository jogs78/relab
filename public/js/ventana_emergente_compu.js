function desaparecerFormulario(){
			$("#registrarCompu").fadeOut(300, desapareceRegistro);
		}

		function mostrarFormulario(){
			$("#registrarCompu").fadeIn();
			$("#oscurecer").click(desaparecerFormulario);
			$("#cerrarRegistroCompu").click(desaparecerFormulario);
		}

		function apareceRegistro(e){
			//Para prevenir que la pagina se recargue
			e.preventDefault();
			$("#oscurecer").fadeIn(500, mostrarFormulario);
		}

		function desapareceRegistro(){
			$("#oscurecer").fadeOut();
		}

		function mostrarloginyregistro(){
			/*$("#activarlogin").click(aparecerlogin);
			$("#cerrar").click(desaparecerlogin);*/

			$("#btnChooseCompu").click(apareceRegistro);
			
		}

		$(document).ready(mostrarloginyregistro);