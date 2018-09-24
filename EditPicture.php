<?php

$nombre_archivo = $_FILES['userfile']['name'];
$tipo_archivo = $_FILES['userfile']['type'];
$tamano_archivo = $_FILES['userfile']['size'];

$EmpleadoId=$_POST['EmpleadoId'];
$Ruta='Photo/'.$EmpleadoId.'_.jpg';
//echo $Ruta; exit;
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $Ruta)){	
				
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>Fotos</title>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<link rel="stylesheet" type="text/css" media="screen" href="style/uvumi-crop.css" />
	<script type="text/javascript" src="js/mootools-for-crop.js"></script>
	<script type="text/javascript" src="js/UvumiCrop-compressed.js"></script>

	<script type="text/javascript">
		exampleCropper1 = new uvumiCropper('EmpleadoId',{
			coordinates:true,
			preview:true,
			downloadButton:false,
			saveButton:true
		});

function Redimensiona() 	
{
	x=(screen.width);
	y=(screen.height);
	window.resizeTo(x,y);
	self.moveTo(0,0);
	return;
}

	</script>

</head>
<body onload="Redimensiona();">	
	<div id="main">
		<div>
			<p><img id="EmpleadoId" src="<?php echo $Ruta; ?>" alt="Foto"/></p>
</div>
	</div>    
</body>
</html>
<?php
	}
else {	echo "Error"; }
?>