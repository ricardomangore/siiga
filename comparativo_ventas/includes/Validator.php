<?php
include_once "/../pojos/Layout.php";
include_once "/../pojos/PostPago.php";
include_once "ToolsComparativoVentas.php";
include_once "comparativo_ventas/dao/LayoutDAO.php";
include_once "comparativo_ventas/dao/PostPagoDAO.php";

class Validator{

	private $number_of_headers_postpago= 102;
	private $headersPostPago = ['NO CONTRATO IMPRESO','ID ORDEN CONTRATACION','FECHA CONTRATACION','PRICEGROUP','CUENTA CLIENTE','NOMBRE CLIENTE','TIPO PERSONA','SUBTIPO PERSONA','TIPO VENTA','STATUS ORDEN','FECHA STATUS ORDEN','EMPRESA','CVE UNICA PDV','NOMBRE PDV UNICO','PDV ESTATUS','MASTER PDV','KAM','CVE UNICA EJECUTIVO','NOMBRE EJECUTIVO UNICO','ATTUID NIVEL 2','NUM NIVEL 2','NOMBRE NIVEL 2','ATTUID NIVEL 3','NUM NIVEL 3','NOMBRE NIVEL 3','ATTUID NIVEL 4','NUM NIVEL 4','NOMBRE NIVEL 4','ATTUID NIVEL 5','NUM NIVEL 5','NOMBRE NIVEL 5','ATTUID NIVEL 6','NUM NIVEL 6','NOMBRE NIVEL 6','ATTUID NIVEL 7','NUM NIVEL 7','NOMBRE NIVEL 7','VENTAS','ID CONTRATO','NIR','MDN INICIAL','PROPIEDAD','FECHA ACTIVACION','MES','SEMANA CONSEJO','MDN ACTUAL','FECHA MDN ACTUAL','SIM','IMEI','SKU','MODELO EQUIPO','MARCA EQUIPO','COLOR EQUIPO','CAPACIDAD EQUIPO','MODALIDAD','TECNOLOGIA','PLAN TARIFARIO HOMO','PLAN TARIFARIO HOMO','PLAZO FORZOSO','FAMILIA','MARCA PLAN','RENTA','NVA RENTA','ACCESSFEE MENS','NVA RENTA SEM','ACCESSFEE SEML','REGION','SUBREGION','ESTADO','CIUDAD COMERCIAL','CVE MERCADO','MERCADO','VP','DIRECCION VTA','AGRUPACION CANAL','CANAL VTA','SEMANA RECARGA','FECHA PRIMER ABONO','MONTO PRIMER ABONO','FECHA SEGUNDO ABONO','MONTO SEGUNDO ABONO','MDN DEFINITIVO','FECHA PORT IN','DONADOR IN','RECEPTOR IN','FECHA PORT OUT','DONADOR OUT','RECEPTOR OUT','CONCESIONADO','ES CONTROL','ES T NEXT','ES VOLTE','CVE EJECUTIVO CODIFICA','EJECUTIVO CODIFICA','CVE PDV CODIFICA','PDV CODIFICA','FECHA CODIFICA','FOLIO CODIFICA','ATTUID CODIFICA','FECHA MOVIMIENTO','DIA','VPGM'];




	/**
	 * method: headerPostPagoValidator($fileName)
	 * description: Validate tittle will be equals than array headersPostPago and headers'nums in the csv file
	 * @param: <String>
	 * @return: <Boolean>
	 */
	public function headerPostPagoValidator($fileName){
		$fp = fopen($fileName, "r");
		$linea = fgets($fp);
		$strArray = explode(',',$linea);
		fclose($fp);

		$returnValue = FALSE;
		if(sizeof($strArray) == $this->number_of_headers_postpago){
			for($i=0;$i<$this->number_of_headers_postpago;$i++){
				$cadena1 = utf8_encode(trim($this->headersPostPago[$i]));
				$cadena2 = utf8_encode(trim($strArray[$i]));
				preg_match("/([a-zA-Z\s\d]+)/", $cadena1, $cadenaRevision1);
				preg_match("/([\w\s\d]+)/", $cadena2, $cadenaRevision2);
				if(strcmp($cadenaRevision1[0],$cadenaRevision2[0]) != 0 ){
					throw new Exception("El encabezado" . $cadenaRevision2[0] . " NO coincide con lo esperado");
					break;
				}
				$returnValue = TRUE;
			}
		}else{
			throw new Exception("La cantidad de encabezados del archivo NO coincide con lo esperado");
		}

		return $returnValue;
	}



