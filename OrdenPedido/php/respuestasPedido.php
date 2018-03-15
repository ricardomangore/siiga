<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
$totalEquiposPedido=0;
$totalSimsPedido=0;
$totalPrecioEquipos=0;
$totalPrecioSims=0;
$ordenPedidoId=$_GET["id"];
$mensaje='';
$time=time();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d", $time);
$fechaResta=date("Y-m-d", strtotime('-4 week'));
$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
if($res=mysql_query($query)){
	$rowOrdenPedido=mysql_fetch_array($res);
		$puntoVentaId=$rowOrdenPedido["PuntoVentaId"];
		$plataforma=$rowOrdenPedido["Plataforma"];
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
  <td>Inv Actual</td>
  <td>Autorizado</td>
  <td>Entregado</td>
  <td>Total</td>
  </tr>
  <tr style="background: #009EDB; color: #FFFFFF;">
<th colspan="6"><div align="center">Equipos  Recibidos</div></th>
</tr>
  
  
  ';
  
	
	
	
	
	
	//echo $rowOrdenPedido["EquiposFinal"]."<br>";
	$equiposAut=explode(",",$rowOrdenPedido["Equipos"]);
	$equiposFin=explode(",",$rowOrdenPedido["EquiposFinal"]);
	$tamEquiposFin=count($equiposFin);
	for($i=0;($i<$tamEquiposFin-1);$i++){
		$cantidadEquipos=explode("-",$equiposFin[$i]);
		$queryEquipos="SELECT E.Equipo AS Equipo, M.Marca AS Marca, E.CostoEquipo AS CostoEquipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$cantidadEquipos[0]";
		if($resEquipos=mysql_query($queryEquipos)){
			$rowEquipo=mysql_fetch_array($resEquipos);
			$tamEquiposAut=count($equiposAut);
			for($j=0;($j<$tamEquiposAut-1);$j++){
				$finEquiposAut=explode("-",$equiposAut[$j]);
				if(($finEquiposAut[0]==$cantidadEquipos[0]) && $band==0){
					$band=1;
					$solicitado=$finEquiposAut[1];
				}
			}
		
			
			
			
			
			if($band==1){
				$queryInvPDV="SELECT I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$cantidadEquipos[0]";
				$resInvPDV=mysql_query($queryInvPDV);
				$totalInvPDV=mysql_num_rows($resInvPDV);
				$totalInvPDVAux=$totalInvPDV+$cantidadEquipos[1];
				if(($rowEquipo["Marca"])=="SIMCARD"){
					$totalSimsPedido=$cantidadEquipos[1]+$totalSimsPedido;
					$costoSimsAux=0;
					$costoSimsAux=$costoSimsAux+($cantidadEquipos[1]*$rowEquipo["CostoEquipo"]);
					$totalPrecioSims=$totalPrecioSims+$costoSimsAux;	
				}else{
					$totalEquiposPedido=$cantidadEquipos[1]+$totalEquiposPedido;
					$costoEquipoAux=0;
					$costoEquipoAux=$costoEquipoAux+($cantidadEquipos[1]*$rowEquipo["CostoEquipo"]);
					$totalPrecioEquipos=$totalPrecioEquipos+$costoEquipoAux;
					
				}
				
				
				
				
					echo '
					<tr>
						<td>'.$rowEquipo["Marca"].'</td>
						<td>'.$rowEquipo["Equipo"].'</td>
						<td>'.$totalInvPDV.'</td>
						<td>'.$solicitado.'</td>
						<td>'.$cantidadEquipos[1].'</td>
						<td>'.$totalInvPDVAux.'</td>
						
					</tr>
				';
				
				
				
				//echo ($i+1).".- ".$rowEquipo["Equipo"]." Entregado: ".$cantidadEquipos[1]." Autorizado: ".$solicitado."<br>";
			}else{
				if(($rowEquipo["Marca"])=="SIMCARD"){
					$totalSimsPedido=$cantidadEquipos[1]+$totalSimsPedido;
					$costoSimsAux=0;
					$costoSimsAux=$costoSimsAux+($cantidadEquipos[1]*$rowEquipo["CostoEquipo"]);
					$totalPrecioSims=$totalPrecioSims+$costoSimsAux;
				}else{
					$totalEquiposPedido=$cantidadEquipos[1]+$totalEquiposPedido;
					$costoEquipoAux=0;
					$costoEquipoAux=$costoEquipoAux+($cantidadEquipos[1]*$rowEquipo["CostoEquipo"]);
					$totalPrecioEquipos=$totalPrecioEquipos+$costoEquipoAux;
				}		
				$queryInvPDV="SELECT I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$cantidadEquipos[0]";
				$resInvPDV=mysql_query($queryInvPDV);
				$totalInvPDV=mysql_num_rows($resInvPDV);
				$totalInvPDVAux=$totalInvPDV+$cantidadEquipos[1];
				
				
				
				echo '
					<tr>
						<td>'.$rowEquipo["Marca"].'</td>
						<td>'.$rowEquipo["Equipo"].'</td>
						<td>'.$totalInvPDV.'</td>
						<td>0</td>
						<td>'.$cantidadEquipos[1].'</td>
						<td>'.$totalInvPDVAux.'</td>
						
					</tr>
				';
				
				
				
				
				//echo ($i+1).".- ".$rowEquipo["Equipo"]." Cantidad: ".$cantidadEquipos[1]." Autorizado: 0<br>";
			}
			
			$band=0;
			
			
			
		}else{
			echo "error".mysql_error();
		}
		//echo ($i+1).".- Equipo: ".$cantidadEquipos[0]." Cantidad: ".$cantidadEquipos[1]."<br>";
	}
	echo '
	<tr style="background: #009EDB; color: #FFFFFF;">
<th colspan="6"><div align="center">Equipos No Recibidos</div></th>
</tr>
	
	';
	
	
	
	for($i=0;$i<($tamEquiposAut-1);$i++){
		$equiposAutAux=explode("-",$equiposAut[$i]);
		$band=0;
		for($j=0;$j<($tamEquiposFin);$j++){
			$equiposFinAux=explode("-",$equiposFin[$j]);
			if($equiposAutAux[0]==$equiposFinAux[0]){
			//	echo "Equipo Encontrado<br>";
				//echo "Equipo: ".$equiposAutAux[0]." Cantidad: ".$equiposAutAux[1]."<br>";
				$band=1;
			}
				
		}
		if($band==0){
		        $queryInvPDV="SELECT I.Cantidad FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND I.EquipoId=$equiposAutAux[0]";
				$resInvPDV=mysql_query($queryInvPDV);
				$totalInvPDV=mysql_num_rows($resInvPDV);
				$totalInvPDVAux=$totalInvPDV+$cantidadEquipos[1];
		    
		    
			$queryEquipos2="SELECT E.Equipo AS Equipo, M.Marca AS Marca FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$equiposAutAux[0]";
			if($resEquipos2=mysql_query($queryEquipos2)){
				$rowEquipo2=mysql_fetch_array($resEquipos2);
					echo '
					<tr>
						<td>'.$rowEquipo2["Marca"].'</td>
						<td>'.$rowEquipo2["Equipo"].'</td>
						<td>'.$totalInvPDV.'</td>
						<td>'.$equiposAutAux[1].'</td>
						<td>0</td>
						<td>'.$totalInvPDV.'</td>
						
					</tr>
				
				
				';
				
			}
			
		}
		
	}
	
		
$total=precioTotal($puntoVentaId);
$totalSims=precioTotalSims($puntoVentaId);
$totalEquiposInv=inventarioActual($puntoVentaId);
$totalSimsInv=inventarioActualSims($puntoVentaId);

$todosEquipos=($totalEquiposPedido+$totalEquiposInv+$totalSimsInv+$totalSimsPedido);
$totalPrecioFinal=($total)+($totalSims)+($totalPrecioEquipos+($totalPrecioEquipos*.16))+($totalPrecioSims+($totalPrecioSims*.16));
	
	
$poliza=Poliza($puntoVentaId);
if($totalPrecioFinal>$poliza){
	$semaforo='<img src="img/rojo.jpg" width=100%><br><font color="red"><b>Poliza Superada por: $'.number_format(($poliza-$totalPrecioFinal),2,'.',',').'</b></font>';
}elseif($totalPrecioFinal<=$poliza){
	$semaforo='<img src="img/sem_ver.gif" width=100%><br><font color="green"><b>Poliza Restante: $'.number_format(($poliza-$totalPrecioFinal),2,'.',',').'</b></font>';
}
$totalPrecioFinal=number_format(($totalPrecioFinal),2,'.',',');	
	
	
echo '
</table>
<br>
	<div class="panel panel-default">
  <div class="panel-heading" '.$fondo.'>
    <h3 class="panel-title">Informaci&oacute;n de Poliza</h3>
  </div>
  <div class="panel-body">
   <div class="row">
	<div class="col-md-10">
	<table class="table table-hover">
	<tr style="background: #009EDB; color: #FFFFFF;">
<th colspan="2"><div align="center">Informaci&oacute;n de Equipos</div></th>
</tr>
	<tr>
		<td>
			Equipos en Inventario: '.$totalEquiposInv.'
		</td>
		<td>
			Precio de Equipos en Inventario: $ '.number_format(($total),2,'.',',').'
		</td>
	</tr>
	<tr>
		<td>
			Equipos Entregados: '.$totalEquiposPedido.'
		</td>
		<td>
			Precio Equipos Entregados: $ '.number_format(($totalPrecioEquipos+($totalPrecioEquipos*.16)),2,'.',',').'
		</td>
	</tr>
	<tr style="background: #009EDB; color: #FFFFFF;">
		<th colspan="2"><div align="center">Informaci&oacute;n de Sims</div></th>
	</tr>
	<tr>
		<td>
			Sims en Inventario: '.$totalSimsInv.'
		</td>
		<td>
			Precio de Sims en Inventario: $ '.number_format(($totalSims),2,'.',',').'
		</td>
	</tr>
	<tr>
		<td>
			Sims Entregadas: '.$totalSimsPedido.'
		</td>
		<td>
			Precio Sims Entregados: $ '.number_format(($totalPrecioSims+($totalPrecioSims*.16)),2,'.',',').'
		</td>
	</tr>
	<tr style="background: #009EDB; color: #FFFFFF;">
		<th colspan="2"><div align="center">Informaci&oacute;n Total de Inventario</div></th>
	</tr>
	<tr>
		<td>
			Total de Equipos: '.$todosEquipos.'
		</td>
		<td>
			Valor Total: $ '.$totalPrecioFinal.'
		</td>
	</tr>

	
	
	</table>
</div>
<div class="col-md-2">
'.$semaforo.'
</div>

</div>

  </div>
</div>



';	
}
?>