<?php
include_once "comparativo_ventas/pojos/Layout.php";
include_once "comparativo_ventas/pojos/Transfer.php";
include_once "ToolsComparativoVentas.php";
include_once "comparativo_ventas/dao/LayoutDAO.php";
include_once "comparativo_ventas/dao/TransferDAO.php";
class ValidatorTransfer{
	private $number_of_headers_transfer = 74;
	private $headersTransfer = ['NO_CONTRATO_IMPRESO','SUBCATEGORIA','INCIDENTE','ID_ORDEN_RENOVACION','CUENTA_CLIENTE','FECHA_ALTA_INC','FECHA_FIRMA','FECHA_CAPTURA','STATUS_RENOVACION','FECHA_STATUS','ID_EJECUTIVO','NOMBRE_EJECUTIVO','PUESTO_EJECUTIVO','NOMBRE_PDV','CLAVE_PDV','CANAL','EMPRESA','CO_ID','FECHA_ACTIVACION_CONTRATO','NEW_SIM','NEW_IMEI','NEW_NUM_SERIE','MODELO_NUEVO','COLOR_NUEVO','SKU','PLAN_INICIAL','RENTA_INICIAL','PLAZO_ANTERIOR','SIM_ANTERIOR','IMEI_ANTERIOR','SERIE_ANTERIOR','MODELO_ANTERIOR','COLOR_ANTERIOR','SKU_ANTERIOR','FECHA_REEMPLAZO','PLAN_ACTUAL','RENTA_ACTUAL','PLAZO_ACTUAL','IMPORTE_FACTURADO','DN_ACTUAL','DESC_AREA_SERV','TECNOLOGIA','SUBINVENTARIO','USUARIO_CCI_INICIAL','USUARIO_CCI_RENOCO','DEPARTAMENTO','NOMBRE_CONTACTO','REGION','SUBREGION','ESTADO','CIUDAD_COMERCIAL','MERCADO','DIRECCION_VTA','CANAL_VTA','CVE_UNICA','NUM_COORDINADOR','COORDINADOR','NUM_GERENTE','GERENTE','OPERADO_POR','MASTER_PDV','ID_DEUDOR','VP','AGRUPACION_CANAL','KAM','KAM_CORREO','TIPO_CLIENTE','ES_CONTROL','RENTA_SERV_CONTROL','ACCESS_FEE','ACCESS_FEE_SIN_CTRL','ACCESS_FEE_SERV_CONTROL','STATUS_TENURE','TIPO_MOVIMIENTO'];



	/**
	 * method: headerTransferValidator($fileName)
	 * description: Validate tittle will be equals than array headersTransfer and headers'nums in the csv file
	 * params: <String>
	 * return <Boolean>
	 */
	public function headerTransferValidator($fileName){
		$fp = fopen($fileName, "r");
		$linea = fgets($fp);
		$strArray = explode(',',$linea);
		fclose($fp);

		$returnValue = FALSE;
		if(sizeof($strArray) == $this->number_of_headers_transfer){
			for($i=0;$i<$this->number_of_headers_transfer;$i++){
				$cadena1 = utf8_encode(trim($this->headersTransfer[$i]));
				$cadena2 = utf8_encode(trim($strArray[$i]));
				preg_match("/([a-zA-Z\s\d\_]+)/", $cadena1, $cadenaRevision1);
				preg_match("/([\w\s\d\_]+)/", $cadena2, $cadenaRevision2);
				if(strcmp($cadenaRevision1[0],$cadenaRevision2[0]) != 0 ){
					throw new Exception("<br>El encabezado" . $cadenaRevision2[0] . " NO coincide con lo esperado");
					break;
				}
				$returnValue = TRUE;
			}
		}else{
			throw new Exception("<br>La cantidad de encabezados del archivo NO coincide con lo esperado");
		}

		return $returnValue;		
	}


	/**
	 * method: getNewLayoutRegister($idUser)
	 * description: create a new record in the table tw_layout and return a object with this data
	 * params: <Int>
	 * return <Object> Layout
	 */
	public function getNewLayoutRegister($idUser){
		$returnValue = NUll;
		if($idUser != NUll){
			$newLayoutRegister = new Layout();
			$newLayoutRegister->setIdUsuario($idUser);
			$newLayoutRegister->setFecha(date("Y-m-d"));
			$newLayoutRegister->setHora(date("h:i:s"));
			$newLayoutRegister->setIdTipoLayout(3);
			$newLayoutDAO = new LayoutDAO();
			try{
				$returnValue = $newLayoutDAO->saveLayout($newLayoutRegister);
			}catch(\Exception $e){
				$returnValue =  $e->getMessage();
			}
		}
		return $returnValue;
	}



