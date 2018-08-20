<?php
require_once ("comparativo_ventas/includes/Validator.php");
/**
 * 
 */
class PostpagoController
{
	
	function __construct()
	{
	}


	public function processPostPago($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValue = NULL;
		$validator = new Validator();
		try{
			if($validator->headerPostPagoValidator($fileName)){
				$newRegisterLayout = $validator->getNewLayoutRegister($userID);
				var_dump($newRegisterLayout);

				$MessajeReturn = $validator->getNewPostPagoRegister($fileName, $newRegisterLayout);
				$returnValue = "<br>EXITO: operacion 100% exitosa" . "<br>" . $MessajeReturn;
			}else{
				$returnValue = "Alguna validacion no fue satisfctoria";
			}
		}catch(Exception $e){
			$returnValue = $e->getMessage();
		}
		return $returnValue;
	}



}

?>