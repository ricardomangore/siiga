<?php
	include("conexion.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=reporteEquiposInicial.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$semana='';
	/*$plataforma='';
	$filtros='';
	$semana=$_POST["semana"];
	$plataforma=$_POST["plataforma"];
	if($semana!='-- Seleccionar Semana --'){
		$filtros='Semana='.$semana;
	}else{
		$filtros='';
	}
	if($plataforma!='--Selecciona Plataforma--'){
		$filtros=$filtros." AND Plataforma='".$plataforma."'";
	}else{
		$filtros=$filtros;
	}
	if($filtros==''){
		$filtros="Estatus!='Cancelado' AND Activo=1";
	}else{
		$filtros=$filtros." AND Estatus!='Cancelado' AND Activo=1";
	}*/
	?>
	<table border="1">
	<tr align="center">
		<th colspan="7" style="background: #000000; color: #FFFFFF;"><font face="helvetica"> Equipos Inicial Solicitados  <?php echo $semana; ?> </font></th>
	</tr>
	<tr>
		<td>Semana</td>
		<td>Organizaci&oacute;n</td>
		<td>Dealer</td>
		<td>Sub Inventario</td>
		<td>NombrePDV</td>
		<td>Codigo Equipo</td>
		<td>Cantidad Sugerida</td>
	</tr>
	
	
	<?php
	$query="SELECT PuntoVentaId, EquiposInicial, PuntoVentaId, Semana FROM OrdenPedido WHERE (Semana>4 AND Semana<8) AND Activo=1 AND Estatus!='Cancelado' ORDER BY Semana";
	//echo $query;
	if($resEquipos=mysql_query($query)){
		while($row=mysql_fetch_array($resEquipos)){
		    $semanaAux=$row["Semana"];
			$equipos=explode(",",$row["EquiposInicial"]);
			$puntoId=$row["PuntoVentaId"];
			$tam=count($equipos);
			//echo "<br>equipos: ".$row["Equipos"]."<br>";
			for($i=0;$i<($tam-1);$i++){
				$equiposAux=explode("-",$equipos[$i]);
				//echo "Equipo: ".$equiposAux[0]." Cantidad: ".$equiposAux[1]."<br>";
				$queryEquipos="SELECT NombreConsigna FROM Equipos WHERE EquipoId=$equiposAux[0]";
				if($resEquiposFin=mysql_query($queryEquipos)){
					$rowEquipos=mysql_fetch_array($resEquiposFin);
					$queryPuntos="SELECT * FROM PuntosATT WHERE PuntoVentaId=$puntoId AND Activo=1";
					if($resPuntos=mysql_query($queryPuntos)){
						$rowPuntos=mysql_fetch_array($resPuntos);
						$organizacion=$rowPuntos["Organizacion"];
						$nombreATT=$rowPuntos["NombreATT"];
						$subInventario=$rowPuntos["SubInventario"];
					}
					?>
					<tr>
					    <td><?php echo $semanaAux;?></td>
						<td><?php echo $organizacion; ?></td>
						<td>Expert Cell S.A. de C.V.</td>
						<td><?php echo $subInventario; ?></td>
						<td><?php echo $nombreATT;?></td>
						<td><?php echo $rowEquipos["NombreConsigna"]; ?></td>
						<td><?php echo $equiposAux[1];?></td>
					</tr>
					<?php
					//echo "Equipo: ".$rowEquipos["NombreConsigna"]." Cantidad: ".$equiposAux[1]."<br>";
					
				}
			}
		}
	}else{
		echo "error".$query.mysql_error();
	}

?>
</table>