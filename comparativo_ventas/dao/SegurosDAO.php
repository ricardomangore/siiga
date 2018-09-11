<?php
include_once('comparativo_ventas/includes/Connect.php');
include_once('comparativo_ventas/pojos/Seguros.php');

class SegurosDAO extends Connect{

	public function saveSeguro($seguroObj){
		$returnValue = NULL;
		if(isset($seguroObj) && is_a($seguroObj,'Seguros')){
			//Procesa el Obejto $segur = 
			$id_layout = $seguroObj->getIdLayout();
			$id_contrato = $seguroObj->getIdContrato();
			$sncode = $seguroObj->getSnCode();
			$seguro = $seguroObj->getSeguro();
			$renta = $seguroObj->getRenta();
			$fecha_act_seg = $seguroObj->getFechaActSeg();
			$id_contrato2 = $seguroObj->getIdContrato2();
			$cuenta_cliente = $seguroObj->getCuentaCliente();
			$estatus_act_seg = $seguroObj->getEstatusActSeg();
			$fecha_ultmod_seg = $seguroObj->getFechaUltmodSeg();
			$empresa = $seguroObj->getEmpresa();
			$order_id = $seguroObj->getOrderId();
			$order_action_id = $seguroObj->getOrderActionId();
			$order_status_description = $seguroObj->getOrderStatusDescription();
			$cve_unica_pdv = $seguroObj->getCveUnicaPdv();
			$nombre_pdv_unico = $seguroObj->getNombrePdvUnico();
			$pdv_estatus = $seguroObj->getPdvEstatus();
			$master_pdv = $seguroObj->getMasterPdv();
			$kam = $seguroObj->getKam();
			$cve_unica_ejecutivo = $seguroObj->getCveUnicaEjecutivo();
			$nombre_ejecutivo_unico = $seguroObj->getNombreEjecutivoUnico();
			$attuid_nivel_2 = $seguroObj->getAttuidNivel2();
			$num_nivel_2 = $seguroObj->getNumNivel2();
			$nombre_nivel_2 = $seguroObj->getNombreNivel2();
			$attuid_nivel_3 = $seguroObj->getAttuidNivel3();
			$num_nivel_3 = $seguroObj->getNumNivel3();
			$nombre_nivel_3 = $seguroObj->getNombreNivel3();
			$attuid_nivel_4 = $seguroObj->getAttuidNivel4();
			$num_nivel_4 = $seguroObj->getNumNivel4();
			$nombre_nivel_4 = $seguroObj->getNombreNivel4();
			$attuid_nivel_5 = $seguroObj->getAttuidNivel5();
			$num_nivel_5 = $seguroObj->getNumNivel5();
			$nombre_nivel_5 = $seguroObj->getNombreNivel5();
			$attuid_nivel_6 = $seguroObj->getAttuidNivel6();
			$num_nivel_6 = $seguroObj->getNumNivel6();
			$nombre_nivel_6 = $seguroObj->getNombreNivel6();
			$attuid_nivel_7 = $seguroObj->getAttuidNivel7();
			$num_nivel_7 = $seguroObj->getNumNivel7();
			$nombre_nivel_7 = $seguroObj->getNombreNivel7();
			$ventas = $seguroObj->getVentas();
			$fecha_act_contr = $seguroObj->getFechaActContr();
			$mdn = $seguroObj->getMdn();
			$mes = $seguroObj->getMes();
			$semana_consejo = $seguroObj->getSemanaConsejo();
			$sku = $seguroObj->getSku();
			$modelo_equipo = $seguroObj->getModeloEquipo();
			$marca_equipo = $seguroObj->getMarcaEquipo();
			$color_equipo = $seguroObj->getColorEquipo();
			$capacidad_equipo = $seguroObj->getCapacidadEquipo();
			$plan_tarifario_origen = $seguroObj->getPlanTarifarioOrigen();
			$plan_tarifario_final = $seguroObj->getPlantarifariofinal();
			$familia = $seguroObj->getFamilia();
			$marca_plan = $seguroObj->getMarcaPlan();
			$region = $seguroObj->getRegion();
			$subregion = $seguroObj->getSubregion();
			$estado = $seguroObj->getEstado();
			$ciudad_comercial = $seguroObj->getCiudadComercial();
			$cve_mercado = $seguroObj->getCveMercado();
			$mercado = $seguroObj->getMercado();
			$vp = $seguroObj->getVp();
			$direccion_vta = $seguroObj->getDireccionVta();
			$agrupacion_canal = $seguroObj->getAgrupacionCanal();
			$canal_vta = $seguroObj->getCanalVta();
			$vpgm =$seguroObj->getVpgm();

			$sqlStr  = "INSERT INTO tw_seguros (";
			$sqlStr .= "id_layout,";
			$sqlStr .= "id_contrato,";
			$sqlStr .= "sncode,";
			$sqlStr .= "seguro,";
			$sqlStr .= "renta,";
			$sqlStr .= "fecha_act_seg,";
			$sqlStr .= "id_contrato2,";
			$sqlStr .= "cuenta_cliente,";
			$sqlStr .= "estatus_act_seg,";
			$sqlStr .= "fecha_ultmod_seg,";
			$sqlStr .= "empresa,";
			$sqlStr .= "order_id,";
			$sqlStr .= "order_action_id,";
			$sqlStr .= "order_status_description,";
			$sqlStr .= "cve_unica_pdv,";
			$sqlStr .= "nombre_pdv_unico,";
			$sqlStr .= "pdv_estatus,";
			$sqlStr .= "master_pdv,";
			$sqlStr .= "kam,";
			$sqlStr .= "cve_unica_ejecutivo,";
			$sqlStr .= "nombre_ejecutivo_unico,";
			$sqlStr .= "attuid_nivel_2,";
			$sqlStr .= "num_nivel_2,";
			$sqlStr .= "nombre_nivel_2,";
			$sqlStr .= "attuid_nivel_3,";
			$sqlStr .= "num_nivel_3,";
			$sqlStr .= "nombre_nivel_3,";
			$sqlStr .= "attuid_nivel_4,";
			$sqlStr .= "num_nivel_4,";
			$sqlStr .= "nombre_nivel_4,";
			$sqlStr .= "attuid_nivel_5,";
			$sqlStr .= "num_nivel_5,";
			$sqlStr .= "nombre_nivel_5,";
			$sqlStr .= "attuid_nivel_6,";
			$sqlStr .= "num_nivel_6,";
			$sqlStr .= "nombre_nivel_6,";
			$sqlStr .= "attuid_nivel_7,";
			$sqlStr .= "num_nivel_7,";
			$sqlStr .= "nombre_nivel_7,";
			$sqlStr .= "ventas,";
			$sqlStr .= "fecha_act_contr,";
			$sqlStr .= "mdn,";
			$sqlStr .= "mes,";
			$sqlStr .= "semana_consejo,";
			$sqlStr .= "sku,";
			$sqlStr .= "modelo_equipo,";
			$sqlStr .= "marca_equipo,";
			$sqlStr .= "color_equipo,";
			$sqlStr .= "capacidad_equipo,";
			$sqlStr .= "plan_tarifario_origen,";
			$sqlStr .= "plan_tarifario_final,";
			$sqlStr .= "familia,";
			$sqlStr .= "marca_plan,";
			$sqlStr .= "region,";
			$sqlStr .= "subregion,";
			$sqlStr .= "estado,";
			$sqlStr .= "ciudad_comercial,";
			$sqlStr .= "cve_mercado,";
			$sqlStr .= "mercado,";
			$sqlStr .= "vp,";
			$sqlStr .= "direccion_vta,";
			$sqlStr .= "agrupacion_canal,";
			$sqlStr .= "canal_vta,";
			$sqlStr .= "vpgm) ";
			$sqlStr .= "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
			if($prepare=$this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss",$id_layout,$id_contrato,$sncode,$seguro,$renta,$fecha_act_seg,$id_contrato2,$cuenta_cliente,$estatus_act_seg,$fecha_ultmod_seg,$empresa,$order_id,$order_action_id,$order_status_description,$cve_unica_pdv,$nombre_pdv_unico,$pdv_estatus,$master_pdv,$kam,$cve_unica_ejecutivo,$nombre_ejecutivo_unico,$attuid_nivel_2,$num_nivel_2,$nombre_nivel_2,$attuid_nivel_3,$num_nivel_3,$nombre_nivel_3,$attuid_nivel_4,$num_nivel_4,$nombre_nivel_4,$attuid_nivel_5,$num_nivel_5,$nombre_nivel_5,$attuid_nivel_6,$num_nivel_6,$nombre_nivel_6,$attuid_nivel_7,$num_nivel_7,$nombre_nivel_7,$ventas,$fecha_act_contr,$mdn,$mes,$semana_consejo,$sku,$modelo_equipo,$marca_equipo,$color_equipo,$capacidad_equipo,$plan_tarifario_origen,$plan_tarifario_final,$familia,$marca_plan,$region,$subregion,$estado,$ciudad_comercial,$cve_mercado,$mercado,$vp,$direccion_vta,$agrupacion_canal,$canal_vta,$vpgm);
				$prepare->execute();
				$seguroObj->setIdRegistro($this->getLink()->insert_id);
				$prepare->close();
				//mysqli_close($this->getLink());
				$returnValue = $seguroObj;

			}else{//Si la consulta preparada falla
				var_dump($this->getLink()->error);
				throw new Exception('No se pudo preparar la consulta');
			}
		}//Concluye validacion del tipo de parametro recibido

		return $returnValue;
	}//Termina el metodo saveSeguro()



