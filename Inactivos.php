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

	$ModuloId=40;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">

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
		</form>	
	</div>

	<div id="Activa" class="dialogo" title="Reingreso de Personal" >	
		<br>			
			
			<label for="ClasificacionPersonalVentaId"><span class="importante">*</span>Clasificacion Venta:</label>
							<select name="ClasificacionPersonalVentaId" id="ClasificacionPersonalVentaId">
							<option value="0">Elige</option>
					<?php
							$Herramientas->Scroll('ClasificacionPersonalVenta','ClasificacionPersonalVentaId','ClasificacionPersonalVenta',0, 'Activo=1', 'ClasificacionPersonalVenta');
					?>
						</select>
						<br>

			<label for="FechaIngreso"><span class="importante">*</span>Fecha de Alta:</label>
					<input type="text" id="FechaIngreso" name="FechaIngreso" readonly="readonly">
			<br>						

			<label for="PuestoId"><span class="importante">*</span>Puesto:</label>
				<select name="PuestoId" id="PuestoId">
				<option value="0">Elige</option>
				<?php
					$Herramientas->Scroll('Puestos','PuestoId','Puesto', 0, 'ACTIVO=1', 'Puesto');
				?>
				</select>
			<br>
				<label for="SubCategoriaId"><span class="importante">*</span>Sub Categorias:</label>
						<select name="SubCategoriaId" id="SubCategoriaId" '.$Lectura.'>
								<option value="0">Elige</option>
				<?php
								$Herramientas->Scroll('SubCategorias','SubCategoriaId','SubCategoria',$SubCategoriaId, 'Activo=1', 'SubCategoria');
				?>
						</select>
						<br>
					
						<label for="Operador"><span class="importante">*</span>Operador:</label>
						<input type="text" id="Operador" name="Operador" maxlength="2" >
					<br>
						<label for="Porcentaje"><span class="importante">*</span>Porcentaje:</label>
						<input type="text" id="Porcentaje" name="Porcentaje" maxlength="4" >
					<br>
							
			
			
			<br><br>
			<div align="right">
					<input type="button" class="baja" id="Reingresar" name="Reingresar" value="Reingresar" onclick="reingresaPersonal()">
			</div>
	</div>

</body>
</html>
