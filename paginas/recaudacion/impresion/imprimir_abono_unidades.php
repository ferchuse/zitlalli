<?php 
	include('../../../conexi.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM abonos_unidades 
	LEFT JOIN tarjetas USING(tarjeta)
	LEFT JOIN conductores USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN empresas ON tarjetas.id_empresas = empresas.id_empresas
	LEFT JOIN recaudaciones ON abonos_unidades.id_recaudaciones = recaudaciones.id_recaudaciones
	LEFT JOIN usuarios ON abonos_unidades.id_usuarios = usuarios.id_usuarios
	
	WHERE id_abonos_unidades= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Abono {$_GET['id_registro']} No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		$total = $filas["cuenta"] - $filas["monto_condonaciones"];
		for($i = 0; $i < 2 ; $i++){
			
			$print.= "@";
			$print.= "!".chr(16)."ABONO DE UNIDADES"."!".chr(0)."\n";
			$print.= "Folio: ".$filas["id_abonos_unidades"]."\n";
			$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
			$print.= "Fecha Abono: ".$filas["fecha_abonos"]."\n";
			$print.= "Fecha Cuenta: ".$filas["fecha_tarjetas"]."\n";
			$print.= "Recaudacion: ".$filas["nombre_recaudaciones"]."\n";
			$print.= "Empresa: ".$filas["nombre_empresas"]."\n";
			$print.= "Num Eco: ".$filas["num_eco"]."\n";
			$print.= "Conductor: ".$filas["nombre_conductores"]."\n";
			$print.= "Cuenta: $".$filas["cuenta"]."\n";
			$print.= "Condonacion: $".$filas["condonacion"]."\n ";
			$print.= "Total: $".$total."\n";
			$print.= "Termicos: ". $filas["saldo_tarjetas"]."\n";
			$print.= "Quetzal: ". $filas["bol_etiflex_importe"]."\n";
			$print.= "Total Tijera: $".$filas["importe_tijera"]."\n";
			$print.= "Total Boletos: $". $filas["total_boletos"]."\n";
			$print.= "Efectivo: $". $filas["efectivo"]."\n";
			$print.= "Total Recaudado: $".$filas["total_recaudado"] ."\n";
			$print.= "Abono Unidad: $".$filas["abono_unidad"] ."\n";
			$print.= "Devolucion: $".$filas["devolucion"] ."\n";
			
			$print.="\n\nVB";
		
			
		}
		if($filas["devolucion"] > 0){
			$print.= "!".chr(16)."DEVOLUCION"."!".chr(0)."\n";
			$print.= "Folio Abono: ".$filas["id_abonos_unidades"]."\n";
			$print.= "Fecha Abono: ".$filas["fecha_abonos"]."\n";
			$print.= "Fecha Cuenta: ".$filas["fecha_tarjetas"]."\n";
			$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
			$print.= "Recaudacion: ".$filas["nombre_recaudaciones"]."\n";
			$print.= "Empresa: ".$filas["nombre_empresas"]."\n";
			$print.= "Num Eco: ".$filas["num_eco"]."\n";
			$print.= "Conductor: ".$filas["nombre_conductores"]."\n";
			$print.= "Devolucion: ".$filas["devolucion"]."\n";
			
			$print.="\n\nVB";
		}
		
		echo base64_encode($print);
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>	