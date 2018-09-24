<?php
	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include_once ("comparativo_ventas/controllers/PostpagoController.php");
	include_once ("comparativo_ventas/controllers/SegurosController.php");
	include_once ("comparativo_ventas/controllers/RenovacionesController.php");
	include_once ("comparativo_ventas/controllers/TransferController.php");
	include_once ("comparativo_ventas/includes/Validator.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");

	$Herramientas= new Tools($_SESSION['UsuarioId']);

$Opc=$_REQUEST['Opc'];

/*Opcion para realizar exclusivamente el comparativo ventas*/

$datoId = $_REQUEST['DatoId'];
if($datoId == 5)
	$Opc = '11';
if($datoId == 8)/*<<<--- cabiar a 7 si es asi, en mi local asi se agrego*/
	$Opc = '12';
if($datoId == 9)
	$Opc = '13';
if($datoId == 6)
	$Opc = '14';

/***********************************************************/

switch ($Opc) {
	case '1':
				$Clave=$_REQUEST['Clave'];
				$DatoId=$_REQUEST['DatoId'];
				$return = Array('ok'=>TRUE);
				$upload_folder ='FilesTmp';
				$nombre_archivo = $Clave;
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo;

				if (!move_uploaded_file($tmp_archivo, $archivador))
				{
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}
				else
					echo $Herramientas->cargarDatos($DatoId, $Clave);
		break;
	case '2':
				$upload_folder ='FacturasDoc';
				$nombre_archivo = $_REQUEST['Factura'];
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo.$_REQUEST['ext'];
				$miFile=$nombre_archivo.$_REQUEST['ext'];

				if (move_uploaded_file($tmp_archivo, $archivador))
				{
					echo $Herramientas->addRecepcion($_REQUEST['PuntoVentaId'], $_REQUEST['Factura'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], 46, $miFile);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}


		break;
	case '3':
				$upload_folder ='Avisos';
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext'];

				if (move_uploaded_file($tmp_archivo, $archivador))
				{
					echo $Herramientas->addAviso($_REQUEST['titulo'], $_REQUEST['aviso'], $archivador, $_REQUEST['Clasificacion'], $_REQUEST['FInicio'], $_REQUEST['FFin']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}
		break;
	case '4':
				$upload_folder ='DocBuro';
				$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].'1'.$_REQUEST['ext1'];

				$tmp_archivo2 = $_FILES['archivo2']['tmp_name'];
				$archivador2 = $upload_folder . '/' . $_REQUEST['clave'].'2'.$_REQUEST['ext2'];

				if (move_uploaded_file($tmp_archivo1, $archivador1) & move_uploaded_file($tmp_archivo2, $archivador2))
				{
					echo $Herramientas->addRevisionBuro($_REQUEST['TipoPersonaId'], $_REQUEST['NombreC'], $_REQUEST['PaternoC'],
						$_REQUEST['MaternoC'], $_REQUEST['RFCC'], $_REQUEST['TLocal'], $_REQUEST['TMovil'],
						$_REQUEST['Calle'], $_REQUEST['NExterior'], $_REQUEST['NInterior'], $_REQUEST['ColoniaId'],
						$archivador1, $archivador2);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}
		break;
	case '5':
				$upload_folder ='Depositos';
				$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext1'];

				if (move_uploaded_file($tmp_archivo1, $archivador1))
				{
				echo $Herramientas->addDeposito($_REQUEST['Deposito'], $_REQUEST['FechaHora'], $_REQUEST['TipoDepositoId'], $_REQUEST['Monto'], $archivador1, $_REQUEST['Comentarios'], $_REQUEST['PuntoVentaId']);
				}
		break;
	case '6':
				$upload_folder ='Validaciones';
				$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].'1'.$_REQUEST['ext1'];

				$tmp_archivo2 = $_FILES['archivo2']['tmp_name'];
				$archivador2 = $upload_folder . '/' . $_REQUEST['clave'].'2'.$_REQUEST['ext2'];

				$tmp_archivo3 = $_FILES['archivo3']['tmp_name'];
				$archivador3 = $upload_folder . '/' . $_REQUEST['clave'].'3'.$_REQUEST['ext3'];

				$tmp_archivo4 = $_FILES['archivo4']['tmp_name'];
				$archivador4 = $upload_folder . '/' . $_REQUEST['clave'].'4'.$_REQUEST['ext4'];

				$tmp_archivo5 = $_FILES['archivo5']['tmp_name'];
				$archivador5 = $upload_folder . '/' . $_REQUEST['clave'].'5'.$_REQUEST['ext5'];

				if (move_uploaded_file($tmp_archivo1, $archivador1) & move_uploaded_file($tmp_archivo2, $archivador2) & move_uploaded_file($tmp_archivo3, $archivador3) & move_uploaded_file($tmp_archivo4, $archivador4) & move_uploaded_file($tmp_archivo5, $archivador5))
				{
					echo $Herramientas->addValidacion ($_REQUEST['Folio'], $archivador1, $archivador2, $archivador3, $_REQUEST['Observacion'], $_REQUEST['Nombre'], $_REQUEST['Paterno'], $_REQUEST['Materno'], $_REQUEST['PuntoVentaId'],$_REQUEST['DescEquipos'],$_REQUEST['DescPlanes'],$_REQUEST['Telefono'], $archivador4, $archivador5,$_REQUEST['Calle'],$_REQUEST['NExterior'],$_REQUEST['NInterior'],$_REQUEST['ColoniaId'],$_REQUEST['MiColonia']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}
		break;
	case '7':
				$upload_folder ='RecargasDoc';
				$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext1'];
				if($tmp_archivo1!='')
				move_uploaded_file($tmp_archivo1, $archivador1);
				//if (move_uploaded_file($tmp_archivo1, $archivador1))
				//{
				echo $Herramientas->guardaRecarga($_REQUEST['Folio'], $_REQUEST['CompaniaId'], $_REQUEST['NTel'], $_REQUEST['MontoRecargaId'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentario'], $_REQUEST['Serie'], $_REQUEST['CompaniaPId'], $_REQUEST['NTelP'], $_REQUEST['Nombre'], $_REQUEST['Paterno'], $_REQUEST['Materno'],$_REQUEST['TelContacto'],$_REQUEST['MailContacto'],$archivador1, $_REQUEST['Nip']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				//}
		break;

	case '8':
				$upload_folder ='RecargasDoc';
				//$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$tmp_archivo1 = '';
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext1'];
				if($tmp_archivo1!='')
				move_uploaded_file($tmp_archivo1, $archivador1);
				//if (move_uploaded_file($tmp_archivo1, $archivador1))
				//{
				echo $Herramientas->guardaVentaTAE($_REQUEST['FolioR'],$_REQUEST['NTel'], $_REQUEST['MontoRecargaId'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentario']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				//}
		break;
	case '9':
				$upload_folder ='RecargasDoc';
				//$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$tmp_archivo1 = '';
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext1'];
				if($tmp_archivo1!='')
				move_uploaded_file($tmp_archivo1, $archivador1);
				//if (move_uploaded_file($tmp_archivo1, $archivador1))
				//{
				echo $Herramientas->guardaVentaTAESim($_REQUEST['Folio'],$_REQUEST['NTel'], $_REQUEST['MontoRecargaId'], $_REQUEST['Serie'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentario']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				//}
		break;
	case '10':
				$upload_folder ='RecargasDoc';
				//$tmp_archivo1 = $_FILES['archivo1']['tmp_name'];
				$tmp_archivo1 = '';
				$archivador1 = $upload_folder . '/' . $_REQUEST['clave'].$_REQUEST['ext1'];
				if($tmp_archivo1!='')
				move_uploaded_file($tmp_archivo1, $archivador1);
				//if (move_uploaded_file($tmp_archivo1, $archivador1))
				//{
				echo $Herramientas->guardaVentaPortabilidad($_REQUEST['FolioR'], $_REQUEST['NTel'], $_REQUEST['MontoRecargaId'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentario'], $_REQUEST['Sim'], $_REQUEST['NTelP'], $_REQUEST['Nombre'], $_REQUEST['Paterno'], $_REQUEST['Materno'],$_REQUEST['Nip'],$_REQUEST['Portabilidad']);
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				//}
		break;/* Aterior*/
	case '11': 
		//Caso solo para PostPago
				$Clave=$_REQUEST['Clave'];
				$DatoId=$_REQUEST['DatoId'];
				$return = Array('ok'=>TRUE);
				$upload_folder ='FilesTmp/PostPago';
				$nombre_archivo = $Clave;
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo;	
				//$validator = new Validator();
				//var_dump($tmp_archivo);
				$postagoController = new PostpagoController();
				//echo __DIR__ . 'FilesTmp/PostPago'. $Clave;
				if (!move_uploaded_file($tmp_archivo, $archivador))
				{
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => 'error');
				}else{
					echo $postagoController->processPostPago("FilesTmp/PostPago/". $Clave, $_SESSION['UsuarioId'], $DatoId, $upload_folder, $tipo_archivo, $tamano_archivo);
				}
				/*else{
					$herramientasPostpago = new PostpagoController();
					echo $herramientasPostpago->pruebas($_SESSION['UsuarioId']);
					Aqui ejecusion de metodos del comparativo
					Se puede devolver solo un echo con mensaje de exito
				}*/
		break;
	case '12':
				$Clave=$_REQUEST['Clave'];
				$DatoId=$_REQUEST['DatoId'];
				$return = Array('ok' => TRUE);
				$upload_folder = 'FilesTmp/Renovaciones';
				$nombre_archivo = $Clave;
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo;
				$renovacionesController = new RenovacionesController();
				//echo __DIR__. 'FilesTmp/Renovaciones' . $Clave;
				if(!move_uploaded_file($tmp_archivo, $archivador)){
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo cargarse.", 'status' => 'error');
				}else{
					echo $renovacionesController->processRenovaciones("FilesTmp/Renovaciones/" . $Clave, $_SESSION['UsuarioId'], $DatoId, $upload_folder, $tipo_archivo, $tmp_archivo);
				}
		break;
	case '13':
				$Clave=$_REQUEST['Clave'];
				$DatoId=$_REQUEST['DatoId'];
				$return = Array('ok' => TRUE);
				$upload_folder = 'FilesTmp/Transfer';
				$nombre_archivo = $Clave;
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo;
				$transferController = new TransferController();
				//echo __DIR__. 'FilesTmp/Transfer' . $Clave;
				if(!move_uploaded_file($tmp_archivo, $archivador)){
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo cargarse", 'status'=>'error');
				}else{
					echo $transferController->processTransfer("FilesTmp/Transfer/" . $Clave, $_SESSION['UsuarioId'], $DatoId, $upload_folder, $tipo_archivo, $tmp_archivo);
				}

		break;
	case '11':
				$Clave=$_REQUEST['Clave'];
				$DatoId=$_REQUEST['DatoId'];
				$return = Array('ok' => TRUE);
				$upload_folder = 'FilesTmp/Seguros';
				$nombre_archivo = $Clave;
				$tipo_archivo = $_FILES['archivo']['type'];
				$tamano_archivo = $_FILES['archivo']['size'];
				$tmp_archivo = $_FILES['archivo']['tmp_name'];
				$archivador = $upload_folder . '/' . $nombre_archivo;
				$segurosController = new SegurosController();
				//echo __DIR__ . 'FilesTmp/Seguros' . $Clave;
				if(!move_uploaded_file($tmp_archivo, $archivador)){
					$return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo cargarse.", 'status' => 'error');
				}else{
					echo $segurosController->processSeguros("FilesTmp/Seguros/" . $Clave, $_SESSION['UsuarioId'], $DatoId, $upload_folder, $tipo_archivo, $tmp_archivo);
				}
		break;
	case '14':
		break;


	}
?>
