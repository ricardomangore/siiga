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

	$ModuloId=49;
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
		<input type="hidden" id="SimuladorId" name="SimuladorId">		
		<br>
		<div align="center">
		<strong><h3>
		SOLO ENTRAN PLANES DILO
		</h3>
		</strong>
		</div>

		<div id="RangoSemanal" class="datagrid" >
		<strong>Venta Semanal Rentas (sin impuestos) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES (Comision semanal al 35%)</strong>		 	
		<table id="MiTabla">
			<thead>				
			<tr align="center">						
				<th></th>
				<th>Venta Semanal Rentas $</th>
				<th>Pago Fijo Base Semanal</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$t=true;				
				$R0=$Herramientas->getRangoSemanal(1);
				while($A0=mysql_fetch_row($R0))
				{
				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
					<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[1].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[2].'</div></td>
					</tr>
					';										
				$t=(!$t);	
				}
				?>
				</tbody>
		</table>
		</div>
		
		
		<div id="RangoMensual" class="datagrid" >
		<strong>
		(Suma de renta de planes SIN IMPUESTOS) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES
		</strong>
		<table id="MiTabla">
			<thead>	
			<tr>
				<td colspan="2"></th>
				<th colspan="3" align="center">Factores por plazo en rentas</th>
			</tr>						
			<tr align="center">						
				<th colspan="2">Acumulado de Venta</th>
				<th>Rentas</th>
			<!--	<th>Planes 6-12</th>  -->
				<th>Planes 18</th>
				<th>Planes 24</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$t=true;				
				$R0=$Herramientas->getRangoMensual(1);
				while($A0=mysql_fetch_row($R0))
				{
				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
				<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td align="center">'.$A0[1].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[2].'</div></td>
					<td align="right">'.$A0[3].'</td>								
					<td align="right">'.$A0[4].'</td>								
												
					</tr>
					';										
				$t=(!$t);	
				}
				?>
				</tbody>
		</table>
		</div>

		<hr id="Linea">

	<input type="hidden" id="a1" name="a1" value="0" />
	<input type="hidden" id="a2" name="a2" value="0" />
	<input type="hidden" id="a3" name="a3" value="0" />
	<input type="hidden" id="a4" name="a4" value="0" />
					
		
		<div align="right"><input type="button"  class="aceptar" id="Calcular1" name="Calcular1" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		<strong>Ingresa en los cuadros de texto tu venta en rentas (sin impuestos) por semana.</strong>
		<br><br>
		
		<div id="Rentas" class="datagrid" >		 	
		<table id="MiTabla">
			<thead>							
			<tr align="center">	
				<th style="width: 25%;"></th>					
				<th>Semana 1</th>
				<th>Semana 2</th>
				<th>Semana 3</th>
				<th>Semana 4</th>
				<th style="width: 25%;">Venta Mensual</th>
			</tr>
			</thead>
			<tbody>
			<!--
				<tr>
					<td>Venta en Planes 6-12</td>
					<td align="center"><input type="text" id="a1" name="a1" style="width: 70%;" value="0" /></td>
					<td align="center"><input type="text" id="a2" name="a2" style="width: 70%;" value="0" /></td>
					<td align="center"><input type="text" id="a3" name="a3" style="width: 70%;" value="0" /></td>
					<td align="center"><input type="text" id="a4" name="a4" style="width: 70%;" value="0" /></td>
					<td align="center"><span id="totala" name="totala"></span></td>					
				</tr>
			-->
				<tr class="alt">
					<td>Venta en Planes 18</td>
					<td align="center"><input type="text" id="b1" name="b1" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b2" name="b2" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b3" name="b3" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b4" name="b4" class="venta" style="width: 70%;" value="" /></td>
					<td><span id="totalb" name="totalb"></span></td>					
				</tr>

				<tr >
					<td>Venta en Planes 24</td>
					<td align="center"><input type="text" id="c1" name="c1" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c2" name="c2" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c3" name="c3" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c4" name="c4" class="venta" style="width: 70%;" value="" /></td>
					<td><span id="totalc" name="totalc"></span></td>					
				</tr>

				<tr class="alt"> 
					<td><span>Total Venta</span></td>
					<td><span id="tventa1" name="tventa1"></span></td>
					<td><span id="tventa2" name="tventa2"></span></td>
					<td><span id="tventa3" name="tventa3"></span></td>
					<td><span id="tventa4" name="tventa4"></span></td>
					<td align="center"><strong><h3><span id="totaltventa" name="totaltventa"></span><h3></strong></td>
				</tr>

				<tr> 
					<td><span class="importante">Pago base fijo</span></td>
					<td><span class="importante" id="fijo1" name="fijo1"></span></td>
					<td><span class="importante" id="fijo2" name="fijo2"></span></td>
					<td><span class="importante" id="fijo3" name="fijo3"></span></td>
					<td><span class="importante" id="fijo4" name="fijo4"></span></td>
					<td><span class="importante" id="totalfijo" name="totalfijo"></span></td>
				</tr>

				<tr class="alt">
					<td>Factor</td>
					<td><span id="factor1" name="factor1"></span></td>
					<td><span id="factor2" name="factor2"></span></td>
					<td><span id="factor3" name="factor3"></span></td>
					<td><span id="factor4" name="factor4"></span></td>
					<td><span id="totalfactor" name="totalfactor"></span></td>
				</tr>

				<tr>
					<td>Comisión Semanal</td>
					<td><span id="Comision1" name="Comision1"></span></td>
					<td><span id="Comision2" name="Comision2"></span></td>
					<td><span id="Comision3" name="Comision3"></span></td>
					<td><span id="Comision4" name="Comision4"></span></td>
					<td><span id="totalcomision" name="totalcomision"></span></td>
				</tr>

				<tr class="alt">
					<td>Total a pagar</td>
					<td><span id="Pagar1" name="Pagar1"></span></td>
					<td><span id="Pagar2" name="Pagar2"></span></td>
					<td><span id="Pagar3" name="Pagar3"></span></td>
					<td><span id="Pagar4" name="Pagar4"></span></td>
					<td><span id="totalPagar" name="totalPagar"></span></td>
				</tr>
			
				<tr>
					<td colspan="5">Bono con logro de cuota mensual</td>										
					<td><span id="bonoMensual" name="bonoMensual"></span></td>
				</tr>

				<tr class="alt" align="center">
					<td colspan="3"></td>										
					<td colspan="2"><strong>Cobro total de mes:</strong></td>
					<td><strong><h2><span class="importante" id="CobroTotal" name="CobroTotal"></span></h2></strong></td>
				</tr>

			</tbody>			
		</table>
		</div>

		<div id="Recalculo" class="datagrid" >		 	
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual </th>
			</tr>
			<tr align="center">						
				<th>Plazo</th>
				<th>Venta Mensual</th>
				<th>Factor</th>
				<th>Comision</th>
			</tr>
			</thead>
			<tbody>
			<!--
				<tr>
					<td>Planes 6-12</td>
					<td><span id="mensual612" name="mensual612"></span></td>
					<td><span id="factor612" name="factor612"></span></td>
					<td><span id="comision612" name="comision612"></span></td>
				</tr>
			-->
				<tr class="alt">
					<td>Planes 18</td>					
					<td><span id="mensual18" name="mensual18"></span></td>
					<td align="right"><span id="factor18" name="factor18"></span></td>
					<td><span id="comision18" name="comision18"></span></td>
				</tr>
				<tr>
					<td>Planes 24</td>
					<td><span id="mensual24" name="mensual24"></span></td>
					<td align="right"><span id="factor24" name="factor24"></span></td>
					<td><span id="comision24" name="comision24"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="3">Suma Comision</td>
					<td><span id="sumacomision" name="sumacomision"></span></td>
				</tr>
				<tr>
					<td colspan="3">Comision Anterior</td>
					<td><span id="comisionanterior" name="comisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="3">Complemento</td>
					<td><span id="complemento" name="complemento"></span></td>
				</tr>
			</tbody>
		</table>
		</div>
		<br><br>
		</form>		
	</div>
</body>
</html>