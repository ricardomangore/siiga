<?php
	include("conexion.php");
	$ordenPedido=$_POST["ordenPedido"];
	$queryPedido="SELECT Equipos FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido AND Pendiente=1";
	if($res=mysql_query($queryPedido)){
		if(mysql_num_rows($res)==1){
		$rowPedido=mysql_fetch_array($res);
		$equipos=$rowPedido["Equipos"];
		$folio = 'ODP'.date("Ymd").str_pad($ordenPedido,4,'0',STR_PAD_LEFT);
		$time=time();
		date_default_timezone_set('America/Mexico_City');
		$fecha=date("Y-m-d H:i:s", $time);
		$numeroSemana = date("W");
		$numeroSemana=$numeroSemana;
		$marcas;
		$queryFin="UPDATE OrdenPedido SET Folio='$folio', EquiposAux='$equipos', EquiposInicial='$equipos', Fecha='$fecha', Semana='$numeroSemana', Estatus='Nuevo', Activo=1, Pendiente=0 WHERE OrdenPedidoId='$ordenPedido'";
		if(mysql_query($queryFin)){
			echo '<div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span> Su Orden de Pedido se ha Enviado Correctamente.<br> Folio del Pedido: '.$folio.'</div>';
		}else{
			echo "Error al consultar: ".$queryFin.mysql_error();
		}
		}elseif(mysql_num_rows($res)==0){
				echo '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-circle"></span> Esta Orden de Pedido ya ha sido Enviada.</div>';
		}
	}else{
		echo "Error al Consultar: ".$queryPedido.mysql_error();
	}
	//$folio = 'ODP'.date("Ymd").str_pad($ordenPedido,4,'0',STR_PAD_LEFT);
	//$queryFin="UPDATE OrdenPedido SET Folio='$folio', ";
	//ODP201710257
?>