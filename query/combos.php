<?php

include("../includes/Conectar.php");
include("../includes/Tools.php");

$Herramientas = new Tools(0);


$Id=$_REQUEST["id"];
$Opc=$_REQUEST["opc"];

switch ($Opc) 
{
	case '1':
				echo '<option value="0" selected="selected">Elige Colonia</option>';
				$Q0="SELECT ColoniaId, Colonia FROM Colonias WHERE CodigoPostal='$Id' ORDER BY Colonia";
				$R0=$Herramientas->Consulta($Q0);
				while($A0=mysql_fetch_row($R0))
				{
					echo '<option value="'.$A0[0].'" title="'.utf8_decode($A0[1]).'">'.utf8_decode($A0[1]).'</option>';
				}	
		break;	

	default:
		echo '<option value="1">N/A</option>';
		break;
}

?>