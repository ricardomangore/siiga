<?php

include_once('comparativo_ventas/includes/Connect.php');
include_once('comparativo_ventas/pojos/TiposLayout.php');

class TiposLayoutDAO extends Connect{

	public function saveTipoLayoutDAO($tipoLayout){
		$returnValue = NULL;
		if(isset($tipoLayout) && is_a($tipoLayout,'TiposLayout')){
			$tipo_layout = $tipoLayout->getTipoLayout();
			$activo = $tipoLayout->getActivo();
			$sqlStr = "INSERT INTO tc_tipos_layout (tipo_layout, activo) VALUES (?,?)";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param("ss", $tipo_layout,$activo);
				$prepare->execute();
				$tipoLayout->setIdTipoLayout($this->getLink()->insert_id);
				$prepare->close();
			}
			mysqli_close($this->getLink());
			$returnValue = $tipoLayout;
		}

		return $returnValue;

	}

}