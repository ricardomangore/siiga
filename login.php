<?php

	include("includes/Conectar.php");
	include("includes/Security.php");

	$Seguridad = new Security();

	if($Seguridad->CreaSesion($_POST['nip'], $_POST['pwd']))
		header("Location: sistema.php");
	else
		{
			
			header("Location: index.php?Error=7206");
		}
		
?>