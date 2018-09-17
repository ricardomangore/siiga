<?php
include_once("comparativo_ventas/includes/ValidatorTransfer.php");
include_once("comparativo_ventas/pojos/Diferencias.php");
include_once("comparativo_ventas/dao/TransferDAO.php");
include_once("comparativo_ventas/dao/DiferenciasDAO.php");
include_once("comparativo_ventas/dao/ComparativoVentasDAO.php");

/**
 * 
 */
class TransferController
{
	
	function __construct(){

	}

	public function processTransfer($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValores = NULL;
		$validator = new ValidatorTransfer();
		try{
			if($validator->headerTransferValidator($fileName)){
				$layoutRegistered = $validator->getNewLayoutRegister($userID);
				//var_dump($layoutRegistered);

				$messageReturned = $validator->newTransferRegister($fileName, $layoutRegistered);

				$returnValores = $messageReturned;
				$this->compareTransfer($layoutRegistered, $uploadFolder);
			}else{
				$returnValores = "Alguna validacion no fue satisfactoria";
			}
		}catch(Exception $e){
			$returnValores = $e->getMessage();
		}
		return $returnValores;
	}


	public function compareTransfer($layout, $uploadFolder){
		$arrayIncidencias = array();
		$transferDAO = new TransferDAO();
		$comparativoVentasDAO = new ComparativoVentasDAO();
		$diferenciaDAO = new DiferenciasDAO();
		$diferencia = new Diferencias();
		$transferList = $transferDAO->findTransferByIdLayoutDAO($layout->getIdLayout());
		//var_dump($postPagoList);
		$case = 1;
		foreach($transferList as $transfer){
			if($comparativoVentasDAO->compareTransferByOrdenRenovacion($transfer)){
				if($transfer->getNewImei() != ""){// EJECUTA CUANDO NEW_IMEI NO ES VACIO
					if(!$comparativoVentasDAO->compareTransferByImei($transfer)){//IMEI NO ENCONTRADO EN SIIGA
						$diferencia->setIdRegistro($transfer->getIdRegistro());
						$diferencia->setIdTipoDiferencia(7);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);
					}
				}else{// USA NEW_SIM CUANDO NEW_IMEI ES VACIO
					if(!$comparativoVentasDAO->compareTransferBySim($transfer)){
						$diferencia->setIdRegistro($transfer->getIdRegistro());
						$diferencia->setIdTipoDiferencia(6);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);
					}
				}
				switch($case){
					case 1:{// CASO 1: NOMBRE PDV NO COINCIDE (id_tipo_diferencia = 2)
						if(!$comparativoVentasDAO->compareTransferByNombrePdv($transfer)){
							$diferencia->setIdRegistro($transfer->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 2:{// CASO 2: FECHA ACTIVACION CONTRATO NO COINCIDE (id_tipo_diferencia = 4)
						if(!$comparativoVentasDAO->compareTransferByFechaActivacion($transfer)){
							$diferencia->setIdRegistro($transfer->getIdRegistro());
							$diferencia->setIdTipoDiferencia(4);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{// CASO 3: PLAN ACTUAL NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->compareTransferByPlan($transfer)){
							$diferencia->setIdRegistro($transfer->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 4:{// CASO 4: PLAZO ACTUAL NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->compareTransferByPlazo($transfer)){
							$diferencia->setIdRegistro($transfer->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 5:{// CASO 5: DN ACTUAL NO COINCIDE (id_tipo_diferencia = 1)->caso 1 por no existir su diferencia
						if(!$comparativoVentasDAO->compareTransferByDn($transfer)){
							$diferencia->setIdRegistro($transfer->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
				}//Termina SWITCH

			}else{//FOLIO NO ENCONTRADO EN SIIGA
				$diferencia->setIdRegistro($transfer->getIdRegistro());
				$diferencia->setIdTipoDiferencia(11);
				$diferenciaDAO->saveDiferenciasDAO($diferencia);
			}
		}//Termina FOREACH
		$idlayout = $layout->getIdLayout();
		$tools = new ToolsComparativoVentas();
		$listaIncidentes = $comparativoVentasDAO->getListTransferIncidents($idlayout);
		if($listaIncidentes != NULL){			
			$arrayIncidencias = $listaIncidentes;
			$titles = array(
				'Id_Orden_Renovacion', 'Nombre_Pdv', 'Fecha_Activacion_Contrato', 'New_Sim', 'New_Imei', 'Plan_Actual',
				'Plazo_Actual', 'Dn_Actual', 'Tipo_Diferencia'
			);
			$fileName = $uploadFolder . "/" ."Transfer layout_$idlayout " . date("Y-m-d") . ".csv";
			$respuesta = $tools->createReportCsv($fileName ,$layout, $arrayIncidencias, $titles);
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




	}//Termina metodo compareTransfer



}
?>
