<?php 
	session_start();
	// require('../../../conexi.php');
	
	// $link = Conectarse();
	// $filas = array();
	
	
	// $consulta = "SELECT * FROM conductores 
	// LEFT JOIN empresas USING(id_empresas)
	// LEFT JOIN derroteros USING(id_derroteros)
	// WHERE id_conductores= '{$_GET['id_registro']}'";
	
	
	// $result = mysqli_query($link,$consulta); 
	// if($result){
	
	// if( mysqli_num_rows($result) == 0){
	
	// die("<div class='alert alert-danger'>No encontrada</div>");
	
	
	// }
	
	// while($fila = mysqli_fetch_assoc($result)){
	
	// $conductor = $fila ;
	
	// }
	
	
	
?> 

<!DOCTYPE html>
<html lang="es_mx">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>QR</title>
		<?php include('../../../styles.php')?>
	</head>
	<body id="page-top">
		
		
		<div id="content-wrapper">		
			<div class="container text-center mt-5">		
				
				<hr>
				<input type="hidden" id="qr_text" value="<?= $_GET["serie"]?>">
				<div id="qrcodeCanvas"></div>
				
			</div> 
		</div> 
		
		<?php include("../../../scripts.php")?>
		<script type="text/javascript" src="../../../plugins/qr_code/jquery-qrcode-0.17.0.min.js"></script>
		<script>
			
			$('#qrcodeCanvas').qrcode({
			render	: "canvas",	
			text	: "https://zitlalli.com/paginas/catalogos/unidades/detalles_unidad.php?serie="+$("#qr_text").val()
			});	
		</script>
	</body>
</html>	


