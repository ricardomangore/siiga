<?php
/**
 * 
 */
class Diferencias
{
	private $id_registro;
	private $id_tipo_diferencia;
	
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

	public function getIdTipoDiferencia()
	{
	    return $this->id_tipo_diferencia;
	}
	
	public function setIdTipoDiferencia($id_tipo_diferencia)
	{
	    $this->id_tipo_diferencia = $id_tipo_diferencia;
	}
}
?>