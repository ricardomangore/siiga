<?php
include_once("comparativo_ventas/includes/ValidatorSeguros.php");
include_once("Comparativo_ventas/includes/ToolsComparativoVentas.php");
include_once("comparativo_ventas/dao/ComparativoVentasDAO.php");
include_once("comparativo_ventas/dao/SegurosDAO.php");
include_once("comparativo_ventas/dao/DiferenciasDAO.php");
include_once("Comparativo_ventas/pojos/ViewSeguros.php");
include_once("Comparativo_ventas/pojos/Diferencias.php");
/**
 * 
 */
class SegurosController
{
	
	function __construct(){
		
	}


	public function processSeguros($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValues = NULL;
		$validator = new ValidatorSeguros();
		try{
			if($validator->headerSegurosValidator($fileName)){
				$layoutRegister = $validator->getNewLayoutRegister($userID);
				//var_dump($layoutRegister);
				$messageReturn =$validator->newSegurosRegister($fileName,$layoutRegister);
				$returnValues = $messageReturn;
				$this->compareSeguros($layoutRegister, $uploadFolder);
			}
		}catch(Exception $e){
			$returnValues = $e->getMessage();
		}
		return $returnValues;

	}


	public function compareSeguros($layout, $uploadFolder){
		$arrayIncidencias = array();
		$segurosDAO = new SegurosDAO();
		$comparativoVentasDAO = new ComparativoVentasDAO();
		$diferenciaDAO = new DiferenciasDAO();
		$diferencia = new Diferencias();

		$segurosList = $segurosDAO->findSegurosByIdlayout($layout->getIdLayout());

		foreach($segurosList as $seguro){
			if($seguro->getOrderId() != ""){// SE EJECUTA CUANDO EL ORDER ID NO ES VACIO
				if(!$comparativoVentasDAO->compareSeguros($seguro)){//CASO 1: CUANDO EL SEGURO ID ES 0 ->caso 1 por no existir su diferencia
					$diferencia->setIdRegistro($seguro->getIdRegistro());
					$diferencia->setIdTipoDiferencia(1);
					$diferenciaDAO->saveDiferenciasDAO($diferencia);
				}
			}else{// CASO 2: ORDER ID NO COINCIDE (id_tipo_diferencia = 1)->caso 1 por no existir su diferencia
				$diferencia->setIdRegistro($seguro->getIdRegistro());
				$diferencia->setIdTipoDiferencia(1);
				$diferenciaDAO->saveDiferenciasDAO($diferencia);
			}
		}//Termina FOREACH
		$idlayout = $layout->getIdLayout();
		$tools = new ToolsComparativoVentas();
		$listaIncidentes = $comparativoVentasDAO->getListSegurosIncidents($idlayout);
		if($listaIncidentes != NULL){			
			$arrayIncidencias = $listaIncidentes;
			$fileName = $uploadFolder . "/" ."Seguros layout_$idlayout " . date("Y-m-d") . ".csv";
			$respuesta = $tools->createReportCsv($fileName ,$layout, $arrayIncidencias);
			if($respuesta){
				echo '<br>---> <a href="'. $fileName .'">DESCARGAR REPORTE</a> <---<br>';
	
				}else{
					echo "<br>ALGO SALIO MAL AL GENERAR EL REPORTE";
			}
		}else{//Termina IF
			echo "No se pudo completar la consulta de los incidentes<br>";
		}

	}//Termina metodo compareSeguros()

}//Termina Clase 
?>