<?php
	/*$servidor='solucellventas.com.mx';
	//$usuario='solvtas_renov';
	//$contraseņa='renov@2017';
	//$nombrebd='solvtas_renovaciones'; 
	error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
	/*$conexion= mysql_connect($servidor,$usuario,$contraseņa,$nombrebd);

	if($conexion){
		echo 'Conexion Exitosa';
		}else{
			 echo 'Error al conectar: <br>'.mysqli_connect_error();
		}*/
			//error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
			//error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
		$conexion = mysql_connect("127.0.0.1", "solucell_consult", "consulta3.14");

if (!$conexion) {
    echo "No pudo conectarse a la BD: " . mysql_error();
    exit;
}

if (!mysql_select_db("solucell_system")) {
    echo "No ha sido posible seleccionar la BD: " . mysql_error();
    exit;
}
?>