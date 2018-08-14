<?php
class Tools extends Conectar{
	var $UsuarioId;
	var $ClaveLast=0;
	function Tools($UsuarioId)
	{
		$this->Conectar();
		$this->UsuarioId=$UsuarioId;
	return;
	}//Tools

	/* FUNCIONES GENERALES ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

	function Consulta($sql){
		if($sql=='')
			return true;
		$Query=mysql_query("$sql", $this->conexion) or die("Error al Consultar: $sql ".mysql_error());
	return $Query;
	}//Consulta
	function MarcaEquipo($sql){
		if($sql==''){

			return true;
		}else{
			$Query=mysql_query("$sql", $this->conexion) or die("Error al Consultar: $sql ".mysql_error());
			$resultado=mysql_fetch_array($query);
			$MarcaId=$resultado["MarcaId"];
			return $MarcaId;
		}
	}//MarcaEquipo
	function Insertar($sql){
		$query=mysql_query("$sql", $this->conexion) or die("Error al Insertar: $sql ".mysql_error());
		$Identificador= mysql_insert_id($this->conexion);
	return $Identificador;
	}//Insertar

	function Fin(){
		mysql_close($this->conexion);
	}//Fin

	function CambiarFormatoFecha($Fecha){
	    list($Dia,$Mes,$Anio)=explode("/",$Fecha);
   		return $Anio."-".$Mes."-".$Dia;
	}//CambiarFormatoFecha

	function StartTransaccion()
	{
		$Q0="SET AUTOCOMMIT=0";
		$Q1="BEGIN";
		$this->Consulta($Q0);
		$this->Consulta($Q1);
	}//StartTransaccion

	function AceptaTransaccion()
	{
		$Q0="COMMIT";
		$this->Consulta($Q0);
	}//AceptaTransaccion

	function CancelaTransaccion()
	{
		$Q0="ROLLBACK";
		$this->Consulta($Q0);
	}//CancelaTransaccion

	function DiaSemana($Fecha){
		$Fecha2 =$Fecha;
		$separa = explode('-',$Fecha2);
		$dia = $separa[0];
		$mes = $separa[1];
		$anio = $separa[2];
		$dias = array('DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO');
	return $dias[date("w", mktime(0, 0, 0, $mes, $dia, $anio))];
	}//DiaSemana

	function Scroll($tabla,$campo_id,$campo_txt,$valor, $Criterio, $Orden){
		$query="SELECT $campo_id,$campo_txt FROM $tabla WHERE $Criterio GROUP BY $campo_txt ORDER BY $Orden ASC";
		$resultado=mysql_query("$query", $this->conexion) or die(mysql_error());

		while($arreglo=mysql_fetch_row($resultado))
		{
			if ($valor==$arreglo[0])
			{
				echo "<option selected value=\"$arreglo[0]\" title=\"".utf8_decode($arreglo[1])."\" >".utf8_decode($arreglo[1])."</option> \n";
			}
			else
			{
				echo "<option value=\"$arreglo[0]\" title=\"$arreglo[1]\">".utf8_decode($arreglo[1])."</option> \n";
			}
		}
	}//Scroll

	function getOrden($R0)
	{
		$orden = array
		(
		"filas" => mysql_num_rows($R0),
		"columnas" => mysql_num_fields($R0),
		);
		return $orden;
	}//getOrden

	function getHModulo($ModuloId)
	{
		$Q0="SELECT ModuloTxt,Img, Vista FROM Modulos WHERE ModuloId=$ModuloId";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function Existe($Campo, $Valor, $Tabla)
	{
		$Q0="SELECT COUNT($Campo) FROM $Tabla WHERE $Campo='$Valor'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q0));
		if($Cta>0)
			return true;

		return false;
	}

/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/* FUNCIONES USUARIOS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

	function getMenuUsuarios(){
	$Q0="
		SELECT T1.FamiliaId, T1.Familia, T1.Img,T2.Modulo, T2.Url, T2.Img
		FROM Familias AS T1
		LEFT JOIN Modulos AS T2 ON T2.FamiliaId=T1.FamiliaId
		INNER JOIN ModulosOperaciones AS T3 ON T3.ModuloId=T2.ModuloId
		INNER JOIN ModulosOperacionesUsuarios AS T4 ON T4.ModuloOperacionId=T3.ModuloOperacionId AND T4.UsuarioId=$this->UsuarioId
		WHERE T2.Activo=1
		GROUP BY T2.ModuloId
		ORDER BY T1.Familia, T2.Modulo
		";
	return $this->Consulta($Q0);
	}//getMenuUsuarios

	function getPermisosModulo($ModuloId)
	{
		$Q0="SELECT OperacionId FROM ModulosOperacionesUsuarios AS T1
			 LEFT JOIN ModulosOperaciones AS T2 ON T2.ModuloOperacionId=T1.ModuloOperacionId
 			 WHERE ModuloId=$ModuloId AND UsuarioId=$this->UsuarioId";

		$R0=$this->Consulta($Q0);

		 $Permisos=array();

		while($A0=mysql_fetch_row($R0))
		{
			$Permisos[]=$A0[0];
		}
	return $Permisos;
	}//getPermisosLista

	function permisoEdicion($ModuloId)
	{
		$Q0="SELECT COUNT(T1.ModuloOperacionId) FROM ModulosOperacionesUsuarios AS T1
				LEFT JOIN ModulosOperaciones AS T2 ON T2.ModuloOperacionId=T1.ModuloOperacionId
				WHERE OperacionId=5 AND UsuarioId=$this->UsuarioId";
		list($Cta)=mysql_fetch_row($this->Consulta($Q0));
			if($Cta>0)
				return true;
			return false;
	}

	function changePassword($Actual, $Nuevo)
	{
		$this->Consulta("UPDATE Usuarios SET Password=MD5('$Nuevo') WHERE UsuarioId=$this->UsuarioId AND Password=MD5('$Actual')");
		if(mysql_affected_rows()>0)
		return true;
		return false;
	}//changePassword

	function addBitacora($ModuloId, $OperacionId, $ObjetoId, $Comentario, $Equipo)
	{

		$Q0="INSERT INTO Bitacora
			 (BitacoraId, UsuarioId, Host, ModuloId, OperacionId, ObjetoId, Fecha, Hora, Comentario)
			 VALUES(NULL, $this->UsuarioId, '$Equipo', '$ModuloId', '$OperacionId', '$ObjetoId', CURDATE(), CURTIME(), '$Comentario')";
		return $this->Consulta($Q0);
	}

	function isNacional()
	{
		$Q0="SELECT Nacionales FROM Usuarios WHERE UsuarioId=".$this->UsuarioId;
		list($Corporativo)=mysql_fetch_row($this->Consulta($Q0));
		if($Corporativo==1)
			return true;
		return false;
	}

	function getClasificacionVenta()
	{
		$Q0="SELECT Clave
			FROM Usuarios AS T1
			INNER JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.FechaBaja='0000-00-00'
			INNER JOIN ClasificacionPersonalVenta AS T3 ON T3.ClasificacionPersonalVentaId=T2.ClasificacionPersonalVentaId
			WHERE UsuarioId=".$this->UsuarioId;

		list($Venta)=mysql_fetch_row($this->Consulta($Q0));
		return $Venta;
	}

	function isRestringido()
	{
		$Q0="SELECT Restringido FROM Usuarios WHERE UsuarioId=".$this->UsuarioId;
		list($Corporativo)=mysql_fetch_row($this->Consulta($Q0));
		if($Corporativo==1)
			return true;
		return false;
	}

	function getMisPuntos()
	{
		$Venta=$this->getClasificacionVenta();

		if($this->isRestringido())
		$Q0="SELECT T1.PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1
			INNER JOIN
			(SELECT T1.PuntoVentaId, Corporativo
			 FROM HistorialPuntosEmpleados AS T1
			 LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
			 LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
			 WHERE UsuarioId=$this->UsuarioId
			) AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			";
		else
		{

		if($this->isNacional())
		$Q0="SELECT PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1 WHERE ClasificacionPersonalVenta IN ($Venta)";
		else
		$Q0="SELECT PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1
			INNER JOIN
			(SELECT PlazaId, Corporativo
			 FROM HistorialPuntosEmpleados AS T1
			 LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
			 LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
			 WHERE UsuarioId=$this->UsuarioId
			) AS T2 ON T2.PlazaId=T1.PlazaId
			WHERE ClasificacionPersonalVenta IN ($Venta)
			";
		}
	$R0=$this->Consulta($Q0);
	$MisPuntos='0';
		while($A0=mysql_fetch_row($R0))
		{
			$MisPuntos.=",".$A0[0];
		}

		return $MisPuntos;
	}




	function getMisPuntos2()
	{
		$Venta=$this->getClasificacionVenta();

		if($this->isRestringido())
		$Q0="SELECT T1.PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1
			INNER JOIN
			(SELECT T1.PuntoVentaId, Corporativo
			 FROM HistorialPuntosEmpleados AS T1
			 LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
			 LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
			 WHERE UsuarioId=$this->UsuarioId AND Fisico=1 AND FechaBaja='0000-00-00'
			) AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			";
		else
		{

		if($this->isNacional())
		$Q0="SELECT PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1 WHERE ClasificacionPersonalVenta IN ($Venta)";
		else
		$Q0="SELECT PuntoVentaId AS Puntos
			FROM PuntosVenta AS T1
			INNER JOIN
			(SELECT PlazaId, Corporativo
			 FROM HistorialPuntosEmpleados AS T1
			 LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
			 LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
			 WHERE UsuarioId=$this->UsuarioId
			) AS T2 ON T2.PlazaId=T1.PlazaId
			WHERE ClasificacionPersonalVenta IN ($Venta)
			";
		}
	$R0=$this->Consulta($Q0);
	$MisPuntos='0';
		while($A0=mysql_fetch_row($R0))
		{
			$MisPuntos.=",".$A0[0];
		}

		return $MisPuntos;
	}


















	function getFiltro($Opc)
	{
		$Q0="SELECT Corporativo FROM Usuarios WHERE UsuarioId=".$this->UsuarioId;
		list($Corporativo)=mysql_fetch_row($this->Consulta($Q0));

		switch ($Opc) {
			case '1':
						if ($Corporativo==1)
							return 'TRUE';
						else
							$Q0="T16.Corporativo = 0 ";
				break;

		}
		return $Q0;
	}

	function isCorporativo()
	{
		$Q0="SELECT Corporativo FROM Usuarios WHERE UsuarioId=".$this->UsuarioId;
		list($Corporativo)=mysql_fetch_row($this->Consulta($Q0));
		if($Corporativo==1)
			return true;
		return false;
	}
/* ADMINISTRACION DE AVISOS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
	function getAvisos($ClasificacionAvisoId)
	{
		$Q0="SELECT Url,
					DATE_FORMAT(FechaInicial,'%d/%m/%Y') AS Inicial,
       				Titulo,
       				CONCAT_WS(' ', Nombre, Paterno, Materno),
       				T1.AvisoId,
   					IF(T5.AvisoId IS NULL, CONCAT('<big><ins><i>',Aviso,'</i></ins></big>'), Aviso) AS Aviso
				FROM Avisos AS T1
				LEFT JOIN Usuarios AS T2 ON T2.UsuarioId=T1.UsuarioId
				LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
        		LEFT JOIN AvisosUsuarios AS T4 ON T4.AvisoId=T1.AvisoId AND T4.UsuarioId=$this->UsuarioId
        		LEFT JOIN AvisosRevision AS T5 ON T5.AvisoId=T1.AvisoId AND T5.UsuarioId=$this->UsuarioId
				WHERE CURDATE() BETWEEN FechaInicial AND FechaFinal AND T1.Activo=1
        		AND ((T4.AvisoId IS NOT NULL AND Privado=1) OR ((Privado=0)))
        		AND ClasificacionAvisoId=$ClasificacionAvisoId
        		ORDER BY T1.AvisoId DESC
			";
		return $this->Consulta($Q0);
	}

	function getClsificacionAvisos()
	{
		$Q0="SELECT 'BIENVENIDA', 'ADMINISTRADOR DEL SISTEMA', Aviso, ClasificacionAvisoId, 0 AS Orden
			FROM Avisos AS T1 WHERE AvisoId=1
			UNION
			SELECT ClasificacionAviso,
			       CONCAT(COUNT(T2.AvisoId),' Avisos Disponibles')  AS Cta,
			       CONCAT('<h1>',SUM(IF(T3.UsuarioId IS NULL, 1,0)), '</h1><h3>Avisos sin leer<h3>') AS SinRevision,
			       T1.ClasificacionAvisoId,
			       Orden
			FROM ClasificacionAvisos AS T1
			INNER JOIN Avisos AS T2 ON T2.ClasificacionAvisoId=T1.ClasificacionAvisoId AND CURDATE() BETWEEN FechaInicial AND FechaFinal AND T2.Activo=1
			LEFT JOIN AvisosRevision AS T3 ON T3.AvisoId=T2.AvisoId AND T3.UsuarioId=1
			GROUP BY T1.ClasificacionAvisoId
			ORDER BY Orden
			";
		return $this->Consulta($Q0);
	}

	function getAdmNotasAll()
	{
		$Q0="SELECT '#Aviso', 'Aviso', 'Fecha Inicial&nbsp&nbsp&nbsp', 'Fecha Final&nbsp&nbsp&nbsp&nbsp', 'Activo&nbsp&nbsp'
				UNION ALL
				SELECT AvisoId, Aviso, DATE_FORMAT(FechaInicial,'%d/%m/%Y'), DATE_FORMAT(FechaFinal,'%d/%m/%Y'), Activo
				FROM Avisos
				";
		return $this->Consulta($Q0);
	}//getAdmNotasAll

	function getAdmNotas($NotaId)
	{
		$Q0="SELECT Aviso, DATE_FORMAT(FechaInicial,'%d/%m/%Y'), DATE_FORMAT(FechaFinal,'%d/%m/%Y')
			FROM Avisos AS T1
			WHERE AvisoId IN ($NotaId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getAdmNotas

	function getBuscaAdmNotas($Nota, $FechaInicial, $FechaFinal, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$FiltroInicial='';
		$FiltroFinal='';

		if($FechaInicial!='')
			$FiltroInicial="AND FechaInicial LIKE '%$FechaInicial%'";
		if($FechaFinal!='')
			$FiltroFinal="AND FechaFinal LIKE '%$FechaFinal%'";

		$Q0="SELECT '#Aviso', 'Aviso', 'Fecha Inicial&nbsp&nbsp&nbsp', 'Fecha Final&nbsp&nbsp&nbsp&nbsp', 'Activo&nbsp&nbsp'
				UNION ALL
				SELECT AvisoId, Aviso, DATE_FORMAT(FechaInicial,'%d/%m/%Y'), DATE_FORMAT(FechaFinal,'%d/%m/%Y'), Activo
				FROM Avisos
				WHERE Aviso LIKE '%$Nota%'
				$FiltroInicial
				$FiltroFinal
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaAdmNotas

	function addAdmNotas($Nota, $FInicio, $FFinal)
	{
		$FInicio=$this->CambiarFormatoFecha($FInicio);
		$FFinal=$this->CambiarFormatoFecha($FFinal);
		$Q0="INSERT INTO Avisos (AvisoId, Aviso, FechaInicial, FechaFinal, UsuarioId, Activo)
			 VALUES(NULL, '$Nota', '$FInicio', '$FFinal', $this->UsuarioId, 1)";
		$this->Insertar($Q0);
	}//addAdmNotas

	function deleteAdmNotas($llaves)
	{
		$Q0="UPDATE Avisos SET Activo=0 WHERE AvisoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteAdmNotas

	function activaAdmNotas($llaves)
	{
		$Q0="UPDATE Avisos SET Activo=1 WHERE AvisoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaAdmNotas

	function updateAdmNotas($AvisoId, $Aviso, $FInicio, $FFinal)
	{
		$FInicio=$this->CambiarFormatoFecha($FInicio);
		$FFinal=$this->CambiarFormatoFecha($FFinal);
		$Q0="UPDATE Avisos
			 SET 	Aviso='$Aviso',
			 		FechaInicial='$FInicio',
			 		FechaFinal='$FFinal'
			 WHERE AvisoId =REPLACE('$AvisoId', ',', '')";
		$this->Consulta($Q0);
	}//updateAdmNotas

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/* ADMINISTRACION DE PERSONAL ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

	function isListaNegra($Nombre, $Paterno, $Materno)
	{
		$Q0="SELECT COUNT(ListaNegraId) AS Existe FROM ListaNegra WHERE Nombre LIKE '%$Nombre%' AND Paterno LIKE '%Paterno%' AND Materno LIKE '%$Materno%'";
		list($Existe)=mysql_fetch_row($this->Consulta($Q0));

		if($Existe==0)
			return false;
		return true;
	}

	function addEmpleado($Nombre, $Paterno, $Materno, $FechaNacimiento, $Curp, $Rfc, $Ife, $Nss, $Genero, $NacionalidadId, $PuestoId, $SubCategoriaId, $FechaAltaPuesto, $PuntoVentaId, $FechaAltaPunto, $Fisico, $EscolaridadId, $ProfesionId, $EstadoCivilId, $BancoId, $NoCuenta, $Clabe, $ColoniaId, $Calle, $NExterior, $NInterior, $Telefono, $Movil, $TipoSangre, $ParentescoId, $NombreContacto, $ColoniaIdContacto, $CalleContacto, $NExteriorContacto, $NInteriorContacto, $TelefonoContacto, $MovilContacto, $CorreoElectronicoContacto, $CoordinadorId, $Operador, $Porcentaje, $ClasificacionPersonalVentaId, $FechaSolicitudImss, $SueldoF, $ReclutadorId, $Mail, $claveAtt)
	{
		$FechaNacimiento=$this->CambiarFormatoFecha($FechaNacimiento);
		$FechaAltaPuesto=$this->CambiarFormatoFecha($FechaAltaPuesto);
		$FechaAltaPunto=$this->CambiarFormatoFecha($FechaAltaPunto);
		if($FechaSolicitudImss!='0000-00-00')
			$FechaSolicitudImss=$this->CambiarFormatoFecha($FechaSolicitudImss);

		if($this->isListaNegra($Nombre, $Paterno, $Materno))
			return utf8_decode('<span class="alerta">¡Por politicas internas no se registrara a esta persona, Favor de verificarlo con Gerencia de Talento Humano!</span>');

		if($this->Existe('Curp', $Curp, 'Empleados'))
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro, La persona ya esta registrada!</span>');

		$Q0="INSERT INTO Empleados (EmpleadoId, Nombre, Paterno, Materno, FechaNacimiento, Curp, Rfc, Ife, NumeroSeguroSocial, Sexo, NacionalidadId, Infonavit, ObservacionesTH, UltimaFechaIngreso, ReclutadorId, claveAtt)
			VALUES	(NULL, UCASE('$Nombre'), UCASE('$Paterno'), UCASE('$Materno'), '$FechaNacimiento', UCASE('$Curp'), UCASE('$Rfc'), '$Ife', '$Nss', '$Genero', $NacionalidadId, 5, '', '$FechaAltaPuesto', $ReclutadorId, '$claveAtt')";

		$this->StartTransaccion();
		if($this->Consulta($Q0))
		{
			$EmpleadoId=mysql_insert_id();

		$Q1="INSERT INTO HistorialPuestosEmpleados (HistorialPuestoEmpleadoId, EmpleadoId, PuestoId, SubCategoriaId, FechaAlta, FechaBaja, CausaBajaId, Operador, Porcentaje, ClasificacionPersonalVentaId, Finiquito)
			 VALUES (NULL, $EmpleadoId, $PuestoId, $SubCategoriaId, '$FechaAltaPuesto', '0000-00-00', 0, '$Operador', $Porcentaje, $ClasificacionPersonalVentaId, 0)";

		$Q2="INSERT INTO HistorialPuntosEmpleados
			 SELECT NULL, $EmpleadoId, PuntoVentaId, '$FechaAltaPunto', '0000-00-00', 0 FROM PuntosVenta WHERE PuntoVentaId IN ($PuntoVentaId $Fisico)";

		$Q3="UPDATE HistorialPuntosEmpleados SET Fisico=1
			 WHERE EmpleadoId=$EmpleadoId AND PuntoVentaId=$Fisico";

		$Q4="INSERT INTO HistorialDatosEmpleados (HistorialDatosEmpleadoId, EmpleadoId, EscolaridadId, ProfesionId, EstadoCivilId, BancoId, NoCuenta, Clabe, ColoniaId, Calle, NExterior, NInterior, Telefono, Movil, TipoSangre)
			 VALUES (NULL, $EmpleadoId, $EscolaridadId, $ProfesionId, $EstadoCivilId, $BancoId, '$NoCuenta', '$Clabe', $ColoniaId, '$Calle', '$NExterior', '$NInterior', '$Telefono', '$Movil', '$TipoSangre')";

		$Q5="INSERT INTO ContactosEmergencia (EmpleadoId, ParentescoId, Nombre, ColoniaId, Calle, NExterior, NInterior, Telefono, Movil, CorreoElectronico)
			 VALUES($EmpleadoId, $ParentescoId, UCASE('$NombreContacto'), $ColoniaIdContacto, '$CalleContacto', '$NExteriorContacto', '$NInteriorContacto', '$TelefonoContacto', '$MovilContacto', '$CorreoElectronicoContacto')";

		$Q6="INSERT INTO CorreosEmpleados (EmpleadoId, Correo, Comentario, Respuesta, Activo)
			 VALUES($EmpleadoId, '$Mail', '', '', 1)" ;

/*
		$oldfile='Photo/'.$this->UsuarioId.'123_.jpg';
		$newfile='Photo/'.$this->UsuarioId.'123.jpg';
*/
		$Q7="INSERT INTO CoordinadoresEmpleados (CoordinadorId, EmpleadoId, FechaAlta, FechaBaja, Id)
			 VALUES($CoordinadorId, $EmpleadoId, '$FechaAltaPunto', '0000-00-00', NULL)";

		$Q8="INSERT INTO HistorialEmpleadosImss
			 SELECT $EmpleadoId, '$FechaSolicitudImss', '0000-00-00', 'A', 0, NULL
			 FROM HistorialEmpleadosImss
			 WHERE '$FechaSolicitudImss'!='0000-00-00'
			 LIMIT 1
			 ";

		$Q9="INSERT INTO HistorialSueldosFijos
			 SELECT NULL, '$EmpleadoId', '$FechaAltaPunto', '0000-00-00', '$SueldoF'
			 FROM HistorialSueldosFijos
			 WHERE '$SueldoF'>0
			 LIMIT 1
			 ";
		if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6) & $this->Consulta($Q7) & $this->Consulta($Q8) & $this->Consulta($Q9) &  $this->addBitacora(10, 2, $EmpleadoId, '','') /*& unlink($oldfile) & rename($newfile, 'Photo/'.$EmpleadoId.'.jpg')*/)
			{
				$this->AceptaTransaccion();
				return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
			}
		}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}

	function editEmpleado($EmpleadoId, $Nombre, $Paterno, $Materno, $FechaNacimiento, $Curp, $Rfc, $Ife, $Nss,
						  $Genero, $NacionalidadId, $PuestoId, $SubCategoriaId, $FechaAltaPuesto, $PuntoVentaId,
						  $FechaAltaPunto, $Fisico, $EscolaridadId, $ProfesionId, $EstadoCivilId, $BancoId,
						  $NoCuenta, $Clabe, $ColoniaId, $Calle, $NExterior, $NInterior, $Telefono, $Movil,
						  $TipoSangre, $ParentescoId, $NombreContacto, $ColoniaIdContacto, $CalleContacto,
						  $NExteriorContacto, $NInteriorContacto, $TelefonoContacto, $MovilContacto,
						  $CorreoElectronicoContacto, $ObservacionesTH, $Operador, $Porcentaje,
						  $ClasificacionPersonalVentaId, $DatosImss, $FechaSImss, $FechaMImss, $SD, $TipoMovimiento,
						  $FechaSF, $SF, $Mail, $claveAtt)
	{
		$CometarioBTCR='Actualizo informacion general ';
		if($DatosImss!='')
			$Arreglo=explode('*',$DatosImss);
		else
			$Arreglo=null;

		$FechaNacimiento=$this->CambiarFormatoFecha($FechaNacimiento);
		$FechaAltaPuesto=$this->CambiarFormatoFecha($FechaAltaPuesto);
		$FechaAltaPunto=$this->CambiarFormatoFecha($FechaAltaPunto);


		$QD="SELECT COUNT(EmpleadoId), IFNULL(HistorialSueldoFijoId,0), IFNULL(SueldoFijo,0) FROM HistorialSueldosFijos WHERE FechaBaja='0000-00-00' AND EmpleadoId=$EmpleadoId";
		list($xxx, $HistorialSueldoFijoId, $LastSF)=mysql_fetch_row($this->Consulta($QD));
		if($FechaSF!='00-00-0000' & $SF!='0' & $LastSF!=$SF)
		{
			$FechaSF=$this->CambiarFormatoFecha($FechaSF);
			$Q11="UPDATE HistorialSueldosFijos
				  SET FechaBaja=DATE_SUB('$FechaSF', INTERVAL 1 DAY)
				  WHERE HistorialSueldoFijoId=$HistorialSueldoFijoId";

			$Q12="INSERT INTO HistorialSueldosFijos (HistorialSueldoFijoId, EmpleadoId, FechaAlta, FechaBaja, SueldoFijo)
   			      VALUES(NULL, $EmpleadoId, '$FechaSF', '0000-00-00', '$SF')";

			$CometarioBTCR.='- Agrega SFijo nuevo';
		}
		else
		{
			$Q11='';
			$Q12='';
		}

		if($FechaSImss=='00-00-0000')
			$Q10="";
			else
			{
				$FechaSImss=$this->CambiarFormatoFecha($FechaSImss);
				if($FechaMImss=='00-00-0000')
					$FechaMImss='0000-00-00';
				else
					$FechaMImss=$this->CambiarFormatoFecha($FechaMImss);
				$Q10="INSERT INTO HistorialEmpleadosImss
					(EmpleadoId, FechaSolicitud, Fecha, Concepto, SalarioDiarioIntegrado, HistorialEmpleadoImss)
					VALUES($EmpleadoId, '$FechaSImss', '$FechaMImss', '$TipoMovimiento', $SD, NULL)";
					$CometarioBTCR.='- Agrego Historial Imss';
			}


		$QA="SELECT PuestoId, SubCategoriaId, FechaAlta, Operador, Porcentaje, ClasificacionPersonalVentaId
			 FROM HistorialPuestosEmpleados WHERE EmpleadoId=$EmpleadoId ORDER BY HistorialPuestoEmpleadoId DESC LIMIT 1";
        list($LastPuestoId, $LastSubCategoriaId, $LastFechaAltaPuesto, $LastOperador, $LastPorcentaje, $LastClasificacionPersonalVentaId)=mysql_fetch_row($this->Consulta($QA));

        $QB="SELECT EscolaridadId, ProfesionId, EstadoCivilId, BancoId, NoCuenta, Clabe, ColoniaId, Calle, NExterior, NInterior, Telefono, Movil
			 FROM HistorialDatosEmpleados WHERE EmpleadoId=$EmpleadoId ORDER BY HistorialDatosEmpleadoId DESC LIMIT 1";
		list($LastEscolaridadId, $LastProfesionId, $LastEstadoCivilId, $LastBancoId, $LastNoCuenta, $LastClabe, $LastColoniaId, $LastCalle, $LastNExterior, $LastNInterior, $LastTelefono, $LastMovil)=mysql_fetch_row($this->Consulta($QB));

		$QC="SELECT OldPv, NewPv, PuntoVentaId
				FROM (
				      SELECT GROUP_CONCAT(PuntoVentaId SEPARATOR '-') AS OldPv
				      FROM HistorialPuntosEmpleados
				      WHERE FechaBaja='0000-00-00' AND EmpleadoId=$EmpleadoId
				     ) AS T1,
				     (
				      SELECT GROUP_CONCAT(PuntoVentaId SEPARATOR '-') AS NewPv
				      FROM PuntosVenta
				      WHERE PuntoVentaId IN ($PuntoVentaId $Fisico)
				     ) AS T2,
				     (
				      SELECT PuntoVentaId
				      FROM HistorialPuntosEmpleados
				      WHERE Fisico=1 AND FechaBaja='0000-00-00' AND EmpleadoId=$EmpleadoId
				     ) AS T3";
		list($OldPv, $NewPv, $LastFisico)=mysql_fetch_row($this->Consulta($QC));

		$Q0="UPDATE Empleados
			SET Nombre=UCASE('$Nombre'),
			Paterno=UCASE('$Paterno'),
			Materno=UCASE('$Materno'),
			FechaNacimiento='$FechaNacimiento',
			Curp=UCASE('$Curp'),
			Rfc=UCASE('$Rfc'),
			Ife='$Ife',
			NumeroseguroSocial='$Nss',
			Sexo='$Genero',
			NacionalidadId=$NacionalidadId,
			ObservacionesTH='$ObservacionesTH',
			claveAtt='$claveAtt'
			WHERE EmpleadoId=$EmpleadoId";

		if($LastPuestoId==$PuestoId & $LastSubCategoriaId==$SubCategoriaId & $LastFechaAltaPuesto==$FechaAltaPuesto & $LastOperador==$Operador & $LastPorcentaje==$Porcentaje & $LastClasificacionPersonalVentaId==$ClasificacionPersonalVentaId)
		{
			$Q1="";
			$Q2="";
		}
		else
		{
		$Q1="UPDATE HistorialPuestosEmpleados
			 SET FechaBaja='$FechaAltaPuesto'
			 WHERE EmpleadoId=$EmpleadoId AND FechaBaja='0000-00-00'";

		$Q2="INSERT INTO HistorialPuestosEmpleados (HistorialPuestoEmpleadoId, EmpleadoId, PuestoId, SubCategoriaId, FechaAlta, FechaBaja, CausaBajaId, Operador, Porcentaje,ClasificacionPersonalVentaId)
			 VALUES (NULL, $EmpleadoId, $PuestoId, $SubCategoriaId, '$FechaAltaPuesto', '0000-00-00', 0, '$Operador', $Porcentaje, $ClasificacionPersonalVentaId)";

		$CometarioBTCR.='- Agrego historial de Puestos';
		}

		if($LastEscolaridadId==$EscolaridadId & $LastProfesionId==$ProfesionId & $LastEstadoCivilId==$EstadoCivilId & $LastBancoId==$BancoId & $LastNoCuenta==$NoCuenta & $LastClabe==$Clabe & $LastColoniaId==$ColoniaId & $LastCalle==$Calle & $LastNExterior==$NExterior & $LastNInterior==$NInterior & $LastTelefono==$Telefono & $LastMovil==$Movil)
			$Q3="";
		else
		{
		$Q3="INSERT INTO HistorialDatosEmpleados (HistorialDatosEmpleadoId, EmpleadoId, EscolaridadId, ProfesionId, EstadoCivilId, BancoId, NoCuenta, Clabe, ColoniaId, Calle, NExterior, NInterior, Telefono, Movil, TipoSangre)
			 VALUES (NULL, $EmpleadoId, $EscolaridadId, $ProfesionId, $EstadoCivilId, $BancoId, '$NoCuenta', '$Clabe', $ColoniaId, '$Calle', '$NExterior', '$NInterior', '$Telefono', '$Movil', '$TipoSangre')";
			 $CometarioBTCR.='- Agrego Historial de informacion personal';
		}
		$Q4="UPDATE ContactosEmergencia
			SET ParentescoId=$ParentescoId,
			Nombre=UCASE('$NombreContacto'),
			ColoniaId=$ColoniaIdContacto,
			Calle='$CalleContacto',
			NExterior='$NExteriorContacto',
			NInterior='$NInteriorContacto',
			Telefono='$TelefonoContacto',
			Movil='$MovilContacto',
			CorreoElectronico='$CorreoElectronicoContacto'
			WHERE EmpleadoId=$EmpleadoId";
		$CometarioBTCR.='- Actualizo contacto de emergencia';

		if($OldPv==$NewPv)
		{
			$Q5="";
			$Q7="";
		}
		else
		{
		$Q5="UPDATE
			HistorialPuntosEmpleados
			SET FechaBaja='$FechaAltaPunto'
			WHERE EmpleadoId=$EmpleadoId AND PuntoVentaId NOT IN ($PuntoVentaId $Fisico) AND FechaBaja='0000-00-00'";

		$Q7="INSERT INTO HistorialPuntosEmpleados
			SELECT NULL, $EmpleadoId, T1.PuntoVentaId, '$FechaAltaPunto', '0000-00-00', 0
			FROM PuntosVenta AS T1
			LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.PuntoventaId=T1.PuntoVentaId AND EmpleadoId=$EmpleadoId AND T2.FechaBaja='0000-00-00'
			WHERE T1.PuntoVentaId IN ($PuntoVentaId $Fisico) AND T2.PuntoVentaId IS NULL";
		$CometarioBTCR.='- Agrego Historial de Puntos de venta';
		}

		if($Fisico==$LastFisico)
		{
			$Q6="";
			$Q8="";
		}
		else
		{
		$Q6="UPDATE
			HistorialPuntosEmpleados
			SET Fisico=0
			WHERE EmpleadoId=$EmpleadoId";
		$Q8="UPDATE HistorialPuntosEmpleados SET Fisico=1
			 WHERE EmpleadoId=$EmpleadoId AND PuntoVentaId=$Fisico AND FechaBaja='0000-00-00'";
		$CometarioBTCR.='- Cambio Punto de venta Fisico';
		}



		$oldfile='Photo/'.$this->UsuarioId.'123_.jpg';
		$newfile='Photo/'.$this->UsuarioId.'123.jpg';
		$this->StartTransaccion();

		$flag=true;
		if($Arreglo>0)
		foreach ($Arreglo as $variables)
				{

				$elementos=explode('|',$variables);
					$HistorialImss=$elementos[0];
					$FechaSImss=$this->CambiarFormatoFecha($elementos[1]);
					if($elementos[2]=='00-00-0000')
						$FechaImss='0000-00-00';
					else
						$FechaImss=$this->CambiarFormatoFecha($elementos[2]);
						$SDI=$elementos[3];

						$Q9="UPDATE HistorialEmpleadosImss
							 SET FechaSolicitud='$FechaSImss',
					 		     Fecha='$FechaImss',
							     SalarioDiarioIntegrado='$SDI'
							 WHERE HistorialEmpleadoImss=$HistorialImss";
						if(!$this->Consulta($Q9))
							$flag=false;
				}

		$QV="UPDATE CorreosEmpleados SET Correo='$Mail' WHERE EmpleadoId=$EmpleadoId";

		if($flag & $this->addBitacora(10, 5, $EmpleadoId, $CometarioBTCR,'') & $this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6) & $this->Consulta($Q7) & $this->Consulta($Q8) & $this->Consulta($Q10) & $this->Consulta($Q11) & $this->Consulta($Q12) & $this->Consulta($QV))
			{

				$this->AceptaTransaccion();
				if(file_exists ($oldfile))
				{
				unlink($oldfile);
				rename($newfile, 'Photo/'.$EmpleadoId.'.jpg');
				}
				return utf8_decode('<span class="notificacion">¡La actualizacion se realizo satisfactoriamente!</span>');

			}

			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar la actualizacion!</span>');

	}

	function getEmpleado($EmpleadoId)
	{
		$Q0="SELECT T1.EmpleadoId, T1.Nombre, T1.Paterno, T1.Materno, DATE_FORMAT(T1.FechaNacimiento,'%d/%m/%Y'),
			       T1.Curp, T1.Rfc, T1.Ife, T1.NumeroSeguroSocial, T1.Sexo, T1.NacionalidadId, T2.PuestoId, T2.SubCategoriaId, DATE_FORMAT(T2.FechaAlta,'%d/%m/%Y'),
			       T3.EscolaridadId, T3.ProfesionId, T3.EstadoCivilId, T3.BancoId, T3.NoCuenta, T3.Clabe, T3.ColoniaId, T4.Colonia, T4.CodigoPostal, T3.Calle,
			       T3.NExterior, T3.NInterior, T3.Telefono, T3.Movil, T3.TipoSangre, T5.ParentescoId, T5.Nombre, T5.ColoniaId, T6.Colonia, T6.CodigoPostal, T5.Calle,
			       T5.NExterior, T5.NInterior, T5.Telefono, T5.Movil, T5.CorreoElectronico, T7.Puntos, T7.Fisico, IFNULL(T8.CoordinadorId,0), T1.ObservacionesTH, Operador, Porcentaje,
			       T2.ClasificacionPersonalVentaId, T9.Correo, T1.claveAtt
			FROM Empleados AS T1
			LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.FechaBaja='0000-00-00'
			LEFT JOIN (
						SELECT EmpleadoId,	EscolaridadId,	ProfesionId,	EstadoCivilId,	BancoId,	NoCuenta,	Clabe,	ColoniaId,	Calle,	NExterior,	NInterior,	Telefono,	Movil,	TipoSangre
						FROM HistorialDatosEmpleados AS T1
						INNER JOIN (
									SELECT MAX(HistorialDatosEmpleadoId) as HistorialDatosEmpleadoId
									FROM HistorialDatosEmpleados GROUP BY EmpleadoId
						 		 ) AS T2 ON T2.HistorialDatosEmpleadoId=T1.HistorialDatosEmpleadoId
					  ) AS T3 ON T3.EmpleadoId=T1.EmpleadoId
			LEFT JOIN Colonias AS T4 ON T4.ColoniaId=T3.ColoniaId
			LEFT JOIN ContactosEmergencia AS T5 ON T5.EmpleadoId=T1.EmpleadoId
			LEFT JOIN Colonias AS T6 ON T6.ColoniaId=T5.ColoniaId
	        LEFT JOIN (
	                  SELECT T1.EmpleadoId, CAST(GROUP_CONCAT(T1.PuntoVentaId) AS CHAR) AS Puntos, T2.PuntoVentaId AS Fisico
	                  FROM HistorialPuntosEmpleados AS T1
	                  LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.Fisico=1 AND T2.FechaBaja='0000-00-00'
	                  WHERE T1.Fechabaja='0000-00-00' AND T1.EmpleadoId IN ($EmpleadoId 0)
	                  GROUP BY EmpleadoId
	                ) AS T7 ON T7.EmpleadoId=T1.EmpleadoId
			LEFT JOIN CoordinadoresEmpleados AS T8 ON T8.EmpleadoId=T1.EmpleadoId
			LEFT JOIN CorreosEmpleados AS T9 ON T9.EmpleadoId=T1.EmpleadoId
			WHERE T1.EmpleadoId IN ($EmpleadoId 0)
			GROUP BY T1.EmpleadoId";

			return mysql_fetch_row($this->Consulta($Q0));
	}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

/* PUNTOS DE VENTA :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function getPuntosPlaza()
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT T1.PuntoVentaId, T2.Plaza, T1.PuntoVenta FROM PuntosVenta AS T1
	LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
	WHERE PuntoVentaId IN ($MisPuntos)";

	return $this->Consulta($Q0);
}

function getPuntosEmpleado($EmpleadoId)
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT T1.PuntoVentaId, T2.Plaza, T1.PuntoVenta, IFNULL(T3.PuntoventaId,0), IFNULL(T3.Fisico,0) FROM PuntosVenta AS T1
		LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
  		  LEFT JOIN HistorialPuntosEmpleados AS T3 ON T3.PuntoVentaId=T1.PuntoventaId AND T3.FechaBaja='0000-00-00' AND EmpleadoId=$EmpleadoId
		WHERE T1.PuntoVentaId IN ($MisPuntos)";

	return $this->Consulta($Q0);
}

function getPuntoVentaFisico()
{
	$Q0="SELECT PuntoVentaId, Corporativo FROM HistorialPuntosEmpleados AS T1
		 LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
		 WHERE FechaBaja='0000-00-00' AND Fisico=1 AND UsuarioId=$this->UsuarioId
		 LIMIT 1
		 ";
	return mysql_fetch_row($this->Consulta($Q0));
}

/*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function getTableModulos($ModuloId)
{
	switch ($ModuloId) {
			case '5':
					$Q0="SELECT T1.ModuloId, T1.Modulo, T1.Img, T1.Url, T2.Familia
						 FROM Modulos AS T1
						 LEFT JOIN Familias AS T2 ON T2.FamiliaId=T1.FamiliaId
						 WHERE T1.Activo=$Estatus";
				break;
			case '6':
					$Q0="SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Nombre, Usuario, Nivel, Mail
						 FROM Empleados AS T1
						 LEFT JOIN Niveles AS T2 ON T2.NivelId=T1.NivelId
						 INNER JOIN ModulosOperacionesEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						 WHERE UsuarioActivo=$Estatus
						 GROUP BY T1.EmpleadoId";
			default:
				# code...
				break;
		}

		$campos=$this->getHeadTabla($ModuloId);
		$R0=$this->Consulta($Q0);
		$datosall = array();

		while($A0=mysqli_fetch_row($R0))
		{
			for($i=0; $i<sizeof($campos); $i++)
				$datos[$campos[$i][0]] = $A0[$i];
				array_push($datosall, $datos);
		}
	return json_encode($datosall);
}

function getDatos($ModuloId)
{


	switch ($ModuloId) {
		case '1':
				$Q0="SELECT '#Aviso', 'Clasificacion', 'Titulo_Aviso', 'Aviso', 'Aviso_Doc', 'Fecha_Inicial', 'Fecha_Vigencia'
					UNION
					SELECT  AvisoId, ClasificacionAviso, Titulo, Aviso,
					        CONCAT('<span class=\"leyenda\" onclick=\"window.open(\'',Url,'\')\">Ver Aviso</span>'),
					        DATE_FORMAT(FechaInicial,'%d/%m/%Y'), DATE_FORMAT(FechaFinal,'%d/%m/%Y')
					FROM Avisos AS T1
					INNER JOIN ClasificacionAvisos AS T2 ON T2.ClasificacionAvisoId=T1.ClasificacionAvisoId
					WHERE T1.Activo=1";


		break;
		case '10':
				$Filtro=$this->getFiltro(1);
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT '#Control', 'Region', 'Sub_Region', 'Plaza', 'Punto_de_Venta', 'Nombre', 'Puesto_Actual', 'Categoria', 'SubCategoria', 'Coordinador_Asignado', 'Ingreso_Al_Puesto', 'Correo', 'Fecha_de_Ingreso', 'Id_Usuario'
					 UNION ALL
					 SELECT T1.EmpleadoId,
					       T8.Region,
					       T7.SubRegion,
					       T6.Plaza,
					       T5.PuntoVenta,
					       CONCAT_WS(' ', T1.Nombre, T1.Paterno, T1.Materno) AS Empleado,
					       T3.Puesto, T15.Categoria,
					       T14.SubCategoria,
                 CONCAT_WS(' ', T13.Nombre, T13.Paterno, T13.Materno) AS Coordinador,
					       DATE_FORMAT(T2.FechaAlta,'%d/%m/%Y') AS FechaAltaPuesto,
					       T9.Correo,
					       DATE_FORMAT(T10.FechaAlta,'%d/%m/%Y') AS FechaIngreso,
					       T16.UsuarioId
					 FROM Empleados AS T1
					 LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.Fechabaja='0000-00-00'
					 LEFT JOIN Puestos AS T3 ON T3.PuestoId=T2.PuestoId
					 LEFT JOIN HistorialPuntosEmpleados AS T4 ON T4.EmpleadoId=T1.EmpleadoId AND T4.FechaBaja='0000-00-00' AND T4.Fisico=1
					 LEFT JOIN PuntosVenta AS T5 ON T5.PuntoVentaId=T4.PuntoVentaId
					 LEFT JOIN Plazas AS T6 ON T6.PlazaId=T5.PlazaId
					 LEFT JOIN SubRegiones AS T7 ON T7.SubRegionId=T6.SubRegionId
					 LEFT JOIN Regiones AS T8 ON T8.RegionId=T7.RegionId
					 LEFT JOIN CorreosEmpleados AS T9 ON T9.EmpleadoId=T1.EmpleadoId
					 LEFT JOIN (SELECT EmpleadoId, FechaAlta FROM HistorialPuestosEmpleados GROUP BY EmpleadoId) AS T10 ON T10.EmpleadoId=T1.EmpleadoId
					 LEFT JOIN HistorialPuntosEmpleados AS T11 ON T11.EmpleadoId=T1.EmpleadoId AND T11.FechaBaja='0000-00-00'
           			 LEFT JOIN CoordinadoresEmpleados AS T12 ON T12.EmpleadoId=T1.EmpleadoId AND T12.FechaBaja='0000-00-00'
           			 LEFT JOIN Empleados AS T13 ON T13.EmpleadoId=T12.CoordinadorId
           			 LEFT JOIN SubCategorias AS T14 ON T14.SubCategoriaId=T2.SubCategoriaId
           			 LEFT JOIN Categorias AS T15 ON T15.CategoriaId=T14.CategoriaId
           			 LEFT JOIN Usuarios AS T16 ON T16.EmpleadoId=T1.EmpleadoId
					 WHERE T11.PuntoVentaId IN ($MisPuntos) AND $Filtro
					 GROUP BY T1.EmpleadoId
					";

		break;
		case '22':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT  'Folio', 'Opciones', 'Region', 'Sub_Region', 'Plaza', 'Punto_de_Venta', 'Fecha_Captura', 'Fecha_Contrato', 'Fecha_Sistema_Seguimiento', 'Cliente', 'Lineas', 'Comentario'
					UNION ALL
					SELECT  T1.Folio, CONCAT('<span class=\"leyenda\" onclick=\"changeEstatus(\'',T1.Folio,'\')\">Cambiar Estatus</span>'),
					Region,
					SubRegion,
					Plaza,
					PuntoVenta,
					DATE_FORMAT(FechaCaptura,'%d/%m/%Y'),
					DATE_FORMAT(FechaContrato,'%d/%m/%Y'),
					DATE_FORMAT(FechaSS,'%d/%m/%Y'),
					CONCAT_WS(' ',Nombre, Paterno, Materno) AS Cliente,
					Lineas,
					Comentarios
					FROM HFolios AS T1
					LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
					LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
					LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
					LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
					LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
					LEFT JOIN (SELECT Folio, COUNT(RegistroId) AS Lineas FROM LFolios GROUP BY Folio) AS T7 ON T7.Folio=T1.Folio
					WHERE T1.PuntoventaId IN ($MisPuntos) AND MovimientoId=0
				";
		break;
		case '23':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT '#Recepcion', 'Fecha','Punto_Venta', 'Factura', 'Equipo', 'Serie', 'Cantidad', 'Comentario'
				UNION ALL
				SELECT T1.MovimientoId, DATE_FORMAT(Fecha,'%d/%m/%Y'), PuntoVenta, ClaveRecepcion AS Factura, Equipo, Serie, Cantidad, Comentario
				FROM Recepciones AS T1
				LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoventaId
				LEFT JOIN Inventario AS T3 ON T3.MovimientoId=T1.MovimientoId
				LEFT JOIN Equipos AS T4 ON T4.EquipoId=T3.EquipoId
				WHERE T1.PuntoVentaId IN ($MisPuntos) AND TipoMovimientoId=1
				";
		break;
		case '24':

					if($this->isCorporativo())
						$MisPuntos=$this->getMisPuntos();
					else
					list($MisPuntos)=$this->getMiPuntoVentaFisico();

				$Q0="SELECT  'Movimiento', 'Opciones', 'Solicitud', 'Plataforma','Region', 'Sub_Region', 'Plaza', 'Punto_de_Venta', 'Fecha_Captura', 'Fecha_Contrato', 'Fecha_PVS', 'Cliente', 'Lineas', 'Comentario'
					UNION ALL
					SELECT  T1.Clave,  CONCAT('<span class=\"leyenda\" onclick=\"addEquipos(\'',T1.Folio,'\',',T1.MovimientoId,')\">Agregar Equipos</span>'),
					T1.Folio, Plataforma,
					Region,
					SubRegion,
					Plaza,
					PuntoVenta,
					DATE_FORMAT(FechaCaptura,'%d/%m/%Y'),
					DATE_FORMAT(FechaContrato,'%d/%m/%Y'),
					DATE_FORMAT(FechaSS,'%d/%m/%Y'),
					CONCAT_WS(' ',Nombre, Paterno, Materno) AS Cliente, Lineas, Comentarios
					FROM HFolios AS T1
					LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
					LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
					LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
					LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
					LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
					LEFT JOIN (SELECT Folio, COUNT(RegistroId) AS Lineas FROM LFolios GROUP BY Folio) AS T7 ON T7.Folio=T1.Folio
					LEFT JOIN Plataformas AS T8 ON T8.PlataformaId=T1.PlataformaId
					WHERE T1.PuntoventaId IN ($MisPuntos) AND MovimientoId>0 AND EnReporte=1
				";

		break;
		case '28':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT '#TR_Salida', 'Fecha_Traspaso', 'ORIGEN', 'DESTINO', 'CANTIDAD', 'PENDIENTE', 'RECIBIDO', 'COMENTARIO'
					UNION
					SELECT T1.MovimientoId, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha,
					       T3.PuntoVenta, T4.PuntoVenta, COUNT(EquipoId) AS Cantidad,
					       FORMAT(SUM((Cantidad+1)/2),0) AS Pendiente,
					       FORMAT(COUNT(EquipoId)-SUM((Cantidad+1)/2),0) AS Recibido,
					       Comentario
					FROM TRSalidas AS T1
					INNER JOIN Inventario AS T2 ON T2.MovimientoId=T1.MovimientoId
					INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaIdO
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaIdD
					WHERE Fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL 3 MONTH) AND CURDATE() AND T3.PuntoVentaId IN ($MisPuntos)
					GROUP BY T1.MovimientoId";
		break;
		case '29':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT '#TR_ENTRADA', 'FECHA_TRASPASO', 'ORIGEN', 'DESTINO', 'CANTIDAD', 'RECIBIDO', 'PENDIENTE', 'COMENTARIO'
					UNION
					SELECT T1.MovimientoId, DATE_FORMAT(T1.Fecha, '%d/%m/%Y') AS Fecha, T3.PuntoVenta, T4.PuntoVenta, T3.Cantidad,
					        COUNT(T2.Cantidad) AS Recibido, T3.Pendiente,
									T1.Comentario
					FROM Recepciones AS T1
					INNER JOIN Inventario AS T2 ON T2.MovimientoId=T1.MovimientoId
					INNER JOIN (
					            SELECT T1.MovimientoId, PuntoVenta, COUNT(EquipoId) AS Cantidad, FORMAT(SUM((Cantidad+1)/2),0) AS Pendiente
					            FROM TRSalidas AS T1
					            INNER JOIN Inventario AS T2 ON T2.MovimientoId=T1.MovimientoId
					            INNER JOIN PuntosVenta AS T3 ON T3.PuntoventaId=T1.PuntoVentaIdO
					            GROUP BY T1.MovimientoId
					            ) AS T3 ON T3.MovimientoId=ClaveRecepcion
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoventaId=T1.PuntoVentaId
					WHERE TipoMovimientoId=3
					AND T1.Fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL 1 MONTH) AND CURDATE() AND T1.PuntoVentaId IN ($MisPuntos)
					GROUP BY T1.MovimientoId";

		break;

		case '35':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'N. Control', 'Ejecutivo de ventas', 'Coordinador', ''
					UNION ALL
					SELECT T1.EmpleadoId, CONCAT_WS(' ', T2.Nombre, T2.Paterno, T2.Materno), CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno), ''
					FROM HistorialPuestosEmpleados AS T1
					LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
					LEFT JOIN CoordinadoresEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.FechaBaja='0000-00-00'
					LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.CoordinadorId
					INNER JOIN HistorialPuntosEmpleados AS T5 ON T5.EmpleadoId=T1.EmpleadoId AND T5.FechaBaja='0000-00-00'
					WHERE T1.FechaBaja='0000-00-00' AND T1.EmpleadoId>1
					AND T5.PuntoVentaId IN ($MisPuntos)
					GROUP BY T1.EmpleadoId
				";
		break;

		break;
		case '38':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'N. Venta', 'Fecha Venta', 'Factura', 'Punto de Venta', 'Vendedor', 'Coordinador', 'Cliente', 'Comentario'
					UNION ALL
					SELECT VentaId, DATE_FORMAT(Fecha, '%d/%m/%Y'),
					CONCAT('<span class=\"leyenda\" onclick=\"verFactura(',VentaId,')\">',Factura,'</span>'),
					PuntoVenta, CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno),
					       CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno), CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno), Comentario
					FROM AccVentas AS T1
					LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
					LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.HistorialPuestoEmpleadoId=T1.VendedorId
					LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
					LEFT JOIN Empleados AS T5 ON T5.EmpleadoId=T1.CoordinadorId
					LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
					WHERE  T2.PuntoVentaId IN ($MisPuntos)
				";
		break;
		case '40':
				$Filtro=$this->getFiltro(1);
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'NUM DE CONTROL',
						       'REGION',
						       'SUBREGION',
						       'PLAZA',
						       'PUNTO VENTA',
						       'PUESTO',
						       'NOMBRE',
						       'FECHA DE INGRESO',
						       'FECHA DE BAJA',
						       'FECHA DE SOLICITUD ALTA',
						       'FECHA ALTA IMSS',
						       'FECHA DE SOLICITUD BAJA',
						       'FECHA BAJA IMSS',
						       'OPERADORA',
						       'FINIQUITO',
						       'MOTIVO DE BAJA',
						       'OBSERVACIONES'
						UNION ALL
						SELECT T1.EmpleadoId,
						       Region,
						       SubRegion, Plaza, PuntoVenta, Puesto, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Empleado,
						       DATE_FORMAT(T11.FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(T11.FechaBaja, '%d/%m/%Y') AS FechaBaja,
						       DATE_FORMAT(T14.FechaSolicitud, '%d/%m/%Y') AS FechaSolicitudAlta,
						       DATE_FORMAT(T14.Fecha, '%d/%m/%Y') AS FechaAltaIMSS,
						       DATE_FORMAT(T16.FechaSolicitud, '%d/%m/%Y') AS FechaSolicitudBaja,
						       DATE_FORMAT(T16.Fecha, '%d/%m/%Y') AS FechaBajaIMSS,
						       T2.Operador, T2.Finiquito, CausaBaja, T3.ObservacionesTH
						FROM
						(
						  SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId
						  FROM HistorialPuestosEmpleados
						  GROUP BY EmpleadoId
						) AS T1
						INNER JOIN HistorialPuestosEmpleados AS T2 ON T2.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
						INNER JOIN Empleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						INNER JOIN Puestos AS T4 ON T4.PuestoId=T2.PuestoId
						INNER JOIN (
						            SELECT MAX(HistorialPuntosEmpleadoId) AS HistorialPuntosEmpleadoId, EmpleadoId
						            FROM HistorialPuntosEmpleados
						            WHERE Fisico=1
						            GROUP BY EmpleadoId
						           ) AS T5 ON T5.EmpleadoId=T1.EmpleadoId
						INNER JOIN HistorialPuntosEmpleados AS T6 ON T6.HistorialPuntosEmpleadoId=T5.HistorialPuntosEmpleadoId
						INNER JOIN PuntosVenta AS T7 ON T7.PuntoVentaId=T6.PuntoVentaId
						INNER JOIN Plazas AS T8 ON T8.PlazaId=T7.PlazaId
						INNER JOIN SubRegiones AS T9 ON T9.SubRegionId=T8.SubRegionId
						INNER JOIN Regiones AS T10 ON T10.RegionId=T9.RegionId
						INNER JOIN (
						            SELECT T1.EmpleadoId, T2.FechaBaja, T4.FechaAlta
						            FROM
						            (SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId) AS T1
						            LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.HistorialPuestoEmpleadoId>=T1.HistorialPuestoEmpleadoId
						            LEFT JOIN (SELECT MIN(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId)
						                      AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						            LEFT JOIN HistorialPuestosEmpleados AS T4 ON T4.HistorialPuestoEmpleadoId=T3.HistorialPuestoEmpleadoId
						            LEFT JOIN SubCategorias AS T5 ON T5.SubCategoriaId=T2.SubCategoriaId
						            GROUP BY T1.EmpleadoId
											) AS T11 ON T11.EmpleadoId=T1.EmpleadoId
						INNER JOIN CausasBaja AS T12 ON T12.CausaBajaId=T2.CausaBajaId
						LEFT JOIN (
						           SELECT MAX(HistorialEmpleadoImss) AS HistorialEmpleadoImss, EmpleadoId
						           FROM HistorialEmpleadosImss
						           WHERE Concepto='A'
						           GROUP BY EmpleadoId
						           ) AS T13 ON T13.EmpleadoId=T1.EmpleadoId
						LEFT JOIN HistorialEmpleadosImss AS T14 ON T14.HistorialEmpleadoImss=T13.HistorialEmpleadoImss
						LEFT JOIN (
						           SELECT MAX(HistorialEmpleadoImss) AS HistorialEmpleadoImss, EmpleadoId
						           FROM HistorialEmpleadosImss
						           WHERE Concepto='B'
						           GROUP BY EmpleadoId
						           ) AS T15 ON T15.EmpleadoId=T1.EmpleadoId
						LEFT JOIN HistorialEmpleadosImss AS T16 ON T16.HistorialEmpleadoImss=T15.HistorialEmpleadoImss
						WHERE T7.PuntoVentaId IN ($MisPuntos) AND $Filtro
					 GROUP BY T1.EmpleadoId
					";
		break;

		case '41':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'Folio', 'Punto_de_Venta','Fecha_de_Captura', 'Fecha_de_Contrato','Fecha_de_Instalacion', 'Vendedor', 'Coordinador', 'Cliente', 'Estatus', 'Plazo', 'Observaciones'
				UNION ALL
				SELECT T1.Folio,PuntoVenta,
				       DATE_FORMAT(FechaCaptura, '%d/%m/%Y'),
				       DATE_FORMAT(FechaContrato, '%d/%m/%Y'),
				       DATE_FORMAT(FechaInstalacion, '%d/%m/%Y'),
				       CONCAT_WS(' ', T3.Nombre, T3.Paterno, T3.Materno) AS Vendedor,
				CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno) AS Coordinador,
				CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno) AS Cliente,
				TPEstatus, Plazo, Observaciones
				FROM TPVentas AS T1
				LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.HistorialPuestoEmpleadoId=T1.VendedorId
				LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
				LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T1.CoordinadorId
				LEFT JOIN Clientes AS T5 ON T5.ClienteId=T1.ClienteId
				LEFT JOIN TPEstatus AS T6 ON T6.TPEstatusId=T1.TPEstatusId
				LEFT JOIN Plazos AS T7 ON T7.PlazoId=T1.PlazoId
				LEFT JOIN PuntosVenta AS T8 ON T8.PuntoVentaId=T1.PuntoVentaId
				WHERE  T8.PuntoVentaId IN ($MisPuntos)
				";
		break;

		case '43':
				$Q0="SELECT '#Entrega', 'Fecha_Entrega', 'Recibe', 'Cantidad', 'Comentario'
					UNION
					SELECT T1.EntregaUniformeId, DATE_FORMAT(FechaEntrega,'%d/%m/%Y') AS FechaEntrega,
					       CONCAT_WS(' ', Nombre, Paterno, Materno) AS Empleado, Cantidad, Comentario
					FROM EntregaUniformesH AS T1
					LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
					LEFT JOIN (
					           SELECT EntregaUniformeId, IFNULL(SUM(Cantidad),0) AS Cantidad
					           FROM EntregaUniformesL
					           GROUP BY EntregaUniformeId
					           ) AS T3 ON T3.EntregaUniformeId=T1.EntregaUniformeId";
		break;
		case '46':
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'Factura', 'FechaFactura', 'Equipo', 'Serie', 'Punto_Vetna'
					UNION
					SELECT Factura, DATE_FORMAT(FechaFactura,'%d/%m/%Y'), Equipo, Serie, PuntoVenta
					FROM OrdenesCompra AS T1
					INNER JOIN Equipos AS T2 ON T2.equipoid=T1.EquipoId
					INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
					WHERE Recibido=1 AND T1.PuntoVentaId IN ($MisPuntos)";
		break;
		case '47':
						$MisPuntos=$this->getMisPuntos();
						$Q0="SELECT 'FACTURA', 'DOCUMENTO', 'FECHA', 'PUNTO VENTA', 'CANTIDAD', 'RECIBIDO', 'COSTO', 'COSTO_IVA'
							UNION
							SELECT T1.Factura, CONCAT('<span class=\"leyenda\" onclick=\"window.open(\'FacturasDoc/',T1.Archivo,'\')\">Ver Factura</span>'),
							Fecha, PuntoVenta, Cantidad, Recibido, Costo, CostoIva
							FROM FacturasEquipos AS T1
							INNER JOIN (
							            SELECT Factura, PuntoVentaId, COUNT(EquipoId) AS Cantidad, SUM(Recibido) AS Recibido,
							                   CONCAT('$ ',FORMAT(ROUND(SUM(Costo),2),2)) AS Costo,
							                   CONCAT('$ ',FORMAT(ROUND(SUM(Costo+Iva),2),2)) AS CostoIva
									            FROM OrdenesCompra
									            GROUP BY Factura
							            ) AS T2 ON T2.Factura=T1.Factura
							INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId";
		break;
		case '60':
					$Q0="SELECT '#Cliente', 'Nombre', 'RFC', 'Identificacion', 'Buro'
					UNION
					SELECT T1.ClienteId, CONCAT_WS(' ', Nombre, Paterno, Materno), rfc,
							CONCAT('<span class=\"leyenda\" onclick=\"window.open(\'',Identificacion,'\')\">Identificacion</span>'),
							CONCAT('<span class=\"leyenda\" onclick=\"window.open(\'',Buro,'\')\">Buro de Credito</span>')
					FROM Clientes AS T1
					INNER JOIN DocumentosBuro AS T2 ON T2.ClienteId=T1.ClienteId";
		break;
		case '63':
					$MisPuntos=$this->getMisPuntos();
					$Q0="SELECT 'RESET','N.C.', 'PUNTO DE VENTA', 'NOMBRE', 'CORREO / USUARIO SIIGA'
					     UNION
						SELECT CONCAT('sendNC(',T1.EmpleadoId,',\'', LCASE(REPLACE(Correo, '@solucell.com.mx', '')),'\')'),T1.EmpleadoId, PuntoVenta, CONCAT_WS(' ', Nombre, paterno, Materno) AS Nombre, LCASE(REPLACE(Correo, '@solucell.com.mx', '')) AS 'Correo / Acceso SIIGA' FROM Usuarios AS T1
						LEFT JOIN CorreosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
						LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						LEFT JOIN HistorialPuntosEmpleados AS T4 ON T4.EmpleadoId=T1.EmpleadoId AND Fisico=1 AND T4.FechaBaja='0000-00-00'
						INNER JOIN HistorialPuestosEmpleados AS T5 ON T5.EmpleadoId=T1.EmpleadoId AND T5.FechaBaja='0000-00-00'
						LEFT JOIN PuntosVenta AS T6 ON T6.PuntoVentaId=T4.PuntoVentaId
						WHERE T1.Activo=1 AND T1.EmpleadoId>1 AND T6.PuntoVentaId IN ($MisPuntos)";
		break;
		case '64':
					$Q0="SELECT 'N.C.', 'NOMBRE', 'EVENTO', 'HORA'
						UNION
						SELECT T1.EmpleadoId, CONCAT_WS(' ',Nombre, Paterno, Materno) AS Nombre, IF(Evento='E','ENTRADA', 'SALIDA') AS Evento, Hora
						FROM Checador AS T1
						INNER JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
						WHERE Fecha=CURDATE()";
		break;
		case '65':
			$MisPuntos=$this->getMisPuntos();
					$Q0="SELECT 'Folio', 'Identificacion','Punto de Venta', 'Fecha', 'Compañia', 'Numero Telefonico', 'Monto Recarga', 'Vendedor', 'Coordinado', 'Comentario'
					UNION
					SELECT Folio, IF(T1.ife!='',CONCAT('<span class=\"leyenda\" onclick=\"window.open(\'',T1.ife,'\')\">Ver Ife</span>'),''),
					PuntoVenta, DATE_FORMAT(T1.Fecha, '%d/%m/%Y'),Compania, NTel, MontoRecarga, CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
					       CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno), Comentario
					FROM Recargas AS T1
					INNER JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
					INNER JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaId
					INNER JOIN HistorialPuestosEmpleados AS T5 ON T5.HistorialPuestoEmpleadoId=T1.VendedorId
					INNER JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
					INNER JOIN Empleados AS T7 ON T7.EmpleadoId=T1.CoordinadorId
					WHERE T1.PuntoVentaId IN ($MisPuntos)
					";
		break;

                case '66':
                        $MisPuntos=$this->getMisPuntos();
	                    $Q0="SELECT '#DepositoId', 'Nombre_Depositante','Punto_de_Venta','Deposito','Fecha_Deposito', 'Tipo_Deposito', 'Monto', 'Comentarios'
					UNION
					SELECT T1.DepositoId, CONCAT_WS(' ', Nombre, Paterno, Materno), PuntoVenta, Deposito, DATE_FORMAT(FechaHora, '%d/%m/%Y'), TipoDeposito, FORMAT(Monto,2), comentarios
					FROM Depositos AS T1
					INNER JOIN TiposDepositos AS T2 ON T2.TipoDepositoId=T1.TipoDepositoId
					INNER JOIN PuntosVenta AS T3 ON T3.PuntoventaId=T1.PuntoVentaId
		 	                LEFT JOIN Bitacora AS T4 ON T4.ObjetoId=T1.DepositoId AND T4.ModuloId=66 and T4.OperacionId=2
		        	        LEFT JOIN Usuarios AS T5 ON T5.usuarioId=T4.UsuarioId
		       		        LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
					WHERE T1.PuntoVentaId IN ($MisPuntos) AND Validado=0";
                break;
                case '70':
                	$MisPuntos=$this->getMisPuntos();
                	if($this->getPermisoEspecial(13))
		                $Q0="SELECT '#VALIDACION', 'FOLIO', 'CLIENTE','TELEFONO', 'ESTATUS', 'FECHA_SOLICITUD', 'HORA_SOLICITUD', 'SOLICITANTE', 'OBSERVACIONES', 'USUARIO_VAIDACION', 'OBSERVACION_VALIDACION', 'FECHA_VALIDACION', 'HORA_VALIDACION'
							UNION
							SELECT ValidacionId, Folio, CONCAT_WS(' ',NombreCliente, PaternoCliente, MaternoCliente), T1.Telefono,
								   Estatusvalidacion, DATE_FORMAT(Fecha,'%d/%m/%Y'), Hora,
							       CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno), Observaciones,
							       CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno), ObservacionesValidacion,
							       DATE_FORMAT(FechaValidacion,'%d/%m/%Y'), HoraValidacion
							FROM ValidacionVenta AS T1
							LEFT JOIN EstatusValidacion AS T2 ON T2.EstatusValidacionId=T1.EstatusValidacionId
							LEFT JOIN Usuarios AS T3 ON T3.UsuarioId=T1.UsuarioId
							LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
							LEFT JOIN Usuarios AS T5 ON T5.UsuarioId=T1.UsuarioValidacionId
							LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
							WHERE FECHA BETWEEN DATE_SUB(CURDATE(),INTERVAL 31 DAY) AND CURDATE()
							";

                		else

		                $Q0="SELECT '#VALIDACION', 'FOLIO', 'CLIENTE','TELEFONO', 'ESTATUS', 'OBSERVACION_VALIDACION'
							UNION
							SELECT ValidacionId, Folio, CONCAT_WS(' ',NombreCliente, PaternoCliente, MaternoCliente), T1.Telefono,
								   Estatusvalidacion, ObservacionesValidacion

							FROM ValidacionVenta AS T1
							LEFT JOIN EstatusValidacion AS T2 ON T2.EstatusValidacionId=T1.EstatusValidacionId
							LEFT JOIN Usuarios AS T3 ON T3.UsuarioId=T1.UsuarioId
							LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
							LEFT JOIN Usuarios AS T5 ON T5.UsuarioId=T1.UsuarioValidacionId
							LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
							WHERE FECHA BETWEEN DATE_SUB(CURDATE(),INTERVAL 31 DAY) AND CURDATE()
							AND T1.PuntoVentaId IN ($MisPuntos)
							";
				break;
				case '73':
					$MisPuntos=$this->getMisPuntos();
					$Q0="SELECT 'Folio','Punto de Venta', 'Fecha', 'Compañia', 'Numero Telefonico', 'Monto Recarga', 'Vendedor', 'Coordinado', 'Comentario'
					UNION
					SELECT Folio,
					PuntoVenta, DATE_FORMAT(T1.Fecha, '%d/%m/%Y'),Compania, NTel, MontoRecarga, CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
					       CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno), T1.Comentario
					FROM Recargas AS T1
					INNER JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
					INNER JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaId
					INNER JOIN HistorialPuestosEmpleados AS T5 ON T5.HistorialPuestoEmpleadoId=T1.VendedorId
					INNER JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
					INNER JOIN Empleados AS T7 ON T7.EmpleadoId=T1.CoordinadorId
					INNER JOIN Bitacora AS T8 ON T1.Folio=T8.Comentario
					WHERE T1.PuntoVentaId IN ($MisPuntos) AND T8.ModuloId=73
					";
				break;
				case '74':
					$MisPuntos=$this->getMisPuntos();
					$Q0="SELECT 'Folio','Punto de Venta', 'Fecha', 'Compañia', 'Numero Telefonico', 'Monto Recarga', 'Vendedor', 'Coordinado', 'Comentario'
					UNION
					SELECT Folio,
					PuntoVenta, DATE_FORMAT(T1.Fecha, '%d/%m/%Y'),Compania, NTel, MontoRecarga, CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
					       CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno), T1.Comentario
					FROM Recargas AS T1
					INNER JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
					INNER JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaId
					INNER JOIN HistorialPuestosEmpleados AS T5 ON T5.HistorialPuestoEmpleadoId=T1.VendedorId
					INNER JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
					INNER JOIN Empleados AS T7 ON T7.EmpleadoId=T1.CoordinadorId
					INNER JOIN Bitacora AS T8 ON T1.Folio=T8.Comentario
					WHERE T1.PuntoVentaId IN ($MisPuntos) AND T8.ModuloId=74
					";
				break;
				case '75':
					$MisPuntos=$this->getMisPuntos();
					$Q0="SELECT 'Folio','Punto de Venta', 'Fecha', 'Compañia', 'Numero Telefonico', 'Monto Recarga', 'Vendedor', 'Coordinado', 'Comentario'
					UNION
					SELECT Folio,PuntoVenta, DATE_FORMAT(T1.Fecha, '%d/%m/%Y'),Compania, NTel, MontoRecarga, CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
					       CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno), T1.Comentario
					FROM Recargas AS T1
					INNER JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
					INNER JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
					INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaId
					INNER JOIN HistorialPuestosEmpleados AS T5 ON T5.HistorialPuestoEmpleadoId=T1.VendedorId
					INNER JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
					INNER JOIN Empleados AS T7 ON T7.EmpleadoId=T1.CoordinadorId
					INNER JOIN Bitacora AS T8 ON T1.Folio=T8.Comentario
					WHERE T1.PuntoVentaId IN ($MisPuntos) AND T8.ModuloId=75
					";
				break;

		default:
				$Q0="SELECT CURDATE()";
		break;
		}
		return $this->Consulta($Q0);
	}



//::CapturaDatos :::::::::::::::::::::::::::::::::::::::::::::::::::::::://
	function getDatosTrabajador($Clave)
	{
		$Q0="SELECT T1.PersonalId,
				   CONCAT_WS(' ',T1.Nombre, T1.Paterno, T1.Materno) AS Nombre,
			       T2.Dependencia,
			       T3.Clasificacion,
			       T3.Tipo,
			       T4.Descripcion,
            	   IF(T5.PersonalId IS NULL,'','¡La evaluacion de esta persona ya existe!')
			FROM Personal AS T1
			LEFT JOIN Dependencias AS T2 ON T2.DependenciaId=T1.DependenciaId
			LEFT JOIN ClasificacionPersonal AS T3 ON T3.ClasificacionPersonalId=T1.ClasificacionPersonalId
			LEFT JOIN (SELECT T1.PersonalId, GROUP_CONCAT(Descripcion SEPARATOR '<br>') AS Descripcion
			           FROM PersonalDescripciones AS T1
			           LEFT JOIN DescripcionPersonal AS T2 ON T2.Descripcionid=T1.DescripcionId
			           GROUP BY T1.PersonalId
			          ) AS T4 ON T4.PersonalId=T1.PersonalId
      		LEFT JOIN Consolidado AS T5 ON T5.PersonalId=T1.PersonalId
			WHERE T1.Clave='$Clave'
			LIMIT 1";
		return $this->Consulta($Q0);
	}


	function getCompetencias($Competencias)
	{
		$var=explode(",", $Competencias);
		$array=array();

		$Cadena='<table>
					<thead>
						<tr>
							<th>Tipo</th>
							<th>Competencia</th>
							<th>Grado Competencia</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;

		foreach ($var as $value)
		{
			if($t) $Clase='';
			else $Clase='class="alt"';

			$v1=explode("|", $value);

			if (!in_array($v1[0], $array) & $v1[0]!=0)
			{
			$array[]=$v1[0];

			$Q0="SELECT TipoCompetencia, Competencia, T3.GradoCompetencia
				 FROM Competencias AS T1
				 LEFT JOIN TiposCompetencia AS T2 ON T2.TipoCompetenciaId=T1.TipoCompetenciaId
				 LEFT JOIN GradosCompetencias AS T3 ON TRUE
				 WHERE CompetenciaId=$v1[0] AND T3.GradoCompetenciaId=$v1[1]";
				list($TipoCompetencia, $Competencia, $GradoCompetencia)=mysql_fetch_row($this->Consulta($Q0));

				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($TipoCompetencia).'</td>
							<td>'.utf8_decode($Competencia).'</td>
							<td>'.utf8_decode($GradoCompetencia).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="removerC(\''.$v1[0].'|'.$v1[1].'\')" /></td>
						</tr>
				';
			$t=(!$t);
			}
		}

				$Cadena.='</tbody>
				</table>';
		return $Cadena;
	}


	function getFuncionesElegias($Subordinado, $Trabajador, $Jefe, $Puesto)
	{

		$Q0="SELECT T0.Funcion, IFNULL(Subordinado,''), IFNULL(Trabajador,''), IFNULL(Jefe,''), IFNULL(Puesto,'')
			 FROM Funciones AS T0
			 LEFT JOIN (SELECT FuncionId, Funcion, 'X' AS Subordinado FROM Funciones WHERE FuncionId IN ($Subordinado 0)) AS T1 ON T1.FuncionId=T0.FuncionId
			 LEFT JOIN (SELECT FuncionId, Funcion, 'X' AS Trabajador FROM Funciones WHERE FuncionId IN ($Trabajador 0)) AS T2 ON T2.FuncionId=T0.FuncionId
			 LEFT JOIN (SELECT FuncionId, Funcion, 'X' AS Jefe FROM Funciones WHERE FuncionId IN ($Jefe 0)) AS T3 ON T3.FuncionId=T0.FuncionId
			 LEFT JOIN (SELECT FuncionId, Funcion, 'X' AS Puesto FROM Funciones WHERE FuncionId IN ($Puesto 0)) AS T4 ON T4.FuncionId=T0.FuncionId
			 WHERE T0.FuncionId IN ($Subordinado $Trabajador $Jefe 0)
			 ORDER BY T0.Funcion ASC
			 ";
		$R0=$this->Consulta($Q0);
		$Cadena='<table>
					<thead>
						<tr>
							<th>Funcion</th>
							<th>Subordinado</th>
							<th>Trabajador</th>
							<th>Jefe</th>
							<th>Funcion Puesto</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		while($A0=mysql_fetch_row($R0))
		{

			if($t)
				$Clase='';
			else
				$Clase='class="alt"';

				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td align="center">'.utf8_decode($A0[1]).'</td>
							<td align="center">'.utf8_decode($A0[2]).'</td>
							<td align="center">'.utf8_decode($A0[3]).'</td>
							<td align="center">'.utf8_decode($A0[4]).'</td>
						</tr>
				';
			$t=(!$t);
		}

		$Cadena.='</tbody>
				</table>';
		return $Cadena;
	}

	function getFunciones()
	{

		$Cadena='<table id="Funciones" >
					<thead>
					<tr><td colspan="3">Buscar:&nbsp<input id="Busqueda" type="text"></td>
						<td><input type="button" class="seleccionar" id="seleccionar" name="seleccionar"></td>
					</tr>
						<tr>
							<th>Funcion</th>
							<th>Subordinado</th>
							<th>Trabajador</th>
							<th>Jefe</th>
							<th>Funcion Puesto</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT FuncionId, Funcion FROM Funciones ORDER BY Funcion ASC";
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><input type="checkbox" name="Subordinado" id="Subordinado" class="sub" value="'.$A0[0].'" onclick="setFuncion(this)" /></td>
							<td align="center"><input type="checkbox" name="Trabajador" id="Trabajador" class="Tr" value="'.$A0[0].'" onclick="setFuncion(this)" /></td>
							<td align="center"><input type="checkbox" name="Jefe" id="Jefe" class="Jf" value="'.$A0[0].'" onclick="setFuncion(this)"/></td>
							<td align="center"><input type="checkbox" name="Puesto" id="Puesto" class="Pt" value="'.$A0[0].'" onclick="setFuncion(this)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getDependencias()
	{
		$Q0="SELECT DependenciaId, Dependencia FROM Dependencias ORDER BY Dependencia";
		return $this->Consulta($Q0);
	}

	function getCategorias()
	{
		$Q0="SELECT CategoriaId, Categoria FROM Categorias ORDER BY Categoria";
		return $this->Consulta($Q0);
	}

	function addCaptura($TrabajadorId, $Folio, $Subordinados, $CategoriaId, $GradoAcademicoCategoriaId,
						$ExperienciaRequeridaCategoria, $AreaTrabajoId, $PuestoId, $GradoAcademicoPuestoId,
						$ExperienciaRequeridaPuesto, $JefeId, $GradoAcademicoActualId, $Coincide, $Competencias,
						$Subordinado, $Trabajador, $Jefe, $FPuesto, $HoraInicio, $HoraFin, $equipo)
	{
		$var=explode(",", $Competencias);

		$PersonalId=$this->getPersonalId($TrabajadorId);
		$PersonalJefeId=$this->getPersonalId($JefeId);
		if($PersonalId==0 || $PersonalJefeId==0)
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
		if($this->ExsisteCaptura($PersonalId))
			return utf8_decode('<span class="alerta">¡Ya existe registro de esta Persona!</span>');

		if(!isset($Coincide))
			$Coincide=0;

		$Q0="INSERT INTO Consolidado
						(CapturaId, Folio, PersonalId, UsuarioId, Fecha, Hora, CategoriaId, AreaTrabajoId, PuestoId,
							Subordinados, JefeId, GradoAcademicoCategoriaId, GradoAcademicoPuestoId, Coincidencia,
							GradoAcademicoId, ExperienciaCategoria, ExperienciaPuesto, HoraInicio, HoraFin)
				  VALUES(NULL, UCASE('$Folio'), $PersonalId, $this->UsuarioId, CURDATE(), CURTIME(), $CategoriaId,
				  	$AreaTrabajoId, $PuestoId, $Subordinados, $PersonalJefeId, $GradoAcademicoCategoriaId,
				  	$GradoAcademicoPuestoId, $Coincide, $GradoAcademicoActualId, $ExperienciaRequeridaCategoria,
				  	$ExperienciaRequeridaPuesto, '$HoraInicio:00', '$HoraFin:00')";

		$Q1="INSERT IGNORE INTO  FuncionesPersonal
			 SELECT $PersonalId, FuncionId, 0,0,0,0 FROM Funciones WHERE FuncionId IN ($Subordinado $Trabajador $Jefe 0)";

		$Q3="UPDATE FuncionesPersonal SET Subordinado=1 WHERE PersonalId=$PersonalId AND FuncionId IN ($Subordinado 0)";
		$Q4="UPDATE FuncionesPersonal SET Trabajador=1 WHERE PersonalId=$PersonalId AND FuncionId IN ($Trabajador 0)";
		$Q5="UPDATE FuncionesPersonal SET Jefe=1 WHERE PersonalId=$PersonalId AND FuncionId IN ($Jefe 0)";
		$Q6="UPDATE FuncionesPersonal SET Puesto=1 WHERE PersonalId=$PersonalId AND FuncionId IN ($FPuesto 0)";

		$this->StartTransaccion();

		if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6))

		foreach ($var as $value)
		{
			$v1=explode("|", $value);
			if ($v1[0]!=0)
			$Q2="INSERT IGNORE INTO PersonalCompetencias (PersonalId, CompetenciaId, GradoCompetenciaId) VALUES($PersonalId, $v1[0], $v1[1])";
			if(!$this->Consulta($Q2))
			{
				$this->CancelaTransaccion();
				return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
			}
		}
		$this->addBitacora(26, 2, '', $equipo);
		$this->AceptaTransaccion();

		return utf8_decode('<span class="notificacion">¡Los datos se guardaron correctamente!</span>');
	}

	function ExsisteCaptura($PersonalId)
	{
		$Q0="SELECT COUNT(CapturaId) AS Cta FROM Consolidado WHERE PersonalId=$PersonalId";
		list($Cta)=mysql_fetch_row($this->Consulta($Q0));
		if($Cta>0)
		return true;
		return false;
	}

	function getPersonalId($Clave)
	{

		$Q0="SELECT PersonalId FROM Personal WHERE Clave='$Clave'";
		list($PersonalId)=mysql_fetch_row($this->Consulta($Q0));
		if(!isset($PersonalId) || $PersonalId=='')
		$PersonalId=0;
		return $PersonalId;
	}

	function getNombrePersonal($Clave)
	{

		$Q0="SELECT CONCAT_WS(' ',Nombre, Paterno, Materno) AS Nombre FROM Personal WHERE Clave='$Clave'";
		list($Nombre)=mysql_fetch_row($this->Consulta($Q0));
		if(!isset($Nombre) || $Nombre=='')
		$Nombre=utf8_decode('<span class="alerta">¡No encontro informacion con esa clave!</span>');
		return $Nombre;
	}

//:: Areas Trabajo :::::::::::::::::::::::::::::::::::::::::::::::::::::::::://
	function addAreaTrabajo($AreaTrabajo, $Dependencias, $Equipo)
	{
		$Q0="INSERT INTO AreasTrabajo (AreaTrabajoId, AreaTrabajo) VALUES(NULL, UCASE('$AreaTrabajo'))";
		$Q1="INSERT IGNORE INTO AreasDependencias
			 SELECT LAST_INSERT_ID(), DependenciaId FROM Dependencias WHERE DependenciaId IN ($Dependencias 0)";
		if($this->Consulta($Q0) & $this->Consulta($Q1))
		{
			$this->addBitacora(28, 2, '', $Equipo);
			return utf8_decode('<span class="notificacion">¡El Area de Trabajo se guardo correctamente!</span>');
		}
		else
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');

	}

//:: Funciones :::::::::::::::::::::::::::::::::::::::::::::::::::::::::://
	function addFuncion($Funcion, $Categorias, $Equipo)
	{
		$Q0="INSERT INTO Funciones (FuncionId, Funcion) VALUES(NULL, UCASE('$Funcion'))";
		$Q1="INSERT IGNORE INTO CategoriasFunciones
			 SELECT CategoriaId, LAST_INSERT_ID() FROM Categorias WHERE CategoriaId IN ($Categorias 0)";
		if($this->Consulta($Q0) & $this->Consulta($Q1))
		{
			$this->addBitacora(28, 2, '', $Equipo);
			return utf8_decode('<span class="notificacion">¡La Funcion se guardo correctamente!</span>');
		}
		else
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');

	}

//:: Puestos :::::::::::::::::::::::::::::::::::::::::::::::::::::::::://
	function addPuesto($Puesto, $Experiencia, $GradoAcademicoId, $Equipo)
	{
		$Q0="INSERT INTO Puestos
			(PuestoId, Puesto, ExperienciaRequerida, GradoAcademicoId)
			VALUES(NULL, UCASE('$Puesto'), $Experiencia, $GradoAcademicoId)";
		if($this->Consulta($Q0))
		{
			$this->addBitacora(10, 2, '', $Equipo);
			return utf8_decode('<span class="notificacion">¡El Puesto se guardo correctamente!</span>');
		}
		else
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');

	}

//:: Bitacora :::::::::::::::::::::::::::::::::::::::::::::::::::::::::://

	//// SUCURSALES ////
	function getSucursales()
	{
		$Q0="SELECT ' #Sucursal', 'Sucursal', 'Calle', 'Codigo Postal&nbsp;&nbsp;', 'Colonia', 'Telefono 1', 'Telefono 2', 'Correo', 'Web', 'RFC', 'Matriz ', 'Activo '
				UNION ALL
				SELECT T1.SucursalId, T1.Sucursal, T1.Calle, T2.CodigoPostal, T2.Colonia, T1.Telefono1, T1.Telefono2, T1.Correo, T1.Web, T1.RFC, IF(T1.Matriz=1,'MATRIZ',''), IF(T1.Activo=1,'ACTIVO','INACTIVO')
				FROM Sucursales AS T1
				LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
				";
		return $this->Consulta($Q0);
	}//getSucursales

	function getSucursal($SucursalId)
	{
		$Q0="SELECT Sucursal, Calle, CodigoPostal, T1.CodigoPostalId, Telefono1, Telefono2, Correo, Web, RFC, Matriz
			FROM Sucursales AS T1
			LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
			WHERE SucursalId IN ($SucursalId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaSucursales($Sucursal, $Rfc, $Calle, $Telefono1, $Telefono2, $CodigoPostal, $Colonia, $Correo, $Web, $Matriz, $Activo)
	{
		if($Matriz==2)
			$FMatriz='0,1';
		else
			$FMatriz=$Matriz;
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT ' #Sucursal', 'Sucursal', 'Calle', 'Codigo Postal&nbsp;&nbsp;', 'Colonia', 'Telefono 1', 'Telefono 2', 'Correo', 'Web', 'RFC', 'Matriz ', 'Activo '
				UNION ALL
				SELECT T1.SucursalId, T1.Sucursal, T1.Calle, T2.CodigoPostal, T2.Colonia, T1.Telefono1, T1.Telefono2, T1.Correo, T1.Web, T1.RFC, IF(T1.Matriz=1,'MATRIZ',''), IF(T1.Activo=1,'ACTIVO','INACTIVO')
				FROM Sucursales AS T1
				LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
				WHERE T1.Sucursal LIKE '%$Sucursal%'
				AND T1.Calle LIKE '%$Calle%'
				AND T2.CodigoPostal LIKE '%$CodigoPostal%'
				AND T2.Colonia LIKE '%$Colonia%'
				AND T1.Telefono1 LIKE '%$Telefono1%'
				AND T1.Telefono2 LIKE '%$Telefono2%'
				AND T1.Correo LIKE '%$Correo%'
				AND T1.Web LIKE '%$Web%'
				AND T1.RFC LIKE '%$Rfc%'
				AND T1.Matriz IN ($FMatriz)
				AND T1.Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaSucursales

	function addSucursal($Sucursal, $Calle, $CodigoPostalId, $Telefono1, $Telefono2, $Correo, $Web, $RFC, $Matriz)
	{
		$Q0="INSERT INTO Sucursales (SucursalId, Sucursal, Calle, CodigoPostalId, Telefono1, Telefono2, Correo, Web, RFC, Matriz, Activo)
			 VALUES(NULL, UCASE('$Sucursal'), UCASE('$Calle'), $CodigoPostalId, '$Telefono1', '$Telefono2', '$Correo', LCASE('$Web'), UCASE('$RFC'), $Matriz, 1)";
		$this->Insertar($Q0);
	}//addSucursal

	function deleteSucursal($llaves)
	{
		$Q0="UPDATE Sucursales SET Activo=0 WHERE SucursalId IN ($llaves 0)";
		$this->Consulta($Q0);
	}

	function activaSucursal($llaves)
	{
		$Q0="UPDATE Sucursales SET Activo=1 WHERE SucursalId IN ($llaves 0)";
		$this->Consulta($Q0);
	}

	function updateSucursal($SucursalId, $Sucursal, $Calle, $CodigoPostalId, $Telefono1, $Telefono2, $Correo, $Web, $RFC, $Matriz)
	{
		$Q0="UPDATE Sucursales
			 SET 	Sucursal='$Sucursal',
			 		Calle='$Calle',
			 		CodigoPostalId=$CodigoPostalId,
			 		Telefono1='$Telefono1',
			 		Telefono2='$Telefono2',
			 		Correo='$Correo',
			 		Web='$Web',
			 		RFC=UCASE('$RFC'),
			 		Matriz=$Matriz
			 WHERE SucursalId =REPLACE('$SucursalId', ',', '')";
		$this->Consulta($Q0);
	}//addSucursal

//// PUESTOS ////
	function getPuestos()
	{
		$Q0="SELECT '#Puesto', 'Puesto', 'Descripcion', 'Activo'
				UNION ALL
				SELECT PuestoId, Puesto, PuestoTxt, Activo
				FROM Puestos
				";
		return $this->Consulta($Q0);
	}//getPuestos

	function getPuesto($PuestoId)
	{
		$Q0="SELECT Puesto, PuestoTxt
			FROM Puestos AS T1
			WHERE PuestoId IN ($PuestoId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaPuestos($Puesto, $Descripcion, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#Puesto', 'Puesto', 'Descripcion', 'Activo'
				UNION ALL
				SELECT PuestoId, Puesto, PuestoTxt, Activo
				FROM Puestos
				WHERE Puesto LIKE '%$Puesto%'
				AND PuestoTxt LIKE '%$Descripcion%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaPuestos

	function addPuestox($Puesto, $PuestoTxt)
	{
		$Q0="INSERT INTO Puestos (PuestoId, Puesto, PuestoTxt, Activo)
			 VALUES(NULL, UCASE('$Puesto'), UCASE('$PuestoTxt'), 1)";
		$this->Insertar($Q0);
	}//addPuesto

	function deletePuesto($llaves)
	{
		$Q0="UPDATE Puestos SET Activo=0 WHERE PuestoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deletePuesto

	function activaPuesto($llaves)
	{
		$Q0="UPDATE Puestos SET Activo=1 WHERE PuestoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaPuesto

	function updatePuesto($PuestoId, $Puesto, $PuestoTxt)
	{
		$Q0="UPDATE Puestos
			 SET 	Puesto='$Puesto',
			 		PuestoTxt='$PuestoTxt'
			 WHERE PuestoId =REPLACE('$PuestoId', ',', '')";
		$this->Consulta($Q0);
	}//updatePuesto

//// ESTATUS ////
	function getEstatus()
	{
		$Q0="SELECT '#Estatus', 'Estatus', 'Descripcion', 'Activo'
				UNION ALL
				SELECT EstatusId, Estatus, EstatusTxt, Activo
				FROM Estatus
				";
		return $this->Consulta($Q0);
	}//getEstatus

	function getEstatu($EstatusId)
	{
		$Q0="SELECT Estatus, EstatusTxt
			FROM Estatus AS T1
			WHERE EstatusId IN ($EstatusId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaEstatus($Estatus, $Descripcion, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#Estatus', 'Estatus', 'Descripcion', 'Activo'
				UNION ALL
				SELECT EstatusId, Estatus, EstatusTxt, Activo
				FROM Estatus
				WHERE Estatus LIKE '%$Estatus%'
				AND EstatusTxt LIKE '%$Descripcion%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaEstatus

	function addEstatus($Estatus, $EstatusTxt)
	{
		$Q0="INSERT INTO Estatus (EstatusId, Estatus, EstatusTxt, Activo)
			 VALUES(NULL, UCASE('$Estatus'), UCASE('$EstatusTxt'), 1)";
		$this->Insertar($Q0);
	}//addEstatus

	function deleteEstatus($llaves)
	{
		$Q0="UPDATE Estatus SET Activo=0 WHERE EstatusId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteEstatus

	function activaEstatus($llaves)
	{
		$Q0="UPDATE Estatus SET Activo=1 WHERE EstatusId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaEstatus

	function updateEstatus($EstatusId, $Estatus, $EstatusTxt)
	{
		$Q0="UPDATE Estatus
			 SET 	Estatus='$Estatus',
			 		EstatusTxt='$EstatusTxt'
			 WHERE EstatusId =REPLACE('$EstatusId', ',', '')";
		$this->Consulta($Q0);
	}//updateEstatus


//// LOCALIDADES ////

	function getMunicipios()
	{
		$Q0="SELECT '#Municipio', 'Estado', 'Municipio', 'Codigos Postales', 'Activo'
			UNION ALL
			SELECT MunicipioId, Estado, Municipio, CONCAT('<span onclick=\"sendFoo(',MunicipioId,');\" class=\"Mano\">Ver Codigos </span>'), T1.Activo FROM Municipios AS T1
			LEFT JOIN Estados AS T2 ON T2.EstadoId=T1.EstadoId limit 15
			";
		return $this->Consulta($Q0);
	}//getMunicipios

	function getMunicipio($MunicipioId)
	{
		$Q0="SELECT Municipio, EstadoId
			FROM Municipios AS T1
			WHERE MunicipioId IN ($MunicipioId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaMunicipios($Municipio, $EstadoId, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Filtro="";
		if($EstadoId!=0)
			$Filtro="AND T1.EstadoId = $EstadoId";

		$Q0="SELECT '#Municipio', 'Estado', 'Municipio', 'Activo'
			UNION ALL
			SELECT MunicipioId, Estado, Municipio, T1.Activo FROM Municipios AS T1
			LEFT JOIN Estados AS T2 ON T2.EstadoId=T1.EstadoId
			WHERE Municipio LIKE '%$Municipio%'
			$Filtro
			AND T1.Activo IN ($FActivo)
			";
		return $this->Consulta($Q0);
	}//getBuscaMunicipios


	function addMunicipio($Municipio, $EstadoId)
	{
		$Q0="INSERT INTO Municipios (MunicipioId, Municipio, EstadoId, Activo)
			 VALUES(NULL, UCASE('$Municipio'), $EstadoId, 1)";
		$this->Insertar($Q0);
	}//addMunicipio

	function deleteMunicipio($llaves)
	{
		$Q0="UPDATE Municipios SET Activo=0 WHERE MunicipioId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteMunicipio

	function activaMunicipio($llaves)
	{
		$Q0="UPDATE Municipios SET Activo=1 WHERE MunicipioId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaMunicipio

	function updateMunicipio($MunicipioId, $Municipio, $EstadoId)
	{
		$Q0="UPDATE Municipios
			 SET 	Municipio='$Municipio',
			 		EstadoId=$EstadoId
			 WHERE MunicipioId =REPLACE('$MunicipioId', ',', '')";
		$this->Consulta($Q0);
	}//updateMunicipio

	//// CODIGOS POSTALES ////

	function getMunicipioById($MunicipioId)
	{
		$Q0="SELECT Municipio FROM Municipios WHERE MunicipioId = $MunicipioId LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}



	function getCodigos($MunicipioId)
	{
		$Q0="SELECT '#Codigo Postal Id', 'Codigo Postal', 'Colonia', 'Activo'
			UNION ALL
			SELECT CodigoPostalId, CodigoPostal, Colonia, Activo
			FROM CodigosPostales
			WHERE MunicipioId=$MunicipioId";
		return $this->Consulta($Q0);
	}//getCodigos

	function getCodigo($CodigoPostalId)
	{
		$Q0="SELECT CodigoPostal, MunicipioId
			FROM CodigosPostales AS T1
			WHERE CodigoPostalId IN ($CodigoPostalId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getCodigo

	function getBuscaCodigos($Municipio, $EstadoId, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Filtro="";
		if($EstadoId!=0)
			$Filtro="AND T1.EstadoId = $EstadoId";

		$Q0="SELECT '#Municipio', 'Estado', 'Municipio', 'Activo'
			UNION ALL
			SELECT MunicipioId, Estado, Municipio, T1.Activo FROM Municipios AS T1
			LEFT JOIN Estados AS T2 ON T2.EstadoId=T1.EstadoId
			WHERE Municipio LIKE '%$Municipio%'
			$Filtro
			AND T1.Activo IN ($FActivo)
			";
		return $this->Consulta($Q0);
	}//getBuscaCodigos


	function addCodigo($Municipio, $EstadoId)
	{
		$Q0="INSERT INTO Municipios (MunicipioId, Municipio, EstadoId, Activo)
			 VALUES(NULL, UCASE('$Municipio'), $EstadoId, 1)";
		$this->Insertar($Q0);
	}//addCodigo

	function deleteCodigo($llaves)
	{
		$Q0="UPDATE Municipios SET Activo=0 WHERE MunicipioId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteCodigo

	function activaCodigo($llaves)
	{
		$Q0="UPDATE Municipios SET Activo=1 WHERE MunicipioId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaCodigo

	function updateCodigo($MunicipioId, $Municipio, $EstadoId)
	{
		$Q0="UPDATE Municipios
			 SET 	Municipio='$Municipio',
			 		EstadoId=$EstadoId
			 WHERE MunicipioId =REPLACE('$MunicipioId', ',', '')";
		$this->Consulta($Q0);
	}//updateCodigo


	//// ESTADO CIVIL ////
	function getEstadoCiviles()
	{
		$Q0="SELECT '#Estado Civil', 'Estado Civil', 'Activo'
				UNION ALL
				SELECT EstadoCivilId, EstadoCivil, Activo
				FROM EstadoCivil
				";
		return $this->Consulta($Q0);
	}//getEstadoCiviles

	function getEstadoCivil($EstadoCivilId)
	{
		$Q0="SELECT EstadoCivil
			FROM EstadoCivil AS T1
			WHERE EstadoCivilId IN ($EstadoCivilId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getEstadoCivil

	function getBuscaEstadoCiviles($EstadoCivil, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#Estado Civil', 'EstadoCivil', 'Activo'
				UNION ALL
				SELECT EstadoCivilId, EstadoCivil, Activo
				FROM EstadoCivil
				WHERE EstadoCivil LIKE '%$EstadoCivil%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaEstadoCivil

	function addEstadoCivil($EstadoCivil)
	{
		$Q0="INSERT INTO EstadoCivil (EstadoCivilId, EstadoCivil, Activo)
			 VALUES(NULL, UCASE('$EstadoCivil'), 1)";
		$this->Insertar($Q0);
	}//addEstadoCivil

	function deleteEstadoCivil($llaves)
	{
		$Q0="UPDATE EstadoCivil SET Activo=0 WHERE EstadoCivilId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteEstadoCivil

	function activaEstadoCivil($llaves)
	{
		$Q0="UPDATE EstadoCivil SET Activo=1 WHERE EstadoCivilId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaEstadoCivil

	function updateEstadoCivil($EstadoCivilId, $EstadoCivil)
	{
		$Q0="UPDATE EstadoCivil
			 SET 	EstadoCivil='$EstadoCivil'
			 WHERE EstadoCivilId =REPLACE('$EstadoCivilId', ',', '')";
		$this->Consulta($Q0);
	}//updateEstadoCivil

//// ESCOLARIDAD ////
	function getEscolaridades()
	{
		$Q0="SELECT '#Escolaridad', 'Escolaridad', 'Activo'
				UNION ALL
				SELECT EscolaridadId, Escolaridad, Activo
				FROM Escolaridades
				";
		return $this->Consulta($Q0);
	}//getEscolaridades

	function getEscolaridad($EscolaridadId)
	{
		$Q0="SELECT Escolaridad
			FROM Escolaridades AS T1
			WHERE EscolaridadId IN ($EscolaridadId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getEscolaridad

	function getBuscaEscolaridades($Escolaridad, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#Escolaridad', 'Escolaridad', 'Activo'
				UNION ALL
				SELECT EscolaridadId, Escolaridad, Activo
				FROM Escolaridades
				WHERE Escolaridad LIKE '%$Escolaridad%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaEscolaridades

	function addEscolaridad($Escolaridad)
	{
		$Q0="INSERT INTO Escolaridades (EscolaridadId, Escolaridad, Activo)
			 VALUES(NULL, UCASE('$Escolaridad'), 1)";
		$this->Insertar($Q0);
	}//addEscolaridad

	function deleteEscolaridad($llaves)
	{
		$Q0="UPDATE Escolaridades SET Activo=0 WHERE EscolaridadId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteEscolaridad

	function activaEscolaridad($llaves)
	{
		$Q0="UPDATE Escolaridades SET Activo=1 WHERE EscolaridadId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaEscolaridad

	function updateEscolaridad($EscolaridadId, $Escolaridad)
	{
		$Q0="UPDATE Escolaridades
			 SET 	Escolaridad='$Escolaridad'
			 WHERE EscolaridadId =REPLACE('$EscolaridadId', ',', '')";
		$this->Consulta($Q0);
	}//updateEscolaridad



//// CLASE ARTICULOS ////
	function getClasesArticulos()
	{
		$Q0="SELECT '#Clase Articulo', 'Clase Articulo', 'Descripcion', 'Unidad de Medida', 'Activo'
				UNION ALL
				SELECT ClaseArticuloId, ClaseArticulo, ClaseArticuloTxt, UnidadMedida, T1.Activo
				FROM ClaseArticulos AS T1
				LEFT JOIN UnidadesMedida AS T2 ON T2.UnidadMedidaId=T1.UnidadMedidaId
				";
		return $this->Consulta($Q0);
	}//getClasesArticulos

	function getClaseArticulo($ClaseArticuloId)
	{
		$Q0="SELECT ClaseArticulo, ClaseArticuloTxt, UnidadMedidaId
			FROM ClaseArticulos AS T1
			WHERE ClaseArticuloId IN ($ClaseArticuloId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getClaseArticulo

	function getBuscaClasesArticulos($ClaseArticulo, $Descripcion, $UnidadMedidaId, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Filtro="";
		if($UnidadMedidaId!=0)
			$Filtro="AND T1.UnidadMedidaId = $UnidadMedidaId";

		$Q0="SELECT '#Clase Articulo', 'Clase Articulo', 'Descripcion', 'Unidad de Medida', 'Activo'
				UNION ALL
				SELECT ClaseArticuloId, ClaseArticulo, ClaseArticuloTxt, UnidadMedida, T1.Activo
				FROM ClaseArticulos AS T1
				LEFT JOIN UnidadesMedida AS T2 ON T2.UnidadMedidaId=T1.UnidadMedidaId
				WHERE ClaseArticulo LIKE '%$ClaseArticulo%'
				AND ClaseArticuloTxt LIKE '%$Descripcion%'
				$Filtro
				AND T1.Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaClasesArticulos

	function addClaseArticulo($ClaseArticulo, $Descripcion, $UnidadMedidaId)
	{
		$Q0="INSERT INTO ClaseArticulos (ClaseArticuloId, ClaseArticulo, ClaseArticuloTxt, UnidadMedidaId, Activo)
			 VALUES(NULL, UCASE('$ClaseArticulo'), UCASE('$Descripcion'), $UnidadMedidaId, 1)";
		$this->Insertar($Q0);
	}//addClaseArticulo

	function deleteClaseArticulo($llaves)
	{
		$Q0="UPDATE ClaseArticulos SET Activo=0 WHERE ClaseArticuloId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteClaseArticulo

	function activaClaseArticulo($llaves)
	{
		$Q0="UPDATE ClaseArticulos SET Activo=1 WHERE ClaseArticuloId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaClaseArticulo

	function updateClaseArticulo($ClaseArticuloId, $ClaseArticulo, $Descripcion, $UnidadMedidaId)
	{
		$Q0="UPDATE ClaseArticulos
			 SET 	ClaseArticulo=UCASE('$ClaseArticulo'),
			 		ClaseArticuloTxt=UCASE('$Descripcion'),
			 		UnidadMedidaId=$UnidadMedidaId
			 WHERE ClaseArticuloId =REPLACE('$ClaseArticuloId', ',', '')";
		$this->Consulta($Q0);
	}//updateClaseArticulo


//// PRODUCTOS ////
	function getProductos()
	{
		$Q0="SELECT '#Producto', 'Producto', 'Descripcion', 'Costo', 'Precio', 'Utilidad', 'Activo'
				UNION ALL
				SELECT T1.ProductoId, Producto, ProductoTxt, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, CONCAT('$ ',FORMAT(Precio,2)) AS Precio, CONCAT(ROUND((1- Costo/Precio)*100,2),' %') AS Utilidad, Activo
				FROM Productos AS T1
				LEFT JOIN HistorialProductos AS T2 ON T2.ProductoId=T1.ProductoId
				WHERE Baja='0000-00-00'
			";
		return $this->Consulta($Q0);
	}//getProductos

	function getProducto($ProductoId)
	{
		$Q0="SELECT Producto, ProductoTxt, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, CONCAT('$ ',FORMAT(Precio,2)) AS Precio
				FROM Productos AS T1
				LEFT JOIN HistorialProductos AS T2 ON T2.ProductoId=T1.ProductoId
				WHERE Baja='0000-00-00' AND T1.ProductoId IN ($ProductoId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getProducto

	function getBuscaProductos($Producto, $Descripcion, $Costo, $Precio, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;


		$Q0="SELECT '#Producto', 'Producto', 'Descripcion', 'Costo', 'Precio', 'Utilidad', 'Activo'
				UNION ALL
				SELECT T1.ProductoId, Producto, ProductoTxt, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, CONCAT('$ ',FORMAT(Precio,2)) AS Precio, CONCAT(ROUND((1- Costo/Precio)*100,2),' %') AS Utilidad, Activo
				FROM Productos AS T1
				LEFT JOIN HistorialProductos AS T2 ON T2.ProductoId=T1.ProductoId
				WHERE Baja='0000-00-00'
				AND Producto LIKE '%$Producto%'
				AND ProductoTxt LIKE '%$Descripcion%'
				AND Costo LIKE '%$Costo%'
				AND Precio LIKE '%$Precio%'
				AND T1.Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaProductos

	function addProducto($Producto, $Descripcion, $Costo, $Precio)
	{
		$Q0="INSERT INTO Productos (ProductoId, Producto, ProductoTxt, Activo)
                  VALUES(NULL, UCASE('$Producto'), '$Descripcion', 1)";
        $Q1="INSERT INTO HistorialProductos (HistorialProductoId, ProductoId, Precio, Costo, Alta, Baja)
                  VALUES(NULL, LAST_INSERT_ID(), REPLACE('$Precio', '$', ''), REPLACE('$Costo', '$', ''), CURDATE(), '0000-00-00')";

        $this->StartTransaccion();
        	if($this->Consulta($Q0))
        		if($this->Consulta($Q1))
        		{
        			$this->AceptaTransaccion();
        			return true;
        		}
  		$this->CancelaTransaccion();
        return false;

	}//addProducto

	function deleteProducto($llaves)
	{
		$Q0="UPDATE Productos SET Activo=0 WHERE ProductoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteProducto

	function activaProducto($llaves)
	{
		$Q0="UPDATE Productos SET Activo=1 WHERE ProductoId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaProducto

	function updateProducto($ProductoId, $Producto, $Descripcion, $Costo, $Precio)
	{
		$Q0="UPDATE Productos SET Producto=UCASE('$Producto'), ProductoTxt='$Descripcion' WHERE ProductoId=REPLACE('$ProductoId', ',', '')";
		$Q1="UPDATE HistorialProductos SET Baja=CURDATE() WHERE ProductoId=REPLACE('$ProductoId', ',', '') AND Baja='0000-00-00'";
		$Q2="INSERT INTO HistorialProductos (HistorialProductoId, ProductoId, Precio, Costo, Alta, Baja)
                  VALUES(NULL, REPLACE('$ProductoId', ',', ''),  REPLACE('$Precio', '$', ''), REPLACE('$Costo', '$', ''), CURDATE(), '0000-00-00')";

        $this->StartTransaccion();
        if($this->Consulta($Q0))
        	if($this->Consulta($Q1))
        		if($this->Consulta($Q2))
        		{
        			$this->AceptaTransaccion();
        			return true;
        		}
        $this->CancelaTransaccion();
        return false;
	}//updateProducto


	//// PAQUETES ////
	function getPaquetes()
	{
		$Q0="SELECT '#Paquete', 'Paquete', 'Descripcion',  'Precio', 'Activo'
				UNION ALL
				SELECT PaqueteId, Paquete, PaqueteTxt, CONCAT('$ ',FORMAT(Precio,2)) AS Precio, Activo
				FROM Paquetes
			";
		return $this->Consulta($Q0);
	}//getPaquetes

	function getProductosPaquetes()
	{
		$Q0="SELECT '#Producto', 'Cantidad', 'Producto', 'Descripcion', 'Costo', 'Precio'
				UNION ALL
				SELECT T1.ProductoId, 0, Producto, ProductoTxt, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, CONCAT('$ ',FORMAT(Precio,2)) AS Precio
				FROM Productos AS T1
				LEFT JOIN HistorialProductos AS T2 ON T2.ProductoId=T1.ProductoId
				WHERE Baja='0000-00-00' AND T1.Activo=1
			";
		return $this->Consulta($Q0);
	}


	function getProductosPaquetesEdit($PaqueteId)
	{
		$Q0="SELECT '#Producto', 'Cantidad', 'Producto', 'Descripcion', 'Costo', 'Precio'
				UNION ALL
				SELECT T1.ProductoId, IFNULL(T3.Cantidad,0) AS Cantidad, Producto, ProductoTxt, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, CONCAT('$ ',FORMAT(Precio,2)) AS Precio
				FROM Productos AS T1
				LEFT JOIN HistorialProductos AS T2 ON T2.ProductoId=T1.ProductoId
        		LEFT JOIN PaquetesProductos AS T3 ON T3.ProductoId=T1.ProductoId AND T3.PaqueteId IN ($PaqueteId 0)
				WHERE Baja='0000-00-00' AND T1.Activo=1
				";
		return $this->Consulta($Q0);
	}

	function getPaquete($PaqueteId)
	{
		$Q0="SELECT Paquete, PaqueteTxt, CONCAT('$ ',FORMAT(Precio,2)) AS Precio
				FROM Paquetes
				WHERE PaqueteId in ($PaqueteId 0)
			";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getPaquete

	function getBuscaPaquetes($Paquete, $Descripcion, $Precio, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#Paquete', 'Paquete', 'Descripcion',  'Precio', 'Activo'
				UNION ALL
				SELECT PaqueteId, Paquete, PaqueteTxt, CONCAT('$ ',FORMAT(Precio,2)) AS Precio, Activo
				FROM Paquetes
				WHERE Paquete LIKE '%$Paquete%'
				AND PaqueteTxt LIKE '%$Descripcion%'
				AND Precio LIKE '%$Precio%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaProductos

	function addPaquete($Paquete, $Descripcion, $Productos, $Precio)
	{
		$flag=true;
		$Q0="INSERT INTO Paquetes (PaqueteId, Paquete, PaqueteTxt, Precio, Activo)
                  VALUES(NULL, UCASE('$Paquete'), '$Descripcion', $Precio, 1)";


        $this->StartTransaccion();
        	if($this->Consulta($Q0))
        	{
       		 $IdPaquete=mysql_insert_id();
		        if($IdPaquete>0)
		        {
					foreach ($Productos as $key => $Producto)
					{
						if($Producto>0)
						{

					        $Q1="INSERT INTO PaquetesProductos (PaqueteId, ProductoId, Cantidad)
					                  VALUES('$IdPaquete', $key, $Producto)";


							if(!$this->Consulta($Q1))
							{
								$flag=false;
								break;
							}
						}
					}
				}else
					$this->CancelaTransaccion();
			}else
				$this->CancelaTransaccion();

			if($flag)
       			$this->AceptaTransaccion();
       		else
       			$this->CancelaTransaccion();
	}//addPaquete




	function deletePaquete($llaves)
	{
		$Q0="UPDATE Paquetes SET Activo=0 WHERE PaqueteId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteProducto

	function activaPaquete($llaves)
	{
		$Q0="UPDATE Paquetes SET Activo=1 WHERE PaqueteId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaProducto

	function updatePaquete($PaqueteId, $Paquete, $Descripcion, $Precio, $Productos)
	{


		$flag=true;
		$Q0="UPDATE
					Paquetes
			SET Paquete=UCASE('$Paquete'),
				Precio=REPLACE('$Precio', '$', ''),
				PaqueteTxt='$Descripcion'
			WHERE PaqueteId='$PaqueteId'";
        $Q1="DELETE FROM PaquetesProductos WHERE PaqueteId='$PaqueteId'";

        $this->StartTransaccion();
        	if($this->Consulta($Q0))
        	{
        		if($this->Consulta($Q1))

		        {
					foreach ($Productos as $key => $Producto)
					{
						if($Producto>0)
						{

					        $Q1="INSERT INTO PaquetesProductos (PaqueteId, ProductoId, Cantidad)
					                  VALUES('$PaqueteId', $key, $Producto)";


							if(!$this->Consulta($Q1))
							{
								$flag=false;
								break;
							}
						}
					}
				}else
					$this->CancelaTransaccion();
			}else
				$this->CancelaTransaccion();

			if($flag)
       			$this->AceptaTransaccion();
       		else
       			$this->CancelaTransaccion();

	}//updateProducto

/////// PROMOCIONES ////////

	function getPromociones()
	{
		$Q0="SELECT '#Promocion', 'Promocion', 'Descripcion', 'Activo&nbsp&nbsp'
				UNION ALL
				SELECT PromocionId, Promocion, PromocionTXT, Activo
				FROM Promociones
				";
		return $this->Consulta($Q0);
	}//getPromociones


//// Tipo Ajustes ////
	function getTipoAjustes()
	{
		$Q0="SELECT '#TipoAjuste', 'TipoAjuste', 'Descripcion', 'Activo'
				UNION ALL
				SELECT TipoAjusteId, TipoAjuste, TipoAjusteTxt, Activo
				FROM TipoAjustes
				";
		return $this->Consulta($Q0);
	}//getTipoAjustes

	function getTipoAjuste($TipoAjusteId)
	{
		$Q0="SELECT TipoAjuste, TipoAjusteTxt
			FROM TipoAjustes AS T1
			WHERE TipoAjusteId IN ($TipoAjusteId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaTipoAjustes($TipoAjuste, $Descripcion, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT '#TipoAjuste', 'TipoAjuste', 'Descripcion', 'Activo'
				UNION ALL
				SELECT TipoAjusteId, TipoAjuste, TipoAjusteTxt, Activo
				FROM TipoAjustes
				WHERE TipoAjuste LIKE '%$TipoAjuste%'
				AND TipoAjusteTxt LIKE '%$Descripcion%'
				AND Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaTipoAjustes

	function addTipoAjuste($TipoAjuste, $TipoAjusteTxt)
	{
		$Q0="INSERT INTO TipoAjustes (TipoAjusteId, TipoAjuste, TipoAjusteTxt, Activo)
			 VALUES(NULL, UCASE('$TipoAjuste'), UCASE('$TipoAjusteTxt'), 1)";
		$this->Insertar($Q0);
	}//addTipoAjuste

	function deleteTipoAjuste($llaves)
	{
		$Q0="UPDATE TipoAjustes SET Activo=0 WHERE TipoAjusteId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteTipoAjuste

	function activaTipoAjuste($llaves)
	{
		$Q0="UPDATE TipoAjustes SET Activo=1 WHERE TipoAjusteId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaTipoAjuste

	function updateTipoAjuste($TipoAjusteId, $TipoAjuste, $TipoAjusteTxt)
	{
		$Q0="UPDATE TipoAjustes
			 SET 	TipoAjuste='$TipoAjuste',
			 		TipoAjusteTxt='$TipoAjusteTxt'
			 WHERE TipoAjusteId =REPLACE('$TipoAjusteId', ',', '')";
		$this->Consulta($Q0);
	}//updateTipoAjuste

	//// PROVEEDORES ////
	function getProveedores()
	{
		$Q0="SELECT ' #Proveedor', 'Proveedor', 'Contacto', 'RFC', 'Telefono 1', 'Telefono 2', 'Calle', 'Colonia', 'CodigoPostal', 'Correo', 'Comentarios', 'Activo '
				UNION ALL
				SELECT ProveedorId, Nombre, Contacto, Rfc, Telefono1, Telefono2, Calle, Colonia, CodigoPostal, Correo, Comentarios, T1.Activo
				FROM Proveedores AS T1
				LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
				";
		return $this->Consulta($Q0);
	}//getProveedores

	function getProveedor($ProveedorId)
	{
		$Q0="SELECT Nombre, Contacto, Rfc, Telefono1, Telefono2, Calle, Colonia, CodigoPostal, Correo, Comentarios, T1.CodigoPostalId
			FROM Proveedores AS T1
			LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
			WHERE ProveedorId IN ($ProveedorId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function getBuscaProveedores($Proveedor, $Rfc, $Calle, $Telefono1, $Telefono2, $CodigoPostal, $Colonia, $Correo, $Web, $Matriz, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;

		$Q0="SELECT ' #Proveedor', 'Proveedor', 'Contacto', 'RFC', 'Telefono 1', 'Telefono 2', 'Calle', 'Colonia', 'CodigoPostal', 'Correo', 'Comentarios', 'Activo '
				UNION ALL
				SELECT ProveedorId, Nombre, Contacto, Rfc, Telefono1, Telefono2, Calle, Colonia, CodigoPostal, Correo, Comentarios, T1.Activo
				FROM Proveedores AS T1
				LEFT JOIN CodigosPostales AS T2 ON T2.CodigoPostalId=T1.CodigoPostalId
				WHERE T1.Proveedor LIKE '%$Proveedor%'
				AND T1.Calle LIKE '%$Calle%'
				AND T2.CodigoPostal LIKE '%$CodigoPostal%'
				AND T2.Colonia LIKE '%$Colonia%'
				AND T1.Telefono1 LIKE '%$Telefono1%'
				AND T1.Telefono2 LIKE '%$Telefono2%'
				AND T1.Correo LIKE '%$Correo%'
				AND T1.RFC LIKE '%$Rfc%'
				AND T1.Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaProveedores

	function addProveedor($Nombre, $Contacto, $Rfc, $Tel1, $Tel2, $Calle, $CodigoPostalId, $Correo, $Comentarios)
	{
		$Q0="INSERT INTO Proveedores (ProveedorId, Nombre, Contacto, Rfc, Telefono1, Telefono2, Calle, CodigoPostalId, Correo, Comentarios, Activo)
			 VALUES(NULL, UCASE('$Nombre'), UCASE('$Contacto'), UCASE('$Rfc'), '$Tel1', '$Tel2', UCASE('$Calle'), '$CodigoPostalId', '$Correo', '$Comentarios',  1)";
		$this->Insertar($Q0);
	}//addProveedor

	function deleteProveedor($llaves)
	{
		$Q0="UPDATE Proveedores SET Activo=0 WHERE ProveedorId IN ($llaves 0)";
		$this->Consulta($Q0);
	}

	function activaProveedor($llaves)
	{
		$Q0="UPDATE Proveedores SET Activo=1 WHERE ProveedorId IN ($llaves 0)";
		$this->Consulta($Q0);
	}

	function updateProveedor($ProveedorId, $Nombre, $Contacto, $Rfc, $Tel1, $Tel2, $Calle, $CodigoPostalId, $Correo, $Comentarios)
	{
		$Q0="UPDATE Proveedores
			 SET 	Nombre='$Nombre',
			 		Contacto='$Contacto',
			 		Calle='$Calle',
			 		CodigoPostalId=$CodigoPostalId,
			 		Telefono1='$Tel1',
			 		Telefono2='$Tel2',
			 		Correo='$Correo',
			 		RFC=UCASE('$Rfc'),
			 		Comentarios='$Comentarios'
			 WHERE ProveedorId IN ($ProveedorId 0)";
		$this->Consulta($Q0);
	}//addProveedor


//// ARTICULOS ////
	function getArticulos()
	{
		$Q0="SELECT '#Articulo', 'Clase Articulo', 'Articulo', 'Descripcion', 'Atributo 1', 'Atributo 2', 'Atributo 3', 'Costo', 'Minimo', 'Maximo', 'Activo'
				UNION ALL
				SELECT ArticuloId, ClaseArticulo, Articulo, descripcion, Att1, Att2, Att3, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, Minimo, Maximo, T1.Activo
				FROM Articulos AS T1
				LEFT JOIN ClaseArticulos AS T2 ON T2.ClaseArticuloId=T1.ClaseArticuloId
			";
		return $this->Consulta($Q0);
	}//getArticulos


	function getArticulo($ArticuloId)
	{
		$Q0="SELECT '#Articulo', 'Clase Articulo', 'Articulo', 'Descripcion', 'Atributo 1', 'Atributo 2', 'Atributo 3', 'Costo', 'Minimo', 'Maximo', 'Activo'
				UNION ALL
				SELECT ArticuloId, ClaseArticulo, Articulo, Descripcion, Att1, Att2, Att3, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, Minimo, Maximo, T1.Activo
				FROM Articulos AS T1
				LEFT JOIN ClaseArticulos AS T2 ON T2.ClaseArticuloId=T1.ClaseArticuloId
				WHERE T1.ArticuloId IN ($ArticuloId 0)
			LIMIT 1";
		return mysql_fetch_row($this->Consulta($Q0));
	}//getArticulo

	function getBuscaArticulos($ClaseArticuloId, $Articulo, $Descripcion, $Att1, $Att2, $Att3, $Costo, $Minimo, $Maximo, $Activo)
	{
		if($Activo==2)
			$FActivo='0,1';
		else
			$FActivo=$Activo;


		$Q0="SELECT '#Articulo', 'Clase Articulo', 'Articulo', 'Descripcion', 'Atributo 1', 'Atributo 2', 'Atributo 3', 'Costo', 'Minimo', 'Maximo', 'Activo'
				UNION ALL
				SELECT ArticuloId, ClaseArticulo, Articulo, Descripcion, Att1, Att2, Att3, CONCAT('$ ',FORMAT(Costo,2)) AS Costo, Minimo, Maximo, T1.Activo
				FROM Articulos AS T1
				LEFT JOIN ClaseArticulos AS T2 ON T2.ClaseArticuloId=T1.ClaseArticuloId
				WHERE T1.ClaseArticuloId=$ClaseArticuloId
				AND Articulo LIKE '%$Articulo%'
				AND Descripcion LIKE '%$Descripcion%'
				AND Att1 LIKE '%$Att1%'
				AND Att2 LIKE '%$Att2%'
				AND Att3 LIKE '%$Att3%'
				AND Costo LIKE '%$Costo%'
				AND Precio LIKE '%$Precio%'
				AND T1.Activo IN ($FActivo)
				";
		return $this->Consulta($Q0);
	}//getBuscaArticulos

	function addArticulo($ClaseArticuloId, $Articulo, $Descripcion, $Att1, $Att2, $Att3, $Costo, $Minimo, $Maximo)
	{
		$Q0="INSERT INTO Articulos (ArticuloId, ClaseArticulo, Articulo, Descripcion, Att1, Att2, Att3, Costo, Minimo, Maximo, Activo)
                  VALUES(NULL, $ClaseArticuloId, UCASE('$Articulo'), UCASE('$Descripcion'), UCASE('$Att1'), UCASE('$Att2'), UCASE('$Att3'), $Costo, $Minimo, $Maximo, 1)";

        $this->StartTransaccion();
        		if($this->Consulta($Q0))
        		{
        			$this->AceptaTransaccion();
        			return true;
        		}
  		$this->CancelaTransaccion();
        return false;

	}//addArticulo

	function deleteArticulo($llaves)
	{
		$Q0="UPDATE Articulos SET Activo=0 WHERE ArticuloId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//deleteArticulo

	function activaArticulo($llaves)
	{
		$Q0="UPDATE Articulos SET Activo=1 WHERE ArticuloId IN ($llaves 0)";
		$this->Consulta($Q0);
	}//activaArticulo

	function updateArticulo($ClaseArticuloId, $Articulo, $Descripcion, $Att1, $Att2, $Att3, $Costo, $Minimo, $Maximo)
	{
		$Q0="UPDATE Articulos SET ClaseArticuloId=$ClaseArticuloId,
								  Articulo=UCASE('$Articulo'),
								  Descripcion=UCASE('$Descripcion'),
								  Att1=UCASE('$Att1'),
								  Att2=UCASE('$Att2'),
								  Att3=UCASE('$Att3'),
								  Costo=$Costo,
								  Minimo=$Minimo,
								  Maximo=$Maximo
			 WHERE ArticuloId=REPLACE('$ArticuloId', ',', '')";

        $this->StartTransaccion();
        		if($this->Consulta($Q0))
        		{
        			$this->AceptaTransaccion();
        			return true;
        		}
        $this->CancelaTransaccion();
        return false;
	}//updateArticulo

	function getListaPuntos()
	{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>#PuntoVenta</th>
							<th>Region</th>
							<th>SunRegion</th>
							<th>Plaza</th>
							<th>Punto de Venta</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.PuntoVentaId, Region, SubRegion, Plaza, PuntoVenta FROM PuntosVenta AS T1
			  LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
			  LEFT JOIN SubRegiones AS T3 ON T3.SubRegionId=T2.SubRegionId
			  LEFT JOIN Regiones AS T4 ON T4.RegionId=T3.RegionId
			  WHERE PuntoVentaId IN ($MisPuntos) AND T1.Activo=1
			  ORDER BY PuntoVenta ASC
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,2)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaAsesores()
	{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla2" >
					<thead>
						<tr>
							<th>#Asesor</th>
							<th>Punto de Venta</th>
							<th>#Coordinador</th>
							<th>Coordinador</th>
							<th>Asesor</th>
							<th>RFC</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T2.HistorialPuestoEmpleadoId, Puntoventa, CoordinadorId,
				       CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno) AS Coordinador,
				       CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno) AS Empleado,
				       T4.RFC
				FROM CoordinadoresEmpleados AS T1
        		LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.FechaBaja='0000-00-00'
				LEFT JOIN HistorialPuntosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.Fisico=1 AND T3.FechaBaja='0000-00-00'
				LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T1.EmpleadoId
				LEFT JOIN PuntosVenta AS T5 ON T5.PuntoVentaId=T3.PuntoVentaId
				LEFT JOIN Empleados AS T7 ON T7.EmpleadoId=T1.CoordinadorId
				WHERE T1.FechaBaja='0000-00-00'AND T2.HistorialPuestoEmpleadoId IS NOT NULL
				AND T5.PuntoVentaId IN ($MisPuntos)
				GROUP BY T2.HistorialPuestoEmpleadoId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td>'.$A0[4].'</td>
							<td>'.$A0[5].'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,3)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaProductosTP($Clave)
	{
		$Cadena='<table id="MiTabla6" >
					<thead>
						<tr>
							<th>#Producto</th>
							<th>Clave</th>
							<th>Descripcion</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT ProductoId, Clave, Descripcion FROM TPProductos WHERE Activo=1";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="AddProducto('.$Clave.','.$A0[0].')"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}


	function getListaReferencias($Clave)
	{


		$Cadena='<table id="MiTablaR" >
					<thead>
						<tr>
							<th>Nombre Referencia</th>
							<th>Parentesco</th>
							<th>Telefono</th>
							<th>Correo Electronico</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT CONCAT_WS(' ', Nombre, paterno, Materno) AS Referencia, Parentesco, Telefono, Mail
				FROM Referencias AS T1
				LEFT JOIN Parentescos AS T2 ON T2.ParentescoId=T1.ParentescoId
				WHERE Clave='$Clave'
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}


	function getListaAddOn()
	{

		$Cadena='<table id="MiTabla3" >
					<thead>
						<tr>
							<th>#Add On</th>
							<th>Add On</th>
							<th>Descripcion</th>
							<th>Seleciona</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT AddonId, Addon, AddonTxt FROM Addon WHERE Activo=1";
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td align="center"><input type="checkbox"  name="AddOns" id="AddOns" class="pv" value="'.$A0[0].'" onclick="setSeleccion(this, 2)" /></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaServicios()
	{

		$Cadena='<table id="MiTabla4" >
					<thead>
						<tr>
							<th>#Servicio Adicional</th>
							<th>Servicio Adicional</th>
							<th>Seleciona</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT ServicioAdicionalId, ServicioAdicional FROM ServiciosAdicionales WHERE Activo=1";
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><input type="checkbox"  name="OtrosServ" id="OtrosServ" class="pv" value="'.$A0[0].'" onclick="setSeleccion(this, 3)" /></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaClientes($Nombre)
	{
		//$MisPuntos=$this->getMisPuntos();
		$Cadena='<br><table id="MiTabla5" >
					<thead>
						<tr>
							<th>#Cliente</th>
							<th>Nombre</th>
							<th>RFC</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT ClienteId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Cliente, RFC FROM Clientes WHERE CONCAT_WS(' ', Nombre, Paterno, Materno) LIKE '%$Nombre%'";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td align="center"><input type="radio" name="ClienteId" id="ClienteId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,4)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaEquipos()
	{
		$Cadena='<table id="MiTabla6" >
					<thead>
						<tr>
							<th>#Equipo</th>
							<th>Equipo</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT EquipoId, Equipo AS Equipo
			  FROM Equipos AS T1
			  LEFT JOIN Marcas AS T2 ON T2.MarcaId=T1.MarcaId
			  WHERE T1.Activo=1";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><input type="radio" name="EquipoId" id="EquipoId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,5)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaPlanes()
	{
		$Venta=$this->getClasificacionVenta();
		$Cadena='<table id="MiTabla7" >
					<thead>
						<tr>
							<th>#Plan</th>
							<th>#TipoPlan</th>
							<th>Plan</th>
							<th>Descripcion</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.PlanId, T1.TipopLanId, CONCAT_WS(' ',T3.TipoPlan, T2.Plan), Sigi FROM TiposPlanPlanes AS T1
			  LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
			  LEFT JOIN TiposPlan AS T3 ON T3.TipoPlanId=T1.TipoPlanId
  			  WHERE T2.Activo=1 AND ClasificacionPersonalVentaId IN ($Venta)";

//  			echo $Q0;

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td align="center"><input type="radio" name="PlanId" id="PlanId" class="Pt" value="'.$A0[0].','.$A0[1].'" onclick="setEleccion(this,6)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}
	function getListaPlanesV2($FamiliaPlanId)
	{
		$Venta=$this->getClasificacionVenta();
		$Cadena='<table id="MiTabla7" >
					<thead>
						<tr>
							<th>#Plan</th>
							<th>#TipoPlan</th>
							<th>Plan</th>
							<th>Descripcion</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		if($FamiliaPlanId==4){
		    	$Q0= "SELECT T1.PlanId, T1.TipopLanId, CONCAT_WS(' ',T3.TipoPlan, T2.Plan), Sigi FROM TiposPlanPlanes AS T1
			  LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
			  LEFT JOIN TiposPlan AS T3 ON T3.TipoPlanId=T1.TipoPlanId
  			  WHERE T2.Activo=1 AND ClasificacionPersonalVentaId IN ($Venta) AND (FamiliaPlanId=$FamiliaPlanId OR T2.PlanId=367)";
		}else{
		    $Q0= "SELECT T1.PlanId, T1.TipopLanId, CONCAT_WS(' ',T3.TipoPlan, T2.Plan), Sigi FROM TiposPlanPlanes AS T1
			  LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
			  LEFT JOIN TiposPlan AS T3 ON T3.TipoPlanId=T1.TipoPlanId
  			  WHERE T2.Activo=1 AND ClasificacionPersonalVentaId IN ($Venta) AND FamiliaPlanId=$FamiliaPlanId";
		}
	

//  			echo $Q0;

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td align="center"><input type="radio" name="PlanId" id="PlanId" class="Pt" value="'.$A0[0].','.$A0[1].'" onclick="setEleccion(this,6)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}
//:: Ventanilla Unica :::::::::::::::::::::::::::::::::::::::::::::::::::::::::://


	function addReferencia($Clave, $ParentescoId, $Nombre, $Paterno, $Materno, $Telefono, $Mail)
	{
		$Q0="INSERT INTO Referencias
			 (ReferenciaId, ParentescoId, Nombre, paterno, Materno, Telefono, Mail, Clave)
			 VALUES(NULL, $ParentescoId, UCASE('$Nombre'), UCASE('$Paterno'), UCASE('$Materno'), UCASE('$Telefono'), UCASE('$Mail'), '$Clave')";

		if($this->Consulta($Q0) & $this->addBitacora(22, 2, mysql_insert_id(),'', 'Referencia'))
		{
			return $this->getListaReferencias($Clave);
		}
		else
			return utf8_decode('<span class="alerta">¡No fue posible agregar el registro!</span>');

	}

	function addCliente($TipoPersonaId, $NombreC, $PaternoC, $MaternoC, $RFCC, $Calle, $NExterior,$NInterior, $ColoniaId, $TLocal, $TMovil, $NombreCT, $PaternoCT, $MaternoCT)
	{
		$this->StartTransaccion();
		$Q0="INSERT INTO Clientes (ClienteId, Nombre, Paterno, Materno, RFC, TipoPersonaId)
            VALUE (NULL, UCASE('$NombreC'), UCASE('$PaternoC'), UCASE('$MaternoC'), UCASE('$RFCC'), $TipoPersonaId)";

		if($this->Consulta($Q0))
		{
			$ClienteId=mysql_insert_id();
			$Q1="INSERT INTO HistorialDatosClientes (HistorialDatosClienteId, ClienteId, NombreContacto,
													 PaternoContacto, MaternoContacto, Calle,
													 NoExterior, NoInterior, ColoniaId, TelefonoLocal, TelefonoMovil)
							 VALUES(NULL, $ClienteId, UCASE('$NombreCT'), UCASE('$PaternoCT'), UCASE('$MaternoCT'),
							 		UCASE('$Calle'), '$NExterior','$NInterior', $ColoniaId, '$TLocal', '$TMovil')
			";
			if($this->Consulta($Q1) & $this->addBitacora(22, 2, $ClienteId,'', 'Cliente'))
			{
			$this->AceptaTransaccion();
			return $ClienteId;
			}
		}
			$this->CancelaTransaccion();
			return 0;

	}

	function addLinea($Clave, $EquipoId, $PlanId, $TipoPlanId, $AddOn, $Servicios, $Plazo, $Contrato, $Comentario)
	{
		$Q0="INSERT INTO TLineas (RegistroId, Clave, EquipoId, PlanId, TipoPlanId,  PlazoId, Contrato, Dn, Diferencial, TipoPagoDiferencial, Comentario)
                   VALUES(NULL, '$Clave', $EquipoId, $PlanId, $TipoPlanId, '$Plazo', $Contrato, '', 0, 0, '$Comentario')";

		$this->StartTransaccion();
		if($this->Consulta($Q0))
		{
			$RegistroId=mysql_insert_id();

		$Q1="INSERT IGNORE INTO TLineasAddon
			 SELECT $RegistroId, AddonId FROM Addon WHERE AddonId IN ($AddOn)";

		$Q2="INSERT IGNORE INTO TLineasServicios
			 SELECT $RegistroId, ServicioAdicionalId FROM ServiciosAdicionales WHERE ServicioAdicionalId IN ($Servicios)";


		if($this->Consulta($Q1) & $this->Consulta($Q2))
			{
				$this->AceptaTransaccion();
			}
		}
			$this->CancelaTransaccion();

		return $this->getListaLineas($Clave);
	}

	function getListaLineas($Clave)
	{	$Cta=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Plan</th>
							<th>Tipo Plan</th>
							<th>Plazo</th>
							<th>AddOn</th>
							<th>Servicios</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT Equipo, Plan, TipoPlan, Plazo, AddOn, Servicios, T1.RegistroId
				FROM TLineas AS T1
				LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId
				LEFT JOIN Planes AS T3 ON T3.PlanId=T1.PlanId
				LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
				LEFT JOIN Plazos AS T5 ON T5.PlazoId=T1.PlazoId
				LEFT JOIN (SELECT RegistroId, GROUP_CONCAT(AddOn SEPARATOR ' - ') AS AddOn FROM TLineasAddon AS T1
				           LEFT JOIN Addon AS T2 ON T2.AddonId=T1.AddonId
				           GROUP BY RegistroId
				          ) AS T6 ON T6.RegistroId=T1.RegistroId
				LEFT JOIN (SELECT RegistroId, GROUP_CONCAT(ServicioAdicional SEPARATOR ' - ') AS Servicios FROM TLineasServicios AS T1
				           LEFT JOIN ServiciosAdicionales AS T2 ON T2.ServicioAdicionalId=T1.ServicioAdicionalId
				           GROUP BY RegistroId
				          ) AS T7 ON T7.RegistroId=T1.RegistroId
				WHERE T1.Clave='$Clave'
			  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[6].','.$Clave.',1)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(Clave) AS Cta FROM TLineas WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}

	function removeLinea($RegistroId, $Clave)
	{
		$Q0="DELETE FROM TLineas WHERE RegistroId=$RegistroId";
		$this->Consulta($Q0);
		return $this->getListaLineas($Clave);
	}

function altaFolioVU($Folio,$FechaContrato, $PuntoVentaId, $VendedorId, $CoordinadorId, $ClienteId,
        $TipoContratacionId, $TipoPagoId, $Comentarios='', $Clave, $ContratacionId,$PlataformaId)
{
	$FechaContrato=$this->CambiarFormatoFecha($FechaContrato);

	if($this->Existe('Folio',$Folio,'HFolios'))
		return utf8_decode('<span class="alerta">¡Este Folio ya existe!</span>');

	$this->StartTransaccion();
	$Q0="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, ContratacionId, Validado,PlataformaId)
					 VALUES(UCASE('$Folio'), CURDATE(), '$FechaContrato', '$FechaContrato', $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, $ClienteId,
        					$TipoContratacionId, $TipoPagoId, '$Comentarios', '$Clave',0, 1, $ContratacionId, 0,$PlataformaId)";
	$Q1="INSERT INTO LFolios
		 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 9,
		 CostoPlan+IFNULL(SUM(CostoAddOn),0) AS Costo, 0 AS RentaSI, T1.Comentario, '$FechaContrato', '', '', Dn, 0, 0,0
		 FROM TLineas AS T1
		 LEFT JOIN TLineasAddon AS T2 ON T2.RegistroId=T1.RegistroId
		 LEFT JOIN PreciosPlanes AS T3 ON T3.PlanId=T1.PlanId AND T3.AddOnId=IFNULL(T2.AddOnId,0)
		 WHERE Clave='$Clave'
		 GROUP BY T1.RegistroId";

	$Q2="INSERT INTO LineasAddon
		 SELECT T1.RegistroId, T1.AddonId,0 FROM TLineasAddon AS T1
		 LEFT JOIN TLineas AS T2 ON T2.RegistroId=T1.RegistroId
		 WHERE T2.Clave='$Clave'";

	$Q3="INSERT INTO LineasServicios
		 SELECT T1.RegistroId, T1.ServicioAdicionalId, 0 FROM TLineasServicios AS T1
		 LEFT JOIN TLineas AS T2 ON T2.RegistroId=T1.RegistroId
		 WHERE T2.Clave='$Clave'";

	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->addBitacora(22, 2, 0, $Folio,''))
			{
				$this->AceptaTransaccion();
				return 'OK';
			}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function altaFolioOrsIn($Folio,$FechaContrato, $PuntoVentaId, $VendedorId, $CoordinadorId, $ClienteId,
        $TipoContratacionId, $TipoPagoId, $Comentarios='',$PlataformaId)
{
	$FechaContrato=$this->CambiarFormatoFecha($FechaContrato);

	if($this->Existe('Folio',$Folio,'HFolios'))
		return utf8_decode('<span class="alerta">¡Este Folio ya existe!</span>');

	$this->StartTransaccion();
	$QX="INSERT INTO Movimientos VALUES(NULL)";
	$this->Consulta($QX);
	$MovimientoId=mysql_insert_id();

	$Q0="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, Validado,PlataformaId)
					 VALUES('$Folio', CURDATE(), '$FechaContrato', '0000-00-00', $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, $ClienteId,
        					$TipoContratacionId, $TipoPagoId, '$Comentarios', '$Folio',$MovimientoId, 1, 0,$PlataformaId)";
	$Q1="INSERT INTO LFolios
		 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 9,
		 		CostoPlan+IFNULL(SUM(CostoAddOn),0) AS Costo, 0 AS RentaSI, '', CURDATE(), '', Contrato, Dn, 0, 0,0
		 FROM TLineas AS T1
		 LEFT JOIN TLineasAddon AS T2 ON T2.RegistroId=T1.RegistroId
		 LEFT JOIN PreciosPlanes AS T3 ON T3.PlanId=T1.PlanId AND T3.AddOnId=IFNULL(T2.AddOnId,0)
		 WHERE Clave='$Folio'
		 GROUP BY T1.RegistroId";

	$Q2="INSERT INTO LineasAddon
		 SELECT T1.RegistroId, T1.AddonId,0 FROM TLineasAddon AS T1
		 LEFT JOIN TLineas AS T2 ON T2.RegistroId=T1.RegistroId
		 WHERE T2.Clave='$Folio'";

	$Q3="INSERT INTO LineasServicios
		 SELECT T1.RegistroId, T1.ServicioAdicionalId, 0 FROM TLineasServicios AS T1
		 LEFT JOIN TLineas AS T2 ON T2.RegistroId=T1.RegistroId
		 WHERE T2.Clave='$Folio'";

	$Q4="INSERT INTO Bitacora
		 SELECT NULL, $this->UsuarioId, 26, 5, RegistroId, '', 14, CURDATE(), CURTIME(), 'Cambio estatus'
		 FROM TLineas WHERE Clave='$Folio'";

	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->addBitacora(22, 2, 0, $Folio,''))
			{
				$this->AceptaTransaccion();
				return 'OK';
			}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function ScrollCoordinadores($valor)
{
	$MisPuntos=$this->getMisPuntos();
		$query="SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Coordinador
				FROM HistorialPuestosEmpleados AS T1
				LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				LEFT JOIN HistorialPuntosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.FechaBaja='0000-00-00'
				LEFT JOIN Puestos AS T4 ON T4.PuestoId=T1.PuestoId
				WHERE T1.FechaBaja='0000-00-00' AND IsCoordinador=1
				AND T3.PuntoventaId IN ($MisPuntos)
				GROUP BY T1.EmpleadoId
				ORDER BY CONCAT_WS(' ', Nombre, Paterno, Materno)
				";

		$resultado=mysql_query("$query", $this->conexion) or die(mysql_error());

		while($arreglo=mysql_fetch_row($resultado))
		{
			if ($valor==$arreglo[0])
			{
				echo "<option selected value=\"$arreglo[0]\" title=\"".utf8_decode($arreglo[1])."\" >".utf8_decode($arreglo[1])."</option> \n";
			}
			else
			{
				echo "<option value=\"$arreglo[0]\" title=\"$arreglo[1]\">".utf8_decode($arreglo[1])."</option> \n";
			}
		}
	}//Scroll

function getHFolio($Folio)
{

$Q0="SELECT
			TipoContratacionId,
			DATE_FORMAT(FechaContrato, '%d/%m/%Y') AS FContratacion,
			DATE_FORMAT(FechaSS, '%d/%m/%Y') AS FContratacion,
			TipoPagoId,
			T1.PuntoventaId,
			PuntoVenta,
			T1.HistorialPuestoEmpleadoId,
			CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno) AS Vendedor,
			T7.SubCategoriaId,
			T7.SubCategoria,
			CoordinadorId,
			CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno) AS Coordinador,
			Comentarios,
			T1.ClienteId,
			CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
			T6.RFC, Clave
			FROM HFolios AS T1
			LEFT JOIN PuntosVenta AS T2 ON T2.PuntoventaId=T1.PUntoVentaId
			LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
			LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
			LEFT JOIN Empleados AS T5 ON T5.EmpleadoId=T1.CoordinadorId
			LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
			LEFT JOIN SubCategorias AS T7 ON T7.SubCategoriaId=T3.SubCategoriaId
				WHERE Folio='$Folio'";
	return mysql_fetch_row($this->Consulta($Q0));
}

function PreparaLineas($Folio, $Clave)
{
	$Q0="INSERT IGNORE INTO TLineas
		SELECT  RegistroId, '$Clave', EquipoId, PlanId, TipoPlanId, PlazoId, ''
		FROM LFolios WHERE Folio='$Folio'";
return $this->Consulta($Q0);
}

function getTablaConsultas()
{
	$Q0="SELECT 'Opciones', 'ConsultaId','Consulta', 'Descripcion'
		 UNION ALL
 		 SELECT CONCAT('descargaConsulta(',T1.ConsultaId,');') AS Opcion, T1.ConsultaId, Consulta, ConsultaTxt
 		 FROM Consultas AS T1
		 INNER JOIN ConsultasUsuarios AS T2 ON T2.ConSultaId=T1.ConsulTaId
		 WHERE T2.UsuarioId=$this->UsuarioId AND T1.Activo=1";
	return $this->Consulta($Q0);
}

function getTablaTutoriales()
{
	$Q0="SELECT 'Opciones', 'Tutorial', 'Descripcion'
		 UNION ALL
 		 SELECT CONCAT('window.open(\'Manuales/',Url,'\')') AS Opcion,
 		 		Tutorial, TutorialTxt
 		 FROM Tutoriales AS T1
		 WHERE T1.Activo=1";
	return $this->Consulta($Q0);
}


function getTablaLayout()
{
	$Q0="SELECT 'Opciones', 'Layout', 'Descripcion'
		 UNION ALL
 		 SELECT CONCAT('descargaLayout(',LayoutId,');') AS Opcion, Layout, LayoutTxt FROM Layout WHERE Activo=1";
	return $this->Consulta($Q0);
}

function getConsultaVU()
{
	$Venta=$this->getClasificacionVenta();
	$Q0="SELECT
		'Año',	'Mes',	'Region',	'SubRegion',	'Plaza',	'PuntoVenta',	'Contrato',	'Folio',
		'Coordinador',	'Ejecutivo',	'Categoria',	'SubCategoria',	'TipoPersona',	'Cliente',	'RFC',
		'TipoPago',	'RegistroId',	'Marca',	'Equipo',	'PlanBum',	'RentaPlan',	'RentaSIVA',
		'RentaSImpuesto',	'Plazo',	'Estatus',	'Comentario',	'FechaEntrega',	'FechaFacturado',
		'Evento',	'Familia',	'ClavePlan', 'Tipo Contratacion', 'Fecha de Ingreso SVU', 'TipoPunto', 'Fecha Captura','Plataforma'
		UNION
		SELECT
		DATE_FORMAT(FechaSS, '%Y') AS Año,
		   CASE DATE_FORMAT(FechaSS,'%m')
		       WHEN '01' THEN 'ENERO'
		       WHEN '02' THEN 'FEBRERO'
		       WHEN '03' THEN 'MARZO'
		       WHEN '04' THEN 'ABRIL'
		       WHEN '05' THEN 'mayo'
		       WHEN '06' THEN 'JUNIO'
		       WHEN '07' THEN 'JULIO'
		       WHEN '08' THEN 'AGOSTO'
		       WHEN '09' THEN 'SEPTIEMBRE'
		       WHEN '10' THEN 'OCTUBRE'
		       WHEN '11' THEN 'NOVIEMBRE'
		       WHEN '12' THEN 'DICIEMBRE'
	       END AS Mes,
IF(T10.EmpleadoId=778,'CORPORATIVO',Region),
IF(T10.EmpleadoId=778,'CORPORATIVO',SubRegion),
IF(T10.EmpleadoId=778,'CORPORATIVO',Plaza),
IF(T10.EmpleadoId=778,'CORPORATIVO',PuntoVenta),
Serie AS Contrato,
T1.Folio,
CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
Puesto AS Categoria,
IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
TipoPersona,
CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
T11.Rfc,
TipoPago,
RegistroId,
Marca,
Equipo,
PlanBum,
RentaPlan,
RentaSIVA,
RentaSImpuesto,
Plazo,
Estatus,
UCASE(Comentario) AS Comentario,
FechaEntrega,
FechaFacturado,
IF(T1.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento,
Familia,
ClavePlan,
TipoContratacion,
DATE_FORMAT(FechaSS,'%d/%m/%Y'),
TipoPunto,
DATE_FORMAT(FechaCaptura,'%d/%m/%Y'),
Plataforma
FROM HFolios AS T1
LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
LEFT JOIN (
            SELECT
                  Folio,
                  T1.RegistroId,
                  Familia,
                  Marca,
                  Equipo,
                  Serie,
                  T2.Clave AS ClavePlan,
                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
                  Costo AS RentaPlan,
                  Costo/1.16 AS RentaSIVA,
                  Costo/1.16/1.03 AS RentaSImpuesto,
                  Plazo,
                  Estatus,
                  Comentario,
                  /*
                  IF(T10.Host=9, DATE_FORMAT(T10.Fecha, '%d/%m/%Y'), '') AS FechaEntrega,
                  IF(T8.Host=7, DATE_FORMAT(T8.Fecha, '%d/%m/%Y'), '') AS FechaFacturado
                  */
                  DATE_FORMAT(T1.FechaEstatus, '%d/%m/%Y') AS FechaEntrega,
                  DATE_FORMAT(T1.FechaEstatus, '%d/%m/%Y') AS FechaFacturado
            FROM LFolios AS T1
            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
            LEFT JOIN (
                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn
                        FROM LineasAddon AS T1
                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
                        GROUP BY RegistroId
                      ) AS T3 ON T3.RegistroId=T1.RegistroId
            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
            #LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=7) AS T8 ON T8.ObjetoId=T1.RegistroId
            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
            LEFT JOIN Marcas AS T10 ON T10.MarcaId=T9.MarcaId
            #LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=9) AS T10 ON T10.ObjetoId=T1.RegistroId
        ) AS T14 ON T14.Folio=T1.Folio
LEFT JOIN TiposContratacion AS T15 ON T15.TipoContratacionId=T1.TipoContratacionId
LEFT JOIN TipoPuntos AS T16 ON T16.TipoPuntoId=T2.TipoPuntoId
LEFT JOIN Plataformas AS T17 ON T1.PlataformaId=T17.PlataformaId
WHERE MovimientoId=0 AND EnReporte=1 AND ClasificacionPersonalVenta IN ($Venta)
GROUP BY T14.RegistroId";
return $this->Consulta($Q0);
}


function getConsultaVUMC()
{
	$Venta=$this->getClasificacionVenta();

	$MisPuntos=$this->getMisPuntos();

	$Q0="SELECT 'Año',	'Mes',	'Region',	'SubRegion',	'Plaza',	'PuntoVenta',	'Folio',
				'Coordinador',	'Ejecutivo',	'Categoria',	'SubCategoria',	'TipoPersona',
				'Cliente',	'TipoPago',	'Equipo',	'PlanBum',	'RentaPlan',	'Plazo',
				'Estatus',	'Comentario',	'FechaEntrega',	'FechaFacturado',
				'Evento',	'Familia',	'ClavePlan'
		UNION ALL
		SELECT
DATE_FORMAT(FechaSS, '%Y') AS Año,
CASE DATE_FORMAT(FechaSS,'%m')
       WHEN '01' THEN 'enero'
       WHEN '02' THEN 'febrero'
       WHEN '03' THEN 'marzo'
       WHEN '04' THEN 'abril'
       WHEN '05' THEN 'mayo'
       WHEN '06' THEN 'junio'
       WHEN '07' THEN 'julio'
       WHEN '08' THEN 'agosto'
       WHEN '09' THEN 'septiembre'
       WHEN '10' THEN 'octubre'
       WHEN '11' THEN 'noviembre'
       WHEN '12' THEN 'diciembre'
       END AS Mes,
IF(T10.EmpleadoId=778,'CORPORATIVO',Region),
IF(T10.EmpleadoId=778,'CORPORATIVO',SubRegion),
IF(T10.EmpleadoId=778,'CORPORATIVO',Plaza),
IF(T10.EmpleadoId=778,'CORPORATIVO',PuntoVenta),
T1.Folio,
CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
Puesto AS Categoria,
IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
TipoPersona,
CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
TipoPago,
Equipo,
PlanBum,
RentaPlan,
Plazo,
Estatus,
UCASE(Comentario) AS Comentario,
FechaEntrega,
FechaFacturado,
IF(TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento,
Familia,
ClavePlan

FROM HFolios AS T1
LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
LEFT JOIN (
            SELECT
                  Folio,
                  T1.RegistroId,
                  Familia,
                  Marca,
                  Equipo,
                  Serie,
                  T2.Clave AS ClavePlan,
                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
                  Costo AS RentaPlan,
                  Costo/1.16 AS RentaSIVA,
                  Costo/1.16/1.03 AS RentaSImpuesto,
                  Plazo,
                  Estatus,
                  Comentario,
                 /* IF(T10.Host=9, DATE_FORMAT(T10.Fecha, '%d/%m/%Y'), '') AS FechaEntrega,
                  IF(T8.Host=7, DATE_FORMAT(T8.Fecha, '%d/%m/%Y'), '') AS FechaFacturado
                  */
                  DATE_FORMAT(T1.FechaEstatus, '%d/%m/%Y') AS FechaEntrega,
                  DATE_FORMAT(T1.FechaEstatus, '%d/%m/%Y') AS FechaFacturado
            FROM LFolios AS T1
            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
            LEFT JOIN (
                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn
                        FROM LineasAddon AS T1
                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
                        GROUP BY RegistroId
                      ) AS T3 ON T3.RegistroId=T1.RegistroId
            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
            #LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=7) AS T8 ON T8.ObjetoId=T1.RegistroId
            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
            LEFT JOIN Marcas AS T10 ON T10.MarcaId=T9.MarcaId
            #LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=9) AS T10 ON T10.ObjetoId=T1.RegistroId
        ) AS T14 ON T14.Folio=T1.Folio
WHERE MovimientoId=0 AND T1.PuntoventaId IN ($MisPuntos) AND EnReporte=1 AND ClasificacionPersonalVenta IN ($Venta)
GROUP BY T14.RegistroId";

return $this->Consulta($Q0);

}

function getPersonal()
{
	$Venta=$this->getClasificacionVenta();
	$MisPuntos=$this->getMisPuntos();

	$Q0="SELECT 'OperadorId', '%Pago', 'FechaPago',	'EmpleadoId', 'Region', 'SubRegion', 'Plaza',
				'PuntoVenta', 'Nombre',	'Nombre','Nombre', 'Paterno', 'Materno',	'FechaIngreso',
				'NumeroCuenta',	'Clabe', 'Banco', 'Puesto',	'SubCategoria',
				'EstatusIMSS', 'Reporta', 'TotalPagar', 'Tipo', 'RFC', 'CURP', 'Numero Seguro Social','CANAL DE VENTA', 'CALLE', 'Correo Electronico',
				'Tipo punto de venta'
		UNION ALL
SELECT T10.Operador,
       CONCAT(T10.Porcentaje,'%') AS '%Pago',
       '' AS FechaPago,
       T1.EmpleadoId,
       Region,
       SubRegion,
       Plaza,
       PuntoVenta,
       CONCAT_WS(' ',T1.Nombre, T1.Paterno, T1.Materno) AS Nombre,
       CONCAT_WS(' ',T1.Paterno, T1.Materno,T1.Nombre) AS Nombre2,
       T1.Nombre,
       T1.Paterno,
       T1.Materno,
       DATE_FORMAT(T1.UltimaFechaIngreso,'%d/%m/%Y') AS FechaIngreso,
       CONCAT('\'',NoCuenta) AS NumeroCuenta,
       CONCAT('\'',Clabe) AS Clabe,
       Banco,
       Puesto,
       T12.SubCategoria,
       IF(T10.Operador!=7,'ACTIVO','INACTIVO') AS EstatusIMSS,

       CONCAT_WS(' ', T14.Nombre, T14.Paterno, T14.Materno) AS Reporta,
       '' AS TotalPagar,
       '' AS Tipo,
       T1.RFC,
       T1.CURP,
       T1.NumeroSeguroSocial,
	T17.ClasificacionPersonalVenta, T8.Calle, T18.Correo,
	IF(T3.SubDistribuidorId=1,'SubDistribuidor','Punto propio')

FROM Empleados AS T1
LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND FechaBaja='0000-00-00' AND T2.Fisico=1
LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoventaId
LEFT JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
LEFT JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
LEFT JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
LEFT JOIN (
            SELECT MAX(HistorialDatosEmpleadoId) AS HistorialDatosEmpleadoId,
                   EmpleadoId
            FROM HistorialDatosEmpleados GROUP BY EmpleadoId
          ) AS T7 ON T7.EmpleadoId=T1.EmpleadoId
LEFT JOIN HistorialDatosEmpleados AS T8 ON T8.HistorialDatosEmpleadoId=T7.HistorialDatosEmpleadoId
LEFT JOIN Bancos AS T9 ON T9.BancoId=T8.BancoId
LEFT JOIN HistorialPuestosEmpleados AS T10 ON T10.EmpleadoId=T1.EmpleadoId AND T10.FechaBaja='0000-00-00'
LEFT JOIN Puestos AS T11 ON T11.PuestoId=T10.PuestoId
LEFT JOIN SubCategorias AS T12 ON T12.SubCategoriaId=T10.SubCategoriaId
LEFT JOIN CoordinadoresEmpleados AS T13 ON T13.EmpleadoId=T1.EmpleadoId AND T13.FechaBaja='0000-00-00'
LEFT JOIN Empleados AS T14 ON T14.EmpleadoId=T13.CoordinadorId
LEFT JOIN (
            SELECT EmpleadoId, PuestoId, FechaAlta
            FROM HistorialPuestosEmpleados
            GROUP BY EmpleadoId, PuestoId
          ) AS T15 ON T15.EmpleadoId=T10.EmpleadoId AND T15.PuestoId=T10.PuestoId
LEFT JOIN (
            SELECT T1.EmpleadoId FROM
             (
              SELECT MAX(HistorialEmpleadoImss) AS HistorialEmpleadoImss, EmpleadoId
              FROM HistorialEmpleadosImss
              GROUP BY EmpleadoId
             ) AS T1
            INNER JOIN HistorialEmpleadosImss AS T2 ON T2.HistorialEmpleadoImss=T1.HistorialEmpleadoImss
            WHERE FechaSolicitud!='0000-00-00' AND Concepto='A'
          ) AS T16 ON T16.EmpleadoId=T1.EmpleadoId
LEFT JOIN ClasificacionPersonalVenta AS T17 ON T17.ClasificacionPersonalVentaId=T10.ClasificacionPersonalVentaId
LEFT JOIN CorreosEmpleados AS T18 ON T18.EmpleadoId=T1.EmpleadoId
WHERE OperadorId IS NOT NULL AND T3.PuntoventaId IN ($MisPuntos)
AND T1.EmpleadoId>1 AND T10.ClasificacionPersonalVentaId IN ($Venta)
GROUP BY T1.EmpleadoId
";
//echo $Q0;
return $this->Consulta($Q0);

}


function getPersonalInactivo()
{
	$MisPuntos=$this->getMisPuntos();
	$Venta=$this->getClasificacionVenta();

	$Q0="SELECT 'OperadorId', '%Pago', 'FechaPago',	'EmpleadoId', 'Region', 'SubRegion', 'Plaza',
				'PuntoVenta', 'Nombre',	'Nombre', 'Paterno', 'Materno',	'FechaIngreso',	'IngresoBase',
				'NumeroCuenta',	'Clabe', 'Banco', 'Puesto',	'SubCategoria',	'Canal', 'PeriodicidadPago',
				'EstatusIMSS', 'Estatus', 'Reporta', 'TotalPagar', 'Tipo', 'Comentario'
		UNION ALL
		SELECT T4.OperadorId,
       '' AS '%Pago',
       '' AS FechaPago,
       T1.EmpleadoId,
       Region,
       SubRegion,
       Plaza,
       PuntoVenta,
       CONCAT_WS(' ',T1.Nombre, T1.Paterno, T1.Materno) AS Nombre,
       T1.Nombre,
       T1.Paterno,
       T1.Materno,
       DATE_FORMAT(T1.UltimaFechaIngreso,'%d/%m/%Y') AS FechaIngreso,
       '' AS IngresoBase,
       CONCAT('\'',NoCuenta) AS NumeroCuenta,
       CONCAT('\'',Clabe) AS Clabe,
       Banco,
       Puesto,
       T12.SubCategoria,
       IF(T10.PuestoId=16, 'ORIGINACION', IF(T10.PuestoId=1,'VENTANILLA UNICA','')) AS Canal,
       '' AS PeriodicidadPago,
       '' AS EstatusIMSS,
       '' AS Estatus,
       CONCAT_WS(' ', T14.Nombre, T14.Paterno, T14.Materno) AS Reporta,
       '' AS TotalPagar,
       '' AS Tipo,
       '' AS Comentario
FROM Empleados AS T1
LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND FechaBaja!='0000-00-00' AND T2.Fisico=1
LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoventaId
LEFT JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
LEFT JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
LEFT JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
LEFT JOIN (
            SELECT MAX(HistorialDatosEmpleadoId) AS HistorialDatosEmpleadoId,
                   EmpleadoId
            FROM HistorialDatosEmpleados GROUP BY EmpleadoId
          ) AS T7 ON T7.EmpleadoId=T1.EmpleadoId
LEFT JOIN HistorialDatosEmpleados AS T8 ON T8.HistorialDatosEmpleadoId=T7.HistorialDatosEmpleadoId
LEFT JOIN Bancos AS T9 ON T9.BancoId=T8.BancoId
LEFT JOIN HistorialPuestosEmpleados AS T10 ON T10.EmpleadoId=T1.EmpleadoId AND T10.FechaBaja!='0000-00-00'
LEFT JOIN Puestos AS T11 ON T11.PuestoId=T10.PuestoId
LEFT JOIN SubCategorias AS T12 ON T12.SubCategoriaId=T10.SubCategoriaId
LEFT JOIN CoordinadoresEmpleados AS T13 ON T13.EmpleadoId=T1.EmpleadoId AND T13.FechaBaja!='0000-00-00'
LEFT JOIN Empleados AS T14 ON T14.EmpleadoId=T13.CoordinadorId
LEFT JOIN (
            SELECT EmpleadoId, PuestoId, FechaAlta
            FROM HistorialPuestosEmpleados
            GROUP BY EmpleadoId, PuestoId
          ) AS T15 ON T15.EmpleadoId=T10.EmpleadoId AND T15.PuestoId=T10.PuestoId
WHERE OperadorId IS NOT NULL AND T3.PuntoventaId IN ($MisPuntos) AND ClasificacionPersonalVenta IN ($Venta)
GROUP BY T1.EmpleadoId
";

return $this->Consulta($Q0);

}


function getInventarioVSO()
{
	$Q0="SELECT
			CONCAT(LPAD('106182',10,'0'),',') AS CustomId,
			CONCAT(LPAD(CONCAT(EquipoId,'0'),8,'0'),',') AS Item,
			CONCAT(LPAD(ClavePunto,10,'0'),',') AS Site,
			CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY),'%d/%m/%Y'),',') AS Fecha,
			CONCAT(SUM(Cantidad),',') AS Qty,
			CONCAT(0,',') AS Transito,
			0 AS Pendiente
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
			WHERE Cantidad>0 AND ClavePunto!='000' AND T3.Activo=1
			GROUP BY T2.PuntoVentaId, EquipoId
			";

	return $this->Consulta($Q0);
}

function getConsumosVSO()
{
	$Q0="UPDATE Inventario SET EnvioVSO=CURDATE() WHERE EnvioVSO='0000-00-00' AND Cantidad<0 AND Activacion!='0000-00-00'";

	$Q1="SELECT
		    CONCAT(LPAD('106182',10,'0'),',') AS CustomId,
			CONCAT(LPAD(CONCAT(T1.EquipoId,'0'),8,'0'),',') AS Item,
  			CONCAT(LPAD(ClavePunto,10,'0'),',') AS Site,
			CONCAT(DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY),'%d/%m/%Y'),',') AS Fecha,
			CONCAT(IFNULL(Venta,0),',') AS Qty,
			'SALE' AS Movimiento
		FROM Inventario AS T1
		LEFT JOIN HFolios AS T2 ON T2.MovimientoId=T1.MovimientoId
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
		LEFT JOIN (
		            SELECT EquipoId, PuntoVentaId, SUM(Cantidad) AS Venta FROM Inventario AS T1
		            INNER JOIN HFolios AS T2 ON T2.MovimientoId=T1.MovimientoId
		            WHERE EnvioVSO=CURDATE()
		            GROUP BY EquipoId, PuntoVentaId
		          ) AS T4 ON T4.EquipoId=T1.EquipoId AND T4.PuntoVentaId=T2.PuntoVentaId
		WHERE  ClavePunto!='000' AND T3.Activo=1
		GROUP BY T2.PuntoVentaId, T1.EquipoId";

			if($this->Consulta($Q0))
			return $this->Consulta($Q1);
		return false;
}


function getInventarioVSObyFecha($Fecha)
{
	$Q0="SELECT
			CONCAT(LPAD('106182',10,'0'),',') AS CustomId,
			CONCAT(LPAD(CONCAT(EquipoId,'0'),8,'0'),',') AS Item,
			CONCAT(LPAD(ClavePunto,10,'0'),',') AS Site,
			CONCAT(DATE_FORMAT(DATE_SUB('$Fecha', INTERVAL 0 DAY),'%d/%m/%Y'),',') AS Fecha,
			CONCAT(SUM(Cantidad),',') AS Qty,
			CONCAT(0,',') AS Transito,
			0 AS Pendiente
			FROM InventarioReportes AS T1
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
			WHERE Cantidad>0 AND ClavePunto!='000'
			GROUP BY T3.PuntoVentaId, EquipoId
			";

	return $this->Consulta($Q0);
}

function getConsumosVSObyFecha($Fecha)
{
	$Q0="UPDATE InventarioReportes SET EnvioVSO='$Fecha' WHERE EnvioVSO='0000-00-00' AND Cantidad<0 AND Activacion!='0000-00-00'";

	$Q1="SELECT
		    CONCAT(LPAD('106182',10,'0'),',') AS CustomId,
			CONCAT(LPAD(CONCAT(T1.EquipoId,'0'),8,'0'),',') AS Item,
  			CONCAT(LPAD(ClavePunto,10,'0'),',') AS Site,
			CONCAT(DATE_FORMAT(DATE_SUB('$Fecha', INTERVAL 1 DAY),'%d/%m/%Y'),',') AS Fecha,
			CONCAT(IFNULL(Venta,0),',') AS Qty,
			'SALE' AS Movimiento
		FROM InventarioReportes AS T1
		LEFT JOIN HFolios AS T2 ON T2.MovimientoId=T1.MovimientoId
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
		LEFT JOIN (
		            SELECT EquipoId, PuntoVentaId, SUM(Cantidad) AS Venta FROM InventarioReportes AS T1
		            INNER JOIN HFolios AS T2 ON T2.MovimientoId=T1.MovimientoId
		            WHERE EnvioVSO=$Fecha
		            GROUP BY EquipoId, PuntoVentaId
		          ) AS T4 ON T4.EquipoId=T1.EquipoId AND T4.PuntoVentaId=T2.PuntoVentaId
		WHERE  ClavePunto!='000'
		GROUP BY T2.PuntoVentaId, T1.EquipoId";

			if($this->Consulta($Q0))
			return $this->Consulta($Q1);
		return false;
}

function getChangeEstatus($Folio)
{
	$Q0="SELECT RegistroId, Plan, Equipo, Estatus, T1.EstatusId, T1.Comentario, T1.Contrato, T1.PlanId, Dn, T1.Serie, Seguro
FROM LFolios AS T1
LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
LEFT JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
LEFT JOIN Estatus AS T4 ON T4.EstatusId=T1.EstatusId
LEFT JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
WHERE Folio='$Folio'";
return $this->Consulta($Q0);
}

function getEstatusPosible($EstatusId, $RegistroId)
{
	$Q0="SELECT T2.EstatusId, T2.Estatus
		FROM EstatusPosibles AS T1
		LEFT JOIN Estatus AS T2 ON T2.EstatusId=T1.EstatusPosible
		WHERE T1.EstatusId=$EstatusId";
	$R0=$this->Consulta($Q0);

	$cad='
	<select name="EstatusId'.$RegistroId.'" id="EstatusId'.$RegistroId.'">
				<option value="0">Elige</option>
				';
				while($A0=mysql_fetch_row($R0))
				{
				$cad.= '<option value="'.$A0[0].'" title="'.$A0[1].'">'.utf8_decode($A0[1]).'</option> \n';
				}
	$cad.='</select>';

	return $cad;
}

function ActualizaEstatus($RegistroId, $EstatusId, $FechaEstatus, $Comentario, $Contrato, $DN)
{
	$FechaEstatus=$this->CambiarFormatoFecha($FechaEstatus);
	$this->StartTransaccion();
	if($EstatusId==14)
	{
	$Q0="UPDATE LFolios
		SET EstatusId=$EstatusId,
		FechaEstatus='$FechaEstatus',
		Contrato='$Contrato',
		Comentario='$Comentario',
		Dn='$DN'
		WHERE RegistroId=$RegistroId";

	$Q1="INSERT INTO Inventario
		SELECT T1.EquipoId, T1.Serie, IccId, -1 AS Cantidad, T3.MovimientoId, '$FechaEstatus', '0000-00-00', T2.AlmacenId, T2.PlataformaId
		FROM LFolios AS T1
		LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
		LEFT JOIN HFolios AS T3 ON T3.Folio=T1.Folio
		WHERE T1.RegistroId=$RegistroId
		LIMIT 1";

	$Q2="UPDATE Inventario AS T1
		INNER JOIN (
		            SELECT T1.Serie, 0 AS Cantidad
		            FROM LFolios AS T1
		            LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
		            WHERE T1.RegistroId=$RegistroId
		            LIMIT 1
		           ) AS T2 ON T2.Serie=T1.Serie
		SET T1.Cantidad=T2.Cantidad
		WHERE T1.Cantidad>0";


	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2) & $this->addBitacora(24, 5, $RegistroId, 'Cambio estatus', $EstatusId))
		{
			$this->AceptaTransaccion();
		return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
		}

	}
	else
	{
	$Q0="UPDATE LFolios
		SET EstatusId=$EstatusId,
		FechaEstatus='$FechaEstatus',
		Comentario='$Comentario',
		Contrato='$Contrato',
		DN='$DN'
		WHERE RegistroId=$RegistroId";

		if($this->Consulta($Q0)  & $this->addBitacoraFechaEstatus($RegistroId, $EstatusId, $FechaEstatus))
		{
			$this->AceptaTransaccion();
		return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
		}
	}
	$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡No fue posible realizar la actualizacion!</span>');

}

function addBitacoraFechaEstatus($ObjetoId, $Equipo, $Fecha)
{

	$Q0="INSERT INTO Bitacora
		 (BitacoraId, UsuarioId, Host, ModuloId, OperacionId, ObjetoId, Fecha, Hora, Comentario)
		 VALUES(NULL, $this->UsuarioId, '$Equipo', 24, 5, '$ObjetoId', '$Fecha', CURTIME(), 'Cambio estatus')";
	return $this->Consulta($Q0);
}

function getMiPuntoVentaFisico()
{
	/*
	$Q0="SELECT T1.PuntoVentaId, T3.PuntoVenta, T3.ClasificacionPersonalVenta
			FROM HistorialPuntosEmpleados AS T1
			LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoventaId=T1.PuntoVentaId
			WHERE Fisico=1 AND FechaBaja='0000-00-00' AND UsuarioId=$this->UsuarioId
			LIMIT 1";
	*/

	if(!isset($_COOKIE["MiPuntoVenta"]))
	$MiPv=0;
	else
	$MiPv=$_COOKIE["MiPuntoVenta"];


	$Q0="
	SELECT T1.PuntoventaId, T1.PuntoVenta, T1.ClasificacionPersonalVenta
		FROM PuntosVenta AS T1
		WHERE PUntoVentaId=$MiPv
	UNION
	SELECT T1.PuntoVentaId, T3.PuntoVenta, T3.ClasificacionPersonalVenta
		FROM HistorialPuntosEmpleados AS T1
		LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoventaId=T1.PuntoVentaId
		WHERE Fisico=1 AND FechaBaja='0000-00-00' AND UsuarioId=$this->UsuarioId
	LIMIT 1";

	return mysql_fetch_row($this->Consulta($Q0));
}

function getAddEquipo($Folio)
{
	$Q0="SELECT RegistroId, Plan, Equipo, Estatus, T1.EstatusId FROM LFolios AS T1
		 LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
		 LEFT JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
		 LEFT JOIN Estatus AS T4 ON T4.EstatusId=T1.EstatusId
		 WHERE Folio='$Folio'";

		 return $this->Consulta($Q0);
}

function validaSeriePunto($Serie, $PuntoVentaId)
{
	$Q0="SELECT Serie, Fecha, Equipo
	FROM (
			SELECT T1.EquipoId, T4.Fecha, T2.PuntoVentaId, T1.Serie
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=3
			LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Serie AND T3.Cantidad=0
			INNER JOIN Recepciones AS T4 ON T4.MovimientoId=T3.MovimientoId AND T4.TipoMovimientoId=1
			WHERE T1.Cantidad>0 AND T1.Serie='$Serie' AND T2.PuntoventaId = $PuntoVentaId
			UNION ALL
			SELECT EquipoId, T2.Fecha, T2.PuntoventaId , T1.Serie
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=1
			WHERE EquipoId IN(SELECT EquipoId FROM Inventario WHERE Serie='$Serie') AND T1.Cantidad>0 AND PuntoventaId =$PuntoVentaId
		) AS T1
	LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId
	ORDER BY Fecha ASC";

	$R0=$this->Consulta($Q0);
	$t=0;
	$FechaMin;
		while($A0=mysql_fetch_row($R0))
		{
			if($t==0)
			{
				$FechaMin=$A0[1];
			}
			if(($Serie==$A0[0] & $FechaMin==$A0[1]) || ($Serie==$A0[0] & $A0[2]=='TRIO SIMCARD V6.1 DISPLAY IUSA PREPAGO') || ($Serie==$A0[0] & $A0[2]=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO')  || ($Serie==$A0[0] & $A0[2]=='TRIO SIMCARD V6.1 DISPLAY UNEF PREPAGO') || ($Serie==$A0[0] & $A0[2]=='TRIO SIMCARD V6.1 DISPLAY IUSA') || ($Serie==$A0[0] & $A0[2]=='SIM CARD V8R TRIO DISPLAY ATT')  || ($Serie==$A0[0] & $A0[2]=='TRIO SIMCARD V6.1 DISPLAY UNEF') || ($Serie==$A0[0] & $A0[2]=='SIM CARD V8R TRIO DISPLAY UNEF') ||
			    ($Serie==$A0[0] & $A0[2]=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO'))
				return $A0[2];
			$t++;
		}
	return false;
}

function isDisponible($Serie)
{
	$Q0="SELECT COUNT(Serie) FROM Disponibles
		 WHERE Serie = '$Serie'
		";
	list($Cta)=mysql_fetch_row($this->Consulta($Q0));

	if($Cta>0)
		return false;
	return true;
}

function validaSerie($Serie, $Folio)
{

	$Q0="SELECT PlataformaId FROM HFolios
		 WHERE Folio = '$Folio'
		";

	list($PlataformaId)=mysql_fetch_row($this->Consulta($Q0));
	if(!$this->isDisponible($Serie))
		return false;
	$Q1="SELECT Equipo
	FROM Inventario AS T1
	LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId
	LEFT JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
	INNER JOIN PlataformasAlmacenes AS T4 ON T4.AlmacenId=T1.PlataformaId
	WHERE Serie='$Serie' AND Cantidad>0 AND MarcaId=13
	AND PuntoventaId IN (SELECT PuntoVentaId FROM HFolios WHERE Folio='$Folio')
	AND T1.AlmacenId IN (SELECT AlmacenId FROM PlataformasAlmacenes WHERE PlataformaId=$PlataformaId)
	UNION
	  SELECT Equipo
	  FROM Inventario AS T2
	  LEFT JOIN Recepciones AS T3 ON T3.MovimientoId=T2.MovimientoId
	  LEFT JOIN Equipos AS T4 ON T4.EquipoId=T2.EquipoId
	  WHERE Cantidad>0 AND PuntoventaId IN (SELECT PuntoVentaId FROM HFolios WHERE Folio='$Folio')
	  AND T2.Serie='$Serie'
	  AND T2.AlmacenId IN (SELECT AlmacenId FROM PlataformasAlmacenes WHERE PlataformaId=$PlataformaId)
	UNION
	  SELECT Equipo FROM SerieLibre AS T1
	  LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
	  LEFT JOIN Recepciones AS T3 ON T3.MovimientoId=T2.MovimientoId
	  LEFT JOIN Equipos AS T4 ON T4.EquipoId=T2.EquipoId
	  WHERE Cantidad>0 AND PuntoventaId IN (SELECT PuntoVentaId FROM HFolios WHERE Folio='$Folio')
	  AND T1.Serie='$Serie'
	  AND T2.AlmacenId IN (SELECT AlmacenId FROM PlataformasAlmacenes WHERE PlataformaId=$PlataformaId)
	  LIMIT 1
	  ";


	list($Equipo)=mysql_fetch_row($this->Consulta($Q1));

	if(isset($Equipo))
		return $Equipo;


	$Q0="SELECT Serie, Fecha, Equipo
	FROM (
			SELECT T1.EquipoId, T4.Fecha, T2.PuntoVentaId, T1.Serie, T1.PlataformaId
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=3
			LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Serie AND T3.Cantidad=0
			INNER JOIN Recepciones AS T4 ON T4.MovimientoId=T3.MovimientoId AND T4.TipoMovimientoId=1
			WHERE T1.Cantidad>0 AND T1.Serie='$Serie' AND T2.PuntoventaId IN (SELECT PuntoVentaId FROM HFolios WHERE Folio='$Folio')
			UNION ALL
			SELECT EquipoId, T2.Fecha, T2.PuntoventaId , T1.Serie, T1.PlataformaId
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=1
			WHERE EquipoId IN(SELECT EquipoId FROM Inventario WHERE Serie='$Serie') AND T1.Cantidad>0 AND PuntoventaId IN (SELECT PuntoVentaId FROM HFolios WHERE Folio='$Folio')
		) AS T1
	LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId AND T1.PlataformaId=$PlataformaId
	ORDER BY Fecha ASC";

	$R0=$this->Consulta($Q0);
	$t=0;
	$FechaMin;

		while($A0=mysql_fetch_row($R0))
		{
			if($t==0)
			{
				$FechaMin=$A0[1];
			}

			if($Serie==$A0[0] & $FechaMin==$A0[1])
				return $A0[2];

			$t++;
		}


	return false;
}

function addLineaOr($Serie, $Folio)
{
	$Equipo=$this->validaSerie($Serie, $Folio);

	if($Equipo)
	return utf8_decode($Equipo);

		return utf8_decode('<span class="alerta">¡Articulo elegido No Valido!</span>');
}

function altaLineaOrg($Serie, $Clave, $PlanId, $TipoPlanId, $AddOn, $Servicios, $PlazoId, $Movimiento, $Diferencial, $TipoPagoDiferencial, $SeguroId, $codigo_sim)
	{
		$sql="SELECT E.MarcaId AS MarcaId FROM Inventario AS I  INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Serie='$Serie'";
		$Query=mysql_query("$sql", $this->conexion) or die("Error al Consultar: $sql ".mysql_error());
		$resultadoMarca=mysql_fetch_array($Query);
		$MarcaId=$resultadoMarca["MarcaId"];
		$cont=0;
		if($MarcaId==13){
			$cont=1;
		}

		$Q0="INSERT INTO TLineas
                   SELECT NULL, '$Movimiento', EquipoId, $PlanId, $TipoPlanId, $PlazoId, '', '', $Diferencial, $TipoPagoDiferencial, '', $SeguroId
                   FROM Inventario WHERE Serie='$Serie' LIMIT 1";

		$this->StartTransaccion();
		if($this->Consulta($Q0))
		{
		$RegistroId=mysql_insert_id();

		$Q1="INSERT IGNORE INTO TLineasAddon
			 SELECT $RegistroId, AddonId FROM Addon WHERE AddonId IN ($AddOn)";

		$Q1="INSERT IGNORE INTO LineasAddon
			 SELECT $RegistroId, AddonId,0 FROM Addon WHERE AddonId IN ($AddOn)";

		$Q2="INSERT IGNORE INTO TLineasServicios
			 SELECT $RegistroId, ServicioAdicionalId FROM ServiciosAdicionales WHERE ServicioAdicionalId IN ($Servicios)";

		$Q3="INSERT INTO LFolios
			 SELECT T1.RegistroId, '$Clave', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 12,
			 CostoPlan+IFNULL(SUM(CostoAddOn),0) AS Costo, 0 AS RentaSI, 'x', CURDATE(), '$Serie', '', Dn, Diferencial, TipoPagoDiferencial, SeguroId
			 FROM TLineas AS T1
 	   		 LEFT JOIN LineasAddon AS T2 ON T2.RegistroId=T1.RegistroId
		     LEFT JOIN PreciosPlanes AS T3 ON T3.PlanId=T1.PlanId AND T3.AddOnId=IFNULL(T2.AddOnId,0)
			 WHERE T1.Registroid=$RegistroId";
		$Q4="INSERT IGNORE INTO Disponibles (Serie) VALUES('$Serie')";

		if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4))
			{
				$this->AceptaTransaccion();
				if($codigo_sim!='0' && $PlanId!=81  && $PlanId!=282  && $PlanId!=283  && $PlanId!=284  && $PlanId!=285  && $PlanId!=286  && $PlanId!=287 && $PlanId!=288  && $PlanId!=314  && $PlanId!=315  && $PlanId!=328  && $PlanId!=329  && $PlanId!=330  && $PlanId!=331  && $PlanId!=332  && $PlanId!=333  && $PlanId!=334  && $PlanId!=335  && $PlanId!=336  && $PlanId!=337  && $PlanId!=278  && $PlanId!=279  && $PlanId!=280  && $PlanId!=281  && $PlanId!=312  && $PlanId!=365  && $PlanId!=289  && $PlanId!=290  && $PlanId!=291  && $PlanId!=292 && $PlanId!=313 && $cont!=1)
					$this->altaLineaOrg($codigo_sim, $Clave, 81, 3, 0, 0, $PlazoId, $Movimiento, 0, 0, 4, 0);
				return 'ok';
			}
		}
			$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}

function altaFolioOr($Folio,$FechaActivacion, $PuntoVentaId, $VendedorId, $CoordinadorId, $ClienteId,
        $TipoContratacionId, $TipoPagoId, $Comentarios='', $Clave, $ContratacionId, $TipoVentaId, $PlataformaId)
{

	$FechaActivacion=$this->CambiarFormatoFecha($FechaActivacion);

	if($this->Existe('Folio',$Folio,'HFolios'))
		return utf8_decode('<span class="alerta">¡Este Folio ya existe!</span>');
	$this->StartTransaccion();
	$Q0="INSERT INTO Movimientos (MovimientoId) VALUES(NULL)";


	if($this->Consulta($Q0))
	{
		$MovimientoId=mysql_insert_id();
	$Q1="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, ContratacionId, Validado, TipoVentaId, PlataformaId)
					 VALUES(UCASE('$Folio'), CURDATE(), CURDATE(), '$FechaActivacion', $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, $ClienteId,
        					$TipoContratacionId, $TipoPagoId, '$Comentarios', '$Clave',$MovimientoId, 1,0, 0, $TipoVentaId, $PlataformaId)";

	if($this->Consulta($Q1) & $this->addBitacora(24, 2, 0, $Folio,''))
			{
				$this->AceptaTransaccion();
				return 'OK';
			}
	}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');

}

function addRecepcion($PuntoVentaId, $ClaveRecepcion, $Comentario, $Clave, $ModuloId, $file)
{
	if($Clave==$this->ClaveLast)
		return 'FAIL';

	$this->ClaveLast=$Clave;

	$Q0="INSERT INTO Movimientos VALUES(NULL)";
	$QA="SELECT COUNT(Factura), IFNULL(FECHA,CURDATE()) AS Fecha FROM FacturasEquipos WHERE Factura='$ClaveRecepcion'";
	list($Cta, $FechaFactura)=mysql_fetch_row($this->Consulta($QA));
	$this->StartTransaccion();
	if($this->Consulta($Q0))
	{
		$MovimientoId=mysql_insert_id();
		$Q1="INSERT INTO Recepciones (MovimientoId, TipoMovimientoId, UsuarioId, PuntoventaId, ClaveRecepcion, Fecha, Hora, Comentario, Clave, FechaMovimiento, HoraMovimiento, ConceptoTRId)
		VALUES($MovimientoId, 1, $this->UsuarioId, $PuntoVentaId, '$ClaveRecepcion', '$FechaFactura', CURTIME(), '$Comentario', '$Clave', CURDATE(), CURTIME(), 0)";

		$Q2="INSERT IGNORE INTO Inventario (EquipoId, serie, IccId, Cantidad, MovimientoId, Activacion, EnvioVSO, AlmacenId, PlataformaId)
			 SELECT EquipoId, Serie, '', 1, $MovimientoId, '0000-00-00', '0000-00-00', AlmacenId, PlataformaId
			 FROM Lectura
			 WHERE Clave=$Clave";

			 if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->addBitacora(23, 2, 0, $MovimientoId,''))
			 {
			 	if ($ModuloId==46)
			 	{
	 				$Q3="UPDATE OrdenesCompra AS T1
					 INNER JOIN Lectura AS T2 ON T2.Serie=T1.Serie AND T2.Clave='$Clave'
					 SET Recibido=1, MovimientoId=$MovimientoId
					 WHERE T1.Factura='$ClaveRecepcion'";

					 $Q4="UPDATE FacturasEquipos SET Archivo='$file' WHERE Factura='$ClaveRecepcion'";
					 if($this->Consulta($Q3) & $this->Consulta($Q4))
					 {
					 	$this->AceptaTransaccion();
			 			return 'OK';
					 }
					$this->CancelaTransaccion();
					return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
			 	}
			 	$this->AceptaTransaccion();
			 	return 'OK';
			 }
	}
	$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');

}

function addLectura($Serie, $Clave, $EquipoId, $AlmacenId, $PlataformaId)
{
	$Q0="INSERT INTO Lectura (Serie, Clave, EquipoId, RegistroId, AlmacenId, PlataformaId)
		 VALUES ('$Serie', '$Clave', $EquipoId, NULL, $AlmacenId, $PlataformaId)";
	$this->Consulta($Q0);

	return $this->getListaLectura($Clave);
}

function addLecturaTExpress($Serie, $Clave)
{

	$this->StartTransaccion();
	$Q0="INSERT IGNORE INTO Disponibles (Serie) VALUES('$Serie')";
	$Q1="INSERT INTO TRLectura (Serie, Clave, RegistroId)
		 VALUES ('$Serie', '$Clave', NULL)";

	if($this->Consulta($Q0) & $this->Consulta($Q1))
	{
		$this->AceptaTransaccion();
	}
	else
		$this->CancelaTransaccion();

	return $this->getListaLecturaTExpress($Clave);
}



function removeTRLectura($RegistroId, $Clave)
{
	$Q0="SELECT Serie FROM TRLectura WHERE RegistroId=$RegistroId";
	list($Serie)=mysql_fetch_row($this->Consulta($Q0));

	$Q1="DELETE FROM Disponibles WHERE Serie='$Serie'";
	$Q2="DELETE FROM TRLectura WHERE RegistroId='$RegistroId'";

	$this->Consulta($Q1);
	$this->Consulta($Q2);

	return $this->getListaLecturaTExpress($Clave);
}

function removeLectura($RegistroId, $Clave)
{
	$Q0="DELETE FROM Lectura WHERE RegistroId='$RegistroId'";
	$this->Consulta($Q0);
	return $this->getListaLectura($Clave);
}

function getListaLectura($Clave)
	{	$Cta=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Serie</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T2.Equipo, T1.Serie, T1.RegistroId FROM Lectura AS T1
				LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId
				WHERE Clave='$Clave'
				ORDER BY RegistroId DESC
			  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[2].','.$Clave.',2)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(Clave) AS Cta FROM Lectura WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}

function getListaLecturaTExpress($Clave)
	{	$Cta=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Serie</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T3.Equipo, T1.Serie, T1.RegistroId FROM TRLectura AS T1
				LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
				LEFT JOIN Equipos AS T3 ON T3.EquipoId=T2.EquipoId
				WHERE Clave='$Clave'
				GROUP BY RegistroId
				ORDER BY RegistroId DESC
			  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[2].','.$Clave.',3)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(Clave) AS Cta FROM TRLectura WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}


function existeSerie($Serie)
{
	$Q0="SELECT SUM(Cta) FROM (
			SELECT COUNT(EquipoId) AS Cta FROM Inventario WHERE Serie='$Serie'
			UNION ALL
			SELECT COUNT(EquipoId) AS Cta FROM Lectura WHERE Serie='$Serie'
			) AS T1
		";
	list($Cta)=mysql_fetch_row($this->Consulta($Q0));

	if($Cta>0)
		return 'Existe';
	return 'Recibe';
}

function InventarioPuntos()
{
	$Venta=$this->getClasificacionVenta();

list($PuntoVentaId, $Corporativo)=$this->getPuntoVentaFisico();

	$MisPuntos=$this->getMisPuntos();

if($Corporativo==1)
	$Filtro='TRUE';
else
//	$Filtro='T3.PuntoVentaId='.$PuntoVentaId;
	$Filtro='T6.PuntoVentaId IN ('.$MisPuntos.')';

	$Q0="SELECT
		'Canal Operativo',
		'Fecha',
		'Region',
		'Sub-Region',
		'Sucursal',
		'Clasificacion',
		'Tipo de Punto',
		'Estatus',
		'Punto_Venta',
		'Factura',
		'SKU',
		'Marca',
		'Equipo',
		'Serie',
		'SIM',
		'Cantidad',
		'Costo',
		'Precio',
		'Fecha vencimiento',
		'AÑO VENCIMIENTO',
		'MES VENCIMIENTO',
		'DIA VENCIMIENTO',
		'SEMANA', 'ALMACEN', 'PLATAFORMA'
		UNION
SELECT T7.ClasificacionPersonalVenta,
       DATE_FORMAT(FechaFactura,'%d/%m/%Y') AS FechaFactura,
   Region,
        SubRegion,
        Plaza,
        IF(T12.MarcaId=13, 'SIM', 'EQUIPO'),
        IF(T6.SubDistribuidorId=1,'SUB', 'PROPIO'),
        IF(Recibido=0, 'POR RECIBIR',IF((T3.MovimientoId OR T4.MovimientoId) IS NOT NULL,IF(T4.TipoMovimientoId=15,'DEMOS','ALMACEN'), IF(T5.MovimientoId IS NOT NULL,'TRANSITO',''))) AS estatus,
        PuntoVenta,
        Factura,
      	T2.EquipoId,
        Marca,
        Equipo,
        CONCAT('\'',T2.Serie),
        CONCAT('\'',T2.Sim),
        1 AS Cantidad,
        Costo,
        Costo*1.16 AS Precio,
        DATE_FORMAT(DATE_ADD(FechaFactura, INTERVAL 60 DAY),'%d/%m/%Y') AS FechaVencimiento,
        DATE_FORMAT(DATE_ADD(FechaFactura, INTERVAL 60 DAY), '%Y') AS AñoVencimiento,
	      CASE DATE_FORMAT(DATE_ADD(FechaFactura, INTERVAL 60 DAY),'%m')
	       WHEN '01' THEN 'ENE'
	       WHEN '02' THEN 'FEB'
	       WHEN '03' THEN 'MAR'
	       WHEN '04' THEN 'ABR'
	       WHEN '05' THEN 'MAY'
	       WHEN '06' THEN 'JUN'
	       WHEN '07' THEN 'JUL'
	       WHEN '08' THEN 'AGO'
	       WHEN '09' THEN 'SEP'
	       WHEN '10' THEN 'OCT'
	       WHEN '11' THEN 'NOV'
	       WHEN '12' THEN 'DIC'
       END AS MesVencimiento,
       DATE_FORMAT(DATE_ADD(FechaFactura, INTERVAL 60 DAY), '%d') AS DiaVencimiento,
       WEEK(DATE_ADD(FechaFactura, INTERVAL 60 DAY)) AS Semana,
       T13.Almacen, T14.Plataforma
FROM OrdenesCompra AS T2
LEFT JOIN Inventario AS T1 ON T1.Serie=T2.Serie AND T1.Cantidad>0
LEFT JOIN AjustesPositivos AS T3 ON T3.MovimientoId=T1.MovimientoId
LEFT JOIN Recepciones AS T4 ON T4.MovimientoId=T1.MovimientoId
LEFT JOIN TRSalidas AS T5 ON T5.MovimientoId=T1.MovimientoId
LEFT JOIN PuntosVenta AS T6 ON T6.PuntoVentaId = IFNULL(T3.PuntoVentaId,IFNULL(T4.PuntoVentaId, IFNULL(T5.PuntoVentaIdO,T2.PuntoVentaId)))
LEFT JOIN ClasificacionPersonalVenta AS T7 ON T7.ClasificacionPersonalVentaId=T6.ClasificacionpersonalVenta
LEFT JOIN Plazas AS T8 ON T8.PlazaId=T6.PlazaId
LEFT JOIN SubRegiones AS T9 ON T9.SubRegionId=T8.SubRegionId
LEFT JOIN Regiones AS T10 ON T10.RegionId=T9.RegionId
LEFT JOIN Equipos AS T11 ON T11.EquipoId=T2.EquipoId
LEFT JOIN Marcas AS T12 ON T12.MarcaId=T11.MarcaId
LEFT JOIN Almacenes AS T13 ON T13.AlmacenId=T2.AlmacenId
LEFT JOIN Plataformas AS T14 ON T14.PlataformaId=T2.PlataformaId
WHERE (Recibido=1 AND Cantidad IS NOT NULL) OR Recibido=0
AND T6.ClasificacionPersonalVenta IN ($Venta) AND $Filtro
";
return $this->Consulta($Q0);

}

function PuntosVentaActivos()
{
	$Venta=$this->getClasificacionVenta();

	$Q0="SELECT 'CanalOperativo', '#PuntoVenta', 'Region', 'SubRegion', 'Plaza', 'PuntoVenta', 'IdStore', 'ABC'
	UNION ALL
	SELECT T5.ClasificacionPersonalVenta, T1.PuntoVentaId, Region, SubRegion, Plaza, PuntoVenta, ClavePunto, ABC FROM PuntosVenta AS T1
	LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
	LEFT JOIN SubRegiones AS T3 ON T3.SubRegionId=T2.SubRegionId
	LEFT JOIN Regiones AS T4 ON T4.RegionId=T3.RegionId
	LEFT JOIN ClasificacionPersonalVenta AS T5 ON T5.ClasificacionPersonalVentaId=T1.ClasificacionpersonalVenta
	WHERE T1.Activo=1 AND T1.ClasificacionPersonalVenta IN ($Venta)
	";

	return $this->Consulta($Q0);
}

function getOriginacion()
{
	$Venta=$this->getClasificacionVenta();
	$MisPuntos=$this->getMisPuntos();

$Q0="SELECT 'Canal de Venta',
    'Año',  'Mes', 'Contrato', 'Region', 'SubRegion',  'Plaza',  'PuntoVenta SIIGA','PuntoVenta AT&T', 'FechaIngreso', 'Folio',
    'Fecha Activacion','Coordinador',  'Ejecutivo',
    'Categoria',  'SubCategoria', 'Cliente',  'TipoPersona', 'RFC',
    'TipoPago', 'Marca',  'Equipo','OrigenDeEquipo','TipoDeLinea','Plan', 'PlanBum',  'RentaPlan',  'RentaSIVA',
    'RentaSImpuesto', 'Plazo',  'Estatus',  'Comentario', 'FechaEntrega', 'FechaFacturado', 'AñoEntrega', 'MesEntrega',
    'AñoFacturacion', 'MesFacturacion', 'Unidades', 'SemanaPago', 'SemanaBUM',
    'Evento', 'Familia',  'ClavePlan', 'Tipo Contratacion', 'Fecha de Ingreso SVU', 'MEID/IMEID', 'RegistroId', 'TipoPunto', 'DN', 'AddOns','Seguro', 'Tipo de Venta', 'Plataforma'
    UNION ALL
    SELECT T17.ClasificacionPersonalVenta,
DATE_FORMAT(T0.Fecha, '%Y') AS Año,
CASE DATE_FORMAT(T0.Fecha,'%m')
       WHEN '01' THEN 'ENERO'
       WHEN '02' THEN 'FEBRERO'
       WHEN '03' THEN 'MARZO'
       WHEN '04' THEN 'ABRIL'
       WHEN '05' THEN 'MAYO'
       WHEN '06' THEN 'JUNIO'
       WHEN '07' THEN 'JULIO'
       WHEN '08' THEN 'AGOSTO'
       WHEN '09' THEN 'SEPTIEMBRE'
       WHEN '10' THEN 'OCTUBRE'
       WHEN '11' THEN 'NOVIEMBRE'
       WHEN '12' THEN 'DICIEMBRE'
       END AS Mes,
Contrato,
IF(T10.EmpleadoId IN (778, 789),'CORPORATIVO',Region),
IF(T10.EmpleadoId IN (778, 789),'CORPORATIVO',SubRegion),
IF(T10.EmpleadoId IN (778, 789),'CORPORATIVO',Plaza),
IF(T10.EmpleadoId IN (778, 789),'CORPORATIVO',PuntoVenta),
NombreATT,
DATE_FORMAT(T0.Fecha, '%d/%m/%Y'),
CONCAT('\'',T1.Folio),
DATE_FORMAT(T1.FechaSS, '%d/%m/%Y') AS Año,
CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
Puesto AS Categoria,
IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
TipoPersona,
T11.Rfc,
TipoPago,
Marca,
Equipo,
Origen,
Raiz,
Plan,
PlanBum,
RentaPlan,
RentaSIVA,
RentaSImpuesto,
Plazo,
Estatus,
UCASE(T14.Comentario) AS Comentario,
DATE_FORMAT(T0.Fecha,'%d/%m/%Y'),
DATE_FORMAT(T0.Fecha,'%d/%m/%Y'),
DATE_FORMAT(T0.Fecha, '%Y') AS Año,
CASE DATE_FORMAT(T0.Fecha,'%m')
       WHEN '01' THEN 'ENERO'
       WHEN '02' THEN 'FEBRERO'
       WHEN '03' THEN 'MARZO'
       WHEN '04' THEN 'ABRIL'
       WHEN '05' THEN 'MAYO'
       WHEN '06' THEN 'JUNIO'
       WHEN '07' THEN 'JULIO'
       WHEN '08' THEN 'AGOSTO'
       WHEN '09' THEN 'SEPTIEMBRE'
       WHEN '10' THEN 'OCTUBRE'
       WHEN '11' THEN 'NOVIEMBRE'
       WHEN '12' THEN 'DICIEMBRE'
       END AS Mes,
DATE_FORMAT(T0.Fecha, '%Y') AS Año,
CASE DATE_FORMAT(T0.Fecha,'%m')
       WHEN '01' THEN 'ENERO'
       WHEN '02' THEN 'FEBRERO'
       WHEN '03' THEN 'MARZO'
       WHEN '04' THEN 'ABRIL'
       WHEN '05' THEN 'MAYO'
       WHEN '06' THEN 'JUNIO'
       WHEN '07' THEN 'JULIO'
       WHEN '08' THEN 'AGOSTO'
       WHEN '09' THEN 'SEPTIEMBRE'
       WHEN '10' THEN 'OCTUBRE'
       WHEN '11' THEN 'NOVIEMBRE'
       WHEN '12' THEN 'DICIEMBRE'
       END AS Mes,
	1 AS Unidades,
  CONCAT('Sem ',IF(WEEK(T0.Fecha,1)>52,1,WEEK(T0.Fecha,1))) AS SemanaPago,
  CONCAT('Sem ',IF(WEEK(T0.Fecha,1)>52,1,WEEK(T0.Fecha,1))) AS SemanaBUM,
  IF(MarcaId=13 AND PlanId=81, 'SIM', IF(PlanId=81, 'VTA DE EQUIPO',IF(T1.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION'))) AS Evento,
Familia,
ClavePlan,
TipoContratacion,
DATE_FORMAT(FechaSS,'%d/%m/%Y'),
CONCAT('\'',T14.Serie),
T14.RegistroId,
TipoPunto, Dn, T18.AddOn,Seguro,IF(T1.TipoVentaId=1,'Prepago', 'Pospago'),
T19.Plataforma
FROM HFolios AS T1
LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
LEFT JOIN PuntosATT AS TATT ON T2.PuntoVentaId=TATT.PuntoVentaId
LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
LEFT JOIN (
            SELECT
                  T1.Folio,
                  T1.RegistroId,
                  Familia,
                  Marca,
                  Equipo,
                  Serie,
                  T2.Clave AS ClavePlan,
                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
                  T2.Plan,
                  Costo AS RentaPlan,
                  Costo/1.16 AS RentaSIVA,
                  Costo/1.16/1.03 AS RentaSImpuesto,
                  Plazo,
                  Estatus,
                  Comentario,
                  Contrato,
                  T9.MarcaId,
                  T1.PlanId,
                  T1.Dn,
                  Seguro,
                  IF(T13.Raiz='Ancla','Compartelo Incluido',IF(T13.Raiz='Popote','Compartelo Adicional',IF(T1.PlanId=367 OR T1.PlanId=368,'Internet En Casa','MIX'))) AS Raiz,
                  IF(T10.MarcaId!=13,'Con Equipo','Sin Equipo') AS Origen
            FROM LFolios AS T1
            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
            LEFT JOIN (
                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn
                        FROM LineasAddon AS T1
                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
                        GROUP BY RegistroId
                      ) AS T3 ON T3.RegistroId=T1.RegistroId
            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
            LEFT JOIN Marcas AS T10 ON T10.MarcaId=T9.MarcaId
	    	INNER JOIN HFolios AS T11 ON T11.Folio=T1.Folio
	    	LEFT JOIN Seguros AS T12 ON T12.SeguroId=T1.SeguroId
	    	LEFT JOIN LineaTemporalOpc1 AS T13 ON (T13.Imei=T1.Serie OR T13.ImeiSim=T1.Serie)
	    WHERE EnReporte=1 AND MovimientoId!=0 AND T1.PlanId!=81 AND T1.PlanId!=255
          ) AS T14 ON T14.Folio=T1.Folio
LEFT JOIN TiposContratacion AS T15 ON T15.TipoContratacionId=T1.TipoContratacionId
LEFT JOIN Bitacora AS T0 ON T0.ObjetoId=T14.RegistroId
LEFT JOIN TipoPuntos AS T16 ON T16.TipoPuntoId=T2.TipoPuntoId
LEFT JOIN ClasificacionPersonalVenta AS T17 ON T17.ClasificacionPersonalVentaId=T2.ClasificacionpersonalVenta
LEFT JOIN (SELECT RegistroId, GROUP_CONCAT(AddOn ORDER BY Addon SEPARATOR ' - ') AS AddOn FROM LineasAddon AS T1
		   INNER JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
		   GROUP BY RegistroId
		   ) AS T18 ON T18.RegistroId=T14.RegistroId
LEFT JOIN Plataformas AS T19 ON T19.PlataformaId=T1.PlataformaId
WHERE T1.MovimientoId!=T1.Folio AND T1.MovimientoId>0 AND T0.Host='14' AND EnReporte=1
AND T2.ClasificacionPersonalVenta IN ($Venta)
AND T2.PuntoventaId IN ($MisPuntos)
GROUP BY T14.RegistroId";

return $this->Consulta($Q0);
}

function getOriginacionMC()
{
$Venta=$this->getClasificacionVenta();

if($this->isCorporativo())
$PuntoVentaId=$this->getMisPuntos();
else
list($PuntoVentaId)=$this->getMiPuntoVentaFisico();

	$Q0="SELECT
    'Contrato', 'PuntoVenta', 'Folio',
    'Coordinador',  'Ejecutivo',
    'Categoria',  'SubCategoria', 'Cliente',  'RFC',
    'TipoPago', 'Equipo', 'PlanBum',  'RentaPlan',
    'RentaSImpuesto', 'Plazo',  'Estatus',  'FechaEntrega',
    'Evento', 'Familia','Tipo Contratacion', 'MEID/IMEID', 'RegistroId','Plataforma'
    UNION ALL
    SELECT
Contrato,
IF(T10.EmpleadoId=778,'CORPORATIVO',PuntoVenta),
CONCAT('\'',T1.Folio),
CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
Puesto AS Categoria,
IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
T11.Rfc,
TipoPago,
Equipo,
PlanBum,
RentaPlan,
RentaSImpuesto,
Plazo,
Estatus,
DATE_FORMAT(T0.Fecha,'%d/%m/%Y'),
IF(T1.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento,
Familia,
TipoContratacion,
CONCAT('\'',T14.Serie),
T14.RegistroId,
Plataforma
FROM HFolios AS T1
LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
LEFT JOIN (
            SELECT
                  Folio,
                  T1.RegistroId,
                  Familia,
                  Equipo,
                  Serie,
                  T2.Clave AS ClavePlan,
                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
                  Costo AS RentaPlan,
                  Costo/1.16/1.03 AS RentaSImpuesto,
                  Plazo,
                  Estatus,
                  Comentario,
                  Contrato
            FROM LFolios AS T1
            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
            LEFT JOIN (
                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn
                        FROM LineasAddon AS T1
                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
                        GROUP BY RegistroId
                      ) AS T3 ON T3.RegistroId=T1.RegistroId
            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
          ) AS T14 ON T14.Folio=T1.Folio
LEFT JOIN TiposContratacion AS T15 ON T15.TipoContratacionId=T1.TipoContratacionId
LEFT JOIN Bitacora AS T0 ON T0.ObjetoId=T14.RegistroId
LEFT JOIN Plataformas AS T16 ON T1.PlataformaId=T16.PlataformaId
WHERE T1.MovimientoId!=T1.Folio AND T1.MovimientoId>0 AND T0.Host='14' AND T1.PuntoventaId IN ($PuntoVentaId) AND EnReporte=1
AND ClasificacionPersonalVenta IN ($Venta)
GROUP BY T14.RegistroId
";

return $this->Consulta($Q0);

}


function getListaPuntosTraspasos()
	{
$Venta=$this->getClasificacionVenta();


		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>#PuntoVenta</th>
							<th>Region</th>
							<th>SunRegion</th>
							<th>Plaza</th>
							<th>Punto de Venta</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.PuntoVentaId, Region, SubRegion, Plaza, PuntoVenta
			  FROM PuntosVenta AS T1
			  LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
			  LEFT JOIN SubRegiones AS T3 ON T3.SubRegionId=T2.SubRegionId
			  LEFT JOIN Regiones AS T4 ON T4.RegionId=T3.RegionId
			  WHERE T1.Activo=1 AND ClasificacionPersonalVenta IN ($Venta)
			  ORDER BY PuntoVenta ASC
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,7)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function existeSerieTraspaso($Serie, $PuntoVentaIdO)
{
	if(!$this->isDisponible($Serie))
		return 'Disponible';

	$Q0="SELECT IFNULL(SUM(Cantidad),0) FROM Inventario AS T1
		LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId
		WHERE Serie = '$Serie' AND Cantidad>0 AND PuntoVentaId=$PuntoVentaIdO
		";

	list($Cta)=mysql_fetch_row($this->Consulta($Q0));

	if($Cta>0)
		return 'TExpress';
	return 'NoExiste';
}

function addTExpress($PuntoVentaIdO, $PuntoVentaIdD, $Comentario, $Clave)
{
	$Q0="INSERT INTO Movimientos VALUES(NULL)";
	$this->StartTransaccion();

	if($this->Consulta($Q0))
	{

		$MovimientoId=mysql_insert_id();
		$Q1="INSERT INTO TRSalidas (MovimientoId, UsuarioId, PuntoVentaIdO, PuntoVentaIdD, Fecha, Hora, Comentario, EstatusTraspasoId)
			VALUES($MovimientoId, $this->UsuarioId, $PuntoVentaIdO, $PuntoVentaIdD, CURDATE(), CURTIME(), '$Comentario', 2)";
		$Q2="UPDATE Inventario AS T1
			INNER JOIN TRLectura AS T2 ON T2.Serie=T1.Serie AND T2.Clave='$Clave'
			SET T1.Cantidad=0
			WHERE T1.Cantidad>0";

		$Q3="INSERT IGNORE INTO Inventario (EquipoId, serie, IccId, Cantidad, MovimientoId, Activacion, EnvioVSO, AlmacenId, PlataformaId)
			 SELECT T2.EquipoId, T2.Serie, T2.IccId, -1, '$MovimientoId', '0000-00-00', '0000-00-00', T2.AlmacenId, T2.PlataformaId
			 FROM TRLectura AS T1
			 LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			 WHERE T1.Clave='$Clave'
			 GROUP BY T1.Serie";

		$Q4="SELECT GROUP_CONCAT(Serie) FROM TRLectura WHERE Clave='$Clave'";
			list($Series)=mysql_fetch_row($this->Consulta($Q4));

		$Q5="DELETE FROM Disponibles WHERE Serie IN ('$Series')";

		$Q6="INSERT INTO Movimientos VALUES(NULL)";
		$this->Consulta($Q6);
		$MovimientoIdR=mysql_insert_id();

		$Q7="INSERT INTO Recepciones (MovimientoId, TipoMovimientoId, UsuarioId, PuntoventaId, ClaveRecepcion, Fecha, Hora, Comentario, Clave, FechaMovimiento, HoraMovimiento, ConceptoTRId)
		VALUES($MovimientoIdR, 3, $this->UsuarioId, $PuntoVentaIdD, '$MovimientoId', CURDATE(), CURTIME(), '$Comentario', '$Clave', CURDATE(), CURTIME(),0)";

		$Q8="INSERT IGNORE INTO Inventario (EquipoId, serie, IccId, Cantidad, MovimientoId, Activacion, EnvioVSO, AlmacenId, PlataformaId)
			 SELECT T2.EquipoId, T2.Serie, T2.IccId, 1, '$MovimientoIdR', '0000-00-00', '0000-00-00', T2.AlmacenId, T2.PlataformaId
			 FROM TRLectura AS T1
			 LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			 WHERE T1.Clave='$Clave'
			 GROUP BY T1.Serie";

			 if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q5) & $this->Consulta($Q7) & $this->Consulta($Q8) & $this->addBitacora(30, 2, 0, $MovimientoId,''))
			 {
			 	$this->AceptaTransaccion();
			 	return 'OK';
			 }
	}
	$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible realizar el traspaso!</span>');

}

function getBuscaArticulo($Serie)
	{

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>#Movimiento</th>
							<th>Tipo Movimiento</th>
							<th>Fecha</th>
							<th>Puntoventa</th>
							<th>Serie</th>
							<th>Equipo</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.MovimientoId, TipoMovimiento, Fecha, PuntoVenta, Serie, Equipo, T4.PuntoVentaId FROM
				Inventario AS T1
				INNER JOIN (
				            SELECT T1.MovimientoId, T2.TipoMovimiento, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, PuntoVentaId FROM Recepciones AS T1
				            LEFT JOIN TiposMovimientos AS T2 ON T2.TipoMovimientoId=T1.TipoMovimientoId
				            UNION
				            SELECT MovimientoId, 'Traspaso Salida', DATE_FORMAT(Fecha,'%d/%m/%Y'), PuntoVentaIdO FROM TRSalidas
				            UNION
				            SELECT MovimientoId, 'Venta', DATE_FORMAT(FechaCaptura,'%d/%m/%Y'), PuntoVentaId FROM HFolios WHERE MovimientoId>0
				            UNION
				            SELECT MovimientoId, T2.TipoMovimiento, DATE_FORMAT(Fecha,'%d/%m/%Y'), 0 FROM AjustesNegativos AS T1
				            LEFT JOIN TiposMovimientos AS T2 ON T2.TipoMovimientoId=T1.TipoMovimientoId
				          ) AS T2 ON T2.MovimientoId=T1.MovimientoId
				LEFT JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
				LEFT JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T2.PuntoVentaId
				WHERE Serie='$Serie'
				ORDER BY T1.MovimientoId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td title="'.$A0[6].'">'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getBuscaArticuloDispopnible($Serie)
	{
		$Q1="SELECT IFNULL(PuntoVentaId,0) FROM Inventario AS T1
				LEFT JOIN(
				            SELECT T1.MovimientoId, PuntoVentaId FROM Recepciones AS T1
				            UNION
				            SELECT MovimientoId, PuntoVentaIdO FROM TRSalidas
				            UNION
				            SELECT MovimientoId, PuntoVentaId FROM HFolios WHERE MovimientoId>0
				        ) AS T2 ON T2.MovimientoId=T1.MovimientoId
				WHERE Serie='$Serie'
				ORDER BY T1.MovimientoId DESC
        		LIMIT 1
				";
		list($PuntoVentaId)=mysql_fetch_row($this->Consulta($Q1));
	if(!isset($PuntoVentaId))
		$PuntoVentaId=0;

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Plataforma</th>
							<th>Almacen</th>
							<th>Fecha_Recepcion</th>
							<th>PuntoVenta</th>
							<th>Serie</th>
							<th>Observacion</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT Equipo, Plataforma, Almacen, Fecha, PuntoVenta, T1.Serie, IF(T3.Serie IS NULL AND Cantidad>0, 'Disponible','No Disponible'), MarcaId
				FROM (
						SELECT T1.EquipoId, T4.Fecha, T2.PuntoVentaId, T1.Serie, T1.Cantidad, T1.PlataformaId, T1.AlmacenId
							FROM Inventario AS T1
							LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=3
							LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Serie AND T3.Cantidad=0
							INNER JOIN Recepciones AS T4 ON T4.MovimientoId=T3.MovimientoId AND T4.TipoMovimientoId=1
							WHERE  T1.Serie='$Serie' AND T2.PuntoventaId = $PuntoVentaId
						UNION
							SELECT EquipoId, T2.Fecha, T2.PuntoventaId , T1.Serie, T1.Cantidad, T1.PlataformaId, T1.AlmacenId
							FROM Inventario AS T1
							LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=1
							WHERE EquipoId IN(SELECT EquipoId FROM Inventario WHERE Serie='$Serie')
				            AND PuntoventaId =$PuntoVentaId
					) AS T1
				LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId
			    LEFT JOIN Disponibles AS T3 ON T3.Serie=T1.Serie
			    LEFT JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoventaId
			    LEFT JOIN Plataformas AS T5 ON T5.PlataformaId=T1.PlataformaId
			    LEFT JOIN Almacenes AS T6 ON T6.AlmacenId=T1.AlmacenId
			    WHERE Cantidad>0
			    GROUP BY Serie
				ORDER BY Fecha ASC
			  ";

		$R0=$this->Consulta($Q0);
		$Bandera=0;
		while($A0=mysql_fetch_row($R0))
		{
		if($A0[7]==13)
			$Disponible='Disponible';
		else
		{
			if(($Bandera==0 || $Bandera==$A0[1]) & $A0[6]=='Disponible')
			{
				$Disponible='Disponible';
				$Bandera=$A0[1];
			}
			else
				$Disponible='No Disponible';
		}

			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
							<td>'.utf8_decode($Disponible).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function guardaLecturaFisico($Serie, $PuntoVentaId)
{
	$Q0="INSERT IGNORE INTO InventarioFisico
		SELECT NULL, Serie, $PuntoVentaId, CURDATE(), '$this->UsuarioId'
		FROM Inventario AS T1
		WHERE Serie='$Serie' LIMIT 1";

	$this->Consulta($Q0);
	return $this->getListaLecturaFisico($PuntoVentaId);
}

function getListaLecturaFisico($PuntoVentaId)
{	$Cta=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Equipo</th>
							<th>Serie</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T2.Equipo, T1.Serie, T0.RegistroId
				FROM InventarioFisico AS T0
				LEFT JOIN Inventario AS T1 ON T1.Serie=T0.Serie
				LEFT JOIN Equipos AS T2 ON T2.EquipoId=T1.EquipoId
				WHERE PuntoVentaId=$PuntoVentaId AND T0.Fecha=CURDATE()
				GROUP BY T1.Serie
			  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[2].','.$PuntoVentaId.',4)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(RegistroId) AS Cta FROM InventarioFisico WHERE PuntoVentaId=$PuntoVentaId AND Fecha=CURDATE()";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}

	function removeLecturaFisico($RegistroId, $PuntoVentaId)
	{
		$Q0="DELETE FROM InventarioFisico WHERE RegistroId=$RegistroId";
		$this->Consulta($Q0);

		return $this->getListaLecturaFisico($PuntoVentaId);
	}

function getLecturaFisica()
{
	$Q0="SELECT 'PuntoVetna', 'Equipo', 'Serie'
		 UNION
		 SELECT PuntoVenta, Equipo, CONCAT('\'',T1.Serie) FROM InventarioFisico AS T1
		 LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
		 LEFT JOIN (SELECT Serie, EquipoId FROM Inventario GROUP BY Serie) AS T3 ON T3.Serie=T1.Serie
		 LEFT JOIN Equipos AS T4 ON T4.EquipoId=T3.EquipoId";
		 return $this->Consulta($Q0);

}

function liberarSerie($Serie)
{
	$Q0="INSERT IGNORE INTO SerieLibre (Serie) VALUES('$Serie')";
	if($this->Consulta($Q0))
		return utf8_decode('<span class="notificacion">¡La peticion se proceso satisfactoriamente!</span>');
	return utf8_decode('<span class="alerta">¡No fue posible realizar la operacion!</span>');

}

function cambiarFechaRecepcion($Movimiento, $FechaNueva)
{
	$FechaNueva=$this->CambiarFormatoFecha($FechaNueva);

	$Q0="UPDATE Recepciones
		 SET Fecha='$FechaNueva'
		 WHERE ClaveRecepcion='$Movimiento'
		";
	$Q1="UPDATE OrdenesCompra
		SET FechaFactura='$FechaNueva'
		WHERE Factura = '$Movimiento'";
	$Q2="UPDATE FacturasEquipos
		SET Fecha='$FechaNueva'
		WHERE Factura = '$Movimiento'";



	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2))
			return utf8_decode('<span class="notificacion">¡La peticion se proceso satisfactoriamente!</span>');
	return utf8_decode('<span class="alerta">¡No fue posible realizar la operacion!</span>');

}

function bajaEmpleados($EmpleadoId, $CausaBajaId, $FechaBaja)
{
	$Q0="SELECT COUNT(CoordinadorId) AS Cta FROM CoordinadoresEmpleados WHERE CoordinadorId=$EmpleadoId AND FechaBaja='0000-00-00'";
	list($Cta)=mysql_fetch_row($this->Consulta($Q0));
		if($Cta>0)
			return utf8_decode('<span class="alerta">¡Existen ejecutivos asignados a esta persona!</span>');
	else
	{
	$this->StartTransaccion();
	$FechaBaja=$this->CambiarFormatoFecha($FechaBaja);
	$Q1="UPDATE HistorialPuestosEmpleados SET FechaBaja='$FechaBaja', CausaBajaId=$CausaBajaId
		 WHERE EmpleadoId=$EmpleadoId AND FechaBaja='0000-00-00'";

	$Q2="UPDATE HistorialPuntosEmpleados SET FechaBaja='$FechaBaja'
		 WHERE EmpleadoId=$EmpleadoId AND FechaBaja='0000-00-00'";

	$Q3="UPDATE Usuarios SET Activo=0 WHERE EmpleadoId=$EmpleadoId";

	$Q4="UPDATE IGNORE CoordinadoresEmpleados SET FechaBaja='$FechaBaja' WHERE FechaBaja='0000-00-00' AND EmpleadoId=$EmpleadoId";

	if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->addBitacora(10, 3, $EmpleadoId, '', ''))
	{
	$this->AceptaTransaccion();
	return 'OK';
	}
	$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible procesar la instruccion!</span>');
	}
}

function getListaCoordinadores()
{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla2" >
					<thead>
						<tr>
							<th>#Coordinador</th>
							<th>Coordinador</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Coordinador
				FROM HistorialPuestosEmpleados AS T1
				LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				LEFT JOIN HistorialPuntosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.FechaBaja='0000-00-00'
				LEFT JOIN Puestos AS T4 ON T4.PuestoId=T1.PuestoId AND T4.IsCoordinador=1
				WHERE T1.FechaBaja='0000-00-00'
				AND T3.PuntoventaId IN ($MisPuntos)
				GROUP BY T1.EmpleadoId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.($A0[1]).'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,8)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;


}

function AsignaCoordinadorEjecutivos($CoordinadorId, $Asesores)
{
	$Q0="UPDATE IGNORE CoordinadoresEmpleados SET FechaBaja=CURDATE()
		 WHERE FechaBaja='0000-00-00' AND EmpleadoId IN ($Asesores 0)
		";
	$Q1="INSERT IGNORE INTO CoordinadoresEmpleados
		SELECT $CoordinadorId, EmpleadoId, CURDATE(), '0000-00-00', NULL
		FROM Empleados WHERE EmpleadoId IN ($Asesores 0)";

	$this->StartTransaccion();
	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->addBitacora(35, 5, $CoordinadorId, $Asesores, ''))
	{
		$this->AceptaTransaccion();
		return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
	}
	else
	{
		$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible procesar la instruccion!</span>');
	}
}

function getDatosClientesSeguimiento($Nombre)
{
	list($PuntoVentaId, $Coorporativo)=$this->getPuntoVentaFisico();
	if($this->isCorporativo())
	$Filtro="TRUE";
	else
		$Filtro='PuntoVentaId = '.$PuntoVentaId;

	if($Nombre=='')
		$Filtro2='AND T2.SeguimientoId IS NULL';
	else
		$Filtro2='AND NOMBRE_CLIENTE=\''.$Nombre.'\'';

	$Q0="SELECT T1.SeguimientoId, NOMBRE_CLIENTE, MUNICIPIO, ESTADO, TELEFONO, DIRECCION, COLONIA
	FROM SeguimientoClientes AS T1
	LEFT JOIN HistorialSeguimiento AS T2 ON T2.SeguimientoId=T1.SeguimientoId
	WHERE T2.SeguimientoId IS NULL AND $Filtro $Filtro2
	GROUP BY NOMBRE_CLIENTE
	ORDER BY RAND() LIMIT 1";
	return mysql_fetch_row($this->Consulta($Q0));
}

function getSeguimientoLineas($Cliente)
	{
	return '';
		$Q0="SELECT T1.SeguimientoId,
			       NUM_CONTRATO,
			       NUM_DN,
			       COD_PLAN,
			       COD_MODELO,
			       DATE_FORMAT(FEC_VENC_CONTRATO,'%d/%m/%Y') AS FEC_VENC_CONTRATO,
			       IFNULL(EstatusSeguimientoId,0) AS EstatusSeguimientoId
			FROM SeguimientoClientes AS T1
			LEFT JOIN (
			            SELECT SeguimientoId, EstatusSeguimientoId FROM
			            (
			            SELECT SeguimientoId, EstatusSeguimientoId
			            FROM HistorialSeguimiento
			            ORDER BY Fecha DESC, Hora DESC
			            ) AS T1 GROUP BY SeguimientoId
			          ) AS T2 ON T2.SeguimientoId=T1.SeguimientoId
			WHERE NOMBRE_CLIENTE='$Cliente'";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Contrato</th>
							<th>Linea</th>
							<th>Plan</th>
							<th>Equipo</th>
							<th>Fecha Vencimiento</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getSeguimientoLineasHistorial($SeguimientoId)
	{
		$Q0="SELECT DATE_FORMAT(Fecha,'%d/%m/%Y'), Hora, CONCAT_WS(' ',Nombre, paterno, Materno),
		EstatusSeguimiento, Comentario, IF(FechaHora='0000-00-00 00:00:00','',DATE_FORMAT(FechaHora, '%d/%m/%Y %h:%m'))
			FROM HistorialSeguimiento AS T1
			LEFT JOIN Usuarios AS T2 ON T2.Usuarioid=T1.UsuarioId
			LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
			LEFT JOIN EstatusSeguimiento AS T4 ON T4.EstatusSeguimientoId=T1.EstatusSeguimientoId

			WHERE SeguimientoId=$SeguimientoId

			";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Usuario</th>
							<th>Esatus</th>
							<th>Comentarios</th>

						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td>'.$A0[4].'</td>

						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getSeguimientoAgenda()
	{
		$Q0="SELECT DATE_FORMAT(FechaHora, '%d/%m/%Y %h:%m'), NOMBRE_CLIENTE,
		Comentario
			FROM HistorialSeguimiento AS T1
			LEFT JOIN Usuarios AS T2 ON T2.Usuarioid=T1.UsuarioId
			LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
			LEFT JOIN EstatusSeguimiento AS T4 ON T4.EstatusSeguimientoId=T1.EstatusSeguimientoId
			LEFT JOIN SeguimientoClientes AS T5 ON T5. SeguimientoId=T1.SeguimientoId
			WHERE FechaHora!='0000-00-00 00:00:00' AND T1.UsuarioId=$this->UsuarioId
			ORDER BY FechaHora";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Fecha/Hora</th>
							<th>Cliente</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}


function getEstatusPosibleSeguimiento($SeguimientoId)
{
	$EstatusId=0;
	$Q0="SELECT T2.EstatusSeguimientoId, T2.EstatusSeguimiento
		FROM EstatusSeguimientoPosibles AS T1
		LEFT JOIN EstatusSeguimiento AS T2 ON T2.EstatusSeguimientoId=T1.EstatusPosible
		WHERE T1.EstatusSeguimientoId=$EstatusId";
	$R0=$this->Consulta($Q0);

	$cad='<select name="EstatusId" id="EstatusId" onchange="cambioEstatus(this)">
				<option value="0">Elige</option>
				';
				while($A0=mysql_fetch_row($R0))
				{
				$cad.= '<option value="'.$A0[0].'" title="'.$A0[1].'">'.utf8_decode($A0[1]).'</option> \n';
				}
	$cad.='</select>';

	return $cad;
}

function GuardaSeguimiento($SeguimientoId, $EstatusSeguimientoId, $Comentarios, $FechaHora)
{
	$Q0="INSERT IGNORE INTO HistorialSeguimiento (SeguimientoId, Fecha, Hora, usuarioId, EstatusSeguimientoId, Comentario, FechaHora)
VALUES($SeguimientoId, CURDATE(), CURTIME(), $this->UsuarioId, $EstatusSeguimientoId, '$Comentarios', '$FechaHora')";

	if($this->Consulta($Q0))
	{
		return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
	}
	else
	{

	return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}
}

function getMisClientesSeguimiento()
	{
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Cliente</th>
							<th>Ciudad</th>
							<th>Estado</th>
							<th>Fecha_Ultima_Revision</th>
							<th>Hora_Ultima_Revision</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT NOMBRE_CLIENTE, CIUDAD, ESTADO, Fecha, Hora
				FROM (
				      SELECT SeguimientoId, Fecha, Hora, UsuarioId
				      FROM (SELECT SeguimientoId, Fecha, Hora, UsuarioId FROM HistorialSeguimiento ORDER BY Fecha DESC, HORA DESC) AS T1 GROUP BY SeguimientoId
				     ) AS T1
				LEFT JOIN SeguimientoClientes AS T2 ON T2.SeguimientoId=T1.SeguimientoId
				WHERE T1.UsuarioId=$this->UsuarioId
				GROUP BY T1.SeguimientoId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td>'.$A0[4].'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="EnviaCliente(\''.$A0[0].'\')"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getInfoPersonal()
	{
	$Venta=$this->getClasificacionVenta();

		$Q0="SELECT 'Canal Operativo', 'Numero Control', 'Nombre Completo', 'Edad', 'Fecha Nacimiento', 'Sexo',
		'Estado Civil', 'Nacionalidad', 'RFC', 'CURP', 'Banco', 'No de Cuenta', 'Clabe', 'Estado','Municipio', 'Domicilio Particular',
		'Telefono Casa', 'Telefono Movil',
		'Puesto', 'SubCategoria','Actividades a Desarrollar', 'Fecha de Ingreso', 'Numero seguro Social',
    'Region', 'SubRegion', 'Plaza', 'Puntoventa',
    'Estatus', 'FechaBaja','Id Causa de Baja', 'Causa de Baja', 'Correo Electronico', 'Id Usuario', 'Estatus Imss', 'Fecha Alta Imss'
UNION
SELECT T25.ClasificacionPersonalVenta, T1.EmpleadoId,
       CONCAT_WS(' ', Nombre, paterno, Materno) AS NombreCompleato,
       YEAR(CURDATE())-YEAR(T1.FechaNacimiento) AS Edad,
       DATE_FORMAT(FechaNacimiento,'%d/%m/%Y') AS FechaNacimiento,
       Sexo,
       EstadoCivil,
       Nacionalidad,
       RFC,
       CURP, T26.Banco, CONCAT('\'',T3.NoCuenta), CONCAT('\'',T3.Clabe),
       Estado, Municipio,
       CONCAT_WS(' ',T3.Calle, 'N.Ext', T3.NExterior, 'N.Int', T3.NInterior, 'Col', T6.Colonia, 'C.P.', T6.CodigoPostal) AS DomicilioParticular,
       CONCAT('\'', Telefono),
       CONCAT('\'', Movil),
       Puesto,
       T7.SubCategoria,
       PuestoTxt,
       DATE_FORMAT(T1.UltimaFechaIngreso,'%d/%m/%Y') AS FechaIngreso,
       CONCAT('\'',NumeroSeguroSocial),
       IF(Estatus='Activo',T15.Region,T21.Region),
       IF(Estatus='Activo',T14.SubRegion,T20.SubRegion),
       IF(Estatus='Activo',T13.Plaza,T19.Plaza),
       IF(Estatus='Activo',T12.PuntoVenta,T18.PuntoVenta),
       Estatus,
       DATE_FORMAT(T7.FechaBaja,'%d/%m/%Y') AS FechaBaja,
       T7.CausaBajaId,
       CausaBaja,
       T23.Correo, T24.UsuarioId, IF(T27.Concepto='A', 'ACTIVO', 'INACTIVO') AS EstatusImss, IF(T27.Concepto='A', DATE_FORMAT(T27.Fecha, '%d/%m/%Y'), '') AS FechaAltaImss
FROM Empleados AS T1
LEFT JOIN (SELECT MAX(HistorialDatosEmpleadoId) AS HistorialDatosEmpleadoId, EmpleadoId
           FROM HistorialDatosEmpleados GROUP BY EmpleadoId) AS T2 ON T2.EmpleadoId=T1.EmpleadoId
LEFT JOIN HistorialDatosEmpleados AS T3 ON T3.HistorialDatosEmpleadoId=T2.HistorialDatosEmpleadoId
LEFT JOIN EstadoCivil AS T4 ON T4.EstadoCivilId=T3.EstadoCivilid
LEFT JOIN Nacionalidades AS T5 ON T5.NacionalidadId=T1.NacionalidadId
LEFT JOIN Colonias AS T6 ON T6.ColoniaId=T3.ColoniaId
LEFT JOIN (
            SELECT T1.EmpleadoId, T2.FechaBaja, T4.FechaAlta, IF(T2.CausaBajaId>0,'INACTIVO', 'ACTIVO') AS Estatus, T2.PuestoId, SubCategoria, T2.CausaBajaId, T2.ClasificacionPersonalVentaId
            FROM
            (SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId) AS T1
            LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.HistorialPuestoEmpleadoId>=T1.HistorialPuestoEmpleadoId
            LEFT JOIN (SELECT MIN(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId)
                      AS T3 ON T3.EmpleadoId=T1.EmpleadoId
            LEFT JOIN HistorialPuestosEmpleados AS T4 ON T4.HistorialPuestoEmpleadoId=T3.HistorialPuestoEmpleadoId
            LEFT JOIN SubCategorias AS T5 ON T5.SubCategoriaId=T2.SubCategoriaId
            GROUP BY T1.EmpleadoId

					) AS T7 ON T7.EmpleadoId=T1.EmpleadoId
LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
LEFT JOIN Municipios AS T9 ON T9.MunicipioId=T6.MunicipioId
LEFT JOIN Estados AS T10 ON T10.EstadoId=T9.EstadoId
LEFT JOIN HistorialPuntosEmpleados AS T11 ON T11.EmpleadoId=T1.EmpleadoId AND T11.FechaBaja='0000-00-00' AND T11.Fisico=1
LEFT JOIN PuntosVenta AS T12 ON T12.PuntoVentaId=T11.PuntoVentaId
LEFT JOIN Plazas AS T13 ON T13.PlazaId=T12.PlazaId
LEFT JOIN SubRegiones AS T14 ON T14.SubRegionId=T13.SubRegionId
LEFT JOIN Regiones AS T15 ON T15.RegionId=T14.RegionId
LEFT JOIN (SELECT MAX(HistorialPuntosEmpleadoId) AS HistorialPuntosEmpleadoId, EmpleadoId  FROM HistorialPuntosEmpleados WHERE Fisico=1
           GROUP BY EmpleadoId) AS T16 ON T16.EmpleadoId=T1.EmpleadoId
LEFT JOIN HistorialPuntosEmpleados AS T17 ON T17.HistorialPuntosEmpleadoId=T16.HistorialPuntosEmpleadoId
LEFT JOIN PuntosVenta AS T18 ON T18.PuntoVentaId=T17.PuntoVentaId
LEFT JOIN Plazas AS T19 ON T19.PlazaId=T18.PlazaId
LEFT JOIN SubRegiones AS T20 ON T20.SubRegionId=T19.SubRegionId
LEFT JOIN Regiones AS T21 ON T21.RegionId=T20.RegionId
LEFT JOIN CausasBaja AS T22 ON T22.CausaBajaId=T7.CausaBajaId
LEFT JOIN CorreosEmpleados AS T23 ON T23.EmpleadoId=T1.EmpleadoId
LEFT JOIN Usuarios AS T24 ON T24.EmpleadoId=T1.EmpleadoId
LEFT JOIN ClasificacionPersonalVenta AS T25 ON T25.ClasificacionPersonalVentaId=T7.ClasificacionPersonalVentaId
LEFT JOIN Bancos AS T26 ON T26.BancoId=T3.BancoId
LEFT JOIN (
			SELECT EmpleadoId, Concepto, Fecha FROM(
			SELECT EmpleadoId, Concepto, Fecha FROM (
			SELECT EmpleadoId, Fecha, Concepto FROM HistorialEmpleadosImss ORDER BY HistorialEmpleadoImss DESC
			) AS T1 GROUP BY EmpleadoId
			) AS T2 WHERE Fecha!='0000-00-00'
		) AS T27 ON T27.EmpleadoId=T1.EmpleadoId
WHERE T1.EmpleadoId>1  #AND T7.ClasificacionPersonalVentaId IN ($Venta)
";

		return $this->Consulta($Q0);
	}


	function getReporteSeguimiento()
	{
		$Venta=$this->getClasificacionVenta();

		$Q0="SELECT 'SEGUIMIENTOID','ASIGNACION','DISTRIBUIDOR_ASIGNADO','NUM_CONTRATO','NUM_DN','COD_ESTATUS_LINEA',
			'COD_UDN2','COD_FAMILIA_PLAN','BEST_FIT','COD_MODELO','COD_PLAN','COD_PLAZA','COD_PROPIEDAD',
			'COD_SEGMENTO_CLIENTE','COD_TPO_CTE','COD_TPO_PAGO','COD_TPO_PERSONA','COD_TPO_PLAN',
			'CVE_CICLO_FACTURACION','FEC_ACTIVACION_LINEA','FEC_ULT_RENOVACION','FEC_VENC_CONTRATO',
			'MES_VENCIMIENTO','ID_RFC','NOMBRE_CLIENTE','ANTIGUEDAD','CUADRANTE','COD_CANAL_VENTA',
			'COD_PUNTO_VENTA','COD_CALLE_CORRESP','COD_COLONIA_CORRESP','COD_MUNICIPIO_CORRESP','COD_POSTAL_CORRESP',
			'COD_CALLE_FISCAL','COD_COLONIA_FISCAL','COD_MUNICIPIO_FISCAL',
			'COD_POSTAL_FISCAL','CIUDAD','ESTADO', 'PUNTO_VENTA', 'REGION',
			'ULTIMA_REVISION','USUARIO','ESTATUS','COMENTARIO'
			UNION
			SELECT T1.SEGUIMIENTOID,
			       ASIGNACION,
			       DISTRIBUIDOR_ASIGNADO,
			       NUM_CONTRATO,
			       NUM_DN,
			       COD_ESTATUS_LINEA,
			       COD_UDN2,
			       COD_FAMILIA_PLAN,
			       BEST_FIT,
			       COD_MODELO,
			       COD_PLAN,
			       COD_PLAZA,
			       COD_PROPIEDAD,
			       COD_SEGMENTO_CLIENTE,
			       COD_TPO_CTE,
			       COD_TPO_PAGO,
			       COD_TPO_PERSONA,
			       COD_TPO_PLAN,
			       CVE_CICLO_FACTURACION,
			       DATE_FORMAT(FEC_ACTIVACION_LINEA,'%d/%m/%Y'),
			       DATE_FORMAT(FEC_ULT_RENOVACION,'%d/%m/%Y'),
			       DATE_FORMAT(FEC_VENC_CONTRATO,'%d/%m/%Y'),
			       MES_VENCIMIENTO,
			       ID_RFC,
			       NOMBRE_CLIENTE,
			       ANTIGUEDAD,
			       CUADRANTE,
			       COD_CANAL_VENTA,
			       COD_PUNTO_VENTA,
			       COD_CALLE_CORRESP,
			       COD_COLONIA_CORRESP,
			       COD_MUNICIPIO_CORRESP,
			       COD_POSTAL_CORRESP,
			       COD_CALLE_FISCAL,
			       COD_COLONIA_FISCAL,
			       COD_MUNICIPIO_FISCAL,
			       COD_POSTAL_FISCAL,
			       CIUDAD,
			       ESTADO,
			       PUNTOVENTA, REGION,
			       DATE_FORMAT(FECHA,'%d/%m/%Y') AS ULTIMA_REVISION,
			       CONCAT_WS(' ',Nombre, Paterno, Materno) AS USUARIO,
			       ESTATUSSEGUIMIENTO AS ESTATUS,
			       COMENTARIO
			FROM SeguimientoClientes AS T1
			LEFT JOIN (
			            SELECT SeguimientoId, Fecha, UsuarioId, EstatusSeguimientoId, Comentario FROM
			            (
			              SELECT SeguimientoId, Fecha, UsuarioId, EstatusSeguimientoId, Comentario
			              FROM HistorialSeguimiento ORDER BY Fecha DESC, Hora DESC
			            ) AS T1 GROUP BY SeguimientoId
			          ) AS T2 ON T2.SeguimientoId=T1.SeguimientoId
			LEFT JOIN Usuarios AS T3 ON T3.UsuarioId=T2.UsuarioId
			LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
			LEFT JOIN EstatusSeguimiento AS T5 ON T5.EstatusSeguimientoId=T2.EstatusSeguimientoId
			LEFT JOIN PuntosVenta AS T6 ON T6.PuntoVentaId=T1.PuntoVentaId
			LEFT JOIN Plazas AS T7 ON T7.PlazaId=T6.PlazaId
			LEFT JOIN SubRegiones AS T8 ON T8.SubRegionId=T7.SubRegionId
			LEFT JOIN Regiones AS T9 ON T9.RegionId=T8.RegionId
			WHERE ClasificacionPersonalVenta IN ($Venta)
			";
			return $this->Consulta($Q0);
	}

function validaAccesorio($Codigo, $PuntoVentaId, $Clave)
{
	//$Q0="SELECT COUNT(Codigo) AS Cta FROM AccInventario WHERE Codigo='$Codigo' AND PuntoVentaId=$PuntoVentaId AND Cantidad>0";
	$Q0="SELECT T1.Cta-T2.Cta AS Cta FROM
		(
		SELECT Cantidad AS Cta FROM AccInventario WHERE Codigo='$Codigo' AND PuntoVentaId=$PuntoVentaId AND Cantidad>0
		) AS T1,
		(
		SELECT COUNT(Codigo) AS Cta FROM AccVtaTemp WHERE Clave='$Clave'
		) AS T2
		";
		list($Cta)=mysql_fetch_row($this->Consulta($Q0));
		if($Cta<=0)
	return utf8_decode('<span class="alerta">¡Codigo ingresado No Valido!</span>');

	$Q1="INSERT INTO AccVtaTemp (Codigo, PuntoVentaId, Clave, RegistroId)
		 VALUES('$Codigo', $PuntoVentaId, '$Clave', NULL)
		";
	$this->Consulta($Q1);

	return $this->getListaAccVta($Clave);
}

function getListaAccVta($Clave)
{	$Cta=0;
	$Mte=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Accesorio</th>
							<th>Codigo SKU</th>
							<th>Precio</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T2.Descripcion, T1.Codigo, T1.RegistroId, Precio, FORMAT(Precio,2) FROM AccVtaTemp AS T1
				INNER JOIN AccArticulos AS T2 ON T2.Codigo=T1.Codigo
				INNER JOIN AccListasPuntos AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
				INNER JOIN AccArticulosPrecios AS T4 ON T4.ListaPrecioId=T3.ListaId AND T1.Codigo=T4.Codigo
				WHERE Clave='$Clave'
				GROUP BY T1.RegistroId
			  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[2].','.$Clave.',5)" /></td>
						</tr>
				';
			$t=(!$t);
			$Mte=$Mte+$A0[3];
		}
		$Q1="SELECT COUNT(RegistroId) AS Cta FROM AccVtaTemp WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						<input type="hidden" name="MontoLineas" id="MontoLineas" value="'.$Mte.'" />
						';
		return $Cadena;
	}

	function removeAccVta($RegistroId, $Clave)
	{
		$Q0="DELETE FROM AccVtaTemp WHERE RegistroId=$RegistroId";
		$this->Consulta($Q0);

		return $this->getListaAccVta($Clave);
	}

	function getVentasAccesorio()
	{

	$Venta=$this->getClasificacionVenta();
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT 'Empresa', 'Mes Venta', 'Fecha Venta', 'Region', 'SubRegion', 'Plaza', 'Punto de Venta', 'Ejecutivo', 'SubCategoria',
       'Coordinador', 'TipoPago', 'Factura', 'Proveedor', 'SKU', 'Clave/Modelo', 'Accesorio', 'Clasificacion', 'Cantidad', 'Precio'
	UNION ALL
	SELECT 'EXPERTCELL' AS Empresa,
	  CASE DATE_FORMAT(T1.Fecha,'%m')
	       WHEN '01' THEN 'enero'
	       WHEN '02' THEN 'febrero'
	       WHEN '03' THEN 'marzo'
	       WHEN '04' THEN 'abril'
	       WHEN '05' THEN 'mayo'
	       WHEN '06' THEN 'junio'
	       WHEN '07' THEN 'julio'
	       WHEN '08' THEN 'agosto'
	       WHEN '09' THEN 'septiembre'
	       WHEN '10' THEN 'octubre'
	       WHEN '11' THEN 'noviembre'
	       WHEN '12' THEN 'diciembre'
	       END AS Mes,
	  DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha,
	  Region,
	  SubRegion,
	  Plaza,
	  PuntoVenta,
	  CONCAT_WS(' ', T11.Nombre, T11.Paterno, T11.Materno) AS Ejecutivo,
	  SubCategoria,
	  CONCAT_WS(' ', T12.Nombre, T12.Paterno, T12.Materno) AS Coordinador,
	  'Efectivo' AS TipoPago,
	  Factura, Proveedor, 	CONCAT('\'',T8.Codigo), Modelo,  Descripcion, Clasificacion, 1 AS Cantidad,
	  Precio
	FROM AccVentas AS T1
	LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
	LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
	LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
	LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
	LEFT JOIN HistorialPuestosEmpleados AS T6 ON T6.HistorialPuestoEmpleadoId=T1.VendedorId
	LEFT JOIN AccVentasLineas AS T7 ON T7.VentaId=T1.VentaId
	LEFT JOIN AccArticulos AS T8 ON T8.Codigo=T7.Codigo
	LEFT JOIN Proveedores AS T9 ON T9.ProveedorId=T8.ProveedorId
	LEFT JOIN AccClasificacion AS T10 ON T10.ClasificacionId=T8.ClasificacionId
	LEFT JOIN Empleados AS T11 ON T11.EmpleadoId=T6.EmpleadoId
	LEFT JOIN Empleados AS T12 ON T12.EmpleadoId=T1.CoordinadorId
	LEFT JOIN SubCategorias AS T13 ON T13.SubCategoriaId=T6.SubCategoriaId
	WHERE T2.PuntoVentaId IN ($MisPuntos) AND ClasificacionPersonalVenta IN ($Venta)
	";

	$MisPuntos=$this->getMisPuntos();

		return $this->Consulta($Q0);

	}

function getInventarioAcc()
{
	$Venta=$this->getClasificacionVenta();

	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT 'Region', 'SubRegion', 'Plaza', 'Puntode Venta', 'Codigo', 'Modelo', 'Descripcion', 'Cantidad'
		UNION ALL
		SELECT Region, SubRegion, Plaza, PuntoVenta, T1.Codigo, Modelo, Descripcion, Cantidad
		FROM AccInventario AS T1
		LEFT JOIN AccArticulos AS T2 ON T2.Codigo=T1.Codigo
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
		LEFT JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
		LEFT JOIN SubRegiones AS T5 ON T5.SuBregionId=T4.SubRegionId
		LEFT JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
		WHERE T3.PuntoVentaId IN ($MisPuntos)
		AND ClasificacionPersonalVenta IN ($Venta)
		";

	return $this->Consulta($Q0);

}

function plantillaPresupuestal()
{

	$Q0="SELECT 'NUM DE CONTROL', 'REGION', 'SUBREGION', 'CLASIFICACION VENTA', 'PUNTO VENTA', 'PUESTO', 'ESTATUS', 'NOMBRE', 'FECHA DE INGRESO', 'COORDINADOR', 'SUELDO FIJO', 'OPERADORA'
			UNION ALL
		SELECT * FROM
			(SELECT T1.EmpleadoId,
			       Region,
			       SubRegion,
			       T13.ClasificacionPersonalVenta,
			       PuntoVenta,
			       Puesto,
			       'ACTIVO',
			       CONCAT_WS(' ',T9.Nombre, T9.Paterno, T9.Materno),
			       DATE_FORMAT(T9.UltimaFechaIngreso,'%d/%m/%Y'),
			       CONCAT_WS(' ', T12.Nombre, T12.Paterno, T12.Materno),
			       SueldoFijo, T14.Operador
			FROM HistorialSueldosFijos AS T1
			LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.FechaBaja='0000-00-00' AND T2.Fisico=1
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoventaId
			LEFT JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
			LEFT JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
			LEFT JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
			LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.EmpleadoId=T1.EmpleadoId
			LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
			LEFT JOIN Empleados AS T9 ON T9.EmpleadoId=T1.EmpleadoId
			LEFT JOIN (SELECT EmpleadoId, FechaAlta
			          FROM HistorialPuestosEmpleados GROUP BY EmpleadoId) AS T10 ON T10.EmpleadoId=T1.EmpleadoId
			LEFT JOIN CoordinadoresEmpleados AS T11 ON T11.EmpleadoId=T1.EmpleadoId AND T11.FechaBaja='0000-00-00'
			LEFT JOIN Empleados AS T12 ON T12.EmpleadoId=T11.CoordinadorId
			LEFT JOIN ClasificacionPersonalVenta AS T13 ON T13.ClasificacionPersonalVentaId=T7.ClasificacionPersonalVentaId
			LEFT JOIN Operadores AS T14 ON T14.OperadorId=T7.Operador
			WHERE T7.FechaBaja='0000-00-00' AND T1.FechaBaja='0000-00-00'
			ORDER BY Region ASC, PuntoVenta ASC, Jerarquia ASC
			) AS T1
			";
			return $this->Consulta($Q0);
			}

function getPlantilla()
{
				$Q0="SELECT Region, Plaza, PuntoVenta, Puesto, Autorizada, IFNULL(Activos,0) AS Activos
			FROM Plantilla AS T1
			LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
			LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
			LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
			LEFT JOIN Puestos AS T6 ON T6.PuestoId=T1.PuestoId
			LEFT JOIN (
			          SELECT PuntoVentaId, PuestoId, COUNT(T1.EmpleadoId) AS Activos
			          FROM HistorialPuestosEmpleados AS T1
			          LEFT JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.FechaBaja='0000-00-00' AND Fisico=1
			          WHERE T1.FechaBaja='0000-00-00'
			          GROUP BY T2.PuntoVentaId, PuestoId
			          ) AS T7 ON T7.PuntoVentaId=T1.PuntoVentaId AND T7.PuestoId=T1.PuestoId
			ORDER BY Region, Plaza, PuntoVenta, Jerarquia";

}

function desbloquearTraspasos()
{
	
	$Q0="SELECT T1.Serie FROM Disponibles AS T1
		LEFT JOIN LFolios AS T2 ON T2.Serie=T1.Serie
		WHERE T2.Serie IS NULL";
	$R0=$this->Consulta($Q0);

	while($A0=mysql_fetch_row($R0))
		{
		$Q1="DELETE FROM Disponibles WHERE Serie ='$A0[0]'";
		$this->Consulta($Q1);
		}
		return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
}

function desbloquearCancelados()
{
	$Q0="SELECT T1.Serie FROM LFolios AS T1
			INNER JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND Cantidad>0
			WHERE EstatusId=13
			GROUP BY Serie";
	$R0=$this->Consulta($Q0);

	while($A0=mysql_fetch_row($R0))
		{
		$Q1="DELETE FROM Disponibles WHERE Serie ='$A0[0]'";
		$this->Consulta($Q1);
		}
		return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
}

function AddLineaTP($Clave, $ProductoId)
{
	$Q0="INSERT INTO TPLineasTemporal (RegistroId, Clave, ProductoId)
	VALUES(NULL, '$Clave', '$ProductoId')";

	if($this->Consulta($Q0))
	return $this->getListaTPVta($Clave);
		else
	return utf8_decode('<span class="alerta">¡Codigo ingresado No Valido!</span>');

}


function getListaTPVta($Clave)
{	$Cta=0;
	$Mte=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Clave</th>
							<th>Descripcion</th>
							<th>Precio</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.RegistroId, T2.Clave, T2.Descripcion, FORMAT(Precio,2)  FROM TPLineasTemporal AS T1
			LEFT JOIN TPProductos AS T2 ON T2.ProductoId=T1.ProductoId
			WHERE T1.Clave='$Clave'
		  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>$'.utf8_decode($A0[3]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[0].','.$Clave.',6)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(RegistroId) AS Cta FROM TPLineasTemporal WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}


function getListaProductosTPbyFolio($Folio)
{	$Cta=0;
	$Mte=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Clave</th>
							<th>Descripcion</th>
							<th>Precio</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.RegistroId, T2.Clave, T2.Descripcion, FORMAT(Precio,2)
			 FROM TPVentasLineas AS T1
			LEFT JOIN TPProductos AS T2 ON T2.ProductoId=T1.ProductoId
			WHERE T1.Folio='$Folio'
		  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>$'.$A0[3].'</td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(RegistroId) AS Cta FROM TPVentasLineas WHERE Folio='$Folio'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}

	function removeTPVta($RegistroId, $Clave)
	{
		$Q0="DELETE FROM TPLineasTemporal WHERE RegistroId=$RegistroId";
		$this->Consulta($Q0);

		return $this->getListaTPVta($Clave);
	}

	function guardaTPVta($PuntoVentaId, $Folio, $PlazoId, $EstatusId, $FechaContrato, $FechaInstalacion, $ClienteId, $VendedorId, $CoordinadorId, $Comentarios, $Clave, $Pvs)
	{
		$FechaContrato=$this->CambiarFormatoFecha($FechaContrato);
		if($FechaInstalacion=='00-00-0000')
			$FechaInstalacion='0000-00-00';
		else
		$FechaInstalacion=$this->CambiarFormatoFecha($FechaInstalacion);

		$Q0="INSERT INTO TPVentas (Folio, FechaCaptura, FechaContrato, FechaInstalacion, VendedorId, CoordinadorId, ClienteId, TPEStatusId, PlazoId, Observaciones, UsuarioId, PuntoVentaId, Pvs)
			VALUES(UCASE('$Folio'),CURDATE(), '$FechaContrato', '$FechaInstalacion', '$VendedorId', '$CoordinadorId',  '$ClienteId', '$EstatusId', '$PlazoId', '$Comentarios', '$this->UsuarioId', $PuntoVentaId, '$Pvs')";

		$Q1="INSERT INTO TPVentasLineas
			SELECT RegistroId, UCASE('$Folio'), ProductoId FROM TPLineasTemporal WHERE Clave='$Clave'";

		$this->StartTransaccion();

		if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->addBitacora(41, 2, '$Folio', '', ''))
		{
			$this->AceptaTransaccion();
			return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
		}

			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}

	function getInactivoEdit($EmpleadoId)
	{
		$EmpleadoId=str_replace(',', '', $EmpleadoId);
		$Q0="SELECT T1.HistorialPuestoEmpleadoId,
			       CONCAT_WS(' ', Nombre, Paterno, Materno) AS Empleado,
			       Finiquito,
			       ObservacionesTH,
			       IFNULL(HistorialEmpleadoImss,0),
			       DATE_FORMAT(FechaSolicitud,'%d/%m/%Y'),
			       DATE_FORMAT(Fecha,'%d/%m/%Y')
			FROM HistorialPuestosEmpleados AS T1
			INNER JOIN (
			            SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId
			            FROM HistorialPuestosEmpleados
			            WHERE EmpleadoId=$EmpleadoId
			           ) AS T2 ON T2.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
			LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
			LEFT JOIN
			        (
			          SELECT T1.HistorialEmpleadoImss, EmpleadoId, FechaSolicitud, Fecha
			          FROM HistorialEmpleadosImss AS T1
			          INNER JOIN
			                    (
			                    SELECT IFNULL(MAX(HistorialEmpleadoImss),0) AS HistorialEmpleadoImss
			                    FROM HistorialEmpleadosImss
			                    WHERE EmpleadoId=$EmpleadoId AND Concepto='B'
			                    ) AS T2 ON T2.HistorialEmpleadoImss=T1.HistorialEmpleadoImss
			        ) AS T4 ON T4.EmpleadoId=T1.EmpleadoId
			";
		return mysql_fetch_row($this->Consulta($Q0));
	}

	function actualizaIfoInactivo($EmpleadoId, $HistorialPuestoEmpleadoId, $HistorialEmpleadosImss, $FechaSolicitud, $Fecha, $Finiquito, $ObservacionesTH)
	{
$EmpleadoId=str_replace(',', '', $EmpleadoId);
		if($FechaSolicitud=="")
			$FechaSolicitud='0000-00-00';
		else
			$FechaSolicitud=$this->CambiarFormatoFecha($FechaSolicitud);

		if($Fecha=="")
			$Fecha='0000-00-00';
		else
			$Fecha=$this->CambiarFormatoFecha($Fecha);

		$Qx="SELECT COUNT(EmpleadoId) AS Cta
			FROM HistorialEmpleadosImss WHERE EmpleadoId";
			list($Cta)=($this->Consulta($Qx));

		$Q0="UPDATE HistorialPuestosEmpleados
			 SET Finiquito=$Finiquito
			 WHERE EmpleadoId=$EmpleadoId";

		$Q1="UPDATE Empleados
			SET ObservacionesTH='$ObservacionesTH'
			WHERE EmpleadoId=$EmpleadoId";


		if($HistorialEmpleadosImss>0)
			$Q2="UPDATE HistorialEmpleadosImss
			 SET FechaSolicitud='$FechaSolicitud',
			     Fecha='$Fecha'
			 WHERE HistorialEmpleadoImss=$HistorialEmpleadosImss";
		else

		if($Cta>0)
		$Q2="INSERT INTO HistorialEmpleadosImss
			 SELECT EmpleadoId, '$FechaSolicitus', '$Fecha', 'B', SalarioDiarioIntegrado, NULL
			 FROM HistorialEmpleadosImss WHERE EmpleadoId=$EmpleadoId";
			else
		$Q2="INSERT INTO HistorialEmpleadosImss (EmpleadoId, FechaSolicitud, Fecha, Concepto, SalarioDiarioIntegrado, HistorialEmpleadoImss)
			 VALUES($EmpleadoId, '$FechaSolicitud', '$Fecha', 'B', 0, NULL)";

			 $this->StartTransaccion();
			 if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2) & $this->addBitacora(40, 5, $EmpleadoId, 'se cambia historialpuesto'.$HistorialPuestoEmpleadoId.' y datos de imss'.$HistorialEmpleadosImss, ''))
			 {
			$this->AceptaTransaccion();
			return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
			}

			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');


	}

	function getVentasLineasTotal()
	{
		$Venta=$this->getClasificacionVenta();

		$MisPuntos=$this->getMisPuntos();
/*
		$Q0="SELECT 'Contrato', 'Folio', 'Fecha Activacion', 'Region', 'SubRegion', 'Plaza', 'PuntoVenta', 'TipoPunto', 'FechaIngreso',
       'Coordinador', 'Ejecutivo', 'Categoria', 'SubCategoria', 'Cliente', 'TipoPersona', 'RFC', 'TipoPago',
       'Marca', 'Equipo', 'Plan', 'PlanDAV', 'PlanBum', 'Familia', 'RentaSImpuesto', 'Plazo', 'Evento', 'Estatus', 'Comentario',
       'FechaEntrega', 'FechaFacturado', 'MEID/IMEID', 'RegistroId', 'DN', 'Canal de Venta', 'Clasificacion de Venta', 'Validado DAV'
		UNION ALL
		SELECT
		Contrato,
		T1.Folio,
		DATE_FORMAT(T1.FechaSS,'%d/%m/%Y') AS FechaActivacion,
		Region,
		SubRegion,
		Plaza,
		PuntoVenta,
		TipoPunto,
		DATE_FORMAT(T0.Fecha, '%d/%m/%Y') AS FechaIngreso,
		CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
		CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
		Puesto AS Categoria,
		IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
		CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
		TipoPersona,
		T11.Rfc,
		TipoPago,
		Marca,
		Equipo,
		Plan,
		PlanNextel,
		PlanBum,
		Familia,
		RentaSImpuesto,
		Plazo,
		IF(LENGTH(T1.Folio)<6,'UNEFON',IF(MarcaId=13 AND PlanId=81, 'SIM', IF(PlanId=81, 'VTA DE EQUIPO',IF(T1.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION')))) AS Evento,
		Estatus,
		UCASE(T14.Comentario) AS Comentario,
		DATE_FORMAT(T0.Fecha,'%d/%m/%Y') AS FechaEntrega,
		DATE_FORMAT(T0.Fecha,'%d/%m/%Y') AS FechaFacturado,
		CONCAT('\'',T14.Serie),
		T14.RegistroId,
		Dn, 'Originacion', T18.ClasificacionPersonalVenta, IF(T1.Validado, 'SI', 'NO')
		FROM HFolios AS T1
		LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
		LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
		LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
		LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
		LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
		LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
		LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
		LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
		LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
		LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
		LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
		LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
		LEFT JOIN (
		            SELECT
		                  T1.Folio,
		                  T1.RegistroId,
		                  Familia,
		                  Marca,
		                  Equipo,
		                  Serie,
		                  T2.Clave AS ClavePlan,
		                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
		                  CONCAT_WS(' ',Plan, AddonTxt) AS Plan,
		                  Costo AS RentaPlan,
		                  Costo/1.16 AS RentaSIVA,
		                  Costo/1.16/1.03 AS RentaSImpuesto,
		                  Plazo,
		                  Estatus,
		                  Comentario,
		                  Contrato,
		                  T9.MarcaId,
		                  T1.PlanId,
		                  Dn
		            FROM LFolios AS T1
		            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
		            LEFT JOIN (
		                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn,
		                        GROUP_CONCAT(AddonTxt  SEPARATOR ' ') AS AddonTxt
		                        FROM LineasAddon AS T1
		                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
		                        GROUP BY RegistroId
		                      ) AS T3 ON T3.RegistroId=T1.RegistroId
		            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
		            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
		            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
		            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
		            LEFT JOIN Marcas AS T10 ON T10.MarcaId=T9.MarcaId
			    INNER JOIN HFolios T11 ON T11.Folio=T1.Folio
			 WHERE EnReporte=1 AND MovimientoId!=0
		          ) AS T14 ON T14.Folio=T1.Folio
		LEFT JOIN TiposContratacion AS T15 ON T15.TipoContratacionId=T1.TipoContratacionId
		LEFT JOIN Bitacora AS T0 ON T0.ObjetoId=T14.RegistroId
		LEFT JOIN TipoPuntos AS T16 ON T16.TipoPuntoId=T2.TipoPuntoId
		LEFT JOIN LineasPlanesNextel AS T17 ON T17.RegistroId=T14.RegistroId
		LEFT JOIN ClasificacionPersonalVenta AS T18 ON T18.ClasificacionPersonalVentaId=T2.ClasificacionPersonalVenta
		WHERE T1.Comentarios!='Temp FG' AND T1.MovimientoId>0 AND T0.Host='14' AND T0.Fecha>=DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND T2.ClasificacionPersonalVenta IN ($Venta)
		AND EnReporte=1 AND T2.PuntoventaId IN ($MisPuntos)
		GROUP BY T14.RegistroId
		UNION ALL
		SELECT
		Serie AS Contrato,
		T1.Folio,
		DATE_FORMAT(T1.FechaSS,'%d/%m/%Y') AS FechaActivacion,
		Region,
		SubRegion,
		Plaza,
		PuntoVenta,
		TipoPunto,
		DATE_FORMAT(FechaSS,'%d/%m/%Y') AS FechaIngreso,
		CONCAT_WS(' ',  T6.Nombre, T6.Paterno, T6.Materno) AS Coordinador,
		CONCAT_WS(' ',  T10.Nombre, T10.Paterno, T10.Materno) AS Ejecutivo,
		Puesto AS Categoria,
		IF(T9.SubCategoriaId=4,'',T9.SubCategoria) AS SubCategoria,
		CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Cliente,
		TipoPersona,
		T11.Rfc,
		TipoPago,
		Marca,
		Equipo,
		Plan,
		PlanNextel,
		PlanBum,
		Familia,
		RentaSImpuesto,
		Plazo,
		IF(T1.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento,
		Estatus,
		UCASE(Comentario) AS Comentario,
		FechaEntrega,
		FechaFacturado,
		'' AS IMEID,
		T14.RegistroId,
		Dn, 'Ventanilla Unica', T18.ClasificacionPersonalVenta,
		IF(T1.Validado, 'SI', 'NO')
		FROM HFolios AS T1
		LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
		LEFT JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
		LEFT JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
		LEFT JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
		LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T1.CoordinadorId
		LEFT JOIN HistorialPuestosEmpleados AS T7 ON T7.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
		LEFT JOIN Puestos AS T8 ON T8.PuestoId=T7.PuestoId
		LEFT JOIN SubCategorias AS T9 ON T9.SubCategoriaId=T7.SubCategoriaId
		LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T7.EmpleadoId
		LEFT JOIN Clientes AS T11 ON T11.ClienteId=T1.ClienteId
		LEFT JOIN TiposPersona AS T12 ON T12.TipoPersonaId=T11.TipoPersonaId
		LEFT JOIN TiposPago AS T13 ON T13.TipoPagoId=T1.TipoPagoId
		LEFT JOIN (
		            SELECT
		                  T1.Folio,
		                  T1.RegistroId,
		                  Familia,
		                  Marca,
		                  Equipo,
		                  Serie,
		                  T2.Clave AS ClavePlan,
		                  CONCAT_WS(' ',T2.Clave, T4.Clave, IFNULL(AddOn, '')) AS PlanBUM,
		                  CONCAT_WS(' ',Plan, AddonTxt) AS Plan,
		                  Costo AS RentaPlan,
		                  Costo/1.16 AS RentaSIVA,
		                  Costo/1.16/1.03 AS RentaSImpuesto,
		                  Plazo,
		                  Estatus,
		                  Comentario,
		                  IF(T11.Host=9, DATE_FORMAT(T11.Fecha, '%d/%m/%Y'), '') AS FechaEntrega,
		                  IF(T8.Host=7, DATE_FORMAT(T8.Fecha, '%d/%m/%Y'), '') AS FechaFacturado,
		                  Dn
		            FROM LFolios AS T1
		            LEFT JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
		            LEFT JOIN (
		                        SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn,
		                        GROUP_CONCAT(AddonTxt  SEPARATOR ' ') AS AddonTxt
		                        FROM LineasAddon AS T1
		                        LEFT JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
		                        GROUP BY RegistroId
		                      ) AS T3 ON T3.RegistroId=T1.RegistroId
		            LEFT JOIN TiposPlan AS T4 ON T4.TipoPlanId=T1.TipoPlanId
		            LEFT JOIN Plazos AS T6 ON T6.PlazoId=T1.PlazoId
		            LEFT JOIN Estatus AS T7 ON T7.EstatusId=T1.EstatusId
		            LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=7) AS T8 ON T8.ObjetoId=T1.RegistroId
		            LEFT JOIN Equipos AS T9 ON T9.EquipoId=T1.EquipoId
		            LEFT JOIN Marcas AS T10 ON T10.MarcaId=T9.MarcaId
		            LEFT JOIN (SELECT ObjetoId, Host, Fecha FROM Bitacora WHERE Comentario='Cambio estatus' AND Host=9) AS T11 ON T11.ObjetoId=T1.RegistroId
			   		INNER JOIN HFolios T12 ON T12.Folio=T1.Folio
                         WHERE EnReporte=1 AND MovimientoId=0
		        ) AS T14 ON T14.Folio=T1.Folio
		LEFT JOIN TiposContratacion AS T15 ON T15.TipoContratacionId=T1.TipoContratacionId
		LEFT JOIN TipoPuntos AS T16 ON T16.TipoPuntoId=T2.TipoPuntoId
		LEFT JOIN LineasPlanesNextel AS T17 ON T17.RegistroId=T14.RegistroId
		LEFT JOIN ClasificacionPersonalVenta AS T18 ON T18.ClasificacionPersonalVentaId=T2.ClasificacionPersonalVenta
		WHERE T14.RegistroId>0 AND T1.MovimientoId=0  AND FechaSS>=DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND EnReporte=1 AND T2.ClasificacionPersonalVenta IN ($Venta)
		AND T2.PuntoventaId IN ($MisPuntos)
		GROUP BY T14.RegistroId";
		*/
        	/*	$Q0="SELECT 'Contrato', 'Folio', 'Fecha Activacion', 'Region', 'SubRegion', 'Plaza', 'PuntoVenta', 'TipoPunto', 'FechaIngreso',
       'Coordinador', 'Ejecutivo', 'Categoria', 'SubCategoria', 'Cliente', 'TipoPersona', 'RFC', 'TipoPago',
       'Marca', 'Equipo', 'OrigenDeEquipo','TipoDeLinea','Plan', 'PlanDAV', 'PlanBum','Familia', 'RentaSImpuesto', 'Plazo', 'Evento', 'Estatus', 'Comentario',
       'FechaEntrega', 'FechaFacturado', 'MEID/IMEID', 'RegistroId', 'DN', 'AddOn','Seguro','Canal de Venta', 'Clasificacion de Venta', 'Validado DAV',
       'Tipo Contratacion', 'Plataforma'
UNION
SELECT Contrato, T1.Folio, DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaActivacion, Region, SubRegion, Plaza, PuntoVenta, TipoPunto,
   		DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaIngreso,
		CONCAT_WS(' ',  T9.Nombre, T9.Paterno, T9.Materno) AS Coordinador,
		CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Ejecutivo,
		Puesto AS Categoria, IF(T13.SubCategoriaId=4,'',T13.SubCategoria) AS SubCategoria,
    CONCAT_WS(' ',  T14.Nombre, T14.Paterno, T14.Materno) AS Cliente, TipoPersona, T14.RFC, TipoPago, 	Marca, Equipo,IF(T18.MarcaId!=13,'Con Equipo','Sin Equipo'),
    IF(T33.Raiz='Ancla','Compartelo Incluido',IF(T33.Raiz='Popote','Compartelo Adicional',IF(T1.PlanId=367 OR T1.PlanId=368,'Internet En Casa','MIX'))) AS Raiz,
    CONCAT_WS(' ',Plan, T21.AddonTxt) AS Plan, PlanNextel, CONCAT_WS(' ',T2.Clave, T19.ClaveBum, IFNULL(T21.AddOn, '')) AS PlanBUM, Familia,
    Costo/1.16/1.03 AS RentaPlan, Plazo,
    IF(T2.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento, Estatus, T1.Comentario,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaEntrega,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaFacturado,
    Serie, T1.RegistroId, T1.DN,T32.Addon,Seguro, IF(T2.MovimientoId>0,'Originacion', 'Ventanilla Unica'),
    T28.ClasificacionPersonalVenta, IF(T2.Validado, 'SI', 'NO'), T29.TipoContratacion, T30.Plataforma

FROM LFolios AS T1
INNER JOIN HFolios AS T2 ON T2.Folio=T1.Folio
INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
INNER JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
INNER JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
INNER JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
INNER JOIN TipoPuntos AS T7 ON T7.TipoPuntoId=T3.TipoPuntoId
#INNER JOIN Bitacora AS T8 ON T8.ObjetoId=T1.RegistroId
INNER JOIN Empleados AS T9 ON T9.EmpleadoId=T2.CoordinadorId
INNER JOIN HistorialPuestosEmpleados AS T10 ON T10.HistorialPuestoEmpleadoId=T2.HistorialPuestoEmpleadoId
INNER JOIN Empleados AS T11 ON T11.EmpleadoId=T10.EmpleadoId
INNER JOIN Puestos AS T12 ON T12.PuestoId=T10.PuestoId
INNER JOIN SubCategorias AS T13 ON T13.SubCategoriaId=T10.SubCategoriaId
INNER JOIN Clientes AS T14 ON T14.ClienteId=T2.ClienteId
INNER JOIN TiposPersona AS T15 ON T15.TipoPersonaId=T14.TipoPersonaId
INNER JOIN TiposPago AS T16 ON T16.TipoPagoId=T2.TipoPagoId
INNER JOIN Equipos AS T17 ON T17.EquipoId=T1.EquipoId
INNER JOIN Marcas AS T18 ON T18.MarcaId=T17.MarcaId
INNER JOIN Planes AS T19 ON T19.PlanId=T1.PlanId
INNER JOIN Plazos AS T20 ON T20.PlazoId=T1.PlazoId
LEFT JOIN (
		    SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn,
		              GROUP_CONCAT(AddonTxt  SEPARATOR ' ') AS AddonTxt
		    FROM LineasAddon AS T1
		    INNER JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
            WHERE T1.AddonId!=7
		    GROUP BY RegistroId
		      ) AS T21 ON T21.RegistroId=T1.RegistroId
LEFT JOIN LineasPlanesNextel AS T22 ON T22.RegistroId=T1.RegistroId
INNER JOIN Estatus AS T25 ON T25.EstatusId=T1.EstatusId
INNER JOIN ClasificacionPersonalVenta AS T28 ON T28.ClasificacionPersonalVentaId=T3.ClasificacionPersonalVenta
LEFT JOIN TiposContratacion AS T29 ON T29.TipoContratacionId=T2.TipoContratacionId
LEFT JOIN Plataformas AS T30 ON T30.PlataformaId=T2.PlataformaId
LEFT JOIN Seguros AS T31 ON T31.SeguroId=T1.SeguroId
LEFT JOIN (SELECT RegistroId, GROUP_CONCAT(AddOn ORDER BY Addon SEPARATOR ' - ') AS AddOn FROM LineasAddon AS T1
		   INNER JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
		   GROUP BY RegistroId
		   ) AS T32 ON T1.RegistroId=T32.RegistroId
LEFT JOIN LineaTemporalOpc1 AS T33 ON (T33.Imei=T1.Serie OR T33.ImeiSim=T1.Serie)
WHERE EnReporte=1 AND T1.Registroid>0  AND FechaSS>=DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
AND T3.ClasificacionPersonalVenta IN ($Venta)
AND T3.PuntoventaId IN ($MisPuntos) AND T1.PlanId!=81 AND T1.PlanId!=255
GROUP BY T1.RegistroId
";

		return $this->Consulta($Q0);*/
		if($this->isCorporativo()){
				$Q0="SELECT 'Contrato', 'Folio', 'Fecha Activacion', 'Region', 'SubRegion', 'Plaza', 'PuntoVenta SIIGA','PuntoVenta AT&T', 'TipoPunto', 'FechaIngreso',
       'Coordinador', 'Ejecutivo', 'Categoria', 'SubCategoria', 'Cliente', 'TipoPersona', 'RFC', 'TipoPago',
       'Marca', 'Equipo', 'Plan', 'PlanDAV', 'PlanBum', 'Familia', 'RentaSImpuesto', 'Plazo', 'Evento', 'Estatus', 'Comentario',
       'FechaEntrega', 'FechaFacturado', 'MEID/IMEID', 'RegistroId', 'DN', 'Canal de Venta', 'Clasificacion de Venta', 'Validado DAV',
       'Tipo Contratacion', 'Plataforma'
UNION
SELECT Contrato, T1.Folio, DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaActivacion, Region, SubRegion, Plaza, PuntoVenta, NombreATT,TipoPunto,
   		DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaIngreso,
		CONCAT_WS(' ',  T9.Nombre, T9.Paterno, T9.Materno) AS Coordinador,
		CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Ejecutivo,
		Puesto AS Categoria, IF(T13.SubCategoriaId=4,'',T13.SubCategoria) AS SubCategoria,
    CONCAT_WS(' ',  T14.Nombre, T14.Paterno, T14.Materno) AS Cliente, TipoPersona, T14.RFC, TipoPago, Marca, Equipo,
    CONCAT_WS(' ',Plan, T21.AddonTxt) AS Plan, PlanNextel, CONCAT_WS(' ',T2.Clave, T19.ClaveBum, IFNULL(T21.AddOn, '')) AS PlanBUM, Familia,
    Costo/1.16/1.03 AS RentaPlan, Plazo,
    IF(T2.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento, Estatus, T1.Comentario,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaEntrega,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaFacturado,
    Serie, T1.RegistroId, T1.DN, IF(T2.MovimientoId>0,'Originacion', 'Ventanilla Unica'),
    T28.ClasificacionPersonalVenta, IF(T2.Validado, 'SI', 'NO'), T29.TipoContratacion, T30.Plataforma

FROM LFolios AS T1
INNER JOIN HFolios AS T2 ON T2.Folio=T1.Folio
INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
LEFT JOIN PuntosATT AS TATT ON T3.PuntoVentaId=TATT.PuntoVentaId
INNER JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
INNER JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
INNER JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
INNER JOIN TipoPuntos AS T7 ON T7.TipoPuntoId=T3.TipoPuntoId
#INNER JOIN Bitacora AS T8 ON T8.ObjetoId=T1.RegistroId
INNER JOIN Empleados AS T9 ON T9.EmpleadoId=T2.CoordinadorId
INNER JOIN HistorialPuestosEmpleados AS T10 ON T10.HistorialPuestoEmpleadoId=T2.HistorialPuestoEmpleadoId
INNER JOIN Empleados AS T11 ON T11.EmpleadoId=T10.EmpleadoId
INNER JOIN Puestos AS T12 ON T12.PuestoId=T10.PuestoId
INNER JOIN SubCategorias AS T13 ON T13.SubCategoriaId=T10.SubCategoriaId
INNER JOIN Clientes AS T14 ON T14.ClienteId=T2.ClienteId
INNER JOIN TiposPersona AS T15 ON T15.TipoPersonaId=T14.TipoPersonaId
INNER JOIN TiposPago AS T16 ON T16.TipoPagoId=T2.TipoPagoId
INNER JOIN Equipos AS T17 ON T17.EquipoId=T1.EquipoId
INNER JOIN Marcas AS T18 ON T18.MarcaId=T17.MarcaId
INNER JOIN Planes AS T19 ON T19.PlanId=T1.PlanId
INNER JOIN Plazos AS T20 ON T20.PlazoId=T1.PlazoId
LEFT JOIN (
		    SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn,
		              GROUP_CONCAT(AddonTxt  SEPARATOR ' ') AS AddonTxt
		    FROM LineasAddon AS T1
		    INNER JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
            WHERE T1.AddonId!=7
		    GROUP BY RegistroId
		      ) AS T21 ON T21.RegistroId=T1.RegistroId
LEFT JOIN LineasPlanesNextel AS T22 ON T22.RegistroId=T1.RegistroId
INNER JOIN Estatus AS T25 ON T25.EstatusId=T1.EstatusId
INNER JOIN ClasificacionPersonalVenta AS T28 ON T28.ClasificacionPersonalVentaId=T3.ClasificacionPersonalVenta
LEFT JOIN TiposContratacion AS T29 ON T29.TipoContratacionId=T2.TipoContratacionId
LEFT JOIN Plataformas AS T30 ON T30.PlataformaId=T2.PlataformaId
WHERE EnReporte=1 AND T1.Registroid>0  AND FechaSS>=DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
AND T3.ClasificacionPersonalVenta IN ($Venta)
AND T3.PuntoventaId IN ($MisPuntos) AND T19.PlanId!=255
GROUP BY T1.RegistroId
";

		return $this->Consulta($Q0);
		}else{
		    $Q0="SELECT 'Contrato', 'Folio', 'Fecha Activacion', 'Region', 'SubRegion', 'Plaza', 'PuntoVenta', 'TipoPunto', 'FechaIngreso',
       'Coordinador', 'Ejecutivo', 'Categoria', 'SubCategoria', 'Cliente', 'TipoPersona', 'RFC', 'TipoPago',
       'Marca', 'Equipo', 'Plan', 'PlanDAV', 'PlanBum', 'Familia', 'RentaSImpuesto', 'Plazo', 'Evento', 'Estatus', 'Comentario',
       'FechaEntrega', 'FechaFacturado', 'MEID/IMEID', 'RegistroId', 'DN', 'Canal de Venta', 'Clasificacion de Venta', 'Validado DAV',
       'Tipo Contratacion', 'Plataforma'
UNION
SELECT Contrato, T1.Folio, DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaActivacion, Region, SubRegion, Plaza, PuntoVenta, TipoPunto,
   		DATE_FORMAT(T2.FechaSS,'%d/%m/%Y') AS FechaIngreso,
		CONCAT_WS(' ',  T9.Nombre, T9.Paterno, T9.Materno) AS Coordinador,
		CONCAT_WS(' ',  T11.Nombre, T11.Paterno, T11.Materno) AS Ejecutivo,
		Puesto AS Categoria, IF(T13.SubCategoriaId=4,'',T13.SubCategoria) AS SubCategoria,
    CONCAT_WS(' ',  T14.Nombre, T14.Paterno, T14.Materno) AS Cliente, TipoPersona, T14.RFC, TipoPago, Marca, Equipo,
    CONCAT_WS(' ',Plan, T21.AddonTxt) AS Plan, PlanNextel, CONCAT_WS(' ',T2.Clave, T19.ClaveBum, IFNULL(T21.AddOn, '')) AS PlanBUM, Familia,
    Costo/1.16/1.03 AS RentaPlan, Plazo,
    IF(T2.TipoContratacionId <3, 'ACTIVACION', 'RENOVACION') AS Evento, Estatus, T1.Comentario,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaEntrega,
		DATE_FORMAT(T1.FechaEstatus,'%d/%m/%Y') AS FechaFacturado,
    Serie, T1.RegistroId, T1.DN, IF(T2.MovimientoId>0,'Originacion', 'Ventanilla Unica'),
    T28.ClasificacionPersonalVenta, IF(T2.Validado, 'SI', 'NO'), T29.TipoContratacion, T30.Plataforma

FROM LFolios AS T1
INNER JOIN HFolios AS T2 ON T2.Folio=T1.Folio
INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
INNER JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
INNER JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
INNER JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
INNER JOIN TipoPuntos AS T7 ON T7.TipoPuntoId=T3.TipoPuntoId
#INNER JOIN Bitacora AS T8 ON T8.ObjetoId=T1.RegistroId
INNER JOIN Empleados AS T9 ON T9.EmpleadoId=T2.CoordinadorId
INNER JOIN HistorialPuestosEmpleados AS T10 ON T10.HistorialPuestoEmpleadoId=T2.HistorialPuestoEmpleadoId
INNER JOIN Empleados AS T11 ON T11.EmpleadoId=T10.EmpleadoId
INNER JOIN Puestos AS T12 ON T12.PuestoId=T10.PuestoId
INNER JOIN SubCategorias AS T13 ON T13.SubCategoriaId=T10.SubCategoriaId
INNER JOIN Clientes AS T14 ON T14.ClienteId=T2.ClienteId
INNER JOIN TiposPersona AS T15 ON T15.TipoPersonaId=T14.TipoPersonaId
INNER JOIN TiposPago AS T16 ON T16.TipoPagoId=T2.TipoPagoId
INNER JOIN Equipos AS T17 ON T17.EquipoId=T1.EquipoId
INNER JOIN Marcas AS T18 ON T18.MarcaId=T17.MarcaId
INNER JOIN Planes AS T19 ON T19.PlanId=T1.PlanId
INNER JOIN Plazos AS T20 ON T20.PlazoId=T1.PlazoId
LEFT JOIN (
		    SELECT RegistroId, GROUP_CONCAT(Clave ORDER BY Orden ASC  SEPARATOR ' ') AS AddOn,
		              GROUP_CONCAT(AddonTxt  SEPARATOR ' ') AS AddonTxt
		    FROM LineasAddon AS T1
		    INNER JOIN Addon AS T2 ON T2.AddOnId=T1.AddOnId
            WHERE T1.AddonId!=7
		    GROUP BY RegistroId
		      ) AS T21 ON T21.RegistroId=T1.RegistroId
LEFT JOIN LineasPlanesNextel AS T22 ON T22.RegistroId=T1.RegistroId
INNER JOIN Estatus AS T25 ON T25.EstatusId=T1.EstatusId
INNER JOIN ClasificacionPersonalVenta AS T28 ON T28.ClasificacionPersonalVentaId=T3.ClasificacionPersonalVenta
LEFT JOIN TiposContratacion AS T29 ON T29.TipoContratacionId=T2.TipoContratacionId
LEFT JOIN Plataformas AS T30 ON T30.PlataformaId=T2.PlataformaId
WHERE EnReporte=1 AND T1.Registroid>0  AND FechaSS>=DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
AND T3.ClasificacionPersonalVenta IN ($Venta)
AND T3.PuntoventaId IN ($MisPuntos)
GROUP BY T1.RegistroId
";

		return $this->Consulta($Q0);
		}
	}

	function getCumpedelmes()
	{
		$Q0="SELECT '', 'Cumpleaños','Nombre', 'Correo', 'Plaza', 'Punto_Venta', 'Icono'
			UNION ALL
			SELECT * FROM (
			SELECT
			      T1.EmpleadoId,

			      CONCAT_WS('-', DATE_FORMAT(FechaNacimiento, '%d'),
			               CASE DATE_FORMAT(FechaNacimiento,'%m')
			          	       WHEN '01' THEN 'enero'
			          	       WHEN '02' THEN 'febrero'
			          	       WHEN '03' THEN 'marzo'
			          	       WHEN '04' THEN 'abril'
			          	       WHEN '05' THEN 'mayo'
			          	       WHEN '06' THEN 'junio'
			          	       WHEN '07' THEN 'julio'
			          	       WHEN '08' THEN 'agosto'
			          	       WHEN '09' THEN 'septiembre'
			          	       WHEN '10' THEN 'octubre'
				                 WHEN '11' THEN 'noviembre'
			          	       WHEN '12' THEN 'diciembre'
				             END) AS Mes,
					CONCAT_WS(' ', Nombre, Paterno, Materno) AS Empleado,
			      Correo,
				Plaza,
			    PuntoVenta,
 	            IF(DATE_FORMAT(FechaNacimiento, '%d')=DATE_FORMAT(CURDATE(), '%d'), 'CumpleHoy', IF(DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY),'%d')=DATE_FORMAT(FechaNacimiento,'%d'),'Cumplemanana','Cumplemes')) AS Icono
			FROM Empleados AS T1
			INNER JOIN HistorialPuntosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND Fisico=1 AND FechaBaja='0000-00-00'
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoventaId=T2.PuntoVentaId
			LEFT JOIN Plazas AS T4 ON T4.PlazaId=T3.PlazaId
			LEFT JOIN SubRegiones AS T5 ON T5.SubRegionId=T4.SubRegionId
			LEFT JOIN Regiones AS T6 ON T6.RegionId=T5.RegionId
			LEFT JOIN CorreosEmpleados AS T7 ON T7.EmpleadoId=T1.EmpleadoId
			WHERE T1.EmpleadoId>1 AND DATE_FORMAT(FechaNacimiento, '%m')=DATE_FORMAT(CURDATE(), '%m')
			ORDER BY DATE_FORMAT(FechaNacimiento, '%d'), PuntoVenta
			) AS T0
			";
		return $this->Consulta($Q0);
	}

function getReporteImss()
{
	$Venta=$this->getClasificacionVenta();

	$Filtro=$this->getFiltro(1);
				$MisPuntos=$this->getMisPuntos();
				$Q0="SELECT 'NUM DE CONTROL',
						       'REGION',
						       'SUBREGION',
						       'PLAZA',
						       'PUNTO VENTA',
						       'PUESTO',
						       'NOMBRE',
						       'FECHA DE INGRESO',
						       'FECHA DE BAJA',
						       'FECHA DE SOLICITUD ALTA',
						       'FECHA ALTA IMSS',
						       'FECHA DE SOLICITUD BAJA',
						       'FECHA BAJA IMSS',
						       'OPERADORA',
						       'FINIQUITO',
						       'MOTIVO DE BAJA',
						       'OBSERVACIONES',
						       'ESTATUS'
						UNION ALL
						SELECT T1.EmpleadoId,
						       Region,
						       SubRegion, Plaza, PuntoVenta, Puesto, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Empleado,
						       DATE_FORMAT(T11.FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(T11.FechaBaja, '%d/%m/%Y') AS FechaBaja,
						       DATE_FORMAT(T14.FechaSolicitud, '%d/%m/%Y') AS FechaSolicitudAlta,
						       DATE_FORMAT(T14.Fecha, '%d/%m/%Y') AS FechaAltaIMSS,
						       DATE_FORMAT(T16.FechaSolicitud, '%d/%m/%Y') AS FechaSolicitudBaja,
						       DATE_FORMAT(T16.Fecha, '%d/%m/%Y') AS FechaBajaIMSS,
						       T2.Operador, T2.Finiquito, CausaBaja, T3.ObservacionesTH,
						       IF(T12.CausaBajaId IS NULL, 'ACTIVO', 'INACTIVO')
						FROM
						(
						  SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId
						  FROM HistorialPuestosEmpleados
						  GROUP BY EmpleadoId
						) AS T1
						INNER JOIN HistorialPuestosEmpleados AS T2 ON T2.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
						INNER JOIN Empleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						INNER JOIN Puestos AS T4 ON T4.PuestoId=T2.PuestoId
						INNER JOIN (
						            SELECT MAX(HistorialPuntosEmpleadoId) AS HistorialPuntosEmpleadoId, EmpleadoId
						            FROM HistorialPuntosEmpleados
						            WHERE Fisico=1
						            GROUP BY EmpleadoId
						           ) AS T5 ON T5.EmpleadoId=T1.EmpleadoId
						INNER JOIN HistorialPuntosEmpleados AS T6 ON T6.HistorialPuntosEmpleadoId=T5.HistorialPuntosEmpleadoId
						INNER JOIN PuntosVenta AS T7 ON T7.PuntoVentaId=T6.PuntoVentaId
						INNER JOIN Plazas AS T8 ON T8.PlazaId=T7.PlazaId
						INNER JOIN SubRegiones AS T9 ON T9.SubRegionId=T8.SubRegionId
						LEFT JOIN Regiones AS T10 ON T10.RegionId=T9.RegionId
						INNER JOIN (
						            SELECT T1.EmpleadoId, T2.FechaBaja, T4.FechaAlta
						            FROM
						            (SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId
						             FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId) AS T1
						            LEFT JOIN HistorialPuestosEmpleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId AND T2.HistorialPuestoEmpleadoId>=T1.HistorialPuestoEmpleadoId
						            LEFT JOIN (SELECT MIN(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId
						            			FROM HistorialPuestosEmpleados  GROUP BY EmpleadoId
						            		  ) AS T3 ON T3.EmpleadoId=T1.EmpleadoId
						            LEFT JOIN HistorialPuestosEmpleados AS T4 ON T4.HistorialPuestoEmpleadoId=T3.HistorialPuestoEmpleadoId
						            LEFT JOIN SubCategorias AS T5 ON T5.SubCategoriaId=T2.SubCategoriaId
						            GROUP BY T1.EmpleadoId
								   ) AS T11 ON T11.EmpleadoId=T1.EmpleadoId
						LEFT JOIN CausasBaja AS T12 ON T12.CausaBajaId=T2.CausaBajaId
						LEFT JOIN (
						           SELECT MAX(HistorialEmpleadoImss) AS HistorialEmpleadoImss, EmpleadoId
						           FROM HistorialEmpleadosImss
						           WHERE Concepto='A'
						           GROUP BY EmpleadoId
						           ) AS T13 ON T13.EmpleadoId=T1.EmpleadoId
						LEFT JOIN HistorialEmpleadosImss AS T14 ON T14.HistorialEmpleadoImss=T13.HistorialEmpleadoImss
						LEFT JOIN (
						           SELECT MAX(HistorialEmpleadoImss) AS HistorialEmpleadoImss, EmpleadoId
						           FROM HistorialEmpleadosImss
						           WHERE Concepto='B'
						           GROUP BY EmpleadoId
						           ) AS T15 ON T15.EmpleadoId=T1.EmpleadoId
						LEFT JOIN HistorialEmpleadosImss AS T16 ON T16.HistorialEmpleadoImss=T15.HistorialEmpleadoImss
						WHERE ClasificacionPersonalVenta IN ($Venta) AND T7.PuntoVentaId IN ($MisPuntos) AND $Filtro
					 GROUP BY T1.EmpleadoId
					";
				return	$this->Consulta($Q0);
}

function getVentaTP($Folio)
{
	$Q0="SELECT
		       DATE_FORMAT(FechaContrato, '%d/%m/%Y') AS FechaContrato,
		       DATE_FORMAT(FechaInstalacion, '%d/%m/%Y') AS FechaInstalacion,
		       VendedorId,
		       CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno) AS Vendedor,
		       CoordinadorId,
		       CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno) AS Coordinador,
		       T1.ClienteId,
		       CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno) AS Cliente,
		       T6.RFC,
		       T1.TPEstatusId,
		       T1.PlazoId,
		       Pvs,
		       PuntoVenta, T1.PuntoVentaId,
		       Observaciones
		FROM TPVentas AS T1
		LEFT JOIN PuntosVenta AS T2 ON T2.PuntoventaId=T1.PuntoVentaId
		LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.HistorialPuestoEmpleadoId=T1.VendedorId
		LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
		LEFT JOIN Empleados AS T5 ON T5.EmpleadoId=T1.CoordinadorId
		LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
		WHERE Folio='$Folio'";
		return mysql_fetch_row($this->Consulta($Q0));
}

function actualizaTPVta($PuntoVentaId, $Folio, $PlazoId, $EstatusId, $FechaContrato, $FechaInstalacion, $ClienteId, $VendedorId, $CoordinadorId, $Comentarios, $Pvs)
{
	$FechaContrato=$this->CambiarFormatoFecha($FechaContrato);

		if($FechaInstalacion=='00-00-0000')
			$FechaInstalacion='0000-00-00';
		else
		$FechaInstalacion=$this->CambiarFormatoFecha($FechaInstalacion);

	$Q0="UPDATE TPVentas
			SET PuntoVentaId=$PuntoVentaId,
			PlazoId=$PlazoId,
			TPEstatusId=$EstatusId,
			FechaContrato='$FechaContrato',
			FechaInstalacion='$FechaInstalacion',
			ClienteId=$ClienteId,
			VendedorId=$VendedorId,
			CoordinadorId=$CoordinadorId,
			Observaciones='$Comentarios',
			Pvs='$Pvs'
			WHERE Folio='$Folio'";

	$this->StartTransaccion();

	 if($this->Consulta($Q0) & $this->addBitacora(41, 5, $Folio, '', ''))
		{
			$this->AceptaTransaccion();
			return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
		}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function getReporteVentasTP()
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT 'RegistroId', 'Vendedor', 'Fecha Contrato', 'Folio', 'Cliente', 'Estatus', 'Fecha Instalacion', 'Descripcion', 'Precio',
        'Coordinador', 'Plazo', 'Pvs', 'PuntoVenta', 'Observaciones'
			UNION ALL
			SELECT RegistroId,
					       CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno) AS Vendedor,
					       DATE_FORMAT(FechaContrato, '%d/%m/%Y') AS FechaContrato,
			           T1.Folio,
			           CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno) AS Cliente,
					       TPEstatus,
					       DATE_FORMAT(FechaInstalacion, '%d/%m/%Y') AS FechaInstalacion,
			           Descripcion, CONCAT('$',FORMAT(Precio,2)),
					       CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno) AS Coordinador,
					       Plazo,
					       Pvs,
					       PuntoVenta,
					       Observaciones
					FROM TPVentas AS T1
					LEFT JOIN PuntosVenta AS T2 ON T2.PuntoventaId=T1.PuntoVentaId
					LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.HistorialPuestoEmpleadoId=T1.VendedorId
					LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
					LEFT JOIN Empleados AS T5 ON T5.EmpleadoId=T1.CoordinadorId
					LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
			    LEFT JOIN TPVentasLineas AS T7 ON T7.Folio=T1.Folio
			    LEFT JOIN TPEstatus AS T8 ON T8.TpEstatusId=T1.TPEstatusId
			    LEFT JOIN Plazos AS T9 ON T9.PlazoId=T1.PlazoId
			    LEFT JOIN TPProductos AS T10 ON T10.ProductoId=T7.ProductoId
			    WHERE T1.PuntoVentaId IN ($MisPuntos)
			";
			return $this->Consulta($Q0);

}


function getInfoBloqueo($Serie)
{
	if($Serie=="")
		return '';

	$Q0="SELECT COUNT(EquipoId) FROM Inventario WHERE Serie='$Serie'";
	list($Cta1)=mysql_fetch_row($this->Consulta($Q0));
	if($Cta1==0)
	{
		$Q1="SELECT COUNT(Serie), IFNULL(Clave,0) FROM Lectura WHERE Serie='$Serie'";
		list($Cta2, $Clave)=mysql_fetch_row($this->Consulta($Q1));
		if($Cta2>0)
			return 'El bloqueo se presenta en la recepcion de mercacia con la clave de movimiento '.$Clave;
	}

	$Q2="SELECT COUNT(Serie) FROM Disponibles WHERE Serie='$Serie'";
	list($Cta3)=mysql_fetch_row($this->Consulta($Q2));
	if($Cta3>0)
	{
		$Q3="SELECT COUNT(RegistroId), Folio, Estatus FROM LFolios AS T1
			INNER JOIN Estatus AS T2 ON T2.EstatusId=T1.EstatusId
			WHERE Serie='$Serie'
			ORDER BY RegistroId DESC";
		list($Cta4, $Folio, $Estatus)=mysql_fetch_row($this->Consulta($Q3));
		if($Cta4>0)
			return 'Esta serie se encuentra capturada en el folio '.$Folio.' con el estatus de '.$Estatus;
		else
		{
			$Q5="SELECT IFNULL(PuntoVentaId,0), EquipoId FROM Inventario AS T1
				LEFT JOIN(
				            SELECT T1.MovimientoId, PuntoVentaId FROM Recepciones AS T1
				            UNION
				            SELECT MovimientoId, PuntoVentaIdO FROM TRSalidas
				            UNION
				            SELECT MovimientoId, PuntoVentaId FROM HFolios WHERE MovimientoId>0
				        ) AS T2 ON T2.MovimientoId=T1.MovimientoId
				WHERE Serie='$Serie'
				ORDER BY T1.MovimientoId DESC
        		LIMIT 1
				";
		list($PuntoVentaId, $EquipoId)=mysql_fetch_row($this->Consulta($Q5));
		if(!isset($PuntoVentaId))
		$PuntoVentaId=0;

		$Q6="SELECT T4.Fecha, T1.Serie
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=3
			LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Serie AND T3.Cantidad=0
			INNER JOIN Recepciones AS T4 ON T4.MovimientoId=T3.MovimientoId AND T4.TipoMovimientoId=1
			WHERE  T1.Serie='$Serie' AND T2.PuntoventaId = $PuntoVentaId
		UNION
			SELECT  T2.Fecha, T1.Serie
			FROM Inventario AS T1
			LEFT JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=1
			WHERE EquipoId IN(SELECT EquipoId FROM Inventario WHERE Serie='$Serie')
            AND PuntoventaId =$PuntoVentaId";
         list($Fecha, $SerieDisponible)=mysql_fetch_row($this->Consulta($Q6));
         if($SerieDisponible==$Serie)
			return 'Se trata de un bloqueo por perdida de comunicacion con el servidor al momento de realizar traspaso';
		else
			return 'Se trata de un problema de PEPS, favor de ingresar una de las series que se muestran disponibles en la primera tabla';

		}
	}

	$Q7="SELECT COUNT(EquipoId) FROM Inventario WHERE SERIE='$Serie' AND Cantidad>0";
	list($Cta6)=mysql_fetch_row($this->Consulta($Q7));
	if($Cta6>0)
	return 'No se encuentra ningun bloqueo sobre esta serie';
	else
	return 'No se tiene existencia de este articulo';

}

function desbloquearLecturaRecepcion($Clave)
{
	$Q0="DELETE FROM Lectura WHERE Clave=$Clave";
		if($this->Consulta($Q0))
		return utf8_decode('<span class="notificacion">¡La peticion se proceso satisfactoriamente!</span>');
	return utf8_decode('<span class="alerta">¡No fue posible realizar la operacion!</span>');

}

function getTablaImportacion()
{
	$Q0="SELECT 'Opciones', 'Documento', 'Descripcion'
		UNION ALL
		SELECT CONCAT('asistenteImprtar(',T1.DatoId,',3);') AS Opcion, Dato, Descripcion
		FROM ImportarDatos AS T1
		INNER JOIN ImportacionUsuarios AS T2 ON T2.DatoId=T1.DatoId
		WHERE Activo=1 AND T2.UsuarioId=$this->UsuarioId";
	return $this->Consulta($Q0);
}

function getTemplatename($DatoId)
{
	$Q0="SELECT Dato, Template FROM ImportarDatos WHERE DatoId=$DatoId";
	return mysql_fetch_row($this->Consulta($Q0));

}

function getHistorialImss($EmpleadoId)
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT HistorialEmpleadoImss, DATE_FORMAT(FechaSolicitud, '%d/%m/%Y'), DATE_FORMAT(Fecha, '%d/%m/%Y'), SalarioDiarioIntegrado, IF(Concepto='A', 'ALTA', 'BAJA')
		 FROM HistorialEmpleadosImss WHERE EmpleadoId=$EmpleadoId";

	return $this->Consulta($Q0);
}

function importaLayout($DatoId, $ClaveTemp)
{

	$Q1="LOAD DATA LOCAL INFILE 'FilesTmp/$ClaveTemp.csv' INTO TABLE TemOrdenCompra
		 FIELDS TERMINATED BY ','LINES TERMINATED BY '\r\n' IGNORE 1 LINES
		(@ClavePunto, @SKU, @Factura, @Serie,@Sim, @almacen, @plataforma)
   		 SET
   		 ClavePunto=IFNULL((SELECT ClavePunto FROM PuntosVenta WHERE PuntoVentaId=@ClavePunto LIMIT 1),'INDEFINIDO'),
		 EquipoId=IFNULL((SELECT EquipoId FROM Equipos WHERE EquipoId=LEFT(@SKU,5) LIMIT 1),'INDEFINIDO'),
		 Factura=IF(@Factura='','INDEFINIDO',@Factura),
		 Serie=IF(@Serie='','INDEFINIDO',@Serie),
		 Sim=@Sim,
		 ClaveTemp='$ClaveTemp',
		 AlmacenId='@almacen',
		 PlataformaId='@plataforma'
		 ";

	$Q2="SELECT COUNT(Factura) FROM TemOrdenCompra WHERE ClaveTemp='$ClaveTemp'";


	$this->Consulta($Q1);


}

function responderEncuesta($RespuestaId, $RespuestaTxt)
{
	$Q0="INSERT IGNORE INTO RespuestasUsuarios (RespuestaId, RespuestaTxt, UsuarioId)
	 	 VALUES ($RespuestaId, '$RespuestaTxt', $this->UsuarioId)";
	$this->Consulta($Q0);

	$Q1="SELECT COUNT(RespuestaId) AS CTA FROM RespuestasUsuarios WHERE RespuestaId=1";
	$Q2="SELECT COUNT(RespuestaId) AS CTA FROM RespuestasUsuarios WHERE RespuestaId=2";

	list($Si)=mysql_fetch_row($this->Consulta($Q1));
	list($No)=mysql_fetch_row($this->Consulta($Q2));

	return $Si.','.$No;

}

function getResultadosEncuesta()
{

	$Q1="SELECT COUNT(RespuestaId) AS CTA FROM RespuestasUsuarios WHERE RespuestaId=1";
	$Q2="SELECT COUNT(RespuestaId) AS CTA FROM RespuestasUsuarios WHERE RespuestaId=2";

	list($Si)=mysql_fetch_row($this->Consulta($Q1));
	list($No)=mysql_fetch_row($this->Consulta($Q2));

	return $Si.','.$No;

}


function Participo($EncuestaId)
{
	$Q0="SELECT COUNT(T1.RespuestaId) AS CTA FROM RespuestasUsuarios AS T1
		INNER JOIN EncuestaRespuestas AS T2 ON T2.RespuestaId=T1.RespuestaId
		INNER JOIN EncuestaPreguntas AS T3 ON T3.PreguntaId=T2.PreguntaId
		WHERE EncuestaId=$EncuestaId AND UsuarioId=$this->UsuarioId";

	list($Cta)=mysql_fetch_row($this->Consulta($Q0));

	if($Cta==0)
		return 'N';
	return 'Y';

}

function getHeadTabla($ModuloId)
{
	//Orden de los campos (Campo, Tipo, Alias, Tipo_Filtro, Tamaño)
	switch ($ModuloId)
	{
			case '10':
				$campos = array(
								array("Id", "number", "#Control", "number", "10%"),
								array("Modulo", "string", "Modulo", "textbox", "10%"),
								array("Img", "string", "Imagen", "textbox", "15%"),
								array("Url", "string", "Url", "textbox", "15%"),
								array("Familia", "string", "Familia", "checkedlist", "10%"),
								);
				break;
			default:
				$campos=array();
				break;
	}
	return $campos;
}

function EntregaUniformes($FechaEntrega, $EmpleadoId, $Comentario, $Clave){
	$FechaEntrega=$this->CambiarFormatoFecha($FechaEntrega);
	$Q0="INSERT INTO EntregaUniformesH (EntregaUniformeId, UsuarioId, Fecha, EmpleadoId, FechaEntrega, Comentario)
		 VALUES(NULL, $this->UsuarioId, CURDATE(), $EmpleadoId, '$FechaEntrega', '$Comentario')";

		 $this->StartTransaccion();
		 if($this->Consulta($Q0))
		 {
		 	$EntregaUniformeId=mysql_insert_id();
		 	$Q1="INSERT INTO EntregaUniformesL
				 SELECT NULL, $EntregaUniformeId, UniformeId, Color, Talla, Cantidad
				 FROM EntregaUniformesLTemporal WHERE Clave='$Clave'";

				if($this->Consulta($Q1))
				{
					$this->AceptaTransaccion();
					return utf8_decode('<span class="notificacion">¡El registro se realizo satisfactoriamente!</span>');
				}
		}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function getListaPersonas()
	{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla2" >
					<thead>
						<tr>
							<th>#Control</th>
							<th>Nombre</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Nombre
				FROM HistorialPuestosEmpleados AS T1
				INNER JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				WHERE FechaBaja='0000-00-00' AND T1.EmpleadoId>1
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,9)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function AddLineaUniforme($Clave, $UniformeId, $Color, $Talla, $Cantidad)
{
	$Q0="INSERT INTO EntregaUniformesLTemporal (RegistroId, Clave, UniformeId, Color, Talla, Cantidad)
		 VALUES(NULL, '$Clave', $UniformeId, '$Color', '$Talla', $Cantidad)";

	if($this->Consulta($Q0))
	return $this->getListaDetalleUniforme($Clave);
		else
	return utf8_decode('<span class="alerta">¡No se realizo el registro! Intentalo nuevamente</span>');

}

function getListaDetalleUniforme($Clave)
{	$Cta=0;
	$Mte=0;
		$Cadena='<table id="MiTablaL" >
					<thead>
						<tr>
							<th>Tipo de Prenda</th>
							<th>Color</th>
							<th>Talla</th>
							<th>Cantidad</th>
							<th>Eliminar</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT RegistroId, Uniforme, Color, Talla, Cantidad FROM EntregaUniformesLTemporal AS T1
				INNER JOIN Uniformes AS T2 ON T2.UniformeId=T1.UniformeId
				WHERE Clave='$Clave'
		  ";

		$R0=$this->Consulta($Q0);

		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$A0[0].','.$Clave.',7)" /></td>
						</tr>
				';
			$t=(!$t);
		}
		$Q1="SELECT COUNT(RegistroId) AS Cta FROM EntregaUniformesLTemporal WHERE Clave='$Clave'";
		list($Cta)=mysql_fetch_row($this->Consulta($Q1));

				$Cadena.='</tbody>
						</table>
						<input type="hidden" name="NoLineas" id="NoLineas" value="'.$Cta.'" />
						';
		return $Cadena;
	}

	function removeLineaUniforme($RegistroId, $Clave)
	{
		$Q0="DELETE FROM EntregaUniformesLTemporal WHERE RegistroId=$RegistroId";
		$this->Consulta($Q0);

		return $this->getListaDetalleUniforme($Clave);
	}


	function cargarDatos($Template, $file)
	{
		switch ($Template) {
			case '1':
					$Q0="LOAD DATA LOCAL INFILE './FilesTmp/$file'
						 INTO TABLE TemOrdenCompra
						 FIELDS TERMINATED BY ','LINES TERMINATED BY '\r\n'
						 IGNORE 1 LINES
							(@ClavePunto, @EquipoId, @Factura, @Serie, @Sim, @Costo, @Iva, @Descuento, @FFactura, @almacen, @plataforma)
						 SET ClavePunto =(SELECT  IF(COUNT(PuntoVentaId)=0,'COD-DIR INVALIDO!', IF(Activo=0,'PUNTO INACTIVO!', PuntoVentaId)) AS Resultado
										  FROM PuntosVenta WHERE ClavePunto=@ClavePunto),
							 EquipoId=(SELECT IF(COUNT(EquipoId)=0,'SKU INVALIDO!', IF(Activo=0,'EQUIPO INACTIVO!', EquipoId)) AS Resultado
									   FROM Equipos WHERE EquipoId=LEFT(@EquipoId,5)),
			 				 Factura=IF(@Factura='','INDEFINIDO!',@Factura),
		 				     Serie=(SELECT IF(COUNT(EquipoId)>0,'DUPLICADO!',IF(LENGTH(@Serie) NOT IN (15,20),'NO VALIDO!',@Serie)) AS Cta FROM OrdenesCompra WHERE Serie=@Serie),
			 				 Sim=@Sim,
			 				 Costo=@Costo,
			 				 Iva=@Iva,
			 				 Descuento=@Descuento,
			 				 FechaFactura=@FFactura,
			 				 ClaveTemp='$file',
			 				 RegistroId=NULL,
			 				 AlmacenId=@almacen,
			 				 PlataformaId=@plataforma
						 ";
					$this->Consulta($Q0);
					return $this->actualizaOrdenCompra($file);
				break;
			case '3':
					$Q0="LOAD DATA LOCAL INFILE './FilesTmp/$file'
						 INTO TABLE TempNextel
						 FIELDS TERMINATED BY ','LINES TERMINATED BY '\r\n'
						 IGNORE 1 LINES
							(@Imei, @Plan, @OrdenContratacion, @Modelos, @NuevoEstatus, @FechaActivacion,
							 @Folio, @Clave, @RegistroId
							)
						 SET Imei=@Imei,
						 	 NombrePlan=@Plan,
							 OrdenContratacion=@OrdenContratacion,
							 Modelos=@Modelos,
							 NuevoEstatus=@NuevoEstatus,
							 FechaActivacion=(SELECT CONCAT(RIGHT(@FechaActivacion,4),'-',LEFT(RIGHT(@FechaActivacion,7),2), '-',LEFT(@FechaActivacion,2))),
							 Folio=LEFT(@OrdenContratacion,12),
							 ContratacionId=(SELECT IFNULL(ContratacionId,0) FROM Contrataciones WHERE Contratacion=RIGHT(@OrdenContratacion,LENGTH(@OrdenContratacion)-12)),
			 				 Clave='$file',
			 				 RegistroId=NULL
						 ";
					$this->Consulta($Q0);
					$Q1="UPDATE HFolios AS T1
							INNER JOIN TempNextel AS T2 ON T2.Folio=TRIM(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(T1.Folio,'REN',''),'PT',''),'PPL',''),'NOR',''),'LIT',''),'FP',''))
							SET T1.ContratacionId=T2.ContratacionId,
							T1.FechaSS=T2.FechaActivacion,
							T1.Validado=1,
							T1.Folio=T2.Folio
							WHERE T2.Clave='$file'";
					$Q2="UPDATE LFolios AS T1
						INNER JOIN TempNextel AS T2 ON T2.Folio=T1.Folio
						SET T1.EstatusId=8
						WHERE T2.Clave='$file' AND NuevoEstatus LIKE '%Envios%'";
					$this->Consulta($Q1);
					$this->Consulta($Q2);
					return $this->comparaVentaNextel($file);
				break;
			case '4':
					$Q0="LOAD DATA LOCAL INFILE './FilesTmp/$file'
						 INTO TABLE Suspendidos
						 FIELDS TERMINATED BY ','LINES TERMINATED BY '\r\n'
						 IGNORE 1 LINES
						 ";
					$this->Consulta($Q0);
					return 'El base se cargo correctamente';
				break;

		}

	}

	function comparaVentaNextel($clave)
	{


		$Q0="SELECT Folio
			 FROM TempNextel WHERE Clave='$clave' AND Folio!=''
			 GROUP BY Folio";
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			$Q1="SELECT NombrePlan, Modelos, Imei
				FROM TempNextel AS T1
				WHERE T1.Folio='$A0[0]' AND Clave='$clave'
				ORDER BY T1.Folio, NombrePlan, Modelos ";

			$Q2="SELECT TRIM(CONCAT(Plan, ' ', IFNULL(GROUP_CONCAT(AddOnTxt SEPARATOR ' ' ),''))) Plan,
						DescripcionNextel, T1.RegistroId, CONCAT_WS(' ', T7.Nombre, T7.Paterno, T7.Materno), Contratacion
	      FROM LFolios AS T1
	      INNER JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
	      LEFT JOIN LineasAddon AS T3 ON T3.RegistroId=T1.RegistroId
	      LEFT JOIN Addon AS T4 ON T4.AddonId=T3.AddOnId
	      INNER JOIN Equipos AS T5 ON T5.EquipoId=T1.EquipoId
	      INNER JOIN HFolios AS T6 ON T6.Folio=T1.Folio
	      INNER JOIN Clientes AS T7 ON T7.ClienteId=T6.ClienteId
	      LEFT JOIN Contrataciones AS T8 ON T8.ContratacionId=T6.ContratacionId
	      WHERE T1.Folio='$A0[0]'
	      GROUP BY T1.RegistroId
	      ORDER BY T1.Folio, CONCAT(Plan, ' ', IFNULL(GROUP_CONCAT(AddOnTxt SEPARATOR ' ' ),'')), DescripcionNextel";
		$R1=$this->Consulta($Q1);
		$R2=$this->Consulta($Q2);
		$F1=mysql_num_rows($R1);
		$F2=mysql_num_rows($R2);

		if($F1>=$F2)
			$t=$F1;
		else
			$t=$F2;

	    //while($A1=mysql_fetch_row($R1) || $A2=mysql_fetch_row($R2))
		for($i=0; $i<$t;$i++)
	     	{
	     		$PlanDav=mysql_result($R1, $i, 0);
	     		$PlanSiiga=mysql_result($R2, $i, 0);

	     		$EquipoDav=mysql_result($R1, $i, 1);
	     		$EquipoSiiga=mysql_result($R2, $i, 1);

     			$Imei=mysql_result($R1, $i, 2);
	     		$Registro=mysql_result($R2, $i, 2);
	     		$Cliente=mysql_result($R2, $i, 3);
	     		$Contratacion=mysql_result($R2, $i, 4);

				if(!isset($PlanDav))
					$PlanDav='';

				if(!isset($PlanSiiga))
					$PlanSiiga='';

	     		if(!isset($EquipoDav))
					$EquipoDav='';

				if(!isset($EquipoSiiga))
					$EquipoSiiga='';

	     		if(!isset($Imei))
					$Imei='';

				if(!isset($Registro))
					$Registro=0;

	     		if($this->getPlanDav($PlanDav)!=strtoupper(str_replace(' ', '', str_replace('PRIP', '', $PlanSiiga))))
	     			$Plan='No Coincide';
	     		else
	     			$Plan='';
	     		if($EquipoDav!=$EquipoSiiga)
	     			$Modelo='No Coincide';
	     		else
	     			$Modelo='';

	     		$Q3="INSERT INTO ComparativoNextel (Folio, Cliente, Contratacion, Imei, PlanDav, ModeloDav, PlanSiiga, ModeloSiiga, RegistroId, Clave, ObPlan, ObEquipo)
					VALUES('$A0[0]', '$Cliente', '$Contratacion', '\'$Imei', '$PlanDav', '$EquipoDav', '$PlanSiiga', '$EquipoSiiga', '$Registro', '$clave', '$Plan', '$Modelo')";
				$this->Consulta($Q3);
	     	}
		}

		return "Se actualizaron las fechas de activacion y tipos de contratacion de los registros coincidentes
				<span class=\"leyenda\" onclick=\"openLink('ExportaResultados.php?clave=".$clave."&tmp=3')\">Ver Resultados de diferencias</span>";
	}

	function getPlanDav($Plan)
	{
		$Plan=str_replace('CPP', '', $Plan);
		$Plan=str_replace(' P', '', $Plan);
		$Plan=str_replace('PRIP', '', $Plan);
		$Plan=str_replace('RSI', '', $Plan);
		$Plan=str_replace('QCHAT', '', $Plan);
		$Plan=str_replace(' ', '', $Plan);
		return strtoupper($Plan);
	}

	function actualizaOrdenCompra($clave)
	{
		$Q0="SELECT COUNT(RegistroId) AS Error
			 FROM TemOrdenCompra
			 WHERE (ClavePunto LIKE '%!' OR EquipoId LIKE '%!' OR Factura LIKE '%!'  OR Serie LIKE '%!')
			 AND ClaveTemp='$clave'";

		list($Cta)=mysql_fetch_row($this->Consulta($Q0));
		if($Cta>0)
			return "Existen datos inconsistentes en el archivo, no es posible registrar la informacion <span class=\"leyenda\" onclick=\"openLink('ExportaResultados.php?clave=".$clave."&tmp=1')\">Ver Resultados</span>";
		else
		{
			$this->StartTransaccion();
			$Q1="INSERT IGNORE INTO OrdenesCompra
					SELECT ClavePunto, EquipoId, Factura, Serie, Sim, 0, CURDATE(), CURTIME(), $this->UsuarioId, Costo, Iva, Descuento, FechaFactura,0, AlmacenId, PlataformaId FROM TemOrdenCompra WHERE ClaveTemp='$clave'";
			$Q2="INSERT IGNORE INTO FacturasEquipos
				 SELECT Factura, FechaFactura, '' FROM TemOrdenCompra WHERE ClaveTemp='$clave' GROUP BY Factura";

			if($this->Consulta($Q1) & $this->Consulta($Q2))
			{
				$this->AceptaTransaccion();
				return 'Se cargaron los registros satisfactoriamente';
			}
			$this->CancelaTransaccion();
			return 'No fue posible cargar los datos';
		}
	}


	function getResultados($tmp, $Clave)
	{
		switch ($tmp) {
			case '1':
				$Q0="SELECT 'PuntoVenta', 'Equipo', 'Factura', 'Serie'
						UNION ALL
						SELECT ClavePunto, EquipoId, Factura, Serie
						FROM TemOrdenCompra
						WHERE ClaveTemp='$Clave'";
				break;
			case '3':
				$Q0="SELECT 'Folio', 'Cliente','Contratacion','Imei', 'Plan Dav', 'Modelo Dav', 'Plan Siiga', 'Modelo Siiga', '#Registro', 'Observacion Plan', 'Observacion Equipo',
							'Cambiar Folio', 'Cambiar Folio Registro', 'Eliminar Registro', 'cambiar Plan', 'Cambiar vendedor'
				UNION
					SELECT Folio, Cliente, Contratacion, Imei, PlanDav, ModeloDav, PlanSiiga, ModeloSiiga, RegistroId, ObPlan, ObEquipo,
							'', '', '', '', ''
					FROM ComparativoNextel
					WHERE Clave='$Clave'
					";
			break;
		}
		return $this->Consulta($Q0);
	}

	function getListaODC($PuntoVentaId)
	{
		$Cadena='<table id="MiTabla6" >
					<thead>
						<tr>
							<th>#Factura</th>
							<th>Fecha</th>
							<th>Punto de Venta</th>
							<th>Articulo</th>
							<th>Recibidos</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT Factura, FechaFactura, PuntoVenta, Articulos, Recibido
				FROM
				    (
				      SELECT Factura, DATE_FORMAT(FechaFactura,'%d/%m/%Y') AS FechaFactura, PuntoVenta, COUNT(EquipoId) AS Articulos,  SUM(Recibido) AS Recibido
				      FROM OrdenesCompra AS T1
				      INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
				      WHERE T1.PuntoVentaId=$PuntoVentaId
				      GROUP BY Factura
				    ) AS T1
				WHERE Articulos-Recibido>0";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="EquipoId" id="EquipoId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,10)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function LeerSerieFactura($Serie, $Factura, $Clave)
{
	$Q0="SELECT COUNT(T1.EquipoId), IFNULL(T1.EquipoId,0), IF(T2.Serie IS NULL, 0,1), T1.AlmacenId, T1.PlataformaId FROM OrdenesCompra AS T1
		 LEFT JOIN Lectura AS T2 ON T2.Serie=T1.Serie
		 WHERE Factura='$Factura'
		 AND T1.Serie='$Serie'";

	list($Cta, $EquipoId, $Recibido, $AlmacenId, $PlataformaId)=mysql_fetch_row($this->Consulta($Q0));

	if($Cta==0)
	{
		$Q1="INSERT IGNORE INTO LecturaInvalida (Factura, Serie, UsuarioId, Fecha, Hora)
			VALUES('$Factura', '$Serie', $this->UsuarioId, CURDATE(), CURTIME())";
		$this->Consulta($Q1);
		return 'Invalido';
	}
	if($EquipoId>0 & $Recibido==0)
	return $this->addLectura($Serie, $Clave, $EquipoId, $AlmacenId, $PlataformaId);
	if($Recibido==1)
	return 'Existe';
}

function getFactPendientesPorRecibir()
{
	$Venta=$this->getClasificacionVenta();
	$MisPuntos=$this->getMisPuntos();
/*
	$Q0="SELECT 'Canal de Venta', 'Punto Venta', 'Factura', 'Fecha Factura', 'Equipo', 'Serie', 'Cantidad'
			UNION
			SELECT T5.ClasificacionPersonalVenta, PuntoVenta, T1.Factura, DATE_FORMAT(FechaFactura, '%d/%m/%Y') AS FechaFactura, Equipo, CONCAT('\'',Serie) AS Serie, Cantidad
			FROM OrdenesCompra AS T1
			INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			INNER JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
			INNER JOIN (SELECT Factura, COUNT(EquipoId) AS Cantidad FROM OrdenesCompra GROUP BY Factura) AS T4 ON T4.Factura=T1.Factura
			LEFT JOIN ClasificacionPersonalVenta AS T5 ON T5.ClasificacionPersonalVentaId=T2.ClasificacionpersonalVenta
			WHERE Recibido=0 AND T1.PuntoVentaId IN ($MisPuntos) AND T2.ClasificacionPersonalVenta IN ($Venta)
			GROUP BY T1.Serie";
*/
		$Q0="SELECT 'Canal de Venta', 'Region','Punto Venta', 'Factura', 'Fecha Factura', 'Marca', 'Equipo', 'Serie', 'Cantidad', 'Almacen', 'Plataforma'
			UNION
			SELECT T5.ClasificacionPersonalVenta, Region, PuntoVenta, T1.Factura, DATE_FORMAT(FechaFactura, '%d/%m/%Y') AS FechaFactura, Marca, Equipo, CONCAT('\'',Serie) AS Serie, Cantidad,
			T10.Almacen, T11.Plataforma
			FROM OrdenesCompra AS T1
			INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			INNER JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
			INNER JOIN (SELECT Factura, COUNT(EquipoId) AS Cantidad FROM OrdenesCompra GROUP BY Factura) AS T4 ON T4.Factura=T1.Factura
			LEFT JOIN ClasificacionPersonalVenta AS T5 ON T5.ClasificacionPersonalVentaId=T2.ClasificacionpersonalVenta
			LEFT JOIN Plazas AS T6 ON T6.PlazaId=T2.PlazaId
			LEFT JOIN SubRegiones AS T7 ON T7.SubRegionId=T6.SubRegionId
			LEFT JOIN Regiones AS T8 ON T8.RegionId=T7.RegionId
			LEFT JOIN Marcas AS T9	ON T9.MarcaId=T3.MarcaId
			LEFT JOIN Almacenes AS T10 ON T10.AlmacenId=T1.AlmacenId
			LEFT JOIN Plataformas AS T11 ON T11.PlataformaId=T1.PlataformaId
			WHERE Recibido=0 AND T1.PuntoVentaId IN ($MisPuntos) AND T2.ClasificacionPersonalVenta IN ($Venta)
			GROUP BY T1.Serie
		";

		return $this->Consulta($Q0);
}


/************************ SIMULADOR *************************/

function getRangoSemanal($SimuladorId)
{
	if($SimuladorId==1)
	{
	$Q0="SELECT 'Menor a', FORMAT(LimiteInferior,0), FORMAT(0,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId
		 UNION
		 SELECT 'Mayor o Igual a', FORMAT(LimiteInferior,0), FORMAT(PagoFijoBase,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId";
	}

	if($SimuladorId==2)
	{
	$Q0="SELECT if(LimiteInferior=0,'Menor a','Mayor o Igual a'), FORMAT(if(LimiteInferior=0,5000,LimiteInferior),0), FORMAT(PagoFijoBase,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId";
	}

	if($SimuladorId==3)
	{
	$Q0="SELECT if(LimiteInferior=0,'Menor a','Mayor o Igual a'), FORMAT(if(LimiteInferior=0,3000,LimiteInferior),0), FORMAT(PagoFijoBase,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId";
	}

	if($SimuladorId==4)
	{
	$Q0="SELECT if(LimiteInferior=0,'Menor a','Mayor o Igual a'), FORMAT(if(LimiteInferior=0,3000,LimiteInferior),0), FORMAT(PagoFijoBase,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId";
	}

	if($SimuladorId==5)
	{
	$Q0="SELECT if(LimiteInferior=0,'Menor a','Mayor o Igual a'), FORMAT(if(LimiteInferior=0,12000,LimiteInferior),0), FORMAT(PagoFijoBase,0) FROM SimuladorRangoSemanal WHERE SimuladorId=$SimuladorId";
	}

	return $this->Consulta($Q0);
}

function getRangoMensual($SimuladorId)
{
	if($SimuladorId==1)
	{

	$Q0="SELECT 'Semanal','Mayor o Igual a', FORMAT(CuotaFactor,0), Factor,Factor, Factor
			FROM SimuladorVariables
		 	WHERE SimuladorId=$SimuladorId
		 UNION
		 SELECT 'Mensual', 'Mayor o Igual a', FORMAT(LimiteInferior,0), Planes18, Planes24, OtrosPlanes
		 	FROM SimuladorRangoMensual
		 	WHERE SimuladorId=$SimuladorId";
	}
	else
	$Q0="SELECT 'Semanal', 'Mayor o Igual a', FORMAT(CuotaFactor,0), CONCAT('Venta Semanal',' * ', Factor)
			FROM SimuladorVariables
		 	WHERE SimuladorId=$SimuladorId
		 UNION
		 SELECT 'Mensual', 'Mayor o Igual a', FORMAT(LimiteInferior,0), IF(Maximo>0,CONCAT('Venta Total * ',Maximo),FORMAT(OtrosPlanes,0))
			FROM SimuladorRangoMensual
			WHERE SimuladorId=$SimuladorId";

	return $this->Consulta($Q0);
}

function getFactores($SimuladorId)
{
	$Q0="SELECT Factor, FORMAT(CuotaFactor,0), FORMAT(CuotaMensual,0)
		 FROM SimuladorVariables
		WHERE SimuladorId=$SimuladorId";
	return $this->Consulta($Q0);
}
/*************************************************************/

/******************** TRASPASOS ENTRADAS SALIDAS    **************/

function addTSalidas($PuntoVentaIdO, $PuntoVentaIdD, $Comentario, $Clave)
{
	$Q0="INSERT INTO Movimientos VALUES(NULL)";
	$this->StartTransaccion();

	if($this->Consulta($Q0))
	{
		$MovimientoId=mysql_insert_id();
		$Q1="INSERT INTO TRSalidas (MovimientoId, UsuarioId, PuntoVentaIdO, PuntoVentaIdD, Fecha, Hora, Comentario, EstatusTraspasoId)
			VALUES($MovimientoId, $this->UsuarioId, $PuntoVentaIdO, $PuntoVentaIdD, CURDATE(), CURTIME(), '$Comentario', 1)";

		$Q2="UPDATE Inventario AS T1
			INNER JOIN TRLectura AS T2 ON T2.Serie=T1.Serie AND T2.Clave='$Clave'
			SET T1.Cantidad=0
			WHERE T1.Cantidad>0";

		$Q3="INSERT IGNORE INTO Inventario (EquipoId, serie, IccId, Cantidad, MovimientoId, Activacion, EnvioVSO, AlmacenId, PlataformaId)
			 SELECT T2.EquipoId, T2.Serie, T2.IccId, 1, '$MovimientoId', '0000-00-00', '0000-00-00', T2.AlmacenId, T2.PlataformaId
			 FROM TRLectura AS T1
			 LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			 WHERE T1.Clave='$Clave'
			 GROUP BY T1.Serie";

		$Q4="SELECT GROUP_CONCAT(Serie) FROM TRLectura WHERE Clave='$Clave'";
			list($Series)=mysql_fetch_row($this->Consulta($Q4));

		 if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->addBitacora(28, 2, 0, $MovimientoId,''))
		 {
		 	$this->AceptaTransaccion();
		 	return 'OK';
		 }
	}

	$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible realizar el traspaso salida!</span>');
}

function getListaOrdenesTraspasos($PuntoVentaId)
{

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>#Orden Traspaso</th>
							<th>Fecha</th>
							<th>Punto_Venta</th>
							<th>Comentario</th>
							<th>Cantidad</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
			$Q0="SELECT T1.MovimientoId, DATE_FORMAT(Fecha,'%d-%m-%Y'), PuntoVenta, Comentario, COUNT(EquipoId) AS Cantidad
			FROM TRSalidas AS T1
			INNER JOIN Inventario AS T2 ON T2.MovimientoId=T1.MovimientoId
			INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaIdO
			WHERE EstatusTraspasoId=1 AND PuntoVentaIdD=$PuntoVentaId AND T2.Cantidad>0
			GROUP BY T1.MovimientoId";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,11)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}
function ValidaSerieTEntrada($Serie,$Odt,$clave)
{
	$Q0="SELECT COUNT(Serie) AS Existe FROM Inventario where movimientoid=$Odt AND Cantidad>0 AND Serie='$Serie'";
	$Q1="SELECT COUNT(Serie) AS NoDisponible FROM TRLectura WHERE Serie='$Serie' AND Clave='$clave'";

	list($Existe)=mysql_fetch_row($this->Consulta($Q0));
	list($NoDisponible)=mysql_fetch_row($this->Consulta($Q1));

	if($Existe>0 & $NoDisponible==0)
		return 'OK';
	return 'FAIL';
}

function addTEntradas($Odt,$Comentario,$Clave, $PuntoVentaIdD){

	$Q0="INSERT INTO Movimientos VALUES(NULL)";
	$this->StartTransaccion();

	if($this->Consulta($Q0))
	{
		$MovimientoIdR=mysql_insert_id();
		$Q1="INSERT INTO Recepciones (MovimientoId, TipoMovimientoId, UsuarioId, PuntoventaId, ClaveRecepcion, Fecha, Hora, Comentario, Clave, FechaMovimiento, HoraMovimiento, ConceptoTRId)
		VALUES($MovimientoIdR, 3, $this->UsuarioId, $PuntoVentaIdD, '$Odt', CURDATE(), CURTIME(), '$Comentario', '$Clave', CURDATE(), CURTIME(),0)";

		$Q2="INSERT IGNORE INTO Inventario (EquipoId, serie, IccId, Cantidad, MovimientoId, Activacion, EnvioVSO, AlmacenId, PlataformaId)
			 SELECT T2.EquipoId, T2.Serie, T2.IccId, 1, '$MovimientoIdR', '0000-00-00', '0000-00-00', T2.AlmacenId, T2.PlataformaId
			 FROM TRLectura AS T1
			 LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			 WHERE T1.Clave='$Clave'
			 GROUP BY T1.Serie";

		$Q3="UPDATE Inventario AS T1
				INNER JOIN TRLectura AS T2 ON T2.Serie=T1.Serie AND T2.Clave='$Clave'
				SET T1.Cantidad=-1
				WHERE T1.MovimientoId=$Odt";

		$Q4="SELECT GROUP_CONCAT(Serie) FROM TRLectura WHERE Clave='$Clave'";
		list($Series)=mysql_fetch_row($this->Consulta($Q4));

		$Q5="DELETE FROM Disponibles WHERE Serie IN ('$Series')";

		 if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q5) & $this->addBitacora(29, 2, 0, $MovimientoIdR,''))
		 {
		 	$this->AceptaTransaccion();
		 	return 'OK';
		 }
	}
	$this->CancelaTransaccion();
	return utf8_decode('<span class="alerta">¡No fue posible realizar el traspaso Entrada!</span>');

}

function getMercanciaTransito()
{
	$Venta=$this->getClasificacionVenta();

	$MisPuntos=$this->getMisPuntos();

	$Q0="SELECT 'CANAL DE VENTA','#TR SALIDA', 'FECHA TRASPASO', 'ORIGEN', 'DESTINO', 'MARCA', 'EQUIPO', 'SERIE', 'ALMACEN', 'PLATAFORMA'
UNION
SELECT T6.ClasificacionPersonalVenta,T1.MovimientoId, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha,
       T3.PuntoVenta, T4.PuntoVenta, T7.Marca,Equipo, CONCAT('\'',Serie), T8.Almacen, T9.Plataforma

FROM TRSalidas AS T1
INNER JOIN Inventario AS T2 ON T2.MovimientoId=T1.MovimientoId
INNER JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaIdO
INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T1.PuntoVentaIdD
INNER JOIN Equipos AS T5 ON T5.EquipoId=T2.EquipoId
LEFT JOIN ClasificacionPersonalVenta AS T6 ON T6.ClasificacionPersonalVentaId=T3.ClasificacionpersonalVenta
LEFT JOIN Marcas AS T7	ON T7.MarcaId=T5.MarcaId
LEFT JOIN Almacenes AS T8 ON T8.AlmacenId=T2.AlmacenId
LEFT JOIN Plataformas AS T9 ON T9.PlataformaId=T2.PlataformaId
WHERE Cantidad>0 AND T3.PuntoVentaId in ($MisPuntos) AND T3.ClasificacionPersonalVenta IN ($Venta) AND
T4.ClasificacionPersonalVenta IN ($Venta)
";

return $this->Consulta($Q0);
}
/***************************************************************/

function getDatosFactura($Factura)
{
	$Q0="SELECT T1.PuntoVentaId, PuntoVenta, Comentario, Archivo FROM Recepciones AS T1
 		 INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
		 INNER JOIN FacturasEquipos AS T3 ON T3.Factura='$Factura'
		 WHERE ClaveRecepcion='$Factura'";

	return mysql_fetch_row($this->Consulta($Q0));
}

function RevisaAviso($Url)
{
	$Q0="INSERT IGNORE INTO AvisosRevision
		 SELECT AvisoId, $this->UsuarioId, CURDATE(), CURTIME() FROM Avisos
		 WHERE Url='$Url'";
	$this->Consulta($Q0);
	return 'ok';
}

function addAviso($Titulo, $Aviso, $Url, $ClasificacionAvisoId, $FInicial, $FFinal)
{
	$Q0="INSERT INTO Avisos (AvisoId, Titulo, Aviso, Url, FechaInicial, FechaFinal, UsuarioId, Privado, ClasificacionAvisoId, Activo)
			  VALUES(NULL, '$Titulo', '$Aviso', '$Url', '$FInicial', '$FFinal', $this->UsuarioId, 0, $ClasificacionAvisoId, 1)";
	$this->StartTransaccion();
	if( $this->Consulta($Q0) & $this->addBitacora(1, 2, mysql_insert_id(), 'Agrgo Aviso', ''))
	{
		$this->AceptaTransaccion();
		return 'ok';
	}

	$this->CancelaTransaccion();
	return 'fail';
}

function ScrollReclutadores($valor)
{
	$query="SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Reclutador
				FROM HistorialPuestosEmpleados AS T1
				LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				WHERE T1.FechaBaja='0000-00-00' AND T1.PuestoId IN (12,28, 44,57)
				GROUP BY T1.EmpleadoId
				ORDER BY CONCAT_WS(' ', Nombre, Paterno, Materno)
				";

		$resultado=mysql_query("$query", $this->conexion) or die(mysql_error());

		while($arreglo=mysql_fetch_row($resultado))
		{
			if ($valor==$arreglo[0])
			{
				echo "<option selected value=\"$arreglo[0]\" title=\"".utf8_decode($arreglo[1])."\" >".utf8_decode($arreglo[1])."</option> \n";
			}
			else
			{
				echo "<option value=\"$arreglo[0]\" title=\"$arreglo[1]\">".utf8_decode($arreglo[1])."</option> \n";
			}
		}
	}//Scroll

function getEmpleadoId()
{
	$Q0="SELECT EmpleadoId FROM Usuarios WHERE UsuarioId=$this->UsuarioId";
	list($EmpleadoId)=mysql_fetch_row($this->Consulta($Q0));
	return $EmpleadoId;
}

function getVSO(){
	$Venta=$this->getClasificacionVenta();
		$Q0="
		SELECT 'SKU', 'MODELO', 'PRECIO COSTO', 'PUNTO DE VENTA', 'PLANTILLA', 'EXISTENCIA ACTUAL NACIONAL ', 'EXISTENCIA ACTUAL PDV ',
		       'VENTA NACIONAL ANTERIOR', 'VENTA SEMANA 1', 'VENTA SEMANA 2','VALOR INVENTARIO '
		UNION
		SELECT T1.EquipoId,
	       T1.Equipo,
	       CONCAT('$ ',FORMAT(T1.CostoEquipo,2)),
	       T3.PuntoVenta,
	       T2.Cantidad,
	       Existencia AS ExistenciaNacional,
	       IFNULL(ExistenciaPunto,0) AS ExistenciaPunto,
	       VentaNacional,
	       VentaSem1,
	       VentaSem2,
	       CONCAT('$ ',FORMAT(T1.CostoEquipo*Existencia,2)) AS ValorInventario
			FROM Equipos AS T1
			LEFT JOIN PlantillaInventario AS T2 ON T2.EquipoId=T1.EquipoId
			LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T2.PuntoVentaId
			INNER JOIN (
			            SELECT T2.PuntoVentaId, EquipoId, SUM(Cantidad) AS Existencia FROM Inventario AS T1
			            INNER JOIN (
			                        SELECT MovimientoId, PuntoVentaId FROM AjustesPositivos
			                        UNION
			                        SELECT MovimientoId, PuntoVentaId FROM Recepciones
			                        UNION
			                        SELECT MovimientoId, PuntoVentaIdO FROM TRSalidas
			                      ) AS T2 ON T2.MovimientoId=T1.MovimientoId
			            WHERE T1.Cantidad>0
			            GROUP BY T1.EquipoId
			          ) AS T4 ON T4.EquipoId=T1.EquipoId
			LEFT JOIN (
			            SELECT T2.PuntoVentaId, EquipoId, SUM(Cantidad) AS ExistenciaPunto FROM Inventario AS T1
			            INNER JOIN (
			                        SELECT MovimientoId, PuntoVentaId FROM AjustesPositivos
			                        UNION
			                        SELECT MovimientoId, PuntoVentaId FROM Recepciones
			                        UNION
			                        SELECT MovimientoId, PuntoVentaIdO FROM TRSalidas
			                      ) AS T2 ON T2.MovimientoId=T1.MovimientoId
			            WHERE T1.Cantidad>0
			            GROUP BY T1.EquipoId, PuntoVentaId
			          ) AS T5 ON T5.EquipoId=T1.EquipoId AND T5.PuntoVentaId=T2.PuntoVentaId
			LEFT JOIN (
			            SELECT T2.EquipoId, COUNT(RegistroId) AS VentaNacional FROM LFolios AS T1
			            INNER JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			            WHERE EstatusId=14 AND Cantidad<0 AND WEEK(FechaEstatus)=WEEK(CURDATE())-1
			            GROUP BY T2.EquipoId
			          ) AS T6 ON T6.EquipoId=T1.EquipoId
			LEFT JOIN (
			            SELECT T2.EquipoId, PuntoVentaId, COUNT(RegistroId) AS VentaSem1 FROM LFolios AS T1
			            INNER JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			            INNER JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			            WHERE EstatusId=14 AND Cantidad<0 AND WEEK(FechaEstatus)=WEEK(CURDATE())-1
			            GROUP BY T2.EquipoId, PuntoVentaId
			          ) AS T7 ON T7.EquipoId=T1.EquipoId AND T7.PuntoVentaId=T2.PuntoVentaId
			LEFT JOIN (
			            SELECT T2.EquipoId, PuntoVentaId, COUNT(RegistroId) AS VentaSem2 FROM LFolios AS T1
			            INNER JOIN Inventario AS T2 ON T2.Serie=T1.Serie
			            INNER JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			            WHERE EstatusId=14 AND Cantidad<0 AND WEEK(FechaEstatus)=WEEK(CURDATE())-2
			            GROUP BY T2.EquipoId, PuntoVentaId
			          ) AS T8 ON T8.EquipoId=T1.EquipoId AND T8.PuntoVentaId=T2.PuntoVentaId
		ClasificacionPersonalVenta IN ($Venta)
	";
		return $this->Consulta($Q0);
	}

function getDatosClientesReactivacion($Nombre)
{
	list($PuntoVentaId, $Coorporativo)=$this->getPuntoVentaFisico();

		$Filtro='PuntoVentaId = '.$PuntoVentaId;

	if($Nombre=='')
		$Filtro2='AND T2.RevisionId IS NULL';
	else
		$Filtro2='AND NOMBREDELCLIENTE=\''.$Nombre.'\'';

	$Q0="SELECT T1.RevisionId, NOMBREDELCLIENTE, DIVISIONSERVDW, RFCCLIENTE
	FROM RenovacionClientes AS T1
	LEFT JOIN HistorialRenovaciones AS T2 ON T2.RevisionId=T1.RevisionId
	WHERE $Filtro $Filtro2
	GROUP BY NOMBREDELCLIENTE
	ORDER BY RAND() LIMIT 1";

	return mysql_fetch_row($this->Consulta($Q0));
}

function getReactivacionLineas($Cliente)
	{
		$Q0="SELECT CONTRATO, TELEFONO, ESN, MODELO, PLANDESERVICIO, BUD_FCH_VENCIMIENTO_CONTRATO  FROM RenovacionClientes
			WHERE NOMBREDELCLIENTE='$Cliente'";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>CONTRATO</th>
							<th>TELEFONO</th>
							<th>ESN</th>
							<th>MODELO</th>
							<th>PLANDESERVICIO</th>
							<th>FECHA VENCIMIIENTO</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getRenovacionesLineasHistorial($RevisionId)
	{
		$Q0="SELECT DATE_FORMAT(Fecha,'%d/%m/%Y'), Hora, CONCAT_WS(' ',Nombre, paterno, Materno),
		EstatusSeguimiento, Comentario, IF(FechaHora='0000-00-00 00:00:00','',DATE_FORMAT(FechaHora, '%d/%m/%Y %h:%m'))
			FROM HistorialRenovaciones AS T1
			LEFT JOIN Usuarios AS T2 ON T2.Usuarioid=T1.UsuarioId
			LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
			LEFT JOIN EstatusSeguimiento AS T4 ON T4.EstatusSeguimientoId=T1.EstatusSeguimientoId
			WHERE RevisionId=$RevisionId

			";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Fecha</th>
							<th>Hora</th>
							<th>Usuario</th>
							<th>Esatus</th>
							<th>Comentarios</th>

						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td>'.$A0[4].'</td>

						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getRenovacionAgenda()
	{
		$Q0="SELECT DATE_FORMAT(FechaHora, '%d/%m/%Y %h:%m'), NOMBREDELCLIENTE,
		Comentario
			FROM HistorialRenovaciones AS T1
			LEFT JOIN Usuarios AS T2 ON T2.Usuarioid=T1.UsuarioId
			LEFT JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
			LEFT JOIN EstatusSeguimiento AS T4 ON T4.EstatusSeguimientoId=T1.EstatusSeguimientoId
			LEFT JOIN RenovacionClientes AS T5 ON T5.RevisionId=T1.RevisionId
			WHERE FechaHora!='0000-00-00 00:00:00' AND T1.UsuarioId=$this->UsuarioId
			ORDER BY FechaHora";

		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Fecha/Hora</th>
							<th>Cliente</th>
							<th>Comentarios</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getMisClientesReactivacion()
	{
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Cliente</th>
							<th>Ciudad</th>
							<th>Estado</th>
							<th>Fecha_Ultima_Revision</th>
							<th>Hora_Ultima_Revision</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT NOMBREDELCLIENTE, RFCCLIENTE, DIVISIONSERVDW, Fecha, Hora
				FROM (
				      SELECT RevisionId, Fecha, Hora, UsuarioId
				      FROM (SELECT RevisionId, Fecha, Hora, UsuarioId FROM HistorialRenovaciones ORDER BY Fecha DESC, HORA DESC) AS T1 GROUP BY RevisionId
				     ) AS T1
				LEFT JOIN RenovacionClientes AS T2 ON T2.RevisionId=T1.RevisionId
				WHERE T1.UsuarioId=$this->UsuarioId
				GROUP BY T1.RevisionId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td>'.$A0[2].'</td>
							<td>'.$A0[3].'</td>
							<td>'.$A0[4].'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="EnviaCliente(\''.$A0[0].'\')"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function GuardaRenovacion($RevisionId, $EstatusSeguimientoId, $Comentarios, $FechaHora)
{
	$Q0="INSERT IGNORE INTO HistorialRenovaciones (RevisionId, Fecha, Hora, usuarioId, EstatusSeguimientoId, Comentario, FechaHora)
VALUES($RevisionId, CURDATE(), CURTIME(), $this->UsuarioId, $EstatusSeguimientoId, '$Comentarios', '$FechaHora')";

	if($this->Consulta($Q0))
	{
		return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
	}
	else
	{

	return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}
}

function addRevisionBuro($TipoPersonaId, $NombreC, $PaternoC, $MaternoC, $RFCC, $TLocal, $TMovil, $Calle,
							$NExterior, $NInterior, $ColoniaId, $archivador1, $archivador2)
{
	$this->StartTransaccion();
		$Q0="INSERT INTO Clientes (ClienteId, Nombre, Paterno, Materno, RFC, TipoPersonaId)
            VALUE (NULL, UCASE('$NombreC'), UCASE('$PaternoC'), UCASE('$MaternoC'), UCASE('$RFCC'), $TipoPersonaId)";

		if($this->Consulta($Q0))
		{
			$ClienteId=mysql_insert_id();
			$Q1="INSERT INTO HistorialDatosClientes (HistorialDatosClienteId, ClienteId, NombreContacto,
													 PaternoContacto, MaternoContacto, Calle,
													 NoExterior, NoInterior, ColoniaId, TelefonoLocal, TelefonoMovil)
				VALUES(NULL, $ClienteId, '', '', '', UCASE('$Calle'), '$NExterior','$NInterior', $ColoniaId, '$TLocal', '$TMovil')
			";

			$Q2="INSERT INTO DocumentosBuro (ClienteId, Identificacion, Buro)
				 VALUES($ClienteId, '$archivador1', '$archivador2')";

			if($this->Consulta($Q1) & $this->Consulta($Q2) & $this->addBitacora(60, 2, $ClienteId,'', 'Cliente'))
			{
			$this->AceptaTransaccion();
			return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');
			}
		}
			$this->CancelaTransaccion();
			return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function getReporteBuro()
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT 'CLIENTE', 'FECHA REGISTRO', 'USUARIO', 'PLAZA', 'PUNTO VENTA'
		UNION
		SELECT CONCAT_WS(' ',T5.Nombre, T5.Paterno, T5.Materno) AS Cliente,
		       DATE_FORMAT(T2.Fecha,'%d/%m/%Y') AS FechaRegistro,
		       CONCAT_WS(' ',T4.Nombre, T4.Paterno, T4.Materno) AS Usuario,
		       Plaza, PuntoVenta
		FROM DocumentosBuro AS T1
		INNER JOIN Bitacora AS T2 ON T2.ObjetoId=T1.ClienteId AND T2.ModuloId=60 AND OperacionId=2
		INNER JOIN Usuarios AS T3 ON T3.UsuarioId=T2.UsuarioId
		INNER JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
		INNER JOIN Clientes AS T5 ON T5.ClienteId=T1.ClienteId
		INNER JOIN HistorialPuntosEmpleados AS T6 ON T6.EmpleadoId=T4.EmpleadoId AND Fisico=1 AND FechaBaja='0000-00-00'
		INNER JOIN PuntosVenta AS T7 ON T7.PuntoVentaId=T6.PuntoVentaId
		INNER JOIN Plazas AS T8 ON T8.PlazaId=T7.PlazaId
		WHERE T7.PuntoVentaId IN ($MisPuntos)
		GROUP BY T5.RFC
	";
	return $this->Consulta($Q0);
}

function altaAnalisisCredito($Folio, $PuntoVentaId, $VendedorId, $TipoContratacionId, $ClienteId, $BuroCliente, $TipoPagoId, $Garantia, $TipoIdentificacionId, $IdentificacionTxt, $LuzNegra, $TipoComprobanteDomicilioId, $FotoComprobanteDomicilio, $FotoBuroCredito, $Observaciones, $Clave)
{
	return true;
}

function altaAnalisisCreditoLineas($Clave, $PlanId, $EquipoId, $PlazoId, $Precio)
{
	return true;
}

function returnMacAddress() {

$location = `which arp`;
$arpTable = `$location`;
$arpSplitted = split("\\n",$arpTable);
$remoteIp = $GLOBALS['REMOTE_ADDR'];

foreach ($arpSplitted as $value) {
       $valueSplitted = split(" ",$value);
       foreach ($valueSplitted as $spLine) {
           if (preg_match("/$remoteIp/",$spLine)) {
               $ipFound = true;
           }
if ($ipFound) {
         reset($valueSplitted);
      foreach ($valueSplitted as $spLine) {
          if (preg_match("/[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f][:-]".
                  "[0-9a-f][0-9a-f][:-]".
                  "[0-9a-f][0-9a-f][:-]".
                 "[0-9a-f][0-9a-f]/i",$spLine)) {
              return $spLine;
             }
          }
     }
      $ipFound = false;
      }
     }
       return false;
    }

function checar($EmpleadoId, $Pwd)
{
	$Q0="SELECT COUNT(UsuarioId) AS CTA FROM Usuarios WHERE EmpleadoId=$EmpleadoId AND Password=MD5('$Pwd')";
	list($Cta)=mysql_fetch_row($this->Consulta($Q0));
	if($Cta>0)
	{
	$Q1="INSERT INTO Checador
		 SELECT * FROM
		 (SELECT NULL, IFNULL(EmpleadoId,$EmpleadoId) AS EmpleadoId, IF(Evento='E','S','E') AS Evento, CURDATE(), CURTIME()
		 	FROM Checador WHERE EmpleadoId=$EmpleadoId AND Fecha=CURDATE() ORDER BY RegistroId DESC LIMIT 1) AS T1
		 UNION
		 SELECT NULL, $EmpleadoId AS EmpleadoId, 'E' AS Evento, CURDATE(), CURTIME()
		 LIMIT 1";
	$this->Consulta($Q1);
	return 'OK';
	}
	return 'FAIL';
}

function getListaPersonalActivo()
{
	$MisPuntos=$this->getMisPuntos();
	$Cadena='<table id="MiTabla2" >
	<thead>
		<tr>
		<th>N.C.</th>
		<th>Nombre</th>
		<th>Elige</th>
		</tr>
		</thead>
		<tbody>';
		$t=true;
		$Q0= "SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, Paterno, Materno) AS Coordinador
				FROM HistorialPuestosEmpleados AS T1
				LEFT JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				LEFT JOIN HistorialPuntosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.FechaBaja='0000-00-00'
				WHERE T1.FechaBaja='0000-00-00' AND T1.EmpleadoId>1
				AND T3.PuntoventaId IN ($MisPuntos)
				GROUP BY T1.EmpleadoId
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.($A0[1]).'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,8)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
}

function resetPWD($NC)
{
	$Q0="UPDATE Usuarios SET Password=MD5('mantenimiento') WHERE EmpleadoId=$NC";

	if($this->Consulta($Q0))
		return 'OK';
	return 'FAIL';
}

function getIsGratisSim($MontoRecargaId)
{
	$Q0="SELECT SimGratis FROM MontoRecargas WHERE MontoRecargaId=$MontoRecargaId";
	list($SimGratis)=mysql_fetch_row($this->Consulta($Q0));
	if($SimGratis==1)
		return true;
	return false;
}

function guardaRecarga($Folio, $CompaniaId, $NTel, $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, $Comentario, $Serie, $CPortabilidadId, $TPortabilidad, $Nombre, $Paterno, $Materno, $TelContacto, $CorreoContacto, $DocIfe, $Nip)
{
$Folio='RE'.$Folio;

//	$Diferencial=0;

if($this->getIsGratisSim($MontoRecargaId))
	$Diferencial=0;
else
	$Diferencial=80;


$Equipo=$this->validaSeriePunto($Serie, $PuntoVentaId);

$this->StartTransaccion();
$Q1="INSERT INTO Recargas (Folio, CompaniaId, NTel, MontoRecargaId, PuntoVentaId, VendedorId, CoordinadorId, Comentario, Fecha, Hora, CompaniaPId, NTelP, Nombre, Paterno, Materno, TelContacto, CorreoContacto, Ife, Nip)
	VALUES('$Folio', $CompaniaId, '$NTel', $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, '$Comentario', CURDATE(), CURTIME(), $CPortabilidadId, '$TPortabilidad', '$Nombre', '$Paterno', '$Materno', '$TelContacto', '$CorreoContacto', '$DocIfe', '$Nip')";

if($Serie=='')
{
		if($this->Consulta($Q1) & $this->addBitacora(65, 2, 0, $Folio, ''))
		{
			$this->AceptaTransaccion();
			return 'OK';
		}
		else
		{
			$this->CancelaTransaccion();
			return 'FAIL';
		}
}
else
{
	$Q0="INSERT INTO Movimientos (MovimientoId) VALUES(NULL)";

	if(($Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA PREPAGO' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF' || $Equipo=='SIM CARD V8R TRIO DISPLAY UNEF' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO')  & $this->Consulta($Q0))

  //if($this->Consulta($Q0))


	{

		$MovimientoId=mysql_insert_id();

		$Q2="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
	                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, ContratacionId, Validado)
						 VALUES(UCASE('$Folio'), CURDATE(), CURDATE(), CURDATE(), $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, 6004,
	        					1, 1, 'Recarga Electronica', '$Folio',$MovimientoId, 1,0, 0)";

		$Q3="INSERT INTO TLineas
	                   SELECT NULL, '$Folio', EquipoId, 255, 3, 6, '', '$NTel',  $Diferencial, 1, '',0
	                   FROM Inventario WHERE Serie='$Serie' LIMIT 1";


		$Q4="INSERT INTO LFolios
				 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 14,
				 0 AS Costo, 0 AS RentaSI, '', CURDATE(), '$Serie', '', Dn, Diferencial, TipoPagoDiferencial,0
				 FROM TLineas AS T1
				 WHERE T1.Clave='$Folio'";

		$Q5="INSERT INTO Inventario
			SELECT T1.EquipoId, T1.Serie, IccId, -1 AS Cantidad, T3.MovimientoId, CURDATE(), '0000-00-00', T2.AlmacenId, T2.PlataformaId
			FROM LFolios AS T1
			LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			LEFT JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			WHERE T1.Folio='$Folio'
			LIMIT 1";

		$Q6="UPDATE Inventario AS T1
			INNER JOIN (
			            SELECT T1.Serie, 0 AS Cantidad
			            FROM LFolios AS T1
			            LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			            WHERE T1.Folio='$Folio'
			            LIMIT 1
			           ) AS T2 ON T2.Serie=T1.Serie
			SET T1.Cantidad=T2.Cantidad
			WHERE T1.Cantidad>0";
		$Q7="INSERT INTO Bitacora (BitacoraId, UsuarioId, ModuloId, OperacionId, ObjetoId, ObjetoTxt, Host, Fecha, Hora, Comentario)
						SELECT NULL, $this->UsuarioId, 65, 2, RegistroId, '',14, CURDATE(), CURTIME(), 'Recarga Electronica'
						FROM TLineas AS T1 WHERE T1.Clave='$Folio'
			";

			if($this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6) & $this->Consulta($Q7) & $this->Consulta($Q1) & $this->addBitacora(65, 2, 0, $Folio, ''))
			{

				$this->AceptaTransaccion();
				return 'OK';
			}
			else
			{
				$this->CancelaTransaccion();

				return 'INVALID';
			}
	}
		$this->CancelaTransaccion();
		return 'INVALID';

}
	$this->CancelaTransaccion();

	return 'FAIL';
}
//funcion para guardar venta de tiempo aire electronico
function guardaVentaTAE($FolioR, $NTel, $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, $Comentario)
{
	//echo 'Folio: '.$FolioR.'<br>'.'Numero para Recarga: '.$NTel.'<br>Monto de la Recarga:'.$MontoRecargaId.'<br>Punto VentaId: '.$PuntoVentaId.'<br>VendedorId: '.$VendedorId.'<br> CoordinadorId:'.$CoordinadorId.'<br>Comentario: '.$Comentario.'<br>';
	//return 'Hola';
$Folio='RE'.$FolioR;

//	$Diferencial=0;
/*
if($this->getIsGratisSim($MontoRecargaId))
	$Diferencial=0;
else
	$Diferencial=80;
*/

//$Equipo=$this->validaSeriePunto($Serie, $PuntoVentaId);

$this->StartTransaccion();
$Q1="INSERT INTO Recargas (Folio, CompaniaId, NTel, MontoRecargaId, PuntoVentaId, VendedorId, CoordinadorId, Comentario, Fecha, Hora, CompaniaPId, NTelP, Nombre, Paterno, Materno, TelContacto, CorreoContacto, Ife, Nip)
	VALUES('$Folio', 3, '$NTel', $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, '$Comentario', CURDATE(), CURTIME(), 0, '', '', '', '', '', '', '', '')";

	if($this->Consulta($Q1) & $this->addBitacora(73, 2, 0, $Folio, ''))
		{
			$this->AceptaTransaccion();
			return utf8_decode('<span class="alerta">¡Recarga Registrada con exito!</span>');
			
		}
		else
		{
			$this->CancelaTransaccion();

			return utf8_decode('<span class="alerta">¡Error al guardar Recarga!</span>');
		}

	$this->CancelaTransaccion();

	return 'FAIL';
}

//Fin de la funcion para la venta de tiempo aire electronica

//funcion para guardar venta de tiempo aire electronico mas activacion de sim
function guardaVentaTAESim($FolioR, $NTel, $MontoRecargaId, $Sim, $PuntoVentaId, $VendedorId, $CoordinadorId, $Comentario)
{
	/*echo $FolioR."<br>".$NTel."<br>".$MontoRecargaId."<br>".$Sim."<br>".$PuntoVentaId."<br>".$VendedorId."<br>".$CoordinadorId."<br>".$Comentario."<br>";
	return 'Hola';*/
$Folio='RE'.$FolioR;
$Serie=$Sim;
//	$Diferencial=0;

if($this->getIsGratisSim($MontoRecargaId))
	$Diferencial=0;
else
	$Diferencial=80;


$Equipo=$this->validaSeriePunto($Serie, $PuntoVentaId);

$this->StartTransaccion();
$Q1="INSERT INTO Recargas (Folio, CompaniaId, NTel, MontoRecargaId, PuntoVentaId, VendedorId, CoordinadorId, Comentario, Fecha, Hora, CompaniaPId, NTelP, Nombre, Paterno, Materno, TelContacto, CorreoContacto, Ife, Nip)
	VALUES('$Folio', 3, '$NTel', $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, '$Comentario', CURDATE(), CURTIME(), 0, '', '', '', '', '', '', '', '')";

	$Q0="INSERT INTO Movimientos (MovimientoId) VALUES(NULL)";

	if(($Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA PREPAGO' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF'  || $Equipo=='SIM CARD V8R TRIO DISPLAY UNEF'  || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO')  & $this->Consulta($Q0))

  //if($this->Consulta($Q0))


	{

		$MovimientoId=mysql_insert_id();

		$Q2="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
	                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, ContratacionId, Validado)
						 VALUES(UCASE('$Folio'), CURDATE(), CURDATE(), CURDATE(), $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, 6004,
	        					1, 1, 'Recarga Electronica', '$Folio',$MovimientoId, 1,0, 0)";

		$Q3="INSERT INTO TLineas
	                   SELECT NULL, '$Folio', EquipoId, 255, 3, 6, '', '$NTel',  $Diferencial, 1, '',0
	                   FROM Inventario WHERE Serie='$Serie' LIMIT 1";


		$Q4="INSERT INTO LFolios
				 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 14,
				 0 AS Costo, 0 AS RentaSI, '', CURDATE(), '$Serie', '', Dn, Diferencial, TipoPagoDiferencial,0
				 FROM TLineas AS T1
				 WHERE T1.Clave='$Folio'";

		$Q5="INSERT INTO Inventario
			SELECT T1.EquipoId, T1.Serie, IccId, -1 AS Cantidad, T3.MovimientoId, CURDATE(), '0000-00-00', T2.AlmacenId, T2.PlataformaId
			FROM LFolios AS T1
			LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			LEFT JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			WHERE T1.Folio='$Folio'
			LIMIT 1";

		$Q6="UPDATE Inventario AS T1
			INNER JOIN (
			            SELECT T1.Serie, 0 AS Cantidad
			            FROM LFolios AS T1
			            LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			            WHERE T1.Folio='$Folio'
			            LIMIT 1
			           ) AS T2 ON T2.Serie=T1.Serie
			SET T1.Cantidad=T2.Cantidad
			WHERE T1.Cantidad>0";
		$Q7="INSERT INTO Bitacora (BitacoraId, UsuarioId, ModuloId, OperacionId, ObjetoId, ObjetoTxt, Host, Fecha, Hora, Comentario)
						SELECT NULL, $this->UsuarioId, 73, 2, RegistroId, '',14, CURDATE(), CURTIME(), '".$Folio."'
						FROM TLineas AS T1 WHERE T1.Clave='$Folio'
			";

			if($this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6) & $this->Consulta($Q7) & $this->Consulta($Q1) & $this->addBitacora(74, 2, 0, $Folio, ''))
			{

				$this->AceptaTransaccion();
				return utf8_decode('<span class="alerta">¡Venta de TAE y Activacion de Sim Exitosa!</span>');
			}
			else
			{
				$this->CancelaTransaccion();

				return 'INVALID';
			}
	}
		$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡Equipo Elegido no Valido!</span>');


	$this->CancelaTransaccion();

	return 'FAIL';

	
	//return 'prueba de envio';
}
function guardaVentaPortabilidad($FolioR, $NTel, $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, $Comentario, $Sim, $NTelP, $Nombre, $Paterno, $Materno, $Nip, $Portabilidad)
{

$Folio='RE'.$FolioR;
$Serie=$Sim;
$comentarioFin=$Comentario.' '.$Portabilidad;
//	$Diferencial=0;

if($this->getIsGratisSim($MontoRecargaId))
	$Diferencial=0;
else
	$Diferencial=80;


$Equipo=$this->validaSeriePunto($Serie, $PuntoVentaId);

$this->StartTransaccion();
$Q1="INSERT INTO Recargas (Folio, CompaniaId, NTel, MontoRecargaId, PuntoVentaId, VendedorId, CoordinadorId, Comentario, Fecha, Hora, CompaniaPId, NTelP, Nombre, Paterno, Materno, TelContacto, CorreoContacto, Ife, Nip)
	VALUES('$Folio', 3, '$NTel', $MontoRecargaId, $PuntoVentaId, $VendedorId, $CoordinadorId, '$comentarioFin', CURDATE(), CURTIME(), 0, '$NTelP', '$Nombre', '$Paterno', '$Materno', '', '', '', '$Nip')";

	$Q0="INSERT INTO Movimientos (MovimientoId) VALUES(NULL)";

	if(($Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA PREPAGO' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF PREPAGO' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY IUSA' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF' || $Equipo=='TRIO SIMCARD V6.1 DISPLAY UNEF' || $Equipo=='SIM CARD V8R TRIO DISPLAY ATT PREPAGO' || $Equipo=='SIM CARD V8R TRIO DISPLAY UNEF')  & $this->Consulta($Q0))

  //if($this->Consulta($Q0))


	{

		$MovimientoId=mysql_insert_id();

		$Q2="INSERT INTO HFolios (Folio, FechaCaptura, FechaContrato, FechaSS, PuntoventaId, UsuarioId, HistorialPuestoEmpleadoId,
	                     CoordinadorId, ClienteId, TipoContratacionId, TipoPagoId, Comentarios, Clave, MovimientoId, EnReporte, ContratacionId, Validado)
						 VALUES(UCASE('$Folio'), CURDATE(), CURDATE(), CURDATE(), $PuntoVentaId, $this->UsuarioId, $VendedorId, $CoordinadorId, 6004,
	        					1, 1, 'Recarga Electronica', '$Folio',$MovimientoId, 1,0, 0)";

		$Q3="INSERT INTO TLineas
	                   SELECT NULL, '$Folio', EquipoId, 255, 3, 6, '', '$NTel',  $Diferencial, 1, '',0
	                   FROM Inventario WHERE Serie='$Serie' LIMIT 1";


		$Q4="INSERT INTO LFolios
				 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 14,
				 0 AS Costo, 0 AS RentaSI, '', CURDATE(), '$Serie', '', Dn, Diferencial, TipoPagoDiferencial,0
				 FROM TLineas AS T1
				 WHERE T1.Clave='$Folio'";

		$Q5="INSERT INTO Inventario
			SELECT T1.EquipoId, T1.Serie, IccId, -1 AS Cantidad, T3.MovimientoId, CURDATE(), '0000-00-00', T2.AlmacenId, T2.PlataformaId
			FROM LFolios AS T1
			LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			LEFT JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			WHERE T1.Folio='$Folio'
			LIMIT 1";

		$Q6="UPDATE Inventario AS T1
			INNER JOIN (
			            SELECT T1.Serie, 0 AS Cantidad
			            FROM LFolios AS T1
			            LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			            WHERE T1.Folio='$Folio'
			            LIMIT 1
			           ) AS T2 ON T2.Serie=T1.Serie
			SET T1.Cantidad=T2.Cantidad
			WHERE T1.Cantidad>0";
		$Q7="INSERT INTO Bitacora (BitacoraId, UsuarioId, ModuloId, OperacionId, ObjetoId, ObjetoTxt, Host, Fecha, Hora, Comentario)
						SELECT NULL, $this->UsuarioId, 75, 2, RegistroId, '',14, CURDATE(), CURTIME(), '".$Folio."'
						FROM TLineas AS T1 WHERE T1.Clave='$Folio'
			";

			if($this->Consulta($Q2) & $this->Consulta($Q3) & $this->Consulta($Q4) & $this->Consulta($Q5) & $this->Consulta($Q6) & $this->Consulta($Q7) & $this->Consulta($Q1) & $this->addBitacora(65, 2, 0, $Folio, ''))
			{

				$this->AceptaTransaccion();
				return utf8_decode('<span class="alerta">¡Venta de Portabilidad registrada con Exito!</span>');
			}
			else
			{
				$this->CancelaTransaccion();

				return 'INVALID';
			}
	}
		$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡ Equipo Elegido no Valido!</span>');


	$this->CancelaTransaccion();

	return 'FAIL';

	
	//return 'prueba de envio';
}


















function getReporteChecador()
{
	$Q0="SELECT 'ID','REGION','SUBREGION','PLAZA', 'PUNTO DE VENTA','NC', 'NOMBRE', 'EVENTO', 'FECHA', 'HORA', 'CANAL OPERATIVO','OPERADOR'
	UNION
	(
	SELECT T1.RegistroId, Region, SubRegion, Plaza, PuntoVenta, T1.EmpleadoId, CONCAT_WS(' ', Nombre, paterno, Materno) AS Nombre, IF(Evento='E', 'Entrada', 'Salida') AS Evento, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, Hora, T8.ClasificacionPersonalVenta, Operador
	FROM Checador AS T1
	INNER JOIN Empleados AS T2 ON T2.EmpleadoId=T1.EmpleadoId
	INNER JOIN HistorialPuntosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId AND T3.Fisico=1 AND T3.FechaBaja='0000-00-00'
	LEFT JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T3.PuntoVentaId
	LEFT JOIN Plazas AS T5 ON T5.PlazaId=T4.PlazaId
	LEFT JOIN SubRegiones AS T6 ON T6.SubRegionId=T5.SubRegionId
	LEFT JOIN Regiones AS T7 ON T7.RegionId=T6.RegionId
	LEFT JOIN ClasificacionPersonalVenta AS T8 ON T8.ClasificacionPersonalVentaId=T4.ClasificacionpersonalVenta
	INNER JOIN HistorialPuestosEmpleados AS HPE ON HPE.EmpleadoId=T2.EmpleadoId AND HPE.FechaBaja='0000-00-00'
	ORDER BY T1.RegistroId
	)";
	return $this->Consulta($Q0);
}

function saveEquipoPunto($name)
{
	$MiPv=$_COOKIE["MiPuntoVenta"];
	$Q0="INSERT IGNORE INTO PuntosVentaEquiposComputo (PuntoVentaId, Equipo) VALUES($MiPv, UCASE('$name'))";
	$this->Consulta($Q0);
}

function addDeposito($Deposito, $FechaHora, $TipoDepositoId, $Monto, $Ficha, $Comentarios, $PuntoVentaId)
{
	$Q0="INSERT INTO Depositos
				      (DepositoId, Deposito, FechaHora, TipoDepositoId, Monto, Ficha, Fecha, Hora, PuntoVentaId, Validado, Comentarios)
				VALUES(NULL, $Deposito, '$FechaHora', $TipoDepositoId, $Monto, '$Ficha', CURDATE(), CURTIME(), $PuntoVentaId, 0, '$Comentarios')";

	$this->StartTransaccion();
		if($this->Consulta($Q0) & $this->addBitacora(66, 2, mysql_insert_id(), 'Alta Deposito', ''))
		{
			$this->AceptaTransaccion();

			return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');

		}
		$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}


function getDeposito($DepositoId)
{
	$Q0="SELECT Deposito,
		    FechaHora,
		    TipoDepositoId,
		    Monto,
		    Ficha,
		    T1.PuntoVentaId,
		    IF(Validado,'DepositoValidado','Deposito NO validado'),
		    Comentarios,
		    PuntoVenta
		FROM Depositos AS T1
		INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
		WHERE DepositoId='$DepositoId'
		";

	return mysql_fetch_row($this->Consulta($Q0));
}


function getRecargas(){
	$Q0="SELECT 'FOLIO', 'FECHA', 'REGION', 'SUBREGION', 'PLAZA', 'PUNTO DE VENTA', 'COMPA?A', 'NUMERO TELEFONICO', 'MONTO RECARGA',
	'VENDEDOR', 'COORDINADOR', 'COMENTARIO', 'SERIE', 'COMPAÑIA PORTABILIDAD',
	'NUMERO PORTABILIDAD', 'NOMBRE_CONTACTO', 'TELEFONO_CONTACTO', 'CORREO_CONTACTO', 'NIP'
UNION
SELECT T1.Folio, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha,  Region, SubRegion, Plaza, Puntoventa, T2.Compania, NTel, MonToRecarga,
       CONCAT_WS(' ', T9.Nombre, T9.Paterno, T9.Materno) AS Vendedor, CONCAT_WS(' ', T10.Nombre, T10.Paterno, T10.Materno) AS Coordinador,
       T1.Comentario, T11.Serie, T12.Compania, T1.NTelP, CONCAT_WS(' ', T1.nombre, T1.paterno, T1.materno), telContacto, correoContacto, nip
FROM Recargas AS T1
LEFT JOIN Companias AS T2 ON T2.CompaniaId=T1.CompaniaId
LEFT JOIN MontoRecargas AS T3 ON T3.MontoRecargaId=T1.MontoRecargaId
LEFT JOIN PuntosVenta AS T4 ON T4.PuntoventaId=T1.PuntoVentaId
LEFT JOIN Plazas AS T5 ON T5.PlazaId=T4.PlazaId
LEFT JOIN SubRegiones AS T6 ON T6.SubRegionId=T5.SubRegionId
LEFT JOIN Regiones AS T7 ON T7.RegionId=T6.RegionId
LEFT JOIN HistorialPuestosEmpleados AS T8 ON T8.HistorialPuestoEmpleadoId=T1.VendedorId
LEFT JOIN Empleados AS T9 ON T9.EmpleadoId=T8.EmpleadoId
LEFT JOIN Empleados AS T10 ON T10.EmpleadoId=T1.CoordinadorId
LEFT JOIN LFolios AS T11 ON T11.Folio=T1.Folio AND EstatusId=14
LEFT JOIN Companias AS T12 ON T12.CompaniaId=T1.CompaniaPId

";
return $this->Consulta($Q0);

}

function validaDeposito($DepositoId)
{

	$Q0="UPDATE Depositos SET Validado=1 WHERE DepositoId IN ($DepositoId 0)";
	$this->StartTransaccion();
		if($this->Consulta($Q0) & $this->addBitacora(66, 7, $DepositoId, 'Valida Deposito', ''))
		{
			$this->AceptaTransaccion();
			return utf8_decode('<span class="notificacion">Los datos se actualizaron correctamente!</span>');
		}
		$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">?No fue posible actualizar el registro!</span>');
}

function revisionAvisos()
{
	$Q0="SELECT 'CLASIFICACION AVISO', '# AVISO', 'AVISO', 'FECHA', 'HORA', 'PLAZA', 'PUNTO DE VENTA', 'NOMBRE'
		UNION ALL
		SELECT ClasificacionAviso,T1.AvisoId, Aviso,
		DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, Hora,
		Plaza, PuntoVenta,
		CONCAT_WS(' ', Nombre, Paterno, Materno) AS Nombre
		FROM AvisosRevision AS T1
		INNER JOIN Usuarios AS T2 ON T2.UsuarioId=T1.UsuarioId
		INNER JOIN Empleados AS T3 ON T3.EmpleadoId=T2.EmpleadoId
		INNER JOIN Avisos AS T4 ON T4.AvisoId=T1.AvisoId
		INNER JOIN HistorialPuntosEmpleados AS T5 ON T5.EmpleadoId=T2.EmpleadoId AND T5.FechaBaja='0000-00-00' AND T5.Fisico=1
		INNER JOIN PuntosVenta AS T6 ON T6.PuntoVentaId=T5.PuntoVentaId
		INNER JOIN Plazas AS T7 ON T7.PlazaId=T6.PlazaId
		INNER JOIN SubRegiones AS T8 ON T8.SubRegionId=T7.SubRegionId
		INNER JOIN Regiones AS T9 ON T9.RegionId=T8.RegionId
		INNER JOIN ClasificacionAvisos AS T10 ON T10.ClasificacionAvisoId=T4.ClasificacionAvisoId
		WHERE T2.EmpleadoId>1
		";
		return $this->Consulta($Q0);
}

function setConcepto($TraspasoId,$ConceptoTRId)
{
	$Q0="UPDATE Recepciones SET ConseptoTRId=$ConceptoTRId WHERE MovimientoId IN ($TraspasoId 0)";
	$this->Consulta($Q0);
}

function bloqueraPunto($PuntoVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId=1 WHERE EmpleadoId
			IN (SELECT EmpleadoId FROM HistorialPuntosEmpleados WHERE PuntoVentaId IN ($PuntoVentaId) AND Fisico=1 AND FechaBaja='0000-00-00')";
		$this->Consulta($Q0);
	$this->addBitacora(61, 4, $PuntoVentaId, 'Bloqueo Inventario','Bloqueo');
}


function desbloquearPunto($PuntoVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId=0 WHERE EmpleadoId
			IN (SELECT EmpleadoId FROM HistorialPuntosEmpleados WHERE PuntoVentaId IN ($PuntoVentaId) AND Fisico=1 AND FechaBaja='0000-00-00')";
		$this->Consulta($Q0);
	$this->addBitacora(61, 4, $PuntoVentaId, 'Desbloqueo Inventario','Desbloqueo');
}


function bloquearCanal($CanalVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId=1 WHERE EmpleadoId
			IN (SELECT EmpleadoId
			FROM HistorialPuntosEmpleados AS T1
			INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			WHERE Fisico=1 AND FechaBaja='0000-00-00' AND ClasificacionPersonalventa=$CanalVentaId
			)";
		$this->Consulta($Q0);
}

function DesbloquearCanal($CanalVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId=0 WHERE EmpleadoId
			IN (SELECT EmpleadoId
			FROM HistorialPuntosEmpleados AS T1
			INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
			WHERE Fisico=1 AND FechaBaja='0000-00-00' AND ClasificacionPersonalventa=$CanalVentaId
			)";
		$this->Consulta($Q0);
}


function getReporteSigi()
{
	$MisPuntos=$this->getMisPuntos();
	$Q0="SELECT 'Año', 'Mes', 'Region', 'Plaza', 'Sucursal', 'Fecha Captura', 'Folio',
		'Fecha Activacion', 'Estatus', 'Radios', 'Fecha Finalizacion', 'Punto de Venta',
		'Coordinador', 'Cliente', 'Plan', 'Equipo', 'Tipo Contratacion', 'Otro Servicio',
		'Notas', 'Asesor', 'Cadena comercial', 'Categoria', 'SubCategoria', 'Capacidad',
		'Comentarios','Promocion', 'Pos Pago/Pre Pago',	'Conectividad',	'Estatus Coordinador',
		'Fecha Alta Puesto Coordinador', 'Clasificacion Punto Venta', 'Clase', 'Usuario que Captura',
		'Estatus Punto de Venta','Renta','Imei','Sim Card','Id','Telefono','Cuenta','Incidente','Efectivo',
		'Debito','Credito','NombreNextel','Deposito','Depositovalidado','Ejecutivo Senior','Renta Plan',
		'Bracket Access Fee','RegistroId','Responsable','Alias','UsuarioFP','SIM','Plazo'
		UNION
	SELECT
       DATE_FORMAT(FechaContrato,'%Y') AS Año,
       CASE DATE_FORMAT(FechaContrato,'%m')
         WHEN '01' THEN 'ENERO'
         WHEN '02' THEN 'FEBRERO'
         WHEN '03' THEN 'MARZO'
         WHEN '04' THEN 'ABRIL'
         WHEN '05' THEN 'mayo'
         WHEN '06' THEN 'JUNIO'
         WHEN '07' THEN 'JULIO'
         WHEN '08' THEN 'AGOSTO'
         WHEN '09' THEN 'SEPTIEMBRE'
         WHEN '10' THEN 'OCTUBRE'
         WHEN '11' THEN 'NOVIEMBRE'
         WHEN '12' THEN 'DICIEMBRE'
       END AS Mes,
       Region,
       SubRegion,
       Plaza,
       DATE_FORMAT(FechaCaptura,'%d/%m/%Y') AS FechaCaptura,
       T1.Folio,
       DATE_FORMAT(FechaSS,'%d/%m/%Y') AS FechaActivacion,
       T7.Estatus,
       1 AS Radios,
       '00/00/0000' AS FechaFinalizacion,
       PuntoVenta,
       CONCAT_WS(' ', T8.Nombre, T8.Paterno, T8.Materno) AS Coordinador,
       CONCAT_WS(' ', T9.Nombre, T9.Paterno, T9.Materno) AS Cliente,
       Plan,
       #CONCAT(Sigi,' ',IFNULL(AddOn,'')),
       Equipo, Contratacion,
       AddOn AS'Otros Servicios',
       '' AS Notas,
       CONCAT_WS(' ', T15.Nombre, T15.Paterno, T15.Materno) AS Asesor,
       '' AS CadenaComercial, Puesto, T17.SubCategoria, '' AS Capacidad,
       T1.Comentarios, Familia,
       IF(Prepago=1,'Pree Pago','Post Pago'),
       'Voz y Datos' AS Conectividad,
       EstatusCoordinador, FechaAltaPuestoCoordinador,
       '' AS ClasificacionPuntoVenta,
       '' AS Clase,
       CONCAT_WS(' ', T20.Nombre, T20.Paterno, T20.Materno) AS Usuario,
       IF(T2.SubDistribuidorId=1, 'Opera Sub', 'Operando') AS EstatusPuntoVenta,
       T2.Renta,
       T6.Serie,
       '' AS Sim,
       '' AS Id,
       '' AS Telefono,
       '' AS Cuenta,
       '' AS Incidente,
       0 AS Efectivo,
       0 AS Debito,
       0 AS Credito,
       NombreNextel,
       '' AS Deposito,
       '' AS DepositoValidado,
       '' AS EjecutivoSenior,
       T6.Costo AS RentaPlan,
       IF(T6.Costo<600,' <600', IF(T6.Costo=600, ' =600', IF(T6.Costo>1000,' >1000',' >600'))) AS BracketAccessFee,
       T6.RegistroId,
       '' AS Responsable,
       '' AS Alias,
       UsuarioFP,
       '' AS Sim,
       T21.Plazo
FROM HFolios AS T1
INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
INNER JOIN Plazas AS T3 ON T3.PlazaId=T2.PlazaId
INNER JOIN SubRegiones AS T4 ON T4.SubRegionId=T3.SubRegionId
INNER JOIN Regiones AS T5 ON T5.RegionId=T4.RegionId
INNER JOIN LFolios AS T6 ON T6.Folio=T1.Folio
INNER JOIN Estatus AS T7 ON T7.EstatusId=T6.EstatusId
INNER JOIN Empleados AS T8 ON T8.EmpleadoId=T1.CoordinadorId
INNER JOIN Clientes AS T9 ON T9.ClienteId=T1.ClienteId
INNER JOIN Planes AS T10 ON T10.PlanId=T6.PlanId
LEFT JOIN (
            SELECT RegistroId, GROUP_CONCAT(AddonTxt SEPARATOR ' ') AS AddOn
            FROM LineasAddon AS T1
            INNER JOIN Addon AS T2 ON T2.AddonId=T1.AddonId
            GROUP BY RegistroId
          ) AS T11 ON T11.RegistroId=T6.RegistroId
LEFT JOIN Equipos AS T12 ON T12.EquipoId=T6.EquipoId
LEFT JOIN Contrataciones AS T13 ON T13.ContratacionId=T1.ContratacionId
LEFT JOIN HistorialPuestosEmpleados AS T14 ON T14.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
LEFT JOIN Empleados AS T15 ON T15.EmpleadoId=T14.EmpleadoId
LEFT JOIN Puestos AS T16 ON T16.PuestoId=T14.PuestoId
LEFT JOIN SubCategorias AS T17 ON T17.SubCategoriaId=T14.SubCategoriaId
LEFT JOIN (
          SELECT T1.EmpleadoId,
                 IF(FechaBaja!='0000-00-00', 'Baja', T3.Puesto) AS EstatusCoordinador,
                 DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAltaPuestoCoordinador
          FROM HistorialPuestosEmpleados AS T1
          INNER JOIN
                  (
                   SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId, EmpleadoId
                   FROM HistorialPuestosEmpleados
                   GROUP BY EmpleadoId
                   ) AS T2 ON T2.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
           LEFT JOIN Puestos AS T3 ON T3.PuestoId=T1.PuestoId
          ) AS T18 ON T18.EmpleadoId=T1.CoordinadorId
LEFT JOIN Usuarios AS T19 ON T19.UsuarioId=T1.UsuarioId
LEFT JOIN Empleados AS T20 ON T20.EmpleadoId=T19.EmpleadoId
LEFT JOIN Plazos AS T21 ON T21.PlazoId=T6.PlazoId
WHERE T2.ClasificacionPersonalVenta=6 AND FechaSS>'2016-04-30' ";

return $this->Consulta($Q0);
}

function getInfoSerie($Serie)
	{
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>PUNTO_VENTA</th>
							<th>FOLIO</th>
							<th>ESTATUS</th>
							<th>PLAN</th>
							<th>ADDON</th>
							<th>CONTRATO</th>
							<th>DN</th>
							<th>FECHA_CAPTURA</th>
							<th>HORA_CAPTURA</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT PuntoVenta, T1.Folio, Estatus, Plan, Addon, Contrato, DN, DATE_FORMAT(T4.Fecha,'%d-%m-%Y'), T4.Hora
			FROM LFolios AS T1
			INNER JOIN Planes AS T2 ON T2.PlanId=T1.PlanId
			LEFT JOIN (
			            SELECT RegistroId, GROUP_CONCAT(Addon SEPARATOR ' - ') AS Addon
			            FROM LineasAddon AS T1
			            INNER JOIN Addon AS T2 ON T2.AddonId=T1.AddonId
			            GROUP BY RegistroId
			           ) AS T3 ON T3.RegistroId=T1.RegistroId
			INNER JOIN Bitacora AS T4 ON T4.ObjetoId=T1.RegistroId AND T4.ModuloId=24
			LEFT JOIN Estatus AS T5 ON T5.EstatusId=T4.Host
			LEFT JOIN HFolios AS T6 ON T6.Folio=T1.Folio
			LEFT JOIN PuntosVenta AS T7 ON T7.PuntoVentaId=T6.PuntoVentaId
		WHERE T1.Serie='$Serie'
		ORDER BY T1.RegistroId
		";
		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td>'.utf8_decode($A0[5]).'</td>
							<td>'.utf8_decode($A0[6]).'</td>
							<td>'.utf8_decode($A0[7]).'</td>
							<td>'.utf8_decode($A0[8]).'</td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getClientetoAsignacion($PuntoVentaId)
{
	$Q0="SELECT SeguimientoId, Nombre_Cliente, Estado, Municipio, Telefono, Direccion, Colonia, Observaciones
		FROM SeguimientoClientes AS T1
		LEFT JOIN Clientes AS T2 ON T2.ClienteId=T1.SeguimientoId
		WHERE PuntoVentaRevision=$PuntoVentaId AND PuntoVentaId=0
		ORDER BY TipoPersonaId DESC, RAND()
		LIMIT 1";

	return mysql_fetch_row($this->Consulta($Q0));
}

function ScrollPuntosVenta($valor)
{
	$MisPuntos=$this->getMisPuntos();
	$query="SELECT PuntoVentaId, PuntoVenta
			FROM PuntosVenta
			WHERE PuntoVentaId IN ($MisPuntos) AND Activo=1
			ORDER BY PuntoVenta
				";
		$resultado=mysql_query("$query", $this->conexion) or die(mysql_error());

		while($arreglo=mysql_fetch_row($resultado))
		{
			if ($valor==$arreglo[0])
			{
				echo "<option selected value=\"$arreglo[0]\" title=\"".utf8_decode($arreglo[1])."\" >".utf8_decode($arreglo[1])."</option> \n";
			}
			else
			{
				echo "<option value=\"$arreglo[0]\" title=\"$arreglo[1]\">".utf8_decode($arreglo[1])."</option> \n";
			}
		}
	}//Scroll

function setPuntoCliente($ClienteId, $PuntoVentaId)
{
	$Q0="UPDATE SeguimientoClientes
		SET PuntoVentaId=$PuntoVentaId
		WHERE SeguimientoId=$ClienteId";
	$this->Consulta($Q0);
}

function LeerSerieAjusteN($Serie, $PuntoVentaId, $Clave)
{
	$Equipo=$this->validaSeriePunto($Serie, $PuntoVentaId);

	if($Equipo)
	return utf8_decode($Equipo);

		return utf8_decode('<span class="alerta">¡Equipo elegido No Valido!</span>');

	$Q0="SELECT COUNT(T1.EquipoId), IFNULL(T1.EquipoId,0), IF(T2.Serie IS NULL, 0,1), T1.AlmacenId, T1.PlataformaId FROM OrdenesCompra AS T1
		 LEFT JOIN Lectura AS T2 ON T2.Serie=T1.Serie
		 WHERE Factura='$Factura'
		 AND T1.Serie='$Serie'";
	list($Cta, $EquipoId, $Recibido, $AlmacenId, $PlataformaId)=mysql_fetch_row($this->Consulta($Q0));
	if($Cta==0)
	{
		$Q1="INSERT IGNORE INTO LecturaInvalida (Factura, Serie, UsuarioId, Fecha, Hora)
			VALUES('$Factura', '$Serie', $this->UsuarioId, CURDATE(), CURTIME())";
		$this->Consulta($Q1);
		return 'Invalido';
	}
	if($EquipoId>0 & $Recibido==0)
	return $this->addLectura($Serie, $Clave, $EquipoId, $AlmacenId, $PlataformaId);
	if($Recibido==1)
	return 'Existe';
}

function addValidacion($Folio, $DocIdentificacion, $DocDomicilio, $DocValidacion, $Observacion, $Nombre, $Paterno, $Materno, $PuntoventaId,$DescEquipos, $DescPlanes, $Telefono, $Ife, $Buro, $Calle, $Nexterior, $Ninterior, $ColoniaId, $MiColonia)
{
	if($ColoniaId==0)
	{
		$QA="SELECT coloniaId FROM Colonias WHERE Colonia=UCASE('$MiColonia') ORDER BY ColoniaId DESC limit 1";
			list($cta)=mysql_fetch_row($this->Consulta($QA));
			if(isset($cta))
				$ColoniaId=$cta;
	}

	$Q0="INSERT INTO ValidacionVenta (ValidacionId, Folio, EstatusValidacionId, DocIdentificacion, DocDomicilio, DocValidacion, Fecha, Hora, UsuarioId, UsuarioValidacionId, Observaciones, ObservacionesValidacion, FechaValidacion, HoraValidacion, NombreCliente, PaternoCliente, MaternoCliente, PuntoVentaId, DescEquipos, DescPlanes, Telefono, EstatusNoeId, FechaEstatus, DocIfe, DocBuro, Calle, Nexterior, Ninterior, ColoniaId, bloqueado)
                      VALUES(NULL, UCASE('$Folio'), 3, '$DocIdentificacion', '$DocDomicilio', '$DocValidacion', CURDATE(), CURTIME(), $this->UsuarioId, 0,UCASE('$Observacion'), '', '0000-00-00', '00:00:00', UCASE('$Nombre'), UCASE('$Paterno'), UCASE('$Materno'), '$PuntoventaId', UCASE('$DescEquipos'), UCASE('$DescPlanes'), '$Telefono', 0 , '0000-00-00', '$Ife', '$Buro', UCASE('$Calle'), UCASE('$Nexterior'), UCASE('$Ninterior'), $ColoniaId,0)";
		$this->StartTransaccion();

		if($this->Consulta($Q0) & $this->addBitacora(70, 2, mysql_insert_id(), 'Validacion '.$Folio, ''))
		{
			$this->AceptaTransaccion();

			return utf8_decode('<span class="notificacion">¡Los datos se actualizaron correctamente!</span>');

		}
		$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
}

function getValidacionVenta($ObjetoId)
{
	$Q0="SELECT Folio, DocIdentificacion, DocDomicilio, DocValidacion, Observaciones, T1.EstatusValidacionId,
		EstatusValidacion, ObservacionesValidacion, NombreCliente, PaternoCliente, MaternoCliente, Telefono,
		T1.PuntoVentaId,PuntoVenta, DescEquipos, DescPlanes, EstatusNoeId, DATE_FORMAT(FechaEstatus,'%d/%m/%Y'),
		DocIfe, DocBuro, T1.Calle, T1.Nexterior, T1.Ninterior, CodigoPostal, Colonia, T1.ColoniaId, bloqueado
		FROM ValidacionVenta AS T1
		LEFT JOIN EstatusValidacion AS T2 ON T2.EstatusValidacionId=T1.EstatusValidacionId
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
		LEFT JOIN Colonias AS T4 ON T4.ColoniaId=T1.ColoniaId
		WHERE ValidacionId IN ($ObjetoId 0)";
		return mysql_fetch_row($this->Consulta($Q0));
}

function actualizaValidacion($ValidacionId, $EstatusValidacionId, $Observaciones, $EstatusNoeId, $FechaEstatus, $Nombre,$Paterno,
	$Materno,$Telefono,$PuntoVentaId,$DescEquipos,$DescPlanes,$Calle,$NExterior,$NInterior,$ColoniaId, $EstatusValidacionIdOld)
{
	$acceso=$this->getPermisoEspecial(13);
	if(!$acceso)
	{
			$Q0="UPDATE ValidacionVenta
			SET EstatusValidacionId=3,
			NombreCliente=UCASE('$Nombre'),
			PaternoCliente=UCASE('$Paterno'),
			MaternoCliente=UCASE('$Materno'),
			Telefono='$Telefono',
			Calle='$Calle',
			NExterior='$NExterior',
			NInterior='$NInterior',
			ColoniaId=$ColoniaId,
			Hora=CURTIME(),
			Fecha=CURDATE(),
			PuntoVentaId=$PuntoVentaId,
			DescEquipos='$DescEquipos',
			DescPlanes='$DescPlanes',
			Observaciones='$Observaciones'
			WHERE ValidacionId IN ($ValidacionId 0)";
	$this->Consulta($Q0);
	return true;
	}
/*
	$QA="SELECT Bloqueado AS Cta FROM ValidacionVenta
		WHERE ValidacionId IN ($ValidacionId 0)";
		list($cta)=mysql_fetch_row($this->Consulta($QA));
		if($cta!=$this->UsuarioId)
		return false;
*/
/*
	if($EstatusValidacionIdOld==2)
		$EstatusValidacionId=3;
*/
	if($FechaEstatus=='00/00/0000')
		$FechaEstatus='0000-00-00';
	else
	$FechaEstatus=$this->CambiarFormatoFecha($FechaEstatus);

	$Q0="UPDATE ValidacionVenta
			SET EstatusValidacionId=$EstatusValidacionId,
			UsuarioValidacionId=$this->UsuarioId,
			ObservacionesValidacion='$Observaciones',
			FechaValidacion=CURDATE(),
			HoraValidacion=CURTIME(),
			EstatusNoeId=$EstatusNoeId,
			FechaEstatus='$FechaEstatus'
			WHERE ValidacionId IN ($ValidacionId 0)";
	$this->Consulta($Q0);
}

function getBuscaFolioCoincidentes($Folio)
	{
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>Folio</th>
							<th>Plataforma</th>
							<th>Fecha_Captura</th>
							<th>PuntoVenta</th>
							<th>Tipo Transaccion</th>
							<th>Selecciona</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		if($Folio=='')
		$Q0="SELECT '', '', '', '',''";
		else
		$Q0= "SELECT Folio, Plataforma, DATE_FORMAT(FechaCaptura, '%d/%m/%Y'), PuntoVenta, IF(MovimientoId=0,'SIN INVENTARIO', 'CON INVENTARIO')
				FROM HFolios AS T1
				INNER JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
				LEFT JOIN Plataformas AS T3 ON T3.PlataformaId=T1.PlataformaId
				WHERE Folio LIKE '%$Folio%'
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td align="center"><img src="img/Select.png" style="cursor:pointer;" onclick="seleccionaFolio(\''.$A0[0].'\')" /></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
}

function getHFolioEdit($Folio)
{
	$Q0="SELECT T1.Folio,
	       DATE_FORMAT(T1.FechaCaptura, '%d/%m/%Y'),
	       DATE_FORMAT(T1.FechaSS, '%d/%m/%Y'),
	       T1.PuntoVentaId,
	       T2.PuntoVenta,
	       T1.HistorialPuestoEmpleadoId,
	       CONCAT_WS(' ', T4.Nombre, T4.Paterno, T4.Materno),
	       T1.CoordinadorId,
	       CONCAT_WS(' ', T5.Nombre, T5.Paterno, T5.Materno),
	       T1.ClienteId,
	       CONCAT_WS(' ', T6.Nombre, T6.Paterno, T6.Materno),
	       T1.TipoContratacionId,
	       T7.TipoContratacion,
	       T1.TipoPagoId,
	       T8.TipoPago,
	       T1.Comentarios,
	       T1.ContratacionId,
	       T9.Contratacion,
	       T2.ClasificacionpersonalVenta
	FROM HFolios AS T1
	LEFT JOIN PuntosVenta AS T2 ON T2.PuntoVentaId=T1.PuntoVentaId
	LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.HistorialPuestoEmpleadoId=T1.HistorialPuestoEmpleadoId
	LEFT JOIN Empleados AS T4 ON T4.EmpleadoId=T3.EmpleadoId
	LEFT JOIN Empleados AS T5 ON T5.EmpleadoId=T1.CoordinadorId
	LEFT JOIN Clientes AS T6 ON T6.ClienteId=T1.ClienteId
	LEFT JOIN TiposContratacion AS T7 ON T7.TipoContratacionId=T1.TipoContratacionId
	LEFT JOIN TiposPago AS T8 ON T8.TipoPagoId=T1.TipoPagoId
	LEFT JOIN Contrataciones AS T9 ON T9.ContratacionId=T1.ContratacionId
	WHERE T1.Folio = '$Folio'
	LIMIT 1";
	return mysql_fetch_row($this->Consulta($Q0));
}

function getLFolioEdit($Folio)
{
	$Q0="SELECT T1.RegistroId,
				Serie,
				T1.PlanId,
				T1.EquipoId,
				T1.PlazoId,
				T1.EstatusId,
		        T1.Costo,
		        Comentario,
		        DATE_FORMAT(FechaEstatus,'%d/%m/%Y'),
		        Contrato, Dn, Diferencial,
		        TipoPagoDiferencial,
		        MovimientoId,
		        Equipo
		FROM LFolios AS T1
		INNER JOIN HFolios AS T2 ON T2.Folio=T1.Folio
		LEFT JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
		WHERE T1.Folio='$Folio'";
return $this->Consulta($Q0);
}


function ActualizaHFolio($Folio,$FechaContrato, $PuntoVentaId, $VendedorId, $CoordinadorId,
						 $ClienteId, $TipoContratacionId, $TipoPagoId, $Comentarios,
						 $ContratacionId, $FolioOld, $PuntoVentaIdOld)
{

	$Qx="SELECT COUNT(RegistroId) FROM LFolios WHERE EstatusId=14 AND Folio='$FolioOld'";
	list($Lineas)=mysql_fetch_row($this->Consulta($Qx));

	$Qy="SELECT COUNT(Folio) FROM HFolios WHERE Folio='$Folio' AND Folio!='$FolioOld'";
	list($Existe)=mysql_fetch_row($this->Consulta($Qy));

	$FechaContrato=$this->CambiarFormatoFecha($FechaContrato);
	$Q0="UPDATE HFolios
	SET Folio=UCASE('$Folio'),
	FechaSS='$FechaContrato',
	PuntoVentaId=$PuntoVentaId,
	HistorialPuestoEmpleadoId=$VendedorId,
	CoordinadorId=$CoordinadorId,
	ClienteId=$ClienteId,
	TipoContratacionId=$TipoContratacionId,
	TipoPagoId=$TipoPagoId,
	ContratacionId=$ContratacionId,
	Comentarios='$Comentarios'
	WHERE Folio='$FolioOld'";

	if($Existe)
	{
		echo 'El folio al que intenta cambiar ya existe, no es posible realizar el cambio';
		return false;
	}

	if($PuntoVentaId!=$PuntoVentaIdOld & $Lineas>0)
	{
		echo 'No es posible actualizar el Punto de Venta si existen movimientos de inventario';
		return false;
	}

$this->StartTransaccion();
	if($this->Consulta($Q0) & $this->addBitacora(71, 5, 0, 'Actualizacion de folio', $Folio))
	{
		$this->AceptaTransaccion();
		echo 'Los datos se actualizaron correctamente';
	}
	else
	{
		$this->CancelaTransaccion();
		echo 'No fue posible actualizar los datos';
	}
}

function actualizaRegistro($RegistroId, $PlanId, $EquipoId, $EstatusId, $PlazoId, $FechaEstatus, $Contrato,
	$Dn, $Diferencial, $TipoPagoDiferencial, $Observaciones, $MovimientoId, $Serie, $EstatusIdOld)
{

	$Qy="SELECT TipoPlanId FROM TiposPlanPlanes WHERE PlanId=$PlanId LIMIT 1";
	list($TipoPlanId)=mysql_fetch_row($this->Consulta($Qy));
	$Bandera=true;
	$FechaEstatus=$this->CambiarFormatoFecha($FechaEstatus);
	$Q0="UPDATE LFolios
		 SET PlanId=$PlanId,
		 EquipoId=$EquipoId,
		 PlazoId=$PlazoId,
		 TipoPlanId=$TipoPlanId,
		 EstatusId=$EstatusId,
		 Comentario='$Observaciones',
		 FechaEstatus='$FechaEstatus',
		 Contrato='$Contrato',
		 Dn='$Dn',
		 Diferencial=$Diferencial,
		 TipoPagoDiferencial=$TipoPagoDiferencial
		 WHERE RegistroId=$RegistroId
		 ";
	$this->StartTransaccion();
	if($MovimientoId>0 & $EstatusId==13 & $EstatusIdOld==14)
	{
		$Q1="DELETE FROM Inventario WHERE Serie='$Serie' AND Activacion!='0000-00-00' LIMIT 1";

		$Q2="SELECT MAX(MovimientoId) FROM Inventario WHERE Serie='$Serie' AND Cantidad=0";
		list($NewMovimientoId)=mysql_fetch_row($this->Consulta($Q2));
		$Q3="UPDATE Inventario
				SET Cantidad=1
				WHERE Serie='$Serie' AND MovimientoId=$NewMovimientoId";
		$Q4="DELETE FROM Disponibles WHERE Serie='$Serie'";
		if(!$this->Consulta($Q2) || !$this->Consulta($Q3))
			$Bandera=false;
	}

	$Q5="UPDATE LFolios AS T1 INNER JOIN (
		SELECT T1.RegistroId,
		   	 IFNULL(CostoPlan,0)+IFNULL(SUM(CostoAddOn),0) AS Costo
		FROM LFolios AS T1
		 	   		 LEFT JOIN LineasAddon AS T2 ON T2.RegistroId=T1.RegistroId
				     LEFT JOIN PreciosPlanes AS T3 ON T3.PlanId=T1.PlanId AND T3.AddOnId=IFNULL(T2.AddOnId,0)
		WHERE RegistroId=$RegistroId
		GROUP BY T1.RegistroId
		) AS T2 ON T2.RegistroId=T1.RegistroId
		SET T1.Costo=T2.Costo";
	if($this->Consulta($Q0) & $this->addBitacora(71, 5, $RegistroId, 'Actualizacion de Registro', '') & $Bandera)
	{

		$this->AceptaTransaccion();
		echo 'Los datos se actualizaron correctamente';
	}
	else
	{
		echo 'No fue posible actualizar los datos';
		$this->CancelaTransaccion();
	}
}

	function getListaUsuariosPendientes()
	{
		$Cadena='<table id="MiTabla2" >
					<thead>
						<tr>
							<th>Numero de Control</th>
							<th>Usuario</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.EmpleadoId, CONCAT_WS(' ', Nombre, paterno, Materno) AS Empleado
				FROM Empleados AS T1
				LEFT JOIN Usuarios AS T2 ON T2.EmpleadoId=T1.EmpleadoId
				LEFT JOIN HistorialPuestosEmpleados AS T3 ON T3.EmpleadoId=T1.EmpleadoId
				INNER JOIN (
				            SELECT MAX(HistorialPuestoEmpleadoId) AS HistorialPuestoEmpleadoId
				            FROM HistorialPuestosEmpleados
				            GROUP BY EmpleadoId
				          ) AS T4 ON T4.HistorialPuestoEmpleadoId=T3.HistorialPuestoEmpleadoId
				WHERE T2.EmpleadoId IS NULL AND T3.FechaBaja='0000-00-00'
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.$A0[0].'</td>
							<td>'.$A0[1].'</td>
							<td align="center"><input type="radio" name="VId" id="VId" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,12)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function altaUsuario($EmpleadoId)
{

$QA="SELECT Correo FROM CorreosEmpleados where EmpleadoId=$EmpleadoId";
list($Correo)=mysql_fetch_row($this->Consulta($QA));
$Q0="SELECT T3.UsuarioId FROM HistorialPuestosEmpleados AS T1
		INNER JOIN HistorialPuestosEmpleados AS T2 ON T2.PuestoId=T1.PuestoId
		INNER JOIN Usuarios AS T3 ON T3.EmpleadoId=T1.EmpleadoId
		WHERE T2.EmpleadoId=$EmpleadoId AND T2.FechaBaja='0000-00-00' AND T1.FechaBaja='0000-00-00'
		AND T2.EmpleadoId!=T1.EmpleadoId
		LIMIT 1";

list($OldUsuarioId)=mysql_fetch_row($this->Consulta($Q0));

$Q1="INSERT INTO Usuarios
	 SELECT NULL, $EmpleadoId, md5('12345'), Corporativo, Nacionales, 1, 0,0,0 FROM Usuarios
	 WHERE UsuarioId=$OldUsuarioId
	";
$this->Consulta($Q1);

$NewUsuarioId=mysql_insert_id();
$Q3="INSERT IGNORE INTO ModulosOperacionesUsuarios
	SELECT ModuloOperacionId, $NewUsuarioId FROM ModulosOperacionesUsuarios WHERE UsuarioId=$OldUsuarioId";
$Q4="INSERT IGNORE INTO ConsultasUsuarios
	SELECT ConsultaId, $NewUsuarioId FROM ConsultasUsuarios WHERE UsuarioId=$OldUsuarioId";
$this->StartTransaccion();

	if($this->Consulta($Q3) & $this->Consulta($Q4))
	{
		$this->AceptaTransaccion();
		return $Correo;
	}
	$this->CancelaTransaccion();
	return 'FAIL';
}

function reingresaPersonal($EmpleadoId, $PuestoId, $SubCategoriaId, $FechaReingreso, $Operador, $Porcentaje, $ClasificacionpersonalVenta)
{
	$EmpleadoId=str_replace(",", "", $EmpleadoId);
	$FechaReingreso=$this->CambiarFormatoFecha($FechaReingreso);
	$Q0="INSERT INTO HistorialPuestosEmpleados (HistorialPuestoEmpleadoId, EmpleadoId, PuestoId, SubCategoriaId, FechaAlta, FechaBaja, CausaBajaId, Operador, Porcentaje, ClasificacionPersonalVentaId, Finiquito)
		 VALUES(NULL, $EmpleadoId, $PuestoId, $SubCategoriaId, '$FechaReingreso', '0000-00-00', 0, '$Operador', $Porcentaje, $ClasificacionpersonalVenta,0)";
	$Q1="INSERT INTO HistorialPuntosEmpleados
		SELECT NULL, EmpleadoId, PuntoVentaId, '$FechaReingreso', '0000-00-00', 1 FROM HistorialPuntosEmpleados WHERE Fisico=1 AND EmpleadoId=$EmpleadoId ORDER BY HistorialPuntosEmpleadoId DESC LIMIT 1";


	$this->StartTransaccion();
	if($this->Consulta($Q0) & $this->Consulta($Q1) & $this->Consulta($Q2))
	{
		$this->AceptaTransaccion();
		return 'OK';
	}
	$this->CancelaTransaccion();
	return 'FAIL';
}

	function getListaPuntosB()
	{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla2" >
					<thead>
						<tr>
							<th>#PuntoVenta</th>
							<th>Region</th>
							<th>SunRegion</th>
							<th>Plaza</th>
							<th>Punto de Venta</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.PuntoVentaId, Region, SubRegion, Plaza, PuntoVenta FROM PuntosVenta AS T1
			  LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
			  LEFT JOIN SubRegiones AS T3 ON T3.SubRegionId=T2.SubRegionId
			  LEFT JOIN Regiones AS T4 ON T4.RegionId=T3.RegionId
			  WHERE PuntoVentaId IN ($MisPuntos) AND T1.Activo=1
			  ORDER BY PuntoVenta ASC
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,13)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

	function getListaPuntosValidacion()
	{
		$MisPuntos=$this->getMisPuntos();
		$Cadena='<table id="MiTabla" >
					<thead>
						<tr>
							<th>#PuntoVenta</th>
							<th>Region</th>
							<th>SunRegion</th>
							<th>Plaza</th>
							<th>Punto de Venta</th>
							<th>Elige</th>
						</tr>
					</thead>
					<tbody>';
		$t=true;
		$Q0= "SELECT T1.PuntoVentaId, Region, SubRegion, Plaza, PuntoVenta FROM PuntosVenta AS T1
			  LEFT JOIN Plazas AS T2 ON T2.PlazaId=T1.PlazaId
			  LEFT JOIN SubRegiones AS T3 ON T3.SubRegionId=T2.SubRegionId
			  LEFT JOIN Regiones AS T4 ON T4.RegionId=T3.RegionId
			  WHERE PuntoVentaId IN ($MisPuntos) AND T1.Activo=1 AND Validacion=1
			  ORDER BY PuntoVenta ASC
			  ";

		$R0=$this->Consulta($Q0);
		while($A0=mysql_fetch_row($R0))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				$Cadena.='
						<tr '.$Clase.'>
							<td>'.utf8_decode($A0[0]).'</td>
							<td>'.utf8_decode($A0[1]).'</td>
							<td>'.utf8_decode($A0[2]).'</td>
							<td>'.utf8_decode($A0[3]).'</td>
							<td>'.utf8_decode($A0[4]).'</td>
							<td align="center"><input type="radio" name="Punto" id="Punto" class="Pt" value="'.$A0[0].'" onclick="setEleccion(this,2)"/></td>
						</tr>
				';
			$t=(!$t);
		}
				$Cadena.='</tbody>
						</table>';
		return $Cadena;
	}

function getIncidenciasTelefonos($Telefono)
{
	$Q0="SELECT COUNT(validacionId), GROUP_CONCAT(CONCAT('#Validacion: ',ValidacionId, ' - Folio:',Folio) SEPARATOR '<BR>')
		 FROM ValidacionVenta
		 WHERE telefono='$Telefono'
		 GROUP BY telefono
		";
	list($cta, $telefonos)=mysql_fetch_row($this->Consulta($Q0));
	if($cta>1)
		return '<span class="atencion">ATENCION: Telefono duplicado</span><br><br>'.$telefonos;
	return '';
}


function getIncidenciasClientes($Cliente)
{
	$Q0="SELECT COUNT(ValidacionId), GROUP_CONCAT(CONCAT('#Validacion: ',ValidacionId, ' - Folio:',Folio) SEPARATOR '<BR>')
		FROM ValidacionVenta
		WHERE CONCAT_WS(' ',NombreCliente, PaternoCliente, MaternoCliente)='$Cliente'
		GROUP BY CONCAT(NombreCliente, PaternoCliente, MaternoCliente)
		";
	list($cta,$clientes)=mysql_fetch_row($this->Consulta($Q0));
		if($cta>1)
		return '<span class="atencion">ATENCION: Cliente duplicado</span><br><br>'.$clientes;
	return '';
}

function getPermisoEspecial($Permiso){
	$Q0="SELECT COUNT(UsuarioId) AS Cta FROM ModulosOperacionesUsuarios AS T1
		INNER JOIN ModulosOperaciones AS T2 ON T2.ModuloOperacionId=T1.ModuloOperacionId
		WHERE OperacionId=$Permiso AND UsuarioId=$this->UsuarioId";
		list($cta)=mysql_fetch_row($this->Consulta($Q0));
		if($cta>0)
		return true;
	return false;
}

function getPlataformaFolio($Folio)
{
	$PlataformaId=0;
	$Q0="SELECT PlataformaId FROM HFolios WHERE Folio='$Folio'";
	list($PlataformaId)=mysql_fetch_row($this->Consulta($Q0));
	return $PlataformaId;
}

function ponBloqueoValidacion($ValidacionId){
	$Q0="UPDATE ValidacionVenta
		 SET bloqueado=$this->UsuarioId
		 WHERE ValidacionId IN ($ValidacionId 0)";
	$this->Consulta($Q0);
}

function addColonia($cp, $colonia)
{
	$Q0="INSERT INTO Colonias (ColoniaId, MunicipioId, colonia, CodigoPostal, Activo)
			VALUES(NULL, 1, UCASE('$colonia'), '$cp', 1)";
return $this->Insertar($Q0);

}

function getReporteValidaciones()
{
	$Q0="SELECT 'ID', 'FOLIO', 'ESTATUS', 'FECHA', 'HORA', 'OBSERVACIONES', 'OBSERVACIONES VALIDACION', 'FECHA_VALIDACION', 'HORA_VALIDACION','CLIENTE', 'PUNTO_VENTA', 'EQUIPOS', 'PLANES', 'TELEFONO',
		'CALLE', 'N EXTERIOR', 'N INTERIOR', 'COLONIA', 'ESTATUS_NOE', 'FECHA_ESTATUS_NOE', 'SOLICITANTE', 'USUARIO_VALIDACION'
		UNION
		SELECT ValidacionId, Folio, EstatusValidacion, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha, Hora,
		Observaciones, ObservacionesValidacion, DATE_FORMAT(FechaValidacion, '%d/%m/%Y') AS Fecha, HoraValidacion,
		CONCAT_WS(' ',NombreCliente, PaternoCliente, MaternoCliente), PuntoVenta, DescEquipos, DescPlanes, Telefono, T1.Calle, T1.Nexterior,
		T1.Ninterior, Colonia, EstatusNoe, DATE_FORMAT(FechaEstatus, '%d/%m/%Y'),
		CONCAT_WS(' ',T6.Nombre,T6.Paterno, T6.Materno) AS Solicitante,
		CONCAT_WS(' ',T8.Nombre,T8.Paterno, T8.Materno) AS UsuarioValidacion
		FROM ValidacionVenta AS T1
		INNER JOIN EstatusValidacion AS T2 ON T2.EstatusValidacionId=T1.EstatusValidacionId
		LEFT JOIN PuntosVenta AS T3 ON T3.PuntoVentaId=T1.PuntoVentaId
		LEFT JOIN Colonias AS T4 ON T4.ColoniaId=T1.ColoniaId
		LEFT JOIN Usuarios AS T5 ON T5.usuarioId=T1.UsuarioId
		LEFT JOIN Empleados AS T6 ON T6.EmpleadoId=T5.EmpleadoId
		LEFT JOIN Usuarios AS T7 ON T7.usuarioId=T1.UsuarioValidacionId
		LEFT JOIN Empleados AS T8 ON T8.EmpleadoId=T7.EmpleadoId
		LEFT JOIN EstatusNoe AS T9 ON T9.EstatusNoeId=T1.EstatusNoeId
		WHERE IFNULL(historico,0) = 0
		";
	return $this->Consulta($Q0);
}
function getReporteRotacionEquipos()
{
	$Q0="SELECT 'Equipo', 'Serie', 'Punto Recepcion', 'Fecha Recepcion', 'Punto Venta', 'Fecha Venta', 'Ejecutivo', 'Dias en almacen'
		UNION
		SELECT T3.Equipo, T1.serie, T4.PuntoVenta AS PuntoVentaRecepcion, T2.Fecha AS FechaRecepcion,
       	T9.PuntoVenta AS PuntoVentaVenta, T5.Activacion AS FechaVenta, CONCAT_WS(' ', T11.nombre, T11.paterno, T11.materno) AS Ejecutivo,
       	DATEDIFF(T5.Activacion, T2.Fecha) AS dias
		FROM Inventario AS T1
		INNER JOIN Recepciones AS T2 ON T2.MovimientoId=T1.MovimientoId AND T2.TipoMovimientoId=1
		INNER JOIN Equipos AS T3 ON T3.EquipoId=T1.EquipoId
		INNER JOIN PuntosVenta AS T4 ON T4.PuntoVentaId=T2.PuntoVentaId
		INNER JOIN Inventario AS T5 ON T5.serie=T1.serie AND T5.Activacion!='0000-00-00'
		INNER JOIN LFolios AS T7 ON T7.serie=T5.serie
		INNER JOIN HFolios AS T8 ON T8.Folio=T7.Folio
		INNER JOIN PuntosVenta AS T9 ON T9.PuntoVentaId=T8.PuntoVentaId
		INNER JOIN HistorialPuestosEmpleados AS T10 ON T10.HistorialPuestoEmpleadoId=T8.HistorialPuestoEmpleadoId
		INNER JOIN Empleados AS T11 ON T11.EmpleadoId= T10.EmpleadoId WHERE T2.Fecha=date_sub(CURDATE(), INTERVAL 3 MONTH)

		";
		return $this->Consulta($Q0);
}
//funciones para nueva captura de originacion
	function getFamiliasPlanes()
	{
		$Q0="SELECT * FROM FamiliaPlan WHERE Activo=1";
		return $this->Consulta($Q0);
	}

	function getLineasTemporales($Folio)
	{
		$Q0="SELECT T1.LineaTemporalId,T2.Plan,T1.Imei, T4.Equipo, T5.Seguro,T6.Addon,T1.Dn,T1.Folio,T1.Movimiento,T2.FamiliaPlanId FROM LineaTemporalOpc1 AS T1
		INNER  JOIN Planes AS T2 ON T1.PlanId=T2.PlanId
		INNER JOIN Inventario AS T3 ON T3.Serie=T1.Imei
		INNER JOIN Equipos AS T4 ON T3.EquipoId=T4.EquipoId
		INNER JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
		LEFT JOIN Addon AS T6 ON T6.AddonId=T1.AddonId
		WHERE Folio='$Folio' AND T3.Cantidad=1";
		return $this->Consulta($Q0);
	}
	function getLineasTemporalesV2($Folio)
	{
		$Q0="SELECT T1.LineaTemporalId,T2.Plan,T1.Imei,T4.Equipo,T1.ImeiSim,  T5.Seguro,T6.Addon,T1.Dn,T1.Folio,T1.Movimiento,T2.FamiliaPlanId FROM LineaTemporalOpc1 AS T1
		INNER  JOIN Planes AS T2 ON T1.PlanId=T2.PlanId
		INNER JOIN Inventario AS T3 ON T3.Serie=T1.Imei
		INNER JOIN Equipos AS T4 ON T3.EquipoId=T4.EquipoId
		INNER JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
		LEFT JOIN Addon AS T6 ON T6.AddonId=T1.AddonId
		WHERE Folio='$Folio' AND T3.Cantidad=1";
		return $this->Consulta($Q0);
	}
	function getLineasTemporalesV3($Folio)
	{
		$Q0="SELECT  DISTINCT T1.Imei,T2.Plan,T1.LineaTemporalId,T1.ImeiSim, T5.Seguro,T6.Addon,T1.Dn,T1.Folio,T1.Movimiento,T2.FamiliaPlanId,T1.TipoVenta,T1.Raiz FROM LineaTemporalOpc1 AS T1
		INNER  JOIN Planes AS T2 ON T1.PlanId=T2.PlanId
		LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Imei OR T3.Serie=T1.ImeiSim
		LEFT JOIN Equipos AS T4 ON T3.EquipoId=T4.EquipoId
		INNER JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
		LEFT JOIN Addon AS T6 ON T6.AddonId=T1.AddonId
		WHERE Folio='$Folio' AND T3.Cantidad=1 ORDER BY Raiz";
		return $this->Consulta($Q0);
	}
	function getModelo($ImeiSim)
	{
		$Q0="SELECT T2.Equipo FROM Inventario AS T1 
		INNER JOIN Equipos AS T2 ON T1.EquipoId=T2.EquipoId
		WHERE T1.Serie='$ImeiSim' ";
		$resultados=$this->Consulta($Q0);
		$row=mysql_fetch_row($resultados);
		return $row[0];
	}
	function getMarca($ImeiSim)
	{
		$Q0="SELECT T3.Marca FROM Inventario AS T1 
		INNER JOIN Equipos AS T2 ON T1.EquipoId=T2.EquipoId
		INNER JOIN Marcas AS T3 ON T2.MarcaId=T3.MarcaId
		WHERE T1.Serie='$ImeiSim' ";
		$resultados=$this->Consulta($Q0);
		$row=mysql_fetch_row($resultados);
		return $row[0];
	}

	function getAnclas($Folio){
			$query="SELECT Raiz FROM LineaTemporalOpc1  WHERE Folio='$Folio' AND Raiz='Ancla'";
			$resultado=$this->Consulta($query);
			$total=mysql_num_rows($resultado);
			return $total;
	}
	function getPopotes($Folio){
			$query2="SELECT Raiz FROM LineaTemporalOpc1  WHERE Folio='$Folio' AND Raiz='Popote'";
			$resultado2=$this->Consulta($query2);
			$total2=mysql_num_rows($resultado2);
			return $total2;
	}
	function altaLineaOrgV2($Serie, $Clave, $PlanId, $TipoPlanId, $AddOn, $Dn, $PlazoId, $Movimiento, $Diferencial, $TipoPagoDiferencial, $SeguroId, $codigo_sim,$tipoVentaAux,$tipoVenta)
	{	
		if($tipoVentaAux==0){

			if($codigo_sim==0){
				$Q0="INSERT INTO LineaTemporalOpc1(LineaTemporalId,Folio,Movimiento,Imei,ImeiSim,PlanId,TipoPlanId,AddonId,Aux,PlazoId,Dn,Diferencial,TipoPagoDiferencial,SeguroId,TipoVenta,Raiz,Opc)VALUES(NULL,'$Clave','$Movimiento','$Serie','$codigo_sim',$PlanId,$TipoPlanId,0,0,$PlazoId,'$Dn',$Diferencial,$TipoPagoDiferencial,$SeguroId,$tipoVentaAux,'No Aplica',1)";
			}else{
				$Q0="INSERT INTO LineaTemporalOpc1(LineaTemporalId,Folio,Movimiento,Imei,ImeiSim,PlanId,TipoPlanId,AddonId,Aux,PlazoId,Dn,Diferencial,TipoPagoDiferencial,SeguroId,TipoVenta,Raiz,Opc)VALUES(NULL,'$Clave','$Movimiento','$Serie','$codigo_sim',$PlanId,$TipoPlanId,0,0,$PlazoId,'$Dn',$Diferencial,$TipoPagoDiferencial,$SeguroId,$tipoVentaAux,'No Aplica',2)";
			}

			if($codigo_sim!=0){
				if($this->getMarca($codigo_sim)!='SIMCARD'){
				return utf8_decode('<span class="alerta">¡Elija una Sim Valida!</span>');
				}
			}

		}elseif($tipoVentaAux==1){
			if($PlanId==365 || $PlanId==366 || $PlanId==367){
				$raiz="Popote";
			}else{
				$raiz="Ancla";
			}
			
			$total=$this->getAnclas($Clave);
			$total2=$this->getPopotes($Clave);

			if($total==0 && $raiz=="Popote"){
				return utf8_decode('<span class="alerta">"Ingresar linea ancla antes de una linea Popote"</span>');
			}elseif($total==1 && ($raiz=='Ancla')){
				return utf8_decode('<span class="alerta">"Ya existe la linea ancla"</span>');
			}elseif ($total==0 && ($PlanId!=365 || $PlanId!=366)) {
				$Q0="INSERT INTO LineaTemporalOpc1(LineaTemporalId,Folio,Movimiento,Imei,ImeiSim,PlanId,TipoPlanId,AddonId,Aux,PlazoId,Dn,Diferencial,TipoPagoDiferencial,SeguroId,TipoVenta,Raiz,Opc)VALUES(NULL,'$Clave','$Movimiento','$Serie','$codigo_sim', $PlanId,$TipoPlanId,0,0,$PlazoId,'$Dn',$Diferencial,$TipoPagoDiferencial,$SeguroId,$tipoVenta,'$raiz',3)";
			}elseif($total==1 && ($PlanId==365 || $PlanId==366 || $PlanId==367)){
				$Q0="INSERT INTO LineaTemporalOpc1(LineaTemporalId,Folio,Movimiento,Imei,ImeiSim,PlanId,TipoPlanId,AddonId,Aux,PlazoId,Dn,Diferencial,TipoPagoDiferencial,SeguroId,TipoVenta,Raiz,Opc)VALUES(NULL,'$Clave','$Movimiento','$Serie','$codigo_sim', $PlanId,$TipoPlanId,0,0,$PlazoId,'$Dn',$Diferencial,$TipoPagoDiferencial,$SeguroId,$tipoVenta,'$raiz',3)";
			}elseif($total2==9) {
				return utf8_decode('<span class="alerta">"ha llegado al limite de lineas permitidas"</span>');
			}	
		}
		



		$this->StartTransaccion();
		if($this->Consulta($Q0))
		{
		$LineaTemporalId=mysql_insert_id();
		$Q1="INSERT IGNORE INTO Disponibles (Serie) VALUES('$Serie')";
		$sim="INSERT IGNORE INTO Disponibles (Serie) VALUES('$codigo_sim')";

		$Q2="INSERT IGNORE INTO AddonTemporal
			 SELECT NULL, AddonId, $LineaTemporalId FROM Addon WHERE AddonId IN ($AddOn)";
		if($this->Consulta($Q1) & $this->Consulta($sim) & $this->Consulta($Q2))
			{
				$this->AceptaTransaccion();
				return 'ok';
			}
		}
			$this->CancelaTransaccion();
		return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');
	}


function altaLineaOrgV3($FechaSS, $Contrato)
	{	
		echo "string";
			 return utf8_decode('<span class="alerta">¡Fecha : !</span>');
		
	}
















	function eliminaLineaTemporal($Folio){
		$query="SELECT Imei,ImeiSim FROM LineaTemporalOpc1 WHERE '$Folio' AND Aux=0";
		$resultado=mysql_query("$query", $this->conexion) or die(mysql_error());

		while($row=mysql_fetch_row($resultado))
		{
			$imei=$row[0];
			$ImeiSim=$row[1];
			$query2="DELETE FROM Disponibles WHERE Serie='$imei' OR Serie='$ImeiSim'";
			if(!mysql_query("$query2",$this->conexion)){
				echo "Error: ".$query2.mysql_error();
			}

		}
		$query3="DELETE FROM LineaTemporalOpc1 WHERE Folio='$Folio'";
		if(!mysql_query("$query3",$this->conexion)){
				echo "Error: ".$query3.mysql_error();
		}

	}//Scroll
	function totalLineasTemporales($Folio){
		$query="SELECT Folio FROM LineaTemporalOpc1 WHERE Folio='$Folio'";
		$resultado=$this->Consulta($query);
		$total=mysql_num_rows($resultado);
		return $total;
	}
	function totalLineasAncla($Folio){
		$query="SELECT Folio FROM LineaTemporalOpc1 WHERE Folio='$Folio' AND Raiz='Ancla'";
		$resultado=$this->Consulta($query);
		$total=mysql_num_rows($resultado);
		return $total;
	}






	function getDatosFolioTemporal($Folio){
		$query="SELECT T1.Folio,T2.Plataforma,T3.TipoContratacion,CONCAT(T4.Nombre, ' ',T4.Paterno,' ',T4.Materno) AS Cliente, 
		CONCAT(T6.Nombre, ' ',T6.Paterno,' ',T6.Materno) AS Empleado, T7.Puntoventa FROM HFolios AS T1 
		LEFT JOIN Plataformas AS T2 ON T1.PlataformaId=T2.PlataformaId 
		LEFT JOIN TiposContratacion AS T3 ON T1.TipoContratacionId=T3.TipoContratacionId
		LEFT JOIN Clientes AS T4 ON T1.ClienteId=T4.ClienteId
		LEFT JOIN HistorialPuestosEmpleados AS T5 ON T1.HistorialPuestoEmpleadoId=T5.HistorialPuestoEmpleadoId
		LEFT JOIN Empleados AS T6 ON T5.EmpleadoId=T6.EmpleadoId
		INNER JOIN PuntosVenta AS T7 ON T1.PuntoventaId=T7.PuntoVentaId
		WHERE T1.Folio='$Folio' ";

		return  $this->Consulta($query);
	}

	function finVenta($LineaTemporalId,$Folio,$Movimiento,$Imei,$ImeiSim,$PlanId,$TipoPlanId,$Addon,$Aux,$PlazoId,$Dn,$Diferencial,$TipoPagoDiferencial,$SeguroId,$TipoVenta,$Raiz,$Opc,$fecha,$Contrato,$Comentarios){
				$Q0="INSERT INTO TLineas
                   SELECT NULL, '$Movimiento', EquipoId, $PlanId, $TipoPlanId, $PlazoId, '', '', $Diferencial, $TipoPagoDiferencial, '', $SeguroId
                   FROM Inventario WHERE Serie='$Imei' LIMIT 1";
    
       	$tam=count($Addon);
       	$AddonAux='';
       	for($i=0;$i<$tam;$i++){
       		if(i==0){
       			$AddonAux='AddonId='.$Addon[$i];
       		}else{
       			$AddonAux=$AddonAux." OR AddonId=".$Addon[$i];
       		}
       	}
		$this->StartTransaccion();
		if($this->Consulta($Q0))
		{
		$RegistroId=mysql_insert_id();
		$Q1="INSERT IGNORE INTO TLineasAddon
			 SELECT $RegistroId, AddonId FROM Addon WHERE $AddonAux";

		$Q2="INSERT IGNORE INTO LineasAddon
			 SELECT $RegistroId, AddonId,0 FROM Addon WHERE $AddonAux";

		/*$Q2="INSERT IGNORE INTO TLineasServicios
			 SELECT $RegistroId, ServicioAdicionalId FROM ServiciosAdicionales WHERE ServicioAdicionalId IN ($Servicios)";*/

		$Q3="INSERT INTO LFolios
			 SELECT T1.RegistroId, '$Folio', T1.PlanId, EquipoId, PlazoId, TipoPlanId, 12,
			 CostoPlan+IFNULL(SUM(CostoAddOn),0) AS Costo, 0 AS RentaSI, 'x', CURDATE(), '$Imei', '', $Dn, Diferencial, TipoPagoDiferencial, SeguroId
			 FROM TLineas AS T1
 	   		 LEFT JOIN LineasAddon AS T2 ON T2.RegistroId=T1.RegistroId
		     LEFT JOIN PreciosPlanes AS T3 ON T3.PlanId=T1.PlanId AND T3.AddOnId=IFNULL(T2.AddOnId,0)
			 WHERE T1.Registroid=$RegistroId";
		$Q4="UPDATE LineaTemporalOpc1 SET Aux=1 WHERE LineaTemporalId=$LineaTemporalId";
		$fechaAux=$this->CambiarFormatoFecha($fecha);
		$Q5="UPDATE LFolios
			SET EstatusId=14,
			FechaEstatus='$fechaAux',
			Contrato='$Contrato',
			Comentario='$Comentarios',
			Dn='$Dn'
			WHERE RegistroId=$RegistroId";

		$Q6="INSERT INTO Inventario
			SELECT T1.EquipoId, T1.Serie, IccId, -1 AS Cantidad, T3.MovimientoId, '$fechaAux', '0000-00-00', T2.AlmacenId, T2.PlataformaId
			FROM LFolios AS T1
			LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
			LEFT JOIN HFolios AS T3 ON T3.Folio=T1.Folio
			WHERE T1.RegistroId=$RegistroId
			LIMIT 1";
		$Q7="UPDATE Inventario AS T1
			INNER JOIN (
		            SELECT T1.Serie, 0 AS Cantidad
		            FROM LFolios AS T1
		            LEFT JOIN Inventario AS T2 ON T2.Serie=T1.Serie AND T2.Cantidad>0
		            WHERE T1.RegistroId=$RegistroId
		            LIMIT 1
		           ) AS T2 ON T2.Serie=T1.Serie
			SET T1.Cantidad=T2.Cantidad
			WHERE T1.Cantidad>0";
		if($this->Consulta($Q1) & $this->Consulta($Q2)  & $this->Consulta($Q3) & $this->Consulta($Q4)  & $this->Consulta($Q5)  & $this->Consulta($Q6)  & $this->Consulta($Q7) & $this->addBitacora(24, 5, $RegistroId, 'Cambio estatus', 14))
			{
				$this->AceptaTransaccion();
				//if($codigo_sim!='0')
				//	$this->altaLineaOrg($codigo_sim, $Clave, 81, 3, 0, 0, $PlazoId, $Movimiento, 0, 0, 4, 0);
				//echo '<span class="notificacion">¡Venta Registrada satisfactoriamente!'.$RegistroId.'</span>';
				return 1;
			}else{
				$this->CancelaTransaccion();
				echo '<span class="alerta">¡Error al Registrar la Venta!</span>';
				return 0;
			}
		}else{

			$this->CancelaTransaccion();
			echo '<span class="alerta">¡Error al Registrar la Venta!</span>';
			return 0;
		}
		//return utf8_decode('<span class="alerta">¡No fue posible realizar el registro!</span>');		
	}
	function getLineasFin($Folio)
	{
		$Q0="SELECT T1.LineaTemporalId,T2.Plan,T1.Imei, T4.Equipo, T5.Seguro,T6.Addon,T1.Dn,T1.Folio,T1.Movimiento,T2.FamiliaPlanId,T8.Estatus, T1.ImeiSim FROM LineaTemporalOpc1 AS T1
		INNER  JOIN Planes AS T2 ON T1.PlanId=T2.PlanId
		INNER JOIN Inventario AS T3 ON T3.Serie=T1.Imei
		INNER JOIN Equipos AS T4 ON T3.EquipoId=T4.EquipoId
		INNER JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
		LEFT JOIN Addon AS T6 ON T6.AddonId=T1.AddonId
		INNER JOIN LFolios AS T7 ON T7.Serie=T1.Imei
		LEFT JOIN Estatus AS T8 ON T8.EstatusId=T7.EstatusId
		WHERE T1.Folio='$Folio' AND T3.Activacion!='0000-00-00'";
		return $this->Consulta($Q0);
	}
	function getLineasFin2($Folio)
	{

		$Q0="SELECT  DISTINCT T1.Imei,T2.Plan,T1.LineaTemporalId,T1.ImeiSim, T5.Seguro,T6.Addon,T1.Dn,T1.Folio,T1.Movimiento,T2.FamiliaPlanId,T1.TipoVenta,T1.Raiz,T8.Estatus FROM LineaTemporalOpc1 AS T1
		INNER  JOIN Planes AS T2 ON T1.PlanId=T2.PlanId
		LEFT JOIN Inventario AS T3 ON T3.Serie=T1.Imei OR T3.Serie=T1.ImeiSim
		LEFT JOIN Equipos AS T4 ON T3.EquipoId=T4.EquipoId
		INNER JOIN Seguros AS T5 ON T5.SeguroId=T1.SeguroId
		LEFT JOIN Addon AS T6 ON T6.AddonId=T1.AddonId
		LEFT JOIN LFolios AS T7 ON T7.Serie=T1.Imei OR T7.Serie=T1.ImeiSim
		LEFT JOIN Estatus AS T8 ON T8.EstatusId=T7.EstatusId
		WHERE T1.Folio='$Folio' AND T3.Activacion!='0000-00-00' ORDER BY Raiz";
		return $this->Consulta($Q0);


	}
	function getContrato($Folio){
		$Q0="SELECT DISTINCT Contrato FROM LFolios WHERE Folio='$Folio'";
		$resultados=$this->Consulta($Q0);
		$row=mysql_fetch_row($resultados);
		return $row[0];
	}	
	function getComentarios($Folio){
		$Q0="SELECT DISTINCT Comentario FROM LFolios WHERE Folio='$Folio' AND PlanId!=81";
		$resultados=$this->Consulta($Q0);
		$row=mysql_fetch_row($resultados);
		return $row[0];
	}
	function getFechaEstatus($Folio){
		$Q0="SELECT DISTINCT FechaEstatus FROM LFolios WHERE Folio='$Folio'";
		$resultados=$this->Consulta($Q0);
		$row=mysql_fetch_row($resultados);
		return $row[0];
	}		
	function bloqueoFaltaCorte(){
		$fecha=date("Y-m-d");
		//$Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND TipoPuntoId!=3 AND (PuntoVentaId!=1 OR PuntoVentaId!=33 OR PuntoVentaId!=228 OR PuntoVentaId!=357 OR PuntoVentaId!=366 OR PuntoVentaId!=152 OR PuntoVentaId!=153 OR PuntoVentaId!=159 OR PuntoVentaId!=162 OR PuntoVentaId!=426 OR PuntoVentaId!=451 OR PuntoVentaId!=250 OR PuntoVentaId!=43 OR PuntoVentaId!=181 OR PuntoVentaId!=184)";
		
	//	$Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND TipoPuntoId!=3 AND PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,534,553,562,563)";
		$Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,546,534,553,562,563)";
		
		
		if($res0=mysql_query($Q0)){
			while ($row0=mysql_fetch_array($res0)){
				$Q1="SELECT PuntoVentaId FROM Depositos WHERE PuntoVentaId=$row0[0] AND Fecha='$fecha' AND TipoDepositoId=5";
				if($res1=mysql_query($Q1)){
					if(mysql_num_rows($res1)==0){
						$this->bloquearPuntoTesoreria($row0[0]);
					}
				}
			}
		}
	}

	function bloqueoFaltaDeposito(){
		$fecha=date("Y-m-d");
		//$Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND TipoPuntoId!=3 AND (PuntoVentaId!=1 OR PuntoVentaId!=33 OR PuntoVentaId!=228 OR PuntoVentaId!=357 OR PuntoVentaId!=366 OR PuntoVentaId!=152 OR PuntoVentaId!=153 OR PuntoVentaId!=159 OR PuntoVentaId!=162 OR PuntoVentaId!=426 OR PuntoVentaId!=451 OR PuntoVentaId!=250 OR PuntoVentaId!=43 OR PuntoVentaId!=181 OR PuntoVentaId!=184)";
		
		    //$Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND TipoPuntoId!=3 AND PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,534,553)";
		    
		    $Q0="SELECT PuntoVentaId, PuntoVenta FROM PuntosVenta WHERE Activo=1 AND PuntoVentaId IN (21,29,30,34,35,39,40,42,72,76,80,85,105,110,128,175,176,190,239,240,363,364,365,368,369,371,373,374,376,377,378,379,407,419,427,430,431,432,433,435,436,437,439,459,460,493,494,496,499,509,527,528,529,530,535,539,540,541,542,544,546,534,553,562,563)";
		
	
		if($res0=mysql_query($Q0)){
			while ($row0=mysql_fetch_array($res0)){
				$Q1="SELECT PuntoVentaId FROM Depositos WHERE PuntoVentaId=$row0[0] AND Fecha='$fecha' AND TipoDepositoId=9";
				if($res1=mysql_query($Q1)){
					if(mysql_num_rows($res1)==0){
						$this->bloquearPuntoTesoreria($row0[0]);
					}
				}
			}
		}
}




function bloquearPuntoTesoreria2($PuntoVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId2=1 WHERE EmpleadoId
		IN (SELECT EmpleadoId FROM HistorialPuntosEmpleados WHERE PuntoVentaId IN ($PuntoVentaId) AND Fisico=1 AND FechaBaja='0000-00-00')";
		$this->Consulta($Q0);
		$this->addBitacora(61, 4, $PuntoVentaId, 'Bloqueo Tesoreria','Bloqueo');
}


function bloquearPuntoTesoreria($PuntoVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId2=1 WHERE EmpleadoId
		IN (SELECT EmpleadoId FROM HistorialPuntosEmpleados WHERE PuntoVentaId IN ($PuntoVentaId) AND Fisico=1 AND FechaBaja='0000-00-00')";
		$this->Consulta($Q0);
		$this->addBitacora(61, 4, $PuntoVentaId, 'Bloqueo Tesoreria','Bloqueo');
}
function desbloquearPuntoTesoreria($PuntoVentaId)
{
	$Q0="UPDATE Usuarios SET TipoBloqueoId2=0 WHERE EmpleadoId
			IN (SELECT EmpleadoId FROM HistorialPuntosEmpleados WHERE PuntoVentaId IN ($PuntoVentaId) AND Fisico=1 AND FechaBaja='0000-00-00')";
		$this->Consulta($Q0);

		$this->addBitacora(61, 4, $PuntoVentaId, 'Desbloqueo Tesoreria','Desbloqueo');

}

}//fin clase
?>
