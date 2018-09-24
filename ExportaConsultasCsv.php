<?php

include("includes/Conectar.php");
include("includes/Security.php");
include("includes/Tools.php");


    $Seguridad=new Security();
    if(!$Seguridad->SesionExiste())
        header("Location: index.php");
        $Herramientas= new Tools($_SESSION['UsuarioId']);


switch ($_GET['opc'])
{
	case 1:
			$R0=$Herramientas->getConsultaVU();
			break;
	case 2: $R0=$Herramientas->getConsultaVUMC();
			break;
  case 3: $R0=$Herramientas->InventarioPuntos();
      break;
  case 4: $R0=$Herramientas->PuntosVentaActivos();
      break;
  case 5: $R0=$Herramientas->getOriginacion();
      break;
  case 6: $R0=$Herramientas->getOriginacionMC();
      break;
  case 7: $R0=$Herramientas->getPersonal();
      break;
  case 8: $R0=$Herramientas->getLecturaFisica();
      break;
  case 9: $R0=$Herramientas->getPersonalInactivo();
      break;
  case 10: $R0=$Herramientas->getReporteSeguimiento();
      break;
  case 11: $R0=$Herramientas->getInfoPersonal();
      break;
  case 12: $R0=$Herramientas->getVentasAccesorio();
      break;
  case 13: $R0=$Herramientas->getInventarioAcc();
      break;
  case 14: $R0=$Herramientas->plantillaPresupuestal();
      break;
  case 15: $R0=$Herramientas->getVentasLineasTotal();
      break;
  case 16: $R0=$Herramientas->getReporteImss();
      break;
  case 17: $R0=$Herramientas->getReporteVentasTP();
      break;
  case 18: $R0=$Herramientas->getFactPendientesPorRecibir();
      break;
  case 19: $R0=$Herramientas->getMercanciaTransito();
      break;
  case 20: $R0=$Herramientas->getVSO();
      break;
  case 21: $R0=$Herramientas->getReporteBuro();
      break;
  case 22: $R0=$Herramientas->getReporteChecador();
      break;
  case 23: $R0=$Herramientas->getRecargas();
      break;
  case 24: $R0=$Herramientas->revisionAvisos();
      break;
  case 25: $R0=$Herramientas->getReporteSigi();
      break;
  case 26: $R0=$Herramientas->getReporteValidaciones();
      break;
  case 27: $R0=$Herramientas->getReporteRotacionEquipos();
      break;


}//switch

$Orden=$Herramientas->getOrden($R0);

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte.xls");

$i=0;
echo '<table>    ';
while($A0=mysql_fetch_row($R0))
     {
       echo '<tr>';
          for($j=0; $j<$Orden['columnas']; $j++)
          {
            if($i==0)
            echo '<th bgcolor="#BFD5EA">'.utf8_decode($A0[$j]).'</th>';
            else
            echo '<td>'.utf8_decode($A0[$j]).'</td>';
          }
       echo '</tr>';
       $i++;
     }
        echo '</tr>';
        echo '</table>';
?>

