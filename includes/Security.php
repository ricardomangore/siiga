<?php
class Security extends Conectar
{
	var $Mensaje='';	
	function Security()
	{		
		$this->Conectar();		
	return;
	}//Tools

	function getMensaje(){
		return $this->Mensaje;
	}

	function Consulta($sql)
	{
		$Query=mysql_query("$sql", $this->conexion) or die("Error al Consultar: ".mysql_error());
	return $Query;
	}//Consulta

	function Insertar($sql)
	{
		$query=mysql_query("$sql", $this->conexion) or die("Error al Insertar: $sql ".mysql_error());
		$Identificador= mysql_insert_id($this->conexion);
	return $Identificador;
	}//Insertar

	function Fin()
	{
		mysql_close($this->conexion);
	}//Fin

	function CreaSesion($Usuario, $Pwd)
	{	
	$Q0="SELECT T1.UsuarioId, T2.EmpleadoId, CONCAT_WS(' ', T2.Nombre, T2.Paterno, T2.Materno) AS Nombre, IFNULL(TipoBloqueo,0), T1.Activo
		 FROM Usuarios AS T1
		 LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
		 LEFT JOIN CorreosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
     	 LEFT JOIN TiposBloqueo AS T4 ON T4.TipoBloqueoId=T1.TipoBloqueoId
		 WHERE REPLACE(T3.Correo,'@solucell.com.mx','')='$Usuario' AND T1.Password=MD5('$Pwd')";
	$R0=$this->Consulta($Q0);
	list($UsuarioId, $EmpleadoId, $Empleado, $Bloqueo, $Activo) = mysql_fetch_row($R0);
		if(isset($UsuarioId))
		{
			$Query="SELECT TipoBloqueoId,TipoBloqueoId2 FROM Usuarios WHERE UsuarioId=$UsuarioId";
			$res=$this->Consulta($Query);
			$row=mysql_fetch_array($res);
			$TipoBloqueo1=$row[0];
			$TipoBloqueo2=$row[1];



			if($Activo=='0')
			{
			$this->Mensaje='Usuario inactivo';
			return false;
			}

			if($Bloqueo=='0' && $TipoBloqueo1==0 && $TipoBloqueo2==0)
			{
			session_start();
			$_SESSION['UsuarioId']=$UsuarioId;
			$_SESSION['EmppleadoId']=$EmpleadoId;
			$_SESSION['Empleado']=$Empleado;
			if($Pwd=='12345')
			$_SESSION['Mensaje']='<span class="Informativo">Tu contraseña no es segura, por favor cambiala y no la compartas con nadie</span>';
			else
			$_SESSION['Mensaje']='<span class="Informativo">Recuerda que la cuenta es personal, no debes compartirla</span>';

			return true;
			}
			elseif($TipoBloqueo1!=0 || $TipoBloqueo2!=0)
			{
				if($TipoBloqueo1==1 && $TipoBloqueo2==1){
					$this->Mensaje="El Usuario Presenta Bloqueo de Tesoreria E Inventarios";
					return false;
				}elseif($TipoBloqueo1==1 && $TipoBloqueo2==0){
					$this->Mensaje="Bloqueo Falta Inventario Semanal";
					return false;
				}elseif($TipoBloqueo1==0 && $TipoBloqueo2==1){
					$this->Mensaje="Bloqueo Por Tesoreria";
					return false;
				}else{
					$this->Mensaje=$Bloqueo;
					return false;
				}

				
			}
		}
		$this->Mensaje='Usuario y/o contraseña no validos';
	return false;
	}//CreaSesion



	function SesionExiste()
	{
	session_start();
		if(!isset($_SESSION['UsuarioId']) || $_SESSION['UsuarioId']==0)	
			return false;
		return true;
	}

	
	function CerrarSesion()
	{
		if (!isset($_SESSION)) 
			session_start();	

		$_SESSION['UsuarioId']=NULL;
		$_SESSION['EmppleadoId']=NULL;
		$_SESSION['Empleado']=NULL;

		unset($_SESSION['UsuarioId']);
		unset($_SESSION['EmppleadoId']);
		unset($_SESSION['Empleado']);
	}	


}
?>
