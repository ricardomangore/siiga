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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />

<script src="http://code.jquery.com/jquery-1.8.1.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/combos.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

</head>
<body>
	<?php $Menu->displayMenu(); ?>
	<div id="Contenido">
		<div id="Titulo">
			<input type="hidden" id="ModuloId" name="ModuloId" value="0">
			<img class="tituloImg" src="img/Sitio.png" />
			Mi Sitio
		</div>	

		<div id="Sesion">
			<form id="foo" />
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
				
				<fieldset>
					<legend>Cambio de Contraseña</legend>
						<?php $HerramientasHtml->DisplayControles(0,0); ?>
					<br>
					<br>
					<div align="center" id="resultados"><?php echo $_SESSION['Mensaje']; ?></div>
					<br>

						<label for="actual"><span class="importante">*</span>Contraseña actual:</label>
						<input type="password" name="actual" id="actual">
						<br>
						<br>
						<label for="password1"><span class="importante">*</span>Nueva contraseña:</label>
						<input type="password" name="password1" id="password1">
						<br>
						<label for="password2"><span class="importante">*</span>Repetir contraseña:</label>
						<input type="password" name="password2" id="password2">
					
				</fieldset>
				
			</form>
		
	</div>

</body>
</html>