<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	$fecha_cancelacion = date("Y-m-d H:i:s");
	
	$respuesta = array();
	
	//Cancelar Abono
	
	$cancela_abono = "UPDATE abono_general 
	SET estatus_abono = 'Cancelado' ,
	datos_cancelacion_abono_general = 'Usuario: {$_GET["nombre_usuarios"]} <br> Fecha: $fecha_cancelacion <br> Motivo: {$_GET["motivo"]}'
	WHERE id_abonogeneral = {$_GET["id_registro"]}";
	
	$result_abono = mysqli_query($link,$cancela_abono) ;
	
	if($result_abono){
		$respuesta["result"] = "success";
	}
	else{
		$respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	}
	
	//actualiza_saldo
	// $actualiza_saldo = "UPDATE unidades 
	// SET saldo_unidades = '' ,
	// estatus_tarjetas = 'Sin Recaudar' 
	// WHERE id_abonogeneral = {$_GET["id_registro"]}";
	
	// $result_abono = mysqli_query($link,$cancela_abono) ;
	
	// if($result_abono){
	// $respuesta["result"] = "success";
	// }
	// else{
	// $respuesta["result"] = "Error en $cancela_abono". mysqli_Error($link);
	// }
	
	
	
	echo json_encode($respuesta);
	
?>