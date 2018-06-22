<?php
class ToolsHtml extends Tools{
	var $UsuarioId;
	function ToolsHtml($UsuarioId)
	{
		$this->Tools($UsuarioId);
		$this->UsuarioId=$UsuarioId;

	return;
	}//ToolsHtml

	function DisplayControles($ModuloId)
	{
		$Permisos=$this->getPermisosModulo($ModuloId);
		echo'
			 <div align="center" id="Controles">
			</br>
			 ';

		if($ModuloId==0 || $ModuloId==35 || $ModuloId==64)
			echo'
				<input type="button" class="guardar" id="guardar" name="guardar" value="Guardar">
				<input type="reset"  class="cancelar" id="cancelar" name="cancelar" value="Cancelar">
				';
		else
			{
					if(in_array("1", $Permisos))
					echo'
					<input type="button" class="lista" id="lista" name="lista" value="Lista">
							';
					echo'

					<input type="button" class="formulario" id="formulario" name="formulario" value="Formulario">
					';
					if(in_array("2", $Permisos))
						echo'
							<input type="button" class="nuevo" id="nuevo" name="nuevo" value="Nuevo">
							<input type="button" class="guardar" id="guardar" name="guardar" value="Guardar">
							';
					if(in_array("5", $Permisos))
						echo'
							<input type="button" class="editar" id="editar" name="editar" value="Editar">
							<input type="button" class="guardar" id="actualizar" name="actualizar" value="Guardar">
							';
					if(in_array("3", $Permisos))
						echo'
							<input type="button" class="borrar" id="borrar" name="borrar" value="Eliminar">
							';
					if(in_array("4", $Permisos))
						echo'
							<input type="button" class="activar" id="activar" name="activar" value="Activar">
							';
					if(in_array("7", $Permisos))
						echo'
							<input type="button" class="activar" id="validar" name="validar" value="Validar">
							';
					if(in_array("8", $Permisos))
						echo'
							<input type="button" class="lista" id="ConceptoTr" name="ConceptoTr" value="Concepto TR">
							';

					echo'
					<input type="reset" class="cancelar" id="cancelar" name="cancelar" value="Cancelar">
					';
			}

		echo'<br><br></div>';
	}

