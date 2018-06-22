<?php
include("conexion.php");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteDepositos.xls");
header("Pragma: no-cache");
header("Expires: 0");
//obtenemos el archivo .csv
$fecha=date("Y-m-d");
 echo '<table>
 		<tr align="center" valign="middle">
 			<th colspan="2" style="background: #000000;  color: #FFFFFF;">Validacion de Depositos por Punto de Venta</th>
 		</tr>
 		<tr>
 			<td style="background: #000000;  color: #FFFFFF;">Punto de Venta</td>
 			<td style="background: #000000;  color: #FFFFFF;">Estatus</td>
 		</tr>';
		
		$Q0="SELECT PV.PuntoVentaId, PV.PuntoVenta FROM PuntosVenta AS PV  WHERE PV.Activo=1 AND PV.TipoPuntoId!=3 AND PV.PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,534)";
		
		//$Q0="SELECT PV.PuntoVentaId, PV.PuntoVenta,PT.NombreATT FROM PuntosVenta AS PV INNER JOIN PuntosATT AS PT ON PV.PuntoVentaId=PT.PuntoVentaId WHERE PV.Activo=1 AND PV.TipoPuntoId!=3 AND (PV.PuntoVentaId!=1 OR PV.PuntoVentaId!=13 OR PV.PuntoVentaId!=51 OR PV.PuntoVentaId!=55 OR PV.PuntoVentaId!=57 OR PV.PuntoVentaId!=69 OR PV.PuntoVentaId!=75 OR PV.PuntoVentaId!=78 OR PV.PuntoVentaId!=83 OR PV.PuntoVentaId!=228 OR PV.PuntoVentaId!=357 OR PV.PuntoVentaId!=358 OR PV.PuntoVentaId!=359 OR PV.PuntoVentaId!=360 OR PV.PuntoVentaId!=361 OR PV.PuntoVentaId!=375 OR PV.PuntoVentaId!=380 OR PV.PuntoVentaId!=384 OR PV.PuntoVentaId!=388 OR PV.PuntoVentaId!=389 OR PV.PuntoVentaId!=394 OR PV.PuntoVentaId!=395 OR PV.PuntoVentaId!=396 OR PV.PuntoVentaId!=397 OR PV.PuntoVentaId!=415 OR PV.PuntoVentaId!=417 OR PV.PuntoVentaId!=451 OR PV.PuntoVentaId!=456 OR PV.PuntoVentaId!=465 OR PV.PuntoVentaId!=468 OR PV.PuntoVentaId!=469 OR PV.PuntoVentaId!=470 OR PV.PuntoVentaId!=471 OR PV.PuntoVentaId!=472 OR PV.PuntoVentaId!=473 OR PV.PuntoVentaId!=474 OR PV.PuntoVentaId!=497 OR PV.PuntoVentaId!=506 OR PV.PuntoVentaId!=507 OR PV.PuntoVentaId!=508 OR PV.PuntoVentaId!=510)";
		if($res0=mysql_query($Q0)){
			while ($row0=mysql_fetch_array($res0)){
				$Q1="SELECT PuntoVentaId FROM Depositos WHERE PuntoVentaId=$row0[0] AND Fecha='$fecha' AND TipoDepositoId=9";
				if($res1=mysql_query($Q1)){
					if(mysql_num_rows($res1)>0){
						echo "<tr><td>".$row0["PuntoVenta"]."</td><td>Realizo Deposito</td></tr>";
					}else{
						echo "<tr><td>".$row0["PuntoVenta"]."</td><td>Pendiente</td></tr>";
					}
				}
			}
		}
echo '</table>';
?>