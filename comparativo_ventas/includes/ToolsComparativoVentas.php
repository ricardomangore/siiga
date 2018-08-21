<?php
/**
 * 
 */
class ToolsComparativoVentas
{
	
	function __construct(){

	}



	/**
	 * method: fetFolio($NoContratoImpreso)
	 * description: get a folio number, this do clean number of the letters
	 * params: <String> 
	 * return <String> 
	 */
	public function getFolio($NoContratoImpreso){
		$returnValue = "";
		if($NoContratoImpreso != NULL){
			preg_match("/([\d\s]+)/", $NoContratoImpreso, $folioAux);
			if(!empty($folioAux)){
				$folioNumber = $folioAux[0];
				$folioArray = str_split($folioNumber);
				for($index = 0; $index < sizeof($folioArray); $index ++){
					if($folioArray[$index]== 0)
						array_shift($folioArray);
					else
						break;
				}
				$returnValue = implode('',$folioArray);
			}
		}
		return $returnValue;
	}




	/**
	 * method: getDateFormat($date)
	 * @description: Convert date format at mysql'datetime.
	 * @params: <String> dateformat(12-05-2018 14:25:12) 
	 * return: <String> dateformat(2018-05-12 14:25:12)
	 */
	public function getDateFormat($date){
		$returnValue = "";
		$fecha = "";
		if($date != NULL && $date != ""){
			$fecha=date("Y-m-d H:i:s",strtotime($date));
			$returnValue = $fecha;
		}
		return $returnValue;
	}


}

?>