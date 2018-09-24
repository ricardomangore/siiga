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
<meta http-equiv="Content-Type" content="text/html;" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"> </script>
<script>window.jQuery || document.write(unescape('%3Cscript src="js/jquery-1.8.1"%3E%3C/script%3E'))</script>

<script type="text/javascript" src="js/menu.js"> </script>
<script type="text/javascript" src="js/general.js"> </script>
<script type="text/javascript" src="js/control.js"> </script>
<script type="text/javascript" src="js/combos.js"> </script>


</head>
</head>
<body>
	<?php $Menu->displayMenu(); ?>
	<div id="Contenido">
		<div id="Titulo">
			<input type="hidden" id="ModuloId" name="ModuloId" value="10">
			<img class="tituloImg" src="img/Puestos.png" />
			Puestos
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
					<legend>Administracin de Puestos</legend>
						<?php $HerramientasHtml->DisplayControles(10,1); ?>
					<br>
					<div align="center" id="resultados"></div>

					<input type="hidden" id="Experiencia" name="Experiencia" value="0">
					<input type="hidden" id="GradoAcademicoId" name="GradoAcademicoId" value="1">

					<label for="Puesto"><span class="importante">*</span>Puesto:</label>
					<input type="text" name="Puesto" id="Puesto" >
					<br>
<!--
					<label for="GradoAcademicoId"><span class="importante">*</span>Grado Academico Requerido:</label>
					<select name="GradoAcademicoId" id="GradoAcademicoId">
					<option value="0">Elige</option>
					<?php // $Herramientas->Scroll('GradosAcademicos','GradoAcademicoId','GradoAcademico',0, 'TRUE', 'GradoAcademicoId') 
					?>
					</select>

					<label for="Experiencia"><span class="importante">*</span>Experiencia Requerida (Meses):</label>
					<input type="text" name="Experiencia" id="Experiencia" >
-->


					<br>


				</fieldset>
				
			</form>
		
	</div>

</body>
</html>