<?php
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
	$usuario=$_SESSION["usuario"];
	$usuarioId=$_SESSION["usuarioId"];
	$puntoVentaId=PuntoVenta($usuarioId);
	$puestoId=$_SESSION["puestoId"];
	$ordenPedido=ordenPedido($usuarioId,$puntoVentaId);
	$puntoVenta=NombrePuntoVenta($puntoVentaId);
	$time=time();
	date_default_timezone_set('America/Mexico_City');
	$fecha=date("Y-m-d H:i:s", $time);
	$numeroSemana = date("W"); 
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Herramientas</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script>
	      
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarPunto.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     }
};	
   </script>
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
    
    
    
    
    
    
    
    
    
    
    
    
  </head>

  <body>
  <!--Menu-->
<?php
	   	if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
			$admin=1;
		}else{
			$admin=0;
		}
	  $activo="herramientas";
	  menu($activo,$ordenPedido, $puntoVentaId,$admin);
	  
	  ?>
  
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
  		<h3><b><span class="glyphicon glyphicon-wrench"></span> Herramientas de Orden de Pedidos</b></h3>
  		
  			<div class="col-md-8">
  				<form action="php/ordenPedido.php" method="post">
  					<input type="hidden" name="usuarioId" value="<?php echo $usuarioId;?>">
  				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title"><b> <span class="glyphicon glyphicon-cog"></span> Configuraci&oacute;n para Apertura y Cierre de Pedido: </b></h3>
  					</div>
  					<div class="panel-body">
    					<table class="table table-bordered" style="width: 60%;" align="center">
    						<tr>
    							<td>Fecha Inicial: <input type="date" name="fechaInicial" required></td>
    							<td>Fecha Final: <input type="date" name="fechaFin" required></td>
    						</tr>
    						<tr>
    							<td>Hora Inicial: &nbsp;&nbsp;<input type="time" name="horaInicial" required></td>
    							<td>Hora Final: &nbsp;&nbsp;<input type="time" name="horaFin" required></td>
    						</tr>
    					</table>
    					<div align="center">
    						<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-ok-circle"></span> Aceptar</button>
    						<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-circle"></span> cancelar</button>
    					</div>
  					</div>
				</div>
				</form>
				
				
				
				
				
				
				
				
				
				<form action="php/ordenPedidoPunto.php" method="post">
 				<input type="hidden" name="usuarioId" value="<?php echo $usuarioId;?>">
  				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title"><b><span class="glyphicon glyphicon-chevron-up"></span>Activar Punto de Venta </b></h3>
  					</div>
  					<div class="panel-body">
   					<div align="right">
   							<span class="glyphicon glyphicon-search"></span> Punto de Venta: <input class="login" type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscar();" /><br>
   					</div>
   					<div align="center" id="resultadoBusqueda"></div>
    				<table class="table table-bordered" style="width: 60%;" align="center">
    						<tr>
    							<td>Fecha Inicial: <input type="date" name="fechaInicial" required></td>
    							<td>Fecha Final: <input type="date" name="fechaFin" required></td>
    						</tr>
    						<tr>
    							<td>Hora Inicial: &nbsp;&nbsp;<input type="time" name="horaInicial" required></td>
    							<td>Hora Final: &nbsp;&nbsp;<input type="time" name="horaFin" required></td>
    						</tr>
    					</table>
    					<div align="center">
    						<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-ok-circle"></span> Aceptar</button>
    						<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-circle"></span> cancelar</button>
    					</div>
  					</div>
				</div>
				</form>
				
				
				
				
				
  			</div>
  			<div class="col-md-4">
  			<div align="center">
  				<img src="img/calendario.png" width="40%">
  				<div align="center"><font color="#00B8DC"><h1><b>Semana : <?php echo $numeroSemana;?></b></h1></font></div>
  			</div>
  				
  			</div>
  		
  		
   	
   		
   
   
   </div>
 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>