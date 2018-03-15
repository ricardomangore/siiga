<?php 
//Archivo de conexión a la base de datos
require('conexion.php');
include("operaciones.php");
function equiposCarrito($ordenPedidoId, $puntoVentaId){
$equipostotalPedido=0;
$precioTotalPedido=0;
$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
$resultado=mysql_query($query);
if($resultado){
	$cont=0;	
	$resultados = mysql_fetch_assoc($resultado);
	$cont++;
	$equipos=explode(",",$resultados["Equipos"]);
	$tam=count($equipos);
	for($i=0;$i<($tam-1);$i++){
		$prueba=explode("-",$equipos[$i]);
		$queryEquipos="SELECT M.Marca AS Marca, E.Equipo AS Equipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$prueba[0]";
		$rowEquipos=mysql_query($queryEquipos);
		$resEquipos=mysql_fetch_array($rowEquipos);
		$auxPrecio=(precioEquipo($prueba[0],$puntoVentaId))*($prueba[1]);
		$precioTotalPedido=$precioTotalPedido+$auxPrecio;
		$cantidad=$prueba[1];
		$equipostotalPedido=$equipostotalPedido+$cantidad;
		}
}
	return($equipostotalPedido);
}
?>