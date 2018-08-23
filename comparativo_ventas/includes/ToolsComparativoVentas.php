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




	/**
	 * method: createReportCsv($layout, $list, $titles)
	 * description: create a new csv file with data in the $list parameter
	 * @param: <Objetct> Layout, <Array> Object, <array> String 
	 * @return: <String> 
	 */
	public function createReportCsv($tableName, $layout, $list, $titles){
		$returnValue = NULL;
		$delimiter = ",";
		$idlayout = $layout->getIdLayout();
		$temp = "FilesTmp/";
		$datos = "";
		if($tableName != "" && !empty($list) && !empty($titles)){
			$fileName = $temp . "$tableName layout_$idlayout " . date("Y-m-d") . ".csv";
			$limitTile = sizeof($titles);
			for($i = 0;$i<($limitTile-1);$i++){
				$title = $titles[$i];
				$datos .= "$title,";
			}
			$finalTitle = $titles[$limitTile-1];
			$datos .= "$finalTitle";
			$datos .= "\r\n";
			foreach($list as $row){
				$tempRow = "";
				$arrayMethods = get_class_methods($row);
				for($i = 1; $i<sizeof($arrayMethods); $i++){
					$method = $arrayMethods[$i];
					$subStr = substr($method,0,3);
					var_dump($subStr);
					if($subStr == 'get'){
						$getTemp =  $row->$method();
						$tempRow .= $getTemp .",";
						var_dump($method);
					}
				}
				$datos .= trim($tempRow, ',');
				$datos .= "\r\n";
			}
			if(!$f = fopen($fileName, "w")){
				$returnValue = "El archivo no se pudo crear";
			}else{
				if(fwrite($f,utf8_decode($datos)) == FALSE){
					$returnValue = "El archivo no se pude escribir";
				}else{
					$returnValue = "EXITO AL CREAR EL ARCHIVO";
					fclose($f);
				}
			}
		}else{
			$returnValue = "NINGUN DATO DEBE ESTAR VACIO: ENCABEZADOS, DATOS, NOMBRE DE LA TABLA";
		}
		return $returnValue;
	}


}

?>