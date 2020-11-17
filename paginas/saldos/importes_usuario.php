<?php
	include("../../paginas/login/login_check.php");
	include('../../conexi.php');
	$link = Conectarse();
	$nombre_pagina = "Importes por Usuario";
	include('../../funciones/generar_select.php');
	
	
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
		<div id="wrapper" class="">
			<?php include("../../menu.php")?>	
			<div id="content-wrapper">		
				<div class="container-fluid">		
					<!-- Breadcrumbs-->
					<ol class="breadcrumb d-print-none">
						<li class="breadcrumb-item">
							<a href="#">Recaudación</a>
						</li>
						<li class="breadcrumb-item active"><?php echo $nombre_pagina;?></li>
					</ol>
					<h3 class="d-none d-print-block">
						Importes Por Usuario
					</h3>
					<form id="form_filtro">
						<button type="submit" id="btn_fechas" class="btn btn-info btn-sm">
							<i class="fas fa-search"></i> Buscar
						</button>
						<div class="row" >
							<div class="col-sm-3" >
								<div class="form-group" >
									<label >Fecha Inicial:</label>
									<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" name="fecha_inicial" id="fecha_inicio">
								</div>
							</div>
							<div class="col-sm-3" >
								<div class="form-group ">
									<label for="">Fecha Final:</label>
									<input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" name="fecha_final" id="fecha_final">
								</div>
							</div>
							<div class="col-sm-3" >
								<div class="form-group">
									<label for="">Empresa:</label>
									<?= generar_select($link, "empresas", "id_empresas", "nombre_empresas", true)?>
									
								</div>
							</div>
						</div>
						<!--<div class="card-footer small text-muted">Ultima Modificación Ayer 12pm</div>
							
							
							<div class=" col-md-2 d-print-none">
							<button type="button" id="btn_imprimir" onclick="window.print();" title="Imprimir" class="btn btn-outline-primary mb-2"><i class="fas fa-print"></i></button>
							<button hidden type="button" id="btn_excel" title="Exportar a Excel" class="btn btn-outline-success mb-2"><i class="far fa-file-excel"></i></button>
							</div>
							
						-->
						
					</form>
					
					
					<div class="d-print-block" hidden id="formato_imprimir">
					</div>
					
					
					<div class="card mb-3" id="tableCard">
						<div class="card-header">
							<i class="fas fa-table"></i>
							Lista de <?php echo $nombre_pagina;?>
						</div>
						<div class="card-body">
							<div class="table-responsive" id="tabla_registros">
								
							</div>
						</div>
						
					</div>
				</div>
				<!-- /.container-fluid -->
				
				<!-- Sticky Footer -->
				<footer class="sticky-footer">
					<div class="container my-auto ">
						<div class="copyright text-center my-auto">
							<span class="d-print-none">Copyright © Glifo Media 2018</span>
						</div>
					</div>
				</footer>
			</div> 
			<!-- /.content-wrapper -->
		</div>
		<!-- /#wrapper -->
		
		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded d-print-none" href="#page-top">
			<i class="fas fa-angle-up"></i>
		</a>
		
		<script src="../../plugins/pos_print/websocket-printer.js" > </script>
		<div class="d-print-block p-2" hidden id="ticket">
		</div>
		<?php include("forms/form_vales.php")?>
		
		<?php include("../../scripts.php")?>
		<script >
			listarRegistros();
			
			$('#form_filtro').on('submit', function filtrar(event){
			event.preventDefault();
			
			listarRegistros();
			
			});
			
			var printService = new WebSocketPrinter();
			
			
			
			function imprimirTicket(){
			console.log("imprimirTicket()");
			
			
			return $.ajax({
			url: "impresion/imprimir_corte_usuario.php",
			data: $("#form_filtro").serialize()
			}).done(function (respuesta){
			
			$.ajax({
			url: "http://localhost/imprimir_zitlalli.php",
			method: "POST",
			data:{
			"texto" : respuesta
			}
			});
			
			printService.submit({
			'type': 'LABEL',
			'raw_content': respuesta
			});
			
			});
			}
			
			
			function listarRegistros(){
				console.log("listarRegistros()");
				$("#tabla_registros").html("<h3 class='text-center'>Cargando <i class='fas fa-spinner fa-spin'></i></h3>")
				let form = $("#form_filtro");
				let boton = form.find(":submit");
				let icono = boton.find('.fas');
				
				boton.prop('disabled',true);
				icono.toggleClass('fa-save fa-spinner fa-pulse ');
				
				return $.ajax({
					url: 'control/lista_importes_usuario.php',
					data: $("#form_filtro").serialize()
					}).done(function(respuesta){
					
					$("#tabla_registros").html(respuesta)
					// $("#dataTable").dataTable();
					$(".imprimir").click(imprimirTicket);
					// $(".imprimir").click(imprimirTicket);
					// $(".cancelar").click(confirmaCancelacion);
					
					
					}).always(function(){
					
					boton.prop('disabled',false);
					icono.toggleClass('fa-save fa-spinner fa-pulse fa-fw');
					
				});
				
			}
			
		</script>
		
	</body>
</html>						