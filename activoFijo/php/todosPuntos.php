<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
$mensaje='';

$query=" SELECT R.Region AS Region, SR.SubRegion AS SubRegion, P.Plaza AS Plaza, PV.PuntoVentaId AS PuntoVentaId, PV.PuntoVenta AS PuntoVenta, CP.ClasificacionPersonalVenta AS ClasificacionPersonalVenta, TP.TipoPunto AS TipoPunto, PAF.Contrato AS Contrato  FROM PuntosVenta AS PV INNER JOIN ClasificacionPersonalVenta AS CP ON CP.ClasificacionPersonalVentaId=PV.ClasificacionPersonalVenta INNER JOIN TipoPuntos AS TP ON PV.TipoPuntoId=TP.TipoPuntoId INNER JOIN Plazas AS P ON P.PlazaId=PV.PlazaId INNER JOIN SubRegiones AS SR ON SR.SubRegionId=P.SubRegionId INNER JOIN Regiones AS R ON R.RegionId=SR.RegionId INNER JOIN PuntosActivoFijo AS PAF ON PAF.PuntoVentaId=PV.PuntoVentaId WHERE PV.Activo=1 AND PAF.Activo=1 ORDER BY PV.PuntoVenta";
//echo $query;
$resultado=mysql_query($query);
if($resultado){

//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
$cont=0;
				$clase="nuevo";
				echo '
				<div id="global2" style="max-width: 100%; max-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr style="background:#0574AC; color:#FFFFFF;">
  <td>Id</td>
  <td>Regiones</td>
  <td>Sub Regiones</td>
  <td>Plazas</td>
  <td>Punto de Venta</td>
  <td>Contrato</td>
  <td>Tipo</td>
  <td>Operaciones</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {
	while ($resultados = mysql_fetch_assoc($resultado)) {
		$cont=$cont+1;
		$puntoVenta=$resultados["PuntoVenta"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		$contrato=$resultados["Contrato"];
		$tipoPunto=$resultados["TipoPunto"];
		if($tipoPunto=='CAE CONCESIONADO'){
			$tipoPunto="PROPIO";
		}
		if($puntoVentaId==397 || $puntoVentaId==506 || $puntoVentaId==467 || $puntoVentaId==396 || $puntoVentaId==465 || $puntoVentaId==366 || $puntoVentaId==78 || $puntoVentaId==83 || $puntoVentaId==395){
			$tipoPunto="SUB DISTRIBUIDOR";
		}
		$region=$resultados["Region"];
		$subRegion=$resultados["SubRegion"];
		$plaza=$resultados["Plaza"];
		if($cont%2==0){
			$clase="info";
		}else{
			$clase="primary";
		}
		$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$puntoVentaId.'</td>
					<td>'.$region.'</td>
					<td>'.$subRegion.'</td>
					<td>'.$plaza.'</td>
					<td>'.$puntoVenta.'</td>
					<td>'.$contrato.'</td>
					<td>'.$tipoPunto.'</td>
                    <td><a href="gastosPuntoVenta.php?id='.$puntoVentaId.'"><button class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span> Aceptar</button></a></td>
                </tr>
			</p>';
};
if($cont==0){
	echo '<div align="center"><b>No existen Registros</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;
echo '  </table>
</div>';
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>