<?php 
	include("conexion.php");
	include("operaciones.php");
	if(isset($_POST["recalcular"])){
		$ordenPedido=$_POST["ordenPedido"];
		if($resPedido=mysql_query("SELECT Equipos FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido")){
			$rowPedido=mysql_fetch_array($resPedido);
			if($rowPedido["Equipos"]=='Pendiente'){
				$equipos2='';
			}else{
				$equipos2='';
			}
		}
		$cont=0;
		$resultado=mysql_query("SELECT E.EquipoId AS EquipoId, M.MarcaId AS MarcaId FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE E.Activo=1 ORDER BY M.Marca");
		while($rowEquipos=mysql_fetch_array($resultado)){
			if($_POST[$rowEquipos["EquipoId"]]>0){
				$equipos2=$equipos2.$rowEquipos["EquipoId"]."-".$_POST[$rowEquipos["EquipoId"]].",";
				$cont++;
			}
		}
		if($cont==0){
			if(mysql_query("UPDATE OrdenPedido SET Equipos='Pendiente' WHERE OrdenPedidoId=$ordenPedido")){
			header("location: ../carritoCompras.php");
		}else{
			echo mysql_error();
		}
		}else{
		if(mysql_query("UPDATE OrdenPedido SET Equipos='$equipos2' WHERE OrdenPedidoId=$ordenPedido")){
			header("location: ../carritoCompras.php");
		}else{
			echo mysql_error();
		}

		}	
		}elseif(isset($_POST["finalizar"])){
			$ordenPedido=$_POST["ordenPedido"];
			$plataforma=$_POST["plataforma"];
			if($plataforma=='--Seleccionar Plataforma--'){
				?>
				<script>
					alert('Seleccionar una plataforma para continuar');
					window.location.href='../carritoCompras.php';
				</script>
				<?php
			}else{
				if(mysql_query("UPDATE OrdenPedido SET Plataforma='$plataforma' WHERE OrdenPedidoId=$ordenPedido")){
					header("location: ../finPedido.php");
				}else{
					echo mysql_error();
				}
					//header("location: ../finPedido.php");
				}
		}
	
?>