<?php
/**
 * 
 */
class ViewTransfer
{
	private $id_orden_renovacion;
	private $nomnbre_pdv;
	private $fecha_activacion_contrato;
	private $new_sim;
	private $new_imei;
	private $plan_actual;
	private $plazo_actual;
	private $dn_actual;
	private $tipo_incidencia;
	
	function __construct(){

	}

	public function getIdOrdenRenovacion()
	{
	    return $this->id_orden_renovacion;
	}
	
	public function setIdOrdenRenovacion($id_orden_renovacion)
	{
	    $this->id_orden_renovacion = $id_orden_renovacion;
	}

	public function getNomnbrePdv()
	{
	    return $this->nomnbre_pdv;
	}
	
	public function setNomnbrePdv($nomnbre_pdv)
	{
	    $this->nomnbre_pdv = $nomnbre_pdv;
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

	public function getPlanActual()
	{
	    return $this->plan_actual;
	}
	
	public function setPlanActual($plan_actual)
	{
	    $this->plan_actual = $plan_actual;
	}

	public function getPlazoActual()
	{
	    return $this->plazo_actual;
	}
	
	public function setPlazoActual($plazo_actual)
	{
	    $this->plazo_actual = $plazo_actual;
	}

	public function getDnActual()
	{
	    return $this->dn_actual;
	}
	
	public function setDnActual($dn_actual)
	{
	    $this->dn_actual = $dn_actual;
	}

	public function getTipoIncidencia()
	{
	    return $this->tipo_incidencia;
	}
	
	public function setTipoIncidencia($tipo_incidencia)
	{
	    $this->tipo_incidencia = $tipo_incidencia;
	}
}
?>