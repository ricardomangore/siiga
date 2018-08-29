<?php
/**
 * 
 */
class ViewSeguros
{
	private $id_contrato;
	private $renta;
	private $fecha_act_seg;
	private $tipo_diferencia;
	
	function __construct(){

	}

	public function getIdContrato()
	{
	    return $this->id_contrato;
	}
	
	public function setIdContrato($id_contrato)
	{
	    $this->id_contrato = $id_contrato;
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

	public function getTipoDiferencia()
	{
	    return $this->tipo_diferencia;
	}
	
	public function setTipoDiferencia($tipo_diferencia)
	{
	    $this->tipo_diferencia = $tipo_diferencia;
	}
}
?>