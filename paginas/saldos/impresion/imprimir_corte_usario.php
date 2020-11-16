<?php 
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/console_log.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = "";
	
	
	$consulta = "##Importes por Usuario
	SELECT
	id_usuarios,
	nombre_usuarios,
	suma_abonos_unidades,
	suma_abonos_general,
	suma_mutualidad
	FROM
	usuarios
	LEFT JOIN (
	SELECT
	abonos_unidades.id_usuarios,
	SUM(abono_unidad) AS suma_abonos_unidades
	FROM
	abonos_unidades
	LEFT JOIN tarjetas USING(tarjeta)
	WHERE
	estatus_abonos <> 'Cancelado'
	AND date(fecha_abonos) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= " GROUP BY
	id_usuarios
	) AS t_suma_abonos_unidades USING (id_usuarios)
	
	
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(monto_abonogeneral) AS suma_abonos_general
	FROM
	abono_general
	LEFT JOIN unidades USING(id_unidades)
	WHERE
	estatus_abono <> 'Cancelado'
	AND date(fecha_abonogeneral) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	
	$consulta.=" GROUP BY
	id_usuarios
	) AS t_suma_abonos_general USING (id_usuarios)
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(monto_mutualidad) AS suma_mutualidad
	FROM
	mutualidad
	WHERE
	estatus_mutualidad <> 'Cancelado'
	AND DATE(fecha_mutualidad) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= " GROUP BY
	id_usuarios
	) AS t_suma_mutualidad USING (id_usuarios)
	WHERE usuarios.id_administrador = '{$_COOKIE["id_administrador"]}'
	
	
	";
	
	
	
	$consulta.=" AND id_usuarios = {$_COOKIE["id_usuarios"]}";
	
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		for ($x = 0 ; $x < 1; $x++){
			$respuesta.= file_get_contents('../../img/logo_brujaz.tmb');
			$respuesta.= "COORDINADORA DE TRANSPORTE GRUPO AAZ A.C.\n";
			$respuesta.= "\n";
			$respuesta.=   "\x1b"."@";
			$respuesta.= "\x1b"."E".chr(1); // Bold
			
			$respuesta.= "!\x10"; //font size
			$respuesta.=   "INFORME DE ENTREGA DE RECAUDACION \n";
			$respuesta.=  "\x1b"."E".chr(0); // Not Bold
			$respuesta.=   "\x1b"."@";
			$respuesta.= "FOLIO: 1234". "\n";
			$respuesta.= "FECHA:". date("d-m-Y"). "\n";
			$respuesta.= "Turno:". $_COOKIE["nombre_usuarios"]."\n\n";
			// $respuesta.= "MONTO TOTAL RECAUDADO:  $123". $filas["suma_abonos_general"] + $filas["suma_abonos_unidades"]."\n\n";
			// $respuesta.= "MONTO TOTAL RECAUDADO:  $123". "\n\n";
			// $respuesta.= "MONTO TOTAL RECAUDADO:  $123". "\n\n";
			$respuesta.= "MONTO TOTAL RECAUDADO:  $123". "\n\n";
			$respuesta.= "MUTUALIDAD:             $123". "\n\n";
			// $respuesta.= "MUTUALIDAD:             $123". $filas["suma_mutualidad"]."\n\n";
			// $respuesta.= "TOTAL:                  $123".$filas["suma_abonos_general"] + $filas["suma_abonos_unidades"] + $filas["suma_mutualidad"]."\n\n";
			$respuesta.= "TOTAL:                  $123"."\n\n";
			$respuesta.= "VALES PAGADOS:          "."$123"."\n\n";
			$respuesta.= "BOLETOS PAGADOS:      "."$123"."\n\n";
			$respuesta.= "VALES DE OPERADOR:      "."$123"."\n\n";
			$respuesta.= "BOLETOS CANCELADOS:      "."$123"."\n\n";
			
			$respuesta.= "EFECTIVO:   $123"."\n\n";
			
			
			
			$respuesta.=  "\nIMPORTE TOTAL:              $ 123" .chr(9). number_format($filas["importe_desglose"]);
			
			
			$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
			$respuesta.= "\nVA"; // Cut
		}
		
		echo base64_encode ( $respuesta );
		// echo  ( $respuesta );
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>			