	/**
	 * method: newTransferRegister($fileName, $layoutRegister)
	 * description: create a new record in the table tw_transfer
	 * params: <String>, <Object> Layout
	 * return <String> 
	 */
	public function newTransferRegister($fileName, $layoutRegister){
		$returnValue = "<center>######################### EXITO ############################</center>";
		$tools = new ToolsComparativoVentas();
		$transferObj = new Transfer();
		$transferDAO = new TransferDAO();
		$fp = fopen($fileName, "r");
		$rows = array();
		$folio = "";
		$idLayout = $layoutRegister->getIdLayout();
		while(($row = fgets($fp)) != FALSE){
			$tempRow = explode(',',$row);
			array_push($rows, $tempRow);
		}
		fclose($fp);
		unset($rows[0]);
		foreach($rows as $row){
			for($i=0;$i<count($row);$i++){
				if($i == 0){
					$folio = $tools->getFolio($row[$i]);
				}
				if($i == 5 || $i == 6 || $i == 7 || $i == 9 || $i ==18 || $i == 34){
					$dateFormat = $tools->getDateFormat($row[$i]);
					$row[$i] = $dateFormat;
				}
			}
			$transferObj->setIdLayout($idLayout);
			$transferObj->setFolio($folio);
			$transferObj->setNoContratoImpreso($row[0]);
			$transferObj->setSubcategoria($row[1]);
			$transferObj->setIncidente($row[2]);
			$transferObj->setIdOrdenRenovacion($row[3]);
			$transferObj->setCuentaCliente($row[4]);
			$transferObj->setFechaAltaInc($row[5]);
			$transferObj->setFechaFirma($row[6]);
			$transferObj->setFechaCaptura($row[7]);
			$transferObj->setStatusRenovacion($row[8]);
			$transferObj->setFechaStatus($row[9]);
			$transferObj->setIdEjecutivo($row[10]);
			$transferObj->setNombreEjecutivo($row[11]);
			$transferObj->setPuestoEjecutivo($row[12]);
			$transferObj->setNombrePdv($row[13]);
			$transferObj->setClavePdv($row[14]);
			$transferObj->setCanal($row[15]);
			$transferObj->setEmpresa($row[16]);
			$transferObj->setCoId($row[17]);
			$transferObj->setFechaActivacionContrato($row[18]);
			$transferObj->setNewSim($row[19]);
			$transferObj->setNewImei($row[20]);
			$transferObj->setNewNumSerie($row[21]);
			$transferObj->setModeloNuevo($row[22]);
			$transferObj->setColorNuevo($row[23]);
			$transferObj->setSku($row[24]);
			$transferObj->setPlanInicial($row[25]);
			$transferObj->setRentaInicial($row[26]);
			$transferObj->setPlazoAnterior($row[27]);
			$transferObj->setSimAnterior($row[28]);
			$transferObj->setImeiAnterior($row[29]);
			$transferObj->setSerieAnterior($row[30]);
			$transferObj->setModeloAnterior($row[31]);
			$transferObj->setColorAnterior($row[32]);
			$transferObj->setSkuAnterior($row[33]);
			$transferObj->setFechaReemplazo($row[34]);
			$transferObj->setPlanActual($row[35]);
			$transferObj->setRentaActual($row[36]);
			$transferObj->setPlazoActual($row[37]);
			$transferObj->setImporteFacturado($row[38]);
			$transferObj->setDnActual($row[39]);
			$transferObj->setDescAreaServ($row[40]);
			$transferObj->setTecnologia($row[41]);
			$transferObj->setSubinventario($row[42]);
			$transferObj->setUsuarioCciInicial($row[43]);
			$transferObj->setUsuarioCciRenoco($row[44]);
			$transferObj->setDepartamento($row[45]);
			$transferObj->setNombreContacto($row[46]);
			$transferObj->setRegion($row[47]);
			$transferObj->setSubregion($row[48]);
			$transferObj->setEstado($row[49]);
			$transferObj->setCiudadComercial($row[50]);
			$transferObj->setMercado($row[51]);
			$transferObj->setDireccionVta($row[52]);
			$transferObj->setCanalVta($row[53]);
			$transferObj->setCveUnica($row[54]);
			$transferObj->setNumCoordinador($row[55]);
			$transferObj->setCoordinador($row[56]);
			$transferObj->setNumGerente($row[57]);
			$transferObj->setGerente($row[58]);
			$transferObj->setOperadoPor($row[59]);
			$transferObj->setMasterPdv($row[60]);
			$transferObj->setIdDeudor($row[61]);
			$transferObj->setVp($row[62]);
			$transferObj->setAgrupacionCanal($row[63]);
			$transferObj->setKam($row[64]);
			$transferObj->setKamCorreo($row[65]);
			$transferObj->setTipoCliente($row[66]);
			$transferObj->setEsControl($row[67]);
			$transferObj->setRentaServControl($row[68]);
			$transferObj->setAccessFee($row[69]);
			$transferObj->setAccessFeeSinCtrl($row[70]);
			$transferObj->setAccessFeeServControl($row[71]);
			$transferObj->setStatusTenure($row[72]);
			$transferObj->setTipoMovimiento($row[73]);
			try{
				$transferDAO->saveTransferDAO($transferObj);
			}catch(Exception $e){
				$returnValue = $e->getMessage();
			}
		}
		return $returnValue;
	}


}
?>