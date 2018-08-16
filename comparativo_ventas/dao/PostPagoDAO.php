<?php

require_once ('/../includes/Connect.php');
require_once ("/../pojos/PostPago.php");

class PostPagoDao extends Connect{


	/**
	 * method: savePostPagoDAO()
	 * description: Return a PostPago Object after insert new record in tw_postpago table
	 * params: <Object> PostPago
	 * return <Object> PostPago
	 */
	public function savePostPagoDAO($postPago){
		$returnValue = NULL;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$id_layout = $postPago->getIDLayout();
			$folio = $postPago->getFolio();
			$no_contrato_impreso = $postPago->getNoContatoImpreso();
			$id_orden_contratacion = $postPago->getIdOrdenContratacion();
			$fecha_contratacion = $postPago->getFechaContratacion();
			$pricegroup = $postPago->getPriceGroup();
			$cuenta_cliente = $postPago->getCuentaCliente();
			$nombre_cliente = $postPago->getNombreCliente();
			$tipo_persona = $postPago->getTipoPersona();
			$subtipo_persona = $postPago->getSubtipoPersona();
			$tipo_venta = $postPago->getTipoVenta();
			$status_orden = $postPago->getStatusOrden();
			$fecha_status_orden = $postPago->getFechaStatusOrden();
			$empresa = $postPago->getEmpresa();
			$cve_unica_pdv = $postPago->getCveUnicaPdv();
			$nombre_pdv_unico = $postPago->getNombrePdvUnico();
			$pdv_estatus = $postPago->getPdvEstatus();
			$master_pdv = $postPago->getMasterPdv();
			$kam = $postPago->getKam();
			$cve_unica_ejecutivo = $postPago->getCveUnicaEjecutivo();
			$nombre_ejecutivo_unico = $postPago->getNombreEjecutivoUnico();
			$attuid_nivel_2 = $postPago->getAttuidNivel2();
			$num_nivel_2 = $postPago->getNumNivel2();
			$nombre_nivel_2 = $postPago->getNombreNivel2();
			$attuid_nivel_3 = $postPago->getAttuidNivel3();
			$num_nivel_3 = $postPago->getNumNivel3();
			$nombre_nivel_3 = $postPago->getNombreNivel3();
			$attuid_nivel_4 = $postPago->getAttuidNivel4();
			$num_nivel_4 = $postPago->getNumNivel4();
			$nombre_nivel_4 = $postPago->getNombreNivel4();
			$attuid_nivel_5 = $postPago->getAttuidNivel5();
			$num_nivel_5 = $postPago->getNumNivel5();
			$nombre_nivel_5 = $postPago->getNombreNivel5();
			$attuid_nivel_6 = $postPago->getAttuidNivel6();
			$num_nivel_6 = $postPago->getNumNIvel6();
			$nombre_nivel_6 = $postPago->getNombreNivel6();
			$attuid_nivel_7 = $postPago->getAttuidNivel7();
			$num_nivel_7 = $postPago->getNumNivel7();
			$nombre_nivel_7 = $postPago->getNombreNivel7();
			$ventas = $postPago->getVentas();
			$id_contrato = $postPago->getIdContrato();
			$nir = $postPago->getNir();
			$mdn_inicial = $postPago->getMdnInicial();
			$propiedad = $postPago->getPropiedad();
			$fecha_activacion = $postPago->getFechaActivacion();
			$mes = $postPago->getMes();
			$semana_consejo = $postPago->getSemanaConsejo();
			$mdn_actual = $postPago->getMdnActual();
			$fecha_mdn_actual = $postPago->getFechaMdnActual();
			$sim = $postPago->getSim();
			$imei = $postPago->getImei();
			$sku = $postPago->getSku();
			$modelo_equipo = $postPago->getModeloEquipo();
			$marca_equipo = $postPago->getMarcaEquipo();
			$color_equipo = $postPago->getColorEquipo();
			$capacidad_equipo = $postPago->getCapacidadEquipo();
			$modalidad = $postPago->getModalidad();
			$tecnologia = $postPago->getTecnologia();
			$plan_tarifario_homo = $postPago->getPlanTarifarioHomo();
			$plan_tarifario_homo2 = $postPago->getPlanTarifarioHomo2();
			$plazo_forzoso = $postPago->getPlazoForzoso();
			$familia = $postPago->getFamilia();
			$marca_plan = $postPago->getMarcaPlan();
			$renta = $postPago->getRenta();
			$nva_renta = $postPago->getNvaRenta();
			$accessfee_mens = $postPago->getAccessfeeMens();
			$nva_renta_sem = $postPago->getNvaRentaSem();
			$accessfee_seml = $postPago->getAccessfeeSeml();
			$region = $postPago->getRegion();
			$subregion = $postPago->getSubregion();
			$estado = $postPago->getEstado();
			$ciudad_comercial = $postPago->getCiudadComercial();
			$cve_mercado = $postPago->getCveMercado();
			$mercado = $postPago->getMercado();
			$vp = $postPago->getVp();
			$direccion_vta = $postPago->getDireccionVta();
			$agrupacion_canal = $postPago->getAgrupacionCanal();
			$canal_vta = $postPago->getCanalVta();
			$semana_recarga = $postPago->getSemanaRecarga();
			$fecha_primer_abono = $postPago->getFechaPrimerAbono();
			$monto_primer_abono = $postPago->getMontoPrimerAbono();
			$fecha_segundo_abono = $postPago->getFechaSegundoAbono();
			$monto_segundo_abono = $postPago->getMontoSegundoAbono();
			$mdn_definitivo = $postPago->getMdnDefinitivo();
			$fecha_port_in = $postPago->getFechaPortIn();
			$donador_in = $postPago->getDonadorIn();
			$receptor_in = $postPago->getReceptorIn();
			$fecha_port_out = $postPago->getFechaPortOut();
			$donador_out = $postPago->getDonadorOut();
			$receptor_out = $postPago->getReceptorOut();
			$concesionado = $postPago->getConcesionado();
			$es_control = $postPago->getEsControl();
			$es_t_next = $postPago->getEsTNext();
			$es_volte = $postPago->getEsVolte();
			$cve_ejecutivo_codifica = $postPago->getCveEjecutivoCodifica();
			$ejecutivo_codifica = $postPago->getEjecutivoCodifica();
			$cve_pdv_codifica = $postPago->getCvePdvCodifica();
			$pdv_codifica = $postPago->getPdvCodifica();
			$fecha_codifica = $postPago->getFechaCodifica();
			$folio_codifica = $postPago->getFolioCodifica();
			$attuid_codifica = $postPago->getAttuidCodifica();
			$fecha_movimiento = $postPago->getFechaMovimiento();
			$dia = $postPago->getDia();
			$vpgm = $postPago->getVpgm();



			$sqlStr = "INSERT INTO tw_postpago (id_registro, id_layout, folio, no_contrato_impreso, id_orden_contratacion, fecha_contratacion, pricegroup, cuenta_cliente, nombre_cliente, tipo_persona, subtipo_persona, tipo_venta, status_orden, fecha_status_orden, empresa, cve_unica_pdv, nombre_pdv_unico, pdv_estatus, master_pdv, kam, cve_unica_ejecutivo, nombre_ejecutivo_unico, attuid_nivel_2, num_nivel_2, nombre_nivel_2, attuid_nivel_3, num_nivel_3, nombre_nivel_3, attuid_nivel_4, num_nivel_4, nombre_nivel_4, attuid_nivel_5, num_nivel_5, nombre_nivel_5, attuid_nivel_6, num_nivel_6, nombre_nivel_6, attuid_nivel_7, num_nivel_7, nombre_nivel_7, ventas, id_contrato, nir, mdn_inicial, propiedad, fecha_activacion, mes, semana_consejo, mdn_actual, fecha_mdn_actual, sim, imei, sku, modelo_equipo, marca_equipo, color_equipo, capacidad_equipo, modalidad, tecnologia, plan_tarifario_homo, plan_tarifario_homo2, plazo_forzoso, familia, marca_plan, renta,	nva_renta, accessfee_mens, nva_renta_sem, accessfee_seml, region, subregion, estado, ciudad_comercial, cve_mercado, mercado, vp,direccion_vta, agrupacion_canal, canal_vta, semana_recarga, fecha_primer_abono, monto_primer_abono, fecha_segundo_abono, monto_segundo_abono, mdn_definitivo, fecha_port_in, donador_in, receptor_in, fecha_port_out, donador_out, receptor_out, concesionado, es_control, es_t_next, es_volte, cve_ejecutivo_codifica, ejecutivo_codifica, cve_pdv_codifica, pdv_codifica, fecha_codifica,	folio_codifica, attuid_codifica, fecha_movimiento, dia, vpgm) VALUES (?,?,?,
				?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param(
					"sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",
					$id_registro, $id_layout, $folio, $no_contrato_impreso, $id_orden_contratacion, $fecha_contratacion, $pricegroup, 
					$cuenta_cliente, $nombre_cliente, $tipo_persona, $subtipo_persona, $tipo_venta, $status_orden, $fecha_status_orden, 
					$empresa, $cve_unica_pdv, $nombre_pdv_unico, $pdv_estatus, $master_pdv, $kam, $cve_unica_ejecutivo, 
					$nombre_ejecutivo_unico, $attuid_nivel_2, $num_nivel_2, $nombre_nivel_2, $attuid_nivel_3, $num_nivel_3, $nombre_nivel_3,
					$attuid_nivel_4, $num_nivel_4, $nombre_nivel_4, $attuid_nivel_5, $num_nivel_5, $nombre_nivel_5, $attuid_nivel_6, 
					$num_nivel_6, $nombre_nivel_6, $attuid_nivel_7, $num_nivel_7, $nombre_nivel_7, $ventas, $id_contrato, $nir, $mdn_inicial,
					$propiedad, $fecha_activacion, $mes, $semana_consejo, $mdn_actual, $fecha_mdn_actual, $sim, $imei, $sku, $modelo_equipo,
					$marca_equipo, $color_equipo, $capacidad_equipo, $modalidad, $tecnologia, $plan_tarifario_homo, $plan_tarifario_homo2,
					$plazo_forzoso, $familia, $marca_plan, $renta, $nva_renta, $accessfee_mens, $nva_renta_sem, $accessfee_seml, $region,
					$subregion, $estado, $ciudad_comercial, $cve_mercado, $mercado, $vp, $direccion_vta, $agrupacion_canal, $canal_vta,
					$semana_recarga, $fecha_primer_abono, $monto_primer_abono, $fecha_segundo_abono, $monto_segundo_abono, $mdn_definitivo,
					$fecha_port_in, $donador_in, $receptor_in, $fecha_port_out, $donador_out, $receptor_out, $concesionado, $es_control,
					$es_t_next, $es_volte, $cve_ejecutivo_codifica, $ejecutivo_codifica, $cve_pdv_codifica, $pdv_codifica, $fecha_codifica,
					$folio_codifica, $attuid_codifica, $fecha_movimiento, $dia, $vpgm
				);

				$prepare->execute();
				
				$postPago->setIdRegistro($this->getLink()->insert_id);
				$prepare->close();
			}
			mysqli_close($this->getLink());
			$returnValue = $postPago;
		}

		return $returnValue;
	}




	/**
	 * method: findPostPagoDAO()
	 * description: Search one record by id and return a PostPago Object
	 * params: <int>
	 * return <Object> PostPago
	 */
	public function findPostPagoDAO($idPostPago){
		$returnValue = NULL;
		if(isset($idPostPago)){
			$sqlStr = "SELECT * FROM tw_postpago WHERE id_registro=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("s", $idPostPago);
				$prepare->execute();
				$prepare->bind_result(
					$id_registro,$id_layout,$folio,$no_contrato_impreso,$id_orden_contratacion,$fecha_contratacion,$pricegroup,
					$cuenta_cliente,$nombre_cliente,$tipo_persona,$subtipo_persona,$tipo_venta,$status_orden,$fecha_status_orden,$empresa,
					$cve_unica_pdv,$nombre_pdv_unico,$pdv_estatus,$master_pdv,$kam,$cve_unica_ejecutivo,$nombre_ejecutivo_unico,
					$attuid_nivel_2,$num_nivel_2,$nombre_nivel_2,$attuid_nivel_3,$num_nivel_3,$nombre_nivel_3,$attuid_nivel_4,$num_nivel_4,
					$nombre_nivel_4,$attuid_nivel_5,$num_nivel_5,$nombre_nivel_5,$attuid_nivel_6,$num_nivel_6,$nombre_nivel_6,
					$attuid_nivel_7,$num_nivel_7,$nombre_nivel_7,$ventas,$id_contrato,$nir,$mdn_inicial,$propiedad,$fecha_activacion,$mes,
					$semana_consejo,$mdn_actual,$fecha_mdn_actual,$sim,$imei,$sku,$modelo_equipo,$marca_equipo,$color_equipo,
					$capacidad_equipo,$modalidad,$tecnologia,$plan_tarifario_homo,$plan_tarifario_homo2,$plazo_forzoso,$familia,
					$marca_plan,$renta,$nva_renta,$accessfee_mens,$nva_renta_sem,$accessfee_seml,$region,$subregion,$estado,
					$ciudad_comercial,$cve_mercado,$mercado,$vp,$direccion_vta,$agrupacion_canal,$canal_vta,$semana_recarga,
					$fecha_primer_abono,$monto_primer_abono,$fecha_segundo_abono,$monto_segundo_abono,$mdn_definitivo,$fecha_port_in,
					$donador_in,$receptor_in,$fecha_port_out,$donador_out,$receptor_out,$concesionado,$es_control,$es_t_next,$es_volte,
					$cve_ejecutivo_codifica,$ejecutivo_codifica,$cve_pdv_codifica,$pdv_codifica,$fecha_codifica,$folio_codifica,
					$attuid_codifica,$fecha_movimiento,$dia,$vpgm
				);
				$prepare->fetch();
				$postPagoObj = new PostPago();
				$postPagoObj->setIdRegistro($id_registro);
				$postPagoObj->setIDLayout($id_layout);
				$postPagoObj->setFolio($folio);
				$postPagoObj->setNoContatoImpreso($no_contrato_impreso);
				$postPagoObj->setIdOrdenContratacion($id_orden_contratacion);
				$postPagoObj->setFechaContratacion($fecha_contratacion);
				$postPagoObj->setPriceGroup($pricegroup);
				$postPagoObj->setCuentaCliente($cuenta_cliente);
				$postPagoObj->setNombreCliente($nombre_cliente);
				$postPagoObj->setTipoPersona($tipo_persona);
				$postPagoObj->setSubtipoPersona($subtipo_persona);
				$postPagoObj->setTipoVenta($tipo_venta);
				$postPagoObj->setStatusOrden($status_orden);
				$postPagoObj->setFechaStatusOrden($fecha_status_orden);
				$postPagoObj->setEmpresa($empresa);
				$postPagoObj->setCveUnicaPdv($cve_unica_pdv);
				$postPagoObj->setNombrePdvUnico($nombre_pdv_unico);
				$postPagoObj->setPdvEstatus($pdv_estatus);
				$postPagoObj->setMasterPdv($master_pdv);
				$postPagoObj->setKam($kam);
				$postPagoObj->setCveUnicaEjecutivo($cve_unica_ejecutivo);
				$postPagoObj->setNombreEjecutivoUnico($nombre_ejecutivo_unico);
				$postPagoObj->setAttuidNivel2($attuid_nivel_2);
				$postPagoObj->setNumNivel2($num_nivel_2);
				$postPagoObj->setNombreNivel2($nombre_nivel_2);
				$postPagoObj->setAttuidNivel3($attuid_nivel_3);
				$postPagoObj->setNumNivel3($num_nivel_3);
				$postPagoObj->setNombreNivel3($nombre_nivel_3);
				$postPagoObj->setAttuidNivel4($attuid_nivel_4);
				$postPagoObj->setNumNivel4($num_nivel_4);
				$postPagoObj->setNombreNivel4($nombre_nivel_4);
				$postPagoObj->setAttuidNivel5($attuid_nivel_5);
				$postPagoObj->setNumNivel5($num_nivel_5);
				$postPagoObj->setNombreNivel5($nombre_nivel_5);
				$postPagoObj->setAttuidNivel6($attuid_nivel_6);
				$postPagoObj->setNumNIvel6($num_nivel_6);
				$postPagoObj->setNombreNivel6($nombre_nivel_6);
				$postPagoObj->setAttuidNivel7($attuid_nivel_7);
				$postPagoObj->setNumNivel7($num_nivel_7);
				$postPagoObj->setNombreNivel7($nombre_nivel_7);
				$postPagoObj->setVentas($ventas);
				$postPagoObj->setIdContrato($id_contrato);
				$postPagoObj->setNir($nir);
				$postPagoObj->setMdnInicial($mdn_inicial);
				$postPagoObj->setPropiedad($propiedad);
				$postPagoObj->setFechaActivacion($fecha_activacion);
				$postPagoObj->setMes($mes);
				$postPagoObj->setSemanaConsejo($semana_consejo);
				$postPagoObj->setMdnActual($mdn_actual);
				$postPagoObj->setFechaMdnActual($fecha_mdn_actual);
				$postPagoObj->setSim($sim);
				$postPagoObj->setImei($imei);
				$postPagoObj->setSku($sku);
				$postPagoObj->setModeloEquipo($modelo_equipo);
				$postPagoObj->setMarcaEquipo($marca_equipo);
				$postPagoObj->setColorEquipo($color_equipo);
				$postPagoObj->setCapacidadEquipo($capacidad_equipo);
				$postPagoObj->setModalidad($modalidad);
				$postPagoObj->setTecnologia($tecnologia);
				$postPagoObj->setPlanTarifarioHomo($plan_tarifario_homo);
				$postPagoObj->setPlanTarifarioHomo2($plan_tarifario_homo2);
				$postPagoObj->setPlazoForzoso($plazo_forzoso);
				$postPagoObj->setFamilia($familia);
				$postPagoObj->setMarcaPlan($marca_plan);
				$postPagoObj->setRenta($renta);
				$postPagoObj->setNvaRenta($nva_renta);
				$postPagoObj->setAccessfeeMens($accessfee_mens);
				$postPagoObj->setNvaRentaSem($nva_renta_sem);
				$postPagoObj->setAccessfeeSeml($accessfee_seml);
				$postPagoObj->setRegion($region);
				$postPagoObj->setSubregion($subregion);
				$postPagoObj->setEstado($estado);
				$postPagoObj->setCiudadComercial($ciudad_comercial);
				$postPagoObj->setCveMercado($cve_mercado);
				$postPagoObj->setMercado($mercado);
				$postPagoObj->setVp($vp);
				$postPagoObj->setDireccionVta($direccion_vta);
				$postPagoObj->setAgrupacionCanal($agrupacion_canal);
				$postPagoObj->setCanalVta($canal_vta);
				$postPagoObj->setSemanaRecarga($semana_recarga);
				$postPagoObj->setFechaPrimerAbono($fecha_primer_abono);
				$postPagoObj->setMontoPrimerAbono($monto_primer_abono);
				$postPagoObj->setFechaSegundoAbono($fecha_segundo_abono);
				$postPagoObj->setMontoSegundoAbono($monto_segundo_abono);
				$postPagoObj->setMdnDefinitivo($mdn_definitivo);
				$postPagoObj->setFechaPortIn($fecha_port_in);
				$postPagoObj->setDonadorIn($donador_in);
				$postPagoObj->setReceptorIn($receptor_in);
				$postPagoObj->setFechaPortOut($fecha_port_out);
				$postPagoObj->setDonadorOut($donador_out);
				$postPagoObj->setReceptorOut($receptor_out);
				$postPagoObj->setConcesionado($concesionado);
				$postPagoObj->setEsControl($es_control);
				$postPagoObj->setEsTNext($es_t_next);
				$postPagoObj->setEsVolte($es_volte);
				$postPagoObj->setCveEjecutivoCodifica($cve_ejecutivo_codifica);
				$postPagoObj->setEjecutivoCodifica($ejecutivo_codifica);
				$postPagoObj->setCvePdvCodifica($cve_pdv_codifica);
				$postPagoObj->setPdvCodifica($pdv_codifica);
				$postPagoObj->setFechaCodifica($fecha_codifica);
				$postPagoObj->setFolioCodifica($folio_codifica);
				$postPagoObj->setAttuidCodifica($attuid_codifica);
				$postPagoObj->setFechaMovimiento($fecha_movimiento);
				$postPagoObj->setDia($dia);
				$postPagoObj->setVpgm($vpgm);

				$prepare->close();
				$returnValue = $postPagoObj;
			}
		}
		mysqli_close($this->getLink());
		return $returnValue;
	}


	public function findAllPostPagoDAO(){
		$returnValue = NULL;
		$arraypostPago = array();
		$sqlStr = "SELECT * FROM tw_postpago";
		$prepare = $this->getLink()->query($sqlStr))
		if(mysql_num_rows($Layouts)!=0)

		
		mysqli_close($this->getLink());
		return $returnValue;
	}


}
?>