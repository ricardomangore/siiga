<?php

include_once "/../../includes/Conectar.php";
include_once "/../pojos/Layout.php";

class LayoutDAO extends Conectar{
	
	/*public function list(){
		$layout = new Layout();
		$sqlStr = 'SELECT * FROM tw_layout';
		$Query=mysql_query("$sqlStr", $this->conexion) or die("Error al Consultar: $sql ".mysql_error());
		return $Query;
		return "hello";
	}*/

	public function layoutList(){$layout = new Layout();
		$array_layout = array();
		$sqlStr = 'SELECT * FROM tw_layout';
		$object = NULL; 
		$Layouts=mysql_query("$sqlStr", $this->conexion);// or die("Error al Consultar: $sql ".mysql_error());
		//$object = $Layouts;
		if(mysql_num_rows($Layouts)!=0){
			$layoutObj = new Layout();
			while($fila =mysql_fetch_array($Layouts)){
				$layoutObj->setIdLayout($fila[0]);
				$layoutObj->setIdUsuario($fila[1]);
				$layoutObj->setFecha($fila[2]);
				$layoutObj->setHora($fila[3]);
				$layoutObj->setIdTipoLayout($fila[4]);
			}
			$object = $layoutObj;
		}
		
		/*while(mysql_fetch_array($Layouts)){
			array_push($array_layout, $layout);
		}*/
		return $object;
	}
	

}

?>