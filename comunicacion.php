<?php

	include("includes/Conectar.php");
	include("includes/Tools.php");

	$Herramientas= new Tools($_SESSION[1]);

	$Q0="SELECT FamiliaId, Familia FROM Familias LIMIT 3";
	$R0=$Herramientas->Consulta($Q0);
	print_r($R0);
	echo json_encode();


?>

