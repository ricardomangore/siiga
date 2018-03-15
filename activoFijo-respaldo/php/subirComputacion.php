<?php
	include("conexion.php");
	$class=$_POST["clasificacion"];
	$comentarios=$_POST["comentarios"];
	$cantidad=$_POST["cantidad"];
	$fecha=$_POST["fecha"];
	$puntoId=$_POST["puntoId"];
	$marca=$_POST["marca"];
	$modelo=$_POST["modelo"];
	$serie=$_POST["serie"];
	if(isset($_POST['propiedad'])){
		$propiedad="AT&T";
	}else{
		$propiedad="Propio";
	}

	$queryComputo="INSERT INTO ActivoFijo(ActivoFijoId, ClasificacionActivoFijoId, MarcaId, Modelo, Serie, Descrpcion, EstatusActivoFijoId, FechaAdquisicion, Cantidad, Propiedad) VALUES (NULL, $class,$marca,'$modelo','$serie','$comentarios',1,'$fecha',$cantidad,'$propiedad')";
	if(mysql_query($queryComputo)){
		$id=mysql_insert_id();
		$queryHistorial="INSERT INTO HistorialActivoFijo(HistorialActivoFijoId, ActivoFijoId, FechaAsignacion, ResponsableId, PuntoVentaId) VALUES (NULL, $id, '$fecha',1,$puntoId)";
		if(mysql_query($queryHistorial)){
			header("Location: ../mobiliarioPuntoVenta.php?id=$puntoId");
		}else{
			echo "error al consultar: ".$queryHistorial.mysql_error();
		}
	}else{
		echo "error al consultar: ".$queryComputo.mysql_error();
	}
?>