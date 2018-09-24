<?php
	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");
	include("includes/Menu.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=reporteInventario.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	
	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);
	$empleadoId=$Herramientas->getEmpleadoId();
	$misPuntos=$Herramientas->getMisPuntos2();
//	echo $misPuntos;
	$puntosAux=explode(",",$misPuntos);
	//echo $puntosAux[0]." Hola ".$puntosAux[1];
	echo '
	<table border="1"> 
		<tr>
			<td style="background: #000000;Color: #FFFFFF;">Canal Operativo</td>
			<td style="background: #000000;Color: #FFFFFF;">Fecha</td>
			<td style="background: #000000;Color: #FFFFFF;">Region</td>
			<td style="background: #000000;Color: #FFFFFF;">SubRegion</td>
			<td style="background: #000000;Color: #FFFFFF;">Sucursal</td>
			<td style="background: #000000;Color: #FFFFFF;">Clasificacion</td>
			<td style="background: #000000;Color: #FFFFFF;">TipoDePunto</td>
			<td style="background: #000000;Color: #FFFFFF;">Estatus</td>
			<td style="background: #000000;Color: #FFFFFF;">PuntoVenta</td>
			<td style="background: #000000;Color: #FFFFFF;">Factura</td>
			<td style="background: #000000;Color: #FFFFFF;">SKU</td>
			<td style="background: #000000;Color: #FFFFFF;">Marca</td>
			<td style="background: #000000;Color: #FFFFFF;">Equipo</td>
			<td style="background: #000000;Color: #FFFFFF;">Serie</td>
			<td style="background: #000000;Color: #FFFFFF;">SIM</td>
			<td style="background: #000000;Color: #FFFFFF;">Cantidad</td>
			<td style="background: #000000;Color: #FFFFFF;">Costo</td>
			<td style="background: #000000;Color: #FFFFFF;">Precio</td>
			<td style="background: #000000;Color: #FFFFFF;">Almacen</td>
			<td style="background: #000000;Color: #FFFFFF;">Plataforma</td>
		</tr>
	';
	$Q0="SELECT Region, SubRegion,Plaza,PuntoVenta,T5.ClasificacionPersonalVenta,TipoPunto FROM Regiones AS T1 INNER JOIN SubRegiones AS T2 ON T1.RegionId=T2.RegionId INNER JOIN Plazas AS T3 ON T2.SubRegionId=T3.SubRegionId INNER JOIN PuntosVenta AS T4 ON T3.PlazaId=T4.PlazaId INNER JOIN ClasificacionPersonalVenta AS T5 ON T4.ClasificacionPersonalVenta=T5.ClasificacionPersonalVentaId INNER JOIN TipoPuntos AS T6 ON T4.TipoPuntoId=T6.TipoPuntoId  WHERE T4.PuntoVentaId IN ($misPuntos)";
	if($res0=mysql_query($Q0)){
		$row0=mysql_fetch_array($res0);
		//echo $row0[0].$row0[1].$row0[2].$row0[3].$row0[4].$row0[5].$row0[6]."<br><br>";
		$Region=$row0[0];
		$SubRegion=$row0[1];
		$Plaza=$row0[2];
		$PuntoVenta=$row0[3];
		$CanalOperativo=$row0[4];
		$TipoPunto=$row0[5];

	}else{
		echo "error al consultar: ".$Q0.mysql_error();
	}

	$Q1="SELECT CONCAT('\'',T2.Serie), T3.Factura, T2.EquipoId, Equipo, Marca,CONCAT('\'',Sim),Costo,Iva,Almacen, Plataforma,FechaFactura, TipoMovimientoId FROM Recepciones AS T1 INNER JOIN Inventario AS T2 ON T1.MovimientoId=T2.MovimientoId INNER JOIN OrdenesCompra AS T3 ON T2.Serie=T3.Serie INNER JOIN Equipos AS T4 ON T4.EquipoId=T2.EquipoId INNER JOIN Marcas AS T5 ON T4.MarcaId=T5.MarcaId INNER JOIN Almacenes AS  T6 ON T2.AlmacenId=T6.AlmacenId INNER JOIN Plataformas AS T7 ON T2.PlataformaId=T7.PlataformaId WHERE T2.Cantidad=1 AND T1.PuntoVentaId IN ($misPuntos) ORDER BY T2.Serie";
	if($res1=mysql_query($Q1)){
		while ($row=mysql_fetch_array($res1)) {
			if($row[4]=="SIMCARD"){
				$tipoEquipo="SIM";
			}else{
				$tipoEquipo="Equipo";
			}
			$precio=$row[6]+$row[7];
			if($row[11]==15){
				$almacen="Demos";
			}else{
				$almacen="Almacen";
			}


			echo '
				<tr>
					<td>'.$CanalOperativo.'</td>
					<td>'.$row[10].'</td>
					<td>'.$Region.'</td>
					<td>'.$SubRegion.'</td>
					<td>'.$Plaza.'</td>
					<td>'.$tipoEquipo.'</td>
					<td>'.$TipoPunto.'</td>
					<td>'.$almacen.'</td>
					<td>'.$PuntoVenta.'</td>
					<td>'.$row[1].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[3].'</td>
					<td>'.$row[4].'</td>
					<td>'.$row[0].'</td>
					<td>'.$row[5].'</td>
					<td>1</td>
					<td>'.$row[6].'</td>
					<td>'.$precio.'</td>
					<td>'.$row[8].'</td>
					<td>'.$row[9].'</td>

				</tr>


			';
			//echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]." ".$row[6]."<br>";
		}
	}else{
		echo "Error al consultar: ".$Q1.mysql_error();
	}
	//echo "<br>Series por Recibir<br>";
	$Q2="SELECT FechaFactura,Marca,Factura, EquipoId, Marca,Equipo,CONCAT('\'',Serie),CONCAT('\''Sim),Costo,Iva,Almacen,Plataforma FROM OrdenesCompra AS T1 INNER JOIN Equipos AS T2 ON T1.EquipoId=T2.EquipoId INNER JOIN Marcas AS T3 ON T2.MarcaId=T3.MarcaId INNER JOIN Plataformas AS T4 ON T4.PlataformaId=T1.PlataformaId INNER JOIN Almacenes AS T5 ON T5.AlmacenId=T1.AlmacenId WHERE Recibido=0 AND PuntoVentaId IN ($misPuntos) ORDER BY Serie";
	if($res2=mysql_query($Q2)){
		while ($row2=mysql_fetch_array($res2)) {
					if($row2[1]=="SIMCARD"){
				$tipoEquipo="SIM";
			}else{
				$tipoEquipo="Equipo";
			}
			$precio=$row[8]+$row[9];

			echo '
				<tr>
					<td>'.$CanalOperativo.'</td>
					<td>'.$row2[0].'</td>
					<td>'.$Region.'</td>
					<td>'.$SubRegion.'</td>
					<td>'.$Plaza.'</td>
					<td>'.$tipoEquipo.'</td>
					<td>'.$TipoPunto.'</td>
					<td>Por Recibir</td>
					<td>'.$PuntoVenta.'</td>
					<td>'.$row2[2].'</td>
					<td>'.$row2[3].'</td>
					<td>'.$row2[4].'</td>
					<td>'.$row2[5].'</td>
					<td>'.$row2[6].'</td>
					<td>'.$row2[7].'</td>
					<td>1</td>
					<td>'.$row2[8].'</td>
					<td>'.$precio.'</td>
					<td>'.$row2[9].'</td>
					<td>'.$row2[10].'</td>

				</tr>


			';	


























		}
	}

