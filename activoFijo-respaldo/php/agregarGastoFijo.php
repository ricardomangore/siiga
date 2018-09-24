<?php
	include("conexion.php");
	$puntoId=$_POST["puntoId"];
	$categoria=$_POST["categoria"];
	$descripcion=$_POST["descripcion"];
	$costo=$_POST["costo"];
	//echo "costo: ".$costo;
	$queryCategoria="SELECT CategoriaGastoFijoId FROM CategoriaGastoFijo WHERE Categoria='$categoria'";
	if($resCatego=mysql_query($queryCategoria)){
		$rowCategoria=mysql_fetch_array($resCatego);
		$categoriaId=$rowCategoria["CategoriaGastoFijoId"];
		$queryGuardar="INSERT INTO GastoFijo(GastoFijoId, CategoriaGastoFijoId, Descripcion, Costo, PuntoVentaId, Activo) VALUES (NULL, $categoriaId, '$descripcion', '$costo', $puntoId,1)";
		if(mysql_query($queryGuardar)){
			header("Location: ../gastosPuntoVenta.php?id=$puntoId");
		}else{
			echo "error al consultar: ".$queryGuardar.mysql_error();
		}
	}else{
		echo "error al consultar".$queryCategoria.mysql_error(); 
	}

	
?>