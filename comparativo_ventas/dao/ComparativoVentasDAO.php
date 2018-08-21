<?php

require_once('/../includes/Connect.php');
require_once('/../pojos/PostPago.php');

class ComparativoVentasDAO extends Connect{

	public function nombrePdvCompareByFolioImei($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$folioLike = "'%".$folio."%'";
				$prepare->bind_param('ss',$folioLike,$imei);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();
				
				var_dump($prepare->error);

				if($param!=''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception('No se puedo ejecutar la consulta');
			}
		}

		return $returnValue;
	}

	public function nombrePdvCompareByFolioSim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $posPago->getSim();

		}
		return $returnValue;
	}

}