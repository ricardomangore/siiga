<?php

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
			/*Esta parte es donde decubro los caracteres ocultos, con regex podria arreglarce*/
			$dato = $strArray[0];
			for($i=0;$i<strlen($dato);$i++){
				echo "<br>".utf8_encode($dato[$i]);
			}
			/*********************************************************************************/
			for($i=0;$i<$this->number_of_headers_postpago;$i++){
				$cadena1 = $this->headersPostPago[$i];
				$cadena2 = trim($strArray[$i]);
				echo "<br>" .$this->headersPostPago[$i] ."=" . trim($strArray[$i],' \t\n\r\0\x0B') . "<br>";
				echo "<br>" .strlen($this->headersPostPago[$i]) ."=" . strlen(trim($strArray[$i],' \t\n\r\0\x0B')) . "<br>";
				if($cadena1 == $cadena2 ){
					echo "bien";
				}else{
					echo "MUYYYY MAL";
				}

				
			}
		}else{//Valida disposiciòn de encabezados e igualdad entre nombres de encabezados
			echo "La cantidad de encabezados del archivo NO coincide con lo esperado";
		}

		return $returnValue;

	}


}