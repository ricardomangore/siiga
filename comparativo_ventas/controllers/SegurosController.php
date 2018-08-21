<?php
require_once("comparativo_ventas/includes/ValidatorSeguros.php");
/**
 * 
 */
class SegurosController
{
	
	function __construct(){
		
	}


	public function processSeguros($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValues = NULL;
		$validator = new ValidatorSeguros();
		try{
			if($validator->headerSegurosValidator($fileName)){
				$returnValues = "<br>######### LOS ENCABEZADOS ESTAN BIEN :) ##########";
				$layoutRegister = $validator->getNewLayoutRegister($userID);
				var_dump($layoutRegister);
				$messageReturn =$validator->newSegurosRegister($fileName,$layoutRegister);
				$returnValues .= "<br>$messageReturn";
			}
		}catch(Exception $e){
			$returnValues = $e->getMessage();
		}
		return $returnValues;

	}
}
?>