<?php
include("conexion.php");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteCortes.xls");
header("Pragma: no-cache");
header("Expires: 0");
//obtenemos el archivo .csv






 echo '<table>
 		<tr align="center" valign="middle">
 			<th colspan="2">Validacion de Cortes por Punto de Venta</th>
 		</tr>
 		<tr>
 			<td style="background: #000000;  color: #FFFFFF;">Punto de Venta</td>
 			<td style="background: #000000;  color: #FFFFFF;">Estatus</td>
 		</tr>';
		//$Q0="SELECT PV.PuntoVentaId, PV.PuntoVenta,PT.NombreATT FROM PuntosVenta AS PV INNER JOIN PuntosATT AS PT ON PV.PuntoVentaId=PT.PuntoVentaId WHERE PV.Activo=1 AND PV.TipoPuntoId!=3 AND PV.PuntoVentaId!=1";
		
		
		$Q0="SELECT PV.PuntoVentaId, PV.PuntoVenta FROM PuntosVenta AS PV  WHERE PV.Activo=1 AND PV.TipoPuntoId!=3 AND PV.PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,534)";
		if($res0=mysql_query($Q0)){
			while ($row0=mysql_fetch_array($res0)){
				if((date('w')==0) || (date('w')==6) || (date('w')==5)){
					$fecha=date("Y-m-d");
					$fechaTemporal=strtotime('-3 day',strtotime($fecha));
					$fechaViernes=date('Y-m-d',$fechaTemporal);
					$fechaTemporal=strtotime('-2 day',strtotime($fecha));
					$fechaSabado=date('Y-m-d',$fechaTemporal);
					$fechaTemporal=strtotime('-1 day',strtotime($fecha));
					$fechaDomingo=date('Y-m-d',$fechaTemporal);
					$Q1="SELECT PuntoVentaId FROM Depositos WHERE PuntoVentaId=$row0[0] AND (Fecha='$fechaViernes' OR Fecha='$fechaSabado' OR Fecha='$fechaDomingo') AND TipoDepositoId=5";
				}else{
				    $fecha=date("Y-m-d");
				    $fechaTemporal=strtotime('-1 day',strtotime($fecha));
					$fechaDomingo=date('Y-m-d',$fechaTemporal);
					$Q1="SELECT PuntoVentaId FROM Depositos WHERE PuntoVentaId=$row0[0] AND Fecha='$fechaDomingo' AND TipoDepositoId=5";
				}

				if($res1=mysql_query($Q1)){
					if(mysql_num_rows($res1)>0){
						echo "<tr><td>".$row0["PuntoVenta"]."</td><td>Realizo Corte</td></tr>";
					}else{
						echo "<tr><td>".$row0["PuntoVenta"]."</td><td>Pendiente</td></tr>";
					}
				}
			}
		}
echo '</table>';
?>