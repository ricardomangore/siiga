<?php
include_once("comparativo_ventas/includes/ValidatorRenovaciones.php");
include_once("comparativo_ventas/dao/RenovacionesDAO.php");
include_once("comparativo_ventas/dao/ComparativoVentasDAO.php");
include_once("comparativo_ventas/dao/TiposDiferenciasDAO.php");
include_once("comparativo_ventas/pojos/Diferencias.php");
include_once("Comparativo_ventas/pojos/ViewRenovaciones.php");
include_once("Comparativo_ventas/includes/ToolsComparativoVentas.php");
/**
 * 
 */
class RenovacionesController
{
	
	function __construct(){
		
	}


	 public function processRenovaciones($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
	 	$returnValores = NULL;
	 	$validator = new ValidatorRenovaciones();
	 	try{
	 		if($validator->headerRenovacionesValidator($fileName)){
	 			$layoutRegistered = $validator->getNewLayoutRegister($userID);
	 			//var_dump($layoutRegistered);
	 			$messageReturned = $validator->newRenovacionesRegister($fileName, $layoutRegistered);
	 			$returnValores = $messageReturned;
	 			$this->compareRenovaciones($layoutRegistered, $uploadFolder);
	 		}
	 	}catch(Exception $e){
	 		$returnValores = $e->getMessage();
	 	}
	 	return $returnValores;

	 }


	 public function compareRenovaciones($layout, $uploadFolder){
		$arrayIncidencias = array();
		$renovacionesDAO = new RenovacionesDAO();
		$comparativoVentasDAO = new ComparativoVentasDAO();
		$diferenciaDAO = new DiferenciasDAO();
		$diferencia = new Diferencias();

		$renovacionesList = $renovacionesDAO->findRenovacionesByIdLayout($layout->getIdLayout());
	
		$case = 1;	
		foreach($renovacionesList as $renovacion){
			if($renovacion->getNewImei() != ""){// SE EJECUTA CUANDO EL IMEI NO ES VACIO
				switch ($case){
					case 1:{// CASO 1: NOMBRE PDV NO COINCIDE ($id_tipo_diferencia = 2)
						if(!$comparativoVentasDAO->compareRenovacionesByNombrePDVImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 2:{// CASO 2: FECHA ACTIVACION CONTRATO NO COINCIDE (id_tipo_diferencia = 4)
						if(!$comparativoVentasDAO->compareRenovacionesByFechaActivacionContratoImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(4);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{// CASO 3: NEW SIM NO COINCIDE (id_tipo_diferencia = 6)
						if(!$comparativoVentasDAO->compareRenovacionesByNewSimImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(6);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 4:{// CASO 4: NEW IMEI NO COINCIDE (id_tipo_diferencia = 7)
						if(!$comparativoVentasDAO->compareRenovacionesByNewImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(7);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 5:{// CASO 5: PLAN ACTUAL NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->compareRenovacionesByPlanActualImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 6:{// CASO 6: PLAZO ACTUAL NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->compareRenovacionesByPlazoActualImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 7:{// CASO 7 : DN ACTUAL NO COINCIDE (id_tipo_diferencia = 1)
						if(!$comparativoVentasDAO->compareRenovacionesByDnActualImei($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}							
					}
				}

			}else{// USA SIM CUANDO EL IMEI ES VACIO
				switch ($case){
					case 1:{// CASO 1: NOMBRE PDV NO COINCIDE (id_tipo_diferencia = 2)
						if(!$comparativoVentasDAO->compareRenovacionesByNombrePDVSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 2:{// CASO 2: FECHA ACTIVACION CONTRATO NO COINCIDE (id_tipo_diferencia = 4)
						if(!$comparativoVentasDAO->compareRenovacionesByFechaActivacionContratoSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(4);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 3:{// CASO 3: NEW SIM NO COINCIDE (id_tipo_diferencia = 6)
						if(!$comparativoVentasDAO->compareRenovacionesByNewSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(6);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 4:{// CASO 4: NEW IMEI NO COINCIDE (id_tipo_diferencia = 7)
						if(!$comparativoVentasDAO->compareRenovacionesByNewImeiSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(7);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 5:{// CASO 5: PLAN ACTUAL NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->compareRenovacionesByPlanActualSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 6:{// CASO 6: PLAZO ACTUAL NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->compareRenovacionesByPlazoActualSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 7:{// CASO 7: DN ACTUAL NO COINCIDE (id_tipo_diferencia = 1)
						if(!$comparativoVentasDAO->compareRenovacionesByDnActualSim($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
				}

			}//termina else

		}//Termina foreach
		$idLayout = $layout->getIdLayout();
		$lista = $diferenciaDAO->findAllDiferenciasDAO();
		$tipoDiferenciaDao = new TiposDiferenciasDAO();
		$tools = new ToolsComparativoVentas();
		foreach($lista as $diferencia){
			$renovacion = $renovacionesDAO->findRenovacionesDAO($diferencia->getIdRegistro());
			if($idLayout == $renovacion->getIdLayout()){
				$nameTipoDiferencia = $tipoDiferenciaDao->findTipoDiferencia($diferencia->getIdTipoDiferencia());
				$viewRenovacion = new ViewRenovaciones();
				$viewRenovacion->setIdOrdenRenovacion($renovacion->getIdOrdenRenovacion());
				$viewRenovacion->setNombrePdv($renovacion->getNombrePdv());
				$viewRenovacion->setFechaActivacionContrato($renovacion->getFechaActivacionContrato());
				$viewRenovacion->setNewSim($renovacion->getNewSim());
				$viewRenovacion->setNewImei($renovacion->getNewImei());
				$viewRenovacion->setPlanActual($renovacion->getPlanActual());
				$viewRenovacion->setPlazoActual($renovacion->getPlazoActual());
				$viewRenovacion->setDnActual($renovacion->getDnActual());
				$viewRenovacion->setTipoDiferencia($nameTipoDiferencia->getTipoDiferencia());
				array_push($arrayIncidencias, $viewRenovacion);
			}
		}
		$fileName = $uploadFolder . "/" ."Renovaciones layout_$idLayout " . date("Y-m-d") . ".csv";
		$respuesta = $tools->createReportCsv($fileName ,$layout, $arrayIncidencias);
		if($respuesta){
			echo '<br>---> <a href="'. $fileName .'">DESCARGAR REPORTE</a> <---<br>';

		}else{
			echo "<br>ALGO SALIO MAL AL GENERAR EL REPORTE";
		}



	 }

}
?>