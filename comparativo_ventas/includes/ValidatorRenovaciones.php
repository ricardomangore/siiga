<?php
include_once "comparativo_ventas/pojos/Layout.php";
include_once "comparativo_ventas/pojos/Renovaciones.php";
include_once "ToolsComparativoVentas.php";
include_once "comparativo_ventas/dao/LayoutDAO.php";
include_once "comparativo_ventas/dao/RenovacionesDAO.php";

class ValidatorRenovaciones{
	private $number_of_headers_renovaciones = 74;
	private $headersRenovaciones = ['NO_CONTRATO_IMPRESO','SUBCATEGORIA','INCIDENTE','ID_ORDEN_RENOVACION','CUENTA_CLIENTE','FECHA_ALTA_INC','FECHA_FIRMA','FECHA_CAPTURA','STATUS_RENOVACION','FECHA_STATUS','ID_EJECUTIVO','NOMBRE_EJECUTIVO','PUESTO_EJECUTIVO','NOMBRE_PDV','CLAVE_PDV','CANAL','EMPRESA','CO_ID','FECHA_ACTIVACION_CONTRATO','NEW_SIM','NEW_IMEI','NEW_NUM_SERIE','MODELO_NUEVO','COLOR_NUEVO','SKU','PLAN_INICIAL','RENTA_INICIAL','PLAZO_ANTERIOR','SIM_ANTERIOR','IMEI_ANTERIOR','SERIE_ANTERIOR','MODELO_ANTERIOR','COLOR_ANTERIOR','SKU_ANTERIOR','FECHA_REEMPLAZO','PLAN_ACTUAL','RENTA_ACTUAL','PLAZO_ACTUAL','IMPORTE_FACTURADO','DN_ACTUAL','DESC_AREA_SERV','TECNOLOGIA','SUBINVENTARIO','USUARIO_CCI_INICIAL','USUARIO_CCI_RENOCO','DEPARTAMENTO','NOMBRE_CONTACTO','REGION','SUBREGION','ESTADO','CIUDAD_COMERCIAL','MERCADO','DIRECCION_VTA','CANAL_VTA','CVE_UNICA','NUM_COORDINADOR','COORDINADOR','NUM_GERENTE','GERENTE','OPERADO_POR','MASTER_PDV','ID_DEUDOR','VP','AGRUPACION_CANAL','KAM','KAM_CORREO','TIPO_CLIENTE','ES_CONTROL','RENTA_SERV_CONTROL','ACCESS_FEE','ACCESS_FEE_SIN_CTRL','ACCESS_FEE_SERV_CONTROL','STATUS_TENURE','TIPO_MOVIMIENTO'];




