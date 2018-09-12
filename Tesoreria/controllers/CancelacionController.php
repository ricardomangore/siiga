<?php
include("../../includes/Conectar.php");
include("../../includes/Security.php");




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
	header('Content-Type: application/json');
	$response = array(
		'orden_crm' => $ordenCRM,
		'numero_documento' => $numeroDocumento,
		'descripcion' => $descripcion,
		'concepto' => $concepto,
		'uid' => $uid,
	);
	echo json_encode($response);
}	