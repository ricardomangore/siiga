<?php
	include("conexion.php");
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	if($fechaInicio==''){
		echo '<script>
			alert("Error en fecha Inicio\nFavor de Ingresar una fecha valida");
			window.location.href="../recargas.php";
		</script>';
	}elseif($fechaFin==''){
		echo '<script>
			alert("Error en fecha Fin\nFavor de Ingresar una fecha valida");
			window.location.href="../recargas.php";
			</script>';
	}elseif($fechaFin<$fechaInicio){
			echo '<script>
			alert("Error en fecha Fin\nFavor de Ingresar una fecha mayor igual a la fecha inicio");
			window.location.href="../recargas.php";
			</script>';
	}else{
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=reporteRecarga.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	$condiciones="(T1.Fecha>='".$fechaInicio."' AND T1.Fecha<='".$fechaFin."')";
	$query="SELECT T1.Folio AS Folio, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha,  T7.Region AS Region, T6.SubRegion AS SubRegion, T5.Plaza AS Plaza, T4.Puntoventa AS PuntoVenta, T1.NTel AS NTel, T3.MontoRecarga AS MontoRecarga,
       CONCAT_WS(' ', T9.Nombre, T9.Paterno, T9.Materno) AS Vendedor, CONCAT_WS(' ', T10.Nombre, T10.Paterno, T10.Materno) AS Coordinador,
       T1.Comentario AS Comentario, T11.Serie AS Serie, T1.NTelP AS NTelP, T1.nip AS Nip, CONCAT_WS(' ', T1.nombre, T1.paterno, T1.materno) AS NombreContacto, T1.telContacto AS TelContacto
FROM Recargas AS T1
LEFT JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
LEFT JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
LEFT JOIN PuntosVenta AS T4 ON T4.PuntoventaId=T1.PuntoVentaId
LEFT JOIN Plazas AS T5 ON T5.PlazaId=T4.PlazaId
LEFT JOIN SubRegiones AS T6 ON T6.SubRegionId=T5.SubRegionId
LEFT JOIN Regiones AS T7 ON T7.RegionId=T6.RegionId
LEFT JOIN HistorialPuestosEmpleados AS T8 ON T8.HistorialPuestoEmpleadoId=T1.VendedorId
LEFT JOIN Empleados AS T9 ON T9.EmpleadoId=T8.EmpleadoId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T1.CoordinadorId
LEFT JOIN LFolios AS T11 ON T11.Folio=T1.Folio AND EstatusId=14
WHERE $condiciones ORDER BY T1.Fecha";
	//echo "$condiciones";
	if($res=mysql_query($query)){
		$i=0;
		echo "<table border='0'>
				<tr style='background: #00ABE2; color: #FFFFFF'>
					<td><b><font face='arial black'>Folio</font></b></td>
					<td><b><font face='arial'>FechaCaptura</font></b></td>
					<td><b><font face='arial'>Region</font></b></td>
					<td><b><font face='arial'>SubRegion</font></b></td>
					<td><b><font face='arial'>Plaza</font></b></td>
					<td><b><font face='arial'>Punto de Venta</font></b></td>
					<td><b><font face='arial'>Numero Telefonico</font></b></td>
					<td><b><font face='arial'>Monto Recarga</font></b></td>
					<td><b><font face='arial'>Vendedor</font></b></td>
					<td><b><font face='arial'>Coordinador</font></b></td>
					<td><b><font face='arial'>Comentario</font></b></td>
					<td><b><font face='arial'>Serie</font></b></td>
					<td><b><font face='arial'>Numero Portabilidad</font></b></td>
					<td><b><font face='arial'>Nip</font></b></td>
					<td><b><font face='arial'>Nombre Contacto</font></b></td>
					<td><b><font face='arial'>Telefono Contacto</font></b></td>				
					<td><b><font face='arial'>Tipo Venta</font></b></td>	
				</tr>
				
		
		";
		$con=0;
		while($row=mysql_fetch_array($res)){
			$folio=$row["Folio"];
            $serie=$row["Serie"];
            $ntelp=$row["NTelP"];
            $nip=$row["Nip"];
			if(($row["Serie"]) && ($row["NTelP"]!='') && ($row["Nip"]!='')){
				$tipoVenta="Portabilidad";
			}elseif($serie!='' && $row["NTelP"]=='' && $row["Nip"]==''){
				$tipoVenta="Activacion de Sim";
			}elseif($serie==''){
				$tipoVenta="Recarga";
			}
			
			if($con%2==1){
				$tr="<tr style='background: #DFF8FF; color: #000000'>";
			}else{
				$tr="<tr>";
			}
			$con++;
			echo "
			$tr
					<td><font face='arial'>".$row["Folio"]."</font></td>
					<td><font face='arial'>".$row["Fecha"]."</font></td>
					<td><font face='arial'>".$row["Region"]."</font></td>
					<td><font face='arial'>".$row["SubRegion"]."</font></td>
					<td><font face='arial'>".$row["Plaza"]."</font></td>
					<td><font face='arial'>".$row["PuntoVenta"]."</font></td>
					<td><font face='arial'>".$row["NTel"]."</font></td>
					<td><font face='arial'>".$row["MontoRecarga"]."</font></td>
					<td><font face='arial'>".$row["Vendedor"]."</font></td>
					<td><font face='arial'>".$row["Coordinador"]."</font></td>
					<td><font face='arial'>".$row["Comentario"]."</font></td>
					<td><font face='arial'>".$serie."</font></td>
					<td><font face='arial'>".$row["NTelP"]."</font></td>
					<td><font face='arial'>".$row["Nip"]."</font></td>
					<td><font face='arial'>".$row["NombreContacto"]."</font></td>
					<td><font face='arial'>".$row["TelContacto"]."</font></td>
					<td><font face='arial'>".$tipoVenta."</font></td>
				</tr>
			
			";
			
		}
		echo "</table>";
	}else{
		echo "error: ".mysql_error();
	}

	}
?>