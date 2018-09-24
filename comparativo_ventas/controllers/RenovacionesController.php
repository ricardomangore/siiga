<?php
include_once("comparativo_ventas/includes/ValidatorRenovaciones.php");
include_once("comparativo_ventas/dao/RenovacionesDAO.php");
include_once("comparativo_ventas/dao/ComparativoVentasDAO.php");
include_once("comparativo_ventas/dao/TiposDiferenciasDAO.php");
include_once("comparativo_ventas/pojos/Diferencias.php");
include_once("comparativo_ventas/pojos/ViewRenovaciones.php");
include_once("comparativo_ventas/includes/ToolsComparativoVentas.php");
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

	/**
	 * method: compareRenovaciones()
	 * description: Compare different incident case and insert a record in the tw_diferencias table. Run the method 
	 * to create a new csv file with information of all records in tw_diferencias table.
	 * @param: <Object, string> Layout
	 * @return: <string>
	 */
	 public function compareRenovaciones($layout, $uploadFolder){
		$arrayIncidencias = array();
		$renovacionesDAO = new RenovacionesDAO();
		$comparativoVentasDAO = new ComparativoVentasDAO();
		$diferenciaDAO = new DiferenciasDAO();
		$diferencia = new Diferencias();

		$renovacionesList = $renovacionesDAO->findRenovacionesByIdLayout($layout->getIdLayout());
	
		$case = 1;	
		foreach($renovacionesList as $renovacion){
			if($comparativoVentasDAO->compareRenovacionesByOrdenRenovacion($renovacion)){
				if($renovacion->getNewImei() != ""){// SE EJECUTA CUANDO EL IMEI NO ES VACIO/
					if(!$comparativoVentasDAO->compareRenovacionesByNewImei($renovacion)){//IMEI NO COINCIDE EN SIIGA
						$diferencia->setIdRegistro($renovacion->getIdRegistro());
						$diferencia->setIdTipoDiferencia(7);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);
					}
				}else{// USA SIM CUANDO EL IMEI ES VACIO
					if(!$comparativoVentasDAO->compareRenovacionesByNewSim($renovacion)){
						$diferencia->setIdRegistro($renovacion->getIdRegistro());
						$diferencia->setIdTipoDiferencia(6);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);						
					}
	
				}

				switch ($case){
					case 1:{// CASO 1: NOMBRE PDV NO COINCIDE ($id_tipo_diferencia = 2)
						if(!$comparativoVentasDAO->compareRenovacionesByNombrePDV($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 2:{// CASO 2: FECHA ACTIVACION CONTRATO NO COINCIDE (id_tipo_diferencia = 4)
						if(!$comparativoVentasDAO->compareRenovacionesByFechaActivacionContrato($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(4);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{// CASO 3: PLAN ACTUAL NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->compareRenovacionesByPlanActual($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 4:{// CASO 4: PLAZO ACTUAL NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->compareRenovacionesByPlazoActual($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}						
					}
					case 5:{// CASO 5 : DN ACTUAL NO COINCIDE (id_tipo_diferencia = 1)->caso 1 por no existir su diferencia
						if(!$comparativoVentasDAO->compareRenovacionesByDnActual($renovacion)){
							$diferencia->setIdRegistro($renovacion->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}							
					}
				}//Termina SWITCH

			}else{//FOLIO NO ENCONTRADO EN SIIGA
				$diferencia->setIdRegistro($renovacion->getIdRegistro());
				$diferencia->setIdTipoDiferencia(11);
				$diferenciaDAO->saveDiferenciasDAO($diferencia);
			}

		}//Termina foreach
		$idlayout = $layout->getIdLayout();
		$tools = new ToolsComparativoVentas();
		$listaIncidentes = $comparativoVentasDAO->getListRenovacionesIncidents($idlayout);
		if($listaIncidentes != NULL){			
			$arrayIncidencias = $listaIncidentes;
			$titles = array(
				'Id_Orden_Renovacion','Nombre_Pdv', 'Fecha_Activacion_Contrato', 'New_Sim', 'New_Imei', 'Plan_Actual',
				'Plazo_Actual', 'Dn_Actual', 'Tipo_Diferencia'
			);
			$fileName = $uploadFolder . "/" ."Renovaciones layout_$idlayout " . date("Y-m-d") . ".csv";
			$respuesta = $tools->createReportCsv($fileName , $layout, $arrayIncidencias, $titles);
			if($respuesta){
				echo '
					<br><center><table><tr><td align="center"><a href="#"><img src="img/Otros/Reportes.png"><br>Click View</a></td>
					<td><div style="width: 50px"></td>
					<td colspan="2" align="center"><a href="'. $fileName .'"><img src="img/Otros/Lista.png"><br>Descargar csv</a></td>
					<td><div style="width: 50px"></td>
					<td align="center"><a href="#"><img src="img/Fuentes/1348167888_app_48.png"><br>Cargar en Siiga</a></td></tr></table></center><br>
					<br><br><br>
					<center><a href="#" onclick="location.reload()"><img src="img/Siguiente.png"></a></center><br><br><br>
					';
				}else{
					echo "<br>ALGO SALIO MAL AL GENERAR EL REPORTE";
			}
		}else{//Termina IF
			echo "No se pudo completar la consulta de los incidentes<br>";
		}



	 }

}
?>
