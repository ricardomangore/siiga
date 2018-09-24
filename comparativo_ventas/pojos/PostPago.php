<?php
/**
 * 
 */
class PostPago
{
	private $id_registro;
	private $id_layout;
	private $folio;
	private $no_contrato_impreso;
	private $id_orden_contratacion;
	private $fecha_contratacion;
	private $pricegroup;
	private $cuenta_cliente;
	private $nombre_cliente;
	private $tipo_persona;
	private $subtipo_persona;
	private $tipo_venta;
	private $status_orden;
	private $fecha_status_orden;
	private $empresa;
	private $cve_unica_pdv;
	private $nombre_pdv_unico;
	private $pdv_estatus;
	private $master_pdv;
	private $kam;
	private $cve_unica_ejecutivo;
	private $nombre_ejecutivo_unico;
	private $attuid_nivel_2;
	private $num_nivel_2;
	private $nombre_nivel_2;
	private $attuid_nivel_3;
	private $num_nivel_3;
	private $nombre_nivel_3;
	private $attuid_nivel_4;
	private $num_nivel_4;
	private $nombre_nivel_4;
	private $attuid_nivel_5;
	private $num_nivel_5;
	private $nombre_nivel_5;
	private $attuid_nivel_6;
	private $num_nivel_6;
	private $nombre_nivel_6;
	private $attuid_nivel_7;
	private $num_nivel_7;
	private $nombre_nivel_7;
	private $ventas;
	private $id_contrato;
	private $nir;
	private $mdn_inicial;
	private $propiedad;
	private $fecha_activacion;
	private $mes;
	private $semana_consejo;
	private $mdn_actual;
	private $fecha_mdn_actual;
	private $sim;
	private $imei;
	private $sku;
	private $modelo_equipo;
	private $marca_equipo;
	private $color_equipo;
	private $capacidad_equipo;
	private $modalidad;
	private $tecnologia;
	private $plan_tarifario_homo;
	private $plan_tarifario_homo2;
	private $plazo_forzoso;
	private $familia;
	private $marca_plan;
	private $renta;
	private $nva_renta;
	private $accessfee_mens;
	private $nva_renta_sem;
	private $accessfee_seml;
	private $region;
	private $subregion;
	private $estado;
	private $ciudad_comercial;
	private $cve_mercado;
	private $mercado;
	private $vp;
	private $direccion_vta;
	private $agrupacion_canal;
	private $canal_vta;
	private $semana_recarga;
	private $fecha_primer_abono;
	private $monto_primer_abono;
	private $fecha_segundo_abono;
	private $monto_segundo_abono;
	private $mdn_definitivo;
	private $fecha_port_in;
	private $donador_in;
	private $receptor_in;
	private $fecha_port_out;
	private $donador_out;
	private $receptor_out;
	private $concesionado;
	private $es_control;
	private $es_t_next;
	private $es_volte;
	private $cve_ejecutivo_codifica;
	private $ejecutivo_codifica;
	private $cve_pdv_codifica;
	private $pdv_codifica;
	private $fecha_codifica;
	private $folio_codifica;
	private $attuid_codifica;
	private $fecha_movimiento;
	private $dia;
	private $vpgm;

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

	public function getNoContatoImpreso()
	{
	    return $this->no_contrato_impreso;
	}
	
	public function setNoContatoImpreso($no_contrato_impreso)
	{
	    $this->no_contrato_impreso = $no_contrato_impreso;
	}

	public function getIdOrdenContratacion()
	{
	    return $this->id_orden_contratacion;
	}
	
	public function setIdOrdenContratacion($id_orden_contratacion)
	{
	    $this->id_orden_contratacion = $id_orden_contratacion;
	}

	public function getFechaContratacion()
	{
	    return $this->fecha_contratacion;
	}
	
	public function setFechaContratacion($fecha_contratacion)
	{
	    $this->fecha_contratacion = $fecha_contratacion;
	}

	public function getPriceGroup()
	{
	    return $this->pricegroup;
	}
	
