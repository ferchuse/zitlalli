<?php 
	
	include('../../../conexi.php');
	
	$link = Conectarse();

	
	$consulta_recaudacion = "
	##Recaudacion
	SELECT
	id_empresas,
	'Recaudación' AS tipo_ingreso,
	nombre_empresas,
	ingreso
	FROM
	empresas
	LEFT JOIN (
	SELECT
	id_empresas,
	SUM(abono_unidad) AS ingreso
	FROM
	abonos_unidades
	LEFT JOIN tarjetas USING (tarjeta)
	WHERE
	estatus_abonos <> 'Cancelado'
	AND date(fecha_abonos) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	GROUP BY
	id_empresas
	) t_abonos USING (id_empresas)";
	
	$consulta_abono_general= "
	##Abono General
	SELECT
	id_empresas,
	'Abono General' AS tipo_ingreso,
	nombre_empresas,
	ingreso
	FROM
	empresas
	LEFT JOIN (
	SELECT
	id_empresas,
	SUM(monto_abonogeneral) AS ingreso
	FROM
	abono_general
	LEFT JOIN unidades USING (id_unidades)
	WHERE
	estatus_abono <> 'Cancelado'
	AND date(fecha_abonogeneral) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	
	GROUP BY
	id_empresas
	) t_abono_general USING (id_empresas)
	";
	
	
	$consulta_mutualidad ="
	
	##Mutualidad
	
	SELECT
	id_empresas,
	'Mutualidad' AS tipo_ingreso,
	nombre_empresas,
	ingreso
	FROM
	empresas
	LEFT JOIN (
	SELECT
	id_empresas,
	SUM(monto_mutualidad) AS ingreso
	FROM
	mutualidad
	WHERE
	estatus_mutualidad <> 'Cancelado'
	AND date(fecha_mutualidad) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	GROUP BY
	id_empresas
	) t_mutualidad USING (id_empresas)
	WHERE
	1
	
	
	";
	
  // echo $consulta;
	
	$result_recaudacion = mysqli_query($link,$consulta_recaudacion);
	if($result_recaudacion){
		
		// if( mysqli_num_rows($result_recaudacion) == 0){
		
		// }
		
		while($fila = mysqli_fetch_assoc($result_recaudacion)){
			$recaudaciones[] = $fila;
		}
	}
	else{
		
		// die("<div class='alert alert-danger'>No hay registros $consulta</div>");
	}
	
	$result_abono_general = mysqli_query($link,$consulta_abono_general);
	if($result_abono_general){
		
		// if( mysqli_num_rows($result_abono_general) == 0){
		// die("<div class='alert alert-danger'>No hay registros $consulta</div>");
		// }
		
		while($fila = mysqli_fetch_assoc($result_abono_general)){
			$abonos_generales[] = $fila;
		}
	}
	
	$result_mutualidad = mysqli_query($link,$consulta_mutualidad);
	if($result_mutualidad){
		
		// if( mysqli_num_rows($result_recaudacion) == 0){
		// die("<div class='alert alert-danger'>No hay registros $consulta</div>");
		// }
		
		while($fila = mysqli_fetch_assoc($resultresult_mutualidad)){
			$mutualidades[] = $fila;
			
		}
	}
	
	
?>  

<table class="table table-bordered table-condensed">
	<thead class="text-center">
		<tr>
			<th colspan="2">Ingresos</th>
			
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="2"><b>Recaudación</b></th>
		</tr>
		<tr>
			<th colspan="">Empresa</th>
			<th colspan="">Monto</th>
		</tr>
		<?php 
			foreach($recaudaciones as $recaudacion){
				$total_ingresos+= $recaudacion["ingreso"] ;
			?>
			<tr>
				<td><?php echo $recaudacion["nombre_empresas"] ?></td>
				<td><?php echo number_format($recaudacion["ingreso"]) ?></td>
			</tr>
			<?php
			}
		?>
	</tbody>
	<tfoot>
		<tr class="h4">
			<td >
				<b> TOTAL</b>
			</td>
			
			<td ><b><?php echo number_format($total_ingresos)?></b></td>
		</tr>
	</tfoot>
</table>
<?php
}
else{
	echo "<pre>Error:".mysqli_error($link)." $consulta</pre>";
}

?>	

<?php
	$consulta = "
	##Egresos
	
	SELECT
	id_empresas,
	'Recibos de Salida' AS tipo_egreso,
	nombre_empresas,
	egreso
	FROM
	empresas
	LEFT JOIN (
	SELECT
	id_empresas,
	SUM(monto_reciboSalidas) AS egreso
	FROM
	recibosSalidas
	WHERE
	estatus_reciboSalidas <> 'Cancelado'
	AND date(fecha_reciboSalidas) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	GROUP BY
	id_empresas
	) t_recibosSalidas USING (id_empresas)
	WHERE
	id_empresas = 2
	UNION
	
	
	##Traspaso
	
	SELECT
	id_empresas,
	'Traspaso de Utilidad' AS tipo_egreso,
	nombre_empresas,
	egreso
	FROM
	empresas
	LEFT JOIN (
	SELECT
	id_empresas,
	SUM(monto_traspaso) AS egreso
	FROM
	traspaso_utilidad
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE
	estatus_traspaso <> 'Cancelado'
	AND date(fecha_traspaso) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	GROUP BY
	id_empresas
	) t_traspasos USING (id_empresas)
	WHERE
	id_empresas = 2;
	";
	
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros $consulta</div>");
			
		}
		
		
		
	?>  
	<table class="table table-bordered table-condensed">
		<thead class="text-center">
			<tr>
				<th colspan="2">Egresos</th>
				
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="">Concepto</td>
				<td colspan="">Monto</td>
			</tr>
			<?php 
				
				
				while($fila = mysqli_fetch_assoc($result)){
					$total_egresos+= $fila["egreso"] ;
				?>
				<tr>
					<td><?php echo $fila["tipo_egreso"] ?></td>
					<td><?php echo number_format($fila["egreso"]) ?></td>
				</tr>
				<?php
				}
			?>
		</tbody>
		<tfoot>
			<tr class="h4">
				<td >
					<b> TOTALES</b>
				</td>
				
				<td ><b><?php echo number_format($total_egresos)?></b></td>
			</tr>
		</tfoot>
	</table>
	<?php
	}
?>	
