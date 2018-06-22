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
	$ModuloId=61;

if(isset($_POST['bkPV']))
{
	if (isset($_POST['PuntoVentaIdB']))	
		$Herramientas->bloqueraPunto($_POST['PuntoVentaIdB']);
	
	if (isset($_POST['CanalVentaId']))
			$Herramientas->bloquearCanal($_POST['CanalVentaId']);
}
if(isset($_POST['DbkPV']))
{
	if (isset($_POST['PuntoVentaIdB']))
		$Herramientas->desbloquearPunto($_POST['PuntoVentaIdB']);
	if (isset($_POST['CanalVentaId']))
			$Herramientas->DesbloquearCanal($_POST['CanalVentaId']);
}
if(isset($_POST['setPV']))
	if (isset($_POST['PuntoVentaId']))
	{
		setcookie("MiPuntoVenta", $_POST['PuntoVentaId']);

	}

if(isset($_POST['RutaId']))
	setcookie("isChecador", 1); 
 
if(isset($_POST['rmvCkd']))
	setcookie("isChecador", 0); 
	
if(isset($_POST['setName']))
	$Herramientas->saveEquipoPunto($_POST['NameEquipo']);

$Permisos=$Herramientas->getPermisosModulo($ModuloId);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">

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
			<form id="fo1"/>
			<strong>
				Sesion: <?php echo $_SESSION['Empleado']; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="img/Out.png" id="out" title="Salir" onclick="CerrarSesion();" />
				<a href="MiSitio.php"><img src="img/MiSitio.png" id="out" title="Mi Sitio" /></a>
			</strong>
			</form>
			<form id="logout" name="logout" method="post" action="logout.php" /></form>
		</div>
			<br>
		
	<div id="display" name="display">
	<div class="ConScroll">		

	<?php if(in_array("9", $Permisos)) { ?>
		<form id="foo" name="foo" method="post" onsubmit="return validaPunto();" >
			<fieldset>
				<legend>Asignar Punto de Venta a Equipo</legend>
					<br>
					<p><h4>
					Con esta herramienta cambiaras el punto de venta y almacen de la sesion activa, al finalizar la sesion, el punto de venta regresara al asignado originalmente por TH
					</h4></p>
					<br>
						<div class="IzquierdaShort">
						<label for="PuntoVenta">Elige Punto de Venta:</label>
						<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" style="width:400px;">
						<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="0"/>
						<br>

						</div>
						<div class="Derecha">
						<div align="right">							
								<input type="submit" value="Aceptar" class="aceptar" id="setPV" name="setPV" />
								
						</div>
						</div>							
			</fieldset>	
		<br><br>
				<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >	
					Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
						<div id="Puntos" class="datagrid" >';
						<?php
					 	echo $Herramientas->getListaPuntos();
					 	?>
						</div>
				</div>
		</form>
	<?php } 
	if(in_array("10", $Permisos)) {
	?>
		<form id="foo3" name="foo3" method="post" onsubmit="return validaBloqueo();" >
		<fieldset>
			<legend>Bloqueo de sistema</legend>
				<br>
					<div class="IzquierdaShort">
					<label for="PuntoVentaB">Elige Punto de Venta:</label>
					<input type="text" name="PuntoVentaB" id="PuntoVentaB" readonly="readonly" style="width:400px;">
					<input type="hidden" name="PuntoVentaIdB" id="PuntoVentaIdB" value="0"/>
					<br>
					<label for="CanalVentaId">Elige Canal de Venta:</label>
					<select name="CanalVentaId" id="CanalVentaId">
							<option value="0">Elige</option>
				<?php	
							 $Herramientas->Scroll('ClasificacionPersonalVenta','ClasificacionPersonalVentaId','ClasificacionPersonalVenta',0, 'Activo=1', 'ClasificacionPersonalVenta');
				?>
					</select>	
					
					<br>

					</div>
					<div class="Derecha">
					<div align="right">														
							<input type="submit" value="Bloquear" class="borrar" id="bkPV" name="bkPV" />
							<input type="submit" value="Desbloquear" class="activar" id="DbkPV" name="DbkPV" />
					</div>
					</div>							
		</fieldset>	
	<br><br>
			<div id="PuntosVentaB" class="dialogo" title="Elegir Punto de Venta" >	
				Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text" >
					<div id="PuntosB" class="datagrid" >';
					<?php
				 	echo $Herramientas->getListaPuntosB();
				 	?>
					</div>
			</div>
	</form>

	<?php } 
	if(in_array("11", $Permisos)) {
	?>

	<form id="foo1" name="foo1" method="post" >
		<fieldset>
			<legend>Configurar equipo como checador</legend>
				<br>
					<div class="IzquierdaShort">
					<label>¿Este equipo funcionara como checador?</label>
					<br>

					</div>
					<div class="DerechaLarge">
					<div align="right">
							<input type="submit" value="Si" class="aceptar" id="setCkd" name="setCkd" />
							<input type="submit" value="No" class="borrar" id="rmvCkd" name="rmvCkd" />
					</div>
					</div>							
		</fieldset>	
	</form>

	<?php } 
	if(in_array("12", $Permisos)) {
	?>

	<form id="foo2" name="foo2" method="post" >
		<fieldset>
			<legend>Registrar Nombre de Equipo</legend>
				<br>
					<div class="IzquierdaShort">
					<label for="NameEquipo">Nombre de Equipo:</label>
					<input type="text" name="NameEquipo" id="NameEquipo">
					<br>
					
					</div>
					<div class="DerechaLarge">
					<div align="right">
					<?php
					if(isset($_COOKIE["MiPuntoVenta"]))
					echo'
						<input type="submit" value="Registrar" class="aceptar" id="setName" name="setName" />
						';
					else
						echo'Debes asignar Punto de Venta a Equipo';
					?>
					</div>
					</div>							
		</fieldset>	
	</form>
	<?php } ?>
	</div>
			</div>					
		
		
	</div>

</body>
</html>