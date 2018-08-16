<?php
require_once('/../includes/Connect.php');
require_once('/../pojos/Renovaciones.php');

class RenovacionesDAO extends Connect{

	public function saveRenovacion($renovacionObj){
		if(isset($renovacionObj) && is_a($renovacionObj,'Renovaciones')){
			var_dump($renovacionObj);
			$id_layout = $renovacionObj->getIdLayout();
			$folio = $renovacionObj->getFolio();
			$no_contrato_impreso = $renovacionObj->getNoContratoImpreso();
			$subcategoria = $renovacionObj->getSubcategoria();
			$incidente = $renovacionObj->getIncidente();
			$id_orden_renovacion = $renovacionObj->getIdOrdenRenovacion();
			$cuenta_cliente = $renovacionObj->getCuentaCliente();
			$fecha_alta_inc = $renovacionObj->getFechaAltaInc();
			$fecha_firma = $renovacionObj->getFecha_Firma();
			$fecha_captura = $renovacionObj->getFechaCaptura();
			$status_renovacion = $renovacionObj->getStatusRenovacion();
			$fecha_status = $renovacionObj->getFechaStatus();
			$id_ejecutivo = $renovacionObj->getIdEjecutivo();
			$nombre_ejecutivo = $renovacionObj->getNombreEjecutivo();
			$puesto_ejecutivo = $renovacionObj->getPuestoEjecutivo();
			$nombre_pdv = $renovacionObj->getNombrePdv();
			$clave_pdv = $renovacionObj->getClavePdv();
			$canal = $renovacionObj->getCanal();
			$empresa = $renovacionObj->getEmpresa();
			$co_id = $renovacionObj->getCoId();
			$fecha_activacion_contrato = $renovacionObj->getFechaActivacionContrato();
			$new_sim = $renovacionObj->getNewSim();
			$new_imei = $renovacionObj->getNewImei();
			$new_num_serie = $renovacionObj->getNewNumSerie();
			$modelo_nuevo = $renovacionObj->getModeloNuevo();
			$color_nuevo = $renovacionObj->getColorNuevo();
			$sku = $renovacionObj->getSku();
			$plan_inicial = $renovacionObj->getPlanInicial();
			$renta_inicial = $renovacionObj->getRentaInicial();
			$plazo_anterior = $renovacionObj->getPlazoAnterior();
			$sim_anterior = $renovacionObj->getSimAnterior();
			$imei_anterior = $renovacionObj->getImeiAnterior();
			$serie_anterior = $renovacionObj->getSerieAnterior();
			$modelo_anterior = $renovacionObj->getModeloAnterior();
			$color_anterior = $renovacionObj->getColorAnterior();
			$sku_anterior = $renovacionObj->getSkuAnterior();
			$fecha_reemplazo = $renovacionObj->getFechaReemplazo();
			$plan_actual = $renovacionObj->getPlanActual();
			$renta_actual = $renovacionObj->getRentaActual();
			$plazo_actual = $renovacionObj->getPlazoActual();
			$importe_facturado = $renovacionObj->getImporteFacturado();
			$dn_actual = $renovacionObj->getDnActual();
			$desc_area_serv = $renovacionObj->getDescAreaServ();
			$tecnologia = $renovacionObj->getTecnologia();
			$subinventario = $renovacionObj->getSubinventario();
			$usuario_cci_inicial = $renovacionObj->getUsuarioCciInicial();
			$usuario_cci_renoco = $renovacionObj->getUsuarioCciRenoco();
			$departamento = $renovacionObj->getDepartamento();
			$nombre_contacto = $renovacionObj->getNombreContacto();
			$region = $renovacionObj->getRegion();
			$subregion = $renovacionObj->getSubregion();
			$estado = $renovacionObj->getEstado();
			$ciudad_comercial = $renovacionObj->getCiudadComercial();
			$mercado = $renovacionObj->getMercado();
			$direccion_vta = $renovacionObj->getDireccionVta();
			$canal_vta = $renovacionObj->getCanalVta();
			$cve_unica = $renovacionObj->getCveUnica();
			$num_coordinador = $renovacionObj->getNumCoordinador();
			$coordinador = $renovacionObj->getCoordinador();
			$num_gerente = $renovacionObj->getNumGerente();
			$gerente = $renovacionObj->getGerente();
			$operado_por = $renovacionObj->getOperadoPor();
			$master_pdv = $renovacionObj->getMasterPdv();
			$id_deudor = $renovacionObj->getIdDeudor();
			$vp = $renovacionObj->getVp();
			$agrupacion_canal = $renovacionObj->getAgrupacionCanal();
			$kam = $renovacionObj->getKam();
			$kam_correo = $renovacionObj->getKamCorreo();
			$tipo_cliente = $renovacionObj->getTipoCliente();
			$es_control = $renovacionObj->getEsControl();
			$renta_serv_control = $renovacionObj->getRentaServControl();
			$access_fee = $renovacionObj->getAccessFee();
			$access_fee_sin_ctrl = $renovacionObj->getAcceessFeeSinCtrl();
			$access_fee_serv_control = $renovacionObj->getAccessFeeServControl();
			$status_tenure = $renovacionObj->getStatusTenure();
			$tipo_movimiento = $renovacionObj->getTipoMovimiento();

			$sqlStr = 'INSERT INTO tw_renovaciones (id_layout,folio,no_contrato_impreso,subcategoria,incidente,id_orden_renovacion,cuenta_cliente,fecha_alta_inc,fecha_firma,fecha_captura,status_renovacion,fecha_status,id_ejecutivo,nombre_ejecutivo,puesto_ejecutivo,nombre_pdv,clave_pdv,canal,empresa,co_id,fecha_activacion_contrato,new_sim,new_imei,new_num_serie,modelo_nuevo,color_nuevo,sku,plan_inicial,renta_inicial,plazo_anterior,sim_anterior,imei_anterior,serie_anterior,modelo_anterior,color_anterior,sku_anterior,fecha_reemplazo,plan_actual,renta_actual,plazo_actual,importe_facturado,dn_actual,desc_area_serv,tecnologia,subinventario,usuario_cci_inicial,usuario_cci_renoco,departamento,nombre_contacto,region,subregion,estado,ciudad_comercial,mercado,direccion_vta,canal_vta,cve_unica,num_coordinador,coordinador,num_gerente,gerente,operado_por,master_pdv,id_deudor,vp,agrupacion_canal,kam,kam_correo,tipo_cliente,es_control,renta_serv_control,access_fee,access_fee_sin_ctrl,access_fee_serv_control,status_tenure,tipo_movimiento) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';

			if($prepare=$this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",$id_layout,$folio,$no_contrato_impreso,$subcategoria,$incidente,$id_orden_renovacion,$cuenta_cliente,$fecha_alta_inc,$fecha_firma,$fecha_captura,$status_renovacion,$fecha_status,$id_ejecutivo,$nombre_ejecutivo,$puesto_ejecutivo,$nombre_pdv,$clave_pdv,$canal,$empresa,$co_id,$fecha_activacion_contrato,$new_sim,$new_imei,$new_num_serie,$modelo_nuevo,$color_nuevo,$sku,$plan_inicial,$renta_inicial,$plazo_anterior,$sim_anterior,$imei_anterior,$serie_anterior,$modelo_anterior,$color_anterior,$sku_anterior,$fecha_reemplazo,$plan_actual,$renta_actual,$plazo_actual,$importe_facturado,$dn_actual,$desc_area_serv,$tecnologia,$subinventario,$usuario_cci_inicial,$usuario_cci_renoco,$departamento,$nombre_contacto,$region,$subregion,$estado,$ciudad_comercial,$mercado,$direccion_vta,$canal_vta,$cve_unica,$num_coordinador,$coordinador,$num_gerente,$gerente,$operado_por,$master_pdv,$id_deudor,$vp,$agrupacion_canal,$kam,$kam_correo,$tipo_cliente,$es_control,$renta_serv_control,$access_fee,$access_fee_sin_ctrl,$access_fee_serv_control,$status_tenure,$tipo_movimiento);
				$prepare->execute();
				$renovacionObj->setIdRegistro($this->getLink()->insert_id);
				$prepare->close();
				mysqli_close($this->getLink());
				$returnValue = $renovacionObj;
			}else{
				throw new Exceptoin('No se puedo preparar la consulta');
			}	
		}//Temina la validación del objeto $renovacionesObj
		return $renovacionObj;
	}

}

