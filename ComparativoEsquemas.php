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

	$ModuloId=53;
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
		<div class="datagrid" >
		<strong>Venta Semanal Rentas (sin impuestos) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES</strong>		 	
		<table id="MiTabla">
			<thead>				
			<tr align="center">						
				<th></th>
				<th colspan="2">ESQUEMA EJECUTIVOS</th>
				<th colspan="2">ESQUEMA TIENDA A</th>
				<th colspan="2">ESQUEMA TIENDA B</th>
				<th colspan="2">ESQUEMA TIENDA C</th>
			</tr>
			<tr align="center">						
				<th></th>
				<th>Venta Semanal Rentas $</th>
				<th>Pago Fijo Base Semanal</th>
				<th>Venta Semanal Rentas $</th>
				<th>Pago Fijo Base Semanal</th>
				<th>Venta Semanal Rentas $</th>
				<th>Pago Fijo Base Semanal</th>
				<th>Venta Semanal Rentas $</th>
				<th>Pago Fijo Base Semanal</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$t=true;				
				$R0=$Herramientas->getRangoSemanal(1);
				$R1=$Herramientas->getRangoSemanal(2);
				$R2=$Herramientas->getRangoSemanal(3);
				$R3=$Herramientas->getRangoSemanal(4);
				while($A0=mysql_fetch_row($R0))
				{
				$A1=mysql_fetch_row($R1);
				$A2=mysql_fetch_row($R2);	
				$A3=mysql_fetch_row($R3);	

				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
					<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[1].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A1[1].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A1[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A2[1].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A2[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A3[1].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A3[2].'</div></td>
					</tr>
					';										
				$t=(!$t);	
				}
				?>
				</tbody>
		</table>
		</div>
		
		<br><br>
		<div class="datagrid" >
		<strong>
		(Suma de renta de planes SIN IMPUESTOS) SOLO ENTRAN PLANES DILO A 18 Y 24 MESES
		</strong>
		<table id="MiTabla">
			<thead>	
			<tr>
				<td colspan="2"></th>
				<th colspan="3" align="center">Factores por plazo en rentas (EJECUTIVOS)</th>
				<th colspan="2" align="center">TIENDA A</th>
				<th colspan="2" align="center">TIENDA B</th>
				<th colspan="2" align="center">TIENDA C</th>
			</tr>						
			<tr align="center">						
				<th colspan="2">Acumulado de Venta</th>
				<th>Rentas</th>				
				<th>Planes 18</th>
				<th>Planes 24</th>
				<th>Rentas</th>
				<th>Bono</th>
				<th>Rentas</th>
				<th>Bono</th>
				<th>Rentas</th>
				<th>Bono</th>
			</tr>
			</thead>
			<tbody>
			<?php
				$t=true;				
				$R0=$Herramientas->getRangoMensual(1);
				$R1=$Herramientas->getRangoMensual(2);
				$R2=$Herramientas->getRangoMensual(3);
				$R3=$Herramientas->getRangoMensual(4);
				while($A0=mysql_fetch_row($R0))
				{
				 $A1=mysql_fetch_row($R1);
				 $A2=mysql_fetch_row($R2);
				 $A3=mysql_fetch_row($R3);
				
				if($t) $Clase='';
					else $Clase='class="alt"';
				echo'
				<tr '.$Clase.'>
					<td>'.$A0[0].'</td>
					<td align="center">'.$A0[1].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A0[2].'</div></td>
					<td align="right">'.$A0[3].'</td>								
					<td align="right">'.$A0[4].'</td>
					<td><div class="signo">$</div><div class="pesos">'.$A1[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A1[3].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A2[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A2[3].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A3[2].'</div></td>
					<td><div class="signo">$</div><div class="pesos">'.$A3[3].'</div></td>
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
					
		
		<div align="right"><input type="button"  class="aceptar" id="Calcular5" name="Calcular5" value="Calcular">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
		<strong>Ingresa en los cuadros de texto tu venta en rentas (sin impuestos) por semana.</strong>
		<br><br>
		
		<div id="Rentas" class="datagrid" >		 	
		<table id="MiTabla">
			<thead>							
			<tr align="center">	
				<th style="width: 35%;"></th>					
				<th>Semana 1</th>
				<th>Semana 2</th>
				<th>Semana 3</th>
				<th>Semana 4</th>
				<th style="width: 20%;">Venta Mensual</th>
			</tr>
			</thead>
			<tbody>		
				<tr class="alt">
					<td>Venta en Planes 18</td>
					<td align="center"><input type="text" id="b1" name="b1" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b2" name="b2" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b3" name="b3" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="b4" name="b4" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><span id="totalb" name="totalb"></span></td>					
				</tr>

				<tr >
					<td>Venta en Planes 24</td>
					<td align="center"><input type="text" id="c1" name="c1" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c2" name="c2" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c3" name="c3" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><input type="text" id="c4" name="c4" class="venta" style="width: 70%;" value="" /></td>
					<td align="center"><span id="totalc" name="totalc"></span></td>					
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
					<td><span class="importante">Pago base fijo Ejecutivos</span></td>
					<td><span class="importante" id="Efijo1" name="Efijo1"></span></td>
					<td><span class="importante" id="Efijo2" name="Efijo2"></span></td>
					<td><span class="importante" id="Efijo3" name="Efijo3"></span></td>
					<td><span class="importante" id="Efijo4" name="Efijo4"></span></td>
					<td><span class="importante" id="Etotalfijo" name="Etotalfijo"></span></td>
				</tr>
				<tr class="alt"> 
					<td><span class="importante">Pago base fijo Tienda A</span></td>
					<td><span class="importante" id="Afijo1" name="Afijo1"></span></td>
					<td><span class="importante" id="Afijo2" name="Afijo2"></span></td>
					<td><span class="importante" id="Afijo3" name="Afijo3"></span></td>
					<td><span class="importante" id="Afijo4" name="Afijo4"></span></td>
					<td><span class="importante" id="Atotalfijo" name="Atotalfijo"></span></td>
				</tr>
				<tr> 
					<td><span class="importante">Pago base fijo Tienda B</span></td>
					<td><span class="importante" id="Bfijo1" name="Bfijo1"></span></td>
					<td><span class="importante" id="Bfijo2" name="Bfijo2"></span></td>
					<td><span class="importante" id="Bfijo3" name="Bfijo3"></span></td>
					<td><span class="importante" id="Bfijo4" name="Bfijo4"></span></td>
					<td><span class="importante" id="Btotalfijo" name="Btotalfijo"></span></td>
				</tr>
				<tr class="alt"> 
					<td><span class="importante">Pago base fijo Tienda C</span></td>
					<td><span class="importante" id="Cfijo1" name="Cfijo1"></span></td>
					<td><span class="importante" id="Cfijo2" name="Cfijo2"></span></td>
					<td><span class="importante" id="Cfijo3" name="Cfijo3"></span></td>
					<td><span class="importante" id="Cfijo4" name="Cfijo4"></span></td>
					<td><span class="importante" id="Ctotalfijo" name="Ctotalfijo"></span></td>
				</tr>

				<tr>
					<td>Factor Ejecutivos</td>
					<td><span id="Efactor1" name="Efactor1"></span></td>
					<td><span id="Efactor2" name="Efactor2"></span></td>
					<td><span id="Efactor3" name="Efactor3"></span></td>
					<td><span id="Efactor4" name="Efactor4"></span></td>
					<td></span></td>
				</tr>

				<tr>
					<td>Factor Tienda A</td>
					<td><span id="Afactor1" name="Afactor1"></span></td>
					<td><span id="Afactor2" name="Afactor2"></span></td>
					<td><span id="Afactor3" name="Afactor3"></span></td>
					<td><span id="Afactor4" name="Afactor4"></span></td>
					<td></span></td>
				</tr>
				<tr class="alt">
					<td>Factor Tienda B</td>
					<td><span id="Bfactor1" name="Bfactor1"></span></td>
					<td><span id="Bfactor2" name="Bfactor2"></span></td>
					<td><span id="Bfactor3" name="Bfactor3"></span></td>
					<td><span id="Bfactor4" name="Bfactor4"></span></td>
					<td></span></td>
				</tr>
				<tr>
					<td>Factor Tienda C</td>
					<td><span id="Cfactor1" name="Cfactor1"></span></td>
					<td><span id="Cfactor2" name="Cfactor2"></span></td>
					<td><span id="Cfactor3" name="Cfactor3"></span></td>
					<td><span id="Cfactor4" name="Cfactor4"></span></td>
					<td></span></td>
				</tr>

				<tr class="alt">
					<td>Comisión Semanal Ejecutivos</td>
					<td><span id="EComision1" name="EComision1"></span></td>
					<td><span id="EComision2" name="EComision2"></span></td>
					<td><span id="EComision3" name="EComision3"></span></td>
					<td><span id="EComision4" name="EComision4"></span></td>
					<td><span id="Etotalcomision" name="Etotalcomision"></span></td>
				</tr>

				<tr>
					<td>Comisión Semanal Tienda A</td>
					<td><span id="AComision1" name="AComision1"></span></td>
					<td><span id="AComision2" name="AComision2"></span></td>
					<td><span id="AComision3" name="AComision3"></span></td>
					<td><span id="AComision4" name="AComision4"></span></td>
					<td><span id="Atotalcomision" name="Atotalcomision"></span></td>
				</tr>

				<tr class="alt">
					<td>Comisión Semanal Tienda B</td>
					<td><span id="BComision1" name="BComision1"></span></td>
					<td><span id="BComision2" name="BComision2"></span></td>
					<td><span id="BComision3" name="BComision3"></span></td>
					<td><span id="BComision4" name="BComision4"></span></td>
					<td><span id="Btotalcomision" name="Btotalcomision"></span></td>
				</tr>

				<tr>
					<td>Comisión Semanal Tienda C</td>
					<td><span id="CComision1" name="CComision1"></span></td>
					<td><span id="CComision2" name="CComision2"></span></td>
					<td><span id="CComision3" name="CComision3"></span></td>
					<td><span id="CComision4" name="CComision4"></span></td>
					<td><span id="Ctotalcomision" name="Ctotalcomision"></span></td>
				</tr>


				<tr class="alt">
					<td>Total a pagar Ejecutivos</td>
					<td><span id="EPagar1" name="EPagar1"></span></td>
					<td><span id="EPagar2" name="EPagar2"></span></td>
					<td><span id="EPagar3" name="EPagar3"></span></td>
					<td><span id="EPagar4" name="EPagar4"></span></td>
					<td><span id="EtotalPagar" name="EtotalPagar"></span></td>
				</tr>
			
				<tr>
					<td>Total a pagar Tienda A</td>
					<td><span id="APagar1" name="APagar1"></span></td>
					<td><span id="APagar2" name="APagar2"></span></td>
					<td><span id="APagar3" name="APagar3"></span></td>
					<td><span id="APagar4" name="APagar4"></span></td>
					<td><span id="AtotalPagar" name="AtotalPagar"></span></td>
				</tr>

				<tr class="alt">
					<td>Total a pagar Tienda B</td>
					<td><span id="BPagar1" name="BPagar1"></span></td>
					<td><span id="BPagar2" name="BPagar2"></span></td>
					<td><span id="BPagar3" name="BPagar3"></span></td>
					<td><span id="BPagar4" name="BPagar4"></span></td>
					<td><span id="BtotalPagar" name="BtotalPagar"></span></td>
				</tr>

				<tr>
					<td>Total a pagar Tienda C</td>
					<td><span id="CPagar1" name="CPagar1"></span></td>
					<td><span id="CPagar2" name="CPagar2"></span></td>
					<td><span id="CPagar3" name="CPagar3"></span></td>
					<td><span id="CPagar4" name="CPagar4"></span></td>
					<td><span id="CtotalPagar" name="CtotalPagar"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="5">Bono con logro de cuota mensual Ejecutivos</td>
					<td><span id="EbonoMensual" name="EbonoMensual"></span></td>
				</tr>
				<tr>
					<td colspan="5">Bono con logro de cuota mensual Tienda A</td>
					<td><span id="AbonoMensual" name="AbonoMensual"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="5">Bono con logro de cuota mensual Tienda B</td>
					<td><span id="BbonoMensual" name="BbonoMensual"></span></td>
				</tr>
				<tr>
					<td colspan="5">Bono con logro de cuota mensual Tienda C</td>
					<td><span id="CbonoMensual" name="CbonoMensual"></span></td>
				</tr>
				<tr class="alt" align="center">
					<td colspan="2"></td>										
					<td colspan="3"><strong>Cobro total de mes Ejecutivos:</strong></td>
					<td><strong><h2><span class="importante" id="ECobroTotal" name="ECobroTotal"></span></h2></strong></td>
				</tr>
				<tr>
					<td colspan="2"></td>										
					<td colspan="3"><strong>Cobro total de mes Tienda A:</strong></td>
					<td><strong><h2><span class="importante" id="ACobroTotal" name="ACobroTotal"></span></h2></strong></td>
				</tr>
				<tr class="alt" align="center">
					<td colspan="2"></td>										
					<td colspan="3"><strong>Cobro total de mes Tienda B:</strong></td>
					<td><strong><h2><span class="importante" id="BCobroTotal" name="BCobroTotal"></span></h2></strong></td>
				</tr>
				<tr align="center">
					<td colspan="2"></td>										
					<td colspan="3"><strong>Cobro total de mes Tienda C:</strong></td>
					<td><strong><h2><span class="importante" id="CCobroTotal" name="CCobroTotal"></span></h2></strong></td>
				</tr>
			</tbody>
		</table>
		</div>

		<div id="Recalculo" class="datagrid" >		 	
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual Ejecutivos</th>
			</tr>
			<tr align="center">						
				<th>Plazo</th>
				<th>Venta Mensual</th>
				<th>Factor</th>
				<th>Comision</th>
			</tr>
			</thead>
			<tbody>
		
				<tr class="alt">
					<td>Planes 18</td>					
					<td><span id="Emensual18" name="Emensual18"></span></td>
					<td><span id="Efactor18" name="Efactor18"></span></td>
					<td><span id="Ecomision18" name="Ecomision18"></span></td>
				</tr>
				<tr>
					<td>Planes 24</td>
					<td><span id="Emensual24" name="Emensual24"></span></td>
					<td><span id="Efactor24" name="Efactor24"></span></td>
					<td><span id="Ecomision24" name="Ecomision24"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="3">Suma Comision</td>
					<td><span id="Esumacomision" name="Esumacomision"></span></td>
				</tr>
				<tr>
					<td colspan="3">Comision Anterior</td>
					<td><span id="Ecomisionanterior" name="Ecomisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="3">Complemento</td>
					<td><span id="Ecomplemento" name="Ecomplemento"></span></td>
				</tr>
			</tbody>
		</table>		
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual Tienda A</th>
			</tr>
			<tr align="center">										
				<th>Venta Mensual</th>
				<th>Bono</th>
				<th>Suma Bono</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">					
					<td><span id="Amensual18" name="Amensual18"></span></td>
					<td><span id="Afactor18" name="Afactor18"></span></td>
					<td><span id="Acomision18" name="Acomision18"></span></td>
				</tr>
				<tr>
					<td colspan="2">Comision Anterior</td>
					<td><span id="Acomisionanterior" name="Acomisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="2">Complemento</td>
					<td><span id="Acomplemento" name="Acomplemento"></span></td>
				</tr>
			</tbody>
		</table>
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual Tienda B</th>
			</tr>
			<tr align="center">										
				<th>Venta Mensual</th>
				<th>Bono</th>
				<th>Suma Bono</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">					
					<td><span id="Bmensual18" name="Bmensual18"></span></td>
					<td><span id="Bfactor18" name="Bfactor18"></span></td>
					<td><span id="Bcomision18" name="Bcomision18"></span></td>
				</tr>
				<tr>
					<td colspan="2">Comision Anterior</td>
					<td><span id="Bcomisionanterior" name="Bcomisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="2">Complemento</td>
					<td><span id="Bcomplemento" name="Bcomplemento"></span></td>
				</tr>
			</tbody>
		</table>
		<table id="MiTabla">
			<thead>				
			<tr>						
				<th colspan="4" align="center">RECALCULO de Comision Mensual Tienda C</th>
			</tr>
			<tr align="center">										
				<th>Venta Mensual</th>
				<th>Bono</th>
				<th>Suma Bono</th>
			</tr>
			</thead>
			<tbody>
				<tr class="alt">					
					<td><span id="Cmensual18" name="Cmensual18"></span></td>
					<td><span id="Cfactor18" name="Cfactor18"></span></td>
					<td><span id="Ccomision18" name="Ccomision18"></span></td>
				</tr>
				<tr>
					<td colspan="2">Comision Anterior</td>
					<td><span id="Ccomisionanterior" name="Ccomisionanterior"></span></td>
				</tr>
				<tr class="alt">
					<td colspan="2">Complemento</td>
					<td><span id="Ccomplemento" name="Ccomplemento"></span></td>
				</tr>
			</tbody>
		</table>
		</div>
		<br><br>
		</form>		
	</div>
</body>
</html>