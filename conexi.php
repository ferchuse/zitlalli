<?php
	
	function Conectarse()
	{
		
		$host="localhost";
		
		if($_SERVER["SERVER_NAME"] == "localhost"  || $_SERVER["SERVER_NAME"] == "192.168.1.88"){
			$db="zitlalli";
			$usuario="sistemas";
			$pass="Glifom3dia";
		}
		else{
			
			
			$db="zitlalli_zitlalli";
			$usuario="zitlalli_sistemas";
			$pass="Gl1fom3di@";
			
			
		}
		
		setlocale(LC_ALL,"es_ES");
		$set_local = "SET time_zone = '-05:00'";
		$set_names = "SET NAMES 'utf8'";
		date_default_timezone_set('America/Mexico_City');
		
		if (!($link=mysqli_connect($host,$usuario,$pass)))
		{
			die( "Error conectando a la base de datos.". mysqli_error($link));
		}
		
		if (!mysqli_select_db($link, $db))
		{
			die( "Error seleccionando la base de datos.". mysqli_error($link));
		}
		
		
		if($_SERVER["SERVER_NAME"] != "localhost") {
			
			mysqli_query($link, "SET sql_mode = ''") or die("Error Cambiando sqlmode").mysqli_error($link);
			// mysqli_query($link, "SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));") or die("Error Cambiando sqlmode").mysqli_error($link);
			
			
			mysqli_query($link, "SET CHARACTER SET utf8") or die("Error en charset UTF8".mysqli_error($link));
			mysqli_query($link, "SET session max_execution_time=300000") or die("Error enmax execution".mysqli_error($link));
		}
		
		
		return $link;
	}
?>