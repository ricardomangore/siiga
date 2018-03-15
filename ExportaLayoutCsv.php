<?php  
include("includes/Conectar.php");   
include("includes/Security.php");
include("includes/Tools.php");

    $Seguridad=new Security();
    if(!$Seguridad->SesionExiste())
        header("Location: index.php");
        $Herramientas= new Tools($_SESSION['UsuarioId']);

$hoy = date("Ymd", strtotime("yesterday"));

$MiFecha='2015-01-01';

switch ($_GET['opc']) {
    case '1':
            $R0=$Herramientas->getInventarioVSO();
            $Nombre='0000106182_Inventario_'.$hoy;
            
        break;
    
    case '2':
            $R0=$Herramientas->getConsumosVSO();
            $Nombre='0000106182_Consumos_'.$hoy;
        break;
    case '3':
            $R0=$Herramientas->getInventarioVSObyFecha($MiFecha);
            $Nombre='0000106182_Inventario_'.$MiFecha;
            
        break;
    
    case '4':
            $R0=$Herramientas->getConsumosVSObyFecha($MiFecha);
            $Nombre='0000106182_Consumos_'.$MiFecha;
        break;
}

$Orden=$Herramientas->getOrden($R0);


Header("Content-type:application/csv");
Header("Content-Disposition:attachment; filename=$Nombre.csv");


while($A0=mysql_fetch_row($R0)) 
{
    for($j=0; $j<$Orden['columnas']; $j++)
        print($A0[$j]);
    print("\r\n");
}

?>