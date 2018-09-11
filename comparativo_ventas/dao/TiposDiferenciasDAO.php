<?php
include_once('comparativo_ventas/includes/Connect.php');
include_once('comparativo_ventas/pojos/TiposDiferencias.php');

class TiposDiferenciasDAO extends Connect{

	/**
	 * Recupera en un arreglo todos los tipos de Diferencias
	 * desde la tabla tc_tipos_diferencias
	 * @return <array> TiposDiferencias
	 */
	public function getTiposDiferenciasList(){
		$returnValue = NULL;
		$sqlStr = "SELECT * FROM tc_tipos_diferencias";
		if($result = $this->getLink()->query($sqlStr)){
			$returnValue = array();
			while($obj = $result->fetch_object()){
				array_push($returnValue, $obj);
			}
		}
		//mysqli_close($this->getLink());
		return $returnValue;
	}

	/**
	 * Búsca un tipo de diferencai por su id_tipo_diferencia
	 * @param <integer> $id 
	 * @return <object> TiposDiferencias
	 */
	public function findTipoDiferencia($id){
		$returnValue = NULL;
		$sqlStr = 'SELECT * FROM tc_tipos_diferencias WHERE id_tipo_diferencia=?';
		if($prepare = $this->getLink()->prepare($sqlStr)){
			$prepare->bind_param("s", $id);
			$prepare->execute();
			$prepare->bind_result($param1, $param2, $param3);
			$result = $prepare->fetch();
			$tipoDiferencia = new TiposDiferencias();
			$tipoDiferencias = new TiposDiferencias();
			$tipoDiferencias->setIdTipoDiferencia($param1);
			$tipoDiferencias->setTipoDiferencia($param2);
			$tipoDiferencias->setActivo($param3);
			$prepare->close();
			$returnValue = $tipoDiferencias;
		}
		//mysqli_close($this->getLink());
		return $returnValue;
	}


}