	function getTituloWeb()
	{
		echo utf8_decode('
		<meta name="author" CONTENT="David Juárez Marín">
		<title>SIIGA</title>
		<link rel="shortcut icon" href="img/Icono.png">
		');
	}

	function displayHeaderModulo($ModuloId)
	{

		list($Txt, $Img, $Vista)=$this->getHModulo($ModuloId);
		echo utf8_decode('
		<div id="Titulo">
			<input type="hidden" id="ModuloId" name="ModuloId" value="'.$ModuloId.'">
			<input type="hidden" id="Vista" name="Vista" value="'.$Vista.'">
			<img class="tituloImg" src="img/'.$Img.'" />'.utf8_encode($Txt).'
		</div>
		');
	}

	function displayLista($ModuloId)
	{

		//Modo 1 -> Formulario
		//Modo 2 -> Edicion
		//Modo 3 -> Lista
		echo'<input type="hidden" id="Modo" name="Modo" value="4"><br>';
		$this->drawTabla($this->getDatos($ModuloId));
	}//displayLista


	function displayFormulario($ModuloId)
	{

		//Modo 1 -> Formulario
		//Modo 2 -> Edicion
		//Modo 3 -> Lista
		//Modo 4 -> ListaInactivo
		echo'<input type="hidden" id="Modo" name="Modo" value="1">

				<br>
				';
		switch ($ModuloId) {
			case '1':
						$this->displayCatAvisos();
				break;
			case '10':
						$this->displayPersonal();
				break;
			case '22':
						$this->displayVentanilla();
				break;
			case '23':
						$this->displayRecepcion();
				break;
			case '24':
						$this->displayPrecaptura();
				break;
			case '26':
						$this->displayVentana();
				break;
			case '28':  $this->displayTSalidas();
				break;
			case '29':  $this->displayTEntradas();
				break;
			case '30':
						$this->displayTExpress();
				break;
			case '33':
						$this->displayInvF();
				break;
			case '35':
						$this->displayAsignaCoordinador();
				break;
			case '38':
						$this->displayVentaAccesorios();
				break;
			case '40':
						$this->displayNoDisponible();
				break;
			case '41':
						$this->displayVentaTP();
				break;
			case '43':
						$this->displayEntregaUniforme();
				break;
			case '46':
						$this->displayRecepcionODC();
				break;
			case '60':
						$this->displayRevisionBuro();
				break;
			case '64':
						$this->displayChecador();
				break;
			case '65':
						$this->displayRecarga();
				break;
			case '66':
						$this->displayDepositos();
				break;
			case '70':
						$this->displayValidacionVenta();
				break;
			case '73':
						$this->displayVentaTAE();
				break;
			case '74':
						$this->displayVentaTAESim();
				break;
			case '75':
						$this->displayVentaPortabilidad();
				break;
			case '76':
						$this->displayOriginacionV2();
			default:
				echo '';
				break;
		}
	}//displayFormulario

	function displayFormularioEdit($ModuloId, $ObjetoId)
	{

		//Modo 2 -> Formulario
		//Modo 3 -> Edicion
		//Modo 3 -> Lista
		echo'<input type="hidden" id="Modo" name="Modo" value="2"><br>';
		switch ($ModuloId) {
			case '10':
						$this->displayPersonalEdit($ObjetoId);
				break;
			case '22':
						$this->displayVentanillaEdit($ObjetoId);
				break;
			case '40':
						$this->displayInactivosEdit($ObjetoId);
				break;
			case '41':
						$this->displayVentaTPEdit($ObjetoId);
				break;
			case '46':
						$this->displayRecepcionODCEdit($ObjetoId);
				break;
			case '66':
						$this->displayDepositosEdit($ObjetoId);
				break;
			case '70':
						$this->displayValidacionVentaEdit($ObjetoId);
				break;

			default:
				echo '';
				break;
		}
	}//displayFormularioEdit


	function displayAvisos($ClasificacionId)
	{
		$R0=$this->getAvisos($ClasificacionId);

		$estilos = array("datagridRed","datagridGreen","datagridPurple","datagridBrown","datagridGray","datagridBlue","datagridOrange");
		shuffle($estilos);
		$i=0;
		while($A0=mysql_fetch_row($R0))
		{
			echo'
			<div class="datagridColor" id="'.$estilos[$i].'">
			<table>
				<thead>
					<tr>
						<th height="40">'.$A0[2].'</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td>
							<div id="no-paging"># '.$A0[4].'  '.$A0[3].' - '.$A0[1].'</div>
						<td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td height="80"><span onclick="openLink(\''.$A0[0].'\')">'.$A0[5].'</span></td>
					</tr>
				</tbody>
			</table>
			</div>
			';
				$i++;
				if($i>=count($estilos))
				{
					$i=0;
					$estilos = array("datagridRed","datagridGreen","datagridPurple","datagridBrown","datagridGray","datagridBlue","datagridOrange");
					shuffle($estilos);
				}
			}
	}

	function displayClasificacionAvisos()
	{
		$R0=$this->getClsificacionAvisos();

		$estilos = array("datagridRed","datagridGreen","datagridPurple","datagridBrown","datagridGray","datagridBlue","datagridOrange");
		shuffle($estilos);
		$i=0;
		while($A0=mysql_fetch_row($R0))
		{
			echo'
			<div class="datagridColor" id="'.$estilos[$i].'">
			<table>
				<thead>
					<tr>
						<th height="40">: : '.$A0[0].'</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td>
							<div id="no-paging"><strong>'.$A0[1].'</strong></div>
						<td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<td height="80" align="center"><span onclick="verAvisos('.$A0[3].')">'.$A0[2].'</span></td>
					</tr>
				</tbody>
			</table>
			</div>
			';
				$i++;
				if($i>=count($estilos))
				{
					$i=0;
					$estilos = array("datagridRed","datagridGreen","datagridPurple","datagridBrown","datagridGray","datagridBlue","datagridOrange");
					shuffle($estilos);
				}
			}
	}

	function drawTabla($R0)
	{
		$Orden=$this->getOrden($R0);
		$i=0;
		$titulos = array();
	echo '
		<input type="hidden" id="Llaves" name="Llaves" value="">
		<span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<div  class="tableContainer">
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">';
		while($A0=mysql_fetch_row($R0))
		{
		if($i==0)
				{
					echo'<thead class="fixedHeader"><tr>';
						for($j=0; $j<$Orden['columnas']; $j++)
							{
							if ($j==0)
								{
										echo '
										<th align="center" valign="midle" >
										<img src="img/Seleccionado.gif" align="absbottom" width="25" height="25"  onclick="Todos()" />
										</th><th>'.utf8_decode($A0[$j]).'&nbsp&nbsp</th>';
										$titulos[$j]=$A0[$j];
								}
							else
								{
									echo '<th bgcolor="#BFD5EA" id="'.utf8_decode($A0[$j]).'">'.utf8_decode($A0[$j]).'</th>';
									$titulos[$j]=$A0[$j];

								}
							}
					echo '</tr></thead>
							<tbody class="scrollContent">';
				}
				else
				{
					echo'<tr>';
					for($j=0; $j<$Orden['columnas']; $j++)
						{
						if ($j==0)
									echo '<td align="center"><input type="checkbox" name="DatoId" id="DatoId" value="'.$A0[$j].'" onclick="changeDato(this, \''.$A0[$j].'\')" /></td>
										  <td headers="'.$titulos[$j].'">'.$A0[$j].'</td>';
						else
									echo '<td headers="'.$titulos[$j].'">'.$A0[$j].'</td>';
						}
				}
			echo '</tr>';
			$i++;
		}
		echo '</tbody></table>
	<script type="text/javascript">
	var sourceTable, destTable;
	function init()
	{
		sourceTable = new SortedTable("s");
		destTable = new SortedTable("d");
		mySorted = new SortedTable();
		mySorted.colorize = function()
		{
			for (var i=0;i<this.elements.length;i++)
			{
				if (i%2){
							this.changeClass(this.elements[i],"even","odd");
						} else {
								this.changeClass(this.elements[i],"odd","even");
								}
			}
		}
			mySorted.onsort = mySorted.colorize;
			mySorted.onmove = mySorted.colorize;
			mySorted.colorize();
			secondTable = SortedTable.getSortedTable(document.getElementById("id"));

			}
      init();
	</script>
		';
	}


/*PERSONAL::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function displayPersonal()
{
	echo'
	<div class="ConScroll">
			<fieldset>
				<legend>Informacion de Personal</legend>
					<br>
					<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre:</label>
					<input type="text" name="Nombre" id="Nombre" maxlength="25">
					<br>

					<label for="Paterno"><span class="importante">*</span>Apellido Paterno:</label>
					<input type="text" name="Paterno" id="Paterno" maxlength="25">
					<br>

					<label for="Materno"><span class="importante">*</span>Apellido Materno:</label>
					<input type="text" name="Materno" id="Materno" maxlength="25">
					<br>

					<label for="FechaNacimiento"><span class="importante">*</span>Fecha de Nacimiento:</label>
					<input type="text" id="FechaNacimiento" name="FechaNacimiento" readonly="readonly">
					<br>

					<label for="Curp"><span class="importante">*</span>CURP:</label>
					<input type="text" id="Curp" name="Curp" maxlength="20">
					<br>

					<label for="Rfc"><span class="importante">*</span>RFC:</label>
					<input type="text" id="Rfc" name="Rfc" maxlength="15">
					<br>

					<label for="Ife"><span class="importante">*</span>Numero de IFE:</label>
					<input type="text" id="Ife" name="Ife" maxlength="13">
					<br>

					<label for="Genero"><span class="importante">*</span>Genero:</label>
					<select name="Genero" id="Genero">
							<option value="0" selected="selected">Elige</option>
							<option value="F">FEMENINO</option>
							<option value="M">MASCULINO</option>
					</select>
					<br>

					<label for="NacionalidadId"><span class="importante">*</span>Nacionalidad:</label>
					<select name="NacionalidadId" id="NacionalidadId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('Nacionalidades','NacionalidadId','Nacionalidad',0, 'TRUE', 'Nacionalidad');
				echo '
					</select>

					<label for="EscolaridadId"><span class="importante">*</span>Escolaridad:</label>
					<select name="EscolaridadId" id="EscolaridadId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('Escolaridades','EscolaridadId','Escolaridad',0, 'TRUE', 'EscolaridadId');
				echo '
					</select>
					<br>
					<input type="hidden" name="ProfesionId" id="ProfesionId" value="1">

					</div>

					<div class="Derecha">

					<label for="EstadoCivilId"><span class="importante">*</span>Estado Civil:</label>
					<select name="EstadoCivilId" id="EstadoCivilId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('EstadoCivil','EstadoCivilId','EstadoCivil',0, 'TRUE', 'EstadoCivil');
				echo '
					</select>
					<br>

					<label for="Calle"><span class="importante">*</span>Calle:</label>
					<input type="text" id="Calle" name="Calle" maxlength="45">
					<br>

					<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
					<input type="text" id="NExterior" name="NExterior" maxlength="15">
					<br>

					<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
					<input type="text" id="NInterior" name="NInterior" maxlength="15">
					<br>

					<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
					<input type="text" id="Cp" name="Cp" maxlength="5">
					<br>

					<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
					<select name="ColoniaId" id="ColoniaId">
							<option value="0">Elige</option>
					</select>
					<br>

					<label for="Telefono"><span class="importante">*</span>Telefono Casa:</label>
					<input type="text" id="Telefono" name="Telefono" maxlength="11">
					<br>

					<label for="Movil"><span class="importante">*</span>Telefono Movil:</label>
					<input type="text" id="Movil" name="Movil" maxlength="11">
					<br>

					<label for="Nss"><span class="importante">*</span>Numero de Seguro Social:</label>
					<input type="text" id="Nss" name="Nss" maxlength="12">
					<br>


					<input type="hidden" id="Sangre" name="Sangre" value="N/A">
					<br><br>


					</div>
					<br>

			</fieldset>

			<fieldset>
				<legend>Informacion Laboral</legend>
					<div class="Izquierda">
						<label for="ClasificacionPersonalVentaId"><span class="importante">*</span>Clasificacion Venta:</label>
							<select name="ClasificacionPersonalVentaId" id="ClasificacionPersonalVentaId">
							<option value="0">Elige</option>
						';
							$this->Scroll('ClasificacionPersonalVenta','ClasificacionPersonalVentaId','ClasificacionPersonalVenta',0, 'Activo=1', 'ClasificacionPersonalVenta');
				echo '
						</select>
						<br>

						<label for="PuestoId"><span class="importante">*</span>Puesto Categoria:</label>
						<select name="PuestoId" id="PuestoId">
								<option value="0">Elige</option>
					';
								$this->Scroll('Puestos','PuestoId','Puesto',0, $this->getFiltro(1).' AND Activo=1', 'Puesto');
				echo '
						</select>
						<br>

						<label for="SubCategoriaId"><span class="importante">*</span>Sub Categoria:</label>
						<select name="SubCategoriaId" id="SubCategoriaId">
								<option value="0">Elige</option>
					';
								$this->Scroll('SubCategorias','SubCategoriaId','SubCategoria',0, 'Activo=1', 'SubCategoria');
				echo '
						</select>
						<br>

						<label for="FechaIngreso"><span class="importante">*</span>Fecha de Ingreso:</label>
							<input type="text" id="FechaIngreso" name="FechaIngreso" readonly="readonly">
						<br>

						<label for="BancoId"><span class="importante">*</span>Banco:</label>
						<select name="BancoId" id="BancoId">
								<option value="0">Elige</option>
					';
								$this->Scroll('Bancos','BancoId','Banco',0, 'TRUE', 'Banco');
				echo '
						</select>
						<br>

						<label for="Cuenta"><span class="importante">*</span>Cuenta Bancaria:</label>
							<input type="text" id="Cuenta" name="Cuenta" maxlength="25" >
						<br>

						<label for="Clabe"><span class="importante">*</span>Clabe Interbancaria:</label>
							<input type="text" id="Clabe" name="Clabe" maxlength="25" >
						<br>

						<label for="Mail"><span class="importante">*</span>Correo Electronico:</label>
							<input type="text" id="Mail" name="Mail">
						<br>

						<label for="clave_att"><span class="importante">*</span>Clave AT&T:</label>
							<input type="text" id="clave_att" name="clave_att" maxlength="6">
						<br>


					</div>
					<div class="Derecha">

					<label for="CoordinadorId">Jefe Inmediato:</label>
					<select name="CoordinadorId" id="CoordinadorId">
							<option value="0">Elige</option>
				';
							 $this->ScrollCoordinadores('0');
				echo '
					</select>
					<br>

					<label for="FechaIngresoPunto"><span class="importante">*</span>Fecha de Ingreso al Punto de Venta:</label>
							<input type="text" id="FechaIngresoPunto" name="FechaIngresoPunto" readonly="readonly">
						<br>
						<br>

					<input type="hidden" id="Puntos" name="Puntos" value="">
					<input type="hidden" id="Fisico" name="Fisico" value="">

					<div name="PuntoVenta" id="PuntoVenta" class="leyenda">
					Elegir Puntos de Venta
					</div>
					<br>
					<br>
						<label for="FechaSolicitudImss">Fecha de Solicitud Alta Imss:</label>
						<input type="text" id="FechaSolicitudImss" name="FechaSolicitudImss" readonly="readonly">
					<br>
						<label for="Operador"><span class="importante">*</span>Operador:</label>
						<input type="text" id="Operador" name="Operador" maxlength="2" >
					<br>
						<label for="Porcentaje"><span class="importante">*</span>Porcentaje:</label>
						<input type="text" id="Porcentaje" name="Porcentaje" maxlength="4" >
					<br>
						<label for="SueldoF"><span class="importante">*</span>S. Fijo:</label>
						<input type="text" id="SueldoF" name="SueldoF" maxlength="5" >
					<br>

					<label for="ReclutadorId">Reclutador:</label>
					<select name="ReclutadorId" id="ReclutadorId">
						<option value="0">Elige</option>
				';
					 $this->ScrollReclutadores($this->getEmpleadoId());
				echo '
					</select>
			</fieldset>

			<fieldset>
				<legend>Contacto Emergencia</legend>
					<br>
						<div class="Izquierda">

							<label for="ParentescoId">Parentesco:</label>
							<select name="ParentescoId" id="ParentescoId">
							<option value="0">Elige</option>
						';
							$this->Scroll('Parentescos','ParentescoId','Parentesco',0, 'TRUE', 'Parentesco');
					echo '
							</select>

							<label for="NombreContacto">Nombre Completo:</label>
							<input type="text" id="NombreContacto" name="NombreContacto" maxlength="150">
							<br>

							<input type="hidden" id="CalleContacto" name="CalleContacto" value="N/A">
							<br>

							<input type="hidden" id="NExteriorContacto" name="NExteriorContacto" value="N/A">
							<br>

							<input type="hidden" id="NInteriorContacto" name="NInteriorContacto" value="N/A">
							<br>
						</div>
						<div class="Derecha">
							<input type="hidden" id="CpContacto" name="CpContacto" value=" ">
							<input type="hidden" id="ColoniaIdContacto" name="ColoniaIdContacto" value="1">

							<label for="TelefonoContacto">Telefono Casa:</label>
							<input type="text" id="TelefonoContacto" name="TelefonoContacto" maxlength="11">
							<br>

							<label for="MovilContacto">Telefono Movil:</label>
							<input type="text" id="MovilContacto" name="MovilContacto" maxlength="11">
							<br>


							<input type="hidden" id="CorreoElectronico" name="CorreoElectronico" value="N/A">

						</div>

				</fieldset>
				<br>
				<br>
			</div>
	';

		echo'
			<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >
					<table id="MiTabla" >
							<thead>
								<tr>
									<th>Plaza</th>
									<th>Punto de Venta</th>
									<th>Selecciona</th>
									<th>Elige</th>
								</tr>
							</thead>
							<tbody>
					';
						$t=true;
						$R0=$this->getPuntosPlaza();
						while($A0=mysql_fetch_row($R0))
						{
							if($t) $Clase='';
							else $Clase='class="alt"';
							echo'
								<tr '.$Clase.'>
								<td>'.utf8_decode($A0[1]).'</td>
								<td>'.utf8_decode($A0[2]).'</td>
								<td align="center"><input type="checkbox" name="PuntoVentaId" id="PuntoVentaId" class="pv" value="'.$A0[0].'" onclick="setSeleccion(this, 1)" /></td>
								<td align="center"><input type="radio" name="PVFisico" id="PVFisico" class="pv" value="'.$A0[0].'"  onclick="setEleccion(this, 1)"/></td>
								</tr>
								';
								$t=(!$t);
						}
					echo'
					</tbody>
					</table>
				</div>
			</div>
			';

}

function displayPersonalEdit($EmpleadoId)
{
	list($EmpleadoId, $Nombre, $Paterno, $Materno, $FechaNacimiento, $Curp, $Rfc, $Ife, $Nss, $Genero,
		 $NacionalidadId, $PuestoId, $SubCategoriaId, $FechaAltaPuesto, $EscolaridadId, $ProfesionId,
		 $EstadoCivilId, $BancoId, $NoCuenta, $Clabe, $ColoniaId, $Colonia, $CodigoPostal, $Calle, $NExterior,
		 $NInterior, $Telefono, $Movil, $TipoSangre, $ParentescoId, $NombreContacto, $ColoniaIdContacto,
		 $ColoniaContacto, $CodigoPostalContacto, $CalleContacto, $NExteriorContacto, $NInteriorContacto,
		 $TelefonoContacto, $MovilContacto, $CorreoElectronico, $Puntos, $Fisico, $CoordinadorId, $ObservacionTh,
		 $Operador, $Porcentaje, $ClasificacionPersonalVentaId, $Mail, $claveAtt)=$this->getEmpleado($EmpleadoId);
$Movimiento='ALTA';
if($Genero=='F')
{
	$F="selected";
	$M='';
}
else
{
	$M="selected";
	$F='';
}

$dia=jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m"),date("d"), date("Y")) , 0 );
if(!$this->isNacional() & $dia!=1)
	$Lectura='disable="disable"';
else
	$Lectura='';

	echo'
	<input type="hidden" id="EmpleadoId" name="EmpleadoId" value="'.$EmpleadoId.'">
	<div class="ConScroll">
			<fieldset>
				<legend>Informacion de Personal</legend>
					<br>
					<div class="Izquierda">

					<img id="Foto" src="Photo/'.$EmpleadoId.'.jpg" />

					<label>Numero de Contro: <span id="nc" name="nc" class="atencion">'.$EmpleadoId.'</span></label>
					<br>
					<label for="Nombre"><span class="importante">*</span>Nombre:</label>
					<input type="text" name="Nombre" id="Nombre" maxlength="25" value="'.$Nombre.'">
					<br>

					<label for="Paterno"><span class="importante">*</span>Apellido Paterno:</label>
					<input type="text" name="Paterno" id="Paterno" maxlength="25" value="'.$Paterno.'">
					<br>

					<label for="Materno"><span class="importante">*</span>Apellido Materno:</label>
					<input type="text" name="Materno" id="Materno" maxlength="25" value="'.$Materno.'">
					<br>

					<label for="FechaNacimiento"><span class="importante">*</span>Fecha de Nacimiento:</label>
					<input type="text" id="FechaNacimiento" name="FechaNacimiento" readonly="readonly" value="'.$FechaNacimiento.'">
					<br>

					<label for="Curp"><span class="importante">*</span>CURP:</label>
					<input type="text" id="Curp" name="Curp" maxlength="20" value="'.$Curp.'">
					<br>

					<label for="Rfc"><span class="importante">*</span>RFC:</label>
					<input type="text" id="Rfc" name="Rfc" maxlength="15" value="'.$Rfc.'">
					<br>

					<label for="Ife"><span class="importante">*</span>Numero de IFE:</label>
					<input type="text" id="Ife" name="Ife" maxlength="13" value="'.$Ife.'">
					<br>

					<label for="Genero"><span class="importante">*</span>Genero:</label>
					<select name="Genero" id="Genero">
							<option value="0" >Elige</option>
							<option value="F" '.$F.'>FEMENINO</option>
							<option value="M" '.$M.'>MASCULINO</option>
					</select>
					<br>

					<label for="NacionalidadId"><span class="importante">*</span>Nacionalidad:</label>
					<select name="NacionalidadId" id="NacionalidadId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('Nacionalidades','NacionalidadId','Nacionalidad',$NacionalidadId, 'TRUE', 'Nacionalidad');
				echo '
					</select>

					<label for="EscolaridadId"><span class="importante">*</span>Escolaridad:</label>
					<select name="EscolaridadId" id="EscolaridadId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('Escolaridades','EscolaridadId','Escolaridad',$EscolaridadId, 'TRUE', 'EscolaridadId');
				echo '
					</select>
					<br>

					<input type="hidden" name="ProfesionId" id="ProfesionId" value="1">

					</div>

					<div class="Derecha">


					<label for="EstadoCivilId"><span class="importante">*</span>Estado Civil:</label>
					<select name="EstadoCivilId" id="EstadoCivilId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('EstadoCivil','EstadoCivilId','EstadoCivil',$EstadoCivilId, 'TRUE', 'EstadoCivil');
				echo '
					</select>
					<br>

					<label for="Calle"><span class="importante">*</span>Calle:</label>
					<input type="text" id="Calle" name="Calle" maxlength="45" value="'.$Calle.'">
					<br>

					<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
					<input type="text" id="NExterior" name="NExterior" maxlength="15" value="'.$NExterior.'">
					<br>

					<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
					<input type="text" id="NInterior" name="NInterior" maxlength="15" value="'.$NInterior.'">
					<br>

					<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
					<input type="text" id="Cp" name="Cp" maxlength="5" value="'.$CodigoPostal.'">
					<br>

					<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
					<select name="ColoniaId" id="ColoniaId">
							<option value="'.$ColoniaId.'">'.$Colonia.'</option>
					</select>
					<br>

					<label for="Telefono"><span class="importante">*</span>Telefono Casa:</label>
					<input type="text" id="Telefono" name="Telefono" maxlength="11" value="'.$Telefono.'">
					<br>

					<label for="Movil"><span class="importante">*</span>Telefono Movil:</label>
					<input type="text" id="Movil" name="Movil" maxlength="11" value="'.$Movil.'">
					<br>

					<label for="Nss"><span class="importante">*</span>Numero de Seguro Social:</label>
					<input type="text" id="Nss" name="Nss" maxlength="12" value="'.$Nss.'">

					<input type="hidden" id="Sangre" name="Sangre" maxlength="20" value=" "">
					<br><br>
					<label for="photo">Foto Personal: <img src="img/Photo.png" id="photo"/></label>
					<br>
					<span class="leyenda" onclick="Documentacion()">Adjuntar Documentacion Personal</span>
					</div>
					<br>

			</fieldset>

			<fieldset>
				<legend>Informacion Laboral</legend>
					<div class="Izquierda">

						<label for="ClasificacionPersonalVentaId"><span class="importante">*</span>Clasificacion Venta:</label>
							<select name="ClasificacionPersonalVentaId" id="ClasificacionPersonalVentaId">
							<option value="0">Elige</option>
						';
							$this->Scroll('ClasificacionPersonalVenta','ClasificacionPersonalVentaId','ClasificacionPersonalVenta',$ClasificacionPersonalVentaId, 'Activo=1', 'ClasificacionPersonalVenta');
				echo '
						</select>
						<br>


						<label for="PuestoId"><span class="importante">*</span>Puesto / Categoria:</label>
						<select name="PuestoId" id="PuestoId"'.$Lectura.' >
								<option value="0">Elige</option>
					';
								$this->Scroll('Puestos','PuestoId','Puesto',$PuestoId, $this->getFiltro(1).' AND Activo=1', 'Puesto');
				echo '
						</select>
						<br>

						<label for="SubCategoriaId"><span class="importante">*</span>Sub Categorias:</label>
						<select name="SubCategoriaId" id="SubCategoriaId" '.$Lectura.'>
								<option value="0">Elige</option>
					';
								$this->Scroll('SubCategorias','SubCategoriaId','SubCategoria',$SubCategoriaId, 'Activo=1', 'SubCategoria');
				echo '
						</select>
						<br>

						<label for="FechaIngreso"><span class="importante">*</span>Fecha de Ingreso:</label>
							<input type="text" id="FechaIngreso" name="FechaIngreso" readonly="readonly" value="'.$FechaAltaPuesto.'">
						<br>
						<label for="BancoId"><span class="importante">*</span>Banco:</label>
						<select name="BancoId" id="BancoId">
								<option value="0">Elige</option>
					';
								$this->Scroll('Bancos','BancoId','Banco',$BancoId, 'TRUE', 'Banco');
				echo '
						</select>
						<br>
						<label for="Cuenta"><span class="importante">*</span>Cuenta Bancaria:</label>
							<input type="text" id="Cuenta" name="Cuenta" maxlength="25" value="'.$NoCuenta.'">
						<br>

						<label for="Clabe"><span class="importante">*</span>Clabe Interbancaria:</label>
							<input type="text" id="Clabe" name="Clabe" maxlength="25" value="'.$Clabe.'">
						<br>

						<label for="Mail"><span class="importante">*</span>Correo Electronico:</label>
							<input type="text" id="Mail" name="Mail" value="'.$Mail.'">
						<br>

						<label for="clave_att"><span class="importante">*</span>Clave AT&T:</label>
							<input type="text" id="clave_att" name="clave_att" maxlength="6" value='.$claveAtt.'>
						<br>


						<label for="Operador"><span class="importante">*</span>Operador:</label>
							<input type="text" id="Operador" name="Operador" maxlength="2" value="'.$Operador.'">
						<br>


						<label for="Porcentaje"><span class="importante">*</span>Porcentaje:</label>
							<input type="text" id="Porcentaje" name="Porcentaje" maxlength="4" value="'.$Porcentaje.'">
						<br>

					</div>
					<div class="Derecha">
					<br>

					<label for="FechaIngresoPunto"><span class="importante">*</span>Fecha de Ingreso al Punto de Venta:</label>
							<input type="text" id="FechaIngresoPunto" name="FechaIngresoPunto" readonly="readonly" value="'.$FechaAltaPuesto.'">
						<br>
						<br>


					<input type="hidden" id="Puntos" name="Puntos" value="'.$Puntos.',">
					<input type="hidden" id="Fisico" name="Fisico" value="'.$Fisico.'">

					<div name="PuntoVentaEdit" id="PuntoVentaEdit" class="leyenda">
					Elegir Puntos de Venta
					</div>
					<br><br>

					<label for="FechaSFijo"><span class="importante">*</span>Fecha inicio S.Fijo:</label>
							<input type="text" id="FechaSFijo" name="FechaSFijo" class="FechaSolicitudImss" readonly="readonly" value="00-00-0000">
					<br>
					<label for="SueldoF"><span class="importante">*</span>S. Fijo:</label>
						<input type="text" id="SueldoF" name="SueldoF" maxlength="5" value="0" >
					<br><br>
						<label for="ObservacionTh">Observaciones:</label>
						<textarea id="ObservacionTh" name="ObservacionTh" class="AreaGS">'.$ObservacionTh.'</textarea>
			</fieldset>

			<fieldset>
				<legend>Informacion IMSS</legend>
					<br>
						<div class="center">
						<div id="HImss" class="datagrid" >
								<table id="MiTablas" >
							<thead>
								<tr>
									<th>Fecha de Solicitud</th>
									<th>Fecha de Movimiento</th>
									<th>Salario Diario Integrado</th>
									<th>Concepto</th>
								</tr>
							</thead>
							<tbody>
					';
								$Indices="";
								$t=true;
								$R0=$this->getHistorialImss($EmpleadoId);
								while($A0=mysql_fetch_row($R0))
								{
									if($t) $Clase='';
									else $Clase='class="alt"';
									echo'
										<tr '.$Clase.'>
											<td><input type="text" id="FechaSImss'.$A0[0].'" name="FechaSImss'.$A0[0].'" readonly="readonly" value="'.$A0[1].'" class="FechaSolicitudImss"></td>
											<td><input type="text" id="FechaMImss'.$A0[0].'" name="FechaMImss'.$A0[0].'" readonly="readonly" value="'.$A0[2].'" class="FechaAltaImss"><img src="img/Clean.png" id="btClean" onclick="resetDate(FechaMImss'.$A0[0].')" ></td>
											<td><input type="text" id="SD'.$A0[0].'" name="SD'.$A0[0].'"  value="'.$A0[3].'" ></td>
											<td>'.$A0[4].'</td>
										</tr>
										';
									$t=(!$t);
									$Indices=$Indices.$A0[0].",";
									$Movimiento=$A0[4];
								}
					if($Movimiento=='ALTA')
						$Movimiento='BAJA';
					else
						$Movimiento='ALTA';
					echo'

							<thead>
								<tr >
									<th colspan="4" align="center">Registro nuevo de IMSS</th>
								</tr>
							</thead>
							<tr>
									<td><input type="text" id="FechaSolImss" name="FechaSolImss" readonly="readonly" value="00-00-0000" class="FechaSolicitudImss"></td>
									<td><input type="text" id="FechaMovImss" name="FechaMovImss" readonly="readonly" value="00-00-0000" class="FechaAltaImss"><img src="img/Clean.png" id="btClean" onclick="resetDate(FechaMImss)" ></td>
									<td><input type="text" id="SDI" name="SDI"  value="0" ></td>
									<td>'.$Movimiento.'</td>
							</tr>
							</tbody>
							</table>
							<input type="hidden" id="indices" name="indices" value="'.substr($Indices,0,strlen($Indices)-1).'" />
							<input type="hidden" id="TipoMovimiento" name="TipoMovimiento" value="'.substr($Movimiento, 0,0).'" />
							</div>
						</div>

				</fieldset>

			<fieldset>
				<legend>Contacto Emergencia</legend>
					<br>
						<div class="Izquierda">

							<label for="ParentescoId"><span class="importante">*</span>Parentesco:</label>
							<select name="ParentescoId" id="ParentescoId">
							<option value="0">Elige</option>
						';
							$this->Scroll('Parentescos','ParentescoId','Parentesco',$ParentescoId, 'TRUE', 'Parentesco');
					echo '
							</select>

							<label for="NombreContacto"><span class="importante">*</span>Nombre Completo:</label>
							<input type="text" id="NombreContacto" name="NombreContacto" maxlength="150" value="'.$NombreContacto.'">

							<input type="hidden" id="CalleContacto" name="CalleContacto" value="N/A">
							<br>


							<input type="hidden" id="NExteriorContacto" name="NExteriorContacto" value="N/A">
							<br>

							<input type="hidden" id="NInteriorContacto" name="NInteriorContacto" value="N/A">
							<br>
						</div>
						<div class="Derecha">
							<input type="hidden" id="CpContacto" name="CpContacto" value=" ">
							<input type="hidden" id="ColoniaIdContacto" name="ColoniaIdContacto" value="1">

							<label for="TelefonoContacto"><span class="importante">*</span>Telefono Casa:</label>
							<input type="text" id="TelefonoContacto" name="TelefonoContacto" maxlength="11" value="'.$TelefonoContacto.'">
							<br>

							<label for="MovilContacto"><span class="importante">*</span>Telefono Movil:</label>
							<input type="text" id="MovilContacto" name="MovilContacto" maxlength="11" value="'.$MovilContacto.'">
							<br>

							<input type="hidden" id="CorreoElectronico" name="CorreoElectronico" value="N/A">

						</div>

				</fieldset>
				<br>
				<br>
			</div>
	';
			echo'
			<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >
							<table id="MiTabla" >
							<thead>
								<tr>
									<th>Plaza</th>
									<th>Punto de Venta</th>
									<th>Selecciona</th>
									<th>Elige</th>
								</tr>
							</thead>
							<tbody>
					';
								$t=true;
								$R0=$this->getPuntosEmpleado($EmpleadoId);
								while($A0=mysql_fetch_row($R0))
								{
									if($t) $Clase='';
									else $Clase='class="alt"';

									if($A0[3]>0)
										$ch='checked="checked"';
									else
										$ch="";
									if($A0[4]>0)
										$ra='checked="checked"';
									else
										$ra="";
										echo'
												<tr '.$Clase.'>
													<td>'.utf8_decode($A0[1]).'</td>
													<td>'.utf8_decode($A0[2]).'</td>
													<td align="center"><input type="checkbox" '.$ch.' name="PuntoVentaId" id="PuntoVentaId" class="pv" value="'.$A0[0].'" onclick="setSeleccion(this, 1)" /></td>
													<td align="center"><input type="radio" '.$ra.' name="PVFisico" id="PVFisico" class="pv" value="'.$A0[0].'"  onclick="setEleccion(this, 1)"/></td>
												</tr>
										';
									$t=(!$t);
								}
					echo'
							</tbody>
							</table>
				</div>
			</div>
			';
}

function displayInactivosEdit($EmpleadoId)
{
	list($HistorialPuestoEmpleadoId, $Nombre, $Finiquito, $ObservacionesTH, $HistorialEmpleadoImss, $FechaSolicitud, $Fecha)=$this->getInactivoEdit($EmpleadoId);
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion Laboral</legend>
				<br>
				<div class="Izquierda">
					'.$Nombre.'
					<input type="hidden" name="HistorialPuestoEmpleadoId" id="HistorialPuestoEmpleadoId" value="'.$HistorialPuestoEmpleadoId.'">
					<input type="hidden" name="HistorialEmpleadoImss" id="HistorialEmpleadoImss" value="'.$HistorialEmpleadoImss.'">
					<input type="hidden" name="EmpleadoId" id="EmpleadoId" value="'.$EmpleadoId.'">
					<br>
					<br>
				<label for="FechaSolicitudImss">Fecha de Solicitud de Baja IMSS:</label>
					<input type="text" id="FechaSolicitudImss" name="FechaSolicitudImss" readonly="readonly" value="'.$FechaSolicitud.'">
					<br>
				<label for="FechaAltaImss">Fecha de Baja IMSS:</label>
					<input type="text" id="FechaAltaImss" name="FechaAltaImss" readonly="readonly" value="'.$Fecha.'">
					<br>
				</div>
				<div class="Derecha">
				<label for="Finiquito">Finiquito:</label>
					<input type="text" name="Finiquito" id="Finiquito" value="'.$Finiquito.'">
					<br>
					<label for="ObservacionesTH">Observaciones:</label>
					<textarea id="ObservacionesTH" name="ObservacionesTH" class="txAreaLong">'.$ObservacionesTH.'</textarea>
				</div>
		</fieldset>
	';
}

/*VENTANILLA::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/

function displayVentanilla()
{
	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<label for="PlataformaId"><span class="importante">*</span>Plataforma:</label>
					<select name="PlataformaId" id="PlataformaId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plataformas','PlataformaId','Plataforma', 0, 'ACTIVO=1', 'Plataforma');
				echo'
				</select>
				
				

				<br>
				<div class="Izquierda">
					<input type="hidden" id="ClasificacionPersonalVenta" name="ClasificacionPersonalVenta" value="'.$ClasificacionPersonalVenta.'" />
					<label for="TipoContratacionId"><span class="importante">*</span>Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', 0, 'ACTIVO=1', 'Tipocontratacion');
					echo'
					</select>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio:</label>
					<input type="text" name="Folio" id="Folio" maxlength="16">
					<br>

				<label for="FechaContrato"><span class="importante">*</span>Fecha de Contrato/Activacion:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly">
					<br>
				';
/*
				if($ClasificacionPersonalVenta==4 || $ClasificacionPersonalVenta==6)
				{
				echo'
				<label for="ContratacionId"><span class="importante">*</span>Contratacion:</label>
				<select name="ContratacionId" id="ContratacionId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Contrataciones','ContratacionId','Contratacion', 0, 'ACTIVO=1', 'Contratacion');
				echo'
				</select>
				';
				}
				else
					echo'<input type="hidden" id="ContratacionId" name="ContratacionId" value="0" />';
*/
				echo'
				<label for="ContratacionId"><span class="importante">*</span>Contratacion:</label>
				<select name="ContratacionId" id="ContratacionId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Contrataciones','ContratacionId','Contratacion', 0, 'ACTIVO=1', 'Contratacion');
				echo'
				</select>
				';


				echo'
				<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', 0, 'ACTIVO=1 AND VU=1', 'TipoPago');
				echo'
				</select>

				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="0"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria"><span class="importante">*</span>Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Datos del Cliente</legend>
				<br>
				<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>
					<label>Referencias: <img src="img/Add.png" id="AddReferencia"/></label>
				</div>
				<div class="Derecha">

					<div class="datagrid">
						<div id="displayRef"></div>
				</div>
		</fieldset>

<fieldset>
			<legend>Registro de Lineas</legend>
				<br>
				<div class="Izquierda">

					<label for="Equipo"><span class="importante">*</span>Equipo:</label>
					<input type="text" name="Equipo" id="Equipo" readonly="readonly">
					<input type="hidden" name="EquipoId" id="EquipoId" value="0" />
					<br>
					<label for="Plan"><span class="importante">*</span>Plan de Contratacion:</label>
					<input type="text" name="Plan" id="Plan" readonly="readonly">
					<input type="hidden" name="PlanId" id="PlanId" value="0" />
					<input type="hidden" name="TipoPlanId" id="TipoPlanId" value="0" />

					<label>Add ON: <img src="img/Add.png" id="AddAddon"/></label>
					<input type="hidden" name="AddOnes" id="AddOnes" />

				<!--
					<br>
					<label>Servicios Adicionales: <img src="img/Add.png" id="AddServ"/></label>
				-->
					<input type="hidden" name="OtrosServ" id="OtrosServ" />
					<br>

					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plazos','PlazoId','Plazo', 0, 'IUSA=1 AND ACTIVO=1', 'Plazo');
				echo'
				</select>
				<br>
					<label for="Comentariol">Comentarios:</label>
					<textarea id="ComentarioL" name="ComentarioL"></textarea>
				<br>
					<label>Agregar Linea: <img src="img/Add.png" id="AddLinea"/></label>

				</div>
				<div class="Derecha">

					<div class="datagrid">
					<div id="displayLineas"></div>
				</div>
		</fieldset>

	</div>
	';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="AddOn" class="dialogo" title="Elegir ADD ON" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="Addons" class="datagrid">';
		 	echo $this->getListaAddOn();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="SAdicional" class="dialogo" title="Elegir Servicio Adicional" >
			Buscar:&nbsp<input id="Busqueda4" class="Busqueda" type="text">
			<div id="servisio" class="datagrid">';
		 	echo $this->getListaServicios();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="NReferencia" class="dialogo" title="Registrar Referencia" >
		<div class="Izquierda">
			<label for="ParentescoReferenciaId"><span class="importante">*</span>Parentesco:</label>
				<select name="ParentescoReferenciaId" id="ParentescoReferenciaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Parentescos','ParentescoId','Parentesco', 0, 'ACTIVO=1', 'Parentesco');
				echo'
				</select>
			<br>
			<label for="NombreR"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreR" id="NombreR" maxlength="30">
			<br>
			<label for="PaternoR"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoR" id="PaternoR" maxlength="30" >
			<br>
			<label for="MaternoR"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoR" id="MaternoR" maxlength="30">
			<br>
		</div>
		<div class="Derecha">
			<label for="TelefonoR"><span class="importante">*</span>Telefono:</label>
				<input type="text" name="TelefonoR" id="TelefonoR" maxlength="11">
			<br>
			<label for="MailR">Correo Electronico:</label>
				<input type="text" name="MailR" id="MailR" maxlength="40">
			<br>
			<input type="button" class="guardar" id="Crear" name="Crear">

		</div>
		</div>
		';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj"  type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">

		</div>
		</div>
		';

		echo'
		<div id="Equipos" class="dialogo" title="Elegir Equipo" >
			Buscar:&nbsp<input id="Busqueda6" class="Busqueda" type="text">
			<div id="Moviles" class="datagrid">';
		 	echo $this->getListaEquipos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Planes" class="dialogo" title="Elegir Plan" >
			Buscar:&nbsp<input id="Busqueda7" class="Busqueda" type="text">
			<div id="MisPlanes" class="datagrid">';
		 	echo $this->getListaPlanes();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayVentanillaEdit($Folio)
{
	$Folio=str_replace(',', '', $Folio);
	list($TipoContratacionId, $FContratacion, $FSS, $TipoPagoId, $PuntoVentaId, $PuntoVenta, $EmpleadoId, $Empleado, $SubCategoriaId, $SubCategoria, $CoordinadorId, $Coordinador, $Comentarios, $ClienteId, $Cliente, $RFC, $Clave)=$this->getHFolio($Folio);

	$this->PreparaLineas($Folio, $Clave);
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">

					<label for="TipoContratacionId"><span class="importante">*</span>Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', $TipoContratacionId, 'TRUE', 'Tipocontratacion');
					echo'
					</select>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio:</label>
					<input type="text" name="Folio" id="Folio" maxlength="6" value="'.$Folio.'">
					<br>

				<label for="FechaContrato"><span class="importante">*</span>Fecha de Contrato:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly" value="'.$FContratacion.'">
					<br>

				<label for="FechaSS"><span class="importante">*</span>Fecha de Ingreso a SVU:</label>
					<input type="text" id="FechaSS" name="FechaSS" readonly="readonly" value="'.$FSS.'">
					<br>

				<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', $TipoPagoId, 'TRUE AND VU=1', 'TipoPago');
				echo'
				</select>


				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly" value="'.$Empleado.'">
					<input type="hidden" name="VendedorId" id="VendedorId" value="'.$EmpleadoId.'" />
					<br>

					<label for="Categoria"><span class="importante">*</span>Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly" value="'.$SubCategoria.'">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly" value="'.$Coordinador.'">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="'.$CoordinadorId.'" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios">'.$Comentarios.'</textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Datos del Cliente</legend>
				<br>
				<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly" value="'.$Cliente.'">
					<input type="hidden" name="ClienteId" id="ClienteId" value="'.$ClienteId.'" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly" value="'.$RFC.'">
					<br>
					<label>Referencias: <img src="img/Add.png" id="AddReferencia"/></label>
				</div>
				<div class="Derecha">

					<div class="datagrid">
						<div id="displayRef"></div>
				</div>
		</fieldset>

		<fieldset >
			<legend>Registro de Lineas</legend>
				<br>
				<div class="Izquierda">

					<label for="Equipo"><span class="importante">*</span>Equipo:</label>
					<input type="text" name="Equipo" id="Equipo" readonly="readonly">
					<input type="hidden" name="EquipoId" id="EquipoId" value="0" />

					<label for="Plan"><span class="importante">*</span>Plan de Contratacion:</label>
					<input type="text" name="Plan" id="Plan" readonly="readonly">
					<input type="hidden" name="PlanId" id="PlanId" value="0" />
					<input type="hidden" name="TipoPlanId" id="TipoPlanId" value="0" />

					<label>Add ON: <img src="img/Add.png" id="AddAddon"/></label>
					<input type="hidden" name="AddOnes" id="AddOnes" />

					<label>Servicios Adicionales: <img src="img/Add.png" id="AddServ"/></label>
					<input type="hidden" name="OtrosServ" id="OtrosServ" />

					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plazos','PlazoId','Plazo', 0, 'Iusa=1 AND ACTIVO=1', 'Plazo');
				echo'
				</select>

					<br>
					<label>Agregar Linea: <img src="img/Add.png" id="AddLinea"/></label>


				</div>
				<div class="Derecha">

					<div class="datagrid">
						<div id="displayLineas">
						';

						echo $this->getListaLineas($Clave);
						echo'
						</div>
				</div>
		</fieldset>

	</div>
	';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="AddOn" class="dialogo" title="Elegir ADD ON" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="Addons" class="datagrid">';
		 	echo $this->getListaAddOn();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="SAdicional" class="dialogo" title="Elegir Servicio Adicional" >
			Buscar:&nbsp<input id="Busqueda4" class="Busqueda" type="text">
			<div id="servisio" class="datagrid">';
		 	echo $this->getListaServicios();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="NReferencia" class="dialogo" title="Registrar Referencia" >
		<div class="Izquierda">
			<label for="ParentescoReferenciaId"><span class="importante">*</span>Parentesco:</label>
				<select name="ParentescoReferenciaId" id="ParentescoReferenciaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Parentescos','ParentescoId','Parentesco', 0, 'ACTIVO=1', 'Parentesco');
				echo'
				</select>
			<br>
			<label for="NombreR"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreR" id="NombreR" maxlength="30">
			<br>
			<label for="PaternoR"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoR" id="PaternoR" maxlength="30" >
			<br>
			<label for="MaternoR"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoR" id="MaternoR" maxlength="30">
			<br>
		</div>
		<div class="Derecha">
			<label for="TelefonoR"><span class="importante">*</span>Telefono:</label>
				<input type="text" name="TelefonoR" id="TelefonoR" maxlength="11">
			<br>
			<label for="MailR">Correo Electronico:</label>
				<input type="text" name="MailR" id="MailR" maxlength="40">
			<br>
			<input type="button" class="guardar" id="Crear" name="Crear">

		</div>
		</div>
		';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj" type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">

		</div>
		</div>
		';

		echo'
		<div id="Equipos" class="dialogo" title="Elegir Equipo" >
			Buscar:&nbsp<input id="Busqueda6" class="Busqueda" type="text">
			<div id="Moviles" class="datagrid">';
		 	echo $this->getListaEquipos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Planes" class="dialogo" title="Elegir Plan" >
			Buscar:&nbsp<input id="Busqueda7" class="Busqueda" type="text">
			<div id="MisPlanes" class="datagrid">';
		 	echo $this->getListaPlanes();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayPrecaptura()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
				<label for="PlataformaId"><span class="importante">*</span>Plataforma:</label>
					<select name="PlataformaId" id="PlataformaId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plataformas','PlataformaId','Plataforma', 0, 'ACTIVO=1', 'Plataforma');
				echo'
				</select>
				<br>

				<label for="TipoVentaId"><span class="importante">*</span>Tipo de Venta:</label>
					<select name="TipoVentaId" id="TipoVentaId">
					<option value="0">Elige</option>
					<option value="1">Prepago</option>
					<option value="2">Pospago</option>
					</select>
					<br>

				<input type="hidden" id="ClasificacionPersonalVenta" name="ClasificacionPersonalVenta" value="'.$ClasificacionPersonalVenta.'" />
					<label for="TipoContratacionId"><span class="importante">*</span>Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', 0, 'ACTIVO=1', 'Tipocontratacion');
					echo'
					</select>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio / Solicitud:</label>

					';

				//if($ClasificacionPersonalVenta==4 || $ClasificacionPersonalVenta==6)
				//{
					echo'<input type="text" name="FolioPO" id="FolioPO" maxlength="20" >
						<label for="FechaSS"><span class="importante">*</span>Fecha de Activacion:</label>
						<input type="text" id="FechaSS" name="FechaSS" value="">

					<label for="ContratacionId"><span class="importante">*</span>Contratacion:</label>
				<select name="ContratacionId" id="ContratacionId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Contrataciones','ContratacionId','Contratacion', 0, 'ACTIVO=1', 'Contratacion');
				echo'
				</select>
				';
				//}
/*
					else
					{
					echo'<input type="text" name="Folio" id="Folio" maxlength="20" >
					<input type="hidden" id="FechaSS" name="FechaSS" value="'.$hoy.'">
					<input type="hidden" id="ContratacionId" name="ContratacionId" value="0">';
						}
						*/
				echo'
					<br>
					<input type="hidden" id="FechaContrato" name="FechaContrato" value="'.$hoy.'">
					<input type="hidden" id="ClasificacionPersonalVenta" name="ClasificacionPersonalVenta" value="'.$ClasificacionPersonalVenta.'">

				<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', 0, 'ACTIVO=1', 'TipoPago');
				echo'
				</select>


				</div>

				<div class="Derecha">
				';
/*
				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>
*/
				echo'
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Datos del Cliente</legend>
				<br>
				<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>
					<label>Referencias: <img src="img/Add.png" id="AddReferencia"/></label>
				</div>
				<div class="Derecha">
					<div class="datagrid">
						<div id="displayRef"></div>
				</div>
		</fieldset>

		';




/*
		<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Estatus_Actual</th>
				<th bgcolor="#BFD5EA" >Nuevo_Estatus</th>
				<th bgcolor="#BFD5EA" >Fecha_Estatus</th>
				<th bgcolor="#BFD5EA" >Comentario</th>
				<th bgcolor="#BFD5EA" >Contrato</th>
				<th bgcolor="#BFD5EA" >DN</th>
				<th bgcolor="#BFD5EA" >Controles</th>

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td align="center" valign="midle">'.$this->getEstatusPosible($A0[4],$A0[0]).'</td>
		<td align="center" valign="midle"><input type="text" id="FechaEstatus'.$A0[0].'" name="FechaEstatus'.$A0[0].'" class="FechaEstatus" value="'.date('d/m/Y').'" readonly="readonly"></td>
		<td align="center" valign="midle"><textarea id="Comentarios'.$A0[0].'" name="Comentarios'.$A0[0].'">'.$A0[5].'</textarea></td>
		<td align="center" valign="midle"><input type="text" id="Contrato'.$A0[0].'" name="Contrato'.$A0[0].'" class="contrato" maxlength="8" value="'.$A0[6].'"></td>
		<td align="center" valign="midle"><input type="text" id="DN'.$A0[0].'" name="DN'.$A0[0].'" value="'.$A0[8].'"></td>
		<td align="center" valign="midle"><input type="button" class="guardar" id="Actualiza" name="Actualiza" value="Guardar" onclick="ActualizaEstatus('.$A0[0].','.$A0[7].')"></td>
		</tr>';
		}
		echo '</tbody></table>
*/

	echo'
		</fieldset>
		<br>
	</div>
	';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="NReferencia" class="dialogo" title="Registrar Referencia" >
		<div class="Izquierda">
			<label for="ParentescoReferenciaId"><span class="importante">*</span>Parentesco:</label>
				<select name="ParentescoReferenciaId" id="ParentescoReferenciaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Parentescos','ParentescoId','Parentesco', 0, 'ACTIVO=1', 'Parentesco');
				echo'
				</select>
			<br>
			<label for="NombreR"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreR" id="NombreR" maxlength="30">
			<br>
			<label for="PaternoR"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoR" id="PaternoR" maxlength="30" >
			<br>
			<label for="MaternoR"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoR" id="MaternoR" maxlength="30">
			<br>
		</div>
		<div class="Derecha">
			<label for="TelefonoR"><span class="importante">*</span>Telefono:</label>
				<input type="text" name="TelefonoR" id="TelefonoR" maxlength="11">
			<br>
			<label for="MailR">Correo Electronico:</label>
				<input type="text" name="MailR" id="MailR" maxlength="40">
			<br>
			<input type="button" class="guardar" id="Crear" name="Crear">

		</div>
		</div>
		';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj" type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="Pat
				rnoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contactos:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">
		</div>

		</div>

		';

		/*FIN VENTANAS*/
}

/*Formulario para nuevo diseño de originacion*/
function displayOriginacionV2()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
		
				<label for="PlataformaId"><span class="importante">*</span>Plataforma:</label>
					<select name="PlataformaId" id="PlataformaId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plataformas','PlataformaId','Plataforma', 0, 'ACTIVO=1', 'Plataforma');
				echo'
				</select>
				<br>

				<label for="TipoVentaId"><span class="importante">*</span>Tipo de Venta:</label>
					<select name="TipoVentaId" id="TipoVentaId">
					<option value="0">Elige</option>
					<option value="1">Prepago</option>
					<option value="2">Pospago</option>
					</select>
					<br>

				<input type="hidden" id="ClasificacionPersonalVenta" name="ClasificacionPersonalVenta" value="'.$ClasificacionPersonalVenta.'" />
					<label for="TipoContratacionId"><span class="importante">*</span>Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', 0, 'ACTIVO=1', 'Tipocontratacion');
					echo'
					</select>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio / Solicitud:</label>

					';

				//if($ClasificacionPersonalVenta==4 || $ClasificacionPersonalVenta==6)
				//{
					echo'<input type="text" name="FolioPO" id="FolioPO" maxlength="20" >
						<label for="FechaSS"><span class="importante">*</span>Fecha de Activacion:</label>
						<input type="text" id="FechaSS" name="FechaSS" value="">

					<label for="ContratacionId"><span class="importante">*</span>Contratacion:</label>
				<select name="ContratacionId" id="ContratacionId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Contrataciones','ContratacionId','Contratacion', 0, 'ACTIVO=1', 'Contratacion');
				echo'
				</select>
				';
				//}
/*
					else
					{
					echo'<input type="text" name="Folio" id="Folio" maxlength="20" >
					<input type="hidden" id="FechaSS" name="FechaSS" value="'.$hoy.'">
					<input type="hidden" id="ContratacionId" name="ContratacionId" value="0">';
						}
						*/
				echo'
					<br>
					<input type="hidden" id="FechaContrato" name="FechaContrato" value="'.$hoy.'">
					<input type="hidden" id="ClasificacionPersonalVenta" name="ClasificacionPersonalVenta" value="'.$ClasificacionPersonalVenta.'">

				<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', 0, 'ACTIVO=1', 'TipoPago');
				echo'
				</select>


				</div>

				<div class="Derecha">
				';
/*
				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>
*/
				echo'
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Datos del Cliente</legend>
				<br>
				<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>
					<label>Referencias: <img src="img/Add.png" id="AddReferencia"/></label>
				</div>
				<div class="Derecha">
					<div class="datagrid">
						<div id="displayRef"></div>
				</div>
		</fieldset>

		';




/*
		<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Estatus_Actual</th>
				<th bgcolor="#BFD5EA" >Nuevo_Estatus</th>
				<th bgcolor="#BFD5EA" >Fecha_Estatus</th>
				<th bgcolor="#BFD5EA" >Comentario</th>
				<th bgcolor="#BFD5EA" >Contrato</th>
				<th bgcolor="#BFD5EA" >DN</th>
				<th bgcolor="#BFD5EA" >Controles</th>

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td align="center" valign="midle">'.$this->getEstatusPosible($A0[4],$A0[0]).'</td>
		<td align="center" valign="midle"><input type="text" id="FechaEstatus'.$A0[0].'" name="FechaEstatus'.$A0[0].'" class="FechaEstatus" value="'.date('d/m/Y').'" readonly="readonly"></td>
		<td align="center" valign="midle"><textarea id="Comentarios'.$A0[0].'" name="Comentarios'.$A0[0].'">'.$A0[5].'</textarea></td>
		<td align="center" valign="midle"><input type="text" id="Contrato'.$A0[0].'" name="Contrato'.$A0[0].'" class="contrato" maxlength="8" value="'.$A0[6].'"></td>
		<td align="center" valign="midle"><input type="text" id="DN'.$A0[0].'" name="DN'.$A0[0].'" value="'.$A0[8].'"></td>
		<td align="center" valign="midle"><input type="button" class="guardar" id="Actualiza" name="Actualiza" value="Guardar" onclick="ActualizaEstatus('.$A0[0].','.$A0[7].')"></td>
		</tr>';
		}
		echo '</tbody></table>
*/

	echo'
		</fieldset>
		<br>
	</div>
	';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="NReferencia" class="dialogo" title="Registrar Referencia" >
		<div class="Izquierda">
			<label for="ParentescoReferenciaId"><span class="importante">*</span>Parentesco:</label>
				<select name="ParentescoReferenciaId" id="ParentescoReferenciaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Parentescos','ParentescoId','Parentesco', 0, 'ACTIVO=1', 'Parentesco');
				echo'
				</select>
			<br>
			<label for="NombreR"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreR" id="NombreR" maxlength="30">
			<br>
			<label for="PaternoR"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoR" id="PaternoR" maxlength="30" >
			<br>
			<label for="MaternoR"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoR" id="MaternoR" maxlength="30">
			<br>
		</div>
		<div class="Derecha">
			<label for="TelefonoR"><span class="importante">*</span>Telefono:</label>
				<input type="text" name="TelefonoR" id="TelefonoR" maxlength="11">
			<br>
			<label for="MailR">Correo Electronico:</label>
				<input type="text" name="MailR" id="MailR" maxlength="40">
			<br>
			<input type="button" class="guardar" id="Crear" name="Crear">

		</div>
		</div>
		';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj" type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="Pat
				rnoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contactos:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">
		</div>

		</div>

		';

		/*FIN VENTANAS*/
}






















	function drawTablaDescargas($R0, $Icono)
	{
		$Orden=$this->getOrden($R0);
		$i=0;
		$titulos = array();
	echo '
		<span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<div  class="tableContainer">
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">';
		while($A0=mysql_fetch_row($R0))
		{
		if($i==0)
				{
					echo'<thead class="fixedHeader"><tr>';
						for($j=0; $j<$Orden['columnas']; $j++)
							{
							if ($j==0)
								{
										echo '<th bgcolor="#BFD5EA" valign="midle" width="3%">'.utf8_decode($A0[$j]).'&nbsp&nbsp</th>';
										$titulos[$j]=$A0[$j];
								}
							else
								{
									echo '<th bgcolor="#BFD5EA" id="'.utf8_decode($A0[$j]).'">'.utf8_decode($A0[$j]).'</th>';
									$titulos[$j]=$A0[$j];

								}
							}
					echo '</tr></thead>
							<tbody class="scrollContent">';
				}
				else
				{
					echo'<tr>';
					for($j=0; $j<$Orden['columnas']; $j++)
						{
						if ($j==0)
									echo '<td align="center">
											<img src="img/'.$Icono.'.png" align="absbottom" width="15" height="15" onclick="'.$A0[$j].'" />
										  </td>
										  ';
						else
									echo '<td headers="'.$titulos[$j].'">'.$A0[$j].'</td>';
						}
				}
			echo '</tr>';
			$i++;
		}
		echo '</tbody></table>

		';
	}

	function drawCumpleaños()
	{
		$R0=$this->getCumpedelmes();
		$Orden=$this->getOrden($R0);
		$i=0;
		$titulos = array();
	echo '
		<span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<div  class="tableContainer">
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">';
		while($A0=mysql_fetch_row($R0))
		{
		if($i==0)
				{
					echo'<thead class="fixedHeader"><tr>';
						for($j=0; $j<$Orden['columnas']-1; $j++)
							{
							if ($j==0)
								{
										echo '<th bgcolor="#BFD5EA" valign="midle" width="50" >'.utf8_decode($A0[$j]).'&nbsp&nbsp</th>';
										$titulos[$j]=$A0[$j];
								}
							else
								{
									echo '<th bgcolor="#BFD5EA" id="'.utf8_decode($A0[$j]).'">'.$A0[$j].'</th>';
									$titulos[$j]=$A0[$j];

								}
							}
					echo '</tr></thead>
							<tbody class="scrollContent">';
				}
				else
				{
					echo'<tr>';
					for($j=0; $j<$Orden['columnas']-1; $j++)
						{
						if ($j==0)
									echo '<td align="center">
											<img src="img/'.$A0[$Orden['columnas']-1].'.png" align="absbottom" width="18" height="18" onclick="alert(\'happy birthday!!! '.$A0[0].'\')" />
										  </td>
										  ';
						else
									echo '<td headers="'.$titulos[$j].'">'.$A0[$j].'</td>';
						}
				}
			echo '</tr>';
			$i++;
		}
		echo '</tbody></table>

		';
	}


	function drawTablaEstatusEquipos($Folio)
	{
		$R0=$this->getChangeEstatus($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Estatus_Actual</th>
				<th bgcolor="#BFD5EA" >Nuevo_Estatus</th>
				<th bgcolor="#BFD5EA" >Fecha_Estatus</th>
				<th bgcolor="#BFD5EA" >Comentario</th>
				<th bgcolor="#BFD5EA" >Contrato</th>
				<th bgcolor="#BFD5EA" >DN</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >Controles</th>

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[9].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td align="center" valign="midle">'.$this->getEstatusPosible($A0[4],$A0[0]).'</td>
		<td align="center" valign="midle"><input type="text" id="FechaEstatus'.$A0[0].'" name="FechaEstatus'.$A0[0].'" class="FechaEstatus" value="'.date('d/m/Y').'" readonly="readonly"></td>
		<td align="center" valign="midle"><textarea id="Comentarios'.$A0[0].'" name="Comentarios'.$A0[0].'">'.$A0[5].'</textarea></td>
		<td align="center" valign="midle"><input type="text" id="Contrato'.$A0[0].'" name="Contrato'.$A0[0].'" class="contrato" maxlength="8" value="'.$A0[6].'"></td>
		<td align="center" valign="midle"><input type="text" id="DN'.$A0[0].'" name="DN'.$A0[0].'" value="'.$A0[8].'"></td>
		<td align="center" valign="midle">'.$A0[10].'</td>
		<td align="center" valign="midle"><input type="button" class="guardar" id="Actualiza" name="Actualiza" value="Guardar" onclick="ActualizaEstatus('.$A0[0].','.$A0[7].')"></td>
		</tr>';
		}
		echo '</tbody></table>
		';
	}

	function drawTablaAddEquipos($Folio)
	{
		$R0=$this->getChangeEstatus($Folio);
	echo'<input type="hidden" id="Modo" name="Modo" value="2"><br>';
	echo '
		<span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Estatus_Actual</th>
				<th bgcolor="#BFD5EA" >Nuevo_Estatus</th>
				<th bgcolor="#BFD5EA" >Fecha_Estatus</th>
				<th bgcolor="#BFD5EA" >Comentario</th>
				<th bgcolor="#BFD5EA" >Controles</th>
			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td align="center" valign="midle">'.$this->getEstatusPosible($A0[4],$A0[0]).'</td>
		<td align="center" valign="midle"><input type="text" id="FechaEstatus'.$A0[0].'" name="FechaEstatus'.$A0[0].'" class="FechaEstatus" value="'.date('d/m/Y').'" readonly="readonly"></td>
		<td align="center" valign="midle"><textarea id="Comentarios'.$A0[0].'" name="Comentarios'.$A0[0].'"></textarea></td>
		<td align="center" valign="midle"><input type="button" class="guardar" id="Actualiza" name="Actualiza" onclick="ActualizaEstatus('.$A0[0].','.$A0[7].')"></td>
		</tr>';
		}
		echo '</tbody></table>

		';
	}

