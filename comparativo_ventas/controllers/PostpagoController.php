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


	public function validateHeaders($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValue = NULL;
		$validator = new Validator();
		try{
			if($validator->headerPostPagoValidator($fileName)){
				$newRegisterLayout = $validator->getNewLayoutRegister($userID);
				var_dump($newRegisterLayout);
				$returnValue = "<br>EXITO: operacion 100% exitosa";
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