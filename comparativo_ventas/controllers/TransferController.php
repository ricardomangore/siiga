<?php
include_once("siiga/comparativo_ventas/includes/ValidatorTransfer.php");
/**
 * 
 */
class TransferController
{
	
	function __construct(){

	}

	public function processTransfer($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValores = NULL;
		$validator = new ValidatorTransfer();
		try{
			if($validator->headerTransferValidator($fileName)){
				$returnValores = "<br> LOS ENCABEZADOS ESTAN BIEN";
				$layoutRegistered = $validator->getNewLayoutRegister($userID);
				var_dump($layoutRegistered);
				$messageReturned = $validator->newTransferRegister($fileName, $layoutRegistered);
				$returnValores .= "<br>$messageReturned";
			}
		}catch(Exception $e){
			$returnValores = $e->getMessage();
		}
		return $returnValores;
	}
}
?>