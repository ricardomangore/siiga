<?php
include_once(__DIR__ . "/../../../comparativo_ventas/includes/Connect.php");

class toolsValidaciones extends Connect
{
	public function insertCancelationAndValdiation($ordenCRM, $numeroDocumento, $descripcion, $concepto, $uId){
		$returnvalue = '';
		if($ordenCRM !== "" && $numeroDocumento !== "" && $uId !== ""){
			try{
				$fecha = date("Y-m-d H:i:s");
				$query = "INSERT INTO cancelacionestesoreria (orden_crm,numero_documento,descripcion,concepto,uid,fecha_cancelacion) VALUES (?,?,?,?,?,?)";
				if($prepare = $this->getLink()->prepare($query)){
					$prepare->bind_param("ssssss",$ordenCRM,$numeroDocumento,$descripcion,$concepto,$uId,$fecha);
					if($prepare->execute()){
						$prepare->close();
						$returnvalue = 'TRUE';	
					}else{
						$prepare->close();
						$returnvalue = 'EL Registro con el numero de Orden CRM '.$ordenCRM. ' y numero de documento '.$numeroDocumento.' ya Existe';//$prepare->error;
					}
				}else{
					throw new Exception("Error al preparar la consulta");
				}
			}catch(mysqli_sql_exception $e){
				$returnvalue = $e->getMessage();
			}
		}
		return $returnvalue;
	}

}


?>
