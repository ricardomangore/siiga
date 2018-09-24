<?php
	include("conexion.php");
	$puntoId=$_POST["puntoId"];
	$nombre=$_POST["nombre"];
	$noe=$_POST["noe"];
	$pvs=$_POST["pvs"];
	$comentario=$_POST["comentario"];


	
	$query="INSERT INTO UsuariosPlataformas(UsuarioPlataformaId, PuntoVentaId, NombreCompleto, UsuarioNOE, UsuarioPVS, Comentarios, Activo) VALUES (NULL, $puntoId,'$nombre', '$noe', '$pvs', '$comentario',1)";
	if(mysql_query($query)){
		header("Location: ../usuarios.php?id=$puntoId");
	}else{
		echo "error al consultar: ".$query.mysql_error();
	}
?>