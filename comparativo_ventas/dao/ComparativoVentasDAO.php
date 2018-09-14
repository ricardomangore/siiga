<?php

include_once('comparativo_ventas/includes/Connect.php');
include_once('comparativo_ventas/pojos/PostPago.php');
include_once('comparativo_ventas/pojos/Transfer.php');
include_once('comparativo_ventas/pojos/Renovaciones.php');
include_once('comparativo_ventas/pojos/Seguros.php');
include_once('comparativo_ventas/pojos/ViewPostPago.php');
include_once('comparativo_ventas/pojos/ViewRenovaciones.php');
include_once('comparativo_ventas/pojos/ViewTransfer.php');
include_once('comparativo_ventas/pojos/ViewSeguros.php');
include_once('comparativo_ventas/includes/ToolsComparativoVentas.php');


class ComparativoVentasDAO extends Connect{

	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ Consultas para los Incidentes $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/

	/**
	 * getListPostPagoIncidents()
	 * Obtiene el listado de incidentes de postpago segun el id_layout
	 * @param <int> 
	 * @return <array> ViewPostPago
	 */
	public function getListPostPagoIncidents($idLayout){
		$returnValue = Null;
		$arrayPostpagos = array();
		$sqlStr = "SELECT tw_postpago.id_registro,tw_postpago.id_layout,tw_postpago.folio,tw_postpago.no_contrato_impreso,
			tw_postpago.id_orden_contratacion,tw_postpago.nombre_cliente,tw_postpago.tipo_venta,tw_postpago.nombre_ejecutivo_unico,
			tw_postpago.sim,tw_postpago.imei,tw_postpago.plazo_forzoso, tc_tipos_diferencias.id_tipo_diferencia,
			tc_tipos_diferencias.tipo_diferencia FROM tw_diferencias INNER JOIN tw_postpago ON tw_postpago.id_registro = 
			tw_diferencias.id_registro INNER JOIN tc_tipos_diferencias ON tc_tipos_diferencias.id_tipo_diferencia = 
			tw_diferencias.id_tipo_diferencia WHERE tw_postpago.id_layout = ".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$viewPostPagoObj = new ViewPostPago();
				$viewPostPagoObj->setIdRegistro($fila[0]);
				$viewPostPagoObj->setIdLayout($fila[1]);
				$viewPostPagoObj->setFolio($fila[2]);
				$viewPostPagoObj->setNoContratoImpreso($fila[3]);
				$viewPostPagoObj->setIdOrdenContratacion($fila[4]);
				$viewPostPagoObj->setNombreCliente($fila[5]);
				$viewPostPagoObj->setTipoVenta($fila[6]);
				$viewPostPagoObj->setNombreEjecutivoUnico($fila[7]);
				$viewPostPagoObj->setSim($fila[8]);
				$viewPostPagoObj->setImei($fila[9]);
				$viewPostPagoObj->setPlazoForzoso($fila[10]);
				$viewPostPagoObj->setIdTipoDiferencia($fila[11]);
				$viewPostPagoObj->setTipoDiferencia($fila[12]);
				array_push($arrayPostpagos, $viewPostPagoObj);
			}//Termina WHILE
			$returnValue = $arrayPostpagos;
		}//Termina IF
		return $returnValue;

	}




	/**
	 * getListRenovacionesIncidents()
	 * Obtiene el listado de incidentes de renovaciones segun el id_layout
	 * @param <int> 
	 * @return <array> ViewPostPago
	 */
	public function getListRenovacionesIncidents($idLayout){
		$returnValue = Null;
		$arrayRenovaciones = array();
		$sqlStr = "SELECT tw_renovaciones.id_orden_renovacion,tw_renovaciones.nombre_pdv,tw_renovaciones.fecha_activacion_contrato,
			tw_renovaciones.new_sim,tw_renovaciones.new_imei,tw_renovaciones.plan_actual,tw_renovaciones.plazo_actual,
			tw_renovaciones.dn_actual,tc_tipos_diferencias.tipo_diferencia FROM tw_diferencias INNER JOIN tw_renovaciones ON 
			tw_renovaciones.id_registro = tw_diferencias.id_registro INNER JOIN tc_tipos_diferencias ON 
			tc_tipos_diferencias.id_tipo_diferencia = tw_diferencias.id_tipo_diferencia 
			WHERE tw_renovaciones.id_layout = ".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$viewRenovacion = new ViewRenovaciones();
				$viewRenovacion->setIdOrdenRenovacion($fila[0]);
				$viewRenovacion->setNombrePdv($fila[1]);
				$viewRenovacion->setFechaActivacionContrato($fila[2]);
				$viewRenovacion->setNewSim($fila[3]);
				$viewRenovacion->setNewImei($fila[4]);
				$viewRenovacion->setPlanActual($fila[5]);
				$viewRenovacion->setPlazoActual($fila[6]);
				$viewRenovacion->setDnActual($fila[7]);
				$viewRenovacion->setTipoDiferencia($fila[8]);
				array_push($arrayRenovaciones, $viewRenovacion);
			}//Termina WHILE
			$returnValue = $arrayRenovaciones;
		}//Termina IF
		return $returnValue;

	}



	/**
	 * getListTransferIncidents()
	 * Obtiene el listado de incidentes de transfer segun el id_layout
	 * @param <int> 
	 * @return <array> ViewTransfer
	 */
	public function getListTransferIncidents($idLayout){
		$returnValue = Null;
		$arrayTransfer = array();
		$sqlStr = "SELECT tw_transfer.id_orden_renovacion,tw_transfer.nombre_pdv,tw_transfer.fecha_activacion_contrato,
			tw_transfer.new_sim,tw_transfer.new_imei,tw_transfer.plan_actual,tw_transfer.plazo_actual,tw_transfer.dn_actual,
			tc_tipos_diferencias.tipo_diferencia FROM tw_diferencias INNER JOIN tw_transfer ON tw_transfer.id_registro = 
			tw_diferencias.id_registro INNER JOIN tc_tipos_diferencias ON tc_tipos_diferencias.id_tipo_diferencia = 
			tw_diferencias.id_tipo_diferencia WHERE tw_transfer.id_layout = ".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$viewTransferObj = new ViewTransfer();
				$viewTransferObj->setIdOrdenRenovacion($fila[0]);
				$viewTransferObj->setNombrePdv($fila[1]);
				$viewTransferObj->setFechaActivacionContrato($fila[2]);
				$viewTransferObj->setNewSim($fila[3]);
				$viewTransferObj->setNewImei($fila[4]);
				$viewTransferObj->setPlanActual($fila[5]);
				$viewTransferObj->setPlazoActual($fila[6]);
				$viewTransferObj->setDnActual($fila[7]);
				$viewTransferObj->setTipoDiferencia($fila[8]);
				array_push($arrayTransfer, $viewTransferObj);
			}//Termina WHILE
			$returnValue = $arrayTransfer;
		}//Termina IF
		return $returnValue;

	}




		/**
	 * getListSegurosIncidents()
	 * Obtiene el listado de incidentes de Seguros segun el id_layout
	 * @param <int> 
	 * @return <array> ViewSeguros
	 */
	public function getListSegurosIncidents($idLayout){
		$returnValue = Null;
		$arraySeguros = array();
		$sqlStr = "SELECT tw_seguros.id_contrato,tw_seguros.renta,tw_seguros.fecha_act_seg,tc_tipos_diferencias.tipo_diferencia
			FROM tw_diferencias INNER JOIN tw_seguros ON tw_seguros.id_registro = tw_diferencias.id_registro INNER JOIN 
			tc_tipos_diferencias ON tc_tipos_diferencias.id_tipo_diferencia = tw_diferencias.id_tipo_diferencia WHERE 
			tw_seguros.id_layout = ".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$viewSeguro = new ViewSeguros();
				$viewSeguro->setIdContrato($fila[0]);
				$viewSeguro->setRenta($fila[1]);
				$viewSeguro->setFechaActSeg($fila[2]);
				$viewSeguro->setTipoDiferencia($fila[3]);
				array_push($arraySeguros, $viewSeguro);
			}//Termina WHILE
			$returnValue = $arraySeguros;
		}//Termina IF
		return $returnValue;

	}


	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/
	/*$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$*/



	/**
	 * comapareRenovacionesByFolio()
	 * Determina si un objeto Renovaciones es igual a un registro de ventas de SIIGa
	 * a partir del Folio
	 * @param <Object> Renovaciones
	 * @return <boolean>
	 */
	public function compareTransferByFolio($transfer){
		$returnValue= FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$folio = $transfer->getFolio();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$folio);
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
	 * comapareRenovacionesByFolio()
	 * Determina si un objeto Renovaciones es igual a un registro de ventas de SIIGa
	 * a partir del Folio
	 * @param <Object> Renovaciones
	 * @return <boolean>
	 */
	public function compareRenovacionesByFolio($renovaciones){
		$returnValue= FALSE;
		if(isset($renovaciones) && is_a($renovaciones,'Renovaciones')){
			$folio = $renovaciones->getFolio();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$folio);
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

#########################################################################################################
#########################################################################################################
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
			$sqlStr="SELECT PuntosATT.NombreATT FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio = ? AND LFolios.Serie=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$folio,$imei);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				

				$pdvNameCis = strtoupper($postPago->getNombrePdvUnico());
				$pdvNameSiiga = strtoupper($param);

				//var_dump($param);
				if($pdvNameCis == $pdvNameSiiga){
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
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND TiposContratacion.Tipocontratacion = ?';
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
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON LFolios.PlazoId=Plazos.PlazoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Plazos.Plazo = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Equipos ON Equipos.EquipoId=LFolios.EquipoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Equipos.Equipo = ? ";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Planes.Plan = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND LFolios.Dn = ?";
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
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio = ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
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
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND TiposContratacion.Tipocontratacion = ?';
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
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON LFolios.PlazoId=Plazos.PlazoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Plazos.Plazo = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Equipos ON Equipos.EquipoId=LFolios.EquipoId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Equipos.Equipo = ? ";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND Planes.Plan = ?";
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie = ? AND LFolios.Dn = ?";
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
	  
	 AQUI COMIENZAN LOS METODOS PARA RENOVACIONES.

  ######################################################################################################################
  ######################################################################################################################
#######################################################################################################################*/



/*************************************************************************************************************
	El siguiente grupo de funciones comapra los registros de Renovaciones por diversos parametros
	como Nombre pdv, Fecha activacion contrato, New sim, New imei, Plan actual, Plazo actual, Dn actual e IMEI 
**************************************************************************************************************/

	/**
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNombrePDVImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$nombrePdv = $renovacion->getNombrePdv();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio 
				INNER JOIN TiposContratacion ON TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId INNER JOIN PuntosATT ON 
				PuntosATT.PuntoVentaId=HFolios.PuntoVentaId WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND PuntosATT.NombreATT = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$nombrePdv);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y Fecha activacion contrato
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByFechaActivacionContratoImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$tools = new ToolsComparativoVentas();
			$fechaActivacionContrato=$tools->getOnlyDate($renovacion->getFechaActivacionContrato());
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio INNER JOIN TiposContratacion ON
				TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND 
				HFolios.FechaContrato = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$nombrePdv);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y New Sim
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNewSimImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion 
				ON TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$sim);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y New Imei
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNewImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion 
				ON TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$imei);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y Plan Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlanActualImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$planActual = $renovacion->getPlanActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio INNER JOIN TiposContratacion ON 
				TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId INNER JOIN Planes ON LFolios.PlanId = Planes.PlanId
				WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$planActual);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y Plazo Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlazoActualImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$plazoActual = $renovacion->getPlazoActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion ON
				TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId INNER JOIN Plazos ON LFolios.PlazoId = Plazos.PlazoId
				WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND Plazos.PlazoId = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$plazoActual);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, IMEI y Dn Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByDnActualImei($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$dnActual = $renovacion->getDnActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion ON 
				TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$dnActual);
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




/*************************************************************************************************************
	El siguiente grupo de funciones comapra los registros de Renovaciones por diversos parametros
	como Nombre pdv, Fecha activacion contrato, New sim, New imei, Plan actual, Plazo actual, Dn actual e SIM 
**************************************************************************************************************/
	/**
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNombrePDVSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$nombrePdv = $renovacion->getNombrePdv();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio 
				INNER JOIN TiposContratacion ON TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId INNER JOIN PuntosATT ON 
				PuntosATT.PuntoVentaId=HFolios.PuntoVentaId WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND PuntosATT.NombreATT = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$nombrePdv);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Fecha activacion contrato
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByFechaActivacionContratoSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$tools = new ToolsComparativoVentas();
			$fechaActivacionContrato=$tools->getOnlyDate($renovacion->getFechaActivacionContrato());
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio INNER JOIN TiposContratacion ON
				TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND 
				HFolios.FechaContrato = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$nombrePdv);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y New Sim
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNewSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion 
				ON TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$sim);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y New Imei
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNewImeiSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$imei = $renovacion->getNewImei();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion 
				ON TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$imei);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Plan Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlanActualSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$planActual = $renovacion->getPlanActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio=HFolios.Folio INNER JOIN TiposContratacion ON 
				TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId INNER JOIN Planes ON LFolios.PlanId = Planes.PlanId
				WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$planActual);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Plazo Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlazoActualSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$plazoActual = $renovacion->getPlazoActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion ON
				TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId INNER JOIN Plazos ON LFolios.PlazoId = Plazos.PlazoId
				WHERE LFolios.Folio = ? AND LFolios.Serie = ? AND Plazos.PlazoId = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$plazoActual);
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
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Dn Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByDnActualSim($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sim = $renovacion->getNewSim();
			$dnActual = $renovacion->getDnActual();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON LFolios.Folio = HFolios.Folio INNER JOIN TiposContratacion ON 
				TiposContratacion.TipoContratacionId = HFolios.TipoContratacionId WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$dnActual);
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




/*######################################################################################################################
  ######################################################################################################################
  ######################################################################################################################
	  
	 AQUI COMIENZAN LOS METODOS PARA TRANSFER.

  ######################################################################################################################
  ######################################################################################################################
#######################################################################################################################*/



/*************************************************************************************************************
	El siguiente grupo de funciones comapra los registros de Transfer por diversos parametros
	como  y SIM 
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
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio = ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
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




/**
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del DN, IMEI y Fecha Activacion 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByFechaActivacionSim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$fechaActivacionContrato = $transfer->getFechaActivacionContrato();
			$sqlStr = "SELECT Inventario.Activacion FROM Inventario WHERE Inventario.EquipoId=(SELECT LFolios.EquipoId FROM LFolios WHERE LFolios.Folio=? AND LFolios.Serie=?) AND Inventario.Serie=? AND Inventario.Cantidad=-1 AND Inventario.Activacion=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ssss',$idOrdenRenovacion,$sim,$sim,$fechaActivacionContrato);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir de la SIM 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferBySim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio WHERE HFolios.Folio =? AND LFolios.Serie= ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$sim);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir de la Plan Nuevo y la SIM 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlanSim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$planActual = $transfer->getPlanActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$planActual);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del Plazo Contratado y la SIM 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlazoSim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$plazoActual = $transfer->getPlazoActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON Plazos.PlazoId=LFolios.PlazoId WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND Plazos.Plazo=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$plazoActual);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del DN, SIM y Folio 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByDnSim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$dnActual = $transfer->getDnActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$sim,$dnActual);
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


/*************************************************************************************************************
	El siguiente grupo de funciones comapra los registros de Transfer por diversos parametros
	como  IMEI
**************************************************************************************************************/

	/**
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion, SIM y Nombre pdv
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByNombrePdvImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$nombre = $transfer->getNombrePdv();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $idOrdenRenovacion,$imei,$nombre);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir de la IMEI 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio WHERE HFolios.Folio =? AND LFolios.Serie= ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$imei);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir de la Plan Nuevo y el IMEI 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlanImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$planActual = $transfer->getPlanActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$planActual);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del Plazo Contratado y el IMEI 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlazoImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$plazoActual = $transfer->getPlazoActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON Plazos.PlazoId=LFolios.PlazoId WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND Plazos.Plazo=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$plazoActual);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del DN, IMEI y Folio 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByDnImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$dnActual = $transfer->getDnActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio WHERE HFolios.Folio = ? AND LFolios.Serie= ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$idOrdenRenovacion,$imei,$dnActual);
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
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del DN, IMEI y Folio 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByFechaActivacionImei($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$imei = $transfer->getNewImei();
			$fechaActivacionContrato = $transfer->getFechaActivacionContrato();
			$sqlStr = "SELECT Inventario.Activacion FROM Inventario WHERE Inventario.EquipoId=(SELECT LFolios.EquipoId FROM LFolios WHERE LFolios.Folio=? AND LFolios.Serie=?) AND Inventario.Serie=? AND Inventario.Cantidad=-1 AND Inventario.Activacion=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ssss',$idOrdenRenovacion,$imei,$imei,$fechaActivacionContrato);
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



	/*######################################################################################################################
	  ######################################################################################################################
	  ######################################################################################################################
		  
		 AQUI COMIENZAN LOS METODOS PARA SEGUROS.
	
	  ######################################################################################################################
	  ######################################################################################################################
	  #######################################################################################################################*/
	
	
	
	/*************************************************************************************************************
		El siguiente grupo de funciones comapra los registros de Seguros por diversos parametros y el ID CONTRATO
	**************************************************************************************************************/

	/**
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del Order Id 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareSeguros($seguro){
		$returnValue = FALSE;
		if(isset($seguro) && is_a($seguro,'Seguros')){
			$orderId = $seguro->getOrderId();
			$sqlStr = "SELECT HFolios.Folio FROM LFolios INNER JOIN HFolios ON LFolios.Folio = HFolios.Folio WHERE HFolios.Folio = ? 
				AND LFolios.SeguroId <> 0";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$orderId);
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