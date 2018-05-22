<?php
	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");
	include("includes/Menu.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	date_default_timezone_set('Mexico/General');
	
	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);	
	
	$Folio='';
	$Movimiento='';

	$Folio=$_POST['MiFolio'];	
	$Movimiento=$_POST['Movimiento'];
	if($Folio==''){
		$Folio=$_GET['id1'];
		$Movimiento=$_GET['id2'];
	}

	$queryTotal="SELECT Aux FROM LineaTemporalOpc1 WHERE Folio='$Folio' AND Aux=1";
	$resultadoTotal=$Herramientas->Consulta($queryTotal);
	$totalTemporal=mysql_num_rows($resultadoTotal);
	if($totalTemporal>0){
		echo "<script>alert('Ya se ha cerrado este folio');</script>";
		echo "<script>window.close();</script>";  
	}







	$PlataformaId=$Herramientas->getPlataformaFolio($Folio);
	$Herramientas->eliminaLineaTemporal($Folio);











?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/styleVentana.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.1.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/combos.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript" src="js/sortedtable.js"></script>

</head>
</head>
<body>
<h4 class="migas"><span class="blue">1</span>Selecciona la familia del plan</h4>
	<div align="center">
	
		<?php
			$HerramientasHtml->displayFamiliasPlanes($Folio,$Movimiento,$PlataformaId);
		?>
	</div>	
	

</body>
</html>