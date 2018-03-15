<?php
	include("conexion.php");
	$time=time();
	date_default_timezone_set('America/Mexico_City');
	$fecha=date("Y-m-d H:i:s", $time);
	$ordenPedidoId=$_POST["OrdenPedidoId"];
	/*if(isset($_POST["guardar"])){
			$queryEstatus="UPDATE OrdenPedido SET Estatus='Revisado' WHERE OrdenPedidoId=$ordenPedidoId";	
	}elseif(isset($_POST["cancelar"])){
			$queryEstatus="UPDATE OrdenPedido SET Estatus='Cancelado' WHERE OrdenPedidoId=$ordenPedidoId";
	}*/
		$queryEstatus="UPDATE OrdenPedido SET Estatus='Revisado' WHERE OrdenPedidoId=$ordenPedidoId";	
	if($resultadoEstatus=mysql_query($queryEstatus)){
		$query="UPDATE OrdenPedido SET Equipos=EquiposAux, FechaRevision='$fecha' WHERE OrdenPedidoId=$ordenPedidoId";
		if($resultado=mysql_query($query)){
			//header("location: ../analisisPedido.php?id=".$ordenPedidoId);
			header("location: ../ordenPedido.php");
		}else{
		echo "Error: ".$query.mysql_error();
		}
	}else{
		echo "Error: ".$queryEstatus.mysql_error();
	}
	
	
?>