<?php
	include("conexion.php");
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=reportePedido.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$fechaInicial='';
	$fechaInicial='';
	$semana='';
	$plataforma='';
	$condiciones='';
	$condiciones2='';
	$fechaInicial=$_POST["fechaInicial"];
	$fechaFin=$_POST["fechaFin"];
	$semana=$_POST["semana"];
	$plataforma=$_POST["plataforma"];
	$consulta="";
	$bandFecha=0;
	if($fechaInicial!=''){
		if($fechaFin!=''){
			$bandFecha=1;
		}
	}elseif($fechaInicial=='' && $fechaFin==''){
		$bandFecha=2;
	}
	if($bandFecha==1){
		if($fechaInicial<=$fechaFin){
			$fechaInicial=strtotime('-1 day', strtotime($fechaInicial));
			$fechaInicial= date('Y-m-j', $fechaInicial);
			$fechaFin=strtotime('+1 day', strtotime($fechaFin));
			$fechaFin= date('Y-m-j', $fechaFin);
			$condiciones=" AND (Fecha>'$fechaInicial' AND Fecha<'$fechaFin') AND Estatus!='Cancelado'";
			$condiciones2=" AND (OP.Fecha>'$fechaInicial' AND OP.Fecha<'$fechaFin') AND Estatus!='Cancelado'";
		}else{
			
		}
	}
	if($semana!=('-- Seleccionar Semana --')){
		$condiciones=$condiciones." AND Semana='$semana'";
		$condiciones2=$condiciones." AND OP.Semana='$semana'";
	}

	if($plataforma!=('--Selecciona Plataforma--')){
		$condiciones=$condiciones.' AND Plataforma="'.$plataforma.'"';
		$condiciones2=$condiciones." AND OP.Plataforma='$plataforma'";
	}

	//echo $fechaInicial.$fechaFin.$semana.$plataforma;
	$query="SELECT Equipos FROM OrdenPedido WHERE Activo=1 $condiciones";
	if($res=mysql_query($query)){
		$equipos=explode(",",$resultados["Equipos"]);
		$cantidad=mysql_num_rows($res);
		//echo "Cantidad de Resultados : ".$cantidad."<br>";
		$equiposUnicos;
		for($i=0;$i<200;$i++){
			$equiposUnicos[$i]=0;
		}
		$cont=0;
		while($row=mysql_fetch_array($res)){
			$equipos=explode(",",$row["Equipos"]);
			$tam=count($equipos);
			for($i=0;$i<$tam;$i++){
				$equipos2=explode("-",$equipos[$i]);
				//echo $equipos2[0]."<br>";
				$equiposUnicos[$cont]=$equipos2[0];
				$cont++;
			}
		}
		$cont2=0;
		for($i=0;$i<$cont;$i++){
			if($equiposUnicos[$i]!=''){
				$cont2++;
				//echo $equiposUnicos[$i]."<br>";
			}
			
		}
		$equiposUnicos2=array_values(array_unique($equiposUnicos));
		//print_r($equiposUnicos2);
		$tamFinal=count($equiposUnicos2);
		?>
		<table>
		<tr style="background: #A5A5A5">
		<td align="center"><font face="calibri" size="2"><b>Dealear</b></font></td>	
			<td align="center"><font face="calibri" size="2"><b>PDV</b></font></td>	
			<td align="center"><font face="calibri" size="2"><b>Tienda</b></font></td>
			<td align="center"><font face="calibri" size="2"><b>Clasificacion</b></font></td>
			<td align="center"><font face="calibri" size="2"><b>Plataforma</b></font></td>
			<td align="center"><font face="calibri" size="2"><b>Semana</b></font></td>
		
		
		<?php
		for($i=0;$i<$tamFinal-1;$i++){
			if($equiposUnicos2[$i]!=0){
				//echo $equiposUnicos2[$i].",";
				$query="SELECT NombreConsigna, EquipoId FROM Equipos WHERE EquipoId='$equiposUnicos2[$i]'";
				$res=mysql_fetch_array(mysql_query($query));
				//echo "<td>".$res["EquipoId"]."</td>";	
				echo "<td align='center'><font face='calibri' size='2'><b>".$res["NombreConsigna"]."</font></td>";	
			}
			
		}
		?>
			<td align="center"><font face="calibri" size="2"><b>Total Equipos</font></b></td>
		</tr>

	
			<?php
					$queryPunto="SELECT OP.Plataforma AS Plataforma, OP.Semana AS Semana, PA.SubInventario AS SubInventario, PA.NombreATT AS NombreATT, OP.Equipos AS Equipos, CP.ClasificacionPersonalVenta AS ClasificacionPersonalVenta FROM OrdenPedido AS OP INNER JOIN PuntosATT AS PA ON OP.PuntoVentaId=PA.PuntoVentaId INNER JOIN PuntosVenta AS PV ON OP.PuntoVentaId=PV.PuntoVentaId INNER JOIN ClasificacionPersonalVenta AS CP ON CP.ClasificacionPersonalVentaId=PV.ClasificacionPersonalVenta WHERE OP.Activo=1 $condiciones2 ORDER BY PA.SubInventario ASC";
					//$queryPunto="SELECT PV.PuntoVenta AS PuntoVenta, OP.Folio AS Folio FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON OP.PuntoVentaId=PV.PuntoVentaId WHERE OP.Activo=1";
					if($res=mysql_query($queryPunto)){
						while($rowPunto=mysql_fetch_array($res)){
							$totalEquipos=0;
							echo "<tr>";
							echo "<td align='center'><font face='calibri' size='2'><b>EXPERT CELL SA DE CV</b></font></td>";
							echo "<td align='center'><font face='calibri' size='2'><b>".$rowPunto["SubInventario"]."</b></font></td>";
							echo "<td><font face='calibri' size='2'><b>".$rowPunto["NombreATT"]."</b></font></td>";
							echo "<td><font face='calibri' size='2'><b>".$rowPunto["ClasificacionPersonalVenta"]."</b></font></td>";
							echo "<td align='center'><font face='calibri' size='2'><b>".$rowPunto["Plataforma"]."</b></font></td>";
							echo "<td align='center'><font face='calibri' size='2'><b>".$rowPunto["Semana"]."</b></font></td>";
							$equipos=$rowPunto["Equipos"];
							$contAux=0;
							$band=0;
							for($i=0;$i<$tamFinal-1;$i++){
								$cantidadEquipos=0;
								if($equiposUnicos2[$i]!=0){
									$equiposAux=explode(",",$equipos);
									$tamAux=count($equiposAux);
									for($j=0;$j<$tamAux;$j++){
										$equipoSolo=explode("-",$equiposAux[$j]);
										if($equipoSolo[0]==$equiposUnicos2[$i]){
											$cantidadEquipos=$equipoSolo[1];
											$totalEquipos=$totalEquipos+$cantidadEquipos;
										}
									}
										if($cantidadEquipos!=0){
										echo "<td align='center'>".$cantidadEquipos."</td>";
									}elseif($cantidadEquipos==0){
										echo "<td align='center'>0</td>";
									}
									}
									
							}
							echo "<td>".$totalEquipos."</td>";
							echo "</tr>";
						}
					}else{
						echo "Error al consultar";
					}
?>
		</table>
		<?php
	}else{
		echo "error : ".$query.mysql_error();
	}

?>