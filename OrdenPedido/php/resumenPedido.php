<?php
	include("conexion.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=resumenPedido.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$semana=$_POST["semana"];
	if($semana!='-- Seleccionar Semana --'){
		$filtros='AND Semana='.$semana;
		$semanaTitulo=$semana;
	}else{
		$filtros='';
		$semanaTitulo="General";
	}
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
		<th colspan="10" style="background: #000000; color: #FFFFFF;"><font face="helvetica"> Resumen de Pedidos Semana: <?php echo $semanaTitulo; ?> </font></th>
	</tr>
	<tr>
		<td>Semana</td>
		<td>Organizaci&oacute;n</td>
		<td>Dealer</td>
		<td>Sub Inventario</td>
		<td>NombrePDV</td>
		<td>Codigo Equipo</td>
		<td>Cantidad Solicitados</td>
		<td>Cantidad Autorizada</td>
		<td>Surtido ATT</td>
	</tr>
	
	
	<?php
	$query="SELECT OrdenPedidoId, PuntoVentaId, EquiposInicial, Equipos, EquiposFinal, PuntoVentaId, Semana FROM OrdenPedido WHERE Activo=1 AND Estatus!='Cancelado' $filtros";
	//echo $query;
	if($resEquipos=mysql_query($query)){
		while($row=mysql_fetch_array($resEquipos)){
			$pedidoId=$row["OrdenPedidoId"];
		    $semanaAux=$row["Semana"];
			$equipos=explode(",",$row["EquiposInicial"]);
			$equiposAutorizados=explode(",",$row["Equipos"]);
			$equiposFinal=explode(",",$row["EquiposFinal"]);
			$puntoId=$row["PuntoVentaId"];
			$tam=count($equipos);
			$tamAutorizado=count($equiposAutorizados);
			$tamFin=count($equiposFinal);
			//echo "<br>equipos: ".$row["Equipos"]."<br>";
			for($i=0;$i<($tam-1);$i++){
				$band=0;
				$band2=0;
				$equiposAux=explode("-",$equipos[$i]);
				for($j=0;$j<($tamAutorizado-1);$j++){
					$equipoAutorizadoAux=explode("-",$equiposAutorizados[$j]);
					if($equiposAux[0]==$equipoAutorizadoAux[0]){
						$cantidadAutorizado=$equipoAutorizadoAux[1];
						$band=1;
						
					}
				}
				for($k=0;$k<($tamFin-1);$k++){
					$equipoFinAux=explode("-",$equiposFinal[$k]);
					if($equiposAux[0]==$equipoFinAux[0]){
						$cantidadFinal=$equipoFinAux[1];
						$band2=1;
					}
				}
				if($band==0){
					$cantidadAutorizado=0;
				}
				if($band2==0){
					$cantidadFinal=0;
				}
				
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
						
					}else{
						echo "Error al consultar: ".$queryPuntos.mysql_error();
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
						<td><?php echo $cantidadAutorizado;?></td>
						<td><?php echo $cantidadFinal;?></td>
					</tr>
					<?php
					//echo "Equipo: ".$rowEquipos["NombreConsigna"]." Cantidad: ".$equiposAux[1]."<br>";
					
				}
			}
			$queryTipoEquipo="SELECT * FROM EquiposPedido WHERE OrdenPedido=$pedidoId AND TipoEquipo=1";
			if($resTipoEquipo=mysql_query($queryTipoEquipo)){
				while($rowTipoEquipo=mysql_fetch_array($resTipoEquipo)){
					$tipoEquipoId=$rowTipoEquipo["EquipoId"];
					$cantidadTipoEquipo=$rowTipoEquipo["Cantidad"];
					$band2=0;
					
					for($l=0;$l<($tamFin-1);$l++){
						$equipoFinAux=explode("-",$equiposFinal[$l]);
						if($tipoEquipoId==$equipoFinAux[0]){
							$cantidadFinal=$equipoFinAux[1];
							$band2=1;
						}
					}
					if($band2==0){
						$cantidadFinal=0;
					}
					$queryEquiposAux="SELECT NombreConsigna FROM Equipos WHERE EquipoId=$tipoEquipoId";
					if($resEquiposAux=mysql_query($queryEquiposAux)){
						$rowEquiposAux=mysql_fetch_array($resEquiposAux);
						
					}
					
					
					
					
					?>
					<tr>
					    <td><?php echo $semanaAux;?></td>
						<td><?php echo $organizacion; ?></td>
						<td>Expert Cell S.A. de C.V.</td>
						<td><?php echo $subInventario; ?></td>
						<td><?php echo $nombreATT;?></td>
						<td><?php echo $rowEquiposAux["NombreConsigna"]; ?></td>
						<td><?php echo "0";?></td>
						<td><?php echo $cantidadTipoEquipo;?></td>
						<td><?php echo $cantidadFinal;?></td>
					</tr>
					
					
					<?php
					
				}
			}
			$queryTipoEquipoFin="SELECT * FROM EquiposPedido WHERE OrdenPedido=$pedidoId AND TipoEquipo=2";
				if($resTipoEquipo=mysql_query($queryTipoEquipoFin)){
				while($rowTipoEquipo=mysql_fetch_array($resTipoEquipo)){
					$tipoEquipoId=$rowTipoEquipo["EquipoId"];
					$cantidadTipoEquipo=$rowTipoEquipo["Cantidad"];
					$queryEquiposAux="SELECT NombreConsigna FROM Equipos WHERE EquipoId=$tipoEquipoId";
					if($resEquiposAux=mysql_query($queryEquiposAux)){
						$rowEquiposAux=mysql_fetch_array($resEquiposAux);
						
					}
					
					
					
					
					?>
					<tr>
					    <td><?php echo $semanaAux;?></td>
						<td><?php echo $organizacion; ?></td>
						<td>Expert Cell S.A. de C.V.</td>
						<td><?php echo $subInventario; ?></td>
						<td><?php echo $nombreATT;?></td>
						<td><?php echo $rowEquiposAux["NombreConsigna"]; ?></td>
						<td><?php echo "0";?></td>
						<td><?php echo "0";?></td>
						<td><?php echo $cantidadTipoEquipo;?></td>
					</tr>
					
					
					<?php
					
				}
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
		}
	}else{
		echo "error".$query.mysql_error();
	}

?>
</table>