//	echo "<br>En Traspaso<br>";
	//$Q3="SELECT Serie FROM TRSalidas AS T1 INNER JOIN Inventario AS T2 ON T1.MovimientoId=T2.MovimientoId WHERE T2.Cantidad=1 AND (T1.PuntoVentaIdO IN ($misPuntos) OR T1.PuntoVentaIdD IN ($misPuntos)) ORDER BY T2.Serie";

	$Q3="SELECT CONCAT('\'',T2.Serie), T3.Factura, T2.EquipoId, Equipo, Marca,CONCAT('\'',Sim),Costo,Iva,Almacen, Plataforma,FechaFactura,PuntoVentaIdO,PuntoVentaIdD FROM TRSalidas AS T1 INNER JOIN Inventario AS T2 ON T1.MovimientoId=T2.MovimientoId INNER JOIN OrdenesCompra AS T3 ON T2.Serie=T3.Serie INNER JOIN Equipos AS T4 ON T4.EquipoId=T2.EquipoId INNER JOIN Marcas AS T5 ON T4.MarcaId=T5.MarcaId INNER JOIN Almacenes AS  T6 ON T2.AlmacenId=T6.AlmacenId INNER JOIN Plataformas AS T7 ON T2.PlataformaId=T7.PlataformaId WHERE T2.Cantidad=1 AND (T1.PuntoVentaIdO IN ($misPuntos) OR T1.PuntoVentaIdD IN ($misPuntos))  ORDER BY T2.Serie";

		if($res3=mysql_query($Q3)){
		while ($row3=mysql_fetch_array($res3)) {
			if($row3[4]=="SIMCARD"){
				$tipoEquipo="SIM";
			}else{
				$tipoEquipo="Equipo";
			}
			$sprecio=$row3[6]+$row3[7];
			if($row3[11]==$puntosAux[0] || $row3[11]==$puntosAux[1]){
				$concepto="Traspaso Salida";
			}else{
				$concepto="Traspaso Entrada";
			}
			echo '
				<tr>
					<td>'.$CanalOperativo.'</td>
					<td>'.$row3[10].'</td>
					<td>'.$Region.'</td>
					<td>'.$SubRegion.'</td>
					<td>'.$Plaza.'</td>
					<td>'.$tipoEquipo.'</td>
					<td>'.$TipoPunto.'</td>
					<td>'.$concepto.'</td>
					<td>'.$PuntoVenta.'</td>
					<td>'.$row3[1].'</td>
					<td>'.$row3[2].'</td>
					<td>'.$row3[3].'</td>
					<td>'.$row3[4].'</td>
					<td>'.$row3[0].'</td>
					<td>'.$row3[5].'</td>
					<td>1</td>
					<td>'.$row3[6].'</td>
					<td>'.$precio.'</td>
					<td>'.$row3[8].'</td>
					<td>'.$row3[9].'</td>

				</tr>


			';
			//echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]." ".$row[6]."<br>";
		}
	}else{
		echo "Error al consultar: ".$Q3.mysql_error();
	}


	/*if($res3=mysql_query($Q3)){
		while ($row3=mysql_fetch_array($res3)) {
			echo $row3[0]."<br>";
		}
	}else{
		echo "Error al consultar: ".$Q3.mysql_error();
	}*/

	echo '</table>';