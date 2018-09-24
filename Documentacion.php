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
	
	$EmpleadoId=$_POST['EmpleadoId'];	
	
if(isset($_FILES['Ife']))
{
$nombre_archivo = $_FILES['Ife']['name'];
$tipo_archivo = $_FILES['Ife']['type'];
$tamano_archivo = $_FILES['Ife']['size'];
$Ruta='Documentos/'.$EmpleadoId.'IFE_.jpg';
move_uploaded_file($_FILES['Ife']['tmp_name'], $Ruta);
}

if(isset($_FILES['Cd']))
{
$nombre_archivo = $_FILES['Cd']['name'];
$tipo_archivo = $_FILES['Cd']['type'];
$tamano_archivo = $_FILES['Cd']['size'];
$Ruta='Documentos/'.$EmpleadoId.'Cd_.jpg';
move_uploaded_file($_FILES['Cd']['tmp_name'], $Ruta);
}

if(isset($_FILES['An']))
{
$nombre_archivo = $_FILES['An']['name'];
$tipo_archivo = $_FILES['An']['type'];
$tamano_archivo = $_FILES['An']['size'];
$Ruta='Documentos/'.$EmpleadoId.'An_.jpg';
move_uploaded_file($_FILES['An']['tmp_name'], $Ruta);
}

if(isset($_FILES['Curp']))
{
$nombre_archivo = $_FILES['Curp']['name'];
$tipo_archivo = $_FILES['Curp']['type'];
$tamano_archivo = $_FILES['Curp']['size'];
$Ruta='Documentos/'.$EmpleadoId.'Curp_.jpg';
move_uploaded_file($_FILES['Curp']['tmp_name'], $Ruta);
}

if(isset($_FILES['Rfc']))
{
$nombre_archivo = $_FILES['Rfc']['name'];
$tipo_archivo = $_FILES['Rfc']['type'];
$tamano_archivo = $_FILES['Rfc']['size'];
$Ruta='Documentos/'.$EmpleadoId.'Rfc_.jpg';
move_uploaded_file($_FILES['Rfc']['tmp_name'], $Ruta);
}

if(isset($_FILES['Imss']))
{
$nombre_archivo = $_FILES['Imss']['name'];
$tipo_archivo = $_FILES['Imss']['type'];
$tamano_archivo = $_FILES['Imss']['size'];
$Ruta='Documentos/'.$EmpleadoId.'Imss_.jpg';
move_uploaded_file($_FILES['Imss']['tmp_name'], $Ruta);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<link href="style/styleVentana.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />

</head>
</head>
<body>	
	<form id="foo" name="foo" method="post" enctype="multipart/form-data" >
		<div id="TituloVentana">Adjuntar Documentacion</div>
		<input type="hidden" name="EmpleadoId" id="EmpleadoId" value="<?php echo $EmpleadoId; ?>" />
	
			<br>			
			<div align="center" id="resultados"></div>
				 <label for="Ife">Ife</label>
				 <input type="file" name="Ife" id="Ife" />
		         <input type="submit" name="FIfe" id="FIfe" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'IFE_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'IFE_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
		         <br><br>
				 <label for="Cd">Comporbante de Domicilio</label>
			     <input type="file" name="Cd" id="Cd" />
		         <input type="submit" name="FCd" id="FCd" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'Cd_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'Cd_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
		         <br><br>
		         <label for="An">Acta de Nacimiento</label>
			     <input type="file" name="An" id="An" />
		         <input type="submit" name="FAn" id="FAn" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'An_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'An_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
		         <br><br>
		         <label for="Rfc">Rfc</label>
			     <input type="file" name="Rfc" id="Rfc" />
		         <input type="submit" name="FRfc" id="FRfc" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'Rfc_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'Rfc_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
		         <br><br>
		         <label for="Curp">Curp</label>
			     <input type="file" name="Curp" id="Curp" />
		         <input type="submit" name="FCurp" id="FCurp" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'Curp_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'Curp_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
		         <br><br>
		         <label for="Imss">Alta IMSS</label>
			     <input type="file" name="Imss" id="Imss" />
		         <input type="submit" name="FImss" id="FImss" value="Adjuntar" />
		         <?php if(file_exists('Documentos/'.$EmpleadoId.'Imss_.jpg')) echo '<a href="Documentos/'.$EmpleadoId.'Imss_.jpg" target="_blank"><img src="img/Ver.png" id="out" title="Ver Documento" /></a>';?>
			</div>
	</form>
</body>
</html>