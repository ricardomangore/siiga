<?php
require_once ('/../includes/Connect.php');
require_once ("/../pojos/Diferencias.php");

class DiferenciasDAO extends Connect{



	/**
	 * method: saveDiferenciasDAO()
	 * description: Return a Diferencias Object after insert new record in tw_diferencias table
	 * params: <Object> PostPago
	 * return <Object> PostPago
	 */
	public function saveDiferenciasDAO($diferenciasDAO){
		$returnValue = NULL;
		if(isset($diferenciasDAO) && is_a($diferenciasDAO,'Diferencias')){
			$id_registro = $diferenciasDAO->getIdRegistro();
			$id_tipo_diferencia = $diferenciasDAO->getIdTipoDiferencia();
			$sqlStr = "INSERT INTO tw_diferencias(id_registro,id_tipo_diferencia) VALUES (?,?)";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ss",$id_registro,$id_tipo_diferencia);
				$prepare->execute();
				$prepare->close();
			}
			mysqli_close($this->getLink());
			$returnValue = $diferenciasDAO;
		}
		return $returnValue;
	}



	/**
	 * method: findDiferenciasDAO()
	 * description: Search one record by id and return a Diferencias Object
	 * params: <int,int>
	 * return <Object> PostPago
	 */
	public function findDiferenciasDAO($idDiferencias, $idTipoDiferencia){
		$returnValue = NULL;
		if(isset($idDiferencias) && isset($idTipoDiferencia)){
			$sqlStr = "SELECT * FROM tw_diferencias WHERE id_registro=? AND id_tipo_diferencia=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ss", $idDiferencias,$idTipoDiferencia);
				$prepare->execute();
				$prepare->bind_result($param1, $param2);
				$prepare->fetch();
				$diferenciasObj = new Diferencias();
				$diferenciasObj->setIdRegistro($param1);
				$diferenciasObj->setIdTipoDiferencia($param2);
				$prepare->close();
				$returnValue = $diferenciasObj;
			}
		}
		mysqli_close($this->getLink());
		return $returnValue;
	}



	/**
	 * method: findAllDiferenciasDAO()
	 * description: Search all records in tw_diferencias table
	 * params: <>
	 * return array<Object> Diferencias
	 */
	public function findAllDiferenciasDAO(){
		$returnValue = NULL;
		$arrayDiferencias = array();
		$sqlStr = "SELECT * FROM tw_diferencias";
		$prepare = $this->getLink()->query($sqlStr);
		if($prepare->num_rows != 0){
			while($fila = $prepare->fetch_array(MYSQLI_NUM)){
				$diferenciaObj = new Diferencias();
				$diferenciaObj->setIdRegistro($fila[0]);
				$diferenciaObj->setIdTipoDiferencia($fila[1]);
				array_push($arrayDiferencias, $diferenciaObj);
			}
			$returnValue = $arrayDiferencias;
		}
		mysqli_close($this->getLink());
		return $returnValue;
	}


}

?>