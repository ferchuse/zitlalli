<?php 
	session_start();
	require('../../../conexi.php');
	
	$link = Conectarse();
	$filas = array();
	
	
	$consulta = "SELECT * FROM unidades 
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN derroteros USING(id_derroteros)
	WHERE serie= '{$_GET['serie']}'";
	
	
	$result = mysqli_query($link,$consulta); 
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$conductor = $fila ;
			
		}
		
	?> 
	
	<DOCTYPE html>
		<html lang="es_mx">
			<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<meta name="description" content="">
				<meta name="author" content="">
				<title>Hoja de Datos</title>
        <?php include('../../../styles.php')?>
			</head>
			<body id="page-top">
				
				
				<div id="content-wrapper">		
					<div class="container">		
						
						<div class="media_carta">
							<div class="row">
								<div class="col-2 text-center" >
									<img  src="../../../img/logo.jpg" class="img-fluid">
								</div>
								<div class="col-10 text-center">
									<h4>Coordinadora de Transporte Grupo AAZ AC</h4>
									<legend>Hoja de Datos</legend> 
								</div>
							</div>
							
							
							<div class="row">
								<div class="col-6 " >
									
									<div class="row mb-2">
										<div class="col-2">
											<label >Empresa:</label>
										</div>	 
										<div class="col-5">			
											<?php
												echo generar_select($link, "empresas", "id_empresas", "nombre_empresas");
											?>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label >No Eco:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="number" name="num_eco" id="num_eco" required>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label >Propietario:</label>
										</div>	
										<div class="col-5">			
											<?php
												echo generar_select($link, "propietarios", "id_propietarios", "nombre_propietarios");
											?>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="fecha_ingreso">Fecha de Ingreso:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="date" name="fecha_ingreso" id="fecha_ingreso" value="<?php echo date("Y-m-d");?>">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="censo">Concesion:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="number" name="censo" id="censo">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label >Tipo Vehículo:</label>
										</div>	
										<div class="col-5">			
											<select class="form-control" id="tipo_unidad" name="tipo_unidad">
												<option value="">Seleccione</option>
												<option value="Autobús">Autobús</option>
												<option value="Camioneta">Camioneta</option>
												<option value="Sprinter">Sprinter</option>
											</select>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label >Estatus:</label>
										</div>	
										<div class="col-5">			
											<select class="form-control" id="estatus_unidades" name="estatus_unidades">
												<option value="">Seleccione</option>
												<option value="Alta">Alta</option>
												<option value="Baja">Baja</option>
												<option value="Inactivo">Inactivo</option>
											</select>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label >Derrotero:</label>
										</div>	
										<div class="col-5">			
											<?php
												echo generar_select($link, "derroteros", "id_derroteros", "nombre_derroteros");
											?>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Motor:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="text" name="serie" id="serie">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Modelo:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="text" name="modelo" id="modelo">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Poliza:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="text" name="poliza" id="poliza" required>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Aseguradora:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="text" name="aseguradora" id="aseguradora">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Vigencia:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="date" name="vigencia" id="vigencia">
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-2">
											<label for="nombre_propietario">Mutualidad:</label>
										</div>	
										<div class="col-5">			
											<input class="form-control" type="number" name="mutualidad" id="mutualidad">
										</div>
									</div>
									
									<div class="row mb-2">
										<div class="col-2">
											<label for="saldo_unidades">Saldo Inicial:</label> 
										</div>	
										<div class="col-5">			
											<input class="form-control" type="number"  name="saldo_unidades" id="saldo_unidades" value="0">
										</div>
									</div>
								</div>
								<div class="col-6 text-center">
									
									Fecha de Impresión: <?php echo date("d/m/Y H:i:s");?><br>
								</div>
								</div> 
							</div> 
						</div> 
					</div> 
				</div> 
				
				<?php include("../../scripts.php")?>
				<script src="js/orden_trabajo.js"></script>
				<script src="js/buscar.js"></script>
			</body>
		</html>	
		
		
		<?php    
		}
		else {
			echo "Error en ".$consulta.mysqli_Error($link);
			
		}
		
		
	?>																																																		