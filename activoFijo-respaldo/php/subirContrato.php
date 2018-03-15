<?php
	include("conexion.php");
	$contrato=$_POST["contrato"];
	$descripcion=$_POST["descripcion"];
	$fechaInicial=$_POST["fechaInicial"];
	$fechaFinal=$_POST["fechaFinal"];
	$puntoId=$_POST["puntoId"];
	$costo=$_POST["costo"];
	$query="INSERT INTO ContratoPuntoVenta(ContratoPuntoVentaId, Contrato, Descripcion, FechaInicio, FechaFin, Costo, PuntoVentaId, Activo) VALUES (NULL, '$contrato', '$descripcion', '$fechaInicial', '$fechaFinal', $costo, $puntoId, 1)";
	if(mysql_query($query)){
		header("Location: ../contratoPuntoVenta.php?id=$puntoId");
	}else{
		echo "error al consultar: ".$query.mysql_error();
	}
?>