<?php
	include("includes/Conectar.php");
	include("includes/Security.php");
	include("includes/Tools.php");
	include("includes/ToolsHtml.php");
	include("includes/Menu.php");

	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	date_default_timezone_set('Mexico/General');

	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);	

	$Clave=$_SESSION['UsuarioId'].date("dmyHis").'66';
	$ModuloId=77;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="style/anytime.5.0.3.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.1.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/combos.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="js/anytime.5.0.3.js"></script>
<script type="text/javascript" src="js/sortedtable.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>


</head>
</head>
<body>
	<?php $Menu->displayMenu(); ?>
	<div id="Contenido">
		<?php
			$HerramientasHtml->displayHeaderModulo($ModuloId);
		?>
		<div id="Sesion">
			<form id="foox" />
			<strong>
				Sesion: <?php echo $_SESSION['Empleado']; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<img src="img/Out.png" id="out" title="Salir" onclick="CerrarSesion();" />
				<a href="MiSitio.php"><img src="img/MiSitio.png" id="out" title="Mi Sitio" /></a>
			</strong>
			</form>
			<form id="logout" name="logout" method="post" action="logout.php" /></form>
		</div>
		
			<form id="foo" name="foo" method="post" >		
				<br/>			
				<div align="center" id="resultados"></div>
				<div id="display" name="display">
					<!--<input type="hidden" name="Clave" id="Clave" value="<?php echo $Clave; ?>" />-->
					<fieldset>
						<div id="app">
							<legend>Cancelaciones</legend>
							<div class="Izquierda">
								<label>
									Orden DRM/OMF:
								</label>
								<input type="text" name="order_crm" v-model="ordenCRM" v-on:keyup="validaOrdenCRM()"/>
								{{ msmErrorCRM }}
								<br/><br/><br/>
								<label>
									Concepto de Pago:
								<label>
								<select>
									<option value="p_inical">
										Pago Inicial
									</option>
									<option value="p_servicio">
										Pago Servicios
									</option>
									<option value="p_anticipado">
										Pago Anticipado
									</option>
								</select>
							</div>
							<div class="Derecha">
								<label>
									N&uacutemero de Documento
								</label>
								<input type="text" name="numero_documento"/>
								<br/><br/><br/>
								<button type="submit">enviar</button>
							</div>
						</div><!-- #app -->
					</fieldset>
				</div>
			</form>
	</div>
	<script type="text/javascript">
		var app = new Vue({
		  el: '#app',
		  data: {
		    ordenCRM: '',
		    msmErrorCRM: '',
		    numeroDocumento: '',
		  },
		  methods:{
		  	validaOrdenCRM(){
		  		var regex = /^([0-9])*$/;
		  		newString = new String("1111111");
		  		var str = this.ordenCRM.toString();
		  		console.log(str);
		  		console.log(regex.test(str));
		  		if(!regex.test(str))
		  			this.msmErrorCRM = 'el campo debe ser numerico';
		  		else
		  			this.msmErrorCRM = '';
		  		
		  	},
		  	validaDocumento(){

		  	},

		  }
		})
	</script>
</body>
</html>
