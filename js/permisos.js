function dame_permiso(){
	console.log("dame_permiso()")
	var permiso = $("#permiso").val();
	console.log("Permiso",permiso);
	
	
	if(permiso == "Lectura"){
		$(".btn-success, .btn-outline-success, .btn-warning, .btn-outline-warning , .btn-outline-danger, .btn-danger, .eliminar, .editar").hide();
	}
	if(permiso == "Supervisor"){
		$(".supervisor").prop("readonly", false);
	}
	if(permiso == "Escritura"){
		$(".btn-outline-danger, .btn-danger, .eliminar").hide();
	}
	
	
}
dame_permiso();

$(document).ready(function (){
	$(".modal").on("shown.bs.modal", function(ev){
		console.log("Focus En Modal");
		$(this).find("input:visible").first().focus();
	});
	
	$("#form_password").submit(cambiarPassword)
	
});


function cambiarPassword(evnt){
	
	
	console.log("cambiarPassword()")
	
	
	event.preventDefault();
	
	if($("#new_password").val() != $("#confirm_password").val()){
		
		alertify.error("Las contraseñas no coinciden");
		return false;
	}
	
	let form = $(this);
	let boton = form.find(':submit');
	let icono = boton.find('.fas');
	
	boton.prop('disabled',true);
	icono.toggleClass('fa-save fa-spinner fa-pulse ');
	
	$.ajax({
		url: '../../funciones/cambiar_password.php',
		method: 'POST',
		dataType: 'JSON',
		data: $("#form_password").serialize()
		}).done(function(respuesta){
		if(respuesta.estatus == 'success'){
			alertify.success('Guardado correctamente');
			$('#modal_password').modal('hide');
			
		}
		else{
			alertify.error('Ocurrio un error');
		}
		}).always(function(){
		boton.prop('disabled',false);
		icono.toggleClass('fa-save fa-spinner fa-pulse ');
	});
	
}