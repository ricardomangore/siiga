<?php
header('Content-Type: text/txt; charset=ISO-8859-1');

	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");

	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);

	switch ($_REQUEST['modulo']) {
		case '0':
				switch ($_REQUEST['opc'])
					{
						case 1: //Cambia Contraseña
								if($Herramientas->changePassword($_REQUEST['actual'],$_REQUEST['nuevo']))
								    echo utf8_decode('<span class="notificacion">¡La contraseña se actualizo satisfactoriamente!</span>');
								else
							  		echo utf8_decode('<span class="alerta">¡No fue posible cambiar la contraseña!</span>');
						break;
						case 2: //Contesta Encuesta
								echo $Herramientas->responderEncuesta($_REQUEST['RespuestaId'], $_REQUEST['RespuestaTxt']);
						case 3: //Ya participo?
								echo $Herramientas->Participo($_REQUEST['EncuestaId']);
						break;
						case 4: echo $Herramientas->getResultadosEncuesta();
						break;
						case 5:
								echo $Herramientas->RevisaAviso($_REQUEST['Url']);
						break;
					}
			break;

		case '10':
					switch ($_REQUEST['opc'])
					{
						case 0://Obtiene tabla de modulos
								echo $Herramientas->getTablePersonal($_REQUEST['ModuloId'], $_REQUEST['estatus']);
						break;
						case 1: //Alta personal
								echo $Herramientas->addEmpleado($_REQUEST['Nombre'], $_REQUEST['Paterno'], $_REQUEST['Materno'], $_REQUEST['FechaNacimiento'], $_REQUEST['Curp'], $_REQUEST['Rfc'], $_REQUEST['Ife'], $_REQUEST['Nss'], $_REQUEST['Genero'], $_REQUEST['NacionalidadId'], $_REQUEST['PuestoId'], $_REQUEST['SubCategoriaId'], $_REQUEST['FechaAltaPuesto'], $_REQUEST['PuntoVentaId'], $_REQUEST['FechaAltaPunto'], $_REQUEST['Fisico'], $_REQUEST['EscolaridadId'], $_REQUEST['ProfesionId'], $_REQUEST['EstadoCivilId'], $_REQUEST['BancoId'], $_REQUEST['NoCuenta'], $_REQUEST['Clabe'], $_REQUEST['ColoniaId'], $_REQUEST['Calle'], $_REQUEST['NExterior'], $_REQUEST['NInterior'], $_REQUEST['Telefono'], $_REQUEST['Movil'], $_REQUEST['TipoSangre'], $_REQUEST['ParentescoId'], $_REQUEST['NombreContacto'], $_REQUEST['ColoniaIdContacto'], $_REQUEST['CalleContacto'], $_REQUEST['NExteriorContacto'], $_REQUEST['NInteriorContacto'], $_REQUEST['TelefonoContacto'], $_REQUEST['MovilContacto'], $_REQUEST['CorreoElectronicoContacto'], $_REQUEST['CoordinadorId'], $_REQUEST['Operador'], $_REQUEST['Porcentaje'], $_REQUEST['ClasificacionPersonalVentaId'], $_REQUEST['FechaSolicitudImss'], $_REQUEST['SueldoF'], $_REQUEST['ReclutadorId'], $_REQUEST['Mail'], $_REQUEST['claveAtt']);
						break;
						case 2: //Edicion Personal
								echo $Herramientas->editEmpleado($_REQUEST['EmpleadoId'], $_REQUEST['Nombre'], $_REQUEST['Paterno'], $_REQUEST['Materno'], $_REQUEST['FechaNacimiento'], $_REQUEST['Curp'], $_REQUEST['Rfc'], $_REQUEST['Ife'], $_REQUEST['Nss'], $_REQUEST['Genero'], $_REQUEST['NacionalidadId'], $_REQUEST['PuestoId'], $_REQUEST['SubCategoriaId'], $_REQUEST['FechaAltaPuesto'], $_REQUEST['PuntoVentaId'], $_REQUEST['FechaAltaPunto'], $_REQUEST['Fisico'], $_REQUEST['EscolaridadId'], $_REQUEST['ProfesionId'], $_REQUEST['EstadoCivilId'], $_REQUEST['BancoId'], $_REQUEST['NoCuenta'], $_REQUEST['Clabe'], $_REQUEST['ColoniaId'], $_REQUEST['Calle'], $_REQUEST['NExterior'], $_REQUEST['NInterior'], $_REQUEST['Telefono'], $_REQUEST['Movil'], $_REQUEST['TipoSangre'], $_REQUEST['ParentescoId'], $_REQUEST['NombreContacto'], $_REQUEST['ColoniaIdContacto'], $_REQUEST['CalleContacto'], $_REQUEST['NExteriorContacto'], $_REQUEST['NInteriorContacto'], $_REQUEST['TelefonoContacto'], $_REQUEST['MovilContacto'], $_REQUEST['CorreoElectronicoContacto'], $_REQUEST['ObservacionTh'], $_REQUEST['Operador'], $_REQUEST['Porcentaje'], $_REQUEST['ClasificacionPersonalVentaId'], $_REQUEST['DatosImss'], $_REQUEST['FechaSImss'], $_REQUEST['FechaMImss'], $_REQUEST['SD'], $_REQUEST['TipoMovimiento'], $_REQUEST['FechaSFijo'], $_REQUEST['SFijo'], $_REQUEST['Mail'], $_REQUEST['claveAtt']);
						break;
						case 3: //Baja Personal
								echo $Herramientas->bajaEmpleados($_REQUEST['EmpleadoId'],$_REQUEST['CausaBajaId'], $_REQUEST['FechaBaja']);
						break;
						case 4: //Reactivacion Personal
						break;
						case 5://Actualiza la foto del personal
								echo $Herramientas->actualizaPhoto($_REQUEST['EmpleadoId']);
						break;
					}
			break;

		case '21':
					switch ($_REQUEST['opc'])
					{
						case 1: // Alta Usuario
			 					echo $Herramientas->altaUsuario($_REQUEST['EmpleadoId']);
						break;
					}
			break;

		case '22':
					switch ($_REQUEST['opc'])
					{
						case 1: //Alta Referencia
								echo $Herramientas->addReferencia($_REQUEST['Clave'], $_REQUEST['ParentescoId'], $_REQUEST['NombreR'], $_REQUEST['PaternoR'], $_REQUEST['MaternoR'], $_REQUEST['TelefonoR'], $_REQUEST['MailR']);
						break;
						case 2: //Alta Cliente
								echo $Herramientas->addCliente($_REQUEST['TipoPersonaId'], $_REQUEST['NombreC'], $_REQUEST['PaternoC'], $_REQUEST['MaternoC'], $_REQUEST['RFCC'], $_REQUEST['Calle'], $_REQUEST['NExterior'], $_REQUEST['NInterior'], $_REQUEST['ColoniaId'], $_REQUEST['TLocal'], $_REQUEST['TMovil'], $_REQUEST['NombreCT'], $_REQUEST['PaternoCT'], $_REQUEST['MaternoCT']);
						break;
						case 3: //Alta Linea
								echo $Herramientas->addLinea($_REQUEST['Clave'], $_REQUEST['EquipoId'], $_REQUEST['PlanId'], $_REQUEST['TipoPlanId'], $_REQUEST['AddOnes'], $_REQUEST['OtrosServ'], $_REQUEST['PlazoId'], $_REQUEST['Contrato'], $_REQUEST['ComentarioL']);
						break;
						case 4: // Remover Linea
								echo $Herramientas->removeLinea($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
						case 5: // Alta Folio
			 					echo $Herramientas->altaFolioVU($_REQUEST['Folio'],$_REQUEST['FechaContrato'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['ClienteId'], $_REQUEST['TipoContratacionId'], $_REQUEST['TipoPagoId'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], $_REQUEST['ContratacionId'],$_REQUEST['PlataformaId']);
						break;
						case 6: //Actualiza estatus
								echo $Herramientas->ActualizaEstatus($_REQUEST['RegistroId'],$_REQUEST['EstatusId'], $_REQUEST['FechaEstatus'], $_REQUEST['Comentario'], $_REQUEST['Contrato'], $_REQUEST['DN']);
						break;
					}
			break;

		case '23':
					switch ($_REQUEST['opc'])
					{
						case 2: //Existe serie
								echo $Herramientas->existeSerie($_REQUEST['Lectura2']);
						break;
						case 3: //Alta Linea Lectura
								echo $Herramientas->addLectura($_REQUEST['Lectura2'], $_REQUEST['Clave'], $_REQUEST['EquipoId']);
						break;
						case 4: // Remover Linea de lectura
								echo $Herramientas->removeLectura($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
						case 5: // Alta Recepcion
			 					echo $Herramientas->addRecepcion($_REQUEST['PuntoVentaId'],$_REQUEST['Factura'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], 23, '');
						break;
					}
			break;


		case '24':
					switch ($_REQUEST['opc'])
					{
						case 3: //Valida Linea
								echo $Herramientas->addLineaOr($_REQUEST['Lectura'], $_REQUEST['MiFolio']);
						break;
						case 5: // Alta Folio
			 					echo $Herramientas->altaFolioOr($_REQUEST['Folio'],$_REQUEST['FechaContrato'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['ClienteId'], $_REQUEST['TipoContratacionId'], $_REQUEST['TipoPagoId'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], $_REQUEST['ContratacionId'], $_REQUEST['TipoVentaId'], $_REQUEST['PlataformaId']);
						break;
						case 6: //Actualiza estatus
								echo $Herramientas->ActualizaEstatus($_REQUEST['RegistroId'],$_REQUEST['EstatusId'], $_REQUEST['FechaEstatus'], $_REQUEST['Comentario']);
						break;
						case 7: //Alta Linea
								echo $Herramientas->altaLineaOrg($_REQUEST['Serie'], $_REQUEST['MiFolio'], $_REQUEST['PlanId'], $_REQUEST['TipoPlanId'], $_REQUEST['AddOnes'], $_REQUEST['OtrosServ'], $_REQUEST['PlazoId'], $_REQUEST['Movimiento'], $_REQUEST['Diferencial'], $_REQUEST['TipoPagoDiferencial'], $_REQUEST['SeguroId'], $_REQUEST['codigo_sim']);
						break;

						case 8: //get Clientes Busqueda
								echo $Herramientas->getListaClientes($_REQUEST['NombreCliente']);
						break;

						case 9: //Alta Linea
								echo $Herramientas->altaLineaOrgV2($_REQUEST['Serie'], $_REQUEST['MiFolio'], $_REQUEST['PlanId'], $_REQUEST['TipoPlanId'], $_REQUEST['AddOnes'], $_REQUEST['Dn'], $_REQUEST['PlazoId'], $_REQUEST['Movimiento'], $_REQUEST['Diferencial'], $_REQUEST['TipoPagoDiferencial'], $_REQUEST['SeguroId'], $_REQUEST['codigo_sim'],$_REQUEST['tipoVentaAux'],$_REQUEST['tipoVenta']);
						break;
						case 10: //Alta Linea
								echo $Herramientas->altaLineaOrgV3($_REQUEST['FechaSS'],$_REQUEST['Contrato']);
						break;






					}
			break;
		case '26':
					switch ($_REQUEST['opc'])
					{
						case 5: // Alta Folio
			 					echo $Herramientas->altaFolioOrsIn($_REQUEST['Folio'],$_REQUEST['FechaContrato'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['ClienteId'], $_REQUEST['TipoContratacionId'], $_REQUEST['TipoPagoId'], $_REQUEST['Comentarios'],$_REQUEST['PlataformaId']);
						break;
					}
			break;
		case '28':
					switch ($_REQUEST['opc'])
					{
						case 1: //Existe serie
								echo $Herramientas->addTSalidas($_REQUEST['PuntoVentaIdO'],$_REQUEST['PuntoVentaIdD'], $_REQUEST['Comentarios'], $_REQUEST['Clave']);
						break;
					}
			break;
		case '29':
					switch ($_REQUEST['opc'])
					{
						case 1: //Existe serie
								echo $Herramientas->ValidaSerieTEntrada($_REQUEST['Lectura6'],$_REQUEST['Odt'],$_REQUEST['clave']);
						break;
						case 2: //Existe serie
								echo $Herramientas->addTEntradas($_REQUEST['Odt'],$_REQUEST['Comentarios'],$_REQUEST['Clave'],$_REQUEST['PuntoVentaId']);
						break;
						case 3: //Existe serie
								echo $Herramientas->setConcepto($_REQUEST['TraspasoId'],$_REQUEST['ConceptoTRId']);
						break;
					}
			break;

		case '30':
					switch ($_REQUEST['opc'])
					{
						case 2: //Existe serie
								echo $Herramientas->existeSerieTraspaso($_REQUEST['Lectura3'], $_REQUEST['PuntoVentaIdO']);
						break;
						case 3: //Alta Linea Lectura
								echo $Herramientas->addLecturaTExpress($_REQUEST['Lectura3'], $_REQUEST['Clave'], $_REQUEST['Cantidad']);
						break;
						case 4: // Remover Linea de lectura
								echo $Herramientas->removeTRLectura($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
						case 5: // Alta Recepcion
			 					echo $Herramientas->addTExpress($_REQUEST['PuntoVentaIdO'],$_REQUEST['PuntoVentaIdD'], $_REQUEST['Comentarios'], $_REQUEST['Clave']);
						break;
					}
			break;
		case '33':
					switch ($_REQUEST['opc'])
					{
						case 1: //Existe serie
								echo $Herramientas->guardaLecturaFisico($_REQUEST['Lectura5'], $_REQUEST['PuntoVentaId']);
						break;
						case 2: // Remover Linea de lecturaFisico
								echo $Herramientas->removeLecturaFisico($_REQUEST['RegistroId'], $_REQUEST['PuntoVentaId']);
						break;

					}
			break;
		case '34':
					switch ($_REQUEST['opc'])
					{
						case 1: //Existe serie
								echo $Herramientas->liberarSerie($_REQUEST['Serie']);
						break;
						case 2: // Remover Linea de lecturaFisico
								echo $Herramientas->cambiarFechaRecepcion($_REQUEST['MovimientoId'], $_REQUEST['FechaRecepcion']);
						break;
						case 3:
								echo $Herramientas->desbloquearTraspasos();
						break;
						case 4:
								echo $Herramientas->desbloquearLecturaRecepcion($_REQUEST['ClaveRecepcion']);
						break;
						case 5:
								echo $Herramientas->desbloquearCancelados();
						break;

					}
			break;
		case '35':
					echo $Herramientas->AsignaCoordinadorEjecutivos($_REQUEST['CoordinadorId'], $_REQUEST['Llaves']);
			break;

		case '36':
					echo $Herramientas->GuardaSeguimiento($_REQUEST['SeguimientoId'], $_REQUEST['EstatusSeguimientoId'], $_REQUEST['Comentarios'], $_REQUEST['FechaHora']);
			break;
		case '37':
					echo $Herramientas->importaLayout($DatoId);
			break;
		case '38':
					switch ($_REQUEST['opc'])
					{
						case 1: //Existe accesorio para Vta
								echo $Herramientas->validaAccesorio($_REQUEST['Lectura'], $_REQUEST['PuntoVentaId'], $_REQUEST['Clave']);
						break;
						case 2: // Remover Linea de Lectura Vta
								echo $Herramientas->removeAccVta($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
					}
			break;
		case '40':
					switch ($_REQUEST['opc'])
					{
						case 1: //Actualiza
								echo $Herramientas->actualizaIfoInactivo($_REQUEST['EmpleadoId'], $_REQUEST['HistorialPuestoEmpleadoId'], $_REQUEST['HistorialEmpleadoImss'], $_REQUEST['FechaSolicitudImss'], $_REQUEST['FechaAltaImss'], $_REQUEST['Finiquito'], $_REQUEST['ObservacionesTH']);
						break;
						case 3: //Actualiza
								echo $Herramientas->reingresaPersonal($_REQUEST['EmpleadoId'], $_REQUEST['PuestoId'], $_REQUEST['SubCategoriaId'], $_REQUEST['FechaIngreso'], $_REQUEST['Operador'], $_REQUEST['Porcentaje'], $_REQUEST['ClasificacionPersonalVentaId']);
						break;
					}
			break;

		case '41':
					switch ($_REQUEST['opc'])
					{
						case 1: //Registra Linea Producto Temporal
								echo $Herramientas->AddLineaTP($_REQUEST['Clave'], $_REQUEST['ProductoId']);
						break;
						case 2: // Remover Linea de Lectura Vta
								echo $Herramientas->removeTPVta($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
						case 3: //Guardar TP
								echo $Herramientas->guardaTPVta($_REQUEST['PuntoVentaId'], $_REQUEST['Folio'], $_REQUEST['PlazoId'], $_REQUEST['EstatusId'], $_REQUEST['FechaContrato'], $_REQUEST['FechaInstalacion'], $_REQUEST['ClienteId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], $_REQUEST['Pvs']);
						break;
						case 4: //Actualiza TP
								echo $Herramientas->actualizaTPVta($_REQUEST['PuntoVentaId'], $_REQUEST['Folio'], $_REQUEST['PlazoId'], $_REQUEST['EstatusId'], $_REQUEST['FechaContrato'], $_REQUEST['FechaInstalacion'], $_REQUEST['ClienteId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentarios'], $_REQUEST['Pvs']);
						break;

					}
			break;

		case '43':
					switch ($_REQUEST['opc'])
					{
						case 1: //Registra Linea Uniforme Temporal
								echo $Herramientas->AddLineaUniforme($_REQUEST['Clave'], $_REQUEST['UniformeId'], $_REQUEST['Color'], $_REQUEST['Talla'], $_REQUEST['Cantidad']);
						break;
						case 2: // Remover Linea de Lectura Vta
								echo $Herramientas->removeLineaUniforme($_REQUEST['RegistroId'], $_REQUEST['Clave']);
						break;
						case 3: //Guardar Entrega Uniforme
								echo $Herramientas->EntregaUniformes($_REQUEST['FechaContrato'], $_REQUEST['EmpleadoId'], $_REQUEST['Comentarios'], $_REQUEST['Clave']);
						break;
					}
			break;

		case '46':
					switch ($_REQUEST['opc'])
					{
						case 1: //Valida Serie Recepcion Factura
								echo $Herramientas->LeerSerieFactura($_REQUEST['LecturaOdc'], $_REQUEST['Factura'], $_REQUEST['Clave']);
						break;
						case 2: //Guardar Factura
								echo $Herramientas->addRecepcion($_REQUEST['PuntoVentaId'], $_REQUEST['Factura'], $_REQUEST['Comentarios'], $_REQUEST['Clave'], 46, $_REQUEST['file']);
						break;
					}
			break;
		case '47':
					switch ($_REQUEST['opc'])
					{
						case 1: //Valida Serie Recepcion Factura
								echo $Herramientas->getFactura($_REQUEST['Factura']);
						break;
					}
			break;
		case '59':
					echo $Herramientas->GuardaRenovacion($_REQUEST['RevisionId'], $_REQUEST['EstatusSeguimientoId'], $_REQUEST['Comentarios'], $_REQUEST['FechaHora']);
			break;
		case '63':
					echo $Herramientas->resetPWD($_REQUEST['NC']);
			break;

		case '64':
					echo $Herramientas->checar($_REQUEST['CoordinadorId'], $_REQUEST['Pwd']);
			break;
		case '65':
					echo $Herramientas->guardaRecarga($_REQUEST['Folio'], $_REQUEST['CompaniaId'], $_REQUEST['NTel'], $_REQUEST['MontoRecargaId'], $_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['Comentario'], $_REQUEST['Serie'], $_REQUEST['CompaniaPId'], $_REQUEST['NTelP']);
			break;
		case '66':
					echo $Herramientas->validaDeposito($_REQUEST['DepositoId']);
		break;
		case '68':
					echo $Herramientas->setPuntoCliente($_REQUEST['SeguimientoId'], $_REQUEST['PuntoVentaId']);
		break;
		case '69':
					switch ($_REQUEST['opc'])
					{
						case 1: //Valida Serie Ajuste Negativo
								echo $Herramientas->LeerSerieAjusteN($_REQUEST['LecturaN'], $_REQUEST['PuntoVentaId'], $_REQUEST['Clave']);
						break;

					}
			break;
		case '70':
					switch ($_REQUEST['opc'])
					{
						case 1: //Valida Venta
							echo $Herramientas->actualizaValidacion($_REQUEST['ValidacionId'], $_REQUEST['EstatusValidacionId'], $_REQUEST['Observaciones'], $_REQUEST['EstatusNoeId'], $_REQUEST['FechaEstatus'],$_REQUEST['Nombre'],$_REQUEST['Paterno'],
									$_REQUEST['Materno'],$_REQUEST['Telefono'],$_REQUEST['PuntoVentaId'],$_REQUEST['DescEquipos'],
									$_REQUEST['DescPlanes'],$_REQUEST['Calle'],$_REQUEST['NExterior'],$_REQUEST['NInterior'],$_REQUEST['ColoniaId'],$_REQUEST['EstatusValidacionIdOld']
									);
						break;
						case 2:
							echo $Herramientas->addColonia($_REQUEST['cp'],$_REQUEST['Colonia']);

					}
			break;
		case '71':
					switch ($_REQUEST['opc'])
					{
						case 1: //Valida Venta
								echo $Herramientas->ActualizaHFolio(
									$_REQUEST['Folio'],
									$_REQUEST['FechaContrato'],
									$_REQUEST['PuntoVentaId'], $_REQUEST['VendedorId'], $_REQUEST['CoordinadorId'], $_REQUEST['ClienteId'], $_REQUEST['TipoContratacionId'], $_REQUEST['TipoPagoId'], $_REQUEST['Comentarios'], $_REQUEST['ContratacionId'], $_REQUEST['FolioOld'], $_REQUEST['PuntoVentaIdOld']);
						break;
						case 2: // Remover Linea de Lectura Vta
								echo $HerramientasHtml->removeAddOn($_REQUEST['RegistroId'], $_REQUEST['AddonId']);
						break;
						case 3: // Remover Linea de Lectura Vta
								echo $HerramientasHtml->AddAddOn($_REQUEST['RegistroId'], $_REQUEST['AddonId']);
						break;
						case 4: // Remover Linea de Lectura Vta
								echo $Herramientas->actualizaRegistro($_REQUEST['RegistroId'], $_REQUEST['PlanId'], $_REQUEST['EquipoId'], $_REQUEST['EstatusId'], $_REQUEST['PlazoId'], $_REQUEST['FechaEstatus'], $_REQUEST['Contrato'], $_REQUEST['Dn'], $_REQUEST['Diferencial'], $_REQUEST['TipoPagoDiferencial'], $_REQUEST['Observaciones'], $_REQUEST['MovimientoId'], $_REQUEST['Serie'], $_REQUEST['EstatusIdOld']);
						break;

					}
			break;
		default:
			echo "";
			break;
	}
?>
