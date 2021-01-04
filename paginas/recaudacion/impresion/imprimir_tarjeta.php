<?php 
	include('../../../conexi.php');
	
	$link = Conectarse();
	$filas = array();
	
	
	
	$consulta = "SELECT * FROM tarjetas 
	
	LEFT JOIN derroteros USING(id_derroteros)
	LEFT JOIN empresas USING(id_empresas)
	LEFT JOIN conductores  USING(id_conductores)
	LEFT JOIN unidades USING(id_unidades)
	LEFT JOIN roles USING(id_roles)
	LEFT JOIN usuarios USING(id_usuarios)
	WHERE tarjeta= '{$_GET['id_registro']}'";
  
	
	$result = mysqli_query($link,$consulta);
	if($result){
		
		if( mysqli_num_rows($result) == 0){
			
			die("<div class='alert alert-danger'>Abono {$_GET['id_registro']} No encontrado</div>");
			
			
		}
		
		while($fila = mysqli_fetch_assoc($result)){
			
			$filas = $fila ;
			
		}
		
		
		
		$print = "@";
		$print.= "a".chr(0)."!".chr(176)."TARJETA"."!".chr(0)."\n a".chr(0);
		$print.= "E".chr(1)."FOLIO: E".chr(0).$filas["tarjeta"]."\n";
		$print.= "FECHA CUENTA: ".$filas["fecha_tarjetas"]."\n";
		$print.= "FECHA CAPTURA: ".$filas["fecha_creacion"]."\n";
		$print.= "FECHA IMPRESION: ".date("d-m-Y H:i:s")."\n";
		$print.= "USUARIO IMPRESION: ".$_COOKIE["nombre_usuarios"]."\n";
		$print.= "USUARIO: ".$filas["nombre_usuarios"]."\n";
		$print.= "EMPRESA: ".$filas["nombre_empresas"]."\n";
		$print.= "NUM ECO: ".$filas["num_eco"]."\n";
		$print.= "CONDUCTOR: ".$filas["nombre_conductores"]."\n";
		$print.= "DERROTERO: ".$filas["nombre_derroteros"]."\n";
		$print.= "ROL: ".$filas["nombre_roles"]."\n\n";
		$print.= "  ORIGEN ".chr(9).chr(9). "DESTINO \n";
		
		
		
		
		
		
		$q_roles = "SELECT
		*
		FROM
		roles_destinos
		LEFT JOIN origenes ON roles_destinos.origen = origenes.id_origenes
		LEFT JOIN (
		SELECT
		id_origenes AS id_destinos,
		nombre_origenes AS nombre_destinos
		FROM
		origenes
		) AS destinos ON roles_destinos.destino = destinos.id_destinos
		WHERE
		id_roles = {$filas['id_roles']}
		ORDER BY id_vueltas";
		
		$result_roles = mysqli_query($link, $q_roles);
		
		while($fila_roles= mysqli_fetch_assoc($result_roles)){
			
			if($_COOKIE["id_administrador"] != '1'){
				
				$print.= "____________".CHR(9).CHR(9);
			}
			else{
				$print.= $fila_roles["nombre_origenes"].CHR(9).CHR(9);
				
			}	
			if($_COOKIE["id_administrador"] != '1'){
				$print.= "_____________ \n\n\n";
			}
			else{
				$print.= $fila_roles["nombre_destinos"]."\n\n\n";
			}
			
			
		}
		
		//https://github.com/mike42/Auth/blob/master/lib/misc/ReceiptPrinter.php
		// https://github.com/mike42/escpos-php/blob/development/src/Mike42/Escpos/Printer.php
		
		$print.= "@";
		$print.= chr(29)."h".chr(80).chr(29)."H".chr(2).chr(29).chr(0);//Barcode Height and settings
		$print.= CHR(29) . 'k' . CHR(69).  chr(strlen($filas["tarjeta"])).$filas["tarjeta"]; //Barcode
		
		$print.= "\n\n\n";
		
		$print.=chr(10).chr(10).chr(13).chr(29).chr(86).chr(66).chr(0);
		
		/*
			
			escNewLine   = chr(10);  // New line (LF line feed)
			escUnerlineOn   = chr(27) + chr(45) + chr(1);  // Unerline On
			escUnerlineOnx2 = chr(27) + chr(45) + chr(2);  // Unerline On x 2
			escUnerlineOff  = chr(27) + chr(45) + chr(0);  // Unerline Off
			escBoldOn       = chr(27) + chr(69) + chr(1);  // Bold On
			escBoldOff      = chr(27) + chr(69) + chr(0);  // Bold Off
			escNegativeOn   = chr(29) + chr(66) + chr(1);  // White On Black On'
			escNegativeOff  = chr(29) + chr(66) + chr(0);  // White On Black Off
			esc8CpiOn       = chr(29) + chr(33) + chr(16); // Font Size x2 On
			esc8CpiOff      = chr(29) + chr(33) + chr(0);  // Font Size x2 Off
			esc16Cpi        = chr(27) + chr(77) + chr(48); // Font A  -  Normal Font
			esc20Cpi        = chr(27) + chr(77) + chr(49); // Font B - Small Font
			escReset        = chr(27) + chr(64); //chr(27) + chr(77) + chr(48); // Reset Printer
			escFeedAndCut   = chr(29) + chr(86) + chr(65); // Partial Cut and feed
			
			escAlignLeft    = chr(27) + chr(97) + chr(48); // Align Text to the Left
			escAlignCenter  = chr(27) + chr(97) + chr(49); // Align Text to the Center
			escAlignRight   = chr(27) + chr(97) + chr(50); // Align Text to the Right
		*/
		
		echo base64_encode($print);
		
	}
	else {
		echo "Error en ".$consulta.mysqli_Error($link);
		
	}
	
	
?>					