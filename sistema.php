<?php
	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");
	include("includes/Menu.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	
	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);

	if((date('w')!=0) && (date('w'))!=6){
		if((date("H:i:s")>="23:59:00") && (date("H:i:s")<="23:59:59")){
			$Herramientas->bloqueoFaltaCorte();
			$Herramientas->addBitacora(61, 4, 0, 'Bloqueo Tesoreria Automatico del sistema cortes','Bloqueo');
		}elseif((date("H:i:s")>="13:00:00") && (date("H:i:s")<="13:00:59")){
			$Herramientas->bloqueoFaltaDeposito();
			$Herramientas->addBitacora(61, 4, 0, 'Bloqueo Tesoreria Automatico del sistema depositos','Bloqueo');
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">


<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<!--
 <link href="style/jquery.jqplot.min.css" rel="stylesheet" type="text/css" />
 <link rel="stylesheet" type="text/css" href="tarjeta/css/navidad.css"> <!-- Para la tarjeta-->

<script src="http://code.jquery.com/jquery-1.8.1.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/table.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="js/plugins/jqplot.pieRenderer.min.js"></script>

</head>
<body>
	<?php $Menu->displayMenu(); ?>
	<div id="Contenido">
		<div id="Titulo">
			<img class="tituloImg" src="img/Aviso.png" />
			Avisos
		</div>	

		<div id="Sesion">
			<form id="foo" />
			<strong>
				Sesion: <?php echo $_SESSION['Empleado']; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="img/Out.png" id="out" title="Salir" onclick="CerrarSesion();" />
				<a href="MiSitio.php"><img src="img/MiSitio.png" id="out" title="Mi Sitio" /></a>
			</strong>
			<input type="hidden" id="Usuarioid" value="<?php echo $_SESSION['UsuarioId']; ?>">
			</form>
			<form id="logout" name="logout" method="post" action="logout.php" /></form>
		</div>

	<!--	
	Esto es para la aterjeta de Navidad
	-->
		<!--	<embed src="tarjeta/melodia.wav" hidden=true autostart=true>   
			</div>
			<div id="divAnimacion">
				<div id="divCortinaIzquierda">&nbsp;</div>
				<div id="divEscenario">
					<div id="divTexto">&nbsp;</div>
					<div id="divSanta">&nbsp;</div>
				</div>
				<div id="divCortinaDerecha">&nbsp;</div>
				<div id="divAbrir">&nbsp;</div>
			</div>
		</div>  
		
		<br><br>

-->
			<form id="foo" name="foo" method="post" >	
		<div id="Avisos">		
			<?php
				$HerramientasHtml->displayClasificacionAvisos();				
			?>
		</div>

	<!--		
		<script type="text/javascript" src="tarjeta/js/ext/jquery-snowfall/snowfall.min.jquery.js"></script>
		<script type="text/javascript" src="tarjeta/js/navidad.js"></script>
	-->
			
			<div id="PanelEncuesta">
			<img src="img/Encuesta.png">

			<div id="resultados">
				<div class="datagridBlack">
				<table>
					<thead>
						<tr>
							<th colspan="2">¿Te gustó la nueva apariencia de SIIGA?</th>						
						</tr>
					</thead>

					<tfoot>
						<tr>
							<td>
							<div id="paging">
								<ul>							
									<li><a href="#"><span id="OtroMomento">EN OTRO MOMENTO</span></a></li>
								</ul>
							</div>
							</td>

							<td>
							<div id="paging">
								<ul>
									<li><a href="#"><span id="Votar">VOTAR</span></a></li>								
								</ul>
							</div>
							</td>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<td colspan="2">
								<p>
						        <label> Si
						          <input type="radio" name="RespuestaId" value="1" id="Si" />
						        </label>
						        <br/>
						        <label> No
						          <input type="radio" name="RespuestaId" value="2" id="No" />
						        </label>					        
						      </p>
							</td>						
						</tr>
					</tbody>
				</table>
				</div>
			</div>

			</div>
<br>

</form>

</body>
</html>