	public function setPriceGroup($pricegroup)
	{
	    $this->pricegroup = $pricegroup;
	}

	public function getCuentaCliente()
	{
	    return $this->cuenta_cliente;
	}
	
	public function setCuentaCliente($cuenta_cliente)
	{
	    $this->cuenta_cliente = $cuenta_cliente;
	}

	public function getNombreCliente()
	{
	    return $this->nombre_cliente;
	}
	
	public function setNombreCliente($nombre_cliente)
	{
	    $this->nombre_cliente = $nombre_cliente;
	}

	public function getTipoPersona()
	{
	    return $this->tipo_persona;
	}
	
	public function setTipoPersona($tipo_persona)
	{
	    $this->tipo_persona = $tipo_persona;
	}

	public function getSubtipoPersona()
	{
	    return $this->subtipo_persona;
	}
	
	public function setSubtipoPersona($subtipo_persona)
	{
	    $this->subtipo_persona = $subtipo_persona;
	}

	public function getTipoVenta()
	{
	    return $this->tipo_venta;
	}
	
	public function setTipoVenta($tipo_venta)
	{
	    $this->tipo_venta = $tipo_venta;
	}

	public function getStatusOrden()
	{
	    return $this->status_orden;
	}
	
	public function setStatusOrden($status_orden)
	{
	    $this->status_orden = $status_orden;
	}

	public function getFechaStatusOrden()
	{
	    return $this->fecha_status_orden;
	}
	
	public function setFechaStatusOrden($fecha_status_orden)
	{
	    $this->fecha_status_orden = $fecha_status_orden;
	}

	public function getEmpresa()
	{
	    return $this->empresa;
	}
	
	public function setEmpresa($empresa)
	{
	    $this->empresa = $empresa;
	}

	public function getCveUnicaPdv()
	{
	    return $this->cve_unica_pdv;
	}
	
	public function setCveUnicaPdv($cve_unica_pdv)
	{
	    $this->cve_unica_pdv = $cve_unica_pdv;
	}

	public function getNombrePdvUnico()
	{
	    return $this->nombre_pdv_unico;
	}
	
	public function setNombrePdvUnico($nombre_pdv_unico)
	{
	    $this->nombre_pdv_unico = $nombre_pdv_unico;
	}

	public function getPdvEstatus()
	{
	    return $this->pdv_estatus;
	}
	
	public function setPdvEstatus($pdv_estatus)
	{
	    $this->pdv_estatus = $pdv_estatus;
	}

	public function getMasterPdv()
	{
	    return $this->master_pdv;
	}
	
	public function setMasterPdv($master_pdv)
	{
	    $this->master_pdv = $master_pdv;
	}

	public function getKam()
	{
	    return $this->kam;
	}
	
	public function setKam($kam)
	{
	    $this->kam = $kam;
	}

	public function getCveUnicaEjecutivo()
	{
	    return $this->cve_unica_ejecutivo;
	}
	
	public function setCveUnicaEjecutivo($cve_unica_ejecutivo)
	{
	    $this->cve_unica_ejecutivo = $cve_unica_ejecutivo;
	}

	public function getNombreEjecutivoUnico()
	{
	    return $this->nombre_ejecutivo_unico;
	}
	
	public function setNombreEjecutivoUnico($nombre_ejecutivo_unico)
	{
	    $this->nombre_ejecutivo_unico = $nombre_ejecutivo_unico;
	}

	public function getAttuidNivel2()
	{
	    return $this->attuid_nivel_2;
	}
	
	public function setAttuidNivel2($attuid_nivel_2)
	{
	    $this->attuid_nivel_2 = $attuid_nivel_2;
	}

	public function getNumNivel2()
	{
	    return $this->num_nivel_2;
	}
	
	public function setNumNivel2($num_nivel_2)
	{
	    $this->num_nivel_2 = $num_nivel_2;
	}

	public function getNombreNivel2()
	{
	    return $this->nombre_nivel_2;
	}
	