/**

$id_registro;
$id_layout;
$folio;
$no_contrato_impreso;
$subcategoria;
$incidente;
$id_orden_renovacion;
$cuenta_cliente;
$fecha_alta_inc;
$fecha_firma;
$fecha_captura;
$status_renovacion;
$fecha_status;
$id_ejecutivo;
$nombre_ejecutivo;
$puesto_ejecutivo;
$nombre_pdv;
$clave_pdv;
$canal;
$empresa;
$co_id;
$fecha_activacion_contrato;
$new_sim;
$new_imei;
$new_num_serie;
$modelo_nuevo;
$color_nuevo;
$sku;
$plan_inicial;
$renta_inicial;
$plazo_anterior;
$sim_anterior;
$imei_anterior;
$serie_anterior;
$modelo_anterior;
$color_anterior;
$sku_anterior;
$fecha_reemplazo;
$plan_actual;
$renta_actual;
$plazo_actual;
$importe_facturado;
$dn_actual;
$desc_area_serv;
$tecnologia;
$subinventario;
$usuario_cci_inicial;
$usuario_cci_renoco;
$departamento;
$nombre_contacto;
$region;
$subregion;
$estado;
$ciudad_comercial;
$mercado;
$direccion_vta;
$canal_vta;
$cve_unica;
$num_coordinador;
$coordinador;
$num_gerente;
$gerente;
$operado_por;
$master_pdv;
$id_deudor;
$vp;
$agrupacion_canal;
$kam;
$kam_correo;
$tipo_cliente;
$es_control;
$renta_serv_control;
$access_fee;
$access_fee_sin_ctrl;
$access_fee_serv_control;
$status_tenure;
$tipo_movimiento;


*/




?>