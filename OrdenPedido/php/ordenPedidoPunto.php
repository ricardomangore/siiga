<?php
	include("conexion.php");
	$puntoId=0;
	$fechaInicial=$_POST["fechaInicial"];
	$fechaFin=$_POST["fechaFin"];
	$horaInicial=$_POST["horaInicial"];
	$horaFin=$_POST["horaFin"];
	$usuarioId=$_POST["usuarioId"];
	$puntoId=$_POST["puntoId"];
	if($puntoId==0){
		echo "Elige un punto de venta<br>";
	}else{
		$query="INSERT INTO AperturaOrdenPedidoPunto(AperturaPuntoId, FechaInicio, FechaFin, HoraInicio, HoraFin, PuntoVentaId, Usuario,Activo) VALUES (NULL, '$fechaInicial','$fechaFin','$horaInicial','$horaFin','$puntoId','$usuarioId',1)";
		if(mysql_query($query)){
			header("location: ../herramientas.php");
		}else{
			echo "Error al consultar".$query.mysql_error();
		}
		
	}
	
?>