<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
$ordenPedidoId=$_GET["id"];
$mensaje='';
$time=time();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d", $time);
$fechaResta=date("Y-m-d", strtotime('-4 week'));
$poliza=0;
$equipostotalInvPDV=0;
$precioTotalInvPDV=0;
$equipostotalPedido=0;
$precioTotalPedido=0;
$totalEquipos=0;
$totalPrecios=0;
$inventarioTotalActual=0;
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
	$plataforma=$resultados["Plataforma"];
	   if(trim($plataforma)==('AVS Azul')){
		 $fondo='style="background: #009EDB; color: #FFFFFF;"';
		   $clase="info";
	   }elseif(trim($plataforma)==('NOE Naranja')){
		   $fondo='style="background: #E05206; color: #FFFFFF;"';
		   $clase="warning";
	   }elseif(trim($plataforma)==('PVS Rojo')){
		   $fondo='style="background: #E30412; color: #FFFFFF;"';
		   $clase="danger";
	   }
				//$clase="nuevo";
				echo '
					
				<table class="table table-hover">

  <tr '.$fondo.'>
  <td>Marca</td>
  <td>Modelo</td>
  <td>Autorizado</td>
  <td>Recibido</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		$cont++;
		//echo $resultados["Equipos"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		$queryPDV=mysql_query("SELECT P.PlazaId AS PlazaId, SR.SubRegionId AS SubRegionId, R.RegionId AS RegionId FROM PuntosVenta AS PV INNER JOIN Plazas AS P ON PV.PlazaId=P.PlazaId INNER JOIN SubRegiones AS SR ON P.SubRegionId=SR.SubRegionId INNER JOIN Regiones AS R ON R.RegionId=SR.RegionId WHERE PV.PuntoVentaId=$puntoVentaId");
		$resPDV=mysql_fetch_array($queryPDV);
		$plazaId=$resPDV["PlazaId"];
		$subRegionId=$resPDV["SubRegionId"];
		$regionId=$resPDV["RegionId"];
		$inventarioTotalActual=inventarioActual($puntoVentaId);
		$precioTotalInvPDV=precioTotal($puntoVentaId);
		$equipos=explode(",",$resultados["Equipos"]);
		$tam=count($equipos);
		//echo "<br><br>El número de elementos en el array es: " .($tam-1)."<br>";
		for($i=0;$i<($tam-1);$i++){
			if($i%2==0){
				$claseaux=$clase;
			}else{
				$claseaux="Sin clase";
			}
			$prueba=explode("-",$equipos[$i]);
			$queryEquipos="SELECT M.Marca AS Marca, E.Equipo AS Equipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$prueba[0]";
			$rowEquipos=mysql_query($queryEquipos);
			$resEquipos=mysql_fetch_array($rowEquipos);
			$auxPrecio=(precioEquipo($prueba[0],$puntoVentaId))*($prueba[1]);
			//echo $auxPrecio.",";
			$precioTotalPedido=$precioTotalPedido+$auxPrecio;
			//echo "Marca: ".$resEquipos["Marca"]." Equipo: ".$resEquipos["Equipo"]." Cantidad: ".$prueba[1]."<br>";
			//echo "modelo: ".$prueba[0]."Cantidad: ".$prueba[1]."<br>";
			$marca=$resEquipos["Marca"];
			$equipo=$resEquipos["Equipo"];
			$cantidad=$prueba[1];
			$queryInvPDV="SELECT I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$prueba[0]";
			$resInvPDV=mysql_query($queryInvPDV);
			$totalInvPDV=mysql_num_rows($resInvPDV);
			$total=$totalInvPDV+$cantidad;
			$equipostotalPedido=$equipostotalPedido+$cantidad;
			echo "<tr class='$claseaux'>
					<td>".$marca."</td>
					<td>".$equipo."</td>
					<td>".$cantidad."</td>
					<td><input type='number' value='0' name='$prueba[0]' style='width: 60px;'></td>
					
					
			<tr>";
		}
		
if($cont==0){
	echo '<div align="center"><b>No existen Registros</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;
echo '  </table>
';
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}


?>