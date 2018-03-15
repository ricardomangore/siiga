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
				<div id="global2" style="max-width: 100%; max-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr '.$fondo.'>
  <td>Marca</td>
  <td>SKU</td>
  <td>Modelo</td>
  <td>Inv Actual</td>
  <td>Pedido</td>
  <td>Costo</td>
  <td>Total</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		$cont++;
		//echo $resultados["Equipos"];
		$puntoVentaId=$resultados["PuntoVentaId"];
		
		$inventarioTotalActual=inventarioActual($puntoVentaId);
		$precioTotalInvPDV=precioTotal($puntoVentaId);
		$equipos=explode(",",$resultados["Equipos"]);
		$tam=count($equipos);
		$queryEquipos="SELECT E.EquipoId AS EquipoId, E.Equipo AS Equipo, E.NombreConsigna AS NombreConsigna, M.Marca AS Marca, E.CostoEquipo AS CostoEquipo FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE E.OrdenPedido=1 ORDER BY M.Marca, E.Equipo";
		if($resEquipo=mysql_query($queryEquipos)){
			$contador=0;
			while($rowEquipos=mysql_fetch_array($resEquipo)){
				if($contador%2==0){
					$claseaux=$clase;
				}else{
					$claseaux="Sin clase";
				}
				for($i=0;$i<$tam;$i++){
					$prueba=explode("-",$equipos[$i]);
					if($prueba[0]==$rowEquipos["EquipoId"]){
						$auxPrecio=(precioEquipo($prueba[0],$puntoVentaId))*($prueba[1]);
						$precioTotalPedido=$precioTotalPedido+$auxPrecio;
						$marca=$rowEquipos["Marca"];
						$equipo=$rowEquipos["Equipo"];
						$nombreConsigna=$rowEquipos["NombreConsigna"];
						$costo=$rowEquipos["CostoEquipo"];
						$cantidad=$prueba[1];
						$queryInvPDV="SELECT DISTINCT I.Serie FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$prueba[0]";
						$resInvPDV=mysql_query($queryInvPDV);
						$totalInvPDV=mysql_num_rows($resInvPDV);
						$total=$totalInvPDV+$cantidad;
						$equipostotalPedido=$equipostotalPedido+$cantidad;
						
						echo "<tr class='$claseaux'>
						<td>".$marca."</td>
						<td>".$nombreConsigna."</td>
						<td>".$equipo."</td>
						<td>".$totalInvPDV."</td>
						<td>".$cantidad."</td>
						<td>$".number_format(($cantidad*($costo+($costo*.16))),2,'.',',')."</td>
						<td>".$total."</td>
					
						<tr>";
						$contador++;
					}
				}
			}
		}else{
			echo "Error al Consultar: ".$queryEquipos.mysql_error();
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
$poliza=Poliza($puntoVentaId);
$totalEquipos=$equipostotalPedido+$inventarioTotalActual;
$totalPrecios=$precioTotalInvPDV+$precioTotalPedido;
if($totalPrecios>$poliza){
	$semaforo='<img src="img/rojo.jpg" width=100%><br><font color="red"><b>Poliza Superada por: $'.number_format(($poliza-$totalPrecios),2,'.',',').'</b></font>';
}elseif($totalPrecios<=$poliza){
	$semaforo='<img src="img/sem_ver.gif" width=100%><br><font color="green"><b>Poliza Restante: $'.number_format(($poliza-$totalPrecios),2,'.',',').'</b></font>';
}
$totalPrecios=number_format(($totalPrecios),2,'.',',');
echo '
<br>
	<div class="panel panel-default">
  <div class="panel-heading" '.$fondo.'>
    <h3 class="panel-title">Informaci&oacute;n de Poliza</h3>
  </div>
  <div class="panel-body">
   <div class="row">
	<div class="col-md-10">
	<table class="table table-hover">
	<tr>
		<td>Poliza Total: $ '.number_format(($poliza),2,'.',',').'</td>
	</tr>
	<tr>
		<td>
			equipos en Inventario: '.$inventarioTotalActual.'
		</td>
		<td>
			Valor de inventario actual: $ '.number_format(($precioTotalInvPDV),2,'.',',').'
		</td>
	</tr>
	<tr>
		<td>
			equipos en Pedido: '.$equipostotalPedido.'
		</td>
		<td>
			Valor de Pedido actual: $ '.number_format(($precioTotalPedido),2,'.',',').'
		</td>
	</tr>
	
	<tr>
		<td>
			Total de Equipos: '.$totalEquipos.'
		</td>
		<td>
			Valor Total: $ '.$totalPrecios.'
		</td>
	</tr>
	</table>
	
</div>
<div class="col-md-2">
<div align="center">
<br><br>
	'.$semaforo.'
</div>
</div>

</div>
   
   
   
   
   
   
   
  </div>
</div>



';
?>