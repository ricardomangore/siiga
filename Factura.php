<?php
header('Content-Type: text/txt; charset=ISO-8859-1');

	include("includes/Conectar.php");	
	include("includes/Security.php");
	//include("includes/Tools.php");	
	include("includes/ToolsFacturas.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	
	//$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasFacturas = new ToolsFacturas($_SESSION['UsuarioId']);

         echo $HerramientasFacturas->GuardaVenta($_POST['PuntoVentaId'], $_POST['VendedorId'], $_POST['CoordinadorId'], $_POST['ClienteId'],$_POST['Comentario'],$_POST['Clave']); 
?>