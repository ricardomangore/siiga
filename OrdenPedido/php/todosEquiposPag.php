<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
require_once("../PHPPaging.lib/PHPPaging.lib.php");
$band1=0;	
$band2=0;
$band3=0;
$band4=0;
$band5=0;
$band6=0;
$band7=0;
$band8=0;
$band9=0;
$band10=0;
$band11=0;
$band12=0;
$band13=0;
$band14=0;
$band15=0;

$mensaje='';
$pagina= new PHPPaging;
$pagina->agregarConsulta("SELECT E.MarcaId AS MarcaId, E.EquipoId AS EquipoId, E.Equipo AS Equipo FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE M.Activo=1 AND E.Activo=1 ORDER BY M.Marca, E.Equipo");


if($pagina->ejecutar()){

//Pedimos todos los datos
//$consulta = mysqli_query($conexion, "SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada WHERE C.Validado=0 ORDER BY FechaFinContrato DESC");
//Mostramos los datos
$cont=0;
				$clase="nuevo";
				echo '
					
				<table class="table table-hover" style="width: 70%">
   		<tr style="background: #0574AC; color: white">
   			<td><b>Id Producto</b></td>
   			<td><b>Descripci&oacute;n Equipos</b></td>
   			<td><b>Precio sin Iva</b></td>
   			<td><b>Cantidad</b></td>
   			
   		</tr>';
  
//while($resultados = mysqli_fetch_array($consulta)) {
	$cont=0;
		 while($row=$pagina->fetchResultado()){
			 if($cont%2==1){
				 $clase='class="alert alert-info"';
			 }else{
				  $clase='class="alert alert-primary"';
			 }
			 $cont++;
			 			if($row["MarcaId"]==2 && $band1==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "ALCATEL";?></b></td>
							</tr>
							<?php
							$band1=1;
						}elseif($row["MarcaId"]==3 && $band2==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "APPLE";?></b></td>
							</tr>
							<?php
							$band2=1;
						}elseif($row["MarcaId"]==5 && $band3==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "HTC";?></b></td>
							</tr>
							<?php
							$band3=1;
						}elseif($row["MarcaId"]==6 && $band4==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "HUAWEI";?></b></td>
							</tr>
							<?php
							$band4=1;
						}elseif($row["MarcaId"]==7 && $band5==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "LG";?></b></td>
							</tr>
							<?php
							$band5=1;
						}elseif($row["MarcaId"]==8 && $band6==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "MOTOROLA";?></b></td>
							</tr>
							<?php
							$band6=1;
						}elseif($row["MarcaId"]==10 && $band7==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "SAMSUNG";?></b></td>
							</tr>
							<?php
							$band7=1;
						}elseif($row["MarcaId"]==11 && $band8==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "SONY";?></b></td>
							</tr>
							<?php
							$band8=1;
						}elseif($row["MarcaId"]==12 && $band9==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "ZTE";?></b></td>
							</tr>
							<?php
							$band9=1;
						}elseif($row["MarcaId"]==13 && $band10==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "SIMCARD";?></b></td>
							</tr>
							<?php
							$band10=1;
						}elseif($row["MarcaId"]==16 && $band11==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "WSA";?></b></td>
							</tr>
							<?php
							$band11=1;
						}elseif($row["MarcaId"]==20 && $band12==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "TRENDNET";?></b></td>
							</tr>
							<?php
							$band12=1;
						}elseif($row["MarcaId"]==23 && $band13==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "LENOVO";?></b></td>
							</tr>
							<?php
							$band13=1;
						}elseif($row["MarcaId"]==24 && $band14==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "HISENSE";?></b></td>
							</tr>
							<?php
							$band14=1;
						}elseif($row["MarcaId"]==25 && $band15==0){
							?>
							<tr align="center">
							<td colspan="4" style="background:#01B1FA; color: white"><b><?php echo "AFFIX";?></b></td>
							</tr>
							<?php
							$band15=1;
						}	
			 				$equipo=$row["Equipo"];
			 				$equipoId=$row["EquipoId"];
			 ?>
			 		<tr <?php echo $clase; ?>>
							<td style="color: black;"><?php echo $equipoId; ?></td>
							<td style="color: black;"><?php echo $equipo; ?></td>
							<?php
								$queryCosto="SELECT Costo FROM OrdenesCompra WHERE EquipoId=$equipoId AND Costo>0";
								if($resCosto=mysql_query($queryCosto)){
									$rowCosto=mysql_fetch_array($resCosto);
									$costo=$rowCosto["Costo"];
									$costo=number_format(($costo),2,'.',',');
								}
							?>
							<td style="color: black;"> MXN $ <?php echo $costo; ?></td>
							<td style="color: black;"><input type="number" style="width: 60px;" value="0"></td>
							
						</tr>
			 
			 <?php
		 };
	echo '</table>
   		<div style="width: 90%;">
   			<div align="right">
   				<button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span> A&ntilde;adir al Carrito</button>
   			</div>';

	   echo 'Paginas'.$pagina->fetchNavegacion();
   		echo '</div>';

if($cont==0){
	echo '<div align="center"><b>No existen Registros</b><br></div>';
	// echo 'Error al conectar: <br>'.mysqli_connect_error();
	}
echo $mensaje;

}else{
	  echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;
}
?>