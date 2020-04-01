<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	
	$consulta = "SELECT * FROM condonaciones 
	
	LEFT JOIN motivos_condonacion USING(id_motivo_condonacion)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_condonaciones= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		
		$print = "@";
		$print.= "CONDONACION DE TARJETA".chr(10).chr(13);
		$print.= "Fecha: ".$filas["fecha_condonaciones"].chr(10).chr(13);
		$print.= "Usuario: ".$filas["nombre_usuarios"].chr(10).chr(13);
		$print.= "Empresa: ".$filas["nombre_empresas"].chr(10).chr(13);
		$print.= "Num Eco: ".$filas["num_eco"].chr(10).chr(13);
		$print.= "Tarjeta: ".$filas["tarjeta"].chr(10).chr(13);
		$print.= "Motivo: ".$filas["motivo_condonacion"].chr(10).chr(13);
		$print.= "Monto: ".$filas["monto_condonaciones"].chr(10).chr(13);
		$print.= "Observaciones: ".$filas["observaciones_condonaciones"].chr(10).chr(13);
		
		$print.="\n\nVB";
		
		
		echo base64_encode($print);
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>