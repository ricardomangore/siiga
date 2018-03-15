<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
$usuario=$_GET["id"];
$puntoVenta=PuntoVenta($usuario);

$mensaje='';

$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.FechaRevision AS FechaRevision, OP.Plataforma AS Plataforma FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.Activo=1 AND OP.PuntoVentaId=$puntoVenta";
//echo $query;
$resultado=mysql_query($query);
if($resultado){

//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
$cont=0;
				$clase="nuevo";
				echo '
				<div id="global2" style="max-width: 90%; max-height: 600px; min-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr style="background:#0574AC; color:#FFFFFF;">
  <td>No. Orden</td>
  <td>Punto de Venta</td>
  <td>Plataforma</td>
  <td>Usuario</td>
  <td>Fecha de Orden</td>
  <td>Fecha de Revisi&oacute;n</td>
  <td>Estatus</td>
  <td>Seleccionar</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {
	while ($resultados = mysql_fetch_assoc($resultado)) {
		$cont=$cont+1;
		$ordenPedidoId=$resultados["OrdenPedidoId"];
		$puntoVenta=$resultados["PuntoVenta"];
		$plataforma=$resultados["Plataforma"];
		$usuario=$resultados["Usuario"];
		$fecha=$resultados["Fecha"];
		$fechaRevision=$resultados["FechaRevision"];
		$estatus=$resultados["Estatus"];
		if($estatus=="Nuevo"){
			$estatusFin='<span class="label label-info"><span class="glyphicon glyphicon-certificate"></span> Nuevo</span>';
		}elseif($estatus=='En revisi&oacute;n'){
			$estatusFin='<span class="label label-warning">En Revisi&oacute;n</span>';
		}elseif($estatus=='Revisado'){
			$estatusFin='<span class="label label-success">Revisado</span>';
		}

		$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$ordenPedidoId.'</td>
					<td>'.$puntoVenta.'</td>
					<td>'.$plataforma.'</td>
					<td>'.$usuario.'</td><td>'.$fecha.'</td><td>'.$fechaRevision.'</td><td>'.$estatusFin.'</td>
                   <td align="center"><input type="radio" required name="OrdenPedido" value='.$ordenPedidoId.'></td>
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
	if($cont/15){
		
	}
	echo '
	<ul class="pagination">
  <li><a href="#">&laquo;</a></li>
  <li><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#">&raquo;</a></li>
</ul>
	
	';
	
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>