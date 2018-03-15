<?php 
	include("conexion.php");
	include("operaciones.php");
	$ordenPedido=$_POST["ordenPedido"];
	//echo "ordenPedido".$ordenPedido;
	if($resPedido=mysql_query("SELECT Equipos FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido")){
		$rowPedido=mysql_fetch_array($resPedido);
		if($rowPedido["Equipos"]=='Pendiente'){
			$equipos2='';
		}else{
			$equipos2=$rowPedido["Equipos"];
		}
	}
	
	$cont=0;
	$resultado=mysql_query("SELECT E.EquipoId AS EquipoId, M.MarcaId AS MarcaId FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE E.Activo=1 ORDER BY M.Marca");
	while($rowEquipos=mysql_fetch_array($resultado)){
		if($_POST[$rowEquipos["EquipoId"]]>0){
			//echo $_POST[$rowEquipos["EquipoId"]]."-".$rowEquipos["EquipoId"]."<br>";
		//	$equipos[$cont]=$_POST[$rowEquipos["EquipoId"]]."-".$rowEquipos["EquipoId"];
			$equipos2=$equipos2.$rowEquipos["EquipoId"]."-".$_POST[$rowEquipos["EquipoId"]].",";
			$cont++;
		}
	}

	
if($cont==0){
	?>
	<script>
alert('Al menos solicita un Equipo para poder agregarlo al Carrito');
window.location.href='../equipos3.php';
</script>
	<?php
}else{
	if(mysql_query("UPDATE OrdenPedido SET Equipos='$equipos2' WHERE OrdenPedidoId=$ordenPedido")){
		header("location: ../equipos3.php");
	}else{
		echo mysql_error();
	}

}
/*	for($i=0;$i<$cont;$i++){
		echo $equipos[$i].",";
	}*/
			//echo $plataforma."<br>".$equipos2;
			
		
			/*	$time=time();
			date_default_timezone_set('America/Mexico_City');
			$fecha=date("Y-m-d H:i:s", $time);
			if($cont>0){
				$query="INSERT INTO OrdenPedido(OrdenPedidoId, PuntoVentaId, Plataforma, Equipos, EquiposAux, EquiposInicial, Fecha, UsuarioId, Estatus, Activo) VALUES (NULL, $puntoVentaId,'$plataforma','$equipos2','$equipos2','$fecha',$usuarioId,'Nuevo',1)";
				if($resQuery=mysql_query($query)){
					
					echo '<div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span> Correcto</b> Orden de pedido guardado con exito</div>';
				}else{
					echo("Error al insertar : ".$query.mysql_error());
				}
				
			}else{
				echo '<div class="alert alert-warning"><b><span class="glyphicon glyphicon-remove-circle"></span> Error</b> Debes de agregar al menos un equipo</div>';
			}*/

	
?>