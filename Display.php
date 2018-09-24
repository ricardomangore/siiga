<?php
	include("includes/Conectar.php");	
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);


    clearstatcache();
	switch ($_REQUEST['opc']) 
	{
		case '0':
			$HerramientasHtml->displayFormulario($_GET['modulo']);
		break;
		case '1':
			$HerramientasHtml->displayLista($_GET['modulo']);
		break;			
		case '2':			
			$HerramientasHtml->displayFormularioEdit($_GET['modulo'], $_GET['ObjetoId']);
		break;
		case '3':			
			$HerramientasHtml->displayAsistenteTemplate($_REQUEST['DatoId']);
		break;
		case '4':
			$HerramientasHtml->displayAsistenteImporta($_REQUEST['DatoId']);
		break;
		case '5':
			$HerramientasHtml->displayAvisos($_REQUEST['DatoId']);
		break;
	}
	
?>