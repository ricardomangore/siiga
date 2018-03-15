<?php
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
	$usuario=$_SESSION["usuario"];
	$usuarioId=$_SESSION["usuarioId"];
	$puntoVentaId=PuntoVenta($usuarioId);
	$ordenPedido=ordenPedido($usuarioId,$puntoVentaId);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plantilla básica de Bootstrap</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script>
	   	$(function(){
 $("#cargarEquipos").click(function(){
 var url = "php/cargar.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioCargarEquipos").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuestaCargarEquipos").html(data); // Mostrar la respuestas del script PHP.
           }
         });
    return false; // Evitar ejecutar el submit del formulario.
 });
});
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
	  $activo="carrito";
	  menu($activo,$ordenPedido, $puntoVentaId);
	  
	  ?>
  
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
   <ol class="breadcrumb">
  <li><a href="equipos3.php"><span class="circulo">1</span> Selecciona Equipos</a></li>
   <li class="active"><span class="circulo">2</span> Revisi&oacute;n de Pedido</li>
	   
  
</ol>
  <div class="row">
  	<div class="col-md-10">
  	<label>Seleccionar Plataforma</label>
  	<?php
		$plataforma="";
		$query="SELECT ClasificacionPersolVentaId FROM PuntosVenta WHERE PuntoVentaId=$puntoVentaId";
		if(mysql_query($query)){
			$row=mysql_fetch_array($query);
			if($row["ClasificacionPersonalVentaId"]==1 || $row["ClasificacionPersonalVentaId"]==5){
				$plataforma="Roja";
			}elseif()
		}
		?>
  	
  	
  	
  		<div align="center">
  			<table class="table" style="width: 80%; background: #0574AC; color: white;">
	  			<tr>
  					<td>EquipoId</td>
  					<td>Marca</td>
  					<td>Modelo</td>
  					<td>Cantidad</td>
  				</tr>
  			</table>
  			<button class="btn btn-info btn-sm"><span class="glyphicon glyphicon-refresh"></span> Recalcular</button>
  			<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
  			<button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
  		</div>
  	</div>
  	<div class="col-md-2">
  		<div align="center">
  			<img src="img/carrito.png" width="100%">
  			
  		</div>
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