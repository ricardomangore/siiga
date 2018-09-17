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
	public function compareTransferByOrdenRenovacion($transfer){
		$returnValue= FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$ordenRenovacion = $transfer->getIdOrdenRenovacion();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$ordenRenovacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				$prepare->close();
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
	public function compareRenovacionesByOrdenRenovacion($renovacion){
		$returnValue= FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$ordenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$ordenRenovacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				$prepare->close();
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

				$prepare->close();
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

/************************************************************************************************
	El siguiente grupo de funciones comapra los registros de PoatPago por diversos parametros
	como Nombre del Punto de venta, Nombre del ejecutivo etc. Tomando como campos principales 
	o lleves primarias Folio y en su caso el campo a buscar
************************************************************************************************/

#######################################################################################################
########################## METODOS PARA VERIFICAR SI EXISTE EL IMEI y SIM #############################
#######################################################################################################
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
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$sqlStr="SELECT LFolios.serie FROM LFolios WHERE LFolios.Folio = ? AND LFolios.serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$folio,$imei);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}
		return $returnValue;
	}
	/**
	 * comaparePostPagoBySim()
	 * Determina si un objeto PostPago es igual a un registro de ventas de SIIGA
	 * a partir del SIM
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoBySim($postPago){
		$returnValue= FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $postPago->getSim();
			$sqlStr="SELECT LFolios.serie FROM LFolios WHERE LFolios.Folio = ? AND LFolios.serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$folio,$sim);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}
		return $returnValue;
	}
	

################################################################################################
################################################################################################
	/**
	 * Determina si ounb objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombrePDV($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sqlStr="SELECT PuntosATT.NombreATT FROM HFolios INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$folio);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				

				$pdvNameCis = strtoupper($postPago->getNombrePdvUnico());
				$pdvNameSiiga = strtoupper($param);

				//var_dump($param);
				$prepare->close();
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
	 * a partir del folio y Tipo de Venta
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByTipoVenta($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PsotPago')){
			$folio = $postPago->getFolio();
			$tipoVenta = $postPago->getTipoVenta();
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio = ? AND TiposContratacion.Tipocontratacion = ?';
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$folio,$tipoVenta);
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
	 * a partir del folio y Nombre Ejecutivo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombreEjecutivo($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$nombreEjecutivo = $postPago->getNombreEjecutivoUnico();//'CARMEN YOLANDA PINKUS AMADOR';//;$postPago->getNombreEjecutivoUnico();
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$folio,$nombreEjecutivo);
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
	 * a partir del folio y Plazo Forzoso adquirido
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlazoForzoso($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$plazoForzoso = $postPago->getPlazoForzoso();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Plazos ON LFolios.PlazoId=Plazos.PlazoId WHERE HFolios.Folio = ? AND Plazos.Plazo = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss', $folio,$plazoForzoso);
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
	 * a partir del folio y Modelo Equipo
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByModeloEquipo($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$modeloEquipo = $postPago->getModeloEquipo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Equipos ON Equipos.EquipoId=LFolios.EquipoId WHERE HFolios.Folio = ? AND Equipos.Equipo = ? ";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss', $folio,$modeloEquipo);
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
	 * a partir del folio y Plan
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByPlan($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$plan = $postPago->getPlantarifarioHomo();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss', $folio,$plan);
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
	 * a partir del folio y DN
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByDN($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$mdn = $postPago->getMdnActual();
			$sqlStr = "SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE HFolios.Folio = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss', $folio,$mdn);
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
	 * a partir del folio y Fecah de Activación
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
			$sqlStr = "SELECT Inventario.Activacion FROM Inventario WHERE Inventario.EquipoId=(SELECT LFolios.EquipoId FROM LFolios WHERE LFolios.Folio=?) AND Inventario.Serie=? AND Inventario.Cantidad=-1 AND Inventario.Activacion=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss', $folio,$imei,$fechaActivacion);
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



######################################################################################################################
############################## METODOS PARA COMPROBAR LA EXISTENCIA DE IMEI Y SIM EN SIIGA ###########################
######################################################################################################################
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
			$sqlStr="SELECT LFolios.serie FROM LFolios WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$imei);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				$prepare->close();
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
			$sqlStr="SELECT LFolios.serie FROM LFolios WHERE LFolios.Folio = ? AND 
				LFolios.Serie = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$sim);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);

				$prepare->close();
				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}

		return $returnValue;
	}
######################################################################################################################
######################################################################################################################
	/**
	 * Determina si un objeto Renovaciones es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByNombrePDV($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$sqlStr="SELECT PuntosATT.NombreATT FROM HFolios INNER JOIN PuntosATT ON 
				PuntosATT.PuntoVentaId=HFolios.PuntoVentaId WHERE HFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s',$idOrdenRenovacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				$pdvNameCis = strtoupper($renovacion->getNombrePdv());
				$pdvNameSiiga = strtoupper($param);
				
				//var_dump($param);
				$prepare->close();
				if($pdvNameSiiga == $pdvNameCis){
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
	 * a partir del id orden renovacion y Fecha activacion contrato
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByFechaActivacionContrato($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$tools = new ToolsComparativoVentas();
			$fechaActivacionContrato=$tools->getOnlyDate($renovacion->getFechaActivacionContrato());
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN TiposContratacion ON
				TiposContratacion.TipoContratacionId=HFolios.TipoContratacionId WHERE HFolios.Folio = ? AND 
				HFolios.FechaContrato = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$fechaActivacionContrato);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);
				$prepare->close();
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
	 * a partir del id orden renovacion y Plan Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlanActual($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$planActual = $renovacion->getPlanActual();
			$sqlStr="SELECT LFolios.Folio FROM LFolios INNER JOIN Planes ON LFolios.PlanId = Planes.PlanId
				WHERE LFolios.Folio = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$planActual);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);
				$prepare->close();
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
	 * a partir del id orden renovacion y Plazo Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByPlazoActual($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$plazoActual = $renovacion->getPlazoActual();
			$sqlStr="SELECT LFolios.Folio FROM LFolios INNER JOIN Plazos ON LFolios.PlazoId = Plazos.PlazoId
				WHERE LFolios.Folio = ? AND Plazos.PlazoId = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$plazoActual);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);
				$prepare->close();
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
	 * a partir del id orden renovacion y Dn Actual
	 * @param <Object> Renovacion
	 * @return <boolean>
	 */
	public function compareRenovacionesByDnActual($renovacion){
		$returnValue = FALSE;
		if(isset($renovacion) && is_a($renovacion,'Renovaciones')){
			$idOrdenRenovacion = $renovacion->getIdOrdenRenovacion();
			$dnActual = $renovacion->getDnActual();
			$sqlStr="SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$dnActual);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				//var_dump($param);
				$prepare->close();
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


##########################################################################################################################
########################## METODOS PARA COMPROBAR LA EXISTENCIA DE IMEI Y SIM EN SIIGA ###################################
##########################################################################################################################


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
			$sqlStr = "SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio =? AND LFolios.Serie= ?";
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
	 * a partir de la SIM 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferBySim($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sim = $transfer->getNewSim();
			$sqlStr = "SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio =? AND LFolios.Serie= ?";
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

##########################################################################################################################
##########################################################################################################################

	/**
	 * Determina si un objeto Transfer es igual a un registro de ventas dentro del SIIGA
	 * a partir del id orden renovacion y Nombre pdv
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByNombrePdv($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$sqlStr = "SELECT PuntosATT.NombreATT FROM HFolios INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('s', $idOrdenRenovacion);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				$pdvNameCis = strtoupper($transfer->getNombrePdv());
				$pdvNameSiiga = strtoupper($param);

				//var_dump($param);

				$prepare->close();
				if($pdvNameCis == $pdvNameSiiga){
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
	 * a partir del DNy Fecha Activacion 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByFechaActivacion($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$fechaActivacionContrato = $transfer->getFechaActivacionContrato();
			$sqlStr = "SELECT Inventario.Activacion FROM Inventario WHERE Inventario.EquipoId=(SELECT LFolios.EquipoId FROM LFolios WHERE LFolios.Folio=?) AND Inventario.Cantidad=-1 AND Inventario.Activacion=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$fechaActivacionContrato);
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
	 * a partir del orden de renovacion 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlan($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$planActual = $transfer->getPlanActual();
			$sqlStr = "SELECT LFolios.Folio FROM LFolios INNER JOIN Planes ON Planes.PlanId=LFolios.PlanId WHERE LFolios.Folio = ? AND Planes.Plan = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$planActual);
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
	 * a partir del Plazo Contratado
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByPlazo($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$plazoActual = $transfer->getPlazoActual();
			$sqlStr = "SELECT LFolios.Folio FROM LFolios INNER JOIN Plazos ON Plazos.PlazoId=LFolios.PlazoId WHERE LFolios.Folio = ? AND Plazos.Plazo=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$plazoActual);
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
	 * a partir del DN y Folio 
	 * @param <Object> Transfer
	 * @return <boolean>
	 */
	public function compareTransferByDn($transfer){
		$returnValue = FALSE;
		if(isset($transfer) && is_a($transfer,'Transfer')){
			$idOrdenRenovacion = $transfer->getIdOrdenRenovacion();
			$dnActual = $transfer->getDnActual();
			$sqlStr = "SELECT LFolios.Folio FROM LFolios WHERE LFolios.Folio = ? AND LFolios.Dn = ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('ss',$idOrdenRenovacion,$dnActual);
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