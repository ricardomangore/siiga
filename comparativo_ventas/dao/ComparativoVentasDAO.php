<?php

require_once('/../includes/Connect.php');
require_once('/../pojos/PostPago.php');

class ComparativoVentasDAO extends Connect{
	/**
	 * Determina si ounb objeto PostPago es igual a un registro de ventas dentro del SIIGA
	 * a partir del folio, IMEI y Nombre del Punto de Venta registrado en ATT
	 * @param <Object> PostPago
	 * @return <boolean>
	 */
	public function comparePostPagoByNombrePDV($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$nombrePdv = $postPago->getNombrePdvUnico();
			$sqlStr="SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN PuntosATT ON HFolios.PuntoventaId=PuntosATT.PuntoVentaId WHERE HFolios.Folio LIKE ? AND LFolios.Serie=? AND PuntosATT.NombreATT=?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$nombrePdv);
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

	/*public function comparePostPagoBySim($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PostPago')){
			$folio = $postPago->getFolio();
			$sim = $posPago->getSim();

		}
		return $returnValue;
	}*/

	public function comparePostPagoByTipoVenta($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PsotPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$tipoVenta = $postPago->getTipoVenta();
			$sqlStr= 'SELECT HFolios.Folio FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN TiposContratacion ON HFolios.TipoContratacionId=TiposContratacion.TipoContratacionId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? aND TiposContratacion.Tipocontratacion LIKE ?';
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$tipoVenta);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				var_dump($param);

				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}

	public function comparePostPagoByNombreEjecutivo($postPago){
		$returnValue = FALSE;
		if(isset($postPago) && is_a($postPago,'PsotPago')){
			$folio = $postPago->getFolio();
			$imei = $postPago->getImei();
			$tipoVenta = $postPago->getNombreEjecutivoUnico();
			$sqlStr= "SELECT Empleados.Nombre FROM Usuarios INNER JOIN Empleados ON Empleados.EmpleadoId=Usuarios.EmpleadoId WHERE Usuarios.UsuarioId=(SELECT HFolios.UsuarioId FROM HFolios INNER JOIN LFolios ON HFolios.Folio=LFolios.Folio INNER JOIN Usuarios ON HFolios.UsuarioId=Usuarios.UsuarioId INNER JOIN Empleados ON Usuarios.EmpleadoId=Empleados.EmpleadoId WHERE HFolios.Folio LIKE ? AND LFolios.Serie = ? ) AND CONCAT(Empleados.Nombre,' ',Empleados.Paterno,' ',Empleados.Materno) LIKE ?";
			if($prepare = $this->getLink()->prepare($sqlStr)){
				$prepare->bind_param('sss',$folio,$imei,$tipoVenta);
				$prepare->execute();
				$prepare->bind_result($param);
				$prepare->fetch();

				var_dump($param);

				$prepare->close();
				if($param != ''){
					$returnValue = TRUE;
				}
			}else{
				throw new Exception("No se puedo preparar la consulta");
			}

		}
		return $returnValue;
	}

}