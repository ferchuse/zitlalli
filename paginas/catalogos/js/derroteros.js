$(document).ready(function(){
	listarRegistros();
	//=========BOTON DEL MODAL=========================
	$("#btn_modal").click(function(){
		$("#form_edicion")[0].reset();
		$(".modal-title").text("Nuevo Derrotero");
		$("#modal_edicion").modal("show");
	});
	
	
	
	//==========GUARDAR ============
	$('#form_edicion').on('submit',function(event){
		event.preventDefault();
		let form = $(this);
		let boton = form.find(':submit');
		let icono = boton.find('.fa');
		let datos = form.serializeArray();
		
		boton.prop('disabled',true);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
		
		$.ajax({
			url: '../../funciones/guardar.php',
			method: 'POST',
			dataType: 'JSON',
			data:{
				tabla: 'derroteros',
				datos: datos
			}
			}).done(function(respuesta){
			if(respuesta.estatus == 'success'){
				alertify.success('Se ha agregado correctamente');
				$('#modal_edicion').modal('hide');
				listarRegistros();
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
	return $.ajax({
		url: '../../funciones/listar.php',
		method: 'POST',
		dataType: 'JSON',
		data: {
			tabla: 'derroteros'
		}
    }).done(function(respuesta){
		if(respuesta.estatus == 'success'){
			let derroteros = '';
			if(respuesta.num_rows > 0){
				$.each(respuesta.mensaje,function(index,element){
					derroteros += `
					<tr>
					<td class="text-center">${element.id_derroteros}</td>
					<td class="text-center">${element.nombre_derroteros}</td>
					<td class="text-center">${element.cuenta_derroteros}</td>
					<td class="text-center">${element.gasto_administracion}</td>
					<td class="text-center">${element.seguro_derroteros}</td>
					<td hidden class="text-center">${element.estatus_derrotero}</td>
					<td class="text-center"> 
					<button class="btn btn-outline-danger eliminar" data-id_derroteros='${element.id_derroteros}'><i class="fas fa-trash-alt"></i></button>
					<button class="btn btn-outline-warning editar" data-id_derroteros='${element.id_derroteros}'><i class="fas fa-pencil-alt"></i></button>
					</td>
					</tr>
					`;
				});
				}else{
				derroteros += `
				<tr>
				<td class="text-center"><h3>No hay Derroteros</h3></td>
				</tr>
				`;
			}
			$('#tabla_DB').html(derroteros);    
			
			// $('#tableDerroteros').DataTable({
				// "language": {
					// "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
				// }
			// });
			
			//=========ELIMINAR=========
			$('.eliminar').click(function(){
				let boton = $(this);
				let id_derroteros = boton.data('id_derroteros');
				var fila = boton.closest('tr');
				
				alertify.confirm('Confirmacion', '¿Deseas eliminarlo?', eliminar , function(){
				});
				
				function eliminar(){
					$.ajax({
						url: 'control/eliminar.php',
						method: 'POST',
						dataType: 'JSON',
						data: {
							tabla: 'derroteros',
							id_campo: 'id_derroteros',
							campo: id_derroteros
						}
						}).done(function(respuesta){
						if(respuesta.estatus == 'success'){
							alertify.success('Se ha eliminado correctamente');
							fila.fadeOut(1000);
							}else{
							alertify.error('Ocurrio un error');
						}
					});
				}
				
			});
			
			/*=======LISTAR EMPRESAS=========*/
			$('.editar').click(function(){
				var boton = $(this);
				var icono = boton.find('.fas');
				var id_derroteros = boton.data('id_derroteros');
				boton.prop('disabled',true);
				icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');
				
				$.ajax({
					url: '../../funciones/listar.php',
					method: 'POST',
					dataType: 'JSON',
					data: {
						tabla: 'derroteros',
						id_campo: 'id_derroteros',
						campo: id_derroteros
					}
					}).done(function(respuesta){
					if(respuesta.estatus == 'success'){
						$.each(respuesta.mensaje[0],function(index,element){
							$('#'+index).val(element);
						});
						$('.modal-title').text('Editar Derrotero');
						$('#modal_edicion').modal('show');
						}else{
						//console.log(respuesta.mensaje);
					}
					}).always(function(){
					boton.prop('disabled',false);
					icono.toggleClass('fas fa-pencil-alt fa fa-spinner fa-pulse fa-fw');
				});
			});
			
			
			
			
			
			}else{
			console.log("Error al cargar la tabla");
		}
	});
	
}