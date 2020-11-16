<?php 
	
	include('../../../conexi.php');
	include('../../../funciones/dame_permiso.php');
	$link = Conectarse();
	
	$consulta = "SELECT * FROM egresos_caja
	
	LEFT JOIN usuarios USING(id_usuarios) 
	
	
	";
	
	
	
	
	if($_GET["id_usuarios"] != ""){
		$consulta.=" WHERE id_usuarios = '{$_GET["id_usuarios"]}' ";
	}
	
	
	$result = mysqli_query($link,$consulta);
	
	if($result){
		$num_registros = mysqli_num_rows($result);
	?>
	<table class="table table-bordered" id="tabla_registros" width="100%" cellspacing="0">
		<thead>
			<tr>
				<th class="text-center"></th>
				<th class="text-center">Folio</th>
				<th class="text-center">Concepto</th>
				<th class="text-center">Importe</th>
				<th class="text-center">Usuario</th>
				
			</tr>
		</thead>
		<tbody >
			<?php
				while($fila = mysqli_fetch_assoc($result)){ 
					
					
				?>
				
				<tr>
					<td>
						<?php
							if($fila["estatus"] == "Cancelado"){
								echo "<span class='badge badge-danger'>Cancelado <br>{$fila["datos_cancelacion"]}</span>";
							}
							else{
								
								$total+= $fila["importe"];
								
								if(dame_permiso("egresos_caja.php", $link) == 'Supervisor'){
								?>
								<button class="btn btn-danger cancelar" title="Cancelar" data-id_registro='<?php echo $fila["id_vales"]?>'>
									<i class="fas fa-times"></i>
								</button>	
								<button class="btn btn-info imprimir" title="Imprimir" data-id_registro='<?php echo $fila["id_vales"]?>'>
									<i class="fas fa-print"></i>
								</button>	
								
								<?php 	
								}
							}
						?>
					</td>
					
					<td><?php echo $fila["id_vales"];?></td>
					<td><?php echo $fila["concepto"];?></td>
					<td>
						
						<?php echo $fila["estatus"] == "Cancelado" ? "" :"$".$fila["importe"];?>
						
						</td>
					<td><?php echo $fila["nombre_usuarios"];?></td>
					
					
					
					
				</tr>
				
				<?php 	
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td >
					<?php echo mysqli_num_rows($result);?> Registros.
				</td>
				<td ></td>
				<td ><B> Total </b></td>
				<td >
					$<?php echo number_format($total);?>.
				</td>
				<td ></td>
			</tr>
		</tfoot>
	</table>
	
	
	<?php
		
		
	}
	else {
		echo "Error en".$consulta. mysqli_error($link);
	}
	
	
?>					