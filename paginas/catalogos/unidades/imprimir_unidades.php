<?php 
	session_start();
	require('../../../conexi.php');
	
	$link = Conectarse();
	$filas = array();
	
	
	$consulta = "SELECT * FROM conductores 
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN derroteros USING(id_derroteros)
	WHERE id_conductores= '{$_GET['id_registro']}'";
	
	
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
									<div class="form-group">
										<label for="nombre_conductores">NOMBRE</label>
										<input class="form-control" value="<?= $conductor["nombre_conductores"]?>" readonly>
										
									</div>
									<div class="form-group">
										<label for="rfc_conductores">RFC</label>
										<input class="form-control" value="<?= $conductor["rfc_conductores"]?>" readonly>
										
									</div> 
									<div class="form-group">
										<label for="tipo_licencia">TIPO LICENCIA</label>
										<input class="form-control" value="<?= $conductor["tipo_licencia"]?>" readonly>
										
									</div>
									<div class="form-group">
										<label for="noLicencia_conductores">LICENCIA</label>
										<input class="form-control" value="<?= $conductor["noLicencia_conductores"]?>" readonly>
									</div>
									<div class="form-group">
										<label for="fechaVigencia_conductores">FECHA DE VIGENCIA</label>
										<input type="date" class="form-control" value="<?= $conductor["fechaVigencia_conductores"]?>" >
									</div> 
									<div class="form-group">
										<label for="id_empresas">EMPRESA</label>
										<input class="form-control" value="<?= $conductor["nombre_empresas"]?>" readonly>
									</div> 
									<div class="form-group">
										<label for="id_derroteros">DERROTERO</label>
										<input class="form-control" value="<?= $conductor["nombre_derroteros"]?>" readonly>
									</div> 
									<div class="form-group">
										<label for="curp_conductores">CURP</label>
										<input class="form-control" value="<?= $conductor["curp_conductores"]?>" readonly>
									</div> 
									<div class="form-group">
										<label for="acta_conductores">ACTA DE NACIMIENTO</label>
										<input class="form-control" value="<?= $conductor["acta_conductores"]?>" readonly>
									</div> 
									<div class="form-group">	
										<label for="estatus_conductores">Estatus</label>
											<input class="form-control" value="<?= $conductor["estatus_conductores"]?>" readonly>
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