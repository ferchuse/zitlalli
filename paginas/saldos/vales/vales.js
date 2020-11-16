
$(document).ready(onLoad);


function onLoad(){
	
	$("#nuevo").click(function nuevo() {
		console.log("nuevo()")
		
		$('#form_vales')[0].reset();
		$("#modal_vales").modal("show");
		
	});
	
	
	$('#form_filtros').on('submit', function(ev){
		ev.preventDefault();
		listarVales();
	});
	
	
	
	$('#form_vales').submit(guardarVales);
	
	$("#lista_vales").on("click", ".cancelar", confirmaCancelar);
	$("#lista_vales").on("click", ".imprimir", function(){
		imprimrTicket($(this).data("id_registro"));
	});
	
	listarVales();
	
}







function listarVales() {
	console.log("listarVales()");
	
	var boton = $("#form_filtros").find(":submit");
	var icono = boton.find(".fas");
	
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-search fa-spinner fa-spin");
	
	$.ajax({
		"url": "vales/listar_vales.php",
		data: $("#form_filtros").serialize()
		}).done(function alCargar(respuesta) {
		$("#lista_vales").html(respuesta);
		
		}).always(function(){
		
		boton.prop("disabled", false);
		icono.toggleClass("fa-search fa-spinner fa-spin");
		
	});
}


function confirmaCancelar(event){
	console.log("confirmaBorrar")
	let $boton = $(this);
	let $fila = $(this).closest('tr');
	let $icono = $(this).find(".fas");
	$boton.prop("disabled", true);
	$icono.toggleClass("fa-times fa-spinner fa-spin");
	
	if(confirm("¿Estás Seguro?")){
		$.ajax({ 
			"url": "vales/cancelar_vales.php",
			"dataType": "JSON",
			"data": {
				"id_registro": $boton.data("id_registro")
			}
			}).done( function alTerminar (respuesta){
			console.log("respuesta", respuesta);
			
			listarVales();
			
			}).fail(function(xhr, textEstatus, error){
			console.log("textEstatus", textEstatus);
			console.log("error", error);
			
			}).always(function(){
			
			$boton.prop("disabled", false);
			$icono.toggleClass("fa-times fa-spinner fa-spin"); 
		});
	}
}		

function guardarVales(event) {
	
	event.preventDefault();
	
	let boton = $(this).find(":submit");
	let icono = boton.find(".fas");
	
	boton.prop("disabled", true);
	icono.toggleClass("fa-save fa-spinner fa-spin");
	
	$.ajax({
		url: "vales/guardar_vales.php",
		method: "POST",
		dataType: "JSON",
		data: $("#form_vales").serialize() + "&id_corridas="+ $("#form_boletos #id_corridas").val()
		
		}).done(function (respuesta) {
		console.log("respuesta", respuesta);
		if (respuesta.estatus == "success") {
			
			alertify.success(respuesta.mensaje);
			
			$("#modal_vales").modal("hide");
			listarVales();
			imprimrTicket(respuesta.folio);
		}
		}).fail(function (xht, error, errnum) {
		
		alertify.error("Error", errnum);
		}).always(function () {
		boton.prop("disabled", false);
		icono.toggleClass("fa-save fa-spinner fa-spin");
		
	});
	
}



var printService = new WebSocketPrinter();

function imprimrTicket(folio){
	console.log("imprimrTicket()");
	
	
	
	
	$.ajax({
		url: "vales/imprimir_vales.php" ,
		data:{
			"folio" : folio
		}
		}).done(function (respuesta){
		
		
		if(window.AppInventor){
			window.AppInventor.setWebViewString(atob(respuesta));
		}
		
		$.ajax({
			url: "http://localhost/imprimir_zitlalli.php",
			method: "POST",
			data:{
				"texto" : respuesta
			}
		});
		
		
		
		printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
		});
		}).always(function(){
		
		
	});
}
