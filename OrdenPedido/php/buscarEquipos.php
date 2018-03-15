<?php
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
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
	$query="SELECT M.Marca AS Marca, E.EquipoId AS EquipoId, E.Equipo AS Equipo, E.CostoEquipo AS CostoEquipo, E.NombreConsigna AS NombreConsigna FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE (E.EquipoId LIKE '%$consultaBusqueda%'
	OR M.Marca LIKE '%$consultaBusqueda%'
	OR E.Equipo LIKE '%$consultaBusqueda%') AND  M.Activo=1 AND E.Activo=1 AND E.OrdenPedido=1 ORDER BY M.Marca, E.Equipo";
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
		echo '<div align="center">Resultados para:  <strong>'.$consultaBusqueda.'</strong></div>';
				$cont=0;
				$clase="nuevo";
				echo '
				<div id="global2" style="max-width: 100%; min-height:100px; max-height:500px; overflow-y: scroll;">
				<table class="table table-hover">

  <tr style="background:#01B1FA; color:#FFFFFF;">
  <td>Id Prducto</td>
  <td>Marca</td>
  <td>ClaveProducto</td>
  <td>Descripcion de Equipos</td>
  <td>Precion Sin Iva</td>
  <td>Cantidad</td>
  </tr>';
		//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
		
		//while($resultados = mysqli_fetch_array($consulta)) {
			while ($resultados = mysql_fetch_assoc($resultado)) {
			$cont=$cont+1;
	$equipoId=$resultados['EquipoId'];
	$marca=$resultados['Marca'];
	$consigna=$resultados['NombreConsigna'];
	$equipo=$resultados['Equipo'];
	$costo=$resultados['CostoEquipo'];
	$costo=number_format(($costo),2,'.',',');
	if(($cont%2)==0){
		$clase='primary';
	}elseif(($usuarioId%2)==1){
		$clase='info';
	}
	$mensaje .= '
			<p>
			<tr class="'. $clase.'">
                	<td>'.$equipoId.'</td>
					<td>'.$marca.'</td>
					<td>'.$consigna.'</td>
                    <td>'.$equipo.'</td><td>MXN $ '.$costo.'</td><td align="center"><input type="number" required name="'.$equipoId.'" value="0" style="width: 60px;" ></td>
   
                </tr>
			</p>';

		};//Fin while $resultados

	}; //Fin else $filas

};//Fin isset $consultaBusqueda

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