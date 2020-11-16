<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	
	$respuesta = array();
	

	$cancela_abono = "UPDATE desglose_dinero 
	SET estatus_desglose = 'Cancelado' ,
	datos_cancelacion = 'Usuario: {$_COOKIE["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion }'
	WHERE id_desglose = {$_GET["id_registro"]}";
	
	$result_abono = mysqli_query($link,$cancela_abono) ;
	
	if($result_abono){
		$respuesta["result"] = "success";
	}
	else{
		$respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	}
	
	
	$respuesta["cancela_abono"] = "$cancela_abono";
	
	
	echo json_encode($respuesta);
	
?>