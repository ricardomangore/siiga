<?php
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

	$ModuloId=31;

	if(!isset($_POST['Lectura4']))
	{
		$Serie=0;
		$_POST['Lectura4']='';
	}
	else
		$Serie=$_POST['Lectura4'];
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
			<br>
			<div align="center" id="resultados"></div>
			<div id="display" name="display">
			
	<div class="ConScroll">		

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
					<div class="IzquierdaShort">
						<label for="Lectura4"><span class="importante">*</span>No. Serie de Equipo:</label>
						<input type="text" name="Lectura4" id="Lectura4" value="<?php echo $_POST['Lectura4']; ?>">
					</div>
					
					<div class="DerechaLarge">
						<div class="datagrid">
								<div id="displayLineas">
							<?php
								echo $Herramientas->getBuscaArticuloDispopnible($Serie);
							?>
								</div>

						</div>
					</div>

				<div class="Centro">
				<br><br>
					<div class="datagrid">
						<div id="displayLineas">
							<?php
								echo $Herramientas->getBuscaArticulo($Serie);
							?>
						</div>

					</div>
				</div>
		</fieldset>			
		<fieldset>
			<legend>Informacion de Bloqueo</legend>
				<br>
				<div class="Centro">
					<?php echo $Herramientas->getInfoBloqueo($Serie); ?>
				<br><br>
				</div>
		</fieldset>	
		<fieldset>
			<legend>Informacion de Venta</legend>
				<br>
				<div class="Centro">					
				<br><br>
				<div class="datagrid">
						<div id="displayLineas">
							<?php
								echo $Herramientas->getInfoSerie($Serie);
							?>
						</div>

					</div>
				</div>
		</fieldset>	

		<br><br>
	</div>


			</div>					
		</form>
		
	</div>

</body>
</html>