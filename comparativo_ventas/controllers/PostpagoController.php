<?php
include_once ("siiga/comparativo_ventas/includes/Validator.php");
include_once("siiga/comparativo_ventas/dao/PostPagoDAO.php");
include_once("siiga/comparativo_ventas/dao/ComparativoVentasDAO.php");
include_once("siiga/comparativo_ventas/dao/DiferenciasDAO.php");
include_once("siiga/comparativo_ventas/dao/TiposDiferenciasDAO.php");
include_once("siiga/comparativo_ventas/pojos/Diferencias.php");
include_once("siiga/comparativo_ventas/pojos/ViewPostPago.php");
include_once("siiga/comparativo_ventas/includes/ToolsComparativoVentas.php");
/**
 * 
 */
class PostpagoController
{
	
	function __construct()
	{
	}



	/**
	 * method: processPostPago()
	 * description: This method is responsible for processing(execute) all validation of postpago
	 * @param: <string,int,int,string,string,string>
	 * @return: <string>
	 */
	public function processPostPago($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValue = NULL;
		$validator = new Validator();
		try{
			if($validator->headerPostPagoValidator($fileName)){
				$newRegisterLayout = $validator->getNewLayoutRegister($userID);
				//var_dump($newRegisterLayout);

				$MessajeReturn = $validator->getNewPostPagoRegister($fileName, $newRegisterLayout);

				$returnValue = $MessajeReturn;
				$this->comparePostPago($newRegisterLayout, $uploadFolder);
			}else{
				$returnValue = "Alguna validacion no fue satisfctoria";
			}
		}catch(Exception $e){
			$returnValue = $e->getMessage();
		}
		return $returnValue;
	}



