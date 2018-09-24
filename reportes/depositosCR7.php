<?php 
	//include("php/conexion.php");
	//include("php/sesion.php");
	include("php/menu.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="es">
<head>
    <meta charset="UTF-8">
<title>Puntos Venta</title>

    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="css/estilos.css" rel="stylesheet" media="screen" />
 
    <!-- librer�as opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>

<?php
	menu();
	?>
</head>

<body><br><br>

<br><br>
<h3><b>&nbsp;&nbsp; <span class="glyphicon glyphicon-list"></span> Reporte de Depositos Christian Huerta Novo</b></h3>
<div class="row">
	<div class="col-md-3">
		
	</div>
	<div class="col-md-6">
		<div class="panel panel-primary">
  		<div class="panel-heading"><h4><b><span class="glyphicon glyphicon-cog"></span> Configuracion de Descarga</b></h4></div>
  		<div class="panel-body">
    		<div class="row">
    			<div class="col-md-1"></div>
    			<div class="col-md-10">
    				<form action="php/depositosCR7.php" method="post">
    					<table class="table table-striped">
    						<tr >
    							<td><b>Fecha Inicio:</b></td>
    							<td><input class="form-control" type="date" name="fechaInicio">
    							 <p class="help-block">Fecha Inicial para descarga del reporte.</p>
    							</td>
    						</tr>
    						<tr>
    							<td><b>Fecha Fin:</b></td>
    							<td><input class="form-control" type="date" name="fechaFin">
    							 <p class="help-block">Fecha Final para descarga del reporte.</p>
    							</td>
    						</tr>
    						
    					</table>
    					<div align="center">
    						<button class="btn btn-primary"><span class="glyphicon glyphicon-download"></span> Descargar</button>
    						<button class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar </button>
    					</div>
    				</form>
    			</div>
    			<div class="col-md-1"></div>
    			
    		</div>
  		</div>
		</div>
		
		
		
		
		
	</div>
	<div class="col-md-3"></div>
</div>

</body>

    <!-- Librer�a jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (tambi�n puedes
         incluir archivos JavaScript individuales de los �nicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
</html>