<?php
include_once ("../../includes/Conectar.php");
include_once("includes/toolsValidaciones.php");
include_once("../../includes/Security.php");


$Seguridad = new Security();
if(!$Seguridad->SesionExiste()){
	header("Location: ../../index.php");
}else{
	header("Content-Type: application/json");
	$ValidationsTools = new toolsValidaciones();
	$date = $_GET['fecha'];
	$fileName = "FilesTmp/CancelacionesTesoreria/CancelationsReport-".$date.".csv";
	$message = $ValidationsTools->createCancelacionReport("../../". $fileName,$date);
	$type = '';
	$msj = '';
	if($message){
		$type = 'Succefull';
		$msj = 'SE CREO EL ARCHIVO CORRECTAMENTE';
	}else{
		$type = 'Error';
		$msj = 'NO HAY CANCELACIONES EN ESTE DIA';
	}
	$response = array(
		'type' => $type, 
		'message' => $msj, 
		'status' => 200, 
		'url' => $fileName,
		'fecha' => $date,
	);

	echo json_encode($response);

}

?> 