	/**
	 * method: comparePostPago()
	 * description: Compare different incident case and insert a record in the tw_diferencias table. Run the method 
	 * to create a new csv file with information of all records in tw_diferencias table.
	 * @param: <Object, string> Layout
	 * @return: <string>
	 */
	public function comparePostPago($layout, $uploadFolder){
		$arrayIncidencias = array();
		$postPagoDAO = new PostPagoDAO();
		$comparativoVentasDAO = new ComparativoVentasDAO();
		$diferenciaDAO = new DiferenciasDAO();
		$diferencia = new Diferencias();
		$postPagoList = $postPagoDAO->findPostPagoDAOByIdLayout($layout->getIdLayout());
		//var_dump($postPagoList);
		$case = 1;
		foreach($postPagoList as $postPago){
			if($postPago->getImei() !=''){//Ejecuta cuando IMEI no es vacio
				switch($case){
					case 1:{//CASO 1: TIPO DE VENTA NO COINCIDE (id_tipo_diferencia = 1)
						if(!$comparativoVentasDAO->comparePostPagoByTipoVenta($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}

					}
					case 2: {//CASO 2: NOMBRE DEL PDV NO COINCIDE (id_tipo_diferencia = 2)
						if(!$comparativoVentasDAO->comparePostPagoByNombrePDV($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{//CASO 3: NOMBRE EJECUTIVO UNICO NO COINCIDE (id_tipo_diferencia = 3)
						if(!$comparativoVentasDAO->comparePostPagoByNombreEjecutivo($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(3);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 4:{//CASO 4: FECHA ACTIVACION NO COINCIDE (id_tipo_diferencia = 4)
						if(!$comparativoVentasDAO->comparePostPagoByFechaActivacion($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(4);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 5:{//CASO 5: MDN NO COINCIDE (id_tipo_diferencia = 5)
						if(!$comparativoVentasDAO->comparePostPagoByDN($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(5);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 6:{//CASO 6: SIM NO COINCIDE (id_tipo_diferencia = 6)

					}
					case 7:{//CASO 7: IMEI NO COINCIDE (id_tipo_diferencia = 7)

					}
					case 8:{//CASO 8: MODELO EQUIPO NO COINCIDE (id_tipo_diferencia = 8)
						if(!$comparativoVentasDAO->comparePostPagoByModeloEquipo($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(8);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 9:{//CASO 9: PLAN TARIFARIO NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->comparePostPagoByPlan($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 10:{//CASO 10: PLAN FORZOSO NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->comparePostPagoByPlazoForzoso($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);//Tomado del caso que coincide con id_tipo_diferencia
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
				}

			}else{//USA LA SIM CUANDO EL IMEI ES VACIO
				switch ($case){
					case 1:{//CASO 1: TIPO DE VENTA NO COINCIDE (id_tipo_diferencia = 1)
						if(!$comparativoVentasDAO->comparePostPagoByTipoVentaSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 2:{//CASO 2: NOMBRE PDV NO COINCIDE (id_tipo_diferecnia = 2)
						if(!$comparativoVentasDAO->comparePostPagoByNombrePDVSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{//CASO 3: NOMBRE EJECUTIVO UNICO NO COINCIDE (id_tipo_diferencia = 3)
						if(!$comparativoVentasDAO->comparePostPagoByNombreEjecutivoSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(3);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 4:{//CASO 4: FECHA ACTIVACION NO COINCIDE (id_tipo_diferencia = 4)

					}
					case 5:{//CASO 5: MDN NO COINCIDE (id_tipo_diferencia = 5)
						if(!$comparativoVentasDAO->comparePostPagoByDNSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(5);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 6:{//CASO 6: SIM NO COINCIDE (id_tipo_diferencia = 6)

					}
					case 7:{//CASO 7: IMEI NO COINCIDE (id_tipo_diferencia = 7)

					}
					case 8:{//CASO 8: MODELO EQUIPO NO COINCIDE (id_tipo_diferencia = 8)
						if(!$comparativoVentasDAO->comparePostPagoByModeloEquipoSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(8);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 9:{//CASO 9: PLAN TARIFARIO NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->comparePostPagoByPlanSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 10:{//CASO 10: PLAZO FORZOSO NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->comparePostPagoByPlazoForzosoSim($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}

				}
			}
		}

		$idlayout = $layout->getIdLayout();
		$lista = $diferenciaDAO->findAllDiferenciasDAO();
		
		$tipoDiferencia = new TiposDiferenciasDAO();
		$tools = new ToolsComparativoVentas();
		//$titulos = ['ID_REGISTRO','ID_TIPO_DIFERENCIA'];
		foreach($lista as $diferencia){
			$posPagoData = $postPagoDAO->findPostPagoDAO($diferencia->getIdRegistro());
			if($idlayout == $posPagoData->getIdLayout()){
				$nameTipoDiferencia = $tipoDiferencia->findTipoDiferencia($diferencia->getIdTipoDiferencia());
				$viewPostPagoObj = new ViewPostPago();
				$viewPostPagoObj->setIdRegistro($posPagoData->getIdRegistro());
				$viewPostPagoObj->setIdLayout($posPagoData->getIdLayout());
				$viewPostPagoObj->setFolio($posPagoData->getFolio());
				$viewPostPagoObj->setNoContratoImpreso($posPagoData->getNoContatoImpreso());
				$viewPostPagoObj->setIdOrdenContratacion($posPagoData->getIdOrdenContratacion());
				$viewPostPagoObj->setNombreCliente($posPagoData->getNombreCliente());
				$viewPostPagoObj->setTipoVenta($posPagoData->getTipoVenta());
				$viewPostPagoObj->setNombreEjecutivoUnico($posPagoData->getNombreEjecutivoUnico());
				$viewPostPagoObj->setSim($posPagoData->getSim());
				$viewPostPagoObj->setImei($posPagoData->getImei());
				$viewPostPagoObj->setPlazoForzoso($posPagoData->getPlazoForzoso());
				$viewPostPagoObj->setIdTipoDiferencia($nameTipoDiferencia->getIdTipoDiferencia());
				$viewPostPagoObj->setTipoDiferencia($nameTipoDiferencia->getTipoDiferencia());
				array_push($arrayIncidencias, $viewPostPagoObj);
			}
		}
		$fileName = $uploadFolder . "/" ."PostPago layout_$idlayout " . date("Y-m-d") . ".csv";
		$respuesta = $tools->createReportCsv($fileName ,$layout, $arrayIncidencias);
		if($respuesta){
			echo '<br>---> <a href="'. $fileName .'">DESCARGAR REPORTE</a> <---<br>';

		}else{
			echo "<br>ALGO SALIO MAL AL GENERAR EL REPORTE";
		}

		
	}

}

?>