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
//echo $fecha." fecha Anterior: ".$fechaResta;


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
				<div id="global2" style="max-width: 90%; max-height: 400px; over;flow-y: scroll">	
				<table class="table table-hover">

  <tr '.$fondo.'>
  <td>EquipoId</td>
  <td>Marca</td>
  <td>Modelo</td>
  <td>Precio Unitario (Sin IVA)</td>
  <td>Solicitud</td>
  <td>Total de la Linea (sin IVA)</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		
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
			$subTotal=$subTotal+$costoLinea;
			$costoUnitarioFin=number_format(($costoUnitario),2,'.',',');
			$costoLineaFin=number_format(($costoLinea),2,'.',',');
			echo "<tr class='$claseaux' style='color: black;'>
					<td>".$equipoId."</td>
					<td>".$marca."</td>
					<td>".$equipo."</td>
					<td align='center'>MXN $ ".$costoUnitarioFin."</td>
					<td align='center'><input type='number' style='width: 50px;' value='$cantidad' name='$prueba[0]'></td>
					<td>MXN $ ".$costoLineaFin."</td>
			<tr>";
			$cont++;
		}
		
if($cont==0){
	echo '<div align="center"><b>Actualmente no existen productos en el carrito</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;
echo '  </table>
</div>';
	echo '<br><br><div align="right" style="width: 90%;"><b>Sub-Total: </b>MXN $ '.number_format(($subTotal),2,'.',',').'</div>';
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>