<?php
include(__DIR__ ."/../../includes/Conectar.php");
include_once("includes/toolsValidaciones.php");
include_once(__DIR__ ."/../../includes/Security.php");


$Seguridad = new Security();
if(!$Seguridad->SesionExiste()){
	header("Location: ../../index.php");
}else{
	header("Content-Type: application/json");
	$ValidationsTools = new toolsValidaciones();
	$fileName = "FilesTmp/CancelacionesTesoreria/CancelationsReport-".date('d-m-Y H-i-s').".csv";
	$message = $ValidationsTools->createCancelacionReport(__DIR__."/../../". $fileName);
	$type = '';
	$msj = '';
	if($message){
		$type = 'Succefull';
		$msj = 'SE CREO EL ARCHIVO CORRECTAMENTE';
	}else{
		$type = 'Error';
		$msj = 'NO SE PUDO CREAR EL ARCHIVO';
	}
	$response = array(
		'type' => $type, 
		'message' => $msj, 
		'status' => 200, 
		'url' => $fileName,
	);

	echo json_encode($response);

}

?> 