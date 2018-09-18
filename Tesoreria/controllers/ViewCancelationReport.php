<?php

class ViewCancelationReport{

	private $nombre;
	private $orden_crm;
	private $numero_documento;
	private $concepto;
	private $fecha_cancelacion;
	private $descripcion;

	public function getNombre()
	{
	    return $this->nombre;
	}
	
	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getOrdenCrm()
	{
	    return $this->orden_crm;
	}
	
	public function setOrdenCrm($orden_crm)
	{
	    $this->orden_crm = $orden_crm;
	}

	public function getNumeroDocumento()
	{
	    return $this->numero_documento;
	}
	
	public function setNumeroDocumento($numero_documento)
	{
	    $this->numero_documento = $numero_documento;
	}

	public function getConcepto()
	{
	    return $this->concepto;
	}
	
	public function setConcepto($concepto)
	{
	    $this->concepto = $concepto;
	}

	public function getFechaCancelacion()
	{
	    return $this->fecha_cancelacion;
	}
	
	public function setFechaCancelacion($fecha_cancelacion)
	{
	    $this->fecha_cancelacion = $fecha_cancelacion;
	}

	public function getDescripcion()
	{
	    return $this->descripcion;
	}
	
	public function setDescripcion($descripcion)
	{
	    $this->descripcion = $descripcion;
	}


}

?>