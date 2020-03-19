<?php
  include("../login/login_check.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Catálogo de Propietarios</title>
		<?php include('../../styles.php')?>
	</head>
	<body id="page-top">
    <?php include("../../navbar.php")?>
    <div id="wrapper">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
          <!-- Breadcrumbs-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="#">Catálogos</a>
						</li>
						<li class="breadcrumb-item active">Propietarios</li>
					</ol>
					<div class="row mb-2">
						<div class="col-3">
							<button type="button" id="btn_modal" class="btn btn-success" > <i class="fas fa-plus"></i> Nuevo</button>
						</div>
					</div>	
					<div class="card mb-3">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de Propietarios
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th class="text-center">Id </th>
											<th class="text-center">Nombre</th>
											<th></th>
										</tr>
										<tr>
											<th></th>
											<th class="text-center">
												<input id="buscar_nombre" type="text" class="form-control" data-indice="1" placeholder="Buscar nombre de propietario">
											</th>
											<th></th>
										</tr>
									</thead>
									<tbody id="tabla_DB">
										<tr>
											<td colspan="3"><h3 class="text-center">Cargando...</h3></td>
										</tr>
									</tbody>
								</table>
								<div class="mensaje"></div>
							</div>
						</div>
						<div class="card-footer small text-muted">Ultima Modificación Ayer 12pm</div>
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
    <?php include("../../scripts.php")?>
    <?php include("forms/form_propietarios.php")?>
    <script src="js/propietarios.js"></script>
    <script src="js/buscar.js"></script>
	</body>
</html>
