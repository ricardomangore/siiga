<?php
	include("conexion.php");
	$fechaInicio=$_POST["fechaInicio"];
	$fechaFin=$_POST["fechaFin"];
	if($fechaInicio==''){
		echo '<script>
			alert("Error en fecha Inicio\nFavor de Ingresar una fecha valida");
			window.location.href="../recargas.php";
		</script>';
	}elseif($fechaFin==''){
		echo '<script>
			alert("Error en fecha Fin\nFavor de Ingresar una fecha valida");
			window.location.href="../recargas.php";
			</script>';
	}elseif($fechaFin<$fechaInicio){
			echo '<script>
			alert("Error en fecha Fin\nFavor de Ingresar una fecha mayor igual a la fecha inicio");
			window.location.href="../recargas.php";
			</script>';
	}else{
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=reporteRecarga.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	$condiciones="(T1.Fecha>='".$fechaInicio."' AND T1.Fecha<='".$fechaFin."')";
	$query="SELECT D.DepositoId AS DepositoId, D.Deposito AS Deposito, D.FechaHora AS FechaHora, TP.TipoDeposito AS TipoDeposito, D.Monto AS Monto, CONCAT('http://solucell.com.mx/siiga/',D.Ficha) AS Ficha, D.Fecha AS Fecha, D.Hora AS Hora, P.PuntoVenta AS PuntoVenta, D.Validado AS Validado, D.Comentarios AS Comentarios
FROM Depositos D
INNER JOIN PuntosVenta P
ON D.PuntoVentaId=P.PuntoVentaId INNER JOIN TiposDepositos TP
ON D.TipoDepositoId=TP.TipoDepositoId WHERE D.Fecha='2017-11-07' AND (TP.TipoDepositoId=2 OR TP.TipoDepositoId=3) ORDER BY TP.TipoDepositoId;";
	//echo "$condiciones";
	if($res=mysql_query($query)){
		$i=0;
		echo "<table border='0'>
				<tr style='background: #00ABE2; color: #FFFFFF'>
					<td><b><font face='arial black'>DepositoId</font></b></td>
					<td><b><font face='arial'>Deposito</font></b></td>
					<td><b><font face='arial'>FechaHora</font></b></td>
					<td><b><font face='arial'>TipoDeposito</font></b></td>
					<td><b><font face='arial'>Monto</font></b></td>
					<td><b><font face='arial'>Ficha</font></b></td>
					<td><b><font face='arial'>Fecha</font></b></td>
					<td><b><font face='arial'>Hora</font></b></td>
					<td><b><font face='arial'>Punto de Venta</font></b></td>
					<td><b><font face='arial'>Validado</font></b></td>
					<td><b><font face='arial'>Comentarios</font></b></td>
					
				</tr>
				
		
		";
		$con=0;
		while($row=mysql_fetch_array($res)){
			
		
			if($con%2==1){
				$tr="<tr style='background: #DFF8FF; color: #000000'>";
			}else{
				$tr="<tr>";
			}
			$con++;
			echo "
			$tr
					<td><font face='arial'>".$row["DepositoId"]."</font></td>
					<td><font face='arial'>".$row["Deposito"]."</font></td>
					<td><font face='arial'>".$row["FechaHora"]."</font></td>
					<td><font face='arial'>".$row["TipoDeposito"]."</font></td>
					<td><font face='arial'>".$row["Monto"]."</font></td>
					<td><font face='arial'><a href='".$row["Ficha"]."'><span class='glyphicon glyphicon-eye-open'></span> Ver Ficha</a></font></td>
					<td><font face='arial'>".$row["Fecha"]."</font></td>
					<td><font face='arial'>".$row["Hora"]."</font></td>
					<td><font face='arial'>".$row["PuntoVenta"]."</font></td>
					<td><font face='arial'>".$row["Validado"]."</font></td>
					<td><font face='arial'>".$row["Comentarios"]."</font></td>
				</tr>
			
			";
			
		}
		echo "</table>";
	}else{
		echo "error: ".mysql_error();
	}

	}
?>