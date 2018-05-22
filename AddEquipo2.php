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



	$queryTotal="SELECT Aux FROM LineaTemporalOpc1 WHERE Folio='$Folio' AND Aux=1";
	$resultadoTotal=$Herramientas->Consulta($queryTotal);
	$totalTemporal=mysql_num_rows($resultadoTotal);
	if($totalTemporal>0){
		echo "<script>alert('Ya se ha cerrado este folio');</script>";
		echo "<script>window.close();</script>";  
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

</head>
</head>
<body>
		<div align="center">
			
		</div>
		<h4 class="migas"><span class="blue">1</span>	<a href="AddEquipo.php?id1=<?php echo $Folio;?>&id2=<?php echo $Movimiento;?>">Selecciona la familia del plan </a>/ <span class="blue">2</span> Agregar Equipos</h4>
		<form id="foo" name="foo" method="post" >
		<div id="TituloVentana">CambiaEstatus</div>
		<input type="hidden" name="MiFolio" id="MiFolio" value="<?php echo $Folio; ?>" />
		<input type="hidden" name="Movimiento" id="Movimiento" value="<?php echo $Movimiento; ?>" />
		<input type="hidden" name="ModuloId" id="ModuloId" value="0" />		
			<br>			
			<div align="center" id="resultados"></div>
			<div id="display" name="display">	

			<?php				
				$HerramientasHtml->drawaddEquipo($PlataformaId,$FamiliaPlanId);
			?>	

			<HR width=98% align="center">
			<?php
				if($FamiliaPlanId==1 || $FamiliaPlanId==2 || $FamiliaPlanId==5 || $FamiliaPlanId==7 || $FamiliaPlanId==8){
					$HerramientasHtml->drawTablaEstatusEquipos2($Folio);	
				}elseif($FamiliaPlanId==3 || $FamiliaPlanId==6){
					$HerramientasHtml->drawTablaEstatusEquipos2V2($Folio);
				}elseif ($FamiliaPlanId==4) {
					$HerramientasHtml->drawTablaEstatusEquipos2V3($Folio);
				}		
			?>
			
			<div id="dvData">
			</div>
			</div>
		</form>
		<div align="right">
				<br>
				<a href="AddEquipo3.php?id1=<?php echo $Folio;?>&id2=<?php echo $Movimiento;?>&id3=<?php echo $FamiliaPlanId;?>"><button class="lista">Siguiente</button></a>&nbsp;&nbsp;

			</div>
	

</body>
</html>