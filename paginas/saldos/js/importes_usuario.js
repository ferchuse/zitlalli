listarRegistros();

$('#id_empresas').on('change', function (event){
	
	$("#nombre_empresa").val($(this).find("option:selected").text())
	
	$('#form_filtro').submit();
	
});
$('#form_filtro').on('submit', function filtrar(event){
	event.preventDefault();
	
	listarRegistros();
	
});

var printService = new WebSocketPrinter();

function imprimirTicket(){
	console.log("imprimirTicket()");
		id_usuarios = $(this).data("id_usuarios")
	
	return $.ajax({
		url: "impresion/imprimir_corte_usuario.php",
		data: $("#form_filtro").serialize() + "&id_usuarios=" + id_usuarios
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


function listarRegistros(){
	console.log("listarRegistros()");
	$("#tabla_registros").html("<h3 class='text-center'>Cargando <i class='fas fa-spinner fa-spin'></i></h3>")
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'control/lista_importes_usuario.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		// $("#dataTable").dataTable();
		$(".imprimir").click(imprimirTicket);
		// $(".imprimir").click(imprimirTicket);
		// $(".cancelar").click(confirmaCancelacion);
		
		
		}).always(function(){
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		
	});
	
}