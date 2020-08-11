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
		
		while($fila = mysqli_fetch_assoc($result_mutualidad)){
			$mutualidades[] = $fila;
			
		}
	}
	
	
?>  

<div class="row" >
	<div class="col-sm-6">
		
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
						$total_recaudacion+= $recaudacion["ingreso"] ;
					?>
					<tr>
						<td><?php echo $recaudacion["nombre_empresas"] ?></td>
						<td class="text-right"><?php echo number_format($recaudacion["ingreso"]) ?></td>
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
					
					<td ><b><?php echo number_format($total_recaudacion)?></b></td>
				</tr>
			</tfoot>
		</table>
		
		
		<table class="table table-bordered table-condensed">
			<thead class="text-center">
				<tr>
					<th colspan="2"><b>Abono General de Unidades</b></th>
				</tr>
			</thead>
			<tbody>
				
				<tr>
					<th colspan="">Empresa</th>
					<th colspan="">Monto</th>
				</tr>
				<?php 
					foreach($abonos_generales as $fila){
						$total_abonos+= $fila["ingreso"] ;
					?>
					<tr>
						<td><?php echo $fila["nombre_empresas"] ?></td>
						<td class="text-right"><?php echo number_format($fila["ingreso"]) ?></td>
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
					
					<td ><b><?php echo number_format($total_abonos)?></b></td>
				</tr>
			</tfoot>
		</table>
		
		<table class="table table-bordered table-condensed">
			
			<tbody>
				<tr>
					<th class="text-center" colspan="2"><b>Mutualidad</b></th>
				</tr>
				<tr>
					<th colspan="">Empresa</th>
					<th colspan="">Monto</th>
				</tr>
				<?php 
					foreach($mutualidades as $fila){
						$total_mutualidades+= $fila["ingreso"] ;
					?>
					<tr>
						<td><?php echo $fila["nombre_empresas"] ?></td>
						<td class="text-right"><?php echo number_format($fila["ingreso"]) ?></td>
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
					
					<td ><b><?php echo number_format($total_mutualidades)?></b></td>
				</tr>
			</tfoot>
		</table>
		
		
	</div>
	
	
	<?php
		$consulta_salidas = "
		##Egresos
		
		SELECT
		
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
		
		
		";
		
		$consulta_traspasos =
		"##Traspaso
		
		SELECT
		
		'Traspaso de Utilidad' AS tipo_egreso,
		nombre_empresas,
		egreso
		FROM
		empresas
		LEFT JOIN (
		SELECT
		id_empresas,
		SUM(monto) AS egreso
		FROM
		traspaso_utilidad
		LEFT JOIN traspaso_utilidad_unidades USING (id_traspaso)
		LEFT JOIN unidades USING(id_unidades)
		WHERE
		estatus_traspaso <> 'Cancelado'
		AND date(fecha_aplicacion) BETWEEN '{$_GET["fecha_inicial"]}'
		AND '{$_GET["fecha_final"]}'
		GROUP BY
		id_empresas
		) t_traspasos USING (id_empresas)
		
		";
		
		
		
		$result_salidas = mysqli_query($link,$consulta_salidas);
		
		$result_traspasos = mysqli_query($link,$consulta_traspasos);
		
		while($fila = mysqli_fetch_assoc($result_traspasos)){
			$traspasos[] = $fila;
		}
		
		
		
		if($result_salidas){
			
			if( mysqli_num_rows($result_salidas) == 0){
				echo("<div class='alert alert-danger'>No hay registros $consulta</div>");
				
			}
			
			while($fila = mysqli_fetch_assoc($result_salidas)){
				$salidas[] = $fila;
			}
			
			
			
		?>  
		<div class="col-sm-6">
			
			<table class="table table-bordered table-condensed">
				<thead class="text-center">
					<tr>
						<th colspan="2">Egresos</th>
						
					</tr>
					<tr>
						<th colspan="2">Recibos de Salida</th>
						
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan="">Empresa</th>
						<th colspan="">Monto</th>
					</tr>
					<?php 
						
						
						foreach($salidas as $fila){
							$total_salidas+= $fila["egreso"] ;
						?>
						<tr>
							<td><?php echo $fila["nombre_empresas"] ?></td>
							<td class="text-right"><?php echo number_format($fila["egreso"]) ?></td>
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
						
						<td ><b><?php echo number_format($total_salidas)?></b></td>
					</tr>
				</tfoot>
			</table>
			
			
			<table class="table table-bordered table-condensed">
				<thead class="text-center">
					<tr>
						<th colspan="2">Traspasos de Utilidad</th>
						
					</tr>
				</thead>
				<tbody>
					<tr>
						<th colspan="">Empresa</th>
						<th colspan="">Monto</th>
					</tr>
					<?php 
						
						
						foreach($traspasos as $fila){
							$total_traspasos+= $fila["egreso"] ;
						?>
						<tr>
							<td><?php echo $fila["nombre_empresas"] ?></td>
							<td class="text-right"><?php echo number_format($fila["egreso"]) ?></td>
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
						
						<td ><b><?php echo number_format($total_traspasos)?></b></td>
					</tr>
				</tfoot>
			</table>
		</div>
		<?php
		}
		else{
			echo "<pre>".mysqli_error($link)."</pre>";
		}
	?>	
</div>

<hr>
<table class="table table-bordered table-condensed">
	
	<tbody>
		<tr>
			<td colspan="">Ingresos</td>
			<td colspan=""><?php echo number_format($total_abonos + $total_mutualidades + $total_recaudacion)?></b></td>
		</tr>
		<tr>
			<td colspan="">Egresos</td>
			<td colspan=""><?php echo number_format($total_traspasos + $total_salidas)?></b></td>
		</tr>
		<tr>
			<th colspan="">Total</th>
			<th colspan=""><?php echo number_format($total_abonos + $total_mutualidades + $total_recaudacion - $total_traspasos - $total_salidas )?></b></th>
		</tr>
		
	</tbody>
	
</table>




