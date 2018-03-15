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
	$Clave=$_SESSION['UsuarioId'].date("dmyHis");

	$ModuloId=29;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
			<input type="hidden" name="Clave" id="Clave" value="<?php echo $Clave; ?>" />
			<?php
				$HerramientasHtml->displayFormulario($ModuloId);
			?>
			</div>					

		<div id="ConceptoTR" class="dialogo" title="Consepto de Traspaso" >	
		<br>
			<span id="ObjetoBaja"></span>
			<br>

			<label for="ConceptoTRId"><span class="importante">*</span>Elegir concepto de traspaso:</label>
				<select name="ConceptoTRId" id="ConceptoTRId">
				<option value="0">Elige</option>
				<?php
					$Herramientas->Scroll('ConceptoTR','ConceptoTRId','ConceptoTR', 0, 'ACTIVO=1', 'ConceptoTR');
				?>
				</select>
			<br><br>
			<div class="Derecha" align="right" >
			<br><br><br><br>
					<input type="button" class="baja" id="Actualiza" name="Actualiza" value="Guardar" onclick="setConcepto()">
			</div>
		</div>


		</form>
		
	</div>

</body>
</html>