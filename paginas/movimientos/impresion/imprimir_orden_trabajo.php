<?php 
	
	include('../../../conexi.php');
	$link = Conectarse();
	$filas = array();
	
	
	
	$consulta = "SELECT * FROM ordenes_trabajo 
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN beneficiarios USING(id_beneficiarios) 
	LEFT JOIN motivos_salida USING(id_motivosSalida) 
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE id_reciboSalidas= '{$_GET['id_registro']}'";
	
	
	$result = mysqli_query($link,$consulta); 
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Tarjeta No encontrada</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
	}
	
?> 




<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		
		<title>Formato</title>
	</head>
	<body>
		
		
		<div class="container"> 
			
			<?php 
				
				for($i=1; $i< 3; $i++){
				?>
				<div class="media_carta">   
					
					<div class="row">
						<div class="col-2 text-center" >
							<img  src="../../../img/logo.jpg" class="img-fluid">
						</div>
						<div class="col-8 text-center">
							<h4> GRUPO AAZ </h4>
							<legend>ORDEN DE TRABAJO</legend> 
						</div>
						<div class="col-2 text-center" >
							<img  src="../../../img/logo.jpg" class="img-fluid">
							<label>FOLIO</label>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">VÁLIDA POR <u><?= $fila["dias"]?> </u> DIAS</div>
						<div class="col-sm-4">A PARTIR DEL DIA <u><?= $fila["fecha_inicial"]?></u> </div>
						<div class="col-sm-4">AL DIA <u><?= $fila["fecha_Ffinal"]?></u> </div>
					</div>
					<div class="row">
						<div class="col-sm-4">ECO <u><?= $fila["num_eco"]?></u></div>
						<div class="col-sm-2">PLANTA (<?= $fila["fecha_inicial"]?>)  POSTURA (<?= $fila["fecha_inicial"]?>) </div>
						<div class="col-sm-2">DERROTERO <u><?= $fila["nombre_derroteros"]?></u> </div>
					</div>
					<div class="row">
						<div class="col-sm-12">NOMBRE DEL OPERADOR <u><?= $fila["nombre_operadores"]?> </u></div>
					</div>
					
					<div class="row">
						<div class="col-sm-6">LICENCIA TIPO FEDERAL(<?= $fila["fecha_inicial"]?>)  POSTURA (<?= $fila["fecha_inicial"]?>) </div>
						<div class="col-sm-4">VENCIMIENTO DE LA LICENCIA <?= $fila["vencimiento_licencia"]?> </div>
					</div>
					
					
					
					<section >
						<p>Reporte de motivos de</p>
						<div class="row">
							<div class="col-sm-3">
								<input type="checkbox" value="">PERDIDA DE VIAJE 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">FALTA DE UNIFORME 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">FALLAS MECANICAS 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">FUERA DE RUTA
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<input type="checkbox" value="">PIRATAJE 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">EXCESO DE VELOCIDAD 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">DEJO PASAJE 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">CHOQUE
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<input type="checkbox" value="">ACCIDENTE
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">ABANDONO DE UNIDAD 
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">LLEVA ACOMPAÑANTE
							</div>
							<div class="col-sm-3">
								<input type="checkbox" value="">SIN TARJETA  AL DIA
							</div>
							
						</div>
						
						
						<label for="comment">DESCRIPCION DE LOS HECHOS:</label>
						<textarea class="form-control" rows="3" id="comment"></textarea>
						
						
					</section>
					
					<br>
					<br>
					<br>
					
					<div class="row text-center">
						<div class="col-sm-4 border-top px-2">
							FRIMA DEL TITULAR
						</div>
						<div class="col-sm-4 border-top px-2">
							JEFE DE PERSONAL
						</div>
						<div class="col-sm-4 border-top px-2">
							FIRMA OPERADOR
						</div>
					</div>
					<hr>
				</div>
				
				
				<?php 
					
				}
			?>
			
		</div>
		
		
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	</body>
</html>																															