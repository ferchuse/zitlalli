<?php 
	session_start();
	include('../../../conexi.php');
	include('../../../funciones/generar_select.php');
	include('../../../funciones/dame_permiso.php');
	$link = Conectarse();
	$filas = array();
	$respuesta = array();
	
	
	$consulta = "##Importes por Usuario
	SELECT
	*
	FROM
	desglose_dinero
	
	LEFT JOIN empresas USING (id_empresas)
	LEFT JOIN usuarios USING (id_usuarios)
	
	WHERE 
	usuarios.id_administrador = '{$_COOKIE["id_administrador"]}'
	AND DATE(fecha_desglose) BETWEEN '{$_GET["fecha_inicial"]}'
	AND '{$_GET["fecha_final"]}'
	";
	
	IF($_GET["id_usuarios"] != ""){
		
		$consulta.=" AND id_usuarios = '{$_GET["id_usuarios"]}'";
		
	}
	
	IF($_GET["id_empresas"] != ""){
		
		$consulta.=" AND id_empresas = '{$_GET["id_empresas"]}'";
		
	}
	
	
	$result = mysqli_query($link,$consulta);
	
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			die("<div class='alert alert-danger'>No hay registros </div>");
			
		}
		
		
		
	?>  
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>Imprimir</th>
				<th>Folio</th>
				<th>Empresa</th>
				<th>Usuario</th>
				<th>Fecha</th>
				<th>Importe</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				
				while($fila = mysqli_fetch_assoc($result)){
					
					
					
					
				?>
				
				<tr>
					<td class="text-center d-print-none">
						
						<?php 
							
							if($fila["estatus_desglose"] == 'Activo'){
								
								
								$totales[0]+= $fila["importe_desglose"];
								
								if(dame_permiso("desglose_dinero.php", $link) == 'Supervisor'){
								?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila['id_desglose']?>'>
									<i class="fas fa-times"></i>
								</button>
								
								<?php
								}
							?>
							<button class="btn btn-outline-primary imprimir " title="Imprimir" data-id_registro='<?= $fila["id_desglose"]?>'>
								<i class="fas fa-print"></i>
							</button>
							
							
							
							
							<?php 
							}
							else{
								
								echo "<span class='badge badge-danger'>Cancelado {$fila["datos_cancelacion"]}</span>";
							}
							
							
						?>
					</td>
					<td class="text-center"><?= $fila["id_desglose"]?></td>
					<td class="text-center"><?= $fila["nombre_empresas"]?></td>
					<td class="text-center"><?= $fila["nombre_usuarios"]?></td>
					<td class="text-center"><?= $fila["fecha_desglose"]?></td>
					<td class="text-center">$ <?= number_format($fila["importe_desglose"])?></td>
				</tr>
				
				<?php
				}
			?>
			
			
		</tbody>
		<tfoot>
			<tr class="h5">
				<td colspan="5" ><b> <?= mysqli_num_rows($result);?> Registro(s)</b></td>
				
				<td  class="text-center"><b>$ <?php echo number_format($totales[0])?></b></td>
			</tr>
		</tfoot>
	</table>
	
	<pre hidden>
		<?php echo $consulta;?>
	</pre>
	<?php
		
	}
	
	else {
		echo "<pre>Error en ".$consulta.mysqli_Error($link)."</pre>";
		
	}
?>
