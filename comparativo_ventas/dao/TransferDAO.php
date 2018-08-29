<?php
include_once ('comparativo_ventas/includes/Connect.php');
include_once ("comparativo_ventas/pojos/Transfer.php");

class TransferDAO extends Connect{


	/**
	 * method: saveTransferDAO()
	 * description: Save a new record on tw_transfer table
	 * params: <Object> transfer
	 * return <Object> transfer
	 */
	public function saveTransferDAO($transferDAO){
		$returnValue = NULL;
		if(isset($transferDAO) && is_a($transferDAO,'Transfer')){
			$id_layout = $transferDAO->getIdLayout();
			$folio = $transferDAO->getFolio();
			$no_contrato_impreso = $transferDAO->getNoContratoImpreso();
			$subcategoria = $transferDAO->getSubcategoria();
			$incidente = $transferDAO->getIncidente();
			$id_orden_renovacion = $transferDAO->getIdOrdenRenovacion();
			$cuenta_cliente = $transferDAO->getCuentaCliente();
			$fecha_alta_inc = $transferDAO->getFechaAltaInc();
			$fecha_firma = $transferDAO->getFechaFirma();
			$fecha_captura = $transferDAO->getFechaCaptura();
			$status_renovacion = $transferDAO->getStatusRenovacion();
			$fecha_status = $transferDAO->getFechaStatus();
			$id_ejecutivo = $transferDAO->getIdEjecutivo();
			$nombre_ejecutivo = $transferDAO->getNombreEjecutivo();
			$puesto_ejecutivo = $transferDAO->getPuestoEjecutivo();
			$nombre_pdv = $transferDAO->getNombrePdv();
			$clave_pdv = $transferDAO->getClavePdv();
			$canal = $transferDAO->getCanal();
			$empresa = $transferDAO->getEmpresa();
			$co_id = $transferDAO->getCoId();
			$fecha_activacion_contrato = $transferDAO->getFechaActivacionContrato(); 
			$new_sim = $transferDAO->getNewSim();
			$new_imei = $transferDAO->getNewImei();
			$new_num_serie = $transferDAO->getNewNumSerie();
			$modelo_nuevo = $transferDAO->getModeloNuevo();
			$color_nuevo = $transferDAO->getColorNuevo();
			$sku = $transferDAO->getSku();
			$plan_inicial = $transferDAO->getPlanInicial();
			$renta_inicial = $transferDAO->getRentaInicial();
			$plazo_anterior = $transferDAO->getPlazoAnterior();
			$sim_anterior = $transferDAO->getSimAnterior();
			$imei_anterior = $transferDAO->getImeiAnterior();
			$serie_anterior = $transferDAO->getSerieAnterior();
			$modelo_anterior = $transferDAO->getModeloAnterior();
			$color_anterior = $transferDAO->getColorAnterior();
			$sku_anterior = $transferDAO->getSkuAnterior();
			$fecha_reemplazo = $transferDAO->getFechaReemplazo();
			$plan_actual = $transferDAO->getPlanActual();
			$renta_actual = $transferDAO->getRentaActual();
			$plazo_actual = $transferDAO->getPlazoActual();
			$importe_facturado = $transferDAO->getImporteFacturado();
			$dn_actual = $transferDAO->getDnActual();
			$desc_area_serv = $transferDAO->getDescAreaServ();
			$tecnologia = $transferDAO->getTecnologia();
			$subinventario = $transferDAO->getSubinventario();
			$usuario_cci_inicial = $transferDAO->getUsuarioCciInicial();
			$usuario_cci_renoco = $transferDAO->getUsuarioCciRenoco();
			$departamento = $transferDAO->getDepartamento();
			$nombre_contacto = $transferDAO->getNombreContacto();
			$region = $transferDAO->getRegion();
			$subregion = $transferDAO->getSubregion();
			$estado = $transferDAO->getEstado();
			$ciudad_comercial = $transferDAO->getCiudadComercial();
			$mercado = $transferDAO->getMercado();
			$direccion_vta = $transferDAO->getDireccionVta();
			$canal_vta = $transferDAO->getCanalVta();
			$cve_unica = $transferDAO->getCveUnica();
			$num_coordinador = $transferDAO->getNumCoordinador();
			$coordinador = $transferDAO->getCoordinador();
			$num_gerente = $transferDAO->getNumGerente();
			$gerente = $transferDAO->getGerente();
			$operado_por = $transferDAO->getOperadoPor();
			$master_pdv = $transferDAO->getMasterPdv();
			$id_deudor = $transferDAO->getIdDeudor();
			$vp = $transferDAO->getVp();
			$agrupacion_canal = $transferDAO->getAgrupacionCanal();
			$kam = $transferDAO->getKam();
			$kam_correo = $transferDAO->getKamCorreo();
			$tipo_cliente = $transferDAO->getTipoCliente();
			$es_control = $transferDAO->getEsControl();
			$renta_serv_control = $transferDAO->getRentaServControl();
			$access_fee = $transferDAO->getAccessFee();
			$access_fee_sin_ctrl = $transferDAO->getAccessFeeSinCtrl();
			$access_fee_serv_control = $transferDAO->getAccessFeeServControl();
			$status_tenure = $transferDAO->getStatusTenure();
			$tipo_movimiento = $transferDAO->getTipoMovimiento();

			$sqlStr = "INSERT INTO tw_transfer (id_layout,folio,no_contrato_impreso,subcategoria,incidente,id_orden_renovacion,cuenta_cliente,fecha_alta_inc,fecha_firma,fecha_captura,status_renovacion,fecha_status,id_ejecutivo,nombre_ejecutivo,puesto_ejecutivo,nombre_pdv,clave_pdv,canal,empresa,co_id,fecha_activacion_contrato,new_sim,new_imei,new_num_serie,modelo_nuevo,color_nuevo,sku,plan_inicial,renta_inicial,plazo_anterior,sim_anterior,imei_anterior,serie_anterior,modelo_anterior,color_anterior,sku_anterior,fecha_reemplazo,plan_actual,renta_actual,plazo_actual,importe_facturado,dn_actual,desc_area_serv,tecnologia,subinventario,usuario_cci_inicial,usuario_cci_renoco,departamento,nombre_contacto,region,subregion,estado,ciudad_comercial,mercado,direccion_vta,canal_vta,cve_unica,num_coordinador,coordinador,num_gerente,gerente,operado_por,master_pdv,id_deudor,vp,agrupacion_canal,kam,kam_correo,tipo_cliente,es_control,renta_serv_control,access_fee,access_fee_sin_ctrl,access_fee_serv_control,status_tenure,tipo_movimiento) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param(
					"ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",$id_layout,$folio,$no_contrato_impreso,$subcategoria,$incidente,$id_orden_renovacion,$cuenta_cliente,$fecha_alta_inc,$fecha_firma,$fecha_captura,$status_renovacion,$fecha_status,$id_ejecutivo,$nombre_ejecutivo,$puesto_ejecutivo,$nombre_pdv,$clave_pdv,$canal,$empresa,$co_id,$fecha_activacion_contrato,$new_sim,$new_imei,$new_num_serie,$modelo_nuevo,$color_nuevo,$sku,$plan_inicial,$renta_inicial,$plazo_anterior,$sim_anterior,$imei_anterior,$serie_anterior,$modelo_anterior,$color_anterior,$sku_anterior,$fecha_reemplazo,$plan_actual,$renta_actual,$plazo_actual,$importe_facturado,$dn_actual,$desc_area_serv,$tecnologia,$subinventario,$usuario_cci_inicial,$usuario_cci_renoco,$departamento,$nombre_contacto,$region,$subregion,$estado,$ciudad_comercial,$mercado,$direccion_vta,$canal_vta,$cve_unica,$num_coordinador,$coordinador,$num_gerente,$gerente,$operado_por,$master_pdv,$id_deudor,$vp,$agrupacion_canal,$kam,$kam_correo,$tipo_cliente,$es_control,$renta_serv_control,$access_fee,$access_fee_sin_ctrl,$access_fee_serv_control,$status_tenure,$tipo_movimiento);

				$prepare->execute();
				$transferDAO->setIdRegistro($this->getLink()->insert_id);
				$prepare->close();
			}else{
				throw new Exception("No se pudo preparar la consulta");
			}
			//mysqli_close($this->getLink());
			$returnValue = $transferDAO;
		}
		return $returnValue;
	}



	/**
	 * method: findTransferDAO()
	 * description: Search one record by id and return a Transfer Object
	 * params: <Int> r
	 * return <Object> transfer
	 */
	public function findTransferDAO($idtransfer){
		$returnValue = NULL;
		if(isset($idtransfer)){
			$sqlStr = "SELECT * FROM tw_transfer WHERE id_registro=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("s", $idtransfer);
				$prepare->execute();
				$prepare->bind_result(
					$id_registro,$id_layout,$folio,$no_contrato_impreso,$subcategoria,$incidente,$id_orden_renovacion,$cuenta_cliente,$fecha_alta_inc,$fecha_firma,$fecha_captura,$status_renovacion,$fecha_status,$id_ejecutivo,$nombre_ejecutivo,$puesto_ejecutivo,$nombre_pdv,$clave_pdv,$canal,$empresa,$co_id,$fecha_activacion_contrato,$new_sim,$new_imei,$new_num_serie,$modelo_nuevo,$color_nuevo,$sku,$plan_inicial,$renta_inicial,$plazo_anterior,$sim_anterior,$imei_anterior,$serie_anterior,$modelo_anterior,$color_anterior,$sku_anterior,$fecha_reemplazo,$plan_actual,$renta_actual,$plazo_actual,$importe_facturado,$dn_actual,$desc_area_serv,$tecnologia,$subinventario,$usuario_cci_inicial,$usuario_cci_renoco,$departamento,$nombre_contacto,$region,$subregion,$estado,$ciudad_comercial,$mercado,$direccion_vta,$canal_vta,$cve_unica,$num_coordinador,$coordinador,$num_gerente,$gerente,$operado_por,$master_pdv,$id_deudor,$vp,$agrupacion_canal,$kam,$kam_correo,$tipo_cliente,$es_control,$renta_serv_control,$access_fee,$access_fee_sin_ctrl,$access_fee_serv_control,$status_tenure,$tipo_movimiento
				);
				$prepare->fetch();
				$transferObject = new Transfer();
				$transferObject->setIdRegistro($id_registro);
				$transferObject->setIdLayout($id_layout);
				$transferObject->setFolio($folio);
				$transferObject->setNoContratoImpreso($no_contrato_impreso);
				$transferObject->setSubcategoria($subcategoria);
				$transferObject->setIncidente($incidente);
				$transferObject->setIdOrdenRenovacion($id_orden_renovacion);
				$transferObject->setCuentaCliente($cuenta_cliente);
				$transferObject->setFechaAltaInc($fecha_alta_inc);
				$transferObject->setFechaFirma($fecha_firma);
				$transferObject->setFechaCaptura($fecha_captura);
				$transferObject->setStatusRenovacion($status_renovacion);
				$transferObject->setFechaStatus($fecha_status);
				$transferObject->setIdEjecutivo($id_ejecutivo);
				$transferObject->setNombreEjecutivo($nombre_ejecutivo);
				$transferObject->setPuestoEjecutivo($puesto_ejecutivo);
				$transferObject->setNombrePdv($nombre_pdv);
				$transferObject->setClavePdv($clave_pdv);
				$transferObject->setCanal($canal);
				$transferObject->setEmpresa($empresa);
				$transferObject->setCoId($co_id);
				$transferObject->setFechaActivacionContrato($fecha_activacion_contrato);
				$transferObject->setNewSim($new_sim);
				$transferObject->setNewImei($new_imei);
				$transferObject->setNewNumSerie($new_num_serie);
				$transferObject->setModeloNuevo($modelo_nuevo);
				$transferObject->setColorNuevo($color_nuevo);
				$transferObject->setSku($sku);
				$transferObject->setPlanInicial($plan_inicial);
				$transferObject->setRentaInicial($renta_inicial);
				$transferObject->setPlazoAnterior($plazo_anterior);
				$transferObject->setSimAnterior($sim_anterior);
				$transferObject->setImeiAnterior($imei_anterior);
				$transferObject->setSerieAnterior($serie_anterior);
				$transferObject->setModeloAnterior($modelo_anterior);
				$transferObject->setColorAnterior($color_anterior);
				$transferObject->setSkuAnterior($sku_anterior);
				$transferObject->setFechaReemplazo($fecha_reemplazo);
				$transferObject->setPlanActual($plan_actual);
				$transferObject->setRentaActual($renta_actual);
				$transferObject->setPlazoActual($plazo_actual);
				$transferObject->setImporteFacturado($importe_facturado);
				$transferObject->setDnActual($dn_actual);
				$transferObject->setDescAreaServ($desc_area_serv);
				$transferObject->setTecnologia($tecnologia);
				$transferObject->setSubinventario($subinventario);
				$transferObject->setUsuarioCciInicial($usuario_cci_inicial);
				$transferObject->setUsuarioCciRenoco($usuario_cci_renoco);
				$transferObject->setDepartamento($departamento);
				$transferObject->setNombreContacto($nombre_contacto);
				$transferObject->setRegion($region);
				$transferObject->setSubregion($subregion);
				$transferObject->setEstado($estado);
				$transferObject->setCiudadComercial($ciudad_comercial);
				$transferObject->setMercado($mercado);
				$transferObject->setDireccionVta($direccion_vta);
				$transferObject->setCanalVta($canal_vta);
				$transferObject->setCveUnica($cve_unica);
				$transferObject->setNumCoordinador($num_coordinador);
				$transferObject->setCoordinador($coordinador);
				$transferObject->setNumGerente($num_gerente);
				$transferObject->setGerente($gerente);
				$transferObject->setOperadoPor($operado_por);
				$transferObject->setMasterPdv($master_pdv);
				$transferObject->setIdDeudor($id_deudor);
				$transferObject->setVp($vp);
				$transferObject->setAgrupacionCanal($agrupacion_canal);
				$transferObject->setKam($kam);
				$transferObject->setKamCorreo($kam_correo);
				$transferObject->setTipoCliente($tipo_cliente);
				$transferObject->setEsControl($es_control);
				$transferObject->setRentaServControl($renta_serv_control);
				$transferObject->setAccessFee($access_fee);
				$transferObject->setAccessFeeSinCtrl($access_fee_sin_ctrl);
				$transferObject->setAccessFeeServControl($access_fee_serv_control);
				$transferObject->setStatusTenure($status_tenure);
				$transferObject->setTipoMovimiento($tipo_movimiento);

				$prepare->close();
				$returnValue = $transferObject;
			}
		}
		mysqli_close($this->getLink());
		return $returnValue;
	}



	/**
	 * method: findAllTransferDAO()
	 * description: Search all records in tw_transfer table
	 * params: <> 
	 * return array<Object> transfer
	 */
	public function findAllTransferDAO(){
		$returnValue = NULL;
		$arrayTransfer = array();
		$sqlStr = "SELECT * FROM tw_transfer";
		$query = $this->getLink()->query($sqlStr);
		if($query->num_rows != 0){
			while($fila = $query->fetch_array(MYSQLI_NUM)){
				$transferObj = new Transfer();
				$transferObj->setIdRegistro($fila[0]);
				$transferObj->setIdLayout($fila[1]);
				$transferObj->setFolio($fila[2]);
				$transferObj->setNoContratoImpreso($fila[3]);
				$transferObj->setSubcategoria($fila[4]);
				$transferObj->setIncidente($fila[5]);
				$transferObj->setIdOrdenRenovacion($fila[6]);
				$transferObj->setCuentaCliente($fila[7]);
				$transferObj->setFechaAltaInc($fila[8]);
				$transferObj->setFechaFirma($fila[9]);
				$transferObj->setFechaCaptura($fila[10]);
				$transferObj->setStatusRenovacion($fila[11]);
				$transferObj->setFechaStatus($fila[12]);
				$transferObj->setIdEjecutivo($fila[13]);
				$transferObj->setNombreEjecutivo($fila[14]);
				$transferObj->setPuestoEjecutivo($fila[15]);
				$transferObj->setNombrePdv($fila[16]);
				$transferObj->setClavePdv($fila[17]);
				$transferObj->setCanal($fila[18]);
				$transferObj->setEmpresa($fila[19]);
				$transferObj->setCoId($fila[20]);
				$transferObj->setFechaActivacionContrato($fila[21]);
				$transferObj->setNewSim($fila[22]);
				$transferObj->setNewImei($fila[23]);
				$transferObj->setNewNumSerie($fila[24]);
				$transferObj->setModeloNuevo($fila[25]);
				$transferObj->setColorNuevo($fila[26]);
				$transferObj->setSku($fila[27]);
				$transferObj->setPlanInicial($fila[28]);
				$transferObj->setRentaInicial($fila[29]);
				$transferObj->setPlazoAnterior($fila[30]);
				$transferObj->setSimAnterior($fila[31]);
				$transferObj->setImeiAnterior($fila[32]);
				$transferObj->setSerieAnterior($fila[33]);
				$transferObj->setModeloAnterior($fila[34]);
				$transferObj->setColorAnterior($fila[35]);
				$transferObj->setSkuAnterior($fila[36]);
				$transferObj->setFechaReemplazo($fila[37]);
				$transferObj->setPlanActual($fila[38]);
				$transferObj->setRentaActual($fila[39]);
				$transferObj->setPlazoActual($fila[40]);
				$transferObj->setImporteFacturado($fila[41]);
				$transferObj->setDnActual($fila[42]);
				$transferObj->setDescAreaServ($fila[43]);
				$transferObj->setTecnologia($fila[44]);
				$transferObj->setSubinventario($fila[45]);
				$transferObj->setUsuarioCciInicial($fila[46]);
				$transferObj->setUsuarioCciRenoco($fila[47]);
				$transferObj->setDepartamento($fila[48]);
				$transferObj->setNombreContacto($fila[49]);
				$transferObj->setRegion($fila[50]);
				$transferObj->setSubregion($fila[51]);
				$transferObj->setEstado($fila[52]);
				$transferObj->setCiudadComercial($fila[53]);
				$transferObj->setMercado($fila[54]);
				$transferObj->setDireccionVta($fila[55]);
				$transferObj->setCanalVta($fila[56]);
				$transferObj->setCveUnica($fila[57]);
				$transferObj->setNumCoordinador($fila[58]);
				$transferObj->setCoordinador($fila[59]);
				$transferObj->setNumGerente($fila[60]);
				$transferObj->setGerente($fila[61]);
				$transferObj->setOperadoPor($fila[62]);
				$transferObj->setMasterPdv($fila[63]);
				$transferObj->setIdDeudor($fila[64]);
				$transferObj->setVp($fila[65]);
				$transferObj->setAgrupacionCanal($fila[66]);
				$transferObj->setKam($fila[67]);
				$transferObj->setKamCorreo($fila[68]);
				$transferObj->setTipoCliente($fila[69]);
				$transferObj->setEsControl($fila[70]);
				$transferObj->setRentaServControl($fila[71]);
				$transferObj->setAccessFee($fila[72]);
				$transferObj->setAccessFeeSinCtrl($fila[73]);
				$transferObj->setAccessFeeServControl($fila[74]);
				$transferObj->setStatusTenure($fila[75]);
				$transferObj->setTipoMovimiento($fila[76]);
				array_push($arrayTransfer, $transferObj);
			}
			$returnValue = $arrayTransfer;
		}
		mysqli_close($this->getLink());
		return $returnValue;
	}


}
?>