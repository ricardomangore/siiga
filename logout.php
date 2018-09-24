<?php

	include("includes/Conectar.php");
	include("includes/Security.php");

	$Seguridad = new Security();

	$Seguridad->CerrarSesion();
	header("Location: index.php");
		
?>