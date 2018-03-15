<?php
	include("conexion.php");
	$equiposAux="";
	$ordenPedidoId=$_POST["ordenPedidoId"];
	//echo "Orden Pedido: ".$ordenPedidoId."<br>";
	$queryEquipos="SELECT E.EquipoId AS EquipoId FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE E.OrdenPedido=1";
	if($resEquipos=mysql_query($queryEquipos)){
		while($rowEquipos=mysql_fetch_array($resEquipos)){
			if($_POST[$rowEquipos["EquipoId"]]>0){
				$equiposAux=$equiposAux.$rowEquipos["EquipoId"]."-".$_POST[$rowEquipos["EquipoId"]].",";
			}
		}
	}
	$queryFin="UPDATE OrdenPedido SET EquiposFinal='$equiposAux', Estatus='Finalizado', Finalizado=1 WHERE OrdenPedidoId=$ordenPedidoId";
	if(mysql_query($queryFin)){
		header("Location: ../ordenPedido.php");
	}else{
		echo "Error al actualizar: ".$queryFin.mysql_error();
	}
	
	
?>