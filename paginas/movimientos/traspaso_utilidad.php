<?php
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Traspaso de Utilidad";
	include('../../funciones/generar_select.php');
	include("../../paginas/login/login_check.php");
?>


<!DOCTYPE html>
<html lang="es_mx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title><?php echo $nombre_pagina;?></title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
		<?php include("../../navbar.php")?>
		<div id="wrapper" class="d-print-none">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Movimientos</a> 
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina; ?></li>
					</ol>
					
					<form id="form_filtro" autocomplete="off">
						<div class="col-12 mb-3">
							<button  type="submit" id="btn_buscar"  class="btn btn-primary" >
								<i class="fas fa-search"></i> Buscar
							</button> 
							<button type="button" class="btn btn-success" id="nuevo">
								<i class="fas fa-plus"></i> Nuevo
							</button>
						</div>
						<div class="row"> 
							<div class="col-sm-2">
								<label >Fecha Inicial:</label>
								<input class="form-control" name="fecha_inicial" type="date" id="fecha_inicial" value="<?php echo date("Y-m-d")?>">
							</div>
							<div class="col-sm-2">
								<label >Fecha Final:</label>
								<input class="form-control" name="fecha_final" type="date" id="fecha_final" value="<?php echo date("Y-m-d")?>">
							</div>
							<div class="col-sm-2">
								<label >Num Eco:</label>
								<input class="form-control" name="num_eco" type="text" >
							</div>
							<div class="col-sm-2">
								<label>Año Aplicación:</label>
								<select class="form-control filtro" id="year" name="year" >
									<option <?= date("Y") == "2020" ? "selected": "";?> value="2020">2020</option>
									<option <?= date("Y") == "2021" ? "selected": "";?> value="2021">2021</option>
									<option <?= date("Y") == "2022" ? "selected": "";?> value="2022">2022</option>
									<option <?= date("Y") == "2023" ? "selected": "";?> value="2023">2023</option>
								</select>
							</div>
							<div class="col-sm-2">
								<label>Mes Aplicación:</label>
								<select class="form-control filtro" id="mes" name="mes" >
									<option value="">Todos</option>
									<option <?= date("n") == "1" ? "selected": "";?> value="1">Enero</option>
									<option <?= date("n") == "2" ? "selected": "";?> value="2">Febrero</option>
									<option <?= date("n") == "3" ? "selected": "";?> value="3">Marzo</option>
									<option <?= date("n") == "4" ? "selected": "";?> value="4">Abril</option>
									<option <?= date("n") == "5" ? "selected": "";?> value="5">Mayo</option>
									<option <?= date("n") == "6" ? "selected": "";?> value="6">Junio</option>
									<option <?= date("n") == "7" ? "selected": "";?> value="7">Julio</option>
									<option <?= date("n") == "8" ? "selected": "";?> value="8">Agosto</option>
									<option <?= date("n") == "9" ? "selected": "";?> value="9">Septiembre</option>
									<option <?= date("n") == "10" ? "selected": "";?> value="10">Octubre</option>
									<option <?= date("n") == "11" ? "selected": "";?> value="11">Noviembre</option>
									<option <?= date("n") == "12" ? "selected": "";?> value="12">Diciembre</option>
									
								</select>
							</div>
						</div>	
						
					</form>
					<hr>
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina; ?>
						</div>
						<div class="card-body">
							
							<div class="table-responsive">
								<table class="table table-bordered" id="tabla_registros" width="100%" cellspacing="0" >
									<thead>
										<tr>
											<th class="text-center">Acciones</th>
											<th class="text-center">Folio</th>
											<th class="text-center">Fecha</th>
											<th class="text-center">Fecha Aplicación</th>
											<th class="text-center">Beneficiario</th>
											<th class="text-center">Concepto</th>
											<th class="text-center">Monto</th>
											<th class="text-center">Estatus</th>
											<th class="text-center">Usuario</th>
										</tr>
									</thead>
									
									<tbody id="containerLista">
										<tr>
											<td colspan="8"><h3 class="text-center">Cargando...</h3></td>
										</tr>
									</tbody>
								</table>
								<div id="mensaje"></div>
							</div>
						</div>
						
					</div>
				</div>
				<!-- /.container-fluid -->
				
				<!-- Sticky Footer -->
				<footer class="sticky-footer">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright  Glifo Media 2018</span>
						</div>
					</div>
				</footer>
				
			</div>
			<!-- /.content-wrapper -->
		</div>
		<!-- /#wrapper -->
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>	
		<div class="d-print-inline d-none p-2 carta"   id="impresion">
			
		</div>
		
		<?php 
			include("../../scripts.php");
			include('forms/forms_traspaso.php');
		?>
		<script src="js/traspaso_utilidad.js?v=<?php echo date('Y-m-d-H:i:s');?>"></script>
		<script src="../catalogos/js/buscar.js"></script>
	</body>
</html>
