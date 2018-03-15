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

	$ModuloId=34;


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
			<legend>Liberar Numero de Serie</legend>
				<br>
					<div class="IzquierdaShort">
						<label for="Serie"><span class="importante">*</span>No. Serie de Equipo:</label>
						<input type="text" name="Serie" id="Serie">
					</div>
					<div class="Derecha">
					<?php
						if($Herramientas->permisoEdicion($ModuloId))
							echo '<input type="button" value="Aceptar" class="aceptar" id="LiberaSerie" name="LiberaSerie">';
					?>
					</div>
							
		</fieldset>	
		<br><br>
		<fieldset>
			<legend>Cambiar Fecha de Recepcion</legend>
				<br>
					<div class="IzquierdaShort">
						<label for="MovimientoId"><span class="importante">*</span># Factura:</label>
						<input type="text" name="MovimientoId" id="MovimientoId">
						<br>
						<label for="FechaIngreso"><span class="importante">*</span>Fecha de Recepcion:</label>
							<input type="text" id="FechaIngreso" name="FechaIngreso" readonly="readonly">
						<br>

					</div>
					<div class="Derecha">
					<?php
						if($Herramientas->permisoEdicion($ModuloId))
							echo '<input type="button" class="aceptar" value="Aceptar" id="FechaRecepcion" name="FechaRecepcion">';
					?>
					</div>
							
		</fieldset>	
		<fieldset>
			<legend>Desbloquear Series</legend>
				<br>
					<div class="IzquierdaShort">
						<label>Solo se liberan Series que se bloquean por traspasos  "El proceso puede tardar algunos minutos"</label>
					</div>
					<div class="Derecha">
					<?php
						if($Herramientas->permisoEdicion($ModuloId))
							echo '<input type="button" class="aceptar" value="Aceptar" id="Desbloquear" name="Desbloquear">';
					?>
					</div>
							
		</fieldset>	
		<fieldset>
			<legend>Liberar Cancelados</legend>
				<br>
					<div class="IzquierdaShort">
						<label>Solo se liberan Series con estatus Cancelado "El proceso puede tardar algunos minutos"</label>
					</div>
					<div class="Derecha">
					<?php
						if($Herramientas->permisoEdicion($ModuloId))
							echo '<input type="button" class="aceptar" value="Aceptar" id="DesbloquearCancelados" name="DesbloquearCancelados">';
					?>
					</div>
							
		</fieldset>	
		<fieldset>
			<legend>Desbloquear Recepcion de Mercancia</legend>
				<br>
					<div class="IzquierdaShort">
						<label for="ClaveRecepcion"><span class="importante">*</span>Clave de Recepcion:</label>
						<input type="text" name="ClaveRecepcion" id="ClaveRecepcion">
					</div>
					<div class="Derecha">
					<?php
						if($Herramientas->permisoEdicion($ModuloId))
							echo '<input type="button" class="aceptar" value="Aceptar" id="LiberaRecepcion" name="LiberaRecepcion">';
					?>
					</div>
							
		</fieldset>	

	</div>


			</div>					
		</form>
		
	</div>

</body>
</html>