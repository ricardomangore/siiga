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

	$ModuloId=52;
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
		<strong>Venta Semanal Rentas ( sin impuestos) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES</strong>		 	
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
				$R0=$Herramientas->getRangoSemanal(4);
				while($A0=mysql_fetch_row($R0))
				{
				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
					<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td align="center">$'.$A0[1].'</td>
					<td align="center">$'.$A0[2].'</td>								
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
		(suma de renta de planes SIN IMPUESTOS) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES
		</strong>
		<table id="MiTabla">
			<thead>	
			<tr align="center">						
				<th colspan="2">Acumulado de Venta</th> 
				<th>Rentas</th>
				
				<th>Bono</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$t=true;				
				$R0=$Herramientas->getRangoMensual(4);
				while($A0=mysql_fetch_row($R0))
				{
				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
					<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td align="center">'.$A0[1].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[3].'</div></td>
					</tr>
					';										
				$t=(!$t);	
				}
				?>
				</tbody>
		</table>
		</div>


		<hr id="Linea">
		<p>
		<span class="Nota">
		NOTA:
		</span>	
		</p>
		<ui>
		<li>Si tienes uno o mas expedientes penalizados, tu bono se va al 50%</li>
		<li>Si tienes un chargeback igual o mayor al 5%, tu bono se reduce al 50% </li>
		<li>Si tienes los dos puntos anteriores, tu bono se perdera en un 100%</li>
		<li>La falta de captura en SIIGA en tiempo y forma (DIARIAMENTE) ocasionara la penalizacion de tu pago semanal NO RECUPERABLE las proximas semanas</li>
		</ui>	
		<br>

		<div align="right"><input type="button"  class="aceptar" id="Calcular4" name="Calcular4" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
			
				<tr>
					<td>Venta en Planes</td>
					<td align="center"><input type="text" id="a1" name="a1" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a2" name="a2" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a3" name="a3" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a4" name="a4" style="width: 70%;" class="venta" /></td>
					<td align="center"><strong><span id="totala" name="totala"></span></strong></td>
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
		<strong>*La comision Mensual se pagara a los 20 dias del siguiente mes</strong> 	
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual </th>
			</tr>
			<tr align="center">										
				<th>Venta Mensual</th>
				<th>Bono</th>
				<th>Suma Bono</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">					
					<td><span id="mensual18" name="mensual18"></span></td>
					<td><span id="factor18" name="factor18"></span></td>
					<td><span id="comision18" name="comision18"></span></td>
				</tr>
				<tr>
					<td colspan="2">Comision Anterior</td>
					<td><span id="comisionanterior" name="comisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="2">Complemento</td>
					<td><span id="complemento" name="complemento"></span></td>
				</tr>
			</tbody>
		</table>
			<div>
			<br><br><span class="Nota">
		CONDICIONES PARA EL PAGO DEL BONO MENSUAL:
		</span>
		
		<br>
		<br>
		<ui>
		<li>Para el pago del bono mensual la venta propia NO podra EXCEDER del 50% de la venta de la tienda</li>
		<li>Se revisara el promedio de venta mensual de cada ejecutivo a su cargo para medir productividad, en caso de alerta, se modificara el esquema</li>
		</ui>
		</div>
		</div>
	
		<br><br>
		</form>		
	</div>
</body>
</html>