<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
$ordenPedidoId=$_GET["id"];
$mensaje='';
$time=time();
date_default_timezone_set('America/Mexico_City');
$fecha=date("Y-m-d", $time);
$fechaResta=date("Y-m-d", strtotime('-4 week'));
//echo $fecha." fecha Anterior: ".$fechaResta;


$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
//echo $query;
$resultado=mysql_query($query);
if($resultado){
	
//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
$cont=0;	
	$resultados = mysql_fetch_assoc($resultado);
	$plataforma=$resultados["Plataforma"];
	   if(trim($plataforma)==('AVS Azul')){
		 $fondo='style="background: #009EDB; color: #FFFFFF;"';
		   $clase="info";
	   }elseif(trim($plataforma)==('NOE Naranja')){
		   $fondo='style="background: #E05206; color: #FFFFFF;"';
		   $clase="warning";
	   }elseif(trim($plataforma)==('PVS Rojo')){
		   $fondo='style="background: #E30412; color: #FFFFFF;"';
		   $clase="danger";
	   }
				//$clase="nuevo";
				echo '
				
				<table class="table table-hover">

  <tr '.$fondo.'>
  <td>Marca</td>
  <td>SKU</td>
  <td>Modelo</td>
  <td>Solicitud</td>
  <td>Aprobados</td>
  </tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {

		$cont++;
		//echo $resultados["Equipos"];
		
		
		
		
		
		
		//echo "<br><br>El número de elementos en el array es: " .($tam-1)."<br>";
		$queryEquipos="SELECT E.EquipoId AS EquipoId, E.NombreConsigna AS NombreConsigna,  E.Equipo AS Equipo, M.Marca AS Marca FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE E.OrdenPedido=1 ORDER BY M.Marca, E.Equipo";
		if($resultadoEquipos=mysql_query($queryEquipos)){
			$contador=0;
			while($rowEquipos=mysql_fetch_array($resultadoEquipos)){
				if($contador%2==0){
					$claseaux=$clase;
				}else{
					$claseaux="Sin clase";
				}
				$equipos=explode(",",$resultados["Equipos"]);
				$tam=count($equipos);
				for($i=0;$i<$tam;$i++){
					$prueba=explode("-",$equipos[$i]);
					if($rowEquipos["EquipoId"]==$prueba[0]){
					$marca=$rowEquipos["Marca"];
					$equipo=$rowEquipos["Equipo"];
					$nombreConsigna=$rowEquipos["NombreConsigna"];
					$cantidad=$prueba[1];	
						echo "<tr class='$claseaux'>
					<td>".$marca."</td>
					<td>".$nombreConsigna."</td>
					<td>".$equipo."</td>
					<td align='center'>".$cantidad."</td>
					<td align='center'><input type='number' style='width: 35px;' value='$cantidad' name='$prueba[0]'></td>
					<tr>";
						$contador++;
					}
				}
			}
		}
		
if($cont==0){
	echo '<div align="center"><b>No existen Registros</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;
echo '  </table>';
}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>