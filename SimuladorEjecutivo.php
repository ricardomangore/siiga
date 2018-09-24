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

	$ModuloId=54;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />

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
		
				<div id="RangoSemanal" class="datagrid" >		
		<table id="MiTabla">
			<thead>				
			<tr align="center">						
				<th>Garantia</th>
				<th>Instalaciones Minimas</th>				
				<th>sujeto a instalaciones 100%</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">
					<td>1a Semana</td>
					<td align="center">0</td>
					<td><div class="signo">$</div><div class="pesos">1,000</div></td>
				</tr>
				<tr>
					<td>2a Semana</td>
					<td align="center">1</td>
					<td><div class="signo">$</div><div class="pesos">1,000</div></td>
				</tr>
				<tr class="alt">
					<td>3a Semana</td>
					<td align="center">2</td>
					<td><div class="signo">$</div><div class="pesos">1,000</div></td>
				</tr>
			</tbody>
		</table>
		</div>
		

		
		
		<div id="RangoMensual">
		<p>
		<span class="Nota">
		NOTA:
		</span>	
		</p>
		<ui>
		<li>El Plan Esencial 2P,  para efectos de comisiones y pago tanto semanal y mensual ,  se considera al .50 del valor de la renta del plan sin impuestos, ES DECIR EQUIVALE A $172</li>
		</ui>	
		<br>
		</div>

		<br>

		<div id="RangoSemanal" class="datagrid" >		
		<table id="MiTabla">
			<thead>				
			<tr align="center">						
				<th>Periodo</th>				
				<th width="30%">Sujeto a</th>
				<th>Rentas sin impuestos por periodo</th>
				<th>Base semanal</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">
					<td>Semanal</td>
					<td>Menor a</td>
					<td><div class="signo">$</div><div class="pesos">340</div></td>
					<td><div class="signo">$</div><div class="pesos">0</div></td>
				</tr>
				<tr>
					<td>Semanal</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">340</div></td>
					<td><div class="signo">$</div><div class="pesos">300</div></td>
				</tr>
				<tr class="alt">
					<td>Semanal</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">500</div></td>
					<td><div class="signo">$</div><div class="pesos">600</div></td>
				</tr>
				<tr>
					<td>Semanal</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">800</div></td>
					<td><div class="signo">$</div><div class="pesos">1,000</div></td>
				</tr>

			</tbody>
		</table>
		</div>
		
		
		<div id="RangoMensual" class="datagrid" >		
		<strong>Comsiones por Volumen según periodo</strong>
			<table id="MiTabla">
			<thead>				
			<tr align="center">						
				<th>Comision</th>				
				<th>Sujeto a</th>
				<th>Rentas sin impuestos por periodo</th>
				<th>Factor a aplicar</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">
					<td>Semanal</td>
					<td>Menor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">344</div></td>
					<td align="right">0.30</td>
				</tr>
				<tr>
					<td>Semanal</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">800</div></td>
					<td align="right">0.50</td>
				</tr>
				<tr class="alt">
					<td>Mensual</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">3,000</div></td>
					<td align="right">0.70</td>
				</tr>
				<tr>
					<td>Mensual</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">5,000</div></td>
					<td align="right">1.0</td>
				</tr>
				<tr class="alt">
					<td>Mensual</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">7,000</div></td>
					<td align="right">1.30</td>
				</tr>
				<tr>
					<td>Mensual</td>
					<td>Mayor o igual a</td>
					<td><div class="signo">$</div><div class="pesos">10,000</div></td>
					<td align="right">1.50</td>
				</tr>

			</tbody>
		</table>		</div>


		<hr id="Linea">

		
		<div align="right"><input type="button"  class="aceptar" id="Calcular6" name="Calcular6" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		<strong>Ingresa en los cuadros de texto tu venta en rentas (sin impuestos ya instalados) por semana.</strong>
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
				<tr class="alt">
					<td>Venta en Planes Escenncial 2P</td>
					<td align="center"><input type="text" id="b1" name="b1" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b2" name="b2" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b3" name="b3" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b4" name="b4" class="venta" style="width: 70%;" value="" /></td>
					<td><span id="totalb" name="totalb"></span></td>					
				</tr>
				<tr class="alt">
					<td></td>
					<td align="center"><span id="s1Real" name="s1Real"></td>
					<td align="center"><span id="s2Real" name="s2Real"></td>
					<td align="center"><span id="s3Real" name="s3Real"></td>
					<td align="center"><span id="s4Real" name="s4Real"></td>
					<td><span id="totalreal" name="totalreal"></span></td>
				</tr>

				<tr >
					<td>Venta en Otros Planes</td>
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
					<td align="center"><span id="factor1" name="factor1"></span></td>
					<td align="center"><span id="factor2" name="factor2"></span></td>
					<td align="center"><span id="factor3" name="factor3"></span></td>
					<td align="center"><span id="factor4" name="factor4"></span></td>
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
				<tr>
					<td>Comision</td>
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