	public function findSegurosByIdlayout($idLayout){
		$returnValue = NULL;
		$arraySeguros = array();
		$sqlStr = "SELECT * FROM tw_seguros WHERE id_layout = ".$idLayout;
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$seguroObj = new Seguros();
				$seguroObj->setIdRegistro($fila[0]);
				$seguroObj->setIdLayout($fila[1]);
				$seguroObj->setIdContrato($fila[2]);
				$seguroObj->setSnCode($fila[3]);
				$seguroObj->setSeguro($fila[4]);
				$seguroObj->setRenta($fila[5]);
				$seguroObj->setFechaActSeg($fila[6]);
				$seguroObj->setIdContrato2($fila[7]);
				$seguroObj->setCuentaCliente($fila[8]);
				$seguroObj->setEstatusActSeg($fila[9]);
				$seguroObj->setFechaUltmodSeg($fila[10]);
				$seguroObj->setEmpresa($fila[11]);
				$seguroObj->setOrderId($fila[12]);
				$seguroObj->setOrderActionId($fila[13]);
				$seguroObj->setOrderStatusDescription($fila[14]);
				$seguroObj->setCveUnicaPdv($fila[15]);
				$seguroObj->setNombrePdvUnico($fila[16]);
				$seguroObj->setPdvEstatus($fila[17]);
				$seguroObj->setMasterPdv($fila[18]);
				$seguroObj->setKam($fila[19]);
				$seguroObj->setCveUnicaEjecutivo($fila[20]);
				$seguroObj->setNombreEjecutivoUnico($fila[21]);
				$seguroObj->setAttuidNivel2($fila[22]);
				$seguroObj->setNumNivel2($fila[23]);
				$seguroObj->setNombreNivel2($fila[24]);
				$seguroObj->setAttuidNivel3($fila[25]);
				$seguroObj->setNumNivel3($fila[26]);
				$seguroObj->setNombreNivel3($fila[27]);
				$seguroObj->setAttuidNivel4($fila[28]);
				$seguroObj->setNumNivel4($fila[29]);
				$seguroObj->setNombreNivel4($fila[30]);
				$seguroObj->setAttuidNivel5($fila[31]);
				$seguroObj->setNumNivel5($fila[32]);
				$seguroObj->setNombreNivel5($fila[33]);
				$seguroObj->setAttuidNivel6($fila[34]);
				$seguroObj->setNumNivel6($fila[35]);
				$seguroObj->setNombreNivel6($fila[36]);
				$seguroObj->setAttuidNivel7($fila[37]);
				$seguroObj->setNumNivel7($fila[38]);
				$seguroObj->setNombreNivel7($fila[39]);
				$seguroObj->setVentas($fila[40]);
				$seguroObj->setFechaActContr($fila[41]);
				$seguroObj->setMdn($fila[42]);
				$seguroObj->setMes($fila[43]);
				$seguroObj->setSemanaConsejo($fila[44]);
				$seguroObj->setSku($fila[45]);
				$seguroObj->setModeloEquipo($fila[46]);
				$seguroObj->setMarcaEquipo($fila[47]);
				$seguroObj->setColorEquipo($fila[48]);
				$seguroObj->setCapacidadEquipo($fila[49]);
				$seguroObj->setPlanTarifarioOrigen($fila[50]);
				$seguroObj->setPlanTarifarioFinal($fila[51]);
				$seguroObj->setFamilia($fila[52]);
				$seguroObj->setMarcaPlan($fila[53]);
				$seguroObj->setRegion($fila[54]);
				$seguroObj->setSubregion($fila[55]);
				$seguroObj->setEstado($fila[56]);
				$seguroObj->setCiudadComercial($fila[57]);
				$seguroObj->setCveMercado($fila[58]);
				$seguroObj->setMercado($fila[59]);
				$seguroObj->setVp($fila[60]);
				$seguroObj->setDireccionVta($fila[61]);
				$seguroObj->setAgrupacionCanal($fila[62]);
				$seguroObj->setCanalVta($fila[63]);
				$seguroObj->setVpgm($fila[64]);
				array_push($arraySeguros, $seguroObj);
			}//Termina WHILE
			$returnValue = $arraySeguros;
		}//Termina IF
		return $returnValue;
	}//Termina metodo findSegurosByIdlayout()


}//TErmian la clase SegurosDAO

?>