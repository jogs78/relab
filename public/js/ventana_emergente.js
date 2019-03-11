function desaparecerFormulario(){
			$("#registrar").fadeOut(300, desapareceRegistro);
		}

		function mostrarFormulario(){
			$("#registrar").fadeIn();
			$("#oscurecer").click(desaparecerFormulario);
			$("#cerrarRegistro").click(desaparecerFormulario);
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

			$("#btnChoose").click(apareceRegistro);
		}

		$(document).ready(mostrarloginyregistro);