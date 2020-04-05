$(document).ready(function(){ 
	
	//=====PROMESA DE LISTAR CONDUCTOR========
	listarRegistros();
	// $("#propietarios").find("select").prop("disabled", true).val("");
	//========DAR LCIK EN BOTON DE NUEVO=============
	$('#form_filtro').on('submit', function filtrar(){
		console.log("fultrar")
		listarRegistros();
		return false;
	});
	
	
	
	
	$('#nuevo').on('click',function(){
		$('#form_edicion')[0].reset();
		$('.modal-title').text('Nuevo Traspaso');
		$('#modal_edicion').modal('show');
	});
	
	$("#btn_agregar").click(agregarUnidad)
	
	$('.monto').on('keyup', function calculaSaldo(event){
		console.log("calculaSaldo()")
		var monto_total = 0;
		var $fila = $(this).closest(".form-row");
		var monto = Number($fila.find(".monto").val());
		var saldo_anterior = Number($fila.find(".saldo_unidades").val());
		$fila.find(".saldo_restante").val(saldo_anterior - monto ); 
		
		$(".monto").each(function sumaMontos(index, item){
			monto_total+= Number($(item).val());
			
		})
		
		$("#monto_traspaso").val(monto_total);
		
	});
	
	$('#form_edicion').on('keypress',function(event){
		
		if(event.which == 13){
			event.preventDefault();
			console.log("Enter form");
			return false;
		}
	});
	
	
	$('.num_eco').on('keyup', function buscarUnidad(event){
		event.preventDefault();
		
		$input = $(this);
		var num_eco = $(this).val();
		if(num_eco == ''){
			alertify.error("Ingrese un Num Eco");
			return false;
		}
		
		var $fila = $(this).closest(".form-row");
		
		console.log("Buscar Unidad", event.which )
		if(event.which == 13){
			
			$input.toggleClass("cargando");
			$.ajax({
				url: 'control/buscar_unidad.php',
				method: 'GET',
				dataType: 'JSON',
				data: {num_eco: num_eco}
				}).done(function(respuesta){
				
				if(respuesta.num_rows == 0){
					alertify.error("No encontrado")
					return false;
				}
				
				$.each(respuesta.filas, function(name, value){
					$fila.find("."+name).val(value);
					
					
				});
				
				
				$fila.find(".monto").focus();
				
				
				}).always(function(){
				
				$input.toggleClass("cargando");
			});
			
		};
	});
	
	
	$('#form_edicion').on('submit', function guardarTraspaso(event){
		event.preventDefault();
		let form = $(this);
		let boton = form.find(':submit');
		let icono = boton.find('.fa');
		let datos = form.serialize();
		let fecha = obtenerFecha(); 
		
		datos +='&id_usuarios='+ $("#id_usuarios").val();
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
		
		$.ajax({
			url: 'control/guardar_traspaso.php',
			method: 'POST', 
			dataType: 'JSON', 
			data: datos
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha agregado correctamente');
				$('#modal_edicion').modal('hide');
				listarRegistros();
				imprimirTicket(respuesta.insert_id);
				}else{
				alertify.error('Ocurrio un error');
			}
			}).always(function(){
			boton.prop('disabled',false);
			icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
		});
	})
	
	
	
	
});





function listarRegistros(){
	console.log("listarRegistros()");
	
	let form = $("#form_filtro");
	let boton = form.find(":submit");
	let icono = boton.find('.fa');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-search fa-spinner fa-pulse ');
	
	return $.ajax({
		url: 'control/lista_traspasos.php',
		data: $("#form_filtro").serialize()
		}).done(function(respuesta){
		
		$("#tabla_registros").html(respuesta)
		
		
		$(".imprimir").click(function (){
			var id_registro = $(this).data("id_registro");
			var boton = $(this);
			var icono = boton.find("fas");
			
			boton.prop("disabled", true);
			icono.toggleClass("fa-print fa-spinner fa-spin");
			
			imprimirTicket(id_registro).always(function(){
				
				boton.prop("disabled", false);
				icono.toggleClass("fa-print fa-spinner fa-spin");
				
			});
			
			
		});
		
		$(".cancelar").click(confirmaCancelacion);
		
		
		}).always(function(){  
		
		boton.prop('disabled',false);
		icono.toggleClass('fa-search fa-spinner fa-pulse fa-fw');
		
	});
}




function confirmaCancelacion(){
	let boton = $(this);
	let id_registro = boton.data('id_registro');
	var fila = boton.closest('tr');
	
	alertify.confirm('Confirmación', '¿Deseas Cancelarlo?', eliminar , function(){
	}); 
	
	function eliminar(){
		$.ajax({
			url: '../../funciones/fila_update.php',
			method: 'POST',
			dataType: 'JSON',
			data: {
				valores: [{name:"estatus_traspaso", value: "Cancelado"}],
				id_campo: 'id_traspaso',
				id_valor: id_registro,
				tabla: "traspaso_utilidad"
			}
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha cancelado correctamente');
				// fila.fadeOut(1000);
				listarRegistros();
				}else{
				alertify.error('Ocurrio un error');
			}
		});
	}
	
}

function obtenerFecha(){
	let today = new Date();
	let dd = today.getDate();
	
	let mm = today.getMonth()+1; 
	const yyyy = today.getFullYear();
	if(dd<10) 
	{
		dd=`0${dd}`;
	} 
	
	if(mm<10) 
	{
		mm=`0${mm}`;
	} 
	return today = `${yyyy}-${mm}-${dd}`;
}

function imprimirTicket(id_registro){
	
	
	return $.ajax({
		url: "impresion/imprimir_traspaso.php",
		data:{
			id_registro : id_registro,
			nombre_usuarios : $("#sesion_nombre_usuarios").html()
		}
		}).done(function (respuesta){
		
		$("#impresion").html(respuesta);
		setTimeout( function(){
			window.print();
			
		}, 500)
	})
}

function agregarUnidad(event){
	console.log("agregarUnidad")
	$("#unidades .form-row:first").clone(true).appendTo("#unidades");
	
}	