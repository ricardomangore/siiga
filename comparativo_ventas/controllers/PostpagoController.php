<?php
include_once("comparativo_ventas/includes/Validator.php");
include_once("comparativo_ventas/dao/PostPagoDAO.php");
include_once("comparativo_ventas/dao/ComparativoVentasDAO.php");
include_once("comparativo_ventas/dao/DiferenciasDAO.php");
include_once("comparativo_ventas/dao/TiposDiferenciasDAO.php");
include_once("comparativo_ventas/pojos/Diferencias.php");
include_once("comparativo_ventas/includes/ToolsComparativoVentas.php");
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
			if($comparativoVentasDAO->comparePostPagoByFolio($postPago)){//SI ENCUENTRA EL FOLIO
				if($postPago->getImei() !=''){//SI EL OBJETO TIENE IMEI
					if(!$comparativoVentasDAO->comparePostPagoByImei($postPago)){//IMEI NO ECONTRADO EN SIIGA
						$diferencia->setIdRegistro($postPago->getIdRegistro());
						$diferencia->setIdTipoDiferencia(7);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);
					}
				}else{//USA LA SIM CUANDO EL IMEI ES VACIO
					if(!$comparativoVentasDAO->comparePostPagoBySim($postPago)){// SIM NO ENCONTRADA EN SIIGA
						$diferencia->setIdRegistro($postPago->getIdRegistro());
						$diferencia->setIdTipoDiferencia(6);
						$diferenciaDAO->saveDiferenciasDAO($diferencia);				
					}
				}
				switch ($case){
					case 1:{//CASO 1: TIPO DE VENTA NO COINCIDE (id_tipo_diferencia = 1)
						if(!$comparativoVentasDAO->comparePostPagoByTipoVenta($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(1);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 2:{//CASO 2: NOMBRE PDV NO COINCIDE (id_tipo_diferecnia = 2)
						if(!$comparativoVentasDAO->comparePostPagoByNombrePDV($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(2);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 3:{//CASO 3: NOMBRE EJECUTIVO UNICO NO COINCIDE (id_tipo_diferencia = 3)
						if(!$comparativoVentasDAO->comparePostPagoByNombreEjecutivo($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(3);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 4:{//CASO 4: FECHA ACTIVACION NO COINCIDE (id_tipo_diferencia = 4)

					}
					case 5:{//CASO 5: MDN NO COINCIDE (id_tipo_diferencia = 5)
						if(!$comparativoVentasDAO->comparePostPagoByDN($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(5);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 6:{//CASO 6: SIM NO COINCIDE (id_tipo_diferencia = 6)

					}
					case 7:{//CASO 7: MODELO EQUIPO NO COINCIDE (id_tipo_diferencia = 8)
						if(!$comparativoVentasDAO->comparePostPagoByModeloEquipo($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(8);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 8:{//CASO 8: PLAN TARIFARIO NO COINCIDE (id_tipo_diferencia = 9)
						if(!$comparativoVentasDAO->comparePostPagoByPlan($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(9);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}
					case 9:{//CASO 9: PLAZO FORZOSO NO COINCIDE (id_tipo_diferencia = 10)
						if(!$comparativoVentasDAO->comparePostPagoByPlazoForzoso($postPago)){
							$diferencia->setIdRegistro($postPago->getIdRegistro());
							$diferencia->setIdTipoDiferencia(10);
							$diferenciaDAO->saveDiferenciasDAO($diferencia);
						}
					}

				}//Termina SWITCH

			}else{//FOLIO NO ENCONTRADO EN SIIGA
				$diferencia->setIdRegistro($postPago->getIdRegistro());
				$diferencia->setIdTipoDiferencia(11);
				$diferenciaDAO->saveDiferenciasDAO($diferencia);
			}


		}

		$idlayout = $layout->getIdLayout();
		$tools = new ToolsComparativoVentas();
		$listaIncidentes = $comparativoVentasDAO->getListPostPagoIncidents($idlayout);
		if($listaIncidentes != NULL){			
			$arrayIncidencias = $listaIncidentes;
			$titles = array(
				'Id_Registro', 'Id_Layout', 'Folio', 'No_Contrato_Impreso', 'Id_Orden_Contratacion', 'Nombre_Cliente',
				'Tipo_Venta', 'Nombre_Ejecutivo_Unico', 'Sim', 'Imei', 'Plazo_Forzoso', 'Id_Tipo_Diferencia', 'Tipo_Diferencia'
			);
			$fileName = $uploadFolder . "/" ."PostPago layout_$idlayout " . date("Y-m-d") . ".csv";
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
		
	}


}

?>
