<?php 
	include('../../../conexi.php');
	
	include('../../../funciones/numero_a_letras.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$denominaciones = ["1000", "500", "200", "100", "50", "20", "10", "5", "2", "1", "0.5"];
	$consulta = "SELECT * FROM desglose_dinero 
	
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_desglose= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		
		$print.= "@";
		$print.= "!".chr(16)."DESGLOSE DE DINERO"."!".chr(0)."\n";
		$print.= "Folio: ".$filas["id_desglose"]."\n";
		$print.= "Fecha: ".$filas["fecha_desglose"]."\n";
		$print.= "Usuario: ".$filas["nombre_usuarios"]."\n";
		$print.= "Denom".chr(9).chr(9)."Cantidad".chr(9)."Importe  \n";
		
		foreach($denominaciones as $i => $denominacion){
			$print.= "$".number_format($denominacion).chr(9).chr(9).number_format($filas[$denominacion]).chr(9).chr(9).number_format($filas[$denominacion] * $denominacion)."  \n";
		}
		
		
		$print.="\n\nIMPORTE TOTAL: $".number_format($filas["importe_desglose"])."\n";
		$print.= NumeroALetras::convertir($filas["importe_desglose"], 'PESOS', 'CENTAVOS')."\n";
		$print.="\n\nVB";
		
		echo base64_encode($print);
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>		