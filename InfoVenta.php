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
	$Folio=$_GET['id'];	
	$q1="SELECT DISTINCT Opc FROM LineaTemporalOpc1 WHERE Folio='$Folio'";
	$resultado=$Herramientas->Consulta($q1);
	$opc=mysql_fetch_row($resultado);
	if($opc[0]==1){
		$FamiliaPlanId=1;
	}elseif($opc[0]==2){
		$FamiliaPlanId=3;
	}elseif ($opc[0]==3) {
		$FamiliaPlanId=4;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/styleVentana.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />

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
		<div align="center">
		<h2>Informaci&oacute;n de venta</h2>

		
		</div>
		<?php
			$HerramientasHtml->drawTablaFolioTemporal($Folio);
		?>
		<fieldset>
			<legend>Informaci&oacute;n de Lineas</legend>


			
			
			<?php
				if($FamiliaPlanId==1 || $FamiliaPlanId==2 || $FamiliaPlanId==5 || $FamiliaPlanId==7 || $FamiliaPlanId==8){
					$HerramientasHtml->drawTablaFinVenta1($Folio);	
				}elseif($FamiliaPlanId==3 || $FamiliaPlanId==6){
					$HerramientasHtml->drawTablaFinVenta2($Folio);
				}elseif($FamiliaPlanId==4) {
					$HerramientasHtml->drawTablaFinVenta3($Folio);
				}			
			?>
			<br>
			<div align="right">
				<button class="borrar" onclick="javascript:window.close();">Cerrar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div id="dvData">
			</div>
			
		</fieldset>
	
    <!-- Librería jQuery requerida por los plugins de JavaScript -->

</body>
</html>