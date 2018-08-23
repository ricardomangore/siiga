<?php
require_once ("comparativo_ventas/includes/Validator.php");
require_once("comparativo_ventas/dao/PostPagoDAO.php");
require_once("comparativo_ventas/dao/ComparativoVentasDAO.php");
require_once("comparativo_ventas/dao/DiferenciasDAO.php");
require_once("comparativo_ventas/pojos/Diferencias.php");
include_once("Comparativo_ventas/includes/ToolsComparativoVentas.php");
/**
 * 
 */
class PostpagoController
{
	
	function __construct()
	{
	}


	public function processPostPago($fileName, $userID, $datoID, $uploadFolder, $archiveType, $archiveSize){
		$returnValue = NULL;
		$validator = new Validator();
		try{
			if($validator->headerPostPagoValidator($fileName)){
				$newRegisterLayout = $validator->getNewLayoutRegister($userID);
				//var_dump($newRegisterLayout);

				$MessajeReturn = $validator->getNewPostPagoRegister($fileName, $newRegisterLayout);

				$returnValue = "<br>EXITO: operacion 100% exitosa" . "<br>" . $MessajeReturn;
				$this->comparePostPago($newRegisterLayout);
			}else{
				$returnValue = "Alguna validacion no fue satisfctoria";
			}
		}catch(Exception $e){
			$returnValue = $e->getMessage();
		}
		return $returnValue;
	}

	public function comparePostPago($layout){
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
				echo "PROCESO FINALIZADO CORRECTAMENTE";

			}else{//USA LA SIM cuando IMEI es vacio
				//pendiente
			}
		}
		/*EJEMPLO DE CREAR ARCHIVO CSV*/
		$lista = $diferenciaDAO->findAllDiferenciasDAO();
		$tools = new ToolsComparativoVentas();
		$titulos = ['ID_REGISTRO','ID_TIPO_DIFERENCIA'];
		$respuesta = $tools->createReportCsv("Diferencias" ,$layout, $lista, $titulos);
		echo "<br>$respuesta";
		/********************************/

	}
}

?>