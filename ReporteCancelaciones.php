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
	</div>
	<br>
	<fieldset><br>
		<div id="shortapp">
			<h3><center><p>{{ message }}</p></center></h3><br>
			<div id="downloadReport" style="display: none;color:red;font-weight: bold;"><center>
				<p>CLICK PARA DESCARGAR EL ARCHIVO CSV DE CANCELACIONES</p>
				<a v-bind:href="url"><img src="img/export_csv.png" style="width:70px; height:70px;"></a>
			</center></div>
		</div>
		<br>
	</fieldset>
	<script>
		var app2 = new Vue({
			el: '#shortapp',
			data :{
				message:'',
				url: '',
			},
			mounted(){
				this.generateCSV();
			},
			methods:{
				generateCSV(){
					axios.get('/siiga/Tesoreria/controllers/CancelacionReportController.php').then(function(response){
						this.url = response.data.url;
					 	var tmp = response.data.message;
					 	var type = response.data.type;
					 	this.message = tmp;
					 	if(type == 'Succefull'){
					 		$('#downloadReport').fadeIn('slow');
					 	}else{
					 		$('#downloadReport').fadeOut('slow');
					 	}
					}.bind(this));
				}
			}
		})
	</script>
</body>
</html>