	/**
	 * method: getNewLayoutRegister($idUser)
	 * description: create a new record in the table tw_layout and return a object with this data
	 * @param: <Int>
	 * @return: <Object> Layout
	 */
	public function getNewLayoutRegister($idUser){
		$returnValue = NUll;
		if($idUser != NUll){
			$newLayoutRegister = new Layout();
			$newLayoutRegister->setIdUsuario($idUser);
			$newLayoutRegister->setFecha(date("Y-m-d"));
			$newLayoutRegister->setHora(date("H:i:s"));
			$newLayoutRegister->setIdTipoLayout(1);
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
	 * method: getNewPostPagoRegister($fileName, $layoutRegister)
	 * description: create a new record in the table tw_postpago
	 * @param: <String>, <Object> Layout
	 * @return: <String> 
	 */
	public function getNewPostPagoRegister($fileName, $layoutRegister){
		$tools = new ToolsComparativoVentas();
		$postPagoObj = new PostPago();
		$postPAgoDAO = new PostPagoDAO();
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
				if($i == 2 || $i == 10 || $i == 42 || $i == 46 || $i == 77 || $i == 79 || $i == 82 || $i == 85 || $i == 96 || $i == 99){
					$dateFormat = $tools->getDateFormat($row[$i]);
					$row[$i] = $dateFormat;
				}
			}
			$postPagoObj->setIdLayout($idLayout);
			$postPagoObj->setFolio($folio);
			$postPagoObj->setNoContatoImpreso($row[0]);
			$postPagoObj->setIdOrdenContratacion($row[1]);
			$postPagoObj->setFechaContratacion($row[2]);
			$postPagoObj->setPriceGroup($row[3]);
			$postPagoObj->setCuentaCliente($row[4]);
			$postPagoObj->setNombreCliente($row[5]);
			$postPagoObj->setTipoPersona($row[6]);
			$postPagoObj->setSubtipoPersona($row[7]);
			$postPagoObj->setTipoVenta($row[8]);
			$postPagoObj->setStatusOrden($row[9]);
			$postPagoObj->setFechaStatusOrden($row[10]);
			$postPagoObj->setEmpresa($row[11]);
			$postPagoObj->setCveUnicaPdv($row[12]);
			$postPagoObj->setNombrePdvUnico($row[13]);
			$postPagoObj->setPdvEstatus($row[14]);
			$postPagoObj->setMasterPdv($row[15]);
			$postPagoObj->setKam($row[16]);
			$postPagoObj->setCveUnicaEjecutivo($row[17]);
			$postPagoObj->setNombreEjecutivoUnico($row[18]);
			$postPagoObj->setAttuidNivel2($row[19]);
			$postPagoObj->setNumNivel2($row[20]);
			$postPagoObj->setNombreNivel2($row[21]);
			$postPagoObj->setAttuidNivel3($row[22]);
			$postPagoObj->setNumNivel3($row[23]);
			$postPagoObj->setNombreNivel3($row[24]);
			$postPagoObj->setAttuidNivel4($row[25]);
			$postPagoObj->setNumNivel4($row[26]);
			$postPagoObj->setNombreNivel4($row[27]);
			$postPagoObj->setAttuidNivel5($row[28]);
			$postPagoObj->setNumNivel5($row[29]);
			$postPagoObj->setNombreNivel5($row[30]);
			$postPagoObj->setAttuidNivel6($row[31]);
			$postPagoObj->setNumNIvel6($row[32]);
			$postPagoObj->setNombreNivel6($row[33]);
			$postPagoObj->setAttuidNivel7($row[34]);
			$postPagoObj->setNumNivel7($row[35]);
			$postPagoObj->setNombreNivel7($row[36]);
			$postPagoObj->setVentas($row[37]);
			$postPagoObj->setIdContrato($row[38]);
			$postPagoObj->setNir($row[39]);
			$postPagoObj->setMdnInicial($row[40]);
			$postPagoObj->setPropiedad($row[41]);
			$postPagoObj->setFechaActivacion($row[42]);
			$postPagoObj->setMes($row[43]);
			$postPagoObj->setSemanaConsejo($row[44]);
			$postPagoObj->setMdnActual($row[45]);
			$postPagoObj->setFechaMdnActual($row[46]);
			$postPagoObj->setSim($row[47]);
			$postPagoObj->setImei($row[48]);
			$postPagoObj->setSku($row[49]);
			$postPagoObj->setModeloEquipo($row[50]);
			$postPagoObj->setMarcaEquipo($row[51]);
			$postPagoObj->setColorEquipo($row[52]);
			$postPagoObj->setCapacidadEquipo($row[53]);
			$postPagoObj->setModalidad($row[54]);
			$postPagoObj->setTecnologia($row[55]);
			$postPagoObj->setPlanTarifarioHomo($row[56]);
			$postPagoObj->setPlanTarifarioHomo2($row[57]);
			$postPagoObj->setPlazoForzoso($row[58]);
			$postPagoObj->setFamilia($row[59]);
			$postPagoObj->setMarcaPlan($row[60]);
			$postPagoObj->setRenta($row[61]);
			$postPagoObj->setNvaRenta($row[62]);
			$postPagoObj->setAccessfeeMens($row[63]);
			$postPagoObj->setNvaRentaSem($row[64]);
			$postPagoObj->setAccessfeeSeml($row[65]);
			$postPagoObj->setRegion($row[66]);
			$postPagoObj->setSubregion($row[67]);
			$postPagoObj->setEstado($row[68]);
			$postPagoObj->setCiudadComercial($row[69]);
			$postPagoObj->setCveMercado($row[70]);
			$postPagoObj->setMercado($row[71]);
			$postPagoObj->setVp($row[72]);
			$postPagoObj->setDireccionVta($row[73]);
			$postPagoObj->setAgrupacionCanal($row[74]);
			$postPagoObj->setCanalVta($row[75]);
			$postPagoObj->setSemanaRecarga($row[76]);
			$postPagoObj->setFechaPrimerAbono($row[77]);
			$postPagoObj->setMontoPrimerAbono($row[78]);
			$postPagoObj->setFechaSegundoAbono($row[79]);
			$postPagoObj->setMontoSegundoAbono($row[80]);
			$postPagoObj->setMdnDefinitivo($row[81]);
			$postPagoObj->setFechaPortIn($row[82]);
			$postPagoObj->setDonadorIn($row[83]);
			$postPagoObj->setReceptorIn($row[84]);
			$postPagoObj->setFechaPortOut($row[85]);
			$postPagoObj->setDonadorOut($row[86]);
			$postPagoObj->setReceptorOut($row[87]);
			$postPagoObj->setConcesionado($row[88]);
			$postPagoObj->setEsControl($row[89]);
			$postPagoObj->setEsTNext($row[90]);
			$postPagoObj->setEsVolte($row[91]);
			$postPagoObj->setCveEjecutivoCodifica($row[92]);
			$postPagoObj->setEjecutivoCodifica($row[93]);
			$postPagoObj->setCvePdvCodifica($row[94]);
			$postPagoObj->setPdvCodifica($row[95]);
			$postPagoObj->setFechaCodifica($row[96]);
			$postPagoObj->setFolioCodifica($row[97]);
			$postPagoObj->setAttuidCodifica($row[98]);
			$postPagoObj->setFechaMovimiento($row[99]);
			$postPagoObj->setDia($row[100]);
			$postPagoObj->setVpgm($row[101]);

			$postPAgoDAO->savePostPagoDAO($postPagoObj);

		}
		return "########################### EXITO AL INSERTAR ###########################";
		
	}


}