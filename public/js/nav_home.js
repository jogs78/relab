// --Variables
let nav = document.getElementById("nav");
let menu = document.getElementById("enlaces");

let abrir = document.getElementById("open");
let botones =document.getElementsByClassName("btn-header");
let cerrado = true;

function menus(){
	let desplazamiento_actual = window.pageYOffset;

	if (desplazamiento_actual <= 300) {
		nav.classList.remove("nav2");
		nav.className = ("nav1");
		nav.style.transition = "1s";
		menu.style.top = "80px";
		abrir.style.color = "white";
	}else{
		nav.classList.remove("nav1");
		nav.className = ("nav2");
		nav.style.transition = "1s";
		menu.style.top = "100px";
		abrir.style.color = "black";
	}
5
}

function apertura(){
	if (cerrado == true) {
		menu.style.width = '70vw';
		cerrado = false;
	}else{
		menu.style.width = '0%';
		menu.style.overflow = "hidden";
		cerrado = true;
	}
}

window.addEventListener("load", function(){
	/*Aquí ocultamos el icono de carga*/
	$("#onload").fadeOut();
	$("body").removeClass("hidden");
	menus();
});

window.addEventListener("click", function(e){
	if (cerrado == false) {
		let span = document.querySelector("span");
		if (e.target != span && e.target != abrir) {
			menu.style.width = '0%';
			menu.style.overflow = 'hidden';
			cerrado = true;
		}
	}
});

window.addEventListener("scroll", function(){
	//nos devuelve los pixeles de lo que mide la pagina
	/*console.log(this.window.pageYOffset);*/
	menus();
});

window.addEventListener("resize", function(){
	if (screen.width >= 700) {
		cerrado = true;
		menu.style.removeProperty("overflow");
		menu.style.removeProperty("width");
	}
});

abrir.addEventListener("click", function(){
	apertura();
});