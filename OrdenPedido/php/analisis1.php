<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
$ordenPedidoId=$_GET["id"];

$mensaje='';
$time=time();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d", $time);
$fechaResta=date("Y-m-d", strtotime('-4 week'));
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
				<div id="global2" style="max-width: 100%; max-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr '.$fondo.'>
  <td>Marca</td>
  <td>Modelo</td>
  <td>Inv PDV</td>
  <!--<td>Inv Plaza</td>
  <td>Inv SubRegion</td>-->
  <td>Inv Regional</td>
  <td>Inv Nacional</td>
  <td>Vendidos (4 sem)</td>
  <td>Pedido Semanal</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		$cont++;
		//echo $resultados["Equipos"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		$queryPDV=mysql_query("SELECT P.PlazaId AS PlazaId, SR.SubRegionId AS SubRegionId, R.RegionId AS RegionId, PV.ClasificacionPersonalVenta AS ClasificacionPersonalVenta FROM PuntosVenta AS PV INNER JOIN Plazas AS P ON PV.PlazaId=P.PlazaId INNER JOIN SubRegiones AS SR ON P.SubRegionId=SR.SubRegionId INNER JOIN Regiones AS R ON R.RegionId=SR.RegionId WHERE PV.PuntoVentaId=$puntoVentaId");
		$resPDV=mysql_fetch_array($queryPDV);
		$plazaId=$resPDV["PlazaId"];
		$subRegionId=$resPDV["SubRegionId"];
		$regionId=$resPDV["RegionId"];
		$clasificacionPersonal=$resPDV["ClasificacionPersonalVenta"];
		$contador=0;
		$queryEquipos="SELECT E.EquipoId AS EquipoId, E.Equipo AS Equipo, M.Marca AS Marca FROM Marcas AS M INNER JOIN Equipos AS E ON M.MarcaId=E.MarcaId WHERE E.OrdenPedido=1 ORDER BY M.Marca, E.Equipo";
		if($respuestaEquipos=mysql_query($queryEquipos)){
			
			
			while($rowEquipos=mysql_fetch_array($respuestaEquipos)){
				$equipos=explode(",",$resultados["Equipos"]);
				$tam=count($equipos);
				if($contador%2==0){
						$claseaux=$clase;
					}else{
						$claseaux="Sin clase";
					}
				for($i=0;$i<$tam;$i++){
					$prueba=explode("-",$equipos[$i]);
					if($prueba[0]==$rowEquipos["EquipoId"]){
						$marca=$rowEquipos["Marca"];
						$equipo=$rowEquipos["Equipo"];
						$cantidad=$prueba[1];
						
						$queryInvPDV="SELECT  I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$prueba[0]";
						$resInvPDV=mysql_query($queryInvPDV);
						$totalInvPDV=mysql_num_rows($resInvPDV);
						
						$queryInvRegion="SELECT I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=R.PuntoVentaId INNER JOIN Plazas AS P ON PV.PlazaId=P.PlazaId INNER JOIN SubRegiones AS SR ON SR.SubRegionId=P.SubRegionId INNER JOIN Regiones AS RE ON RE.RegionId=SR.RegionId WHERE I.Cantidad>0 AND RE.RegionId=$regionId AND I.EquipoId=$prueba[0] AND PV.ClasificacionPersonalVenta=$clasificacionPersonal";
						$resInvRegion=mysql_query($queryInvRegion);
						$totalInvRegion=mysql_num_rows($resInvRegion);
						
						
						
						$queryInvNacional="SELECT DISTINCT I.Serie AS Serie  FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId INNER JOIN PuntosVenta AS PV ON R.PuntoVentaId=PV.PuntoVentaId  WHERE I.Cantidad>0 AND I.EquipoId=$prueba[0] AND PV.ClasificacionPersonalVenta=$clasificacionPersonal";
						$resInvNacional=mysql_query($queryInvNacional);
						$totalInvNacional=mysql_num_rows($resInvNacional);
						$queryPendientes="SELECT OC.Serie AS Serie FROM OrdenesCompra AS OC INNER JOIN
						PuntosVenta AS PV ON OC.PuntoVentaId=PV.PuntoVentaId WHERE OC.EquipoId=$prueba[0] AND OC.Recibido=0 AND PV.ClasificacionPersonalVenta=$clasificacionPersonal";
						$resInvPendiente=mysql_query($queryPendientes);
						$totalInvNacional=$totalInvNacional + mysql_num_rows($resInvPendiente);
			
						$queryInvTransito="SELECT I.Cantidad AS Cantidad FROM Inventario AS I INNER JOIN TRSalidas AS TR ON I.MovimientoId=TR.MovimientoId INNER JOIN PuntosVenta AS PV ON TR.PuntoVentaIdD=PV.PuntoVentaId  WHERE I.Cantidad>0 AND I.EquipoId=$prueba[0] AND PV.ClasificacionPersonalVenta=$clasificacionPersonal";
						$resInvTransito=mysql_query($queryInvTransito);
						$totalInvNacional=$totalInvNacional + mysql_num_rows($resInvTransito);
						
						
						$queryVendidos="SELECT L.EquipoId FROM HFolios AS H INNER JOIN LFolios AS L ON H.Folio=L.Folio WHERE L.EquipoId=$prueba[0] AND H.PuntoVentaId=$puntoVentaId AND L.EstatusId=14 AND (L.FechaEstatus>='$fechaResta' AND L.FechaEstatus<='$fecha' );";
						$resVendidos=mysql_query($queryVendidos);
						$totalVendidos=mysql_num_rows($resVendidos);
			
			
						echo "<tr class='$claseaux'>
							<td>".$marca."</td>
							<td>".$equipo."</td>
							<td>".$totalInvPDV."</td>
							<!--<td>".$totalInvPlaza."</td>
							<td>".$totalInvSubRegion."</td>-->
							<td>".$totalInvRegion."</td>
							<td>".$totalInvNacional."</td>
							<td>".$totalVendidos."</td>
							<td>".$cantidad."</td>
						<tr>";
						$i=$tam;
						$contador++;
					}
				}	
			}
			
		}else{
			echo "Error al consultar: ".$queryEquipos.mysql_error();
		}
		
		
	
		if($resultados["Estatus"]=="Nuevo"){
			if(mysql_query("UPDATE OrdenPedido SET Estatus='En revisi&oacute;n' WHERE OrdenPedidoId=$ordenPedidoId")){
				
			}
		}
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