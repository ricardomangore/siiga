<?php
	include("conexion.php");
	$fechaInicial=$_POST["fechaInicial"];
	$fechaFin=$_POST["fechaFin"];
	$horaInicial=$_POST["horaInicial"];
	$horaFin=$_POST["horaFin"];
	$usuarioId=$_POST["usuarioId"];
	if(mysql_query("UPDATE AperturaOrdenPedido SET Activo=0")){
		$query="INSERT INTO AperturaOrdenPedido(AperturaId, FechaInicio, FechaFin, HoraInicio, HoraFin,Usuario,Activo) VALUES (NULL, '$fechaInicial','$fechaFin','$horaInicial','$horaFin','$usuarioId',1)";
		if(mysql_query($query)){
			header("location: ../herramientas.php");
		}else{
			echo "Error al consultar".$query.mysql_error();
		}
	}else{
		echo "Error al consulta: ".mysql_query();
	}

	
?>