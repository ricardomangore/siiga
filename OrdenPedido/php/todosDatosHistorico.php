<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
include("sesion.php");
$numeroSemana = date("W"); 
$condiciones="";/*
if($_SESSION["usuarioId"]==172){
	$condiciones="AND (PV.ClasificacionPersonalVenta=1 OR PV.ClasificacionPersonalVenta=6 OR PV.ClasificacionPersonalVenta=7)";
}elseif($_SESSION["usuarioId"]==353 ||  $_SESSION["usuarioId"]==1228){
	$condiciones="AND (PV.ClasificacionPersonalVenta=4 OR PV.ClasificacionPersonalVenta=5 OR PV.ClasificacionPersonalVenta=7 OR PV.ClasificacionPersonalVenta=8)";
}*/

$mensaje='';

$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, OP.Folio AS Folio, OP.Semana AS Semana, PV.PuntoVenta AS PuntoVenta, PV.PuntoVentaId AS PuntoVentaId, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.Semana!=$numeroSemana AND OP.Activo=1 AND OP.Pendiente=0 $condiciones AND OP.Fecha>'2017-12-31' ORDER BY OP.Fecha DESC";
//echo $query;
$resultado=mysql_query($query);
if($resultado){

//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
$cont=0;
				$clase="nuevo";
				echo '
				<div id="global2" style="max-width: 95%; max-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr style="background:#0574AC; color:#FFFFFF;">
  <td>No. Orden</td>
  <td>Punto de Venta</td>
  <td>Plataforma</td>
  <td>Usuario</td>
  <td>Responsable</td>
  <td>Fecha</td>
  <td>Semana</td>
  <td>Estatus</td>
  <td>Seleccionar</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {
	while ($resultados = mysql_fetch_assoc($resultado)) {
		$cont=$cont+1;
		$ordenPedidoId=$resultados["OrdenPedidoId"];
		$folio=$resultados["Folio"];
		$puntoVenta=$resultados["PuntoVenta"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		$plataforma=$resultados["Plataforma"];
		$usuario=$resultados["Usuario"];
		$fecha=$resultados["Fecha"];
		$semana=$resultados["Semana"];
		$estatus=$resultados["Estatus"];
		if($puntoVentaId==427 || $puntoVentaId==426  || $puntoVentaId==471  || $puntoVentaId==509  || $puntoVentaId==494  || $puntoVentaId==496  || $puntoVentaId==34  || $puntoVentaId==368  || $puntoVentaId==493  || $puntoVentaId==42  || $puntoVentaId==21  || $puntoVentaId==29  || $puntoVentaId==369  || $puntoVentaId==370  || $puntoVentaId==371  || $puntoVentaId==76  || $puntoVentaId==30  || $puntoVentaId==72  || $puntoVentaId==407  || $puntoVentaId==425  || $puntoVentaId==74  || $puntoVentaId==492   || $puntoVentaId==506   || $puntoVentaId==67   || $puntoVentaId==467   || $puntoVentaId==464   || $puntoVentaId==61   || $puntoVentaId==68   || $puntoVentaId==397   || $puntoVentaId==9   || $puntoVentaId==48   || $puntoVentaId==457){
			
			$responsable="Elizabeth Sanchez Huitzil";
			
		}else{
			$responsable='Jaime Rodriguez Sanchez';
		}
		if($estatus=="Nuevo"){
			$estatusFin='<span class="label label-info"><span class="glyphicon glyphicon-certificate"></span> Nuevo</span>';
		}elseif($estatus=='En revisi&oacute;n'){
			$estatusFin='<span class="label label-warning">En Revisi&oacute;n</span>';
		}elseif($estatus=='Revisado'){
			$estatusFin='<span class="label label-success">Revisado</span>';
		}elseif($estatus=='Cancelado'){
			$estatusFin='<span class="label label-danger">Cancelado</span>';
		}elseif($estatus=='Finalizado'){
			$estatusFin='<span class="label label-primary">Finalizado</span>';
		}
		$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$folio.'</td>
					<td>'.$puntoVenta.'</td>
					<td>'.$plataforma.'</td>
					<td>'.$usuario.'</td><td>'.$responsable.'</td><td>'.$fecha.'</td><td>'.$semana.'</td><td>'.$estatusFin.'</td>
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
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>