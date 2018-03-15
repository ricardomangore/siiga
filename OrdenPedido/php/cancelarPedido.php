<?php
	include("conexion.php");
	$comentarios=$_POST["comentarios"];
	$orden=$_POST["ordenId"];
	$query="UPDATE OrdenPedido SET Comentario='$comentarios', Estatus='Cancelado' WHERE OrdenPedidoId=$orden";
	if(mysql_query($query)){
		header("Location: ../ordenPedido.php");
	}else{
		echo "error al consultar: ".$query.mysql_query();
	}
?>