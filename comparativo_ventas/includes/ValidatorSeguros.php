<?php
include_once "siiga/comparativo_ventas/pojos/Layout.php";
include_once "siiga/comparativo_ventas/pojos/Seguros.php";
include_once "ToolsComparativoVentas.php";
include_once "comparativo_ventas/dao/LayoutDAO.php";
include_once "comparativo_ventas/dao/SegurosDAO.php";

class ValidatorSeguros{
	private $number_of_headers_seguros = 63;
	private $headersSeguros = ['ID_CONTRATO','SNCODE','SEGURO','RENTA','FECHA_ACT_SEG','ID_CONTRATO','CUENTA_CLIENTE','ESTATUS_ACT_SEG','FECHA_ULTMOD_SEG','EMPRESA','ORDER_ID','ORDER_ACTION_ID','ORDER_STATUS_DESCRIPTION','CVE_UNICA_PDV','NOMBRE_PDV_UNICO','PDV_ESTATUS','MASTER_PDV','KAM','CVE_UNICA_EJECUTIVO','NOMBRE_EJECUTIVO_UNICO','ATTUID_NIVEL_2','NUM_NIVEL_2','NOMBRE_NIVEL_2','ATTUID_NIVEL_3','NUM_NIVEL_3','NOMBRE_NIVEL_3','ATTUID_NIVEL_4','NUM_NIVEL_4','NOMBRE_NIVEL_4','ATTUID_NIVEL_5','NUM_NIVEL_5','NOMBRE_NIVEL_5','ATTUID_NIVEL_6','NUM_NIVEL_6','NOMBRE_NIVEL_6','ATTUID_NIVEL_7','NUM_NIVEL_7','NOMBRE_NIVEL_7','VENTAS','FECHA_ACT_CONTR','MDN','MES','SEMANA_CONSEJO','SKU','MODELO_EQUIPO','MARCA_EQUIPO','COLOR_EQUIPO','CAPACIDAD_EQUIPO','PLAN_TARIFARIO_ORIGEN','PLAN_TARIFARIO_FINAL','FAMILIA','MARCA_PLAN','REGION','SUBREGION','ESTADO','CIUDAD_COMERCIAL','CVE_MERCADO','MERCADO','VP','DIRECCION_VTA','AGRUPACION_CANAL','CANAL_VTA','VPGM'];


	public function headerSegurosValidator($fileName){
		$fp = fopen($fileName, "r");
		$linea = fgets($fp);
		$strArray = explode(',',$linea);
		fclose($fp);

		$returnValue = FALSE;
		if(sizeof($strArray) == $this->number_of_headers_seguros){
			for($i=0;$i<$this->number_of_headers_seguros;$i++){
				$cadena1 = utf8_encode(trim($this->headersSeguros[$i]));
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

	public function getNewLayoutRegister($idUser){
		$returnValue = NUll;
		if($idUser != NUll){
			$newLayoutRegister = new Layout();
			$newLayoutRegister->setIdUsuario($idUser);
			$newLayoutRegister->setFecha(date("Y-m-d"));
			$newLayoutRegister->setHora(date("h:i:s "));
			$newLayoutRegister->setIdTipoLayout(4);
			$newLayoutDAO = new LayoutDAO();
			try{
				$returnValue = $newLayoutDAO->saveLayout($newLayoutRegister);
			}catch(\Exception $e){
				$returnValue =  $e->getMessage();
			}
		}
		return $returnValue;
	}


	public function newSegurosRegister($fileName, $layoutRegister){
		$returnValue = "######################### EXITO :) ############################";
		$tools = new ToolsComparativoVentas();
		$segurosObj = new Seguros();
		$segurosDAO = new SegurosDAO();
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
				if($i == 4 || $i == 39 ){
					$dateFormat = $tools->getDateFormat($row[$i]);
					$row[$i] = $dateFormat;
				}
			}
			$segurosObj->setIdLayout($idLayout);
			$segurosObj->setIdContrato($row[0]);
			$segurosObj->setSnCode($row[1]);
			$segurosObj->setSeguro($row[2]);
			$segurosObj->setRenta($row[3]);
			$segurosObj->setFechaActSeg($row[4]);
			$segurosObj->setIdContrato2($row[5]);
			$segurosObj->setCuentaCliente($row[6]);
			$segurosObj->setEstatusActSeg($row[7]);
			$segurosObj->setFechaUltmodSeg($row[8]);
			$segurosObj->setEmpresa($row[9]);
			$segurosObj->setOrderId($row[10]);
			$segurosObj->setOrderActionId($row[11]);
			$segurosObj->setOrderStatusDescription($row[12]);
			$segurosObj->setCveUnicaPdv($row[13]);
			$segurosObj->setNombrePdvUnico($row[14]);
			$segurosObj->setPdvEstatus($row[15]);
			$segurosObj->setMasterPdv($row[16]);
			$segurosObj->setKam($row[17]);
			$segurosObj->setCveUnicaEjecutivo($row[18]);
			$segurosObj->setNombreEjecutivoUnico($row[19]);
			$segurosObj->setAttuidNivel2($row[20]);
			$segurosObj->setNumNivel2($row[21]);
			$segurosObj->setNombreNivel2($row[22]);
			$segurosObj->setAttuidNivel3($row[23]);
			$segurosObj->setNumNivel3($row[24]);
			$segurosObj->setNombreNivel3($row[25]);
			$segurosObj->setAttuidNivel4($row[26]);
			$segurosObj->setNumNivel4($row[27]);
			$segurosObj->setNombreNivel4($row[28]);
			$segurosObj->setAttuidNivel5($row[29]);
			$segurosObj->setNumNivel5($row[30]);
			$segurosObj->setNombreNivel5($row[31]);
			$segurosObj->setAttuidNivel6($row[32]);
			$segurosObj->setNumNivel6($row[33]);
			$segurosObj->setNombreNivel6($row[34]);
			$segurosObj->setAttuidNivel7($row[35]);
			$segurosObj->setNumNivel7($row[36]);
			$segurosObj->setNombreNivel7($row[37]);
			$segurosObj->setVentas($row[38]);
			$segurosObj->setFechaActContr($row[39]);
			$segurosObj->setMdn($row[40]);
			$segurosObj->setMes($row[41]);
			$segurosObj->setSemanaConsejo($row[42]);
			$segurosObj->setSku($row[43]);
			$segurosObj->setModeloEquipo($row[44]);
			$segurosObj->setMarcaEquipo($row[45]);
			$segurosObj->setColorEquipo($row[46]);
			$segurosObj->setCapacidadEquipo($row[47]);
			$segurosObj->setPlanTarifarioOrigen($row[48]);
			$segurosObj->setPlanTarifarioFinal($row[49]);
			$segurosObj->setFamilia($row[50]);
			$segurosObj->setMarcaPlan($row[51]);
			$segurosObj->setRegion($row[52]);
			$segurosObj->setSubregion($row[53]);
			$segurosObj->setEstado($row[54]);
			$segurosObj->setCiudadComercial($row[55]);
			$segurosObj->setCveMercado($row[56]);
			$segurosObj->setMercado($row[57]);
			$segurosObj->setVp($row[58]);
			$segurosObj->setDireccionVta($row[59]);
			$segurosObj->setAgrupacionCanal($row[60]);
			$segurosObj->setCanalVta($row[61]);
			$segurosObj->setVpgm($row[62]);
			try{
				$segurosDAO->saveSeguro($segurosObj);
			}catch(Exception $e){
				$returnValue = $e->getMessage();
			}
		}

		return $returnValue;
	}


}
?>