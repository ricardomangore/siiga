<?php
/**
 * 
 */
class TiposLayout
{
	private $id_tipo_layout;
	private $tipo_layout;
	private $activo;
	
	function __construct(){

	}

	public function getIdTipoLayout()
	{
	    return $this->id_tipo_layout;
	}
	
	public function setIdTipoLayout($id_tipo_layout)
	{
	    $this->id_tipo_layout = $id_tipo_layout;
	}

	public function getTipoLayout()
	{
	    return $this->tipo_layout;
	}
	
	public function setTipoLayout($tipo_layout)
	{
	    $this->tipo_layout = $tipo_layout;
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