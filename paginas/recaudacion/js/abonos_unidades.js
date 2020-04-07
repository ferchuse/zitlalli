var printService = new WebSocketPrinter();


$('#form_filtro').on('submit', function filtrar(event){
	event.preventDefault();
	
	listarRegistros();
	
});


listarRegistros();

function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fa');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-spin ');
	
	return $.ajax({
		url: 'control/lista_abonos_unidades.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		$(".imprimir").click(function(){
			
			let id_registro = $(this).data("id_registro");
			
			boton.prop('disabled',true);
			icono.toggleClass('fa-print fa-spinner fa-spin ');
			imprimirTicket(id_registro).always(function(){
				
				boton.prop('disabled',false);
				icono.toggleClass('fa-print fa-spinner fa-spin');
				
			});
		});
		$(".cancelar").click(confirmaCancelacion);
		
		
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-spin');
		
	});
	
}


function imprimirTicket(id_registro){
	console.log("imprimirTicket()");
	
	
	return $.ajax({
		url: "impresion/imprimir_abono_unidades.php",
		data:{
			id_registro : id_registro
		}
		}).done(function (respuesta){
		
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
		
	});
}


function confirmaCancelacion(event){
	console.log("confirmaCancelacion()");
	let boton = $(this);
	let icono = boton.find(".fas");
	var id_registro = $(this).data("id_registro");
	var fila = boton.closest('tr');
	
	alertify.prompt()
  .setting({
    'reverseButtons': true,
		'labels' :{ok:"SI", cancel:'NO'},
		'title': "Cancelar Abono" ,
    'message': "Motivo de Cancelación" ,
    'onok':cancelarRegistro,
    'oncancel': function(){
			boton.prop('disabled', false);
			
		}
	}).show();
	
	
	
	
	function cancelarRegistro(evt, motivo){
		if(motivo == ''){
			console.log("Escribe un motivo");
			alertify.error("Escribe un motivo");
			return false;
			
		}
		
		boton.prop("disabled", true);
		icono.toggleClass("fa-times fa-spinner fa-spin");
		
		
		return $.ajax({
			url: "control/cancelar_abono.php",
			dataType:"JSON",
			data:{
				id_registro : id_registro,
				nombre_usuarios : $("#sesion_nombre_usuarios").text(),
				motivo : motivo
			}
			}).done(function (respuesta){
			if(respuesta.result == "success"){
				alertify.success("Cancelado");
				listarRegistros();
			}
			else{
				alertify.error(respuesta.result);
				
			}
			
			}).always(function(){
			boton.prop("disabled", false);
			icono.toggleClass("fa-times fa-spinner fa-spin");
			
		});
	}
}