	public function setNombreNivel2($nombre_nivel_2)
	{
	    $this->nombre_nivel_2 = $nombre_nivel_2;
	}

	public function getAttuidNivel3()
	{
	    return $this->attuid_nivel_3;
	}
	
	public function setAttuidNivel3($attuid_nivel_3)
	{
	    $this->attuid_nivel_3 = $attuid_nivel_3;
	}

	public function getNumNivel3()
	{
	    return $this->num_nivel_3;
	}
	
	public function setNumNivel3($num_nivel_3)
	{
	    $this->num_nivel_3 = $num_nivel_3;
	}

	public function getNombreNivel3()
	{
	    return $this->nombre_nivel_3;
	}
	
	public function setNombreNivel3($nombre_nivel_3)
	{
	    $this->nombre_nivel_3 = $nombre_nivel_3;
	}

	public function getAttuidNivel4()
	{
	    return $this->attuid_nivel_4;
	}
	
	public function setAttuidNivel4($attuid_nivel_4)
	{
	    $this->attuid_nivel_4 = $attuid_nivel_4;
	}

	public function getNumNivel4()
	{
	    return $this->num_nivel_4;
	}
	
	public function setNumNivel4($num_nivel_4)
	{
	    $this->num_nivel_4 = $num_nivel_4;
	}

	public function getNombreNivel4()
	{
	    return $this->nombre_nivel_4;
	}
	
	public function setNombreNivel4($nombre_nivel_4)
	{
	    $this->nombre_nivel_4 = $nombre_nivel_4;
	}

	public function getAttuidNivel5()
	{
	    return $this->attuid_nivel_5;
	}
	
	public function setAttuidNivel5($attuid_nivel_5)
	{
	    $this->attuid_nivel_5 = $attuid_nivel_5;
	}

	public function getNumNivel5()
	{
	    return $this->num_nivel_5;
	}
	
	public function setNumNivel5($num_nivel_5)
	{
	    $this->num_nivel_5 = $num_nivel_5;
	}

	public function getNombreNivel5()
	{
	    return $this->nombre_nivel_5;
	}
	
	public function setNombreNivel5($nombre_nivel_5)
	{
	    $this->nombre_nivel_5 = $nombre_nivel_5;
	}

	public function getAttuidNivel6()
	{
	    return $this->attuid_nivel_6;
	}
	
	public function setAttuidNivel6($attuid_nivel_6)
	{
	    $this->attuid_nivel_6 = $attuid_nivel_6;
	}

	public function getNumNivel6()
	{
	    return $this->num_nivel_6;
	}
	
	public function setNumNivel6($num_nivel_6)
	{
	    $this->num_nivel_6 = $num_nivel_6;
	}

	public function getNombreNivel6()
	{
	    return $this->nombre_nivel_6;
	}
	
	public function setNombreNivel6($nombre_nivel_6)
	{
	    $this->nombre_nivel_6 = $nombre_nivel_6;
	}

	public function getAttuidNivel7()
	{
	    return $this->attuid_nivel_7;
	}
	
	public function setAttuidNivel7($attuid_nivel_7)
	{
	    $this->attuid_nivel_7 = $attuid_nivel_7;
	}

	public function getNumNivel7()
	{
	    return $this->num_nivel_7;
	}
	
	public function setNumNivel7($num_nivel_7)
	{
	    $this->num_nivel_7 = $num_nivel_7;
	}

	public function getNombreNivel7()
	{
	    return $this->nombre_nivel_7;
	}
	
	public function setNombreNivel7($nombre_nivel_7)
	{
	    $this->nombre_nivel_7 = $nombre_nivel_7;
	}

	public function getVentas()
	{
	    return $this->ventas;
	}
	
	public function setVentas($ventas)
	{
	    $this->ventas = $ventas;
	}

	public function getIdContrato()
	{
	    return $this->id_contrato;
	}
	
	public function setIdContrato($id_contrato)
	{
	    $this->id_contrato = $id_contrato;
	}

	public function getNir()
	{
	    return $this->nir;
	}
	
