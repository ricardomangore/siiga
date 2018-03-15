<?php
	include("conexion2.php");
	$usuario=trim($_POST["usuario"]);
	$usuarioAux=explode("@",$usuario);
	if($usuarioAux[1]==''){
		$usuario=$usuario."@solucell.com.mx";
	}elseif($usuarioAux[1]=='solucell.com.mx'){
		$usuario=$usuario;
	}else{
		//echo $usuario=$usuario;
	}
	$pass=md5($_POST["pass"]);
	$query="SELECT  CONCAT(E.Nombre, ' ', E.Paterno, ' ', E.Materno) AS Nombre, HPE.PuestoId AS PuestoId, U.UsuarioId AS UsuarioId FROM CorreosEmpleados AS CE INNER JOIN Empleados AS E ON E.EmpleadoId=CE.EmpleadoId INNER JOIN Usuarios AS U ON E.EmpleadoId=U.EmpleadoId INNER JOIN HistorialPuestosEmpleados AS HPE ON U.EmpleadoId=HPE.EmpleadoId WHERE  CE.Correo='$usuario' AND U.Password='$pass' AND (HPE.PuestoId=13 OR HPE.PuestoId=17 OR HPE.PuestoId=23 OR HPE.PuestoId=55 OR HPE.PuestoId=54 OR HPE.PuestoId=7 OR HPE.PuestoId=68 OR HPE.PuestoId=69 OR HPE.PuestoId=22 OR HPE.PuestoId=62 OR HPE.PuestoId=16 OR HPE.PuestoId=16 OR HPE.PuestoId=53 OR HPE.PuestoId=61 OR HPE.PuestoId=75 OR HPE.PuestoId=5 OR HPE.PuestoId=9) AND HPE.FechaBaja='0000-00-00' AND U.Activo=1";
	if($res=mysql_query($query)){
		if(mysql_num_rows($res)>0){
			$row=mysql_fetch_array($res);
			$nombre=$row["Nombre"];
			$puestoId=$row["PuestoId"];
			$usuarioId=$row["UsuarioId"];
			//echo $nombre;
			session_start();
			//Declaro mis variables de sesión
			$_SESSION["autentificado"] = true;
			$_SESSION["usuario"]=$nombre;
			$_SESSION["puestoId"]=$puestoId;
			$_SESSION["usuarioId"]=$usuarioId;
			header("Location: ../recargas.php");
		}else{
			header("Location: ../index.php?error=si");
		}
	}else{
		echo "Error al consultar".$query.mysql_error();
	}
	
?>