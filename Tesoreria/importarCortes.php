<?php
include("conexion.php");
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporteCortes.xls");
header("Pragma: no-cache");
header("Expires: 0");
$fechaAux=date("Y-m-d");

//obtenemos el archivo .csv
$tipo = $_FILES['archivo']['type'];
$tamanio = $_FILES['archivo']['size'];
$archivotmp = $_FILES['archivo']['tmp_name'];
//cargamos el archivo
$lineas = file($archivotmp);

 $i=0;
 /*$fecha='21/05/2016';
 $fechaAux=date_create_from_format('d/m/Y','$fecha');
 echo date_format($fechaAux,'Y-m-d');*/
//Recorremos el bucle para leer línea por línea
 echo '<table>
 		<tr>
 			<td style="background: #000000;  color: #FFFFFF;">Fecha</td>
 			<td style="background: #000000;  color: #FFFFFF;">Punto de Venta</td>
 			<td style="background: #000000;  color: #FFFFFF;">referencia</td>
 			<td style="background: #000000;  color: #FFFFFF;">Monto Cobrado</td>
 			<td style="background: #000000;  color: #FFFFFF;">Monto Cobrado Real</td>
 			<td style="background: #000000;  color: #FFFFFF;">Ficha Deposito</td>
 			<td style="background: #000000;  color: #FFFFFF;">Estatus</td>
 		    <td style="background: #000000;  color: #FFFFFF;">Estatus Referencia</td>
 		</tr>';
foreach ($lineas as $linea_num => $linea)
{ 
   //abrimos bucle
   /*si es diferente a 0 significa que no se encuentra en la primera línea 
   (con los títulos de las columnas) y por lo tanto puede leerla*/
   if($i != 0) 
   { 
	   	
       //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
       /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
       leyendo hasta que encuentre un ; */
       $datos = explode(",",$linea);
       //Almacenamos los datos que vamos leyendo en una variable
	   $tienda = trim($datos[0]);
	   $fecha=trim($datos[1]);
	   $importe=trim($datos[2]);
	   $referencia=trim($datos[3]);
	   //$query="SELECT Monto, Ficha FROM Depositos WHERE (Deposito='$referencia' OR ) AND TipoDepositoId=9";
	   
	   $query="SELECT T1.PuntoVentaId, Monto, Ficha,Deposito FROM Depositos AS T1 INNER JOIN PuntosATT AS T2 ON T1.PuntoVentaId=T2.PuntoVentaId
 WHERE TipoDepositoId=9 AND Fecha='$fechaAux' AND (PuntosDepositos LIKE '%$tienda%' OR Deposito='$referencia')";
	   if($res=mysql_query($query)){
	   		if(mysql_num_rows($res)>0){
	   			$row=mysql_fetch_array($res);
	   			if($importe==$row["Monto"]){
	   				$estatus='Coincide';
	   			}else{
	   				$estatus='No Coincide';
	   			}
	   			if($referencia==$row[Deposito]){
	   			    	$estatusR='Coincide';
	   			}else{
	   			    	$estatusR='No Coincide Referencia';
	   			}
	   			echo '
	   				<tr>
			 			<td>'.$fecha.'</td>
 						<td>'.$tienda.'</td>
 						<td>'.$referencia.'</td>
 						<td>$ '.number_format($row["Monto"],2,'.',',').'</td>
 						<td>$ '.number_format($importe,2,'.',',').'</td>
 						<td><a href="http://www.solucell.com.mx/siiga/'.$row["Ficha"].'">Ver Ficha</a></td>
 						<td>'.$estatus.'</td>
 						<td>'.$estatusR.'</td>
 					</tr>';
	   		}
	   }

	   
       //cerramos condición
   }
 	
   /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
   entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
   $i++;
   //cerramos bucle
}





//funcion para ver puntos que no subieron corte
$Q0="SELECT PV.PuntoVentaId, PV.PuntoVenta FROM PuntosVenta AS PV  WHERE PV.Activo=1 AND PV.TipoPuntoId!=3 AND PV.PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,545,549,534) ORDER BY PuntoVenta";

if($res2=mysql_query($Q0)){
	while ($row2=mysql_fetch_array($res2)) {
		$Q2="SELECT PuntoVentaId FROM Depositos WHERE TipoDepositoId=9 AND PuntoVentaId=$row2[0] AND Fecha='$fechaAux'";
		if($res3=mysql_query($Q2)){
			if(mysql_num_rows($res3)==0){
				echo '
	   				<tr>
			 			<td>'.$fecha.'</td>
 						<td>'.$row2[1].'</td>
 						<td>No Disponible</td>
 						<td>0</td>
 						<td>0</td>
 						<td>No Disponible</td>
 						<td>No realizo Deposito</td>
 							<td>No Existe Referencia</td>
 					</tr>';
			}
		}
	}
}


echo '</table>';
?>