	public function setNir($nir)
	{
	    $this->nir = $nir;
	}

	public function getMdnInicial()
	{
	    return $this->mdn_inicial;
	}
	
	public function setMdnInicial($mdn_inicial)
	{
	    $this->mdn_inicial = $mdn_inicial;
	}

	public function getPropiedad()
	{
	    return $this->propiedad;
	}
	
	public function setPropiedad($propiedad)
	{
	    $this->propiedad = $propiedad;
	}

	public function getFechaActivacion()
	{
	    return $this->fecha_activacion;
	}
	
	public function setFechaActivacion($fecha_activacion)
	{
	    $this->fecha_activacion = $fecha_activacion;
	}

	public function getMes()
	{
	    return $this->mes;
	}
	
	public function setMes($mes)
	{
	    $this->mes = $mes;
	}

	public function getSemanaConsejo()
	{
	    return $this->semana_consejo;
	}
	
	public function setSemanaConsejo($semana_consejo)
	{
	    $this->semana_consejo = $semana_consejo;
	}

	public function getMdnActual()
	{
	    return $this->mdn_actual;
	}
	
	public function setMdnActual($mdn_actual)
	{
	    $this->mdn_actual = $mdn_actual;
	}

	public function getFechaMdnActual()
	{
	    return $this->fecha_mdn_actual;
	}
	
	public function setFechaMdnActual($fecha_mdn_actual)
	{
	    $this->fecha_mdn_actual = $fecha_mdn_actual;
	}

	public function getSim()
	{
	    return $this->sim;
	}
	
	public function setSim($sim)
	{
	    $this->sim = $sim;
	}

	public function getImei()
	{
	    return $this->imei;
	}
	
	public function setImei($imei)
	{
	    $this->imei = $imei;
	}

	public function getSku()
	{
	    return $this->sku;
	}
	
	public function setSku($sku)
	{
	    $this->sku = $sku;
	}

	public function getModeloEquipo()
	{
	    return $this->modelo_equipo;
	}
	
	public function setModeloEquipo($modelo_equipo)
	{
	    $this->modelo_equipo = $modelo_equipo;
	}

	public function getMarcaEquipo()
	{
	    return $this->marca_equipo;
	}
	
	public function setMarcaEquipo($marca_equipo)
	{
	    $this->marca_equipo = $marca_equipo;
	}

	public function getColorEquipo()
	{
	    return $this->color_equipo;
	}
	
	public function setColorEquipo($color_equipo)
	{
	    $this->color_equipo = $color_equipo;
	}

	public function getCapacidadEquipo()
	{
	    return $this->capacidad_equipo;
	}
	
	public function setCapacidadEquipo($capacidad_equipo)
	{
	    $this->capacidad_equipo = $capacidad_equipo;
	}

	public function getModalidad()
	{
	    return $this->modalidad;
	}
	
	public function setModalidad($modalidad)
	{
	    $this->modalidad = $modalidad;
	}

	public function getTecnologia()
	{
	    return $this->tecnologia;
	}
	
	public function setTecnologia($tecnologia)
	{
	    $this->tecnologia = $tecnologia;
	}

	public function getPlanTarifarioHomo()
	{
	    return $this->plan_tarifario_homo;
	}
	
	public function setPlanTarifarioHomo($plan_tarifario_homo)
	{
	    $this->plan_tarifario_homo = $plan_tarifario_homo;
	}

	public function getPlanTarifarioHomo2()
	{
	    return $this->plan_tarifario_homo2;
	}
	
	public function setPlanTarifarioHomo2($plan_tarifario_homo2)
	{
	    $this->plan_tarifario_homo2 = $plan_tarifario_homo2;
	}

	public function getPlazoForzoso()
	{
	    return $this->plazo_forzoso;
	}
	
	public function setPlazoForzoso($plazo_forzoso)
	{
	    $this->plazo_forzoso = $plazo_forzoso;
	}

	public function getFamilia()
	{
	    return $this->familia;
	}
	
