<?php
include("../../includes/Conectar.php");
include_once("../../includes/Security.php");
include_once("includes/toolsValidaciones.php");




$Seguridad=new Security();
if(!$Seguridad->SesionExiste())
	header("Location: ../../index.php");
else{
	header("Content-Type: application/json");
	$ordenCRM = $_POST["ordenCRM"]; 
	$numeroDocumento = $_POST['numeroDocumento'];
	$descripcion = $_POST['descripcion'];
	$concepto = $_POST['concepto']; 
	$uid = $_POST['uid'];

	$boolMenssage = NULL;
	$toolvalidation = new toolsValidaciones();
	$type = 'error';
	$message = '';
	try{
		$boolMenssage = $toolvalidation->insertCancelationAndValdiation($ordenCRM,$numeroDocumento,$descripcion,$concepto,$uid);
	}catch(Exception $e){
		$boolMenssage = $e->getMessage();
	}
	if($boolMenssage == 'TRUE'){
		$type = 'Succefull';
		$message = 'Succefull insertion';
	}else{
		$message = $boolMenssage;
	}

	$response = array(
		'type' => $type,
		'message' => $message,
		'status' => 200,
	);





	/*header('Content-Type: application/json');
	$response = array(
		'orden_crm' => $ordenCRM,
		'numero_documento' => $numeroDocumento,
		'descripcion' => $descripcion,
		'concepto' => $concepto,
		'uid' => $uid,
	);*/
	echo json_encode($response);
}

?>


	
