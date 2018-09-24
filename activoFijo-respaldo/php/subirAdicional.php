<?php
	include("conexion.php");
	$class=$_POST["clasificacion"];
	$comentarios=$_POST["comentarios"];
	$cantidad=$_POST["cantidad"];
	$fecha=$_POST["fecha"];
	$puntoId=$_POST["puntoId"];
	if(isset($_POST['propiedad'])){
		$propiedad="AT&T";
	}else{
		$propiedad="Propio";
	}
	$querySeguridad="INSERT INTO ActivoFijo(ActivoFijoId, ClasificacionActivoFijoId, MarcaId,  Descrpcion, EstatusActivoFijoId, FechaAdquisicion, Cantidad,Propiedad) VALUES (NULL, $class, 1, '$comentarios',1,'$fecha',$cantidad,'$propiedad')";
	if(mysql_query($querySeguridad)){
		$id=mysql_insert_id();
		$queryHistorial="INSERT INTO HistorialActivoFijo(HistorialActivoFijoId, ActivoFijoId, FechaAsignacion, ResponsableId, PuntoVentaId) VALUES (NULL, $id, '$fecha',1,$puntoId)";
		if(mysql_query($queryHistorial)){
			header("Location: ../mobiliarioPuntoVenta.php?id=$puntoId");
		}else{
			echo "error al consultar: ".$queryHistorial.mysql_error();
		}
	}else{
		echo "error al consultar: ".$querySeguridad.mysql_error();
	}
?>