	public function setFamilia($familia)
	{
	    $this->familia = $familia;
	}

	public function getMarcaPlan()
	{
	    return $this->marca_plan;
	}
	
	public function setMarcaPlan($marca_plan)
	{
	    $this->marca_plan = $marca_plan;
	}

	public function getRenta()
	{
	    return $this->renta;
	}
	
	public function setRenta($renta)
	{
	    $this->renta = $renta;
	}

	public function getNvaRenta()
	{
	    return $this->nva_renta;
	}
	
	public function setNvaRenta($nva_renta)
	{
	    $this->nva_renta = $nva_renta;
	}

	public function getAccessfeeMens()
	{
	    return $this->accessfee_mens;
	}
	
	public function setAccessfeeMens($accessfee_mens)
	{
	    $this->accessfee_mens = $accessfee_mens;
	}

	public function getNvaRentaSem()
	{
	    return $this->nva_renta_sem;
	}
	
	public function setNvaRentaSem($nva_renta_sem)
	{
	    $this->nva_renta_sem = $nva_renta_sem;
	}

	public function getAccessfeeSeml()
	{
	    return $this->accessfee_seml;
	}
	
	public function setAccessfeeSeml($accessfee_seml)
	{
	    $this->accessfee_seml = $accessfee_seml;
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

	public function getCveMercado()
	{
	    return $this->cve_mercado;
	}
	
	public function setCveMercado($cve_mercado)
	{
	    $this->cve_mercado = $cve_mercado;
	}

	public function getMercado()
	{
	    return $this->mercado;
	}
	
	public function setMercado($mercado)
	{
	    $this->mercado = $mercado;
	}

	public function getVp()
	{
	    return $this->vp;
	}
	
	public function setVp($vp)
	{
	    $this->vp = $vp;
	}

	public function getDireccionVta()
	{
	    return $this->direccion_vta;
	}
	
	public function setDireccionVta($direccion_vta)
	{
	    $this->direccion_vta = $direccion_vta;
	}

	public function getAgrupacionCanal()
	{
	    return $this->agrupacion_canal;
	}
	
	public function setAgrupacionCanal($agrupacion_canal)
	{
	    $this->agrupacion_canal = $agrupacion_canal;
	}

	public function getCanalVta()
	{
	    return $this->canal_vta;
	}
	
	public function setCanalVta($canal_vta)
	{
	    $this->canal_vta = $canal_vta;
	}

	public function getSemanaRecarga()
	{
	    return $this->semana_recarga;
	}
	
	public function setSemanaRecarga($semana_recarga)
	{
	    $this->semana_recarga = $semana_recarga;
	}

	public function getFechaPrimerAbono()
	{
	    return $this->fecha_primer_abono;
	}
	
	public function setFechaPrimerAbono($fecha_primer_abono)
	{
	    $this->fecha_primer_abono = $fecha_primer_abono;
	}

	public function getMontoPrimerAbono()
	{
	    return $this->monto_primer_abono;
	}
	
	public function setMontoPrimerAbono($monto_primer_abono)
	{
	    $this->monto_primer_abono = $monto_primer_abono;
	}

	public function getFechaSegundoAbono()
	{
	    return $this->fecha_segundo_abono;
	}
	
	public function setFechaSegundoAbono($fecha_segundo_abono)
	{
	    $this->fecha_segundo_abono = $fecha_segundo_abono;
	}

	public function getMontoSegundoAbono()
	{
	    return $this->monto_segundo_abono;
	}
	
	public function setMontoSegundoAbono($monto_segundo_abono)
	{
	    $this->monto_segundo_abono = $monto_segundo_abono;
	}

	public function getMdnDefinitivo()
	{
	    return $this->mdn_definitivo;
	}
	
	public function setMdnDefinitivo($mdn_definitivo)
	{
	    $this->mdn_definitivo = $mdn_definitivo;
	}

	public function getFechaPortIn()
	{
	    return $this->fecha_port_in;
	}
	
	public function setFechaPortIn($fecha_port_in)
	{
	    $this->fecha_port_in = $fecha_port_in;
	}

	public function getDonadorIn()
	{
	    return $this->donador_in;
	}
	
	public function setDonadorIn($donador_in)
	{
	    $this->donador_in = $donador_in;
	}

	public function getReceptorIn()
	{
	    return $this->receptor_in;
	}
	
	public function setReceptorIn($receptor_in)
	{
	    $this->receptor_in = $receptor_in;
	}

	public function getFechaPortOut()
	{
	    return $this->fecha_port_out;
	}
	
	public function setFechaPortOut($fecha_port_out)
	{
	    $this->fecha_port_out = $fecha_port_out;
	}

	public function getDonadorOut()
	{
	    return $this->donador_out;
	}
	
	public function setDonadorOut($donador_out)
	{
	    $this->donador_out = $donador_out;
	}

	public function getReceptorOut()
	{
	    return $this->receptor_out;
	}
	
	public function setReceptorOut($receptor_out)
	{
	    $this->receptor_out = $receptor_out;
	}

	public function getConcesionado()
	{
	    return $this->concesionado;
	}
	
	public function setConcesionado($concesionado)
	{
	    $this->concesionado = $concesionado;
	}

	public function getEsControl()
	{
	    return $this->es_control;
	}
	
	public function setEsControl($es_control)
	{
	    $this->es_control = $es_control;
	}

	public function getEsTNext()
	{
	    return $this->es_t_next;
	}
	
	public function setEsTNext($es_t_next)
	{
	    $this->es_t_next = $es_t_next;
	}

	public function getEsVolte()
	{
	    return $this->es_volte;
	}
	
	public function setEsVolte($es_volte)
	{
	    $this->es_volte = $es_volte;
	}

	public function getCveEjecutivoCodifica()
	{
	    return $this->cve_ejecutivo_codifica;
	}
	
	public function setCveEjecutivoCodifica($cve_ejecutivo_codifica)
	{
	    $this->cve_ejecutivo_codifica = $cve_ejecutivo_codifica;
	}

	public function getEjecutivoCodifica()
	{
	    return $this->ejecutivo_codifica;
	}
	
	public function setEjecutivoCodifica($ejecutivo_codifica)
	{
	    $this->ejecutivo_codifica = $ejecutivo_codifica;
	}

	public function getCvePdvCodifica()
	{
	    return $this->cve_pdv_codifica;
	}
	
	public function setCvePdvCodifica($cve_pdv_codifica)
	{
	    $this->cve_pdv_codifica = $cve_pdv_codifica;
	}

	public function getPdvCodifica()
	{
	    return $this->pdv_codifica;
	}
	
	public function setPdvCodifica($pdv_codifica)
	{
	    $this->pdv_codifica = $pdv_codifica;
	}

	public function getFechaCodifica()
	{
	    return $this->fecha_codifica;
	}
	
	public function setFechaCodifica($fecha_codifica)
	{
	    $this->fecha_codifica = $fecha_codifica;
	}

	public function getFolioCodifica()
	{
	    return $this->folio_codifica;
	}
	
	public function setFolioCodifica($folio_codifica)
	{
	    $this->folio_codifica = $folio_codifica;
	}

	public function getAttuidCodifica()
	{
	    return $this->attuid_codifica;
	}
	
	public function setAttuidCodifica($attuid_codifica)
	{
	    $this->attuid_codifica = $attuid_codifica;
	}

	public function getFechaMovimiento()
	{
	    return $this->fecha_movimiento;
	}
	
	public function setFechaMovimiento($fecha_movimiento)
	{
	    $this->fecha_movimiento = $fecha_movimiento;
	}

	public function getDia()
	{
	    return $this->dia;
	}
	
	public function setDia($dia)
	{
	    $this->dia = $dia;
	}

	public function getVpgm()
	{
	    return $this->vpgm;
	}
	
	public function setVpgm($vpgm)
	{
	    $this->vpgm = $vpgm;
	}

}

?>