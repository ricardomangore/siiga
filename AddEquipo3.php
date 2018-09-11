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
	

	$Folio=$_GET['id1'];	
	$Movimiento=$_GET['id2'];
	$FamiliaPlanId=$_GET['id3'];
	$PlataformaId=$Herramientas->getPlataformaFolio($Folio);
	//echo "Folio: ".$Folio." Movimiento: ".$Movimiento." FamiliaPlanId: ".$FamiliaPlanId;
	$totalLineasTemporales=$Herramientas->totalLineasTemporales($Folio);
	$totalLineasAnclas=$Herramientas->totalLineasAncla($Folio);
	if(($totalLineasTemporales)==0){
		?>
			<script>
alert("No se han agregado Lineas");
window.location.href = 'AddEquipo2.php?id1='+ encodeURIComponent(<?php echo $Folio;?>)+'&id2=' + encodeURIComponent(<?php echo $Movimiento;?>)+'&id3=' + encodeURIComponent(<?php echo $FamiliaPlanId; ?>);
</script>

	

<?php
	}
if((($totalLineasAnclas)==0) && $FamiliaPlanId==4){
		?>
			<script>
alert("No Existe una Linea Ancla Favor de ingresarla");
window.location.href = 'AddEquipo2.php?id1='+ encodeURIComponent(<?php echo $Folio;?>)+'&id2=' + encodeURIComponent(<?php echo $Movimiento;?>)+'&id3=' + encodeURIComponent(<?php echo $FamiliaPlanId; ?>);
</script>

	

<?php
	}





?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="style/styleVentana.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="style/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.1.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/combos.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

<script type="text/javascript" src="js/sortedtable.js"></script>
<!--Pruebas para propio ajax-->
 <script>
 	$(function(){
 $("#FinVenta").click(function(){
 var url = "reportes/php/finVenta.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioFinVenta").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuestaFinVenta").html(data); // Mostrar la respuestas del script PHP.
           }
         });
    return false; // Evitar ejecutar el submit del formulario.
 });
});	 



 </script>
</head>
</head>
<body>
		<div align="center">
			<!--<a href="AddEquipo2.php?id1=<?php echo $Folio;?>&id2=<?php echo $Movimiento;?>&id3=<?php echo $FamiliaPlanId;?>"><button class="borrar">Regresar</button></a>-->

		
		</div>
		<h4 class="migas"><span class="blue">1</span>Selecciona la familia del plan / <span class="blue"> 2</span> <a href="AddEquipo2.php?id1=<?php echo $Folio;?>&id2=<?php echo $Movimiento;?>&id3=<?php echo $FamiliaPlanId;?>">Agregar Equipos</a> / <span class="blue">3</span>Finalizar Orden</h4>
		
		<br><br>
		<?php
			$HerramientasHtml->drawTablaFolioTemporal($Folio);
		?>
		<fieldset>
			<legend>Informacion de Lineas</legend>
			<form id="formularioFinVenta" method="post" >
			<br>
			<div align="center" id="respuestaFinVenta"></div>
			<br>
			<div id="column1">
				<label for="FechaSS"><span class="importante">*</span>Fecha de Activacion:</label>
				<input type="text" id="FechaSS" name="FechaSS" readonly="">
				<label for="Contrato"><span class="importante">*</span>Contrato</label>
				<input type="text" name="Contrato" id="Contrato">
				<input type="hidden" name="Folio" value="<?php echo $Folio;?>">
				<input type="hidden" name="FamiliaPlanId" value="<?php echo $FamiliaPlanId;?>">
			</div>
			<div id="column2">
				<label for="Comentarios">Comentarios</label>
				<textarea cols="16" rows="16" name="Comentarios"></textarea>
			</div>

			
			
			<?php
				if($FamiliaPlanId==1 || $FamiliaPlanId==2 || $FamiliaPlanId==5 || $FamiliaPlanId==7 || $FamiliaPlanId==8){
					$HerramientasHtml->drawTablaEstatusEquipos3($Folio);	
				}elseif($FamiliaPlanId==3 || $FamiliaPlanId==6){
					$HerramientasHtml->drawTablaEstatusEquipos3($Folio);
				}elseif($FamiliaPlanId==4) {
					$HerramientasHtml->drawTablaEstatusEquipos4($Folio);
				}			
				
			?>
			<br>
			<div align="right">
				<button class="guardar" name="FinVenta" id="FinVenta">Finalizar </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</div>
			<div id="dvData">
			</div>
			</form>
		</fieldset>
	
    <!-- Librería jQuery requerida por los plugins de JavaScript -->

</body>
</html>