	function drawaddEquipo($PlataformaId,$FamiliaPlanId){
					if(($PlataformaId==1) && ($FamiliaPlanId!=4)){
						echo '
							<input type="hidden" name="csequipoAux" id="csequipoAux" value="0">
						';
					}else{
						echo '
						<label for="csequipo"><span class="importante">*</span>Tipo de Venta:</label>
							<input type="hidden" name="csequipoAux" id="csequipoAux" value="1">
							<select name="csequipo" id="csequipo">
								<option value="0">Elige</option>
								<option value="1">Con Equipo</option>
								<option value="2">Sin Equipo</option>
							</select>
						';
					}
		echo'
					
					
					
					<br>
					<div id="column1">
					<label for="Lectura"><span class="importante">*</span>Codigo Equipo:</label>
					<input type="text" name="Lectura" id="Lectura">
					<label for="Equipo"> Descripcion Equipo:</label>
					<input type="text" name="Equipo" id="Equipo" readonly="readonly">
					<br>
					
			';
					if(($PlataformaId==1) && ($FamiliaPlanId==3 || $FamiliaPlanId==4 || $FamiliaPlanId==6))
					echo'
										
						<label for="codigo_sim"><span class="importante">*</span>SIM:</label>
						<input type="text" name="codigo_sim" id="codigo_sim">
						
					';else
					echo '<input type="hidden" name="codigo_sim" id="codigo_sim" value="0">';
					if(($PlataformaId==1)  && ($FamiliaPlanId==3 || $FamiliaPlanId==4 || $FamiliaPlanId==6))
					echo'
					<label for="DSim">Descripcion SIM:</label>
					<input type="text" name="DSim" id="DSim" readonly="readonly" value="">
					';
					else
					echo'<input type="hidden" name="DSim" id="DSim" value="x">';

		echo'  				
					</div>
					<div id="column2">
					<label for="Plan"><span class="importante">*</span>Plan de Contratacion:</label>
					<input type="text" name="Plan" id="Plan" readonly="readonly">
					<input type="hidden" name="PlanId" id="PlanId" value="0" />
					<input type="hidden" name="TipoPlanId" id="TipoPlanId" value="0" /><br>
					';

		echo '
					<label for="Dn"><span class="importante">*</span>Dn:</label>
					<input type="text" name="Dn" id="Dn" maxlength="10">
					<br><br>
					<label for="Diferencial">Diferencial:</label>
					<input type="text" name="Diferencial" id="Diferencial">
				
					<br><br>
					';
					
						
					echo '
					</div>
					<div id="column3">
					



					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
					';
						$this->Scroll('Plazos','PlazoId','Plazo', 0, 'IUSA=1 AND ACTIVO=1', 'Plazo');
					echo'
					</select>
					<br><br><br><br>
					<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
					<select name="TipoPagoId" id="TipoPagoId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposPago','TipoPagoId','TipoPago', 0, 'Vu=1 AND ACTIVO=1', 'TipoPagoId');
					echo'
					</select>
					<br><br>
					
					
					<br><br>
				
					</div>
					<div id="column4">
					<br><br>
						<label>Add ON: <img src="img/Add.png" id="AddAddon"/></label>
						<input type="hidden" name="AddOnes" id="AddOnes" />
					
					<br>
					<label for="SeguroId"><span class="importante">*</span>Seguro:</label>
					<select name="SeguroId" id="SeguroId">
					<option value="0">Elige</option>
					';
						$this->Scroll('Seguros','SeguroId','Seguro', 0, 'ACTIVO=1', 'SeguroId');
					echo'
					</select>






					</div>
					<br><br><br>
					<div id="columnDerecha">
					<br>
					<input type="button" class="agregar" value="Agregar" id="AddLineaOr" name="AddLineaOr" align="right" >
					</div>
				<br>
				<br>

		';
		echo'
		<div id="AddOn" class="dialogo" title="Elegir ADD ON" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="Addons" class="datagrid">';
		 	echo $this->getListaAddOn();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="SAdicional" class="dialogo" title="Elegir Servicio Adicional" >
			Buscar:&nbsp<input id="Busqueda4" class="Busqueda" type="text">
			<div id="servisio" class="datagrid">';
		 	echo $this->getListaServicios();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="Planes" class="dialogo" title="Elegir Plan" >
			Buscar:&nbsp<input id="Busqueda7" class="Busqueda" type="text">
			<div id="MisPlanes" class="datagrid">';
		 	echo $this->getListaPlanesV2($FamiliaPlanId);
			echo'
				</div>
			</div>
			';
			echo '<br><br><br><br><br><br><br>';
	}

function displayVentana()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>

