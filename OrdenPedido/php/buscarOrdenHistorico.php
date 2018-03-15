<?php
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
$numeroSemana = date("W"); 
//Variable de búsqueda
$consultaBusqueda = $_POST['valorBusqueda'];
//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$consultaBusqueda = str_replace($caracteres_malos, $caracteres_buenos, $consultaBusqueda);
//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

//Comprueba si $consultaBusqueda está seteado
if (isset($consultaBusqueda)) {

	//Selecciona todo de la tabla mmv001 
	//donde el nombre sea igual a $consultaBusqueda, 
	//o el apellido sea igual a $consultaBusqueda, 
	//o $consultaBusqueda sea igual a nombre + (espacio) + apellido
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, OP.Folio AS Folio, OP.Semana AS Semana, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE (OP.Folio LIKE '%$consultaBusqueda%'
	OR PV.PuntoVenta LIKE '%$consultaBusqueda%' OR OP.Plataforma LIKE '%$consultaBusqueda%' OR OP.Fecha LIKE '%$consultaBusqueda%' OR OP.Estatus LIKE '%$consultaBusqueda%' OR E.Nombre LIKE '%$consultaBusqueda%' OR Semana LIKE '%$consultaBusqueda%'
	) AND OP.Activo=1 AND OP.Pendiente=0 AND OP.Semana!=$numeroSemana ORDER BY OP.Fecha DESC ";
	$resultado=mysql_query($query);
	/*$consulta = mysqli_query($conexion, ("SELECT C.IdCliente AS IdCliente, C.Nombre AS Nombre, IP.FechaContrato AS FechaContrato, IP.FechaFinContrato AS FechaFinContrato, IP.Dn AS Dn, EL.EstatusLlamada AS EstatusLlamada FROM Clientes AS C INNER JOIN InfoPlan AS IP ON C.IdCliente=IP.IdCliente INNER JOIN EstatusLlamada AS EL ON C.IdEstatusLlamada=EL.IdEstatusLlamada
	WHERE (C.Nombre LIKE '%$consultaBusqueda%'
	OR IP.FechaContrato LIKE '%$consultaBusqueda%'
	OR IP.Dn LIKE '%$consultaBusqueda%'
	OR EL.EstatusLlamada LIKE '%$consultaBusqueda%')"));*/
	//Obtiene la cantidad de filas que hay en la consulta
	if($resultado){
		
	//$filas = mysqli_num_rows($consulta);
	$filas=mysql_num_rows($resultado);

	//Si no existe ninguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
	if ($filas === 0) {
		$mensaje = "<p>No hay ning&uacute;n Resultado para la busqueda actual</p>";
	} else {
		//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
		$cont=0;
				$clase="nuevo";
				echo '
				<div id="global2" style="max-width: 90%; max-height: 400px; overflow-y: scroll;">	
				<table class="table table-hover">

  <tr style="background:#0574AC; color:#FFFFFF;">
  <td>No. Orden</td>
  <td>Punto de Venta</td>
  <td>Plataforma</td>
  <td>Usuario</td>
  <td>Fecha</td>
  <td>Semana</td>
  <td>Estatus</td>
  <td>Seleccionar</td>
  </tr>';
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		
		//while($resultados = mysqli_fetch_array($consulta)) {
			while ($resultados = mysql_fetch_assoc($resultado)) {
			$cont=$cont+1;
		$ordenPedidoId=$resultados["OrdenPedidoId"];
		$folio=$resultados["Folio"];
		$puntoVenta=$resultados["PuntoVenta"];
		$plataforma=$resultados["Plataforma"];
		$usuario=$resultados["Usuario"];
		$fecha=$resultados["Fecha"];
		$semana=$resultados["Semana"];
		$estatus=$resultados["Estatus"];
		if($estatus=="Nuevo"){
			$estatusFin='<span class="label label-info"><span class="glyphicon glyphicon-certificate"></span> Nuevo</span>';
		}elseif($estatus=='En revisi&oacute;n'){
			$estatusFin='<span class="label label-warning">En Revisi&oacute;n</span>';
		}elseif($estatus=='Revisado'){
			$estatusFin='<span class="label label-success">Revisado</span>';
		}elseif($estatus=='Cancelado'){
			$estatusFin='<span class="label label-danger">Cancelado</span>';
		}elseif($estatus=='Finalizado'){
			$estatusFin='<span class="label label-primary">Finalizado</span>';
		}
	$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$folio.'</td>
					<td>'.$puntoVenta.'</td>
					<td>'.$plataforma.'</td>
					<td>'.$usuario.'</td><td>'.$fecha.'</td><td>'.$semana.'</td><td>'.$estatusFin.'</td>
                   <td align="center"><input type="radio" required name="OrdenPedido" value='.$ordenPedidoId.'></td>
                </tr>
			</p>';

		};//Fin while $resultados

	}; //Fin else $filas

}else{
	echo "Error: ".$query.mysql_error();
	}//Fin isset $consultaBusqueda

//Devolvemos el mensaje que tomará jQuery
echo $mensaje;
echo '  </table>
</div>';
}else{
	 echo "<br>No pudo ejecutarse satisfactoriamente la consulta ($sql) " .
         "en la BD: " . mysql_error();
    exit;

}
?>