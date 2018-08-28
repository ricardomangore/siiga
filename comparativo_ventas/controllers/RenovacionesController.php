<?php
include_once("comparativo_ventas/includes/ValidatorRenovaciones.php");
/**
 * 
 */
class RenovacionesController
{
	
	function __construct(){
		
	}


	 public function processRenovaciones($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
	 	$returnValores = NULL;
	 	$validator = new ValidatorRenovaciones();
	 	try{
	 		if($validator->headerRenovacionesValidator($fileName)){
	 			$returnValores = "<br>########## LOS TITULOS ESTAN BIEN ##########";
	 			$layoutRegistered = $validator->getNewLayoutRegister($userID);
	 			var_dump($layoutRegistered);
	 			$messageReturned = $validator->newRenovacionesRegister($fileName, $layoutRegistered);
	 			$returnValores .= "<br>$messageReturned";
	 		}
	 	}catch(Exception $e){
	 		$returnValores = $e->getMessage();
	 	}
	 	return $returnValores;

	 }

}
?>