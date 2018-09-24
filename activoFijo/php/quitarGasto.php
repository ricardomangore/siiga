<?php
	include("conexion.php");
	$query="SELECT GastoFijoId, PuntoVentaId FROM GastoFijo WHERE Activo=1";
	if($res=mysql_query($query)){
		while($row=mysql_fetch_array($res)){
			if(isset($_REQUEST[$row["GastoFijoId"]])){
				$gastoFijoId=$row["GastoFijoId"];
				$puntoId=$row["PuntoVentaId"];
		}
	}
		$queryGasto="UPDATE GastoFijo SET Activo=0 WHERE GastoFijoId=$gastoFijoId";
		if(mysql_query($queryGasto)){
			header("Location: ../gastosPuntoVenta.php?id=$puntoId");
		}else{
			echo "Error al consultar: ".$queryGasto.mysql_error();
		}
	}else{
		echo "Error al consultar: ".$query.mysql_error();
	}
?>