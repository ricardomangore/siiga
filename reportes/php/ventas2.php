<?php
	include("conexion.php");
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=reporteRecarga.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
?>
<table border="1">
	<tr>
		<td><b><font face="calibri">CONTRATO / CO ID</b></td>
		<td><b><font face="calibri">FOLIO DEL CONTRATO</b></td>
		<td><b><font face="calibri">EXTRACTO FOLIO</b></td>
		<td><b><font face="calibri">REGI&Oacute;N</b></td>
		<td><b><font face="calibri">SUBREGION</b></td>
		<td><b><font face="calibri">PLAZA</b></td>
		<td><b><font face="calibri">PTO. DE VENTA</b></td>
		<td><b><font face="calibri">OPERACION PDV</b></td>
		<td><b><font face="calibri">TIPO DE PDV</b></td>
		<td><b><font face="calibri">ESTATUS DEL PUNTO</b></td>
		<td><b><font face="calibri">FECHA DE CAPTURA SIIGA</b></td>
		<td><b><font face="calibri">COORDINADOR</b></td>
		<td><b><font face="calibri">EJECUTIVO</b></td>
		<td><b><font face="calibri">CATEGORIA</b></td>
		<td><b><font face="calibri">SUBCATEGORIA</b></td>
		<td><b><font face="calibri">CLIENTE</b></td>
		<td><b><font face="calibri">MARCA DE EQUIPO</b></td>
		<td><b><font face="calibri">EQUIPO</b></td>
		<td><b><font face="calibri">PLAN SIIGA</b></td>
		<td><b><font face="calibri">PLAN ATT</b></td>
		<td><b><font face="calibri">FAMILIA PLAN</b></td>
		<td><b><font face="calibri">TIPO DE PLAN</b></td>
		<td><b><font face="calibri">RENTA TOTAL</b></td>
		<td><b><font face="calibri">RENTA SIN IMPUESTOS</b></td>
		<td><b><font face="calibri">PLAZO FORZOSO</b></td>
		<td><b><font face="calibri">ESTATUS</b></td>
		<td><b><font face="calibri">FECHA DE FACTURACION</b></td>
		<td><b><font face="calibri">FECHA ENTREGA DEL EQUIPO</b></td>
		<td><b><font face="calibri">AÑO FACTURACION</b></td>
		<td><b><font face="calibri">MES FACTURACION</b></td>
		<td><b><font face="calibri">AÑO ENTREGA</b></td>
		<td><b><font face="calibri">MES ENTREGA</b></td>
		<td><b><font face="calibri">UNIDADES</b></td>
		<td><b><font face="calibri">TIPO DE VENTA</b></td>
		<td><b><font face="calibri">EVENTO</b></td>
		<td><b><font face="calibri">TIPO DE CONTRACION</b></td>
		<td><b><font face="calibri">SISTEMA DE VENTA</b></td>
		<td><b><font face="calibri">DN</b></td>
		<td><b><font face="calibri">SEMANA PAGO</b></td>
		<td><b><font face="calibri">MEID/IMEID</b></td>		
		<td><b><font face="calibri">DIA ENTREGA</b></td>
		<td><b><font face="calibri">REG ID</b></td>
		<td><b><font face="calibri">ESTATUS AUDITORIA</b></td>
		<td><b><font face="calibri">ESTATUS VALIDACION PARA PAGO</b></td>
		<td><b><font face="calibri">CUENTA</b></td>
		<td><b><font face="calibri">FECHA DE BAJA</b></td>
		<td><b><font face="calibri">DIAS CON SERVICIO</b></td>
		<td><b><font face="calibri">OBSERVACIONES</b></td>		
	</tr>
	<?php
		$queryConsulta="SELECT LF.Contrato AS Contrato, HF.Folio AS Folio, R.Region AS Region, SR.SubRegion AS SubRegion, P.Plaza AS Plaza, PV.PuntoVenta AS PuntoVenta, CPV.ClasificacionPuntoVenta AS ClasificacionPuntoVenta, TP.TipoPunto AS TipoPunto, PV.Activo AS Activo, HF.FechaCaptura AS FechaCaptura, CONCAT(E.Nombre, ' ', E.Paterno, ' ', E.Materno) AS Coordinador, HPE.EmpleadoId AS EmpleadoId, Pue.Puesto AS Puesto, SC.SubCategoria, CONCAT(CL.Nombre, ' ', CL.Paterno, ' ', CL.Materno) AS Cliente, M.Marca AS Marca, Eq.Equipo AS Equipo, Pl.Plan AS Plan, Pl.Clave AS Clave, LF.Costo AS Costo, Plzo.Plazo AS Plazo, Es.Estatus AS Estatus, HF.FechaContrato, LF.FechaEstatus, TV.TipoVenta AS TipoVenta FROM LFolios AS LF INNER JOIN HFolios AS HF ON HF.Folio=LF.Folio INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=HF.PuntoVentaId INNER JOIN Plazas AS P ON P.PlazaId=PV.PlazaId INNER JOIN SubRegiones AS SR ON SR.SubRegionId=P.SubRegionId INNER JOIN Regiones AS R ON R.RegionId=SR.RegionId INNER JOIN ClasificacionPuntosVenta AS CPV ON CPV.ClasificacionPuntoVentaId=PV.ClasificacionPuntoVentaId INNER JOIN TipoPuntos AS TP ON TP.TipoPuntoId=PV.TipoPuntoId INNER JOIN HistorialPuestosEmpleados AS HPE ON HPE.HistorialPuestoEmpleadoId=HF.HistorialPuestoEmpleadoId INNER JOIN Empleados AS E ON E.EmpleadoId=HF.CoordinadorId INNER JOIN Puestos AS Pue ON Pue.PuestoId=HPE.PuestoId INNER JOIN SubCategorias AS SC ON SC.SubCategoriaId=HPE.SubCategoriaId INNER JOIN Clientes AS CL ON CL.ClienteId=HF.ClienteId INNER JOIN Equipos AS Eq ON Eq.EquipoId=LF.EquipoId INNER JOIN Marcas AS M ON M.MarcaId=Eq.MarcaId INNER JOIN Planes AS Pl ON Pl.PlanId=LF.PlanId INNER JOIN Plazos AS Plzo ON Plzo.PlazoId=LF.PlazoId INNER JOIN Estatus AS Es ON Es.EstatusId=LF.EstatusId INNER JOIN TiposVenta AS TV ON TV.TipoVentaId=HF.TipoVentaId WHERE HF.EnReporte=1 AND (FechaCaptura>'2017-12-31') AND LF.PlanId!=81 AND LF.PlanId!=255 AND HPE.FechaBaja='0000-00-00'";
		if($res=mysql_query($queryConsulta)){
		while($row=mysql_fetch_array($res)){
			$contrato=$row["Contrato"];
			$folioSiiga=$row["Folio"];
			$extractoFolio= ereg_replace("[a-zA-Z]","",$folioSiiga);
			$region=$row["Region"];
			$subRegion=$row["SubRegion"];
			$plaza=$row["Plaza"];
			$puntoVenta=$row["PuntoVenta"];
			$clasificacionPuntoVenta=$row["ClasificacionPuntoVenta"];
			$tipoPunto=$row["TipoPunto"];
			$coordinador=$row["Coordinador"];
			if($row["Activo"]==1){
				$estatus="Operando";
			}elseif($row["Activo"]==0){
				$estatus=="Cerrado";
			}
			$fechaCaptura=$row["FechaCaptura"];
			$empleadoId=$row["EmpleadoId"];
			$queryEmpleado="SELECT CONCAT(Nombre, ' ', Paterno, ' ', Materno) AS Empleado FROM Empleados WHERE EmpleadoId='$empleadoId'";
			if($resEmpleado=mysql_query($queryEmpleado)){
				$rowEmpleado=mysql_fetch_array($resEmpleado);
				$empleado=$rowEmpleado["Empleado"];
			}else{
				echo "Error al consultar".$queryEmpleado.mysql_error();
			}
			$puesto=$row["Puesto"];
			$subCategoria=$row["SubCategoria"];
			$cliente=$row["Cliente"];
			$marca=$row["Marca"];
			$equipo=$row["Equipo"];
			$plan=$row["Plan"];
			if($row["Clave"]=='ATT a tu manera'){
				$familia='A TU MANERA';
				$tipoPlan='MIXTO';
			}elseif($row['Clave']=='ATT con todo'){
				$familia='CON TODO';
				$tipoPlan='POSTPAGO TRADICIONAL';
			}elseif($row['Clave']=='ATT con todoNEG'){
				$familia='CON TODO NEG';
				$tipoPlan='POSTPAGO TRADICIONAL';
			}elseif($row['Clave']=='ATT damos más'){
				$familia='DAMOS MAS';
				$tipoPlan='MIXTO';
			}elseif($row['Clave']=='ATT Ya!'){
				$familia='YA';
				$tipoPlan='MIXTO';
			}elseif($row['Clave']=='AT&T INTERNET CON TODO'){
				$familia='CON TODO INTERNET';	
				$tipoPlan='POSTPAGO TRADICIONAL';
			}elseif($row['Clave']=='ATT Consiguelo'){
				$familia='ATT PLUS AVS';
				$tipoPlan='POSTAPAGO TRADICIONAL';
			}elseif($row['Clave']=='ATT UNIDOS PUENTE PRIP'){
				$familia='ATT UNIDOS PUENTE PRIP';
				$tipoPlan='MIXTO';
			}elseif($row['Clave']=='ATT Compartelo'){
				$familia='Compartelo';
				$tipoPlan='POSTPAGO TRADICIONAL';
			}
				$costo=$row["Costo"];
				$plazo=$row["Plazo"];
				$estatusFolio=$row["Estatus"];
				$fechaContrato=$row["FechaContrato"];
				$fechaEstatus=$row["FechaEstatus"];
				$tipoVenta=$row["TipoVenta"];
			?>
			<tr>
				<td><font face="calibri"><?php echo $contrato;?></td>	
				<td><font face="calibri"><?php echo $folioSiiga;?></td>
				<td><font face="calibri"><?php echo $extractoFolio;?></td>
				<td><font face="calibri"><?php echo $region;?></td>
				<td><font face="calibri"><?php echo $subRegion;?></td>
				<td><font face="calibri"><?php echo $plaza;?></td>
				<td><font face="calibri"><?php echo $puntoVenta;?></td>
				<td><font face="calibri"><?php echo $tipoPunto;?></td>
				<td><font face="calibri"><?php echo $clasificacionPuntoVenta;?></td>
				<td><font face="calibri"><?php echo $estatus;?></td>
				<td><font face="calibri"><?php echo $fechaCaptura;?></td>
				<td><font face="calibri"><?php echo $coordinador;?></td>
				<td><font face="calibri"><?php echo $empleado;?></td>
				<td><font face="calibri"><?php echo $puesto;?></td>
				<td><font face="calibri"><?php echo $subCategoria;?></td>
				<td><font face="calibri"><?php echo $cliente;?></td>
				<td><font face="calibri"><?php echo $marca;?></td>
				<td><font face="calibri"><?php echo $equipo;?></td>
				<td><font face="calibri"><?php echo $plan;?></td>
				<td></td>
				<td><font face="calibri"><?php echo $familia;?></td>
				<td><font face="calibri"><?php echo $tipoPlan;?></td>
				<td><font face="calibri"><?php echo $costo;?></td>
				<td><font face="calibri"><?php echo $costo-($costo*.16);?></td>
				<td><font face="calibri"><?php echo $plazo;?></td>
				<td><font face="calibri"><?php echo $estatusFolio;?></td>
				<td><font face="calibri"><?php echo $fechaContrato;?></td>
				<td><font face="calibri"><?php echo $fechaEstatus;?></td>
				<td><font face="calibri"><?php echo date("Y",strtotime($fechaContrato));?></td>
				<td><font face="calibri"><?php echo date("m",strtotime($fechaContrato));?></td>
				<td><font face="calibri"><?php echo  date("Y",strtotime($fechaEstatus));?></td>
				<td><font face="calibri"><?php echo  date("m",strtotime($fechaEstatus));?></td>
				<td>1</td>
				<td><font face="calibri"><?php echo  $tipoVenta;?></td>

				
			</tr>
			<?php
			
		}
			}else{
			echo "Error al consultar: ".$queryConsulta.mysql_error();
		}
	?>
</table>
