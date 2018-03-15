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
			<input type="hidden" id="ModuloId" name="ModuloId" value="28">
			<img class="tituloImg" src="img/Areas.png" />
			Areas de Trabajo
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
					<legend>Administracin de Areas de Trabajo</legend>
						<?php $HerramientasHtml->DisplayControles(28,1); ?>
					<br>
					<div align="center" id="resultados"></div>
					<div class="Izquierda">
					<label for="AreaTrabajo"><span class="importante">*</span>Area de Trabajo:</label>
					<input type="text" name="AreaTrabajo" id="AreaTrabajo" >
					</div>
					<div class="Derecha">
						<input type="hidden" id="Dependencias" name="Dependencias" value="">						
						<div class="datagrid">
							<table id="Funciones" >
							<thead>
								<tr>
									<td colspan="2">Buscar:&nbsp<input id="Busqueda" type="text"></td>
								</tr>
								<tr>						
									<th>Dependencia</th>
									<th>Seleccionar</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$t=true;				
								$R0=$Herramientas->getDependencias();
								while($A0=mysql_fetch_row($R0))
								{
									if($t) $Clase='';
									else $Clase='class="alt"';
										echo'
												<tr '.$Clase.'>
													<td>'.utf8_decode($A0[1]).'</td>
													<td align="center"><input type="checkbox" name="Dependencia" id="Dependencia" class="Dep" value="'.$A0[0].'" onclick="setFuncion(this)" /></td>
												</tr>
										';										
									$t=(!$t);	
								}
							?>
							</tbody>
							</table>
						</div>						
					</div>

				</fieldset>
				
			</form>
		
	</div>

</body>
</html>