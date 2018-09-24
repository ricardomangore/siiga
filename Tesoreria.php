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

	$ModuloId=76;
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
	</div>

	<fieldset>
		
	
	<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">


	<thead class="fixedHeader">
		<tr>
			<th bgcolor="#BFD5EA" valign="midle" width="3%">Opciones</th>
			<th bgcolor="#BFD5EA">Titulo</th>
			<th bgcolor="#BFD5EA">Descripci&oacute;n</th>
		</tr>
	</thead>
	<tbody class="scrollContent">
		<tr>
			<td align="center"><a href="Templates/FormatoCortes0.csv" download="FormatoCorte.csv"><img src="img/Csv.png"> </a></td>
			<td>T&eacute;mplate Montos Reales</td>
			<td>T&eacute;mplate para utilizar la herramienta de Dep&oacute;sitos Reales</td>

		</tr>
		<tr>
			<td align="center"><a href="Tesoreria/cortes.php"><img src="img/Csv.png"> </a></td>
			<td>Reporte Cortes</td>
			<td>Reporte Diario para mostrar que puntos de venta subieron Cortes</td>

		</tr>
		<tr>
			<td align="center"><a href="Tesoreria/depositos.php"><img src="img/Csv.png"> </a></td>
			<td>Reporte Dep&oacute;sitos</td>
			<td>Reporte Diario para mostrar que puntos de venta subieron Dep&oacute;sitos</td>

		</tr>

	</tbody>

	</table>



	</fieldset>
<br><br>
	<fieldset>
	<legend>Dep&oacute;sitos Montos Reales</legend>
		<form action="Tesoreria/importarCortes.php" enctype="multipart/form-data" method="post">

			<input id="archivo" accept=".csv" name="archivo" type="file" required>
			<input type="hidden" name="MAX_FILE_SIZE" value="20000">
			<input class="lista" type="submit" name="enviar" value="Aceptar">
		</form>
	</fieldset>
	
		<fieldset>
	<legend>Descarga de Reportes</legend>
	    <a href="reportes/depositosCR7.php" target="_blank">
			<input class="lista" type="submit" name="enviar" value="Aceptar">
		</a>
	</fieldset>













</body>
</html>