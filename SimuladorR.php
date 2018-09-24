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

	$ModuloId=57;
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
				$R0=$Herramientas->getRangoSemanal(5);
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
				$R0=$Herramientas->getRangoMensual(5);
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
		<br><br>
		</div>

		<hr id="Linea">
		<span class="Nota">
		NOTA: Apoyo de gasolina
		</span>	
		</p>
		<ui>
		<li><strong>De 1 mil x semana, condicionado a que  cada uno de los pdv , logren su cuota semanal esto sera de forma individual, ver ejemplo:</strong></li>
		</ui>
		<br>
<div>
	<div class="Izquierda">
		<div class="datagrid">
			<table>
			<thead>	
			<tr align="center">						
				<th>Punto de Venta</th> 
				<th>Tipo de Punto</th>
				<th>Cuota Semanal</th>
				<th>Venta Real</th>
			</tr>
			</thead>
				<tbody>
				<tr>
					<td>Punto 1</td>
					<td align="center">A</td>
					<td><div class="signo">$</div><div class="pesos">5,000</div></td>
					<td><div class="signo">$</div><div class="pesos">7,800</div></td>
				</tr>
				<tr class="altR">
					<td>Punto 2</td>
					<td align="center">B</td>
					<td><div class="signo">$</div><div class="pesos">3,000</div></td>
					<td><div class="signo">$</div><div class="pesos">2,300</div></td>
				</tr>
				<tr class="altR">
					<td>Punto 3</td>
					<td align="center">C</td>
					<td><div class="signo">$</div><div class="pesos">2,000</div></td>
					<td><div class="signo">$</div><div class="pesos">1,800</div></td>
				</tr>
				<tr class="alt">
					<td colspan="2" style="color: red" align="center"><strong>Total</strong></td>
					<td><strong><div class="signo">$</div><div class="pesos">10,000</div></strong></td>
					<td><strong><div class="signo">$</div><div class="pesos">11,900</div></strong></td>
				</tr>
				<tr>
					<td colspan="4"><span class="importante">Observemos que las filas marcadas en rojo son puntos que no llegan a su cuota, por lo tanto <strong>NO APLICA EL BONO DE GASOLINA</strong></span></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="Derecha">
		<div class="datagrid">
			<table style="width: 80%;">
			<thead>	
			<tr align="center">						
				<th>Punto de Venta</th> 
				<th>Tipo de Punto</th>
				<th>Cuota Semanal</th>
				<th>Venta Real</th>
			</tr>
			</thead>
				<tbody>
				<tr>
					<td>Punto 1</td>
					<td align="center">A</td>
					<td><div class="signo">$</div><div class="pesos">5,000</div></td>
					<td><div class="signo">$</div><div class="pesos">5,020</div></td>
				</tr>
				<tr class="alt">
					<td>Punto 2</td>
					<td align="center">B</td>
					<td><div class="signo">$</div><div class="pesos">3,000</div></td>
					<td><div class="signo">$</div><div class="pesos">3,200</div></td>
				</tr>
				<tr>
					<td>Punto 3</td>
					<td align="center">C</td>
					<td><div class="signo">$</div><div class="pesos">2,000</div></td>
					<td><div class="signo">$</div><div class="pesos">2,200</div></td>
				</tr>
				<tr class="alt">
					<td colspan="2" style="color: red" align="center"><strong>Total</strong></td>
					<td><strong><div class="signo">$</div><div class="pesos">10,000</div></strong></td>
					<td><strong><div class="signo">$</div><div class="pesos">10,420</div></strong></td>
				</tr>
				<tr>
					<td colspan="4"><span class="importante">Observemos que todas las tiendas cumplen su cuota semanal <strong>SI APLICA EL BONO DE GASOLINA</strong></span></td>
				</tr>
				</tbody>
			</table>
			<br><br>
		</div>
	</div>
</div>
<div class="centro">
<br><br><br><br><br><br><br><br>
<br><br><br><br>
<span class="Nota">
		NOTA: Pago de bono por venta de Subdistribuidores
		</span>
		</p>
		<ui>
		<li><strong>Para el pago de este bono condicionado a que  condicionado a que logres la cuota total semanal (suma de todos los puntos) esto sera de forma individual, ver ejemplo:</strong></li>
		</ui>
		<br>
