<?php
require_once ('/../includes/Connect.php');
require_once ("/../pojos/Diferencias.php");

class DiferenciasDAO extends Connect{

	public function saveDiferenciasDAO($diferenciasDAO){
		$returnValue = NULL;
		if(isset($diferenciasDAO) && is_a($diferenciasDAO,'Diferencias')){
			$id_registro = $diferenciasDAO->getIdRegistro();
			$id_tipo_diferencia = $diferenciasDAO->getIdTipoDiferencia();
			$sqlStr = "INSERT INTO tw_diferencias(id_registro,id_tipo_diferencia) VALUES (?,?)";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param($id_registro,$id_tipo_diferencia);
				$prepare->execute();
				$prepare->close();
			}else{
				throw new Exception("No se pudo preparar la consulta");
			}
			mysqli_close($this->getLink());
			$returnValue = $diferenciasDAO;
		}else{
			throw new Exception("El objeto esta vacio/el objeto no es del tipo correcto");
		}
		return $returnValue;
	}


	public function findDiferenciasDAO($idDiferencias, $idTipoDiferencia){
		$returnValue = NULL;
		if(isset($idDiferencias) && isset($idTipoDiferencia)){
			$sqlStr = "SELECT * FROM tw_diferencias WHERE id_registro=? AND id_tipo_diferencia=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ss", $idDiferencias,$idTipoDiferencia);
				$prepare->execute();
				$prepare->bind_result($id_registro, $id_tipo_diferencia);
				$prepare->fetch();
			}else{
				throw new Exception("No se pudo preparar la consulta");
			}
		}else{
			throw new Exception("los datos idDiferencias e idTipoDiferencia nos pueden ir vacios");
		}
	}


}

?>