<?php 
	include("conexion.php");
	$ordenPedido=$_POST["ordenPedido"];
	$queryEquipos="SELECT * FROM Equipos WHERE OrdenPedido=1";
	if($resEquipos=mysql_query($queryEquipos)){
		while($rowEquipos=mysql_fetch_array($resEquipos)){
			if($_POST[$rowEquipos["EquipoId"]]>0){
				$equipoId=$rowEquipos["EquipoId"];
				$cantidad=$_POST[$rowEquipos["EquipoId"]];
				if(mysql_query("INSERT INTO EquiposPedido(EquipoPedidoId, OrdenPedido, EquipoId, Cantidad, TipoEquipo, Activo) VALUES (NULL, '$ordenPedido',$equipoId,$cantidad,1,1)")){
					$querySelect="SELECT M.Marca AS Marca, E.Equipo AS Equipo, E.EquipoId AS EquipoId, EP.Cantidad FROM EquiposPedido AS EP INNER JOIN Equipos AS E ON EP.EquipoId=E.EquipoId INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE EP.OrdenPedido='$ordenPedido' AND EP.Activo=1 AND EP.TipoEquipo=1 ORDER BY M.Marca, E.Equipo";
					if($resEquiposPedido=mysql_query($querySelect)){
						echo '
						<div align="center"><br><br><h4><span class="glyphicon glyphicon-phone"> </span> Equipos no Registrados en Pedido</h4>
		</div>
						';
						echo "<table class='table table-hover'>
						<tr style='background:#23602E; color: #FFFFFF;'>
							<td>Marca</td>
							<td>Modelo</td>
							<td>Solicitud</td>
							<td>Aprobados</td>
						</tr>
						
						";
						while($rowEquiposPedido=mysql_fetch_array($resEquiposPedido)){
							echo "
							<tr>
									<td>".$rowEquiposPedido["Marca"]."</td>
									<td>".$rowEquiposPedido["Equipo"]."</td>
									<td>0</td>
									<td><input type='number' value='".$rowEquiposPedido["Cantidad"]."' name='".$rowEquiposPedido["EquipoId"]."' style='width: 60px;'></td>
									
							
							</tr>";
						}
						echo "</table>";
					}else{
						echo "error al consultar: ".$querySelect.mysql_error();
					}
				}
				$band=1;
			}
		}
		if($band!=1){
			echo "no se agrego Equipo";
		}
	}
?>