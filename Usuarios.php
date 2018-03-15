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

	$ModuloId=21;


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
			<legend>Alta de Usuarios</legend>
				<br>
					<div>
					<label for="Usuario"><span class="importante">*</span>Nombre de Usuario:</label>
					<input type="text" name="Usuario" id="Usuario" readonly="readonly" style="width:350px;">
					<input type="hidden" name="EmpleadoId" id="EmpleadoId" value="0" />
					<br>

					</div>
					<div class="Derecha">
					<?php
							echo '<input type="button" value="Aceptar" class="aceptar" id="CreaUsuario" name="CreaUsuario">';
					?>
					</div>
							
		</fieldset>	

	</div>

			<div id="Usuarios" class="dialogo" title="Elegir Usuario" >	
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">				
			<div id="Users" class="datagrid">
			<?php
		 	echo $Herramientas->getListaUsuariosPendientes();
			?>
				</div>
			</div>

			</div>					
		</form>
		
	</div>

</body>
</html>