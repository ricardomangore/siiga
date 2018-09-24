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
<meta name="uid" content="<?php echo $_SESSION['UsuarioId']; ?>">
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
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>


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
							<div class="messageNotification" style="display: none;color:red;font-weight: bold;"><center><p>{{ msjnotification }}</p></center></div>
							<input type="hidden" name="uid" value="<?php echo $_SESSION['UsuarioId']?>"/>
							<legend>Cancelaciones</legend>
							<br/><br/>
							<div class="Izquierda">
								<label>
									Orden DRM/OMF:
								</label>
								<input 
									type="text" 
									name="order_crm" 
									v-model.trim="ordencrm.value" 
									v-on:keyup="validaOrdenCRM(ordencrm.value)"
									v-on:blur="validaOrdenCRM(ordencrm.value)"
									/>
								<div 
									v-if="ordencrm.haserror===true"
									style="color: red; font-weight: bold;"
									>
									{{ ordencrm.message }}
								</div>
								<br/><br/><br/>
								<label>
									N&uacutemero de Documento: 
								</label>
								<input 
									type="text" 
									name="numero_documento"
									v-model.trim="numdocument.value" 
									v-on:keyup="validaNumDoc(numdocument.value)"
									v-on:blur="validaNumDoc(numdocument.value)"/>
								<div v-if="numdocument.haserror===true"
									style="color:red; font-weight: bold;"
									>
									{{ numdocument.message }}
								</div>
							</div>
							<div class="Derecha">
								<label>
									Concepto de Pago:
								<label>
								<select name="concepto"
										v-model="concept.value"
										v-on:click="validaConcepto()"
										v-on:blur="validaConcepto()"
										>
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
								<div v-if="concept.haserror===true"
									style="color:red; font-weight: bold;"
									>
									{{ concept.message }}
								</div>
								<br/><br/><br/>
								<label>
									Desripci&oacuten del movimiento
								</label>
								<textarea name="descripcion"
									v-model.trim="description.value" 
									v-on:keyup="validaDescription(description.value)"
									v-on:blur="validaDescription(description.value)"/>>
								</textarea>
								<div v-if="description.haserror===true"
									style="color:red; font-weight: bold;"
									>
									{{ description.message }}
								</div>
								<br/><br/><br/>
								<button v-bind:disabled="disabled"
									v-on:click.prevent="submit()" 
									type="submit">
									enviar
								</button>
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
	  		ordencrm : 
	  		{
	  			name: '',
	  			value: '',
	  			haserror: false,
	  			isempty: false,
	  			isvalid: false,
	  			message: '',
	  		},
	  		numdocument:{
	  			name: '',
	  			value: '',
	  			haserror: false,
	  			isempty: false,
	  			isvalid: false,
	  			message: '',
	  		},
	  		description: {
	  			name: '',
	  			value: '',
	  			haserror: false,
	  			isempty: false,
	  			isvalid: false,
	  			message: '',
	  		},
	  		concept: {
	  			name: '',
	  			value: '',
	  			haserror: false,
	  			isempty: false,
	  			isvalid: false,
	  			message: '',
	  		},
	  		disabled:'disabled',
	  		uid: '',
	  		msjnotification: '',
	  		showMessageSuccess: false,
		  },
		  mounted(){
		  	let token = document.head.querySelector('meta[name="uid"]');
		  	this.uid = token.content;
		  },
		  methods:{
		  	validaOrdenCRM(param){
		  		var regex = /^([0-9])*$/;
		  		var str = param.toString();
		  		if(this.isEmpty(str)){
		  			this.ordencrm.haserror=true;
		  			this.ordencrm.isvalid = false;
		  			this.ordencrm.message='debe llenar el campo'
		  		}else{
		  			this.ordencrm.haserror=false;
		  			this.ordencrm.isvalid = true;
		  			this.ordencrm.message='';
		  			if(!this.isNumeric(str)){
			  			this.ordencrm.haserror=true;
			  			this.ordencrm.isvalid = false;
			  			this.ordencrm.message = 'el campo debe ser númerico';
			  		}
			  		else{
			  			this.ordencrm.haserror = false;
			  			this.ordencrm.isvalid = true;
			  			this.ordencrm.message = '';
			  		}
		  		}
		  		this.validaButton();
		  	},
		  	validaNumDoc(param){
		  		var regex = /^([0-9])*$/;
		  		var str = param.toString();
		  		if(this.isEmpty(str)){
		  			this.numdocument.haserror=true;
		  			this.numdocument.isvalid = false;
		  			this.numdocument.message='debe llenar el campo'
		  		}else{
		  			this.numdocument.haserror=false;
		  			this.numdocument.isvalid = true;
		  			this.numdocument.message='';
		  			if(!this.isNumeric(str)){
			  			this.numdocument.haserror=true;
			  			this.numdocument.isvalid = false;
			  			this.numdocument.message = 'el campo debe ser númerico';
			  		}
			  		else{
			  			this.numdocument.haserror = false;
			  			this.numdocument.isvalid = true;
			  			this.numdocument.message = '';
			  		}
		  		}
		  		this.validaButton();
		  	},
		  	validaDescription(param){
		  		var regex = /^([0-9])*$/;
		  		var str = param.toString();
		  		if(this.isEmpty(str)){
		  			this.description.haserror=true;
		  			this.description.isvalid = false;
		  			this.description.message='debe llenar el campo'
		  		}else{
		  			this.description.haserror=false;
		  			this.description.isvalid = true;
		  			this.description.message='';
		  		}
		  		this.validaButton();
		  	},
		  	validaConcepto(){
		  		if(this.concept.value===''){
		  			this.concept.haserror= true;
		  			this.concept.isvalid=false;
		  			this.concept.message= 'seleccione una opción';
		  		}else{
		  			this.concept.haserror= false;
		  			this.concept.isvalid=true;
		  			this.concept.message= '';
		  		}
		  	},
		  	isNumeric(param){
		  		var regex = /^([0-9])*$/;
		  		var str = param.toString();
		  		return regex.test(str);
		  	},
		  	isEmpty(param){
		  		var returnValue = true;
		  		if(param !== '')
		  			returnValue = false;
		  		return returnValue;
		  	},
		  	validaButton(){
		  		if(this.ordencrm.isvalid && 
		  			this.numdocument.isvalid &&
		  			this.description.isvalid &&
		  			this.concept.isvalid){
		  			//console.log('habilitamos botón');
		  			//console.log(this.ordencrm.value + ";" + this.numdocument.value + ";" + this.description.value);
		  			this.disabled = false;
		  		}else{
		  			//console.log('deshabilita botón');
		  			//console.log(this.ordencrm.value + ";" + this.numdocument.value + ";" + this.description.value);
		  			this.disabled = 'disabled';
		  		}
		  	},
		  	submit(){
		  		//const axios = require('axios');
		  		var formData = new FormData();
		  		formData.append('ordenCRM',this.ordencrm.value);
		  		formData.append('numeroDocumento',this.numdocument.value);
		  		formData.append('descripcion',this.description.value);
		  		formData.append('concepto',this.concept.value);
		  		formData.append('uid',this.uid);
		  		var tmp;
		  		axios.post('/siiga/Tesoreria/controllers/CancelacionController.php',formData).
		  		then(function(response){
		  			tmp = response.data.message
		  			var type = response.data.type;
		  			this.msjnotification = tmp;
		  			if(type == 'Succefull'){
		  				$('.messageNotification').fadeOut('slow',function(){
		  					$('.messageNotification').fadeIn('slow',function(){
		  						$('.messageNotification').fadeOut('slow');
		  					});
		  				});
		  			}else{
		  				$('.messageNotification').fadeOut('slow',function(){
		  					$('.messageNotification').fadeIn('slow');
		  				});
		  			}
		  			this.ordencrm.value = '';
		  			this.numdocument.value = '';
		  			this.description.value = '';
		  			this.concept.value = '';
		  		}.bind(this));
		  		this.disabled = 'disabled';
		  	}
		  }
		})
	</script>
</body>
</html>
