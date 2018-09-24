<?php
include("includes/Conectar.php");   
include("includes/Security.php");
include("includes/Tools.php");

$Seguridad=new Security();
if(!$Seguridad->SesionExiste())
   header("Location: index.php");
   $Herramientas= new Tools($_SESSION['UsuarioId']);
   $R0=$Herramientas->getResultados($_GET['tmp'], $_GET['clave']);

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