				<label for="PlataformaId"><span class="importante">*</span>Plataforma:</label>
					<select name="PlataformaId" id="PlataformaId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plataformas','PlataformaId','Plataforma', 0, 'ACTIVO=1', 'Plataforma');
				echo'
				</select><br>
				';
	echo '
				<div class="Izquierda">


				<label for="TipoContratacionId"><span class="importante">*</span>Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', 0, 'ACTIVO=1', 'Tipocontratacion');
					echo'
					</select>
					<br>

				<label for="Folio"><span class="importante">*</span>Solicitud:</label>
				<input type="text" name="Folio" id="Folio" maxlength="20" readonly="readonly">
				<br>

				<label for="TipoPagoId"><span class="importante">*</span>Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', 0, 'ACTIVO=1', 'TipoPago');
				echo'
				</select>

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

				</div>

				<div class="Derecha">

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria"><span class="importante">*</span>Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Datos del Cliente</legend>
				<br>
				<div class="Izquierda">

					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>
					<label>Referencias: <img src="img/Add.png" id="AddReferencia"/></label>
				</div>
				<div class="Derecha">

					<div class="datagrid">
						<div id="displayRef"></div>
				</div>
		</fieldset>

		<fieldset>
			<legend>Registro de Lineas</legend>
				<br>
				<div class="Izquierda">

					<label for="Equipo"><span class="importante">*</span>Equipo:</label>
					<input type="text" name="Equipo" id="Equipo" readonly="readonly">
					<input type="hidden" name="EquipoId" id="EquipoId" value="0" />
					<br>
					<label for="Plan"><span class="importante">*</span>Plan de Contratacion:</label>
					<input type="text" name="Plan" id="Plan" readonly="readonly">
					<input type="hidden" name="PlanId" id="PlanId" value="0" />
					<input type="hidden" name="TipoPlanId" id="TipoPlanId" value="0" />
					<br>

					<label>Add ON: <img src="img/Add.png" id="AddAddon"/></label>
					<input type="hidden" name="AddOnes" id="AddOnes" />
					<br>
					<label>Servicios Adicionales: <img src="img/Add.png" id="AddServ"/></label>
					<input type="hidden" name="OtrosServ" id="OtrosServ" />
					<br>
					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
				';
					$this->Scroll('Plazos','PlazoId','Plazo', 0, 'IUSA=1 AND ACTIVO=1', 'Plazo');
				echo'
				</select>
				<br>
				<br>
				<label for="Contrato"><span class="importante">*</span>Contrato:</label>
				<input type="text" name="Contrato" id="Contrato" maxlength="20" >
				<br>
				<br>
					<br>
					<label>Agregar Linea: <img src="img/Add.png" id="AddLinea"/></label>

				</div>
				<div class="Derecha">

					<div class="datagrid">
						<div id="displayLineas"></div>
				</div>
		</fieldset>


		<br>
	</div>
	';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="NReferencia" class="dialogo" title="Registrar Referencia" >
		<div class="Izquierda">
			<label for="ParentescoReferenciaId"><span class="importante">*</span>Parentesco:</label>
				<select name="ParentescoReferenciaId" id="ParentescoReferenciaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('Parentescos','ParentescoId','Parentesco', 0, 'ACTIVO=1', 'Parentesco');
				echo'
				</select>
			<br>
			<label for="NombreR"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreR" id="NombreR" maxlength="30">
			<br>
			<label for="PaternoR"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoR" id="PaternoR" maxlength="30" >
			<br>
			<label for="MaternoR"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoR" id="MaternoR" maxlength="30">
			<br>
		</div>
		<div class="Derecha">
			<label for="TelefonoR"><span class="importante">*</span>Telefono:</label>
				<input type="text" name="TelefonoR" id="TelefonoR" maxlength="11">
			<br>
			<label for="MailR">Correo Electronico:</label>
				<input type="text" name="MailR" id="MailR" maxlength="40">
			<br>
			<input type="button" class="guardar" id="Crear" name="Crear">

		</div>
		</div>
		';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj" type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';


		echo'
		<div id="AddOn" class="dialogo" title="Elegir ADD ON" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="Addons" class="datagrid">';
		 	echo $this->getListaAddOn();
			echo'
				</div>
			</div>
			';
		echo'
		<div id="SAdicional" class="dialogo" title="Elegir Servicio Adicional" >
			Buscar:&nbsp<input id="Busqueda4" class="Busqueda" type="text">
			<div id="servisio" class="datagrid">';
		 	echo $this->getListaServicios();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="Pat
				rnoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>

			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">
		</div>



		</div>

		';

		echo'
		<div id="Equipos" class="dialogo" title="Elegir Equipo" >
			Buscar:&nbsp<input id="Busqueda6" class="Busqueda" type="text">
			<div id="Moviles" class="datagrid">';
		 	echo $this->getListaEquipos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Planes" class="dialogo" title="Elegir Plan" >
			Buscar:&nbsp<input id="Busqueda7" class="Busqueda" type="text">
			<div id="MisPlanes" class="datagrid">';
		 	echo $this->getListaPlanes();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayRecepcion()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">

					<label for="Factura"><span class="importante">*</span>Factura:</label>
					<input type="text" name="Factura" id="Factura" maxlength="10">
					<br>

					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

				</div>



				<div class="Derecha">

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">

					<label for="Equipo"><span class="importante">*</span>Equipo:</label>
					<input type="text" name="Equipo" id="Equipo" readonly="readonly">
					<input type="hidden" name="EquipoId" id="EquipoId" value="0" />
					<br>
					<br>
					<label for="Lectura2"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="Lectura2" id="Lectura2">
					<br>

					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>

				</div>
				<div class="Derecha">

				<div class="datagrid">
						<div id="displayLineas">
						';
						$Clave=0;
						echo $this->getListaLectura($Clave);
						echo'
						</div>

				</div>
		</fieldset>
		<br>
	</div>
	';

		/*Ventanas*/
		echo'
		<div id="Equipos" class="dialogo" title="Elegir Equipo" >
			Buscar:&nbsp<input id="Busqueda6" class="Busqueda" type="text">
			<div id="Moviles" class="datagrid">';
		 	echo $this->getListaEquipos();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayTExpress()
{

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" name="Campo" id="Campo" />
					<label for="PuntoVentaO"><span class="importante">*</span>Punto de Venta Origen:</label>
					<input type="text" name="PuntoVentaO" id="PuntoVentaO" readonly="readonly" >
					<input type="hidden" name="PuntoVentaIdO" id="PuntoVentaIdO" value="0" />
					<input type="hidden" name="CantidadUnidad" id="CantidadUnidad" value="0" />
					<br>

					<label for="PuntoVentaD"><span class="importante">*</span>Punto de Venta Destino:</label>
					<input type="text" name="PuntoVentaD" id="PuntoVentaD" readonly="readonly" >
					<input type="hidden" name="PuntoVentaIdD" id="PuntoVentaIdD" value="0" />
					<br>
				</div>

				<div class="Derecha">

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">

					<br>
					<label for="Lectura3"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="Lectura3" id="Lectura3">
					<br>

					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>

				</div>
				<div class="Derecha">

				<div class="datagrid">
						<div id="displayLineas">
						';
						$Clave=0;
						echo $this->getListaLecturaTExpress($Clave);
						echo'
						</div>

				</div>
		</fieldset>
		<br>
	</div>
	';



		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntosTraspasos();
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}

function displayInvF()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Lectura de Datos</legend>
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

				<br>
				<div class="Izquierda">
					<br>
					<label for="Lectura5"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="Lectura5" id="Lectura5">
					<br>

					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>

				</div>
				<div class="Derecha">

				<div class="datagrid">
						<div id="displayLineas">
						';
						$Clave=0;
						echo $this->getListaLecturaFisico($PuntoVentaId);
						echo'
						</div>

				</div>
		</fieldset>
		<br>
	</div>
	';
}

function displayAsignaCoordinador()
{
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Elegir personal</legend>
				<label for="Coordinador"><span class="importante">*</span>Jefe Inmediato:</label>
				<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
				<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
				<br><br>
	';
		$this->drawTabla($this->getDatos(35));
	echo'
		</fieldset>
		<br>
	</div>

	<div id="Coordinaciones" class="dialogo" title="Elegir Jefe Inmediato" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Coordinadores" class="datagrid">';
		 	echo $this->getListaCoordinadores();
			echo'
				</div>
			</div>
	';
}

