<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
$ordenPedidoId=$_GET["id"];
$mensaje='';
$time=time();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d", $time);
$fechaResta=date("Y-m-d", strtotime('-4 week'));
$subTotal=0;
$totalEquipos=0;

//echo $fecha." fecha Anterior: ".$fechaResta;
$query1="SELECT Plataforma FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
$resultado1=mysql_query($query1);
$rowEquipos1=mysql_fetch_array($resultado1);
$plataforma=$rowEquipos1["Plataforma"];

$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
//echo $query;
$resultado=mysql_query($query);
if($resultado){
//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
	
$cont=0;	
	$resultados = mysql_fetch_assoc($resultado);
	$fondo='style="background: #0574AC; color: #FFFFFF;"';
	  	//$clase="nuevo";
				echo '
				<div style="max-width: 80%; max-height: 400px;">
				<table class="table table-hover">
				<tr '.$fondo.'>
				<td colspan="5" align="center"><b>Plataforma: '.$plataforma.'</b></td>	
				</tr>
  <tr '.$fondo.'>
  <td>EquipoId</td>
  <td>Marca</td>
  <td>Modelo</td>
  <td>Solicitud</td>
  <td>Total de la Linea (sin IVA)</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		$cont++;
		//echo $resultados["Equipos"];
		$puntoVentaId=$resultados["PuntoVentaId"];		
		$equipos=explode(",",$resultados["Equipos"]);
		$tam=count($equipos);
		//echo "<br><br>El número de elementos en el array es: " .($tam-1)."<br>";
		for($i=0;$i<($tam-1);$i++){
			if($i%2==0){
				$claseaux="alert alert-info";
			}else{
				$claseaux="Sin clase";
			}
			$prueba=explode("-",$equipos[$i]);
			$queryEquipos="SELECT E.EquipoId AS EquipoId, M.Marca AS Marca, E.Equipo AS Equipo, E.CostoEquipo AS CostoEquipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$prueba[0]";
			$rowEquipos=mysql_query($queryEquipos);
			$resEquipos=mysql_fetch_array($rowEquipos);
			
			//echo "Marca: ".$resEquipos["Marca"]." Equipo: ".$resEquipos["Equipo"]." Cantidad: ".$prueba[1]."<br>";
			//echo "modelo: ".$prueba[0]."Cantidad: ".$prueba[1]."<br>";
			$equipoId=$resEquipos["EquipoId"];
			$marca=$resEquipos["Marca"];
			$equipo=$resEquipos["Equipo"];
			$cantidad=$prueba[1];
			$costoUnitario=$resEquipos["CostoEquipo"];
			$costoLinea=$costoUnitario*$cantidad;
			$totalEquipos=$totalEquipos+$cantidad;
			$subTotal=$subTotal+$costoLinea;
			$costoUnitarioFin=number_format(($costoUnitario),2,'.',',');
			$costoLineaFin=number_format(($costoLinea),2,'.',',');
			echo "<tr class='$claseaux' style='color: black;'>
					<td>".$equipoId."</td>
					<td>".$marca."</td>
					<td>".$equipo."</td>
					<td align='center'>$cantidad</td>
					<td>MXN $ ".$costoLineaFin."</td>
			<tr>";
		}
		
if($cont==0){
	echo '<div align="center"><b>No existen Registros</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;
echo '  </table>
</div>';

	$iva=$subTotal*(.16);
	$total=$subTotal+$iva;

		echo '<br><br><br>
		<div align="right" style="max-width: 80%;">
			<table class="table table-hover" style="width: 35%">
			<tr class="alert alert-info">
				<td><b><font color="#000000">Cantidad de Equipos: </b></font></td>
				<td><font color="#000000">'.$totalEquipos.'</font></td>				
			</tr>
			<tr>
				<td><b>Sub-Total: </b></td>
				<td>MXN $ '.number_format(($subTotal),2,'.',',').'</td>				
			</tr>			
			<tr class="alert alert-info">
				<td><font color="#000000"><b>IVA: </b></font></td>
				<td><font color="#000000">MXN $ '.number_format(($iva),2,'.',',').'</font></td>				
			</tr>
			<tr>
				<td><b>
				Total: </b></td>
				<td>MXN $ '.number_format(($total),2,'.',',').'</td>			
			</tr>
		</table>
		</div>
		

	';

}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>