<?php
/**
 * 
 */
class ViewPostPago
{
	private $id_registro;
	private $id_layout;
	private $folio;
	private $no_contrato_impreso;
	private $id_orden_contratacion;
	private $nombre_cliente;
	private $tipo_venta;
	private $nombre_ejecutivo_unico;
	private $sim;
	private $imei;
	private $plazo_forzoso;
	private $id_tipo_diferencia;
	private $tipo_diferencia;
	
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

	public function getIdOrdenContratacion()
	{
	    return $this->id_orden_contratacion;
	}
	
	public function setIdOrdenContratacion($id_orden_contratacion)
	{
	    $this->id_orden_contratacion = $id_orden_contratacion;
	}

	public function getNombreCliente()
	{
	    return $this->nombre_cliente;
	}
	
	public function setNombreCliente($nombre_cliente)
	{
	    $this->nombre_cliente = $nombre_cliente;
	}

	public function getTipoVenta()
	{
	    return $this->tipo_venta;
	}
	
	public function setTipoVenta($tipo_venta)
	{
	    $this->tipo_venta = $tipo_venta;
	}

	public function getNombreEjecutivoUnico()
	{
	    return $this->nombre_ejecutivo_unico;
	}
	
	public function setNombreEjecutivoUnico($nombre_ejecutivo_unico)
	{
	    $this->nombre_ejecutivo_unico = $nombre_ejecutivo_unico;
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

	public function getPlazoForzoso()
	{
	    return $this->plazo_forzoso;
	}
	
	public function setPlazoForzoso($plazo_forzoso)
	{
	    $this->plazo_forzoso = $plazo_forzoso;
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

}
?>