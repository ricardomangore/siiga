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
	 * @param: <String> 
	 * @return <String> 
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
	 * description: Convert date format at mysql'datetime.
	 * @param: <String> dateformat(12-05-2018 14:25:12) 
	 * @return: <String> dateformat(2018-05-12 14:25:12)
	 */
	public function getDateFormat($date){
		$returnValue = "";
		$fecha = "";
		if($date != NULL && $date != "" && $date != "00:00.0"){
			$tempdate = str_replace("/", "-", $date);
			$fecha=date("Y-m-d H:i:s",strtotime($tempdate));
			$returnValue = $fecha;
		}
		return $returnValue;
	}


	/*ESTE METODO SE AGREGO POR QUE EN LAS CONSULTAS SE HACIA USO DE EL PERO NO EXISTIA*/
	public function getOnlyDate($date){
		$returnValue = "";
		if(isset($date)){
			preg_match("/(\d+\-\d+\-\d+).+/", $date, $newDate);
			$returnValue = $newDate[0];
		}
		return $returnValue;
	}



	/**
	 * method: createReportCsv($layout, $list, $titles)
	 * description: create a new csv file with data in the $list parameter
	 * @param: <Objetct> Layout, <Array> Object, <array> String 
	 * @return: <String> 
	 */
	public function createReportCsv($fileName, $layout, $list, $titles=NULL){
		$returnValue = FALSE;
		$delimiter = ",";
		$idlayout = $layout->getIdLayout();
		$datos = "";
		if($fileName != "" && !empty($list) && $layout != NULL){
			if($titles != NULL){
				$limitTile = sizeof($titles);
				for($i = 0;$i<($limitTile-1);$i++){
					$title = $titles[$i];
					$datos .= "$title,";
				}
				$finalTitle = $titles[$limitTile-1];
				$datos .= "$finalTitle";
				$datos .= "\r\n";
			}
			foreach($list as $row){
				$tempRow = "";
				$arrayMethods = get_class_methods($row);
				for($i = 1; $i<sizeof($arrayMethods); $i++){
					$method = $arrayMethods[$i];
					$subStr = substr($method,0,3);
					if($subStr == 'get'){
						$getTemp =  $row->$method();
						$tempRow .= $getTemp .",";
					}
				}
				$datos .= trim($tempRow, ',');
				$datos .= "\r\n";
			}
			if(!$f = fopen($fileName, "w")){
				$returnValue = FALSE;
			}else{
				if(fwrite($f,utf8_decode($datos)) == FALSE){
					$returnValue = FALSE;
				}else{
					$returnValue = TRUE;
					fclose($f);
				}
			}
		}else{
			$returnValue = FALSE;
		}
		return $returnValue;
	}


}

?>