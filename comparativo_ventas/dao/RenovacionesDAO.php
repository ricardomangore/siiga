<?php
include_once('comparativo_ventas/includes/Connect.php');
include_once('comparativo_ventas/pojos/Renovaciones.php');

class RenovacionesDAO extends Connect{

	public function saveRenovacion($renovacionObj){
		if(isset($renovacionObj) && is_a($renovacionObj,'Renovaciones')){
			//var_dump($renovacionObj);
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
				//mysqli_close($this->getLink());
				$returnValue = $renovacionObj;
			}else{
				throw new Exception('No se puede preparar la consulta');
			}	
		}//Temina la validación del objeto $renovacionesObj
		return $renovacionObj;
	}

	public function findRenovacionesDAO($idRenovacion){
		$returnValue = NULL;
		if(isset($idRenovacion)){
			$sqlStr = "SELECT * FROM tw_renovaciones WHERE id_registro=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("s", $idRenovacion);
				$prepare->execute();
				$prepare->bind_result($id_registro, $id_layout,$folio,$no_contrato_impreso,$subcategoria,$incidente,$id_orden_renovacion,$cuenta_cliente,$fecha_alta_inc,$fecha_firma,$fecha_captura,$status_renovacion,$fecha_status,$id_ejecutivo,$nombre_ejecutivo,$puesto_ejecutivo,$nombre_pdv,$clave_pdv,$canal,$empresa,$co_id,$fecha_activacion_contrato,$new_sim,$new_imei,$new_num_serie,$modelo_nuevo,$color_nuevo,$sku,$plan_inicial,$renta_inicial,$plazo_anterior,$sim_anterior,$imei_anterior,$serie_anterior,$modelo_anterior,$color_anterior,$sku_anterior,$fecha_reemplazo,$plan_actual,$renta_actual,$plazo_actual,$importe_facturado,$dn_actual,$desc_area_serv,$tecnologia,$subinventario,$usuario_cci_inicial,$usuario_cci_renoco,$departamento,$nombre_contacto,$region,$subregion,$estado,$ciudad_comercial,$mercado,$direccion_vta,$canal_vta,$cve_unica,$num_coordinador,$coordinador,$num_gerente,$gerente,$operado_por,$master_pdv,$id_deudor,$vp,$agrupacion_canal,$kam,$kam_correo,$tipo_cliente,$es_control,$renta_serv_control,$access_fee,$access_fee_sin_ctrl,$access_fee_serv_control,$status_tenure,$tipo_movimiento);
				$prepare->fetch();
				$renovacionObj = new Renovaciones();
				$renovacionObj->setIdRegistro($id_registro);
				$renovacionObj->setIdLayout($id_layout);
				$renovacionObj->setFolio($folio);
				$renovacionObj->setNoContratoImpreso($no_contrato_impreso);
				$renovacionObj->setSubcategoria($subcategoria);
				$renovacionObj->setIncidente($incidente);
				$renovacionObj->setIdOrdenRenovacion($id_orden_renovacion);
				$renovacionObj->setCuentaCliente($cuenta_cliente);
				$renovacionObj->setFechaAltaInc($fecha_alta_inc);
				$renovacionObj->setFecha_Firma($fecha_firma);
				$renovacionObj->setFechaCaptura($fecha_captura);
				$renovacionObj->setStatusRenovacion($status_renovacion);
				$renovacionObj->setFechaStatus($fecha_status);
				$renovacionObj->setIdEjecutivo($id_ejecutivo);
				$renovacionObj->setNombreEjecutivo($nombre_ejecutivo);
				$renovacionObj->setPuestoEjecutivo($puesto_ejecutivo);
				$renovacionObj->setNombrePdv($nombre_pdv);
				$renovacionObj->setClavePdv($clave_pdv);
				$renovacionObj->setCanal($canal);
				$renovacionObj->setEmpresa($empresa);
				$renovacionObj->setCoId($co_id);
				$renovacionObj->setFechaActivacionContrato($fecha_activacion_contrato);
				$renovacionObj->setNewSim($new_sim);
				$renovacionObj->setNewImei($new_imei);
				$renovacionObj->setNewNumSerie($new_num_serie);
				$renovacionObj->setModeloNuevo($modelo_nuevo);
				$renovacionObj->setColorNuevo($color_nuevo);
				$renovacionObj->setSku($sku);
				$renovacionObj->setPlanInicial($plan_inicial);
				$renovacionObj->setRentaInicial($renta_inicial);
				$renovacionObj->setPlazoAnterior($plazo_anterior);
				$renovacionObj->setSimAnterior($sim_anterior);
				$renovacionObj->setImeiAnterior($imei_anterior);
				$renovacionObj->setSerieAnterior($serie_anterior);
				$renovacionObj->setModeloAnterior($modelo_anterior);
				$renovacionObj->setColorAnterior($color_anterior);
				$renovacionObj->setSkuAnterior($sku_anterior);
				$renovacionObj->setFechaReemplazo($fecha_reemplazo);
				$renovacionObj->setPlanActual($plan_actual);
				$renovacionObj->setRentaActual($renta_actual);
				$renovacionObj->setPlazoActual($plazo_actual);
				$renovacionObj->setImporteFacturado($importe_facturado);
				$renovacionObj->setDnActual($dn_actual);
				$renovacionObj->setDescAreaServ($desc_area_serv);
				$renovacionObj->setTecnologia($tecnologia);
				$renovacionObj->setSubinventario($subinventario);
				$renovacionObj->setUsuarioCciInicial($usuario_cci_inicial);
				$renovacionObj->setUsuarioCciRenoco($usuario_cci_renoco);
				$renovacionObj->setDepartamento($departamento);
				$renovacionObj->setNombreContacto($nombre_contacto);
				$renovacionObj->setRegion($region);
				$renovacionObj->setSubregion($subregion);
				$renovacionObj->setEstado($estado);
				$renovacionObj->setCiudadComercial($ciudad_comercial);
				$renovacionObj->setMercado($mercado);
				$renovacionObj->setDireccionVta($direccion_vta);
				$renovacionObj->setCanalVta($canal_vta);
				$renovacionObj->setCveUnica($cve_unica);
				$renovacionObj->setNumCoordinador($num_coordinador);
				$renovacionObj->setCoordinador($coordinador);
				$renovacionObj->setNumGerente($num_gerente);
				$renovacionObj->setGerente($gerente);
				$renovacionObj->setOperadoPor($operado_por);
				$renovacionObj->setMasterPdv($master_pdv);
				$renovacionObj->setIdDeudor($id_deudor);
				$renovacionObj->setVp($vp);
				$renovacionObj->setAgrupacionCanal($agrupacion_canal);
				$renovacionObj->setKam($kam);
				$renovacionObj->setKamCorreo($kam_correo);
				$renovacionObj->setTipoCliente($tipo_cliente);
				$renovacionObj->setEsControl($es_control);
				$renovacionObj->setRentaServControl($renta_serv_control);
				$renovacionObj->setAccessFee($access_fee);
				$renovacionObj->setAcceessFeeSinCtrl($access_fee_sin_ctrl);
				$renovacionObj->setAccessFeeServControl($access_fee_serv_control);
				$renovacionObj->setStatusTenure($status_tenure);
				$renovacionObj->setTipoMovimiento($tipo_movimiento);
				$prepare->close();
				$returnValue = $renovacionObj;
			}
		}
		return $returnValue;

	}


	public function findRenovacionesByIdLayout($idLayout){
		$returnValue = NULL;
		$arraypostPago = array();
		$sqlStr = "SELECT * FROM tw_renovaciones WHERE id_layout=".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$renovacionObj = new Renovaciones();
				$renovacionObj->setIdRegistro($fila[0]);
				$renovacionObj->setIdLayout($fila[1]);
				$renovacionObj->setFolio($fila[2]);
				$renovacionObj->setNoContratoImpreso($fila[3]);
				$renovacionObj->setSubcategoria($fila[4]);
				$renovacionObj->setIncidente($fila[5]);
				$renovacionObj->setIdOrdenRenovacion($fila[6]);
				$renovacionObj->setCuentaCliente($fila[7]);
				$renovacionObj->setFechaAltaInc($fila[8]);
				$renovacionObj->setFecha_Firma($fila[9]);
				$renovacionObj->setFechaCaptura($fila[10]);
				$renovacionObj->setStatusRenovacion($fila[11]);
				$renovacionObj->setFechaStatus($fila[12]);
				$renovacionObj->setIdEjecutivo($fila[13]);
				$renovacionObj->setNombreEjecutivo($fila[14]);
				$renovacionObj->setPuestoEjecutivo($fila[15]);
				$renovacionObj->setNombrePdv($fila[16]);
				$renovacionObj->setClavePdv($fila[17]);
				$renovacionObj->setCanal($fila[18]);
				$renovacionObj->setEmpresa($fila[19]);
				$renovacionObj->setCoId($fila[20]);
				$renovacionObj->setFechaActivacionContrato($fila[21]);
				$renovacionObj->setNewSim($fila[22]);
				$renovacionObj->setNewImei($fila[23]);
				$renovacionObj->setNewNumSerie($fila[24]);
				$renovacionObj->setModeloNuevo($fila[25]);
				$renovacionObj->setColorNuevo($fila[26]);
				$renovacionObj->setSku($fila[27]);
				$renovacionObj->setPlanInicial($fila[28]);
				$renovacionObj->setRentaInicial($fila[29]);
				$renovacionObj->setPlazoAnterior($fila[30]);
				$renovacionObj->setSimAnterior($fila[31]);
				$renovacionObj->setImeiAnterior($fila[32]);
				$renovacionObj->setSerieAnterior($fila[33]);
				$renovacionObj->setModeloAnterior($fila[34]);
				$renovacionObj->setColorAnterior($fila[35]);
				$renovacionObj->setSkuAnterior($fila[36]);
				$renovacionObj->setFechaReemplazo($fila[37]);
				$renovacionObj->setPlanActual($fila[38]);
				$renovacionObj->setRentaActual($fila[39]);
				$renovacionObj->setPlazoActual($fila[40]);
				$renovacionObj->setImporteFacturado($fila[41]);
				$renovacionObj->setDnActual($fila[42]);
				$renovacionObj->setDescAreaServ($fila[43]);
				$renovacionObj->setTecnologia($fila[44]);
				$renovacionObj->setSubinventario($fila[45]);
				$renovacionObj->setUsuarioCciInicial($fila[46]);
				$renovacionObj->setUsuarioCciRenoco($fila[47]);
				$renovacionObj->setDepartamento($fila[48]);
				$renovacionObj->setNombreContacto($fila[49]);
				$renovacionObj->setRegion($fila[50]);
				$renovacionObj->setSubregion($fila[51]);
				$renovacionObj->setEstado($fila[52]);
				$renovacionObj->setCiudadComercial($fila[53]);
				$renovacionObj->setMercado($fila[54]);
				$renovacionObj->setDireccionVta($fila[55]);
				$renovacionObj->setCanalVta($fila[56]);
				$renovacionObj->setCveUnica($fila[57]);
				$renovacionObj->setNumCoordinador($fila[58]);
				$renovacionObj->setCoordinador($fila[59]);
				$renovacionObj->setNumGerente($fila[60]);
				$renovacionObj->setGerente($fila[61]);
				$renovacionObj->setOperadoPor($fila[62]);
				$renovacionObj->setMasterPdv($fila[63]);
				$renovacionObj->setIdDeudor($fila[64]);
				$renovacionObj->setVp($fila[65]);
				$renovacionObj->setAgrupacionCanal($fila[66]);
				$renovacionObj->setKam($fila[67]);
				$renovacionObj->setKamCorreo($fila[68]);
				$renovacionObj->setTipoCliente($fila[69]);
				$renovacionObj->setEsControl($fila[70]);
				$renovacionObj->setRentaServControl($fila[71]);
				$renovacionObj->setAccessFee($fila[72]);
				$renovacionObj->setAcceessFeeSinCtrl($fila[73]);
				$renovacionObj->setAccessFeeServControl($fila[74]);
				$renovacionObj->setStatusTenure($fila[75]);
				$renovacionObj->setTipoMovimiento($fila[76]);
				array_push($arraypostPago, $renovacionObj);
			}
			$returnValue = $arraypostPago;
		}
		return $returnValue;

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