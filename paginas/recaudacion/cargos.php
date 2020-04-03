<?php
	$nombre_pagina = "Cargos a Unidades";
	$id= "id_cargos";
	$tabla = "cargos_unidades";
	
	include("../../conexi.php");
	include("../../funciones/generar_select.php");
	include("../../paginas/login/login_check.php");
	$link = Conectarse();
?>

<!DOCTYPE html>
<html lang="en">
	
  <head>
		
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
		
    <title>Cargos a Unidades</title>
		<?php include("../../styles.php")?>
	</head>
	
  <body id="page-top">
		
    <?php include("../../navbar.php")?>
		
		
    <div id="wrapper" class="d-print-none">
			
      <!-- Sidebar -->
      <?php include("../../menu.php")?>
			
      <div id="content-wrapper">
				
        <div class="container-fluid">
					
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Recaudación</a>
						</li> 
            <li class="breadcrumb-item active">Cargos a Unidades</li>
					</ol>
					
					
					
					<!--Form Filtro !-->
					<form id="form_filtro" autocomplete="off">
						<div class="row mb-2">
							<div class="col-12">
								<div class="col-12 mb-3">
									<button class="btn btn-primary btn-sm" >
										<i class="fas fa-search"></i> Buscar
									</button>
								</div>
								
							</div>
						</div>
						
						<div class="row mb-1">
							<div class="col-1">
								<label for="nombre_condonaciones">Mes:</label>
							</div>
							<div class="col-2">			
								<select class="form-control" name="mes_cargos">
									<option <?= date("Ym") == "202012" ? "selected" : ""?> value="202012">2020-12 </option>
									<option <?= date("Ym") == "202011" ? "selected" : ""?> value="202011">2020-11 </option>
									<option <?= date("Ym") == "202010" ? "selected" : ""?> value="202010">2020-10 </option>
									<option <?= date("Ym") == "202009" ? "selected" : ""?> value="202009">2020-09 </option>
									<option <?= date("Ym") == "202008" ? "selected" : ""?> value="202008">2020-08 </option>
									<option <?= date("Ym") == "202007" ? "selected" : ""?> value="202007">2020-07 </option>
									<option <?= date("Ym") == "202006" ? "selected" : ""?> value="202006">2020-06 </option>
									<option <?= date("Ym") == "202005" ? "selected" : ""?> value="202005">2020-05 </option>
									<option <?= date("Ym") == "202004" ? "selected" : ""?> value="202004">2020-04 </option>
									
								</select>
							</div> 
							<div class="col-1">
								<label for="nombre_condonaciones">Estatus:</label>
							</div>
							<div class="col-2">			
								<select class="form-control" name="estatus_unidades">
									<option value="">Todos</option>
									<option value="Alta">Alta </option>
									<option value="Baja">Baja </option>
									<option value="Inactivo">Inactivo </option>
								</select>
							</div>  
						</div>
						<div class="row mb-1"> 
							<div class="col-1">
								<label for="nombre_condonaciones">Num Eco:</label>
							</div>	
							<div class="col-2">			
								<input class="form-control" type="text" name="num_eco" id="num_eco" >
							</div> 
							<div class="col-1">
								<label >Empresa:</label>
							</div>	
							<div class="col-2">			
								<?php echo generar_select($link, "empresas", "id_empresas", "nombre_empresas", true)?>
							</div> 
						</div>
					</form>
					<hr>
					
					<hr>
					<div class="card card-primary mb-3" >
						<div class="card-header bg-info">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								<h4 class="text-center">
									Cargando...	
								</h4>
							</div>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
				
				<!-- Sticky Footer -->
				<footer class="sticky-footer">
					<div class="container my-auto">
						<div class="copyright text-center my-auto">
							<span>Copyright © Glifo Media 2018</span>
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
		
		<div class="d-print-block p-2 " hidden id="ticket" >
		</div>
		
		
		<?php include("../../scripts.php")?>
		<script src="js/cargos_unidades.js"></script>
	</body>
	
</html>																																		