<?php
header("Expires: Tue, 22 Jul 2014 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");
	include("includes/Menu.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	
	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);	

	$ModuloId=10;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
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
	<?php $Menu->displayMenu(); ?>
	<div id="Contenido">
		<?php
			$HerramientasHtml->displayHeaderModulo($ModuloId);
		?>

		<div id="Sesion">
			<form id="foox" />
			<strong>
				Sesion: <?php echo $_SESSION['Empleado']; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="img/Out.png" id="out" title="Salir" onclick="CerrarSesion();" />
				<a href="MiSitio.php"><img src="img/MiSitio.png" id="out" title="Mi Sitio" /></a>
			</strong>
			</form>
			<form id="logout" name="logout" method="post" action="logout.php" /></form>
		</div>

		<form id="foo" name="foo" method="post" >
		<?php				
			$HerramientasHtml->DisplayControles($ModuloId);
			?>
			<br>
			<div align="center" id="resultados"></div>
			<div id="display" name="display">
			<?php
				$HerramientasHtml->displayLista($ModuloId);
			?>
			</div>

		<div id="Baja" class="dialogo" title="Baja de Personal" >	
		<br>
			<span id="ObjetoBaja"></span>
			<br><br><br>
			<div class="Izquierda">
			<label for="CausaBajaId"><span class="importante">*</span>Causa de baja:</label>
				<select name="CausaBajaId" id="CausaBajaId">
				<option value="0">Elige</option>
				<?php
					$Herramientas->Scroll('CausasBaja','CausaBajaId','CausaBaja', 0, 'ACTIVO=1', 'CausaBaja');
				?>
				</select>
			<br><br>
			<label for="FechaContrato"><span class="importante">*</span>Fecha de Baja:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly">
					<br>						
			</div>
			<div class="Derecha">
				<div id="avisoVentana"></div>				
			</div>
			<div class="Derecha" align="right" >
			<br><br><br><br>
					<input type="button" class="baja" id="Actualiza" name="Actualiza" value="Baja" onclick="bajaPersonal()">
			</div>
		</div>

		</form>	
	</div>

</body>
</html>
