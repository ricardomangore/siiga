<?php
include_once(__DIR__ . "/../../../comparativo_ventas/includes/Connect.php");
include_once("/../ViewCancelationReport.php");

class toolsValidaciones extends Connect
{
	public function insertCancelationAndValdiation($ordenCRM, $numeroDocumento, $descripcion, $concepto, $uId){
		$returnvalue = '';
		if($ordenCRM !== "" && $numeroDocumento !== "" && $uId !== ""){
			try{
				$fecha = date("Y-m-d");
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

	public function getListCancelations($fecha){
		$returnValue = NULL;
		$arrayCancelations = array();
		//$fechaHoy = date("Y-m-d");
		//$fechaAyer = date("Y-m-d", strtotime("yesterday"));
		$query = "SELECT CONCAT(empleados.Nombre,' ',empleados.Paterno,' ',empleados.Materno), cancelacionestesoreria.orden_crm, cancelacionestesoreria.numero_documento, cancelacionestesoreria.concepto, cancelacionestesoreria.fecha_cancelacion, cancelacionestesoreria.descripcion FROM cancelacionestesoreria INNER JOIN usuarios 
			ON cancelacionestesoreria.uid = usuarios.UsuarioId INNER JOIN empleados ON usuarios.EmpleadoId = empleados.EmpleadoId
			WHERE cancelacionestesoreria.fecha_cancelacion =  '".$fecha."'";
		$prepare = $this->getLink()->query($query);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				//var_dump($fila);
				$viewCancelationReporObj = new ViewCancelationReport();
				$viewCancelationReporObj->setNombre($fila[0]);
				$viewCancelationReporObj->setOrdenCrm($fila[1]);
				$viewCancelationReporObj->setNumeroDocumento($fila[2]);
				$viewCancelationReporObj->setConcepto($fila[3]);
				$viewCancelationReporObj->setFechaCancelacion($fila[4]);
				$viewCancelationReporObj->setDescripcion($fila[5]);
				array_push($arrayCancelations, $viewCancelationReporObj);
			}
			$returnValue = $arrayCancelations;
		}
		return $returnValue;
	}

	public function createCancelacionReport($fileName,$fecha){
		$returnValue = FALSE;
		$cancelationsList = $this->getListCancelations($fecha);
		$titles = array('Nombre','Orden CRM','Numero Documento','Concepto','Fecha Cancelacion','Descripcion');
		if($cancelationsList != NULL){
			if($flag = $this->generateReport($fileName,$cancelationsList,$titles)){
				$returnValue = TRUE;
			}
		}
		return $returnValue;
	}

	public function generateReport($fileName, $list, $titles=NULL){
		$returnValue = FALSE;
		$delimiter = ",";
		$datos = "";
		if($fileName != "" && !empty($list)){
			if($titles != NULL){
				$limitTile = sizeof($titles);
				for($i = 0;$i<($limitTile-1);$i++){
					$title = $titles[$i];
					$datos .= "$title,";
				}
				$finalTitle = $titles[$limitTile-1];
				$datos .= "$finalTitle";
				$datos .= "\r\n";
			}
			foreach($list as $row){
				$tempRow = "";
				$arrayMethods = get_class_methods($row);
				for($i = 0; $i<sizeof($arrayMethods); $i++){
					$method = $arrayMethods[$i];
					$subStr = substr($method,0,3);
					if($subStr == 'get'){
						$getTemp =  $row->$method();
						$tempRow .= $getTemp .",";
					}
				}
				$datos .= trim($tempRow, ',');
				$datos .= "\r\n";
			}
			if(!$f = fopen($fileName, "w")){
				$returnValue = FALSE;
			}else{
				if(fwrite($f,utf8_decode($datos)) == FALSE){
					$returnValue = FALSE;
				}else{
					$returnValue = TRUE;
					fclose($f);
				}
			}
		}else{
			$returnValue = FALSE;
		}
		return $returnValue;
	}//Termina generateReport



}//Termina Clase toolsValidaciones


?>
