<?php
include("conexion.php");
if(isset($_POST['get_option']))
{

$categoria = $_POST['get_option'];
$query="SELECT CategoriaActivoFijoId FROM CategoriaActivoFijo WHERE Categoria='$categoria'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);
$categoriaId=$row['CategoriaActivoFijoId'];
 $find=mysql_query("SELECT ClasificacionActivoFijo FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=$plataformaId AND Activo=1");
	echo "<option>--Seleccionar Categoria--</option>";
 while($row=mysql_fetch_array($find))
 {
  echo "<option>".$row['ClasificacionActivoFijo']."</option>";
 }
 exit;
}
?>