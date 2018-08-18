<?php
include_once "/../pojos/Layout.php";
include_once "comparativo_ventas/dao/LayoutDAO.php";

class Validator{

	private $number_of_headers_postpago= 104;
	private $headersPostPago = ['ID ORDEN CONTRATACION','ID CONTRATO','NO CONTRATO IMPRESO','ID ORDEN CONTRATACION','FECHA CONTRATACION','PRICEGROUP','CUENTA CLIENTE','NOMBRE CLIENTE','TIPO PERSONA','SUBTIPO PERSONA','TIPO VENTA','STATUS ORDEN','FECHA STATUS ORDEN','EMPRESA','CVE UNICA PDV','NOMBRE PDV UNICO','PDV ESTATUS','MASTER PDV','KAM','CVE UNICA EJECUTIVO','NOMBRE EJECUTIVO UNICO','ATTUID NIVEL 2','NUM NIVEL 2','NOMBRE NIVEL 2','ATTUID NIVEL 3','NUM NIVEL 3','NOMBRE NIVEL 3','ATTUID NIVEL 4','NUM NIVEL 4','NOMBRE NIVEL 4','ATTUID NIVEL 5','NUM NIVEL 5','NOMBRE NIVEL 5','ATTUID NIVEL 6','NUM NIVEL 6','NOMBRE NIVEL 6','ATTUID NIVEL 7','NUM NIVEL 7','NOMBRE NIVEL 7','VENTAS','ID CONTRATO','NIR','MDN INICIAL','PROPIEDAD','FECHA ACTIVACION','MES','SEMANA CONSEJO','MDN ACTUAL','FECHA MDN ACTUAL','SIM','IMEI','SKU','MODELO EQUIPO','MARCA EQUIPO','COLOR EQUIPO','CAPACIDAD EQUIPO','MODALIDAD','TECNOLOGIA','PLAN TARIFARIO HOMO','PLAN TARIFARIO HOMO','PLAZO FORZOSO','FAMILIA','MARCA PLAN','RENTA','NVA RENTA','ACCESSFEE MENS','NVA RENTA SEM','ACCESSFEE SEML','REGION','SUBREGION','ESTADO','CIUDAD COMERCIAL','CVE MERCADO','MERCADO','VP','DIRECCION VTA','AGRUPACION CANAL','CANAL VTA','SEMANA RECARGA','FECHA PRIMER ABONO','MONTO PRIMER ABONO','FECHA SEGUNDO ABONO','MONTO SEGUNDO ABONO','MDN DEFINITIVO','FECHA PORT IN','DONADOR IN','RECEPTOR IN','FECHA PORT OUT','DONADOR OUT','RECEPTOR OUT','CONCESIONADO','ES CONTROL','ES T NEXT','ES VOLTE','CVE EJECUTIVO CODIFICA','EJECUTIVO CODIFICA','CVE PDV CODIFICA','PDV CODIFICA','FECHA CODIFICA','FOLIO CODIFICA','ATTUID CODIFICA','FECHA MOVIMIENTO','DIA','VPGM'];




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
				//echo "<br>" .$cadenaRevision1[0] ."=" . $cadenaRevision2[0] . "<br>";
				//echo "<br>" .strlen($cadenaRevision1[0]) ."=" . strlen($cadenaRevision2[0]) . "<br>";
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


}