function displayDatosClientesSeguimiento($SeguimientoId, $Nombre, $Municipio, $Estado, $Telefono, $Direccion, $Colonia)
{
	echo '
	<fieldset>
	<legend>Informacion del Cliente</legend>
	<br>
	';
	if (isset($SeguimientoId))
	{
	echo '
	<div class="Izquierda">
	<input type="hidden" id="SeguimientoId" name="SeguimientoId" value="'.$SeguimientoId.'" />
	<label>Cliente: <img src="img/BCliente.png" id="BCliente" title="Buscar" /></label>'.$Nombre.'
	<br><br>
	<label>Municipio: </label>'.$Municipio.'
	<label>Estado: </label>'.$Estado.'
	<br><br>
	<label>Telefono: </label>'.$Telefono.'
	<br>
	<label>Direccion: </label>'.$Direccion.'
	<br>
	<label>Colonia: </label>'.$Colonia.'

	</div>


	<div class="Derecha">
	<label><span class="importante">*</span>Esatus: </label>';
			echo $this->getEstatusPosibleSeguimiento($SeguimientoId);
	echo '
		<br><br>
       <div id="Fechas" style="display: none">
           <label><span class="importante">*</span>Fecha/Hora: </label>
             <input type="text" name="dateTimeField" id="dateTimeField" readonly="readonly" style="border: 0px groove:#FFF; background-color:#E6EFF9; font-family: Verdana,Arial,Helvetica; font-size: 11px; width: 130px; color:#174287;" />
			        <script>AnyTime.picker(\'dateTimeField\', {labelTitle:"Seleccionar Fecha y Hora", labelYear:"A?", labelMonth:\'Mes\', labelDayOfMonth:"Dia", labelHour: "Hora", labelMinute: "Minuto", askSecond:false,
											monthAbbreviations:[\'Ene\',\'Feb\',\'Mar\',\'Abr\',\'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\',\'Oct\',\'Nov\',\'Dic\'],
											dayAbbreviations:[\'Dom\', \'Lun\', \'Mar\', \'Mie\', \'Jue\', \'Vie\', \'Sab\']});
				  </script>
                 </div>

	<br><br>
	<label><span class="importante">*</span>Comentarios: </label>
	<textarea id="Comentarios" name="Comentarios"></textarea>
	</div>
	';

	echo'
	<br><br>
				<div class="Centro">
				<br><br>
					<div class="datagrid">
						<div id="displayLineas">
					';
							echo $this->getSeguimientoLineas($Nombre);

				echo '
						</div>

					</div>
				</div>

	';

	}
	else
		echo 'No existen datos por mostrar';
echo '</fieldset>
<fieldset>
	<legend>Historial de Seguimiento</legend>

				<div class="Izquierda">
					<div class="datagrid">
						<div id="displayLineas">
						<strong>HISTORIAL DEL CLIENTE</<strong>
					';
						echo $this->getSeguimientoLineasHistorial($SeguimientoId);

				echo '
						</div>

					</div>
				</div>

				<div class="Derecha">
					<div class="datagrid">
						<div id="displayLineas">
						<strong>AGENDA</<strong>
					';
							echo $this->getSeguimientoAgenda();

				echo '
						</div>

					</div>
				</div>

</fieldset>
';
/*Ventanas*/
		echo'
		<div id="MisClientes" class="dialogo" title="Mis Clientes" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Clientes" class="datagrid" >';
		 	echo $this->getMisClientesSeguimiento();
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}


function displayVentaAccesorios()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Venta</legend>
				<br>
				<div class="Izquierda">
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>
					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria"><span class="importante">*</span>Sub Categoria:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>


					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>
				</div>

				<div class="Derecha">

					<label>Total de Accesorios:&nbsp&nbsp<span id="TAcc" class="importante"></span></label>
					<br>
					<label>Total a Pagar:&nbsp&nbsp<span id="TT" class="importante"></span></label>
					<br>
					<label>Restante:&nbsp&nbsp<span id="Restante" class="importante"></span></label>

					<br><br>
					<label for="Efectivo"><span class="importante">*</span>Efectivo:</label>
					<input type="text" name="Efectivo" id="Efectivo" >
					<br>
					<label for="TCredito"><span class="importante">*</span>T. Credito:</label>
					<input type="text" name="TCredito" id="TCredito" value="0" readonly="readonly">
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>


		<fieldset>
			<legend>Registro de Accesorios</legend>
				<br>
				<div align="center">
					<input type="text" name="CodAcc" id="CodAcc" placeholder="Ingresa Codigo de Accesorio" >
				</div>
				<br><br>
				<div class="datagrid">
					<div id="displayLineas"></div>
				</div>
		</fieldset>

	</div>
	';
		/*Ventanas*/
		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj"  type="text">
			<div id="Customer" class="datagrid">';
			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">
			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">

		</div>
		</div>
		';

		/*FIN VENTANAS*/
}

function displayVentaTP()
{
	$Clave=$this->UsuarioId.date("dmyHis");

	echo'
	<input type="hidden" name="Clave" id="Clave" value="'.$Clave.'" />
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Venta</legend>
				<br>
				<div class="Izquierda">

					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="0"/>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio:</label>
					<input type="text" name="Folio" id="Folio" maxlength="20">
					<br>

					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
					';
					$this->Scroll('Plazos','PlazoId','Plazo', 0, 'Tp=1 AND ACTIVO=1', 'Plazo');
					echo'
					</select>
					<br>

					<label for="EstatusId"><span class="importante">*</span>Estatus:</label>
					<select name="EstatusId" id="EstatusId">
					<option value="0">Elige</option>
					';
					$this->Scroll('TPEstatus','TPEstatusId','TPEstatus', 0, 'ACTIVO=1', 'TPEstatus');
					echo'
					</select>
					<br>

					<label for="FechaContrato"><span class="importante">*</span>Fecha de Contrato:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly">
					<br>

					<label for="FechaInstalacion"><span class="importante">*</span>Fecha de Instalacion:</label>
					<input type="text" id="FechaInstalacion" name="FechaInstalacion" readonly="readonly">
					<br>

					<label for="Pvs"><span class="importante">*</span>PVS:</label>
					<input type="text" name="Pvs" id="Pvs" maxlength="20">
					<br>

				</div>

				<div class="Derecha">
					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly">
					<input type="hidden" name="ClienteId" id="ClienteId" value="0" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly">
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>


		<fieldset>
			<legend>Registro de Productos</legend>
				<br>
				<div align="center">
					<input type="text" name="CodTP" id="CodTP" placeholder="Buscar Producto" >
				</div>
				<br><br>
				<div class="datagrid">
					<div id="displayLineas"></div>
				</div>
		</fieldset>
<br><br>
	</div>
	';
		/*Ventanas*/
		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj"  type="text">
			<div id="Customer" class="datagrid">';
			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">
			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

				<input type="hidden" name="Calle" id="Calle" value="--">
				<input type="hidden" name="NExterior" id="NExterior" value="--">
				<input type="hidden" name="NInterior" id="NInterior" value="--">
				<input type="hidden" name="ColoniaId" id="ColoniaId" value="1">
				<input type="hidden" name="TLocal" id="TLocal" value="--">

		</div>
		<div class="Derecha">

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">

		</div>
		</div>
		';

		echo'
		<div id="Productos" class="dialogo" title="Elegir Producto Total Play" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="ProductosTp" class="datagrid">';
		 	echo $this->getListaProductosTP($Clave);
			echo'
				</div>
			</div>
			';

		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';



		/*FIN VENTANAS*/
}



function displayVentaTPEdit($Folio)
{
	$Folio=str_replace(',', '', $Folio);
list($FechaContrato, $FechaInstalacion, $VendedorId, $Vendedor, $CoordinadorId, $Coordinador, $ClienteId, $Cliente, $Rfc, $TPEstatusId, $PlazoId, $Pvs, $PuntoVenta, $PuntoVentaId, $Observaciones)=$this->getVentaTP($Folio);
echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Venta</legend>
				<br>
				<div class="Izquierda">

					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" value="'.$PuntoVenta.'" readonly="readonly">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Folio"><span class="importante">*</span>Folio:</label>
					<input type="text" name="Folio" id="Folio" maxlength="20" value="'.$Folio.'" readonly="readonly">
					<br>

					<label for="PlazoId"><span class="importante">*</span>Plazo:</label>
					<select name="PlazoId" id="PlazoId">
					<option value="0">Elige</option>
					';
					$this->Scroll('Plazos','PlazoId','Plazo', $PlazoId, 'Tp=1 AND ACTIVO=1', 'Plazo');
					echo'
					</select>
					<br>

					<label for="EstatusId"><span class="importante">*</span>Estatus:</label>
					<select name="EstatusId" id="EstatusId">
					<option value="0">Elige</option>
					';
					$this->Scroll('TPEstatus','TPEstatusId','TPEstatus', $TPEstatusId, 'ACTIVO=1', 'TPEstatus');
					echo'
					</select>
					<br>

					<label for="FechaContrato"><span class="importante">*</span>Fecha de Contrato:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly" value="'.$FechaContrato.'">
					<br>

					<label for="FechaInstalacion"><span class="importante">*</span>Fecha de Instalacion:</label>
					<input type="text" id="FechaInstalacion" name="FechaInstalacion" readonly="readonly" value="'.$FechaInstalacion.'">
					<br>

					<label for="Pvs"><span class="importante">*</span>PVS:</label>
					<input type="text" name="Pvs" id="Pvs" maxlength="20" value="'.$Pvs.'">
					<br>

				</div>

				<div class="Derecha">
					<label for="Nombre"><span class="importante">*</span>Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly" value="'.$Cliente.'">
					<input type="hidden" name="ClienteId" id="ClienteId" value="'.$ClienteId.'" />
					<br>

					<label for="RFC"><span class="importante">*</span>RFC Cliente:</label>
					<input type="text" name="RFC" id="RFC" readonly="readonly" value="'.$Rfc.'">
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly" value="'.$Vendedor.'">
					<input type="hidden" name="VendedorId" id="VendedorId" value="'.$VendedorId.'" />
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly" value="'.$Coordinador.'">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="'.$CoordinadorId.'" />
					<br>

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios">'.$Observaciones.'</textarea>
				</div>
		</fieldset>


		<fieldset>
			<legend>Registro de Productos</legend>
				<br>

				<div class="datagrid">
					<div id="displayLineas">';
				echo $this->getListaProductosTPbyFolio($Folio);
				echo'
					</div>
				</div>
		</fieldset>
<br><br>
	</div>
	';
		/*Ventanas*/
		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj"  type="text">
			<div id="Customer" class="datagrid">';
			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">
			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="PaternoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

				<input type="hidden" name="Calle" id="Calle" value="--">
				<input type="hidden" name="NExterior" id="NExterior" value="--">
				<input type="hidden" name="NInterior" id="NInterior" value="--">
				<input type="hidden" name="ColoniaId" id="ColoniaId" value="1">
				<input type="hidden" name="TLocal" id="TLocal" value="--">
		</div>
		<div class="Derecha">

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contacto:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">

		</div>
		</div>
		';

		echo'
		<div id="Productos" class="dialogo" title="Elegir Producto Total Play" >
			Buscar:&nbsp<input id="Busqueda3" class="Busqueda" type="text">
			<div id="ProductosTp" class="datagrid">';
		 	echo $this->getListaProductosTP($Clave);
			echo'
				</div>
			</div>
			';

		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}


function displayNoDisponible()
{
	echo '<div align="center"><span class="notificacion">No Disponible en este Modulo</span></div>';
}

function displayAsistenteTemplate($DatoId)
{
list($Dato, $Template)=$this->getTemplatename($DatoId);
	echo'<div id="Asistente">
		<input type="hidden" id="paso" name="paso" value="3" />
		<input type="hidden" id="DatoId" name="DatoId" value="'.$DatoId.'" />
		<div>
			<input type="button" id="anterior" name="anterior" class="anterior" value="Anterior"/>
			<input type="button" id="siguiente" name="siguiente" class="siguiente" value="Siguiente"/>
		</div>
		<br>
		A continuacion podras descargar el template adecuado para la importacion de informacion de "'.$Dato.'"
		<p>
		Recuerda no cambiar la extencion ni el formato del archivo, este debe de ser un documento delimitado por comas.
		El archivo no debe de llevar en su contenido el simbolo (,).
		</p>
		<br><br>
		<div align="center"><img src="img/Template.png" id="Template" title="'.$Template.'" onclick="descargaTemplate(\''.$Template.'\')"/></div>
		</div>
	';
}

function displayAsistenteImporta($DatoId)
{
	echo'<div id="Asistente">
		<input type="hidden" id="paso" name="paso" value="4" />
		<input type="hidden" id="DatoId" name="DatoId" value="'.$DatoId.'" />
		<div>
			<input type="button" id="anterior" name="anterior" class="anterior" value="Anterior"/>
			<input type="button" id="siguiente" name="siguiente" class="siguiente" value="Siguiente"/>
		</div>
		<br>
			<p>
			<div id="contenido" name"contenido">
			Elige Archivo delimitado por comas (csv)
			</p><br>
			<input type="file" name="FileImport" id="FileImport">
			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>
		</div>
	';
}




function displayEntregaUniforme()
{
	$Clave=$this->UsuarioId.date("dmyHis");

	echo'
	<input type="hidden" name="Clave" id="Clave" value="'.$Clave.'" />
	<div class="ConScroll">
		<fieldset>
			<legend>Entrega de Uniforme</legend>
				<br>
				<div class="Izquierda">
					<label for="FechaContrato"><span class="importante">*</span>Fecha de Entrega:</label>
					<input type="text" id="FechaContrato" name="FechaContrato" readonly="readonly">
					<br>
					<label for="Empleado"><span class="importante">*</span>Persona que recibe:</label>
					<input type="text" name="Empleado" id="Empleado" readonly="readonly">
					<input type="hidden" name="EmpleadoId" id="EmpleadoId" value="0"/>
					<br>
				</div>
				<div class="Derecha">
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
				<br>
		</fieldset>
		<fieldset>
			<legend>Detalle de Uniforme</legend>
				<br>
				<div align="center">
					<select name="UniformeId" id="UniformeId">
					<option value="0">Elige Tipo de prenda</option>
					';
					 $this->Scroll('Uniformes','UniformeId','Uniforme',0, 'TRUE', 'Uniforme');
					echo '
					</select>

					<select name="Color" id="Color">
						<option value="0">Elige el color</option>
						<option value="BLANCO" title="BLANCO">BLANCO</option>
						<option value="GRIS" title="GRIS">GRIS</option>
						<option value="NEGRO" title="NEGRO">NEGRO</option>
					</select>

					<select name="Talla" id="Talla">
						<option value="0">Elige la talla</option>
						<option value="CH" title="CH">CH</option>
						<option value="MED" title="MED">MED</option>
						<option value="GDE" title="GDE">GDE</option>
						<option value="XGDE" title="XGDE">XGDE</option>
					</select>

					<input type="text" name="Cantidad" id="Cantidad" placeholder="Cantidad" style="width:8%;">
					&nbsp
					<img src="img/Add.png" id="AddUniforme"/>

				</div>
				<br><br>
				<div class="datagrid">
					<div id="displayLineas"></div>
				</div>
		</fieldset>

<br><br>
	</div>
	';
		/*Ventanas*/
		echo'
		<div id="Empleados" class="dialogo" title="Elegir Persona" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Personas" class="datagrid">';
		 	echo $this->getListaPersonas();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayRecepcionODCEdit($Odt)
{
	$Odt=str_replace(',','',$Odt);
	list($PuntoVentaId, $PuntoVenta, $Comentario, $Factura)=$this->getDatosFactura($Odt);
echo '
		<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">

					<label for="Factura"><span class="importante">*</span>Factura:</label>
					<input type="text" readonly="readonly" value='.$Odt.'>
					<br>
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br><br>
					<span class="leyenda" onclick="window.open(\'FacturasDoc/'.$Factura.'\')">Ver Factura</span>
				</div>
				<div class="Derecha">
					<span class="importante">Recuerda que la toda Factura debe venir con acuse de recibo <br>
					(Fecha Recibido, nombre y firma del Gerente)
					</span><br><br>
					<label for="FileImport"><span class="importante">*</span>Documentos Factura: (Formatos validos: png, jpg, bmp, pdf, zip)</label>
					<input type="file" name="FileImport" id="FileImport">
					<br><br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios" readonly="readonly">'.$Comentario.'</textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">
					<label for="Lectura2"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="LecturaOdc" id="LecturaOdc">
					<br>
					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>
				</div>
				<div class="Derecha">
				<div class="datagrid">
						<div id="displayLineas">
				';
						$Clave=0;
						echo $this->getListaLectura($Clave);
						echo'
						</div>
				</div>
		</fieldset>
		<br>
	</div>';
}

function displayRecepcionODC()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">

					<label for="Factura"><span class="importante">*</span>Factura:</label>
					<input type="text" name="ODC" id="ODC" readonly="readonly">
					<br>
					<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>
				</div>
				<div class="Derecha">
					<span class="importante">Recuerda que la toda Factura debe venir con acuse de recibo <br>
					(Fecha Recibido, nombre y firma del Gerente)
					</span><br><br>
					<label for="FileImport"><span class="importante">*</span>Documentos Factura: (Formatos validos: png, jpg, bmp, pdf, zip)</label>
					<input type="file" name="FileImport" id="FileImport">
					<br><br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">
					<label for="Lectura2"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="LecturaOdc" id="LecturaOdc">
					<br>
					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>
				</div>
				<div class="Derecha">
				<div class="datagrid">
						<div id="displayLineas">
				';
						$Clave=0;
						echo $this->getListaLectura($Clave);
						echo'
						</div>
				</div>
		</fieldset>
		<br>
	</div>
	';

		/*Ventanas*/
		echo'
		<div id="Ordenes" class="dialogo" title="Elegir Orden de Compra" >
			Buscar:&nbsp<input id="Busqueda6" class="Busqueda" type="text">
			<div id="ODCompra" class="datagrid">';
		 	echo $this->getListaODC($PuntoVentaId);
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayTSalidas()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" name="Campo" id="Campo" />
					<label for="PuntoVentaO"><span class="importante">*</span>Punto de Venta Origen:</label>
					<input type="text" name="PVenta" id="PVenta" readonly="readonly" value="'.$PuntoVenta.'" >
					<input type="hidden" name="PuntoVentaIdO" id="PuntoVentaIdO" value="'.$PuntoVentaId.'" />
					<br>

					<label for="PuntoVentaD"><span class="importante">*</span>Punto de Venta Destino:</label>
					<input type="text" name="PuntoVentaD" id="PuntoVentaD" readonly="readonly" >
					<input type="hidden" name="PuntoVentaIdD" id="PuntoVentaIdD" value="0" />
					<br>
				</div>

				<div class="Derecha">

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">

					<br>
					<label for="Lectura3"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="Lectura3" id="Lectura3">
					<br>

					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>

				</div>
				<div class="Derecha">

				<div class="datagrid">
						<div id="displayLineas">
						';
						$Clave=0;
						echo $this->getListaLecturaTExpress($Clave);
						echo'
						</div>

				</div>
		</fieldset>
		<br>
	</div>
	';



		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntosTraspasos();
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}

function displayTEntradas()
{
	list($PuntoVentaId, $PuntoVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos de Recepcion</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" name="Campo" id="Campo" />
					<label for="PuntoVentaOrigen"><span class="importante">*</span>Punto de Venta Origen:</label>
					<input type="text" name="PuntoVentaOrigen" id="PuntoVentaOrigen" readonly="readonly" value="" >
					<input type="hidden" name="PuntoVentaIdO" id="PuntoVentaIdO" value="0" />
					<br>

					<label for="PuntoVentaD"><span class="importante">*</span>Punto de Venta Destino:</label>
					<input type="text" name="PuntoVentaDestino" id="PuntoVentaDestino" readonly="readonly"value="'.$PuntoVenta.'" >
					<input type="hidden" name="PuntoVentaIdD" id="PuntoVentaIdD" value="'.$PuntoVentaId.'" />
					<br>
				</div>

				<div class="Derecha">
					<label for="Odt"><span class="importante">*</span>Orden de Traspaso:</label>
					<input type="text" name="Odt" id="Odt" readonly="readonly"value="" >
					<br>

					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
				</div>
		</fieldset>

		<fieldset>
			<legend>Lectura de Datos</legend>
				<br>
				<div class="Izquierda">
					<br>
					<label for="Lectura6"><span class="importante">*</span>No. Serie de Equipo:</label>
					<input type="text" name="Lectura6" id="Lectura6">
					<br>
					<label for="Cantidad"><span class="importante">*</span>Cantidad:</label>
					<input type="text" name="Cantidad" id="Cantidad" value="0" class="boxshort" readonly="readonly">
					<br>
				</div>
				<div class="Derecha">

				<div class="datagrid">
						<div id="displayLineas">
						';
						$Clave=0;
						echo $this->getListaLecturaTExpress($Clave);
						echo'
						</div>

				</div>
		</fieldset>
		<br>
	</div>
	';
		/*Ventanas*/
		echo'
		<div id="OrdenTraspaso" class="dialogo" title="Elegir Orden de Traspaso" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Ordenes" class="datagrid" >';
		 	echo $this->getListaOrdenesTraspasos($PuntoVentaId);
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}

function displayCatAvisos()
{
	echo '
		<div class="ConScroll">
		<fieldset>
			<legend>Datos de Aviso</legend>
				<br>
				<div class="Izquierda">
					<label for="TituloAviso"><span class="importante">*</span>Titulo:</label>
					<input type="text" id="TituloAviso" name="TituloAviso">
					<br>
					<label for="Aviso">Descripcion Aviso:</label>
					<textarea id="Aviso" name="Aviso"></textarea>
					<br><br>
					<label for="ClasificacioAvisoId"><span class="importante">*</span>Clasificacion de Aviso:</label>
					<select name="ClasificacioAvisoId" id="ClasificacioAvisoId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('ClasificacionAvisos','ClasificacionAvisoId','ClasificacionAviso',0, 'TRUE', 'ClasificacionAviso');
				echo '
					</select>
				</div>
				<div class="Derecha">
					<label for="FileImport"><span class="importante">*</span>Documento Aviso:</label>
					<input type="file" name="FileImport" id="FileImport">
					<br><br>
					<label for="FechaInicio"><span class="importante">*</span>Fecha de Inicio de publicacion:</label>
					<input type="text" name="FechaInicio" id="FechaInicio" readonly="readonly" class="newDate" />
			        <script>AnyTime.picker(\'FechaInicio\', {labelTitle:"Seleccionar Fecha", format: "%Y-%m-%d",});</script>
             		<br>
             		<label for="FechaFin"><span class="importante">*</span>Fecha de vigencia:</label>
             		<input type="text" name="FechaFin" id="FechaFin" readonly="readonly" class="newDate" />
			        <script>AnyTime.picker(\'FechaFin\', {labelTitle:"Seleccionar Fecha", format: "%Y-%m-%d",});</script>
				</div>
		</fieldset>
		<br>
	</div>';
}

function displayDatosClientesReactivacion($RevisionId, $Nombre, $Ciudad, $Rfc)
{
	echo '
	<fieldset>
	<legend>Informacion del Cliente</legend>
	<br>
	';
	if (isset($RevisionId))
	{
	echo '
	<div class="Izquierda">
	<input type="hidden" id="RevisionId" name="RevisionId" value="'.$RevisionId.'" />
	<label>Cliente: <img src="img/BCliente.png" id="BCliente" title="Buscar" /></label>'.$Nombre.'
	<br><br>
	<label>RFC:</label>'.$Rfc.'
	<br><br>

	<label>Ciudad: </label>'.$Ciudad.'
	<br><br>

	</div>


	<div class="Derecha">
	<label><span class="importante">*</span>Esatus: </label>';
			echo $this->getEstatusPosibleSeguimiento($RevisionId);
	echo '
		<br><br>
       <div id="Fechas" style="display: none">
           <label><span class="importante">*</span>Fecha/Hora: </label>
             <input type="text" name="dateTimeField" id="dateTimeField" readonly="readonly" style="border: 0px groove:#FFF; background-color:#E6EFF9; font-family: Verdana,Arial,Helvetica; font-size: 11px; width: 130px; color:#174287;" />
			        <script>AnyTime.picker(\'dateTimeField\', {labelTitle:"Seleccionar Fecha y Hora", labelYear:"Año", labelMonth:\'Mes\', labelDayOfMonth:"Dia", labelHour: "Hora", labelMinute: "Minuto", askSecond:false,
											monthAbbreviations:[\'Ene\',\'Feb\',\'Mar\',\'Abr\',\'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\',\'Oct\',\'Nov\',\'Dic\'],
											dayAbbreviations:[\'Dom\', \'Lun\', \'Mar\', \'Mie\', \'Jue\', \'Vie\', \'Sab\']});
				  </script>
                 </div>

	<br><br>
	<label><span class="importante">*</span>Comentarios: </label>
	<textarea id="Comentarios" name="Comentarios"></textarea>
	</div>
	';

	echo'
	<br><br>
				<div class="Centro">
				<br><br>
					<div class="datagrid">
						<div id="displayLineas">
					';
							echo $this->getReactivacionLineas($Nombre);

				echo '
						</div>

					</div>
				</div>

	';

	}
	else
		echo 'No existen datos por mostrar';
echo '</fieldset>
<fieldset>
	<legend>Historial de Seguimiento</legend>

				<div class="Izquierda">
					<div class="datagrid">
						<div id="displayLineas">
						<strong>HISTORIAL DEL CLIENTE</<strong>
					';
						echo $this->getRenovacionesLineasHistorial($RevisionId);
				echo '
						</div>

					</div>
				</div>
				<div class="Derecha">
					<div class="datagrid">
						<div id="displayLineas">
						<strong>AGENDA</<strong>
					';
							echo $this->getRenovacionAgenda();

				echo '
						</div>

					</div>
				</div>
</fieldset>
';
/*Ventanas*/
		echo'
		<div id="MisClientes" class="dialogo" title="Mis Clientes" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Clientes" class="datagrid" >';
		 	echo $this->getMisClientesReactivacion();
			echo'
				</div>
			</div>
			';
		/*FIN VENTANAS*/
}

function displayRevisionBuro()
{
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Cliente</legend>
			<br>
		<div class="Izquierda">
		<input type="hidden" id="TipoPersonaId" name="id="TipoPersonaId"  value="1" />
			<br>
			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="Pat
				rnoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">


		</div>

		<div class="Derecha">
			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br><br>


			<label for="FileImportIdentificacion"><span class="importante">*</span>Identificacion:</label>
			<input type="file" name="FileImportIdentificacion" id="FileImportIdentificacion">
			<br><br>
			<label for="FileImportBuro"><span class="importante">*</span>Buro de Credito:</label>
			<input type="file" name="FileImportBuro" id="FileImportBuro">




			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>

		</div>
			<br>
		</fieldset>
		';
}

function drawTablaConsulta($R0)
	{
		$Orden=$this->getOrden($R0);
		$i=0;
		$titulos = array();
	echo '
		<span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<div  class="tableContainer">
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">';
		while($A0=mysql_fetch_row($R0))
		{
		if($i==0)
				{
					echo'<thead class="fixedHeader"><tr>';
						for($j=0; $j<$Orden['columnas']; $j++)
							{
							if ($j==0)
								{
										echo '<th bgcolor="#BFD5EA" valign="midle" width="3%">'.utf8_decode($A0[$j]).'&nbsp&nbsp</th>';
										$titulos[$j]=$A0[$j];
								}
							else
								{
									echo '<th bgcolor="#BFD5EA" id="'.utf8_decode($A0[$j]).'">'.utf8_decode($A0[$j]).'</th>';
									$titulos[$j]=$A0[$j];

								}
							}
					echo '</tr></thead>
							<tbody class="scrollContent">';
				}
				else
				{
					echo'<tr>';
					for($j=0; $j<$Orden['columnas']; $j++)
						echo '<td headers="'.$titulos[$j].'">'.$A0[$j].'</td>';
				}
			echo '</tr>';
			$i++;
		}
		echo '</tbody></table>

		';
	}

function displayChecador()
{
	echo'

				<label for="Coordinador"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="Coordinador" id="Coordinador" readonly="readonly" style="width:340px;">
				<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
				<label for="pwd"><span class="importante">*</span>Contraseña SIIGA:</label>
				<input type="password" id="pwd" name="pwd"/>
				<br><br>
	';
		$this->drawTabla($this->getDatos(64));
	echo'

		<br>


	<div id="Coordinaciones" class="dialogo" title="Elegir Persona" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Coordinadores" class="datagrid">';
		 	echo $this->getListaPersonalActivo();
			echo'
				</div>
			</div>
	';
}


function displayRecarga()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}


	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" id="CompaniaId" name="CompaniaId" value="1" />

					<label for="Folio"><span class="importante">*</span>Folio :</label>
					<input type="text" name="Folio" id="Folio" maxlength="10" >
					<br>
					<label for="NTel"><span class="importante">*</span>Numero Telefonico :</label>
					<input type="text" name="NTel" id="NTel" maxlength="10" >

				<label for="MontoRecargaId"><span class="importante">*</span>Monto Recarga:</label>
				<select name="MontoRecargaId" id="MontoRecargaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('MontoRecargas','MontoRecargaId','MontoRecarga', 0, 'ACTIVO=1', 'Orden');
				echo'
				</select>
				<br><br>
					<label for="SIM">SIM:</label>
					<input type="text" name="SIM" id="SIM" maxlength="20">
				<br><br>
				<input type="hidden" id="PortabilidadId" name="PortabilidadId" value="0" />

				  <label for="NTelP">Numero Telefonico para portabilidad:</label>
                                        <input type="text" name="NTelP" id="NTelP" maxlength="10" >

				  <label for="Nip">NIP (4 dijitos):</label>
                                        <input type="text" name="Nip" id="Nip" maxlength="4" >

				  <label for="Nombre">Nombre:</label>
                                        <input type="text" name="Nombre" id="Nombre" >

				  <label for="Paterno">Paterno:</label>
                                        <input type="text" name="Paterno" id="Paterno" >

				  <label for="Materno">Materno:</label>
                                        <input type="text" name="Materno" id="Materno" >

				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">RFC:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
					<br><br><br>
				  <label for="TelContacto">Telefono de Contacto:</label>
                   <input type="text" name="TelContacto" id="TelContacto" maxlength="10" >

				  <label for="MailContacto">RFC Cliente:</label>
                   <input type="text" name="MailContacto" id="MailContacto" maxlength="10" >
                    <br>
					<label for="FileIfe"><span class="importante">*</span>Identificacion Oficial (Formatos validos: png, jpg, bmp, pdf, zip):</label>
					<input type="file" name="FileIfe" id="FileIfe">

				</div>
		</fieldset>


		<br>
	</div>
	';

		/*Ventanas*/

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}


function displayVentaTAE()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}


	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" id="CompaniaId" name="CompaniaId" value="1" />

					<label for="FolioR"><span class="importante">*</span>Folio :</label>
					<input type="text" name="FolioR" id="FolioR" maxlength="6" >
					<br>
					<label for="NTel"><span class="importante">*</span>Numero Telefonico :</label>
					<input type="text" name="NTel" id="NTel" maxlength="10" >

				<label for="MontoRecargaId"><span class="importante">*</span>Monto Recarga:</label>
				<select name="MontoRecargaId" id="MontoRecargaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('MontoRecargas','MontoRecargaId','MontoRecarga', 0, 'ACTIVO=1', 'Orden');
				echo'
				</select>
				<br><br>


				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">RFC:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
					<br><br><br>
				

				</div>
		</fieldset>


		<br>
	</div>
	';

		/*Ventanas*/

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}

function displayVentaTAESim()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}


	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" id="CompaniaId" name="CompaniaId" value="1" />

					<label for="FolioR"><span class="importante">*</span>Folio :</label>
					<input type="text" name="FolioR" id="FolioR" maxlength="6" >
					<br>
					<label for="NTel"><span class="importante">*</span>Numero Telefonico :</label>
					<input type="text" name="NTel" id="NTel" maxlength="10" >

				<label for="MontoRecargaId"><span class="importante">*</span>Monto Recarga:</label>
				<select name="MontoRecargaId" id="MontoRecargaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('MontoRecargas','MontoRecargaId','MontoRecarga', 0, 'ACTIVO=1', 'Orden');
				echo'
				</select>
				<br><br>
					<label for="SIM"><span class="importante">*</span>SIM:</label>
					<input type="text" name="SIM" id="SIM" maxlength="20">
				<br><br>
				
				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">RFC:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
					<br><br><br>
				 
				</div>
		</fieldset>


		<br>
	</div>
	';

		/*Ventanas*/

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}


function displayVentaPortabilidad()
{

	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}


	$hoy = date("d-m-Y");
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
					<input type="hidden" id="CompaniaId" name="CompaniaId" value="1" />

					<label for="FolioR"><span class="importante">*</span>Folio :</label>
					<input type="text" name="FolioR" id="FolioR" maxlength="6" >
					<br>
					<label for="NTel"><span class="importante">*</span>Numero Telefonico :</label>
					<input type="text" name="NTel" id="NTel" maxlength="10" >

				<label for="MontoRecargaId"><span class="importante">*</span>Monto Recarga:</label>
				<select name="MontoRecargaId" id="MontoRecargaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('MontoRecargas','MontoRecargaId','MontoRecarga', 0, 'ACTIVO=1', 'Orden');
				echo'
				</select>
				<br><br>
					<label for="SIM"><span class="importante">*</span>SIM:</label>
					<input type="text" name="SIM" id="SIM" maxlength="20">
				<br><br>
				<input type="hidden" id="PortabilidadId" name="PortabilidadId" value="0" />

				  <label for="NTelP"><span class="importante">*</span>Numero Telefonico para portabilidad:</label>
                                        <input type="text" name="NTelP" id="NTelP" maxlength="10" >

				  <label for="Nip"><span class="importante">*</span>NIP (4 dijitos):</label>
                                        <input type="text" name="Nip" id="Nip" maxlength="4" >

				  <label for="Nombre"><span class="importante">*</span>Nombre:</label>
                                        <input type="text" name="Nombre" id="Nombre" >

				  <label for="Paterno"><span class="importante">*</span>Paterno:</label>
                                        <input type="text" name="Paterno" id="Paterno" >

				  <label for="Materno"><span class="importante">*</span>Materno:</label>
                                        <input type="text" name="Materno" id="Materno" >

				</div>

				<div class="Derecha">

				<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor"><span class="importante">*</span>Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly">
					<input type="hidden" name="VendedorId" id="VendedorId" value="0" />
					<br>

					<label for="Categoria">RFC:</label>
					<input type="text" name="Categoria" id="Categoria" readonly="readonly">
					<br>

					<label for="Coordinador"><span class="importante">*</span>Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="0" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios"></textarea>
					<br><br><br>
					<label for="Portabilidad"><span class="importante">*</span>Elige tipo de portabilidad</label>
					<select id="Portabilidad" name="Portabilidad">
					<option value="0">--Seleccionar tipo de portabilidad--</option>
					<option>Portabilidad SIIGA</option>
					<option>Portabilidad PVS</option>
					</select>

				</div>
		</fieldset>


		<br>
	</div>
	';

		/*Ventanas*/

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';

		/*FIN VENTANAS*/
}


function displayDepositos()
{
	list($PuntoVentaId, $PuntoVenta, $ClasificacionPersonalVenta)=$this->getMiPuntoVentaFisico();
	if(!isset($PuntoVentaId))
	{
		$PuntoVentaId=0;
		$PuntoVenta='';
	}

	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Deposito</legend>
			<br>
		<div class="Izquierda">
			<label for="TipoDepositoId"><span class="importante">*</span>Tipo de Deposito:</label>
					<select name="TipoDepositoId" id="TipoDepositoId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('TiposDepositos','TipoDepositoId','TipoDeposito',0, 'TRUE AND Activo=1', 'TipoDeposito');
				echo '
					</select>
			<br><br>
           <label><span class="importante">*</span>Fecha y Hora Deposito: </label>
             <input type="text" name="dateTimeField" id="dateTimeField" readonly="readonly" style="border: 0px groove:#FFF; background-color:#E6EFF9; font-family: Verdana,Arial,Helvetica; font-size: 11px; width: 130px; color:#174287;" />
			    <script>AnyTime.picker(\'dateTimeField\', {labelTitle:"Seleccionar Fecha y Hora", labelYear:"Año", labelMonth:\'Mes\', labelDayOfMonth:"Dia", labelHour: "Hora", labelMinute: "Minuto", askSecond:false,
										monthAbbreviations:[\'Ene\',\'Feb\',\'Mar\',\'Abr\',\'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\',\'Oct\',\'Nov\',\'Dic\'],
										dayAbbreviations:[\'Dom\', \'Lun\', \'Mar\', \'Mie\', \'Jue\', \'Vie\', \'Sab\']});
				</script>
			<br><br>
			<label for="NFicha"><span class="importante">*</span>Numero de Deposito:</label>
				<input type="text" name="NFicha" id="NFicha" maxlength="30">
			<br><br>

			<label for="Monto"><span class="importante">*</span>Monto Deposito:</label>
				<input type="text" name="Monto" id="Monto" maxlength="30">
			<br>
		</div>

		<div class="Derecha">
		<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br><br>

			<label for="FileImportFicha"><span class="importante">*</span>Ficha Deposito (Formatos validos: png, jpg, bmp, pdf, zip):</label>
			<input type="file" name="FileImportFicha" id="FileImportFicha">
			<br><br>
			<label for="Comentarios">Comentarios:</label>
			<textarea id="Comentarios" name="Comentarios"></textarea>
			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>
		</div>
			<br>
		</fieldset>
		';
}


function displayDepositosEdit($DepositoId)
{
list($Deposito, $FechaHora, $TipoDepositoId, $Monto, $Ficha, $PuntoVentaId, $Validado, $Comentarios, $PuntoVenta)=$this->getDeposito($DepositoId);
echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Deposito</legend>
			<br>
		<div class="Izquierda">
			<label><h3>#Deposito: '.$DepositoId.'</h3></label>
			<input type="hidden" id="DepositoId" value="'.$DepositoId.'" />
			<br>
			<label for="TipoDepositoId"><span class="importante">*</span>Tipo de Deposito:</label>
					<select name="TipoDepositoId" id="TipoDepositoId">
							<option value="0">Elige</option>
				';
							 $this->Scroll('TiposDepositos','TipoDepositoId','TipoDeposito',$TipoDepositoId, 'TRUE', 'TipoDeposito');
	echo '
					</select>
			<br><br>
           <label><span class="importante">*</span>Fecha y Hora Deposito: </label>
             <input type="text" name="dateTimeField" id="dateTimeField" readonly="readonly" style="border: 0px groove:#FFF; background-color:#E6EFF9; font-family: Verdana,Arial,Helvetica; font-size: 11px; width: 130px; color:#174287;" value='.$FechaHora.' />
			    <script>AnyTime.picker(\'dateTimeField\', {labelTitle:"Seleccionar Fecha y Hora", labelYear:"A?", labelMonth:\'Mes\', labelDayOfMonth:"Dia", labelHour: "Hora", labelMinute: "Minuto", askSecond:false,
										monthAbbreviations:[\'Ene\',\'Feb\',\'Mar\',\'Abr\',\'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\',\'Oct\',\'Nov\',\'Dic\'],
										dayAbbreviations:[\'Dom\', \'Lun\', \'Mar\', \'Mie\', \'Jue\', \'Vie\', \'Sab\']});
				</script>
			<br><br>
			<label for="NFicha"><span class="importante">*</span>Numero de Deposito:</label>
				<input type="text" name="NFicha" id="NFicha" maxlength="30" value='.$Deposito.'>
			<br><br>

			<label for="Monto"><span class="importante">*</span>Monto Deposito:</label>
				<input type="text" name="Monto" id="Monto" maxlength="30" value='.$Monto.'>
			<br>
		</div>

		<div class="Derecha">
		<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
					<input type="text" name="MiPuntoVenta" id="MiPuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br><br>
		<label for="FileImportFicha"><span class="importante">*</span>Ficha Deposito (Formatos validos: png, jpg, bmp, pdf, zip):</label>
			<input type="file" name="FileImportFicha" id="FileImportFicha">
			<br><br>

			<span class="leyenda" onclick="window.open(\''.$Ficha.'\')">Ver Ficha</span>
			<br><br>
			<label for="Comentarios">Comentarios:</label>
			<textarea id="Comentarios" name="Comentarios">'.$Comentarios.'</textarea>
			<br><br>
			<span class="alerta" id="isValidado" >'.$Validado.'</span>
			<br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>
		</div>
			<br>
		</fieldset>
			';
}


function displayDatosClientesAsignacion()
{
	list($SeguimientoId, $Nombre, $Estado, $Municipio, $Telefono, $Direccion, $Colonia, $Observacion)=$this->getClientetoAsignacion(39);
	echo '
	<fieldset>
	<legend>Informacion del Cliente</legend>
	<br>
	';
	if (isset($SeguimientoId))
	{
	echo '
	<div class="Izquierda">
	<input type="hidden" id="SeguimientoId" name="SeguimientoId" value="'.$SeguimientoId.'" />
	<label>Cliente: </label>'.$Nombre.'
	<br><br>
	<label>Municipio: </label>'.$Municipio.'
	<label>Estado: </label>'.$Estado.'
	<br><br>
	<label>Telefono: </label>'.$Telefono.'
	<br>
	<label>Direccion: </label>'.$Direccion.'
	<br>
	<label>Colonia: </label>'.$Colonia.'
	</div>
	<div class="Derecha">
	<label>Observacion: </label>'.$Observacion.'
	<br><br>
	<label for="PuntoVentaId"><span class="importante">*</span>Asigna Punto de Venta:</label>
	<select name="PuntoVentaId" id="PuntoVentaId">
		<option value="0">Elige</option>
	';
		 $this->ScrollPuntosVenta(0);
	echo '
		</select>
	</div>
	';
	}
	else
		echo 'No existen datos por mostrar';
echo '</fieldset>';

}

function displayValidacionVenta()
{
	echo'
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Cliente</legend>
			<br>
		<div class="Izquierda">
			<br>
			<label for="Folio"><span class="importante">*</span>Folio:</label>
				<input type="text" name="Folio" id="Folio" maxlength="14">
				<input type="hidden" name="FoEdicion" id="FoEdicion" value="0">
			<br>
			<label for="Nombre"><span class="importante">*</span>Nombre Cliente:</label>
				<input type="text" name="Nombre" id="Nombre" maxlength="40">
			<br>
			<label for="Paterno"><span class="importante">*</span>Paterno Cliente:</label>
				<input type="text" name="Paterno" id="Paterno" maxlength="40">
			<br>
			<label for="Materno"><span class="importante">*</span>Materno Cliente:</label>
				<input type="text" name="Materno" id="Materno" maxlength="40">
			<br>
			<label for="Telefono"><span class="importante">*</span>Telefono Cliente:</label>
				<input type="text" name="Telefono" id="Telefono" maxlength="10">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select><input type="text" id="MiColonia" name="MiColonia" value="" style="display:none;" >&nbsp;&nbsp;&nbsp;<img src="img/Edit.png" id="Edit" title="Editar" />
			<br><br>

		</div>
		<div class="Derecha">
			<label for="PuntoVenta"><span class="importante">*</span>Punto de Venta:</label>
				<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="">
				<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="0"/>
			<br>
			<label for="DescEquipos"><span class="importante">*</span>Descripcion de Equipos:</label>
			<textarea id="DescEquipos" name="DescEquipos"></textarea>
			<br>
			<label for="DescPlanes"><span class="importante">*</span>Descripcion de Planes:</label>
			<textarea id="DescPlanes" name="DescPlanes"></textarea>
			<br><br>
			<label for="FileImportIdentificacion"><span class="importante">*</span>Identificacion:</label>
			<input type="file" name="FileImportIdentificacion" id="FileImportIdentificacion">
			<br><br>
			<label for="FileImportDomicilio"><span class="importante">*</span>Comprobante de Domicilio:</label>
			<input type="file" name="FileImportDomicilio" id="FileImportDomicilio">
			<br><br>
			<label for="FileImportWord"><span class="importante">*</span>Documento de validacion:</label>
			<input type="file" name="FileImportWord" id="FileImportWord">
			<br><br>
			<label for="FileImportIfe"><span class="importante">*</span>IFE en punto de venta:</label>
			<input type="file" name="FileImportIfe" id="FileImportIfe">
			<br><br>
			<label for="FileImportBuro"><span class="importante">*</span>Buro de Credito:</label>
			<input type="file" name="FileImportBuro" id="FileImportBuro">
			<br><br>

			<input type="hidden" id="EstatusValidacionId" value="0" />
			<label for="Comentarios">Comentarios:</label>
			<textarea id="Comentarios" name="Comentarios"></textarea>
			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>

		</div>
			<br>
		</fieldset>
		';
/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntosValidacion();
			echo'
				</div>
			</div>
			';
}

function displayValidacionVentaEdit($ValidacionId)
{
	list($Folio, $Identificacion, $Domicilio, $Documento, $Comentario, $EstatusId, $Estatus, $Observacion, $NombreCliente, $PaternoCliente, $MaternoCliente, $Telefono, $PuntoVentaId, $PuntoVenta, $DescEquipos, $DescPlanes, $EstatusNoeId, $FechaEstatus,$Ife, $Buro,
		$Calle, $NExterior, $NInterior, $Cp, $Colonia, $ColoniaId, $bloqueado)=$this->getValidacionVenta($ValidacionId);

	$acceso=$this->getPermisoEspecial(13);

	if($EstatusId!=1)
	{
	if($bloqueado!=$this->UsuarioId and $bloqueado!=0)
		echo '<span class="importante">ESTE FOLIO ESTA SIENDO REVISADO POR OTRO USUARIO</span>';
	if($bloqueado==0)
		$this->ponBloqueoValidacion($ValidacionId);
	echo '
	<input type="hidden" id="ValidacionId" value="'.$ValidacionId.'" 7>
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Cliente</legend>
			<br>
		<div class="Izquierda">
			<br>
			<label for="Folio">Folio:</label>
				<input type="text" name="Folio" id="Folio" maxlength="14" readonly="readonly" value='.$Folio.'>
				<input type="hidden" name="FoEdicion" id="FoEdicion" value="1">
			<br>
			<label for="Comentarios">Comentarios Solicitante:</label>
			'.$Comentario.'
			<br><br>
			';
		if($acceso)
		{
			echo'
			<label for="EstatusValidacionId"><span class="importante">*</span>Estatus:</label>
					<select name="EstatusValidacionId" id="EstatusValidacionId">
					<option value="0">Elige</option>
					';
						 $this->Scroll('EstatusValidacion','EstatusValidacionId','EstatusValidacion',$EstatusId, 'TRUE', 'EstatusValidacion');
					echo '
					</select>';
		}
		else
			echo'<input type="hidden" id="EstatusValidacionId" value="'.$EstatusId.'" />';

			echo'
			<br>
			<input type="hidden" id="EstatusValidacionIdOld" value="'.$EstatusId.'" />
			<br>
			<label for="Nombre"><span class="importante">*</span>Nombre Cliente:</label>
				<input type="text" name="Nombre" id="Nombre" maxlength="40" value="'.$NombreCliente.'">
			<br>
			<label for="Paterno"><span class="importante">*</span>Paterno Cliente:</label>
				<input type="text" name="Paterno" id="Paterno" maxlength="40" value="'.$PaternoCliente.'">
			<br>
			<label for="Materno"><span class="importante">*</span>Materno Cliente:</label>
				<input type="text" name="Materno" id="Materno" maxlength="40" value="'.$MaternoCliente.'">
			<br>
			<label for="Telefono"><span class="importante">*</span>Telefono Cliente:</label>
				<input type="text" name="Telefono" id="Telefono" maxlength="10" value="'.$Telefono.'">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50" value="'.$Calle.'">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5" value="'.$NExterior.'">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5" value="'.$NInterior.'">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5" value="'.$Cp.'">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
			<select name="ColoniaId" id="ColoniaId">
					<option value="'.$ColoniaId.'">'.$Colonia.'</option>
				</select>
			<br><br>

			<br><br>


		</div>
		<div class="Derecha">
			<label for="PuntoVenta">Punto de Venta:</label>
				<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
				<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
			<br>
			<label for="DescEquipos">Descripcion de Equipos:</label>
			<textarea id="DescEquipos" name="DescEquipos">'.$DescEquipos.'</textarea>
			<br><br>
			<label for="DescPlanes">Descripcion de Planes:</label>
			<textarea id="DescPlanes" name="DescPlanes">'.$DescPlanes.'</textarea>
			<br><br>
			<br><br>

			<label for="FileImportIdentificacion"><span class="importante">*</span>Identificacion:</label>
			<input type="file" name="FileImportIdentificacion" id="FileImportIdentificacion"><br>
			';
			if($acceso)
			echo '<span class="leyenda" onclick="window.open(\''.$Identificacion.'\')">Ver Identificacion</span>';
		echo'
			<br><br>
			<label for="FileImportDomicilio"><span class="importante">*</span>Comprobante de Domicilio:</label>
			<input type="file" name="FileImportDomicilio" id="FileImportDomicilio"><br>';
			if($acceso)
			echo '<span class="leyenda" onclick="window.open(\''.$Domicilio.'\')">Ver Comprobante de Domicilio</span>';
		echo'
			<br><br>
			<label for="FileImportWord"><span class="importante">*</span>Documento de validacion:</label>
			<input type="file" name="FileImportWord" id="FileImportWord"><br>
			';
			if($acceso)
			echo '<span class="leyenda" onclick="window.open(\''.$Documento.'\')">Ver Documento de validacion</span>';
		echo'
			<br><br>
			<label for="FileImportIfe"><span class="importante">*</span>IFE en punto de venta:</label>
			<input type="file" name="FileImportIfe" id="FileImportIfe"><br>
						';
			if($acceso)
			echo '<span class="leyenda" onclick="window.open(\''.$Ife.'\')">Ver Ife en Punto de Venta</span>';
		echo'
			<br><br>
			<label for="FileImportBuro"><span class="importante">*</span>Buro de Credito:</label>
			<input type="file" name="FileImportBuro" id="FileImportBuro"><br>
					';
			if($acceso)
			echo '
			<span class="leyenda" onclick="window.open(\''.$Buro.'\')">Ver Buro de credito</span>';
		echo'
			<br><br>
			';

			if($acceso)
			{
			echo'
			<label for="EstatusNoeId"><span class="importante">*</span>Estatus Noe:</label>
					<select name="EstatusNoeId" id="EstatusNoeId">
					<option value="0">Elige</option>
					';
						 $this->Scroll('EstatusNoe','EstatusNoeId','EstatusNoe',$EstatusNoeId, 'TRUE', 'EstatusNoe');
					echo '
					</select>
					<br>
					<label for="FechaEstatus"><span class="importante">*</span>Fecha de Estatus Noe:</label>
					<input type="text" id="FechaEstatus" name="FechaEstatus" class="FechaEstatus" value="'.$FechaEstatus.'" readonly="readonly">
					<br>

			<label for="ComentariosV">Comentarios Validacion:</label>
			<textarea id="ComentariosV" name="ComentariosV"></textarea>
			';
			}
			else
				echo'
					<input type="hidden" id="EstatusNoeId" value="'.$EstatusNoeId.'" />
					<input type="hidden" id="FechaEstatus" value="'.$FechaEstatus.'" />
			';

			echo'
			<input type="hidden" id="FileImportIdentificacion" value="0" />
			<input type="hidden" id="FileImportDomicilio" value="0" />
			<input type="hidden" id="FileImportWord" value="0" />
			<input type="hidden" id="FileImportIfe" value="0" />
			<br><br>
			<div>
			<strong>
				'.$this->getIncidenciasTelefonos($Telefono).'
			</strong>
			<br><br><br>
			<strong>
				'.$this->getIncidenciasClientes($NombreCliente.' '.$PaternoCliente.' '.$MaternoCliente).'
			</strong>
			</div>

			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta"></span>
				</div>
			</div>

		</div>
			<br>
		</fieldset>
		';

	}
	else
	echo '
	<input type="hidden" id="ValidacionId" value="'.$ValidacionId.'" 7>
	<div class="ConScroll">
		<fieldset>
			<legend>Informacion de Cliente</legend>
			<br>
		<div class="Izquierda">
			<br>
			<label for="Folio">Folio:</label>
				<input type="text" name="Folio" id="Folio" maxlength="20" readonly="readonly" value='.$Folio.'>
			<br>
			<label for="Comentarios">Comentarios Solicitante:</label>
			'.$Comentario.'
			<br><br>
			<label for="EstatusValidacionId"><span class="importante">*</span>Estatus:</label>
			'.$Estatus.'
			<label for="ComentariosV">Comentarios Validacion:</label>
			'.$Observacion.'
		</div>
		<div class="Derecha">
			<span class="leyenda" onclick="window.open(\''.$Identificacion.'\')">Ver Identificacion</span>
			<br><br>
			<span class="leyenda" onclick="window.open(\''.$Domicilio.'\')">Ver Comprobante de Domicilio</span>
			<br><br>
			<span class="leyenda" onclick="window.open(\''.$Documento.'\')">Ver Documento de validacion</span>

			<input type="hidden" id="FileImportIdentificacion" value="0" />
			<input type="hidden" id="FileImportDomicilio" value="0" />
			<input type="hidden" id="FileImportWord" value="0" />

			<br><br><br><br>
				<div align="center">
				<span  id="msj" class="alerta">NO SE PUEDE EDITAR ESTA VALIDACION</span>
				</div>
			</div>

		</div>
			<br>
		</fieldset>
		';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntosValidacion();
			echo'
				</div>
			</div>
			';

}

function displayLFolioEdit($Folio)
{
		$R0=$this->getLFolioEdit($Folio);
		while($A0=mysql_fetch_row($R0))
		{
		echo '<div class="Izquierda">
				 <label>#Registro:<br>
				 &nbsp;&nbsp;&nbsp;&nbsp;<span class="importante">'.$A0[0].'</span>
				 <input type="hidden" id="RegistroId" name="RegistroId" value="'.$A0[0].'" />
				 <label>Serie:<br>
				 &nbsp;&nbsp;&nbsp;&nbsp;<span class="importante">'.$A0[1].'</span>
				 <input type="hidden" id="Serie'.$A0[0].'" name="Serie'.$A0[0].'" value="'.$A0[1].'"/>
					<br<br><br>
					<label for="PlanId'.$A0[0].'">Plan:</label>
					<select name="PlanId'.$A0[0].'" id="PlanId'.$A0[0].'">';
						$this->Scroll('Planes','PlanId','Plan', $A0[2], 'ACTIVO=1', 'Plan');
			 echo'</select>
			 		<br<br>
					<label for="EquipoId'.$A0[0].'">Equipo:</label>
			<input type="hidden" id="MovimientoId'.$A0[0].'" name="MovimientoId'.$A0[0].'" value="'.$A0[13].'" />';


		if($A0[13]>0){
			$Originacion=1;
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="importante">'.$A0[14].'</span>
			<input type="hidden" id="EquipoId'.$A0[0].'" name="EquipoId'.$A0[0].'" value="'.$A0[3].'" />';
		}
		else
		{
			$Originacion=0;
			echo'
					<select name="EquipoId'.$A0[0].'" id="EquipoId'.$A0[0].'">';
						$this->Scroll('Equipos','EquipoId','Equipo', $A0[3], 'ACTIVO=1', 'Equipo');
			 echo'</select>';
		}
			 	echo'
			 		<br<br>
					<label for="PlazoId'.$A0[0].'">Plazo:</label>
					<select name="PlazoId'.$A0[0].'" id="PlazoId'.$A0[0].'">';
						$this->Scroll('Plazos','PlazoId','Plazo', $A0[4], 'ACTIVO=1', 'Plazo');
			 echo'</select>
			 		<br<br>
			 		<input type="hidden" id="EstatusIdOld'.$A0[0].'" name="EstatusIdOld'.$A0[0].'" value="'.$A0[5].'" />
			 		<label>Costo:<br>
			 		&nbsp;&nbsp;&nbsp;&nbsp;<span class="importante">$'.$A0[6].'</span>
			 		<label for="EstatusId'.$A0[0].'">Estatus:</label>
			 		<select name="EstatusId'.$A0[0].'" id="EstatusId'.$A0[0].'">';
						$this->Scroll('Estatus','EstatusId','Estatus', $A0[5], 'ACTIVO=1 AND Originacion='.$Originacion, 'Estatus');
			 echo'</select>
			 <br>
			 	<label for="FechaEstatus'.$A0[0].'">Fecha Estatus:</label>
			 	<input type="text" id="FechaEstatus'.$A0[0].'" name="FechaEstatus'.$A0[0].'" class="FechaEstatus" value="'.$A0[8].'" readonly="readonly">
			 </div>
			 	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			 <div class="Derecha">
				<label for="Contrato'.$A0[0].'">Contrato:</label>
			 	<input type="text" id="Contrato'.$A0[0].'" name="Contrato'.$A0[0].'" value="'.$A0[9].'">
			 	<br>
				<label for="Dn'.$A0[0].'">DN:</label>
			 	<input type="text" id="Dn'.$A0[0].'" name="Dn'.$A0[0].'" value="'.$A0[10].'">
			 	<label for="Diferencial'.$A0[0].'">Diferencial:</label>
			 	<input type="text" id="Diferencial'.$A0[0].'" name="Diferencial'.$A0[0].'" value="'.$A0[11].'">
		 		<label for="TipoPagoId'.$A0[0].'">Tipo de Pago Diferencial:</label>
		 		<select name="TipoPagoId'.$A0[0].'" id="TipoPagoId'.$A0[0].'">';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', $A0[12], 'ACTIVO=1', 'TipoPago');
			echo'
				</select>
				<br>
				<label for="Comentarios">Comentarios:</label>
				<textarea id="Comentarios'.$A0[0].'" name="Comentarios'.$A0[0].'">'.utf8_decode($A0[7]).'</textarea>
				<br><br><br>
				<label for="AddonId'.$A0[0].'">AddOn:</label>
		 		<select name="AddonId'.$A0[0].'" id="AddonId'.$A0[0].'">
		 		<option value="0">Elige Addon</option>';
					$this->Scroll('Addon','AddonId','Addon', 0, 'ACTIVO=1', 'Addon');
			echo'
				</select>&nbsp;<img src="img/Add.png" id="AddAddon" onclick="agregarAddOn('.$A0[0].')"/>
				<div id="Addones">';
					$this->getAddonEdit($A0[0]);
				echo'



				</div>
				<br><br><br>
				<div align="right">
					<input type="button" class="guardar" id="ActualizaFolio'.$A0[0].'" name="ActualizaFolio'.$A0[0].'" value="Guardar" onclick="actualizaLinea('.$A0[0].')">
					</div>
			 </div>
			 <br><br><br>
			  ';
		}
echo'
</div>
<br>
'
;

}

function getAddonEdit($RegistroId)
{
	echo'
		<table id="MiTabla3" >
					<thead>
						<tr>
							<th>#AddOn</th>
							<th>Opciones</th>
						</tr>
					</thead>
					<tbody>';
				$t=true;
				$Q1= "SELECT T1.AddonId, AddOn
					FROM LineasAddon AS T1
					INNER JOIN Addon AS T2 ON T2.AddonId=T1.AddonId
					WHERE T1.AddonId!=7 AND RegistroId=$RegistroId";

		$R1=$this->Consulta($Q1);
		while($A1=mysql_fetch_row($R1))
		{
			if($t) $Clase='';
			else $Clase='class="alt"';
				echo '
						<tr '.$Clase.'>
							<td>'.utf8_decode($A1[1]).'</td>
							<td align="center"><img src="img/Remove.png" title="Eliminar" onclick="Remover('.$RegistroId.','.$A1[0].',8)" /></td>
						</tr>
				';
			$t=(!$t);
		}
				echo'</tbody>
						</table>';

}

function displayHFolioEdit($Folio)
{
	list($Folio,$FechaCaptura,$FechaSS,$PuntoVentaId, $PuntoVenta,$HistorialPuestoEmpleadoId,
		 $Vendedor, $CoordinadorId, $Coordinador, $ClienteId, $Cliente, $TipoContratacionId,
		 $TipoContratacion, $TipoPagoId, $TipoPago, $Comentarios, $ContratacionId, $Contratacion, $ClasificacionPersonalVenta)=$this->getHFolioEdit($Folio);

	echo '
		<fieldset>
			<legend>Datos del Folio</legend>
				<br>
				<div class="Izquierda">
					<label for="TipoContratacionId">Tipo de Contratacion:</label>
					<select name="TipoContratacionId" id="TipoContratacionId">
					<option value="0">Elige</option>
					';
						$this->Scroll('TiposContratacion','TipoContratacionid','Tipocontratacion', $TipoContratacionId, 'ACTIVO=1', 'Tipocontratacion');
					echo'
					</select>
					<br>
					<input type="hidden" id="PuntoVentaIdOld" name="PuntoVentaIdOld" value="'.$PuntoVentaId.'">
					<label for="FolioN">Folio / Solicitud:</label>
					<input type="text" name="FolioN" id="FolioN" maxlength="16" value='.$Folio.'>
					<label for="FechaSS">Fecha de Activacion:</label>
					<input type="text" id="FechaSS" name="FechaSS" value="'.$FechaSS.'">
					<label for="ContratacionId">Contratacion:</label>
					<select name="ContratacionId" id="ContratacionId">
					<option value="0">Elige</option>
					';
					$this->Scroll('Contrataciones','ContratacionId','Contratacion', $ContratacionId, 'ACTIVO=1', 'Contratacion');
					echo'
					</select>
					<br>

				<label for="TipoPagoId">Tipo de Pago:</label>
				<select name="TipoPagoId" id="TipoPagoId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPago','TipoPagoId','TipoPago', $TipoPagoId, 'ACTIVO=1', 'TipoPago');
				echo'
				</select>
				</div>

				<div class="Derecha">
				';
				echo'
					<label for="PuntoVenta">Punto de Venta:</label>
					<input type="text" name="PuntoVenta" id="PuntoVenta" readonly="readonly" value="'.$PuntoVenta.'">
					<input type="hidden" name="PuntoVentaId" id="PuntoVentaId" value="'.$PuntoVentaId.'"/>
					<br>

					<label for="Vendedor">Ejecutivo de Ventas:</label>
					<input type="text" name="Vendedor" id="Vendedor" readonly="readonly" value="'.$Vendedor.'">
					<input type="hidden" name="VendedorId" id="VendedorId" value="'.$HistorialPuestoEmpleadoId.'" />
					<br>

					<label for="Coordinador">Coordinador:</label>
					<input type="text" name="Coordinador" id="Coordinador" readonly="readonly" value="'.$Coordinador.'">
					<input type="hidden" name="CoordinadorId" id="CoordinadorId" value="'.$CoordinadorId.'" />
					<br>
					<label for="Nombre">Nombre Cliente: <img src="img/Add.png" id="AddCliente"/></label>
					<input type="text" name="Nombre" id="Nombre" readonly="readonly" value="'.$Cliente.'">
					<input type="hidden" name="ClienteId" id="ClienteId" value="'.$ClienteId.'" />
					<br>
					<label for="Comentarios">Comentarios:</label>
					<textarea id="Comentarios" name="Comentarios">'.$Comentarios.'</textarea>
					<br>
					<div align="right">
					<input type="button" class="guardar" id="ActualizaFolio" name="ActualizaFolio" value="Guardar">
					</div>
				</div>
		</fieldset>
		';

		/*Ventanas*/
		echo'
		<div id="PuntosVenta" class="dialogo" title="Elegir Punto de Venta" >
			Buscar:&nbsp<input id="Busqueda1" class="Busqueda" type="text" >
			<div id="Puntos" class="datagrid" >';
		 	echo $this->getListaPuntos();
			echo'
				</div>
			</div>
			';

		echo'
		<div id="Vendedores" class="dialogo" title="Elegir Ejecutivo de Ventas" >
			Buscar:&nbsp<input id="Busqueda2" class="Busqueda" type="text">
			<div id="Asesores" class="datagrid">';
		 	echo $this->getListaAsesores();
			echo'
				</div>
			</div>
			';


		echo'
		<div id="Clientes" class="dialogo" title="Elegir Cliente" >
			Buscar:&nbsp<input id="BuscarObj" type="text">
			<div id="Customer" class="datagrid">';

			echo'
				</div>
			</div>
			';

		echo'
		<div id="ClientesNuevos" class="dialogo" title="Registrar Cliente" >
		<div class="Izquierda">

			<label for="TipoPersonaId"><span class="importante">*</span>Tipo de Persona:</label>
				<select name="TipoPersonaId" id="TipoPersonaId">
				<option value="0">Elige</option>
				';
					$this->Scroll('TiposPersona','TipoPersonaId','TipoPersona', 0, 'ACTIVO=1', 'TipoPersona');
				echo'
				</select>
			<br>

			<label for="NombreC"><span class="importante">*</span>Nombre:</label>
				<input type="text" name="NombreC" id="NombreC" maxlength="30">
			<br>

			<label for="PaternoC"><span class="importante">*</span>Apellido Paterno:</label>
				<input type="text" name="Pat
				rnoC" id="PaternoC" maxlength="30" >
			<br>

			<label for="MaternoC"><span class="importante">*</span>Apellido Materno:</label>
				<input type="text" name="MaternoC" id="MaternoC" maxlength="30">
			<br>

			<label for="RFCC"><span class="importante">*</span>RFC:</label>
				<input type="text" name="RFCC" id="RFCC" maxlength="30">
			<br>

			<label for="Calle"><span class="importante">*</span>Calle:</label>
				<input type="text" name="Calle" id="Calle" maxlength="50">
			<br>

			<label for="NExterior"><span class="importante">*</span>Numero Exterior:</label>
				<input type="text" name="NExterior" id="NExterior" maxlength="5">
			<br>

			<label for="NInterior"><span class="importante">*</span>Numero Interior:</label>
				<input type="text" name="NInterior" id="NInterior" maxlength="5">
			<br>

			<label for="Cp"><span class="importante">*</span>Codigo Postal:</label>
				<input type="text" id="Cp" name="Cp" maxlength="5">
			<br>

			<label for="ColoniaId"><span class="importante">*</span>Colonia:</label>
				<select name="ColoniaId" id="ColoniaId">
					<option value="0">Elige</option>
				</select>
			<br>

		</div>
		<div class="Derecha">

			<label for="TLocal"><span class="importante">*</span>Telefono Local:</label>
				<input type="text" name="TLocal" id="TLocal" maxlength="11">
			<br>

			<label for="TMovil"><span class="importante">*</span>Telefono Movil:</label>
				<input type="text" name="TMovil" id="TMovil" maxlength="11">
			<br>
			<br>
			<span class="importanteMini">
			Los datos de Contacto son necesarios para Personas Morales
			</span>
			<br>
			<br>
			<label for="NombreCT">Nombre Contactos:</label>
				<input type="text" name="NombreCT" id="NombreCT" maxlength="30">
			<br>

			<label for="PaternoCT">Apellido Paterno Contacto:</label>
				<input type="text" name="PaternoCT" id="PaternoCT" maxlength="30" >
			<br>

			<label for="MaternoCT">Apellido Materno Contacto:</label>
				<input type="text" name="MaternoCT" id="MaternoCT" maxlength="30">
			<br><br>

			<input type="button" class="guardar" id="CrearCl" name="CrearCl" value="Guardar">
		</div>

		</div>

		';

		/*FIN VENTANAS*/
}

function AddAddOn($RegistroId, $AddonId)
{
	$Q0="INSERT IGNORE INTO LineasAddon (RegistroId, AddonId, Costo) VALUES($RegistroId ,$AddonId, 0)";
	$this->Consulta($Q0);

	return $this->getAddonEdit($RegistroId);
}

function removeAddOn($RegistroId, $AddonId)
{
	$Q0="DELETE FROM LineasAddon WHERE RegistroId=$RegistroId AND AddonId=$AddonId";
	$this->Consulta($Q0);
	return $this->getAddonEdit($RegistroId);
}

function displayFamiliasPlanes($Folio,$Movimiento,$PlataformaId)
	{
		$R0=$this->getFamiliasPlanes();
		$estilos = array("datagridBlueFamiliaPlan");
		shuffle($estilos);
		$i=0;
		while($A0=mysql_fetch_row($R0))
		{
			echo'

			<div class="datagridColor" id="'.$estilos[$i].'">
			<table>
				<thead>
					<tr>
						<th height="40">:: Elige</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td>
							<div id="no-paging"></div>
						<td>
					</tr>
				</tfoot>
				<tbody>
					<tr align="center">
						<td height="80"><h2><a class="ligas" href="AddEquipo2.php?id1='.$Folio.'&id2='.$Movimiento.'&id3='.$A0[0].'">'.$A0[1].'</a></h2></td>
					</tr>
				</tbody>
			</table>
			</div>
			';
				$i++;
				if($i>=count($estilos))
				{
					$i=0;
					$estilos = array("datagridBlueFamiliaPlan");
					shuffle($estilos);
				}
			}
	}
	function drawTablaEstatusEquipos2($Folio)
	{
		$R0=$this->getLineasTemporales($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Operaciones</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[0]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}

		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td>'.$A0[4].'</td>
		<td>'.$addones.'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$A0[6].'</td>
		<td><div align="center"><a href="reportes/php/borrarTemporales.php?id='.$A0[7].'&id2='.$A0[8].'&ss='.$A0[2].'&id3='.$A0[9].'&temp='.$A0[0].'" title="Quitar Equipo"><img src="img/Remove.png"></a></div></td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}

function drawTablaEstatusEquipos3($Folio)
	{
		$R0=$this->getLineasTemporales($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		/*Addones*/

		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[0]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}

		/*Fin de Addones*/
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td>'.$A0[4].'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}
function drawTablaEstatusEquipos4($Folio)
	{
		$R0=$this->getLineasTemporalesV3($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Raiz</th>
				<th bgcolor="#BFD5EA" >Tipo Venta</th>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
				if($A0[10]==1){
					$tipoVenta="Con Equipo";
					$serie=$A0[0];
					$modelo=$this->getModelo($serie);
				}elseif($A0[10]==2){
					$tipoVenta="Sin Equipo";
					$serie=$A0[3];
					$modelo=$this->getModelo($serie);

				}

		/*inicio Addones*/
				$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[2]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}


		/*Fin de Addones*/


		echo'<tr>
		<td>'.$A0[11].'</td>
		<td>'.$tipoVenta.'</td>
		<td>'.$A0[1].'</td>
		<td>'.$serie.'</td>
		<td>'.$modelo.'</td>
		<td>'.$A0[4].'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}










function drawTablaEstatusEquipos2V2($Folio)
	{
		$R0=$this->getLineasTemporalesV2($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Imei Sim</th>
				<th bgcolor="#BFD5EA" >Sim</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Operaciones</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[0]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}

		$modelo=$this->getModelo($A0[4]);
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td>'.$A0[4].'</td>
		<td>'.$modelo.'</td>
		<td>'.$A0[5].'</td>
		<td>'.$addones.'</td>
		<!--<td>'.$A0[6].'</td>-->
		<td>'.$A0[7].'</td>
		<td><div align="center"><a href="reportes/php/borrarTemporales.php?id='.$A0[8].'&id2='.$A0[9].'&ss='.$A0[2].'&id3='.$A0[10].'&temp='.$A0[0].'" title="Quitar Equipo"><img src="img/Remove.png"></a></div></td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}

function drawTablaEstatusEquipos2V3($Folio)
	{
		$R0=$this->getLineasTemporalesV3($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		  <span class="informacion">Buscar:</span>&nbsp<input id="Busqueda" class="Busqueda" type="text" >
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Imei Sim</th>
				<th bgcolor="#BFD5EA" >Sim</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Tipo de Venta</th>
				<th bgcolor="#BFD5EA" >Raiz</th>
				<th bgcolor="#BFD5EA" >Operaciones</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		$modelo=$this->getModelo($A0[4]);
		if($A0[10]==1){
			$tipoVenta="Con Equipo";
		}elseif($A0[10]==2){
			$tipoVenta="Sin Equipo";
		}
		$equipo=$this->getModelo($A0[0]);
		$sim=$this->getModelo($A0[3]);
		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[2]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}





		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[0].'</td>
		<td>'.$equipo.'</td>
		<td>'.$A0[3].'</td>
		<td>'.$sim.'</td>
		<td>'.$A0[4].'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		<td>'.$tipoVenta.'</td>
		<td>'.$A0[11].'</td>
		<td><div align="center"><a href="reportes/php/borrarTemporales2.php?id='.$A0[7].'&id2='.$A0[8].'&ss='.$A0[0].'&si='.$A0[3].'&id3='.$A0[9].'&temp='.$A0[2].'" title="Quitar Equipo"><img src="img/Remove.png"></a></div></td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}


	function drawTablaFolioTemporal($Folio){
		$R0=$this->getDatosFolioTemporal($Folio);
		$A0=mysql_fetch_row(($R0));
		echo '
			<fieldset>
			<legend>Informacion del Folio</legend>
			<div class="Izquierda">
			<table border="0">
				<tr>
					<td>Folio: </td>
					<td>&nbsp;&nbsp;&nbsp;'.$A0[0].' </td>
				</tr>
				<tr>
					<td>Plataforma: </td>
					<td>&nbsp;&nbsp;&nbsp;'.$A0[1].' </td>
				</tr>
				<tr>
					<td>Tipo de Venta: </td>
					<td>&nbsp;&nbsp;&nbsp;'.$A0[2].' </td>
				</tr>
			</table>
			</div>
			<div class="Derecha">
			<table border="0">
				<tr>
					<td>Cliente: </td>
					<td>&nbsp;&nbsp;&nbsp;'.$A0[3].' </td>
				</tr>
				<tr>
					<td>Ejecutivo de Ventas: </td>
					<td>&nbsp;&nbsp;&nbsp;'.$A0[4].' </td>
				</tr>
				<tr>
					<td>Punto Venta: </td>
					<td>&nbsp;&nbsp; '.$A0[5].'</td>
				</tr>
			</table>
			</div>
			<br><br>
		</fieldset>
		';

	}
	
		function drawTablaFinVenta1($Folio)
	{

		$Fecha=$this->getFechaEstatus($Folio);
		echo '<span><b>Fecha de Activacion: '.$Fecha.'</b></span>';
		$Contrato=$this->getContrato($Folio);
		echo '<br><span><b>No. Contrato: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Contrato.'</b></span>';
		$Comentarios=$this->getComentarios($Folio);
	    echo '<br><span><b>Comentarios: </b></span><br>';
	    echo '<textarea disabled>'.$Comentarios.'</textarea>';

		$R0=$this->getLineasFin($Folio);


	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Estatus</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		/*Addones*/

		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[0]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}

		/*Fin de Addones*/
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td>'.$A0[4].'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		<td>'.$A0[10].'</td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}
function drawTablaFinVenta2($Folio)
	{

		$Fecha=$this->getFechaEstatus($Folio);
		echo '<span><b>Fecha de Activacion: '.$Fecha.'</b></span>';
		$Contrato=$this->getContrato($Folio);
		echo '<br><span><b>No. Contrato: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Contrato.'</b></span>';
		$Comentarios=$this->getComentarios($Folio);
	    echo '<br><span><b>Comentarios: </b></span><br>';
	    echo '<textarea disabled>'.$Comentarios.'</textarea>';

		$R0=$this->getLineasFin($Folio);


	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Imei Sim</th>
				<th bgcolor="#BFD5EA" >Sim Activacion</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Estatus</th>
				

			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
		/*Addones*/

		$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[0]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}
		$sim=$this->getModelo($A0[11]);
		/*Fin de Addones*/
		echo'<tr>
		<td>'.$A0[1].'</td>
		<td>'.$A0[2].'</td>
		<td>'.$A0[3].'</td>
		<td>'.$A0[11].'</td>
		<td>'.$sim.'</td>
		<td>'.$A0[4].'</td>
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		<td>'.$A0[10].'</td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}

	function drawTablaFinVenta3($Folio)
	{
		$Fecha=$this->getFechaEstatus($Folio);
		echo '<span><b>Fecha de Activacion: '.$Fecha.'</b></span>';
		$Contrato=$this->getContrato($Folio);
		echo '<br><span><b>No. Contrato: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$Contrato.'</b></span>';
		$Comentarios=$this->getComentarios($Folio);
	    echo '<br><span><b>Comentarios: </b></span><br>';
	    echo '<textarea disabled>'.$Comentarios.'</textarea>';
		$R0=$this->getLineasFin2($Folio);

	echo '<input type="hidden" id="Modo" name="Modo" value="2"><br>
		
			<table id="myTable" cellpadding="0" cellspacing="0"  border="0" class="tablesorter">
			<thead class="fixedHeader"><tr>
				<th bgcolor="#BFD5EA" >Raiz</th>
				<th bgcolor="#BFD5EA" >Tipo Venta</th>
				<th bgcolor="#BFD5EA" >Plan</th>
				<th bgcolor="#BFD5EA" >Imei</th>
				<th bgcolor="#BFD5EA" >Equipo</th>
				<th bgcolor="#BFD5EA" >Seguro</th>
				<th bgcolor="#BFD5EA" >AddOn</th>
				<th bgcolor="#BFD5EA" >Dn</th>
				<th bgcolor="#BFD5EA" >Estatus</th>
			</tr></thead>
		<tbody class="scrollContent">
		';
		while($A0=mysql_fetch_row($R0))
		{
				if($A0[10]==1){
					$tipoVenta="Con Equipo";
					$serie=$A0[0];
					$modelo=$this->getModelo($serie);
				}elseif($A0[10]==2){
					$tipoVenta="Sin Equipo";
					$serie=$A0[3];
					$modelo=$this->getModelo($serie);

				}

		/*inicio Addones*/
				$query="SELECT Addon FROM AddonTemporal AS T1 INNER JOIN Addon AS T2 ON T1.AddonId=T2.AddonId WHERE T1.LineaTemporalId=$A0[2]";
		$R1=$this->Consulta($query);
		$addones="";
		$i=0;
		while($A1=mysql_fetch_row($R1)){
			if($i==0){
				$addones=$A1[0];
			}else{
				$addones=$addones." / "."$A1[0]";
			}
			$i++;
		}


		/*Fin de Addones*/


		echo'<tr>
		<td>'.$A0[11].'</td>
		<td>'.$tipoVenta.'</td>
		<td>'.$A0[1].'</td>
		<td>'.$serie.'</td>
		<td>'.$modelo.'</td>
		<td>'.$A0[4].'</td>
		<!--<td>'.$A0[5].'</td>-->
		<td>'.$addones.'</td>
		<td>'.$A0[6].'</td>
		<td>'.$A0[12].'</td>
		</tr>';
		}
		echo '
		</tbody></table>
		';
	}
}//Fin Clase
?>