</div>
	<div class="Izquierda">
		<div class="datagrid">
			<table>
			<thead>	
			<tr align="center">						
				<th>Punto de Venta</th> 
				<th>Tipo de Punto</th>
				<th>Cuota Semanal</th>
				<th>Venta Real</th>
			</tr>
			</thead>
				<tbody>
				<tr class="altR">
					<td>Tiendas Propias</td>
					<td align="center">A, B Y/O C</td>
					<td><div class="signo">$</div><div class="pesos">12,000</div></td>
					<td><div class="signo">$</div><div class="pesos">11,000</div></td>
				</tr>
				<tr class="alt">
					<td>Subdistribuidores</td>
					<td></td>
					<td></td>
					<td><div class="signo">$</div><div class="pesos">10,000</div></td>
				</tr>
				<tr>
					<td colspan="4"><span class="importante">Observemos que la venta de tiendas propias no cubre la cuota semanal <strong>NO APLICA EL BONO DE VENTA SUBDISTRIBUIDORES</strong></span></td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="Derecha">
		<div class="datagrid">
			<table style="width: 80%;">
			<thead>	
			<tr align="center">						
				<th>Punto de Venta</th> 
				<th>Tipo de Punto</th>
				<th>Cuota Semanal</th>
				<th>Venta Real</th>
			</tr>
			</thead>
				<tbody>
				<tr>
					<td>Tiendas Propias</td>
					<td align="center">A, B Y/O C</td>
					<td><div class="signo">$</div><div class="pesos">12,000</div></td>
					<td><div class="signo">$</div><div class="pesos">13,000</div></td>
				</tr>
				<tr class="alt">
					<td>Subdistribuidores</td>
					<td></td>
					<td></td>
					<td><div class="signo">$</div><div class="pesos">10,000</div></td>
				</tr>
				<tr>
					<td colspan="4"><span class="importante">En este caso se cubre la cuota semanal de Tiendas Propias, entonces <strong>SI APLICA PAGO DE BONO POR VENTA DE SUBDISTRIBUIDORES</strong></span></td>
				</tr>
				</tbody>
			</table>
		</div>
	<br>
		<div align="right"><input type="button"  class="aceptar" id="Calcular8" name="Calcular8" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
	<br>		
	</div>
	<div id="Rentas" class="datagrid" >		 	
			<strong>Ingresa en los cuadros de texto tu venta en rentas (sin impuestos) por semana.</strong>
		<br>
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
					<td>Venta en Planes Tiendas Propias</td>
					<td align="center"><input type="text" id="a1" name="a1" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a2" name="a2" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a3" name="a3" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="a4" name="a4" style="width: 70%;" class="venta" /></td>
					<td align="center"><strong><span id="totala" name="totala"></span></strong></td>
				</tr>
				<tr class="alt">
					<td>Venta en Planes SubDistribuidores</td>
					<td align="center"><input type="text" id="b1" name="b1" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="b2" name="b2" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="b3" name="b3" style="width: 70%;" class="venta" /></td>
					<td align="center"><input type="text" id="b4" name="b4" style="width: 70%;" class="venta" /></td>
					<td align="center"><strong><span id="totalb" name="totalb"></span></strong></td>
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
					<td><span class="importante">Pago venta Subdistribuidores</span></td>
					<td><span class="importante" id="fijos1" name="fijos1"></span></td>
					<td><span class="importante" id="fijos2" name="fijos2"></span></td>
					<td><span class="importante" id="fijos3" name="fijos3"></span></td>
					<td><span class="importante" id="fijos4" name="fijos4"></span></td>
					<td><span class="importante" id="totalfijos" name="totalfijos"></span></td>
				</tr>
				<tr class="alt">
					<td>Factor SubDistribuidores</td>
					<td><span id="factors1" name="factor1s"></span></td>
					<td><span id="factors2" name="factor2s"></span></td>
					<td><span id="factors3" name="factor3s"></span></td>
					<td><span id="factors4" name="factor4s"></span></td>
					<td><span id="totalfactors" name="totalfactors"></span></td>
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
					<td>Total a pagar Vta Propia</td>
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
				<tr class="alt">
					<td colspan="5">Pago por Vta Sub</td>										
					<td><span id="PagoSub" name="PagoSub"></span></td>
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
		</div>
		<br><br>
		</form>		
	</div>
</body>
</html>