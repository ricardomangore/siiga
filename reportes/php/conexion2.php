<?php
	/*$servidor='solucellventas.com.mx';
	//$usuario='solvtas_renov';
	//$contraseña='renov@2017';
	//$nombrebd='solvtas_renovaciones'; 
	error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
	/*$conexion= mysql_connect($servidor,$usuario,$contraseña,$nombrebd);

	if($conexion){
		echo 'Conexion Exitosa';
		}else{
			 echo 'Error al conectar: <br>'.mysqli_connect_error();
		}*/
			error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
		$conexion = mysql_connect("solucell.com.mx", "solucell_consult", "consulta3.14");
//$conexion = mysql_connect("localhost", "root", "");

if (!$conexion) {
    echo "No pudo conectarse a la BD: " . mysql_error();
    exit;
}

if (!mysql_select_db("solucell_system")) {
    echo "No ha sido posible seleccionar la BD: " . mysql_error();
    exit;
}
?>