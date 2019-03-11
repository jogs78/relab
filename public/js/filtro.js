$(function(){
	$(".filter").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		let valor = $(this).attr("data-nombre");

		if (valor == "todos") {
			$(".cont-work").show("1000");
		}else{
			$(".cont-work").not("."+valor).hide("1000");
			$(".cont-work").filter("."+valor).show("1000");
		}
	});

	let usuario = $("#usuario").offset().top,
		sala = $("#sala").offset().top,
		mobi = $("#trabajo").offset().top,
		revision = $("#contacto").offset().top;

	window.addEventListener("resize", function(){
		let usuario = $("#usuario").offset().top,
			sala = $("#sala").offset().top,
			mobi = $("#trabajo").offset().top,
			revision = $("#contacto").offset().top;
	});

	$("#enlace-inicio").on("click", function(e){
		e.preventDefault();
		$("html, body").animate({
			scrollTop: 0
		}, 600);
	});

	$("#enlace-usuario").on("click", function(e){
		e.preventDefault();
		$("html, body").animate({
			scrollTop: usuario - 100
		}, 600);
	});
	$("#enlace-salas").on("click", function(e){
		e.preventDefault();
		$("html, body").animate({
			scrollTop: sala
		}, 600);
	});
	$("#enlace-mobi").on("click", function(e){
		e.preventDefault();
		$("html, body").animate({
			scrollTop: mobi - 100
		}, 600);
	});
	$("#enlace-revision").on("click", function(e){
		e.preventDefault();
		$("html, body").animate({
			scrollTop: revision - 100
		}, 600);
	});
});