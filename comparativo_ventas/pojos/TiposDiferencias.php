<?php
/**
 * 
 */
class TiposDiferencias
{
	private $id_tipo_diferencia;
	private $tipo_diferencia;
	private $activo;
	
	function __construct(){

	}

	public function getIdTipoDiferencia()
	{
	    return $this->id_tipo_diferencia;
	}
	
	public function setIdTipoDiferencia($id_tipo_diferencia)
	{
	    $this->id_tipo_diferencia = $id_tipo_diferencia;
	}

	public function getTipoDiferencia()
	{
	    return $this->tipo_diferencia;
	}
	
	public function setTipoDiferencia($tipo_diferencia)
	{
	    $this->tipo_diferencia = $tipo_diferencia;
	}

	public function getActivo()
	{
	    return $this->activo;
	}
	
	public function setActivo($activo)
	{
	    $this->activo = $activo;
	}
}
?>