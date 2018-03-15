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
	  $activo="reporte";
	  menu($activo,$ordenPedido, $puntoVentaId,$admin);
	  ?>
  
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
  		<h3><b><span class="glyphicon glyphicon-list-alt"></span> Reporte de Orden de Pedidos</b></h3>
  		
  			<div class="col-md-8">
  			<!--
  				<form action="php/reportesSugerido.php" method="post">
  				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title"><b> <span class="glyphicon glyphicon-cog"></span> Configuraci&oacute;n para Descarga de Reportes: </b></h3>
  					</div>
  					<div class="panel-body">
    					<table class="table table-bordered" style="width: 60%;" align="center">
    						<tr>
    							<td>Fecha Inicial: <input type="date" name="fechaInicial" ></td>
    							<td>Fecha Final: <input type="date" name="fechaFin" ></td>
    						</tr>
    						<tr>
    							<td>Semana: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    							<select name="semana">
    								<option>-- Seleccionar Semana --</option>
    								<?php
										/*$querySemanas="SELECT DISTINCT Semana FROM OrdenPedido WHERE Activo=1 ORDER BY Semana";
										if($res=mysql_query($querySemanas)){
											while($row=mysql_fetch_array($res)){
												echo "<option>".$row["Semana"]."</option>";
											}
										}*/
									?>
    							</select></td>
							</tr>
   							<tr>
    							<td>Plataforma: &nbsp;&nbsp;
    							<select name="plataforma">
    								<option>--Selecciona Plataforma--</option>
    								<option>AVS Azul</option>
    								<option>NOE Naranja</option>
    								<option>PVS Rojo</option>
    							</select>
    							
    							</td>
    						</tr>
   
    					</table>
    					<div align="center">
    						<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download"></span> Descargar</button>
    						<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-circle"></span> Limpiar Filtros</button>
    					</div>
  					</div>
				</div>
				</form>-->
			
			
				
					
						
							
								
									
										
											
												
													
			<form action="php/reportesSugerido.php" method="post">
  				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title"><b> <span class="glyphicon glyphicon-cog"></span> Configuraci&oacute;n para Descarga de Reportes: </b></h3>
  					</div>
  					<div class="panel-body">
    					<table class="table table-bordered" style="width: 60%;" align="center">
    						<tr>
    							<td>Semana: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    							<select name="semana">
    								<option>-- Seleccionar Semana --</option>
    								<?php
										$querySemanas="SELECT DISTINCT Semana FROM OrdenPedido WHERE Activo=1 AND (FECHA>= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)) ORDER BY Semana";
										if($res=mysql_query($querySemanas)){
											while($row=mysql_fetch_array($res)){
												echo "<option>".$row["Semana"]."</option>";
											}
										}
									?>
    							</select></td>
							</tr>
   							<tr>
    							<td>Plataforma: &nbsp;&nbsp;
    							<select name="plataforma">
    								<option>--Selecciona Plataforma--</option>
    								<option>AVS Azul</option>
    								<option>NOE Naranja</option>
    								<option>PVS Rojo</option>
    							</select>
    							
    							</td>
    						</tr>
    						<!--<tr>
    							<td><input type="checkbox" name="general"> Descargar Reporte Completo</td>
    						</tr>-->
    					</table>
    					<div align="center">
    						<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download"></span> Descargar</button>
    						<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-circle"></span> Limpiar Filtros</button>
    					</div>
  					</div>
				</div>
				</form>
														
															
																	
				<form action="php/resumenPedido.php" method="post">
  				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title"><b> <span class="glyphicon glyphicon-stats"></span> Reporte para Resumen de Pedidos: </b></h3>
  					</div>
  					<div class="panel-body">
    					<table class="table table-bordered" style="width: 60%;" align="center">
    						<tr>
    							<td>Semana: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    							<select name="semana">
    								<option>-- Seleccionar Semana --</option>
    								<?php
										$querySemanas="SELECT DISTINCT Semana FROM OrdenPedido WHERE Activo=1 AND (FECHA>= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)) ORDER BY Semana";
										if($res=mysql_query($querySemanas)){
											while($row=mysql_fetch_array($res)){
												echo "<option>".$row["Semana"]."</option>";
											}
										}
									?>
    							</select></td>
							</tr>
   							
    						<!--<tr>
    							<td><input type="checkbox" name="general"> Descargar Reporte Completo</td>
    						</tr>-->
    					</table>
    					<div align="center">
    						<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-download"></span> Descargar</button>
    						<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove-circle"></span> Limpiar Filtros</button>
    					</div>
  					</div>
				</div>
				</form>			
				
				
				
  			</div>
  			<div class="col-md-4">
  			<div align="center">
  				<img src="img/reportes.png" width="60%">
  				
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