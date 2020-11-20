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
	suma_mutualidad,
	suma_egresos,
	suma_desglose
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
	
	";
	
	
	$consulta.="
	
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(importe_desglose) AS suma_desglose
	FROM
	desglose_dinero
	WHERE
	estatus_desglose <> 'Cancelado'
	AND DATE(fecha_desglose) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= "
	GROUP BY
	id_usuarios
	) AS t_suma_desglose USING (id_usuarios)
	
	";
	
	
	$consulta.="
	
	LEFT JOIN (
	SELECT
	id_usuarios,
	SUM(importe) AS suma_egresos
	FROM
	egresos_caja
	WHERE
	estatus <> 'Cancelado'
	AND DATE(fecha) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'";
	
	
	if($_GET["id_empresas"] != ""){
		$consulta.= " AND id_empresas = '{$_GET["id_empresas"]}'";
	}
	
	$consulta.= "
	GROUP BY
	id_usuarios
	) AS t_suma_egresos USING (id_usuarios)
	
	";
	
	
	
	
	$consulta.=" 
	
	
	WHERE id_usuarios = {$_GET["id_usuarios"]}";
	
	
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Registro No encontrado</div>");
			
			
		}
		
		while($row = mysqli_fetch_assoc($result)){
			
			$fila = $row ;
			
		}
		
		
		$consulta_egresos = "
		SELECT * FROM egresos_caja
		
		
		WHERE
		estatus <> 'Cancelado'
		AND DATE(fecha) BETWEEN '{$_GET["fecha_inicial"]}'
		AND '{$_GET["fecha_final"]}'
		AND id_usuarios = '{$_COOKIE["id_usuarios"]}'
		
		";
		
		
		if($_GET["id_empresas"] != ""){
			$consulta_egresos.= " AND id_empresas = '{$_GET["id_empresas"]}'";
		}
		
		$result_egresos = mysqli_query($link,$consulta_egresos);
		
		while($row = mysqli_fetch_assoc($result_egresos)){
			
			$lista_egresos[] = $row ;
			
		}
		
		
		
		$total_recaudacion = $fila["suma_abonos_unidades"] + $fila["suma_abonos_general"] + $fila["suma_mutualidad"] ;
		
		$diferencia = ($fila["suma_egresos"] + $fila["suma_desglose"]) - $total_recaudacion  ;
		
		for ($x = 0 ; $x < 1; $x++){
			$respuesta.= file_get_contents('../../img/logo_brujaz.tmb');
			$respuesta.= "COORDINADORA DE TRANSPORTE GRUPO AAZ A.C.\n";
			$respuesta.= "\n";
			$respuesta.= "\x1b"."@";
			$respuesta.= "\x1b"."E".chr(1); // Bold
			
			$respuesta.= "!\x10"; //font size
			$respuesta.= "INFORME DE ENTREGA DE RECAUDACION \n";
			$respuesta.= "\x1b"."E".chr(0); // Not Bold
			$respuesta.= "\x1b"."@";
			
			$respuesta.= "EMPRESA: ".$_GET["nombre_empresa"]. "\n";
			$respuesta.= "FECHA:". date("d-m-Y"). "\n";
			$respuesta.= "USUARIO:". $_COOKIE["nombre_usuarios"]."\n\n";
			$respuesta.= "ABONO DE UNIDADES:   $".number_format($fila["suma_abonos_unidades"])."\n\n";
			$respuesta.= "ABONO GENERAL:       $".number_format($fila["suma_abonos_general"])."\n\n";
			$respuesta.= "MUTUALIDAD:          $".number_format($fila["suma_mutualidad"])."\n\n";
			$respuesta.= "TOTAL RECAUDACION:   $".number_format($total_recaudacion)."\n\n";
			
			$respuesta.= "EGRESOS:  \n\n";
			foreach($lista_egresos as $egreso){
				
				$respuesta.= "#{$egreso["id_vales"]} {$egreso["concepto"]}      $ {$egreso["importe"]}   \n";
			}
			
			
			
			
			$respuesta.= "TOTAL EGRESOS:             $".number_format($fila["suma_egresos"])."\n\n";
			$respuesta.= "EFECTIVO:            $".number_format($fila["suma_desglose"])."\n\n";
			$respuesta.= "DIFERENCIA:          $".number_format($diferencia);
			
			
			$respuesta.= "\x1b"."d".chr(2); // 4 Blank lines
			$respuesta.= "\nVA"; // Cut
		}
		
		// echo $consulta;
		
		echo base64_encode ( $respuesta );
		// echo  ( $respuesta );
		
		
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>			