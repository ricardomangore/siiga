<?php
 /**
  * 
  */
 class Transfer
 {
	private $id_registro;
	private $id_layout;
	private $folio;
	private $no_contrato_impreso;
	private $subcategoria;
	private $incidente;
	private $id_orden_renovacion;
	private $cuenta_cliente;
	private $fecha_alta_inc;
	private $fecha_firma;
	private $fecha_captura;
	private $status_renovacion;
	private $fecha_status;
	private $id_ejecutivo;
	private $nombre_ejecutivo;
	private $puesto_ejecutivo;
	private $nombre_pdv;
	private $clave_pdv;
	private $canal;
	private $empresa;
	private $co_id;
	private $fecha_activacion_contrato;
	private $new_sim;
	private $new_imei;
	private $new_num_serie;
	private $modelo_nuevo;
	private $color_nuevo;
	private $sku;
	private $plan_inicial;
	private $renta_inicial;
	private $plazo_anterior;
	private $sim_anterior;
	private $imei_anterior;
	private $serie_anterior;
	private $modelo_anterior;
	private $color_anterior;
	private $sku_anterior;
	private $fecha_reemplazo;
	private $plan_actual;
	private $renta_actual;
	private $plazo_actual;
	private $importe_facturado;
	private $dn_actual;
	private $desc_area_serv;
	private $tecnologia;
	private $subinventario;
	private $usuario_cci_inicial;
	private $usuario_cci_renoco;
	private $departamento;
	private $nombre_contacto;
	private $region;
	private $subregion;
	private $estado;
	private $ciudad_comercial;
	private $mercado;
	private $direccion_vta;
	private $canal_vta;
	private $cve_unica;
	private $num_coordinador;
	private $coordinador;
	private $num_gerente;
	private $gerente;
	private $operado_por;
	private $master_pdv;
	private $id_deudor;
	private $vp;
	private $agrupacion_canal;
	private $kam;
	private $kam_correo;
	private $tipo_cliente;
	private $es_control;
	private $renta_serv_control;
	private $access_fee;
	private $access_fee_sin_ctrl;
	private $access_fee_serv_control;
	private $status_tenure;
	private $tipo_movimiento;

 	function __construct(){

 	}

 	public function getIdRegistro()
 	{
 	    return $this->id_registro;
 	}
 	
 	public function setIdRegistro($id_registro)
 	{
 	    $this->id_registro = $id_registro;
 	}

 	public function getIdLayout()
 	{
 	    return $this->id_layout;
 	}
 	
 	public function setIdLayout($id_layout)
 	{
 	    $this->id_layout = $id_layout;
 	}

 	public function getFolio()
 	{
 	    return $this->folio;
 	}
 	
 	public function setFolio($folio)
 	{
 	    $this->folio = $folio;
 	}

 	public function getNoContratoImpreso()
 	{
 	    return $this->no_contrato_impreso;
 	}
 	
 	public function setNoContratoImpreso($no_contrato_impreso)
 	{
 	    $this->no_contrato_impreso = $no_contrato_impreso;
 	}

 	public function getSubcategoria()
 	{
 	    return $this->subcategoria;
 	}
 	
 	public function setSubcategoria($subcategoria)
 	{
 	    $this->subcategoria = $subcategoria;
 	}

 	public function getIncidente()
 	{
 	    return $this->incidente;
 	}
 	
 	public function setIncidente($incidente)
 	{
 	    $this->incidente = $incidente;
 	}

 	public function getIdOrdenRenovacion()
 	{
 	    return $this->id_orden_renovacion;
 	}
 	
 	public function setIdOrdenRenovacion($id_orden_renovacion)
 	{
 	    $this->id_orden_renovacion = $id_orden_renovacion;
 	}

 	public function getCuentaCliente()
 	{
 	    return $this->cuenta_cliente;
 	}
 	
 	public function setCuentaCliente($cuenta_cliente)
 	{
 	    $this->cuenta_cliente = $cuenta_cliente;
 	}

 	public function getFechaAltaInc()
 	{
 	    return $this->fecha_alta_inc;
 	}
 	
 	public function setFechaAltaInc($fecha_alta_inc)
 	{
 	    $this->fecha_alta_inc = $fecha_alta_inc;
 	}

 	public function getFechaFirma()
 	{
 	    return $this->fecha_firma;
 	}
 	
 	public function setFechaFirma($fecha_firma)
 	{
 	    $this->fecha_firma = $fecha_firma;
 	}

 	public function getFechaCaptura()
 	{
 	    return $this->fecha_captura;
 	}
 	
 	public function setFechaCaptura($fecha_captura)
 	{
 	    $this->fecha_captura = $fecha_captura;
 	}

 	public function getStatusRenovacion()
 	{
 	    return $this->status_renovacion;
 	}
 	
 	public function setStatusRenovacion($status_renovacion)
 	{
 	    $this->status_renovacion = $status_renovacion;
 	}

 	public function getFechaStatus()
 	{
 	    return $this->fecha_status;
 	}
 	
 	public function setFechaStatus($fecha_status)
 	{
 	    $this->fecha_status = $fecha_status;
 	}

 	public function getIdEjecutivo()
 	{
 	    return $this->id_ejecutivo;
 	}
 	
 	public function setIdEjecutivo($id_ejecutivo)
 	{
 	    $this->id_ejecutivo = $id_ejecutivo;
 	}

 	public function getNombreEjecutivo()
 	{
 	    return $this->nombre_ejecutivo;
 	}
 	
 	public function setNombreEjecutivo($nombre_ejecutivo)
 	{
 	    $this->nombre_ejecutivo = $nombre_ejecutivo;
 	}

 	public function getPuestoEjecutivo()
 	{
 	    return $this->puesto_ejecutivo;
 	}
 	
 	public function setPuestoEjecutivo($puesto_ejecutivo)
 	{
 	    $this->puesto_ejecutivo = $puesto_ejecutivo;
 	}

 	public function getNombrePdv()
 	{
 	    return $this->nombre_pdv;
 	}
 	
 	public function setNombrePdv($nombre_pdv)
 	{
 	    $this->nombre_pdv = $nombre_pdv;
 	}

 	public function getClavePdv()
 	{
 	    return $this->clave_pdv;
 	}
 	
 	public function setClavePdv($clave_pdv)
 	{
 	    $this->clave_pdv = $clave_pdv;
 	}

 	public function getCanal()
 	{
 	    return $this->canal;
 	}
 	
 	public function setCanal($canal)
 	{
 	    $this->canal = $canal;
 	}

 	public function getEmpresa()
 	{
 	    return $this->empresa;
 	}
 	
 	public function setEmpresa($empresa)
 	{
 	    $this->empresa = $empresa;
 	}

 	public function getCoId()
 	{
 	    return $this->co_id;
 	}
 	
 	public function setCoId($co_id)
 	{
 	    $this->co_id = $co_id;
 	}

 	public function getFechaActivacionContrato()
 	{
 	    return $this->fecha_activacion_contrato;
 	}
 	
 	public function setFechaActivacionContrato($fecha_activacion_contrato)
 	{
 	    $this->fecha_activacion_contrato = $fecha_activacion_contrato;
 	}

 	public function getNewSim()
 	{
 	    return $this->new_sim;
 	}
 	
 	public function setNewSim($new_sim)
 	{
 	    $this->new_sim = $new_sim;
 	}

 	public function getNewImei()
 	{
 	    return $this->new_imei;
 	}
 	
 	public function setNewImei($new_imei)
 	{
 	    $this->new_imei = $new_imei;
 	}

 	public function getNewNumSerie()
 	{
 	    return $this->new_num_serie;
 	}
 	
 	public function setNewNumSerie($new_num_serie)
 	{
 	    $this->new_num_serie = $new_num_serie;
 	}

 	public function getModeloNuevo()
 	{
 	    return $this->modelo_nuevo;
 	}
 	
 	public function setModeloNuevo($modelo_nuevo)
 	{
 	    $this->modelo_nuevo = $modelo_nuevo;
 	}

 	public function getColorNuevo()
 	{
 	    return $this->color_nuevo;
 	}
 	
 	public function setColorNuevo($color_nuevo)
 	{
 	    $this->color_nuevo = $color_nuevo;
 	}

 	public function getSku()
 	{
 	    return $this->sku;
 	}
 	
 	public function setSku($sku)
 	{
 	    $this->sku = $sku;
 	}

 	public function getPlanInicial()
 	{
 	    return $this->plan_inicial;
 	}
 	
 	public function setPlanInicial($plan_inicial)
 	{
 	    $this->plan_inicial = $plan_inicial;
 	}

 	public function getRentaInicial()
 	{
 	    return $this->renta_inicial;
 	}
 	
 	public function setRentaInicial($renta_inicial)
 	{
 	    $this->renta_inicial = $renta_inicial;
 	}

 	public function getPlazoAnterior()
 	{
 	    return $this->plazo_anterior;
 	}
 	
 	public function setPlazoAnterior($plazo_anterior)
 	{
 	    $this->plazo_anterior = $plazo_anterior;
 	}

 	public function getSimAnterior()
 	{
 	    return $this->sim_anterior;
 	}
 	
 	public function setSimAnterior($sim_anterior)
 	{
 	    $this->sim_anterior = $sim_anterior;
 	}

 	public function getImeiAnterior()
 	{
 	    return $this->imei_anterior;
 	}
 	
 	public function setImeiAnterior($imei_anterior)
 	{
 	    $this->imei_anterior = $imei_anterior;
 	}

 	public function getSerieAnterior()
 	{
 	    return $this->serie_anterior;
 	}
 	
 	public function setSerieAnterior($serie_anterior)
 	{
 	    $this->serie_anterior = $serie_anterior;
 	}

 	public function getModeloAnterior()
 	{
 	    return $this->modelo_anterior;
 	}
 	
 	public function setModeloAnterior($modelo_anterior)
 	{
 	    $this->modelo_anterior = $modelo_anterior;
 	}

 	public function getColorAnterior()
 	{
 	    return $this->color_anterior;
 	}
 	
 	public function setColorAnterior($color_anterior)
 	{
 	    $this->color_anterior = $color_anterior;
 	}

 	public function getSkuAnterior()
 	{
 	    return $this->sku_anterior;
 	}
 	
 	public function setSkuAnterior($sku_anterior)
 	{
 	    $this->sku_anterior = $sku_anterior;
 	}

 	public function getFechaReemplazo()
 	{
 	    return $this->fecha_reemplazo;
 	}
 	
 	public function setFechaReemplazo($fecha_reemplazo)
 	{
 	    $this->fecha_reemplazo = $fecha_reemplazo;
 	}

 	public function getPlanActual()
 	{
 	    return $this->plan_actual;
 	}
 	
 	public function setPlanActual($plan_actual)
 	{
 	    $this->plan_actual = $plan_actual;
 	}

 	public function getRentaActual()
 	{
 	    return $this->renta_actual;
 	}
 	
 	public function setRentaActual($renta_actual)
 	{
 	    $this->renta_actual = $renta_actual;
 	}

 	public function getPlazoActual()
 	{
 	    return $this->plazo_actual;
 	}
 	
 	public function setPlazoActual($plazo_actual)
 	{
 	    $this->plazo_actual = $plazo_actual;
 	}

 	public function getImporteFacturado()
 	{
 	    return $this->importe_facturado;
 	}
 	
 	public function setImporteFacturado($importe_facturado)
 	{
 	    $this->importe_facturado = $importe_facturado;
 	}

 	public function getDnActual()
 	{
 	    return $this->dn_actual;
 	}
 	
 	public function setDnActual($dn_actual)
 	{
 	    $this->dn_actual = $dn_actual;
 	}

 	public function getDescAreaServ()
 	{
 	    return $this->desc_area_serv;
 	}
 	
 	public function setDescAreaServ($desc_area_serv)
 	{
 	    $this->desc_area_serv = $desc_area_serv;
 	}

 	public function getTecnologia()
 	{
 	    return $this->tecnologia;
 	}
 	
 	public function setTecnologia($tecnologia)
 	{
 	    $this->tecnologia = $tecnologia;
 	}

 	public function getSubinventario()
 	{
 	    return $this->subinventario;
 	}
 	
 	public function setSubinventario($subinventario)
 	{
 	    $this->subinventario = $subinventario;
 	}

 	public function getUsuarioCciInicial()
 	{
 	    return $this->usuario_cci_inicial;
 	}
 	
 	public function setUsuarioCciInicial($usuario_cci_inicial)
 	{
 	    $this->usuario_cci_inicial = $usuario_cci_inicial;
 	}

 	public function getUsuarioCciRenoco()
 	{
 	    return $this->usuario_cci_renoco;
 	}
 	
 	public function setUsuarioCciRenoco($usuario_cci_renoco)
 	{
 	    $this->usuario_cci_renoco = $usuario_cci_renoco;
 	}

 	public function getDepartamento()
 	{
 	    return $this->departamento;
 	}
 	
 	public function setDepartamento($departamento)
 	{
 	    $this->departamento = $departamento;
 	}

 	public function getNombreContacto()
 	{
 	    return $this->nombre_contacto;
 	}
 	
 	public function setNombreContacto($nombre_contacto)
 	{
 	    $this->nombre_contacto = $nombre_contacto;
 	}

 	public function getRegion()
 	{
 	    return $this->region;
 	}
 	
 	public function setRegion($region)
 	{
 	    $this->region = $region;
 	}

 	public function getSubregion()
 	{
 	    return $this->subregion;
 	}
 	
 	public function setSubregion($subregion)
 	{
 	    $this->subregion = $subregion;
 	}

 	public function getEstado()
 	{
 	    return $this->estado;
 	}
 	
 	public function setEstado($estado)
 	{
 	    $this->estado = $estado;
 	}

 	public function getCiudadComercial()
 	{
 	    return $this->ciudad_comercial;
 	}
 	
 	public function setCiudadComercial($ciudad_comercial)
 	{
 	    $this->ciudad_comercial = $ciudad_comercial;
 	}

 	public function getMercado()
 	{
 	    return $this->mercado;
 	}
 	
 	public function setMercado($mercado)
 	{
 	    $this->mercado = $mercado;
 	}

 	public function getDireccionVta()
 	{
 	    return $this->direccion_vta;
 	}
 	
 	public function setDireccionVta($direccion_vta)
 	{
 	    $this->direccion_vta = $direccion_vta;
 	}

 	public function getCanalVta()
 	{
 	    return $this->canal_vta;
 	}
 	
 	public function setCanalVta($canal_vta)
 	{
 	    $this->canal_vta = $canal_vta;
 	}

 	public function getCveUnica()
 	{
 	    return $this->cve_unica;
 	}
 	
 	public function setCveUnica($cve_unica)
 	{
 	    $this->cve_unica = $cve_unica;
 	}

 	public function getNumCoordinador()
 	{
 	    return $this->num_coordinador;
 	}
 	
 	public function setNumCoordinador($num_coordinador)
 	{
 	    $this->num_coordinador = $num_coordinador;
 	}

 	public function getCoordinador()
 	{
 	    return $this->coordinador;
 	}
 	
 	public function setCoordinador($coordinador)
 	{
 	    $this->coordinador = $coordinador;
 	}

 	public function getNumGerente()
 	{
 	    return $this->num_gerente;
 	}
 	
 	public function setNumGerente($num_gerente)
 	{
 	    $this->num_gerente = $num_gerente;
 	}

 	public function getGerente()
 	{
 	    return $this->gerente;
 	}
 	
 	public function setGerente($gerente)
 	{
 	    $this->gerente = $gerente;
 	}

 	public function getOperadoPor()
 	{
 	    return $this->operado_por;
 	}
 	
 	public function setOperadoPor($operado_por)
 	{
 	    $this->operado_por = $operado_por;
 	}

 	public function getMasterPdv()
 	{
 	    return $this->master_pdv;
 	}
 	
 	public function setMasterPdv($master_pdv)
 	{
 	    $this->master_pdv = $master_pdv;
 	}

 	public function getIdDeudor()
 	{
 	    return $this->id_deudor;
 	}
 	
 	public function setIdDeudor($id_deudor)
 	{
 	    $this->id_deudor = $id_deudor;
 	}

 	public function getVp()
 	{
 	    return $this->vp;
 	}
 	
 	public function setVp($vp)
 	{
 	    $this->vp = $vp;
 	}

 	public function getAgrupacionCanal()
 	{
 	    return $this->agrupacion_canal;
 	}
 	
 	public function setAgrupacionCanal($agrupacion_canal)
 	{
 	    $this->agrupacion_canal = $agrupacion_canal;
 	}

 	public function getKam()
 	{
 	    return $this->kam;
 	}
 	
 	public function setKam($kam)
 	{
 	    $this->kam = $kam;
 	}

 	public function getKamCorreo()
 	{
 	    return $this->kam_correo;
 	}
 	
 	public function setKamCorreo($kam_correo)
 	{
 	    $this->kam_correo = $kam_correo;
 	}

 	public function getTipoCliente()
 	{
 	    return $this->tipo_cliente;
 	}
 	
 	public function setTipoCliente($tipo_cliente)
 	{
 	    $this->tipo_cliente = $tipo_cliente;
 	}

 	public function getEsControl()
 	{
 	    return $this->es_control;
 	}
 	
 	public function setEsControl($es_control)
 	{
 	    $this->es_control = $es_control;
 	}

 	public function getRentaServControl()
 	{
 	    return $this->renta_serv_control;
 	}
 	
 	public function setRentaServControl($renta_serv_control)
 	{
 	    $this->renta_serv_control = $renta_serv_control;
 	}

 	public function getAccessFee()
 	{
 	    return $this->access_fee;
 	}
 	
 	public function setAccessFee($access_fee)
 	{
 	    $this->access_fee = $access_fee;
 	}

 	public function getAccessFeeSinCtrl()
 	{
 	    return $this->access_fee_sin_ctrl;
 	}
 	
 	public function setAccessFeeSinCtrl($access_fee_sin_ctrl)
 	{
 	    $this->access_fee_sin_ctrl = $access_fee_sin_ctrl;
 	}

 	public function getAccessFeeServControl()
 	{
 	    return $this->access_fee_serv_control;
 	}
 	
 	public function setAccessFeeServControl($access_fee_serv_control)
 	{
 	    $this->access_fee_serv_control = $access_fee_serv_control;
 	}

 	public function getStatusTenure()
 	{
 	    return $this->status_tenure;
 	}
 	
 	public function setStatusTenure($status_tenure)
 	{
 	    $this->status_tenure = $status_tenure;
 	}

 	public function getTipoMovimiento()
 	{
 	    return $this->tipo_movimiento;
 	}
 	
 	public function setTipoMovimiento($tipo_movimiento)
 	{
 	    $this->tipo_movimiento = $tipo_movimiento;
 	}

 }
?>