	/**
	 * method: headerRenovacionesValidator($fileName)
	 * description: Validate tittle will be equals than array headersRenovaciones and headers'nums in the csv file
	 * params: <String>
	 * return <Boolean>
	 */
	public function headerRenovacionesValidator($fileName){
		$fp = fopen($fileName, "r");
		$linea = fgets($fp);
		$strArray = explode(',',$linea);
		fclose($fp);

		$returnValue = FALSE;
		if(sizeof($strArray) == $this->number_of_headers_renovaciones){
			for($i=0;$i<$this->number_of_headers_renovaciones;$i++){
				$cadena1 = utf8_encode(trim($this->headersRenovaciones[$i]));
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
			$newLayoutRegister->setIdTipoLayout(2);
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
	 * method: newRenovacinesRegister($fileName, $layoutRegister)
	 * description: create a new record in the table tw_renovcaciones
	 * params: <String>, <Object> Layout
	 * return <String> 
	 */
	public function newRenovacionesRegister($fileName, $layoutRegister){
		$returnValue = "######################### EXITO :) ############################";
		$tools = new ToolsComparativoVentas();
		$renovacionObj = new Renovaciones();
		$renovacionesDAO = new RenovacionesDAO();
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
			$renovacionObj->setIdLayout($idLayout);
			$renovacionObj->setFolio($folio);
			$renovacionObj->setNoContratoImpreso($row[0]);
			$renovacionObj->setSubcategoria($row[1]);
			$renovacionObj->setIncidente($row[2]);
			$renovacionObj->setIdOrdenRenovacion($row[3]);
			$renovacionObj->setCuentaCliente($row[4]);
			$renovacionObj->setFechaAltaInc($row[5]);
			$renovacionObj->setFecha_Firma($row[6]);
			$renovacionObj->setFechaCaptura($row[7]);
			$renovacionObj->setStatusRenovacion($row[8]);
			$renovacionObj->setFechaStatus($row[9]);
			$renovacionObj->setIdEjecutivo($row[10]);
			$renovacionObj->setNombreEjecutivo($row[11]);
			$renovacionObj->setPuestoEjecutivo($row[12]);
			$renovacionObj->setNombrePdv($row[13]);
			$renovacionObj->setClavePdv($row[14]);
			$renovacionObj->setCanal($row[15]);
			$renovacionObj->setEmpresa($row[16]);
			$renovacionObj->setCoId($row[17]);
			$renovacionObj->setFechaActivacionContrato($row[18]);
			$renovacionObj->setNewSim($row[19]);
			$renovacionObj->setNewImei($row[20]);
			$renovacionObj->setNewNumSerie($row[21]);
			$renovacionObj->setModeloNuevo($row[22]);
			$renovacionObj->setColorNuevo($row[23]);
			$renovacionObj->setSku($row[24]);
			$renovacionObj->setPlanInicial($row[25]);
			$renovacionObj->setRentaInicial($row[26]);
			$renovacionObj->setPlazoAnterior($row[27]);
			$renovacionObj->setSimAnterior($row[28]);
			$renovacionObj->setImeiAnterior($row[29]);
			$renovacionObj->setSerieAnterior($row[30]);
			$renovacionObj->setModeloAnterior($row[31]);
			$renovacionObj->setColorAnterior($row[32]);
			$renovacionObj->setSkuAnterior($row[33]);
			$renovacionObj->setFechaReemplazo($row[34]);
			$renovacionObj->setPlanActual($row[35]);
			$renovacionObj->setRentaActual($row[36]);
			$renovacionObj->setPlazoActual($row[37]);
			$renovacionObj->setImporteFacturado($row[38]);
			$renovacionObj->setDnActual($row[39]);
			$renovacionObj->setDescAreaServ($row[40]);
			$renovacionObj->setTecnologia($row[41]);
			$renovacionObj->setSubinventario($row[42]);
			$renovacionObj->setUsuarioCciInicial($row[43]);
			$renovacionObj->setUsuarioCciRenoco($row[44]);
			$renovacionObj->setDepartamento($row[45]);
			$renovacionObj->setNombreContacto($row[46]);
			$renovacionObj->setRegion($row[47]);
			$renovacionObj->setSubregion($row[48]);
			$renovacionObj->setEstado($row[49]);
			$renovacionObj->setCiudadComercial($row[50]);
			$renovacionObj->setMercado($row[51]);
			$renovacionObj->setDireccionVta($row[52]);
			$renovacionObj->setCanalVta($row[53]);
			$renovacionObj->setCveUnica($row[54]);
			$renovacionObj->setNumCoordinador($row[55]);
			$renovacionObj->setCoordinador($row[56]);
			$renovacionObj->setNumGerente($row[57]);
			$renovacionObj->setGerente($row[58]);
			$renovacionObj->setOperadoPor($row[59]);
			$renovacionObj->setMasterPdv($row[60]);
			$renovacionObj->setIdDeudor($row[61]);
			$renovacionObj->setVp($row[62]);
			$renovacionObj->setAgrupacionCanal($row[63]);
			$renovacionObj->setKam($row[64]);
			$renovacionObj->setKamCorreo($row[65]);
			$renovacionObj->setTipoCliente($row[66]);
			$renovacionObj->setEsControl($row[67]);
			$renovacionObj->setRentaServControl($row[68]);
			$renovacionObj->setAccessFee($row[69]);
			$renovacionObj->setAcceessFeeSinCtrl($row[70]);
			$renovacionObj->setAccessFeeServControl($row[71]);
			$renovacionObj->setStatusTenure($row[72]);
			$renovacionObj->setTipoMovimiento($row[73]);
			try{
				$renovacionesDAO->saveRenovacion($renovacionObj);
			}catch(Exception $e){
				$returnValue = $e->getMessage();
			}
		}
		return $returnValue;
	}


}
?>