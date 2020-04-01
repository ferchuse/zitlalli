<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/numero_a_letras.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM abono_general 
	LEFT JOIN unidades USING (id_unidades) LEFT JOIN empresas USING (id_empresas) LEFT JOIN propietarios USING (id_propietarios) LEFT JOIN derroteros USING (id_derroteros) LEFT JOIN motivosabonounidades USING (id_motivosAbono) LEFT JOIN usuarios USING (id_usuarios)
	WHERE id_abonogeneral= '{$_GET['id_registro']}'";
	
	
	$result = mysqli_query($link,$consulta); 
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			// console_log($fila);
			$filas = $fila ;
			
			
		}
		
		
		$print.= "@";
		$print.= "!".chr(16)."ABONO GENERAL"."!".chr(0)."\n";
		$print.= "Folio: ".$filas["id_abonogeneral"]."\n";
		$print.= "Fecha: ".$filas["fecha_abonogeneral"]."\n";
		$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
		$print.= "Num Eco: ".$filas["num_eco"]."\n";
		$print.= "Motivo: ".$filas["nombre_motivosAbono"]."\n";
		$print.= "Depositante: ".$filas["depositante"]."\n";
		$print.= "Concepto: $".$filas["concepto_abonogeneral"]."\n ";
		$print.= "Bueno Por: $".$filas["monto_abonogeneral"]."\n";
		$print.= NumeroALetras::convertir($filas["monto_abonogeneral"], 'PESOS', 'CENTAVOS')."\n";
		
		
		$print.="\n\nVB";
		
		echo base64_encode($print);
		
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>																																				