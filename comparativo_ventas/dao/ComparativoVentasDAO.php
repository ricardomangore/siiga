<?php

require_once('/../includes/Connect.php');
require_once('/../pojos/PostPago.php');
require_once('/../pojos/Transfer.php');
require_once('/../includes/ToolsComparativoVentas.php');

class ComparativoVentasDAO extends Connect{

	/**
	 * comaparePostPagoByFolio()
	 * Determina si un objeto PostPago es igual a un registro de ventas de SIIGa
	 * a partir del Folio
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByFolio($postPago){
		$returnValue= FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$folio);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				var_dump($param);

				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * comaparePostPagoByImei()
	 * Determina si un objeto PostPago es igual a un registro de ventas de SIIGA
	 * a partir del IMEI
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByImei($postPago){
		$returnValue= FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$imei = $postPago->getImei();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$imei);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}
		return $returnValue;
	}
/************************************************************************************************
	El siguiente grupo de funciones comapra los registros de PoatPago por diversos parametros
	como Nombre del Punto de venta, Nombre del ejecutivo etc. Tomando como campos principales 
	o lleves primarias Folio e IMEI
************************************************************************************************/
	/**
	 * Determina si ounb objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombrePDV($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$nombrePdv = $postPago->getNombrePdvUnico();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$nombrePdv);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}

		return $returnValue;
	}

	/**
	 * Determina si on objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Tipo de Venta
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByTipoVenta($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PsotPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$tipoVenta = $postPago->getTipoVenta();
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND TiposContratacion.Tipocontratacion LIKE ?';
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$tipoVenta);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}


	/**
	 * Determina si on objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Nombre Ejecutivo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombreEjecutivo($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$nombreEjecutivo = $postPago->getNombreEjecutivoUnico();//'CARMEN YOLANDA PINKUS AMADOR';//;$postPago->getNombreEjecutivoUnico();
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) LIKE ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$nombreEjecutivo);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}

	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Plazo Forzoso adquirido
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlazoForzoso($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$plazoForzoso = $postPago->getPlazoForzoso();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON LFolios.PlazoId=Plazos.PlazoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Plazos.Plazo = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$imei,$plazoForzoso);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();


				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No s epuedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Modelo Equipo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByModeloEquipo($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$modeloEquipo = $postPago->getModeloEquipo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Equipos ON Equipos.EquipoId=LFolios.EquipoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Equipos.Equipo = ? ";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$imei,$modeloEquipo);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No s epuedo preparar la consulta');
			}
		}
		return $returnValue;
	}

	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Plan
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlan($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$plan = $postPago->getPlantarifarioHomo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$imei,$plan);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y DN
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByDN($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$mdn = $postPago->getMdnActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$imei,$mdn);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Fecah de Activación
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByFechaActivacion($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$tools = new ToolsComparativoVentas();
			$fechaActivacion=$tools->getOnlyDate($postPago->getFechaActivacion());
			$sqlStr = "SELECT Inventario.Activacion FROM Inventario WHERE Inventario.EquipoId=(SELECT LFolios.EquipoId FROM LFolios WHERE LFolios.Folio=? AND LFolios.Serie=?) AND Inventario.Serie=? AND Inventario.Cantidad=-1 AND Inventario.Activacion=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ssss', $folio,$imei,$imei,$fechaActivacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}

/************************************************************************************************
	El siguiente grupo de funciones comapra los registros de PoatPago por diversos parametros
	como Nombre del Punto de venta, Nombre del ejecutivo etc. Tomando como campos principales 
	o lleves primarias Folio e SIM
************************************************************************************************/
	/**
	 * Determina si ounb objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombrePDVSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$nombrePdv = $postPago->getNombrePdvUnico();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$sim,$nombrePdv);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}

		return $returnValue;
	}

	/**
	 * Determina si on objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Tipo de Venta
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByTipoVentaSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PsotPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$tipoVenta = $postPago->getTipoVenta();
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND TiposContratacion.Tipocontratacion LIKE ?';
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$sim,$tipoVenta);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}


	/**
	 * Determina si on objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Nombre Ejecutivo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombreEjecutivoSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$nombreEjecutivo = $postPago->getNombreEjecutivoUnico();//'CARMEN YOLANDA PINKUS AMADOR';//;$postPago->getNombreEjecutivoUnico();
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) LIKE ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$sim,$nombreEjecutivo);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}

	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Plazo Forzoso adquirido
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlazoForzosoSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$plazoForzoso = $postPago->getPlazoForzoso();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON LFolios.PlazoId=Plazos.PlazoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Plazos.Plazo = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$sim,$plazoForzoso);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();


				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No s epuedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Modelo Equipo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByModeloEquipoSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$modeloEquipo = $postPago->getModeloEquipo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Equipos ON Equipos.EquipoId=LFolios.EquipoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Equipos.Equipo = ? ";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$sim,$modeloEquipo);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No s epuedo preparar la consulta');
			}
		}
		return $returnValue;
	}

	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Plan
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlanSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$plan = $postPago->getPlantarifarioHomo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$sim,$plan);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y DN
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByDNSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$mdn = $postPago->getMdnActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$sim,$mdn);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}


	/**
	 * Determina si un objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, SIM y Fecah de Activación
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	/*public function comparePostPagoByFechaActivacionSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$fechaActivacion = $postPago->getFechaActivacion();
			$sqlStr = "";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$sim,$fechaActivacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}*/





/*######################################################################################################################
  ######################################################################################################################
  ######################################################################################################################
	  
	 AQUI COMIENZAN LOS METODOS PARA TRANSFER.

  ######################################################################################################################
  ######################################################################################################################
#######################################################################################################################*/



/*************************************************************************************************************
	El siguiente grupo de funciones comapra los registros de Transfer por diversos parametros
	como Nombre pdv, Fecha activacion contrato, New sim, New imei, Plan actual, Plazo actual, Dn actual y SIM 
**************************************************************************************************************/

	/**
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Nombre pdv
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByNombrePdvSim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$nombre = $transfer->getNombrePdv();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $idOrdenRenovacion,$sim,$nombre);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				//var_dump($param);

				$prepare->close();
				if($param != '' || !is_null($param)){
					$returnValue = TRUE;
				}
			}else{
				throw  new Exception('No se puedo preparar la consulta');
			}
		}
		return $returnValue;
	}


}//Termina la clase CorporativoVentasDAO