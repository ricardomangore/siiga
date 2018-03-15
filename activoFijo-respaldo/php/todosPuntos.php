<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
$mensaje='';

$query=" SELECT PV.PuntoVentaId AS PuntoVentaId, PV.PuntoVenta AS PuntoVenta, CP.ClasificacionPersonalVenta AS ClasificacionPersonalVenta, TP.TipoPunto AS TipoPunto  FROM PuntosVenta AS PV INNER JOIN ClasificacionPersonalVenta AS CP ON CP.ClasificacionPersonalVentaId=PV.ClasificacionPersonalVenta INNER JOIN TipoPuntos AS TP ON PV.TipoPuntoId=TP.TipoPuntoId WHERE PV.Activo=1 ORDER BY PV.PuntoVenta";
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
  <td>Id Punto</td>
  <td>Punto de Venta</td>
  <td>Clasificacion</td>
  <td>Tipo</td>
  <td>Operaciones</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {
	while ($resultados = mysql_fetch_assoc($resultado)) {
		$cont=$cont+1;
		$puntoVenta=$resultados["PuntoVenta"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		$clasificacionPersonal=$resultados["ClasificacionPersonalVenta"];
		$tipoPunto=$resultados["TipoPunto"];
		if($cont%2==0){
			$clase="info";
		}else{
			$clase="primary";
		}
		$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$puntoVentaId.'</td>
					<td>'.$puntoVenta.'</td>
					<td>'.$clasificacionPersonal.'</td>
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