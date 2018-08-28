<?php

include_once "siiga/includes/Conectar.php";
include_once "siiga/comparativo_ventas/pojos/Layout.php";

class LayoutDAO extends Conectar{

	protected $table_name = 'tw_layout';

	/**
	 * method: getLayoutList()
	 * description: Return a Layout Objects List
	 * params: 
	 * return <Array> List
	 */
	public function getLayoutList(){
		$layout = new Layout();
		$array_layout = array();
		$sqlStr = 'SELECT * FROM tw_layout';
		$object = NULL; 
		$Layouts=mysql_query("$sqlStr", $this->conexion);
		if(mysql_num_rows($Layouts)!=0){
			
			while($fila =mysql_fetch_array($Layouts)){
				$layoutObj = new Layout();
				$layoutObj->setIdLayout($fila[0]);
				$layoutObj->setIdUsuario($fila[1]);
				$layoutObj->setFecha($fila[2]);
				$layoutObj->setHora($fila[3]);
				$layoutObj->setIdTipoLayout($fila[4]);
				array_push($array_layout, $layoutObj);
			}
			$object = $array_layout;
		}
		return $object;
	}


	/**
	 * method: saveLayout()
	 * description: Save a layout record in the tw_layout table in Data Base
	 * params: <Object> Layout
	 * return <Boolean>
	 */
	public function saveLayout($layout){
		$returnValue = NULL;
		if(isset($layout) && is_a($layout,'Layout'))
			if($layout->isEmpty()){
				$idUsuario = $layout->getIdUsuario();
				$fecha = $layout->getFecha();
				$hora = $layout->getHora();
				$idTipoLayout = $layout->getIdTipoLayout();
				$sqlStr = "INSERT INTO tw_layout (id_usuario,fecha,hora,id_tipo_layout) VALUES ($idUsuario,'" . $fecha . "', '" . $hora . "' ,$idTipoLayout)";
				$isInsert = mysql_query("$sqlStr", $this->conexion);
			
				if(!$isInsert){
					$returnValue = $isInsert;
					throw new Exception('no se pudo insertar');
				}else{
					$idLayout = mysql_insert_id();
					$layout->setIdLayout($idLayout);
					$returnValue = $layout;
				}
				return $returnValue;
			}else{
				throw new Exception('El Objecto esta vacio');
			}
		else
			return $returnValue;
	}


	/**
	 * method: findLayout()
	 * description: Find a layout in the tw_layout table in Data Base
	 * params: <int> 
	 * return <Object> Layout
	 */
	public function findLayout($idLayout){
		$returnValue = NULL;
		if(isset($idLayout)){
			$sqlStr = "SELECT * FROM tw_layout WHERE id_layout=" . $idLayout;
			$isSelect = mysql_query("$sqlStr",$this->conexion);
			if(mysql_num_rows($isSelect)!=0){
				$layout = mysql_fetch_array($isSelect);
				$layoutObj = new Layout();
				$layoutObj->setIdLayout($layout[0]);
				$layoutObj->setIdUsuario($layout[1]);
				$layoutObj->setFecha($layout[2]);
				$layoutObj->setHora($layout[3]);
				$layoutObj->setIdTipoLayout($layout[4]);
				$returnValue = $layoutObj;
			}
		}else{
			throw new Exception("El id del layout esta vacio");
		}
		return $returnValue;
	}


	/**
	 * method: updateLayout()
	 * description: Update a record in the tw_layout table in Data Base
	 * params: <Objet> Layout 
	 * return <Boolean> 
	 */
	public function updateLayout($layout){
		$returnValue = FALSE;
		if(isset($layout) && is_a($layout,'Layout')){
			if($layout->isEmpty()){
				$idLayout = $layout->getIdLayout();
				$idUsuario = $layout->getIdUsuario();
				$fecha = $layout->getFecha();
				$hora = $layout->getHora();
				$idTipoLayout = $layout->getIdTipoLayout();
				$sqlStr = "UPDATE tw_layout SET id_usuario=$idUsuario,fecha='" . $fecha . "',hora='" . $hora . "',id_tipo_layout=$idTipoLayout WHERE id_layout=$idLayout";
				$isUpdate = mysql_query("$sqlStr", $this->conexion);
				$returnValue = $isUpdate;
				if(!$returnValue){
					throw new Exception("No se pudo actualizar");
				}
			}else{
				throw new Exception("El objeto esta vacio");
			}
		}else{
			return $returnValue;
		}
	}
	

}

?>