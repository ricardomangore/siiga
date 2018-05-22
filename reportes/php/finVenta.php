<?php
	include("../../includes/Conectar.php");
	include("../../includes/Security.php");
	include("../../includes/Tools.php");
	include("../../includes/ToolsHtml.php");
	include("../../includes/Menu.php");
	$Seguridad=new Security();
	if(!$Seguridad->SesionExiste())
		header("Location: index.php");
	date_default_timezone_set('Mexico/General');
	
	$Menu= new Menu($_SESSION['UsuarioId']);
	$Herramientas= new Tools($_SESSION['UsuarioId']);
	$HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']);	
	$fecha=$_POST["FechaSS"];
	$Contrato=$_POST["Contrato"];
	$Folio=$_POST["Folio"];
	$Comentarios=$_POST["Comentarios"];
	$FamiliaPlanId=$_POST["FamiliaPlanId"];
	$queryTotal="SELECT Aux FROM LineaTemporalOpc1 WHERE Folio='$Folio' AND Aux=1";
	$resultadoTotal=$Herramientas->Consulta($queryTotal);
	$totalTemporal=mysql_num_rows($resultadoTotal);

	if($fecha!='' && $Contrato!='' && $totalTemporal==0){
		/*echo "Fecha: ".$fecha;
		echo "<br>Contrato: ".$Contrato;
		echo "<br>Folio: ".$Folio."<br>";*/

	$query="SELECT * FROM LineaTemporalOpc1 WHERE Folio='$Folio'";
	$resutaldos=$Herramientas->Consulta($query);
	while ($row=mysql_fetch_row($resutaldos)) {
		$queryAddon="SELECT AddonId FROM AddonTemporal WHERE LineaTemporalId=$row[0]";
		$resultadosAddon=$Herramientas->Consulta($queryAddon);
		$rowAddon=mysql_fetch_row($resultadosAddon);
		if($FamiliaPlanId==1 || $FamiliaPlanId==2 || $FamiliaPlanId==5 || $FamiliaPlanId==7 || $FamiliaPlanId==8){
			$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$rowAddon,$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$fecha,$Contrato,$Comentarios);
		}elseif($FamiliaPlanId==3 || $FamiliaPlanId==6){
			$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$rowAddon,$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$fecha,$Contrato,$Comentarios);


			$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[4],$row[3],81,3,$rowAddon,$row[8],6,$row[10],0,0,4,$row[14],$row[15],$row[16],$fecha,'NA','');
		}else{
			if($row[14]==1){
				$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$rowAddon,$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$fecha,$Contrato,$Comentarios);
			$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[4],$row[3],81,3,$rowAddon,$row[8],6,$row[10],0,0,4,$row[14],$row[15],$row[16],$fecha,'NA','');
			}elseif($row[14]==2){
				$band=$Herramientas->FinVenta($row[0],$row[1],$row[2],$row[4],$row[3],$row[5],$row[6],$rowAddon,$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14],$row[15],$row[16],$fecha,$Contrato,$Comentarios);

			}
		}
		
	}
	if($band==1){
		echo '<span class="notificacion">¡Venta Registrada satisfactoriamente!</span>';
	}elseif($band==0){
		echo '<span class="alerta">¡Error al Registrar la Venta!</span>';
	}
}elseif ($resultadoTotal>0) {
	echo '<span class="alerta">¡Error Esta Venta ya fue registrada!</span>';
}



	
?>