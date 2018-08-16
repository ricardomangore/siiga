<?php
/**
 * 
 */
class Seguros
{
	private $id_registro;
	private $id_layout;
	private $id_contrato;
	private $sncode;
	private $seguro;
	private $renta;
	private $fecha_act_seg;
	private $id_contrato2;
	private $cuenta_cliente;
	private $estatus_act_seg;
	private $fecha_ultmod_seg;
	private $empresa;
	private $order_id;
	private $order_action_id;
	private $order_status_description;
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
	private $fecha_act_contr;
	private $mdn;
	private $mes;
	private $semana_consejo;
	private $sku;
	private $modelo_equipo;
	private $marca_equipo;
	private $color_equipo;
	private $capacidad_equipo;
	private $plan_tarifario_origen;
	private $plan_tarifario_final;
	private $familia;
	private $marca_plan;
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

	public function getIdContrato()
	{
	    return $this->id_contrato;
	}
	
	public function setIdContrato($id_contrato)
	{
	    $this->id_contrato = $id_contrato;
	}

	public function getSnCode()
	{
	    return $this->sncode;
	}
	
	public function setSnCode($sncode)
	{
	    $this->sncode = $sncode;
	}

	public function getSeguro()
	{
	    return $this->seguro;
	}
	
	public function setSeguro($seguro)
	{
	    $this->seguro = $seguro;
	}

	public function getRenta()
	{
	    return $this->renta;
	}
	
	public function setRenta($renta)
	{
	    $this->renta = $renta;
	}

	public function getFechaActSeg()
	{
	    return $this->fecha_act_seg;
	}
	
	public function setFechaActSeg($fecha_act_seg)
	{
	    $this->fecha_act_seg = $fecha_act_seg;
	}

	public function getIdContrato2()
	{
	    return $this->id_contrato2;
	}
	
	public function setIdContrato2($id_contrato2)
	{
	    $this->id_contrato2 = $id_contrato2;
	}

	public function getCuentaCliente()
	{
	    return $this->cuenta_cliente;
	}
	
	public function setCuentaCliente($cuenta_cliente)
	{
	    $this->cuenta_cliente = $cuenta_cliente;
	}

	public function getEstatusActSeg()
	{
	    return $this->estatus_act_seg;
	}
	
	public function setEstatusActSeg($estatus_act_seg)
	{
	    $this->estatus_act_seg = $estatus_act_seg;
	}

	public function getFechaUltmodSeg()
	{
	    return $this->fecha_ultmod_seg;
	}
	
	public function setFechaUltmodSeg($fecha_ultmod_seg)
	{
	    $this->fecha_ultmod_seg = $fecha_ultmod_seg;
	}

	public function getEmpresa()
	{
	    return $this->empresa;
	}
	
	public function setEmpresa($empresa)
	{
	    $this->empresa = $empresa;
	}

	public function getOrderId()
	{
	    return $this->order_id;
	}
	
	public function setOrderId($order_id)
	{
	    $this->order_id = $order_id;
	}

	public function getOrderActionId()
	{
	    return $this->order_action_id;
	}
	
	public function setOrderActionId($order_action_id)
	{
	    $this->order_action_id = $order_action_id;
	}

	public function getOrderStatusDescription()
	{
	    return $this->order_status_description;
	}
	
	public function setOrderStatusDescription($order_status_description)
	{
	    $this->order_status_description = $order_status_description;
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

	public function getFechaActContr()
	{
	    return $this->fecha_act_contr;
	}
	
	public function setFechaActContr($fecha_act_contr)
	{
	    $this->fecha_act_contr = $fecha_act_contr;
	}

	public function getMdn()
	{
	    return $this->mdn;
	}
	
	public function setMdn($mdn)
	{
	    $this->mdn = $mdn;
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

	public function getPlanTarifarioOrigen()
	{
	    return $this->plan_tarifario_origen;
	}
	
	public function setPlanTarifarioOrigen($plan_tarifario_origen)
	{
	    $this->plan_tarifario_origen = $plan_tarifario_origen;
	}

	public function getPlantarifariofinal()
	{
	    return $this->plan_tarifario_final;
	}
	
	public function setPlantarifariofinal($plan_tarifario_final)
	{
	    $this->plan_tarifario_final = $plan_tarifario_final;
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

	public function getVpgm()
	{
	    return $this->vpgm;
	}
	
	public function setVpgm($vpgm)
	{
	    $this->vpgm = $vpgm;
	}

}


/*
getIdRegistro()
getIdLayout()
getIdContrato()
getSnCode()
getSeguro()
getRenta()
getFechaActSeg()
getIdContrato2()
getCuentaCliente()
getEstatusActSeg()
getFechaUltmodSeg()
getEmpresa()
getOrderId()
getOrderActionId()
getOrderStatusDescription()
getCveUnicaPdv()
getNombrePdvUnico()
getPdvEstatus()
getMasterPdv()
getKam()
getCveUnicaEjecutivo()
getNombreEjecutivoUnico()
getAttuidNivel2()
getNumNivel2()
getNombreNivel2()
getAttuidNivel3()
getNumNivel3()
getNombreNivel3()
getAttuidNivel4()
getNumNivel4()
getNombreNivel4()
getAttuidNivel5()
getNumNivel5()
getNombreNivel5()
getAttuidNivel6()
getNumNivel6()
getNombreNivel6()
getAttuidNivel7()
getNumNivel7()
getNombreNivel7()
getVentas()
getFechaActContr()
getMdn()
getMes()
getSemanaConsejo()
getSku()
getModeloEquipo()
getMarcaEquipo()
getColorEquipo()
getCapacidadEquipo()
getPlanTarifarioOrigen()
getPlantarifariofinal()
getFamilia()
getMarcaPlan()
getRegion()
getSubregion()
getEstado()
getCiudadComercial()
getCveMercado()
getMercado()
getVp()
getDireccionVta()
getAgrupacionCanal()
getCanalVta()
getVpgm()




$id_registro
$id_layout
$id_contrato
$sncode
$seguro
$renta
$fecha_act_seg
$id_contrato2
$cuenta_cliente
$estatus_act_seg
$fecha_ultmod_seg
$empresa
$order_id
$order_action_id
$order_status_description
$cve_unica_pdv
$nombre_pdv_unico
$pdv_estatus
$master_pdv
$kam
$cve_unica_ejecutivo
$nombre_ejecutivo_unico
$attuid_nivel_2
$num_nivel_2
$nombre_nivel_2
$attuid_nivel_3
$num_nivel_3
$nombre_nivel_3
$attuid_nivel_4
$num_nivel_4
$nombre_nivel_4
$attuid_nivel_5
$num_nivel_5
$nombre_nivel_5
$attuid_nivel_6
$num_nivel_6
$nombre_nivel_6
$attuid_nivel_7
$num_nivel_7
$nombre_nivel_7
$ventas
$fecha_act_contr
$mdn
$mes
$semana_consejo
$sku
$modelo_equipo
$marca_equipo
$color_equipo
$capacidad_equipo
$plan_tarifario_origen
$plan_tarifario_final
$familia
$marca_plan
$region
$subregion
$estado
$ciudad_comercial
$cve_mercado
$mercado
$vp
$direccion_vta
$agrupacion_canal
$canal_vta
$vpgm

*/

?>