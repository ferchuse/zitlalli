<?php 

	include('../conexi.php');
	$link = Conectarse();
	
	$respuesta = array();
	
	$consulta ="
	UPDATE propietarios 
	SET password_propietarios = '{$_POST["password_propietarios"]}' 
	WHERE id_propietarios = '{$_COOKIE["id_usuarios"]}' ";	
	
	$result = mysqli_query($link, $consulta);
	
	
	if($result){
		$respuesta["estatus"] = "success";
		$respuesta["mensaje"] = "Guardado";
		$respuesta["consulta"] = $consulta;
		
	}
	else{
		
		$respuesta["estatus"] = "error";
		$respuesta["mensaje"] = "Error en insert: $consulta  ".mysqli_error($link);		
	}
	
	echo json_encode($respuesta);
	
?>