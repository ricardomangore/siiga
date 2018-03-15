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
	$marcas;
	for($i=0;$i<50;$i++){
		$marcas[$i]=0;
	}
	$cont=0;	
	$query="SELECT * FROM Marcas WHERE Activo=1 ORDER BY Marca";
	if($res=mysql_query($query)){
		while($row=mysql_fetch_array($res)){
			if(isset($_POST[$row['Marca']]) ){
				$marcas[$cont]=$row['MarcaId'];
				$cont++;
			}
		}
	}else{
		echo "error: ".$query.mysql_error();
	}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finalizar Pedido</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script>
	$(document).ready(function() {
    $.ajax({
    url: "php/finPedido.php?id=+<?php echo $ordenPedido;?>",
    type: "POST",
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
        $("#resultadoBusqueda").html("<img src='img/cargando.gif' />");
    }
    }).done(function(echo){
        $("#resultadoBusqueda").html(echo);
    });
});
	      
$(function(){
 $("#enviarPedido").click(function(){
 var url = "php/enviarPedido.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioEnviarPedido").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuestaEnviarPedido").html(data); // Mostrar la respuestas del script PHP.
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
	   	if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
			$admin=1;
		}else{
			$admin=0;
		}
	  $activo="carrito";
	  menu($activo,$ordenPedido, $puntoVentaId,$admin);
	  
	  ?>
  
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
   <ol class="breadcrumb">
		<li><a href="equipos3.php"><span class="circulo">1</span> Selecciona Equipos</a></li>
		<li><a href="carritoCompras.php"><span class="circulo">2</span> Revisi&oacute;n de Pedido</a></li>
   		<li class="active"><span class="circulo">3</span> Finalizar Orden de Pedido</li>
	</ol>
   <div class="row">
   <div align="center" id="respuestaEnviarPedido"></div>
   	<div class="col-md-10">
		<b><span class="glyphicon glyphicon-user"></span> Usuario: </b><?php echo $usuario;?><br> 
		<b><span class="glyphicon glyphicon-home"></span> Punto de Venta: </b><?php echo $puntoVenta;?><br>
		<b><span class="glyphicon glyphicon-calendar"></span> Fecha: </b><?php echo $fecha;?><br>
  		<b><span class="glyphicon glyphicon-calendar"></span> Semana: </b><?php echo $numeroSemana;?><br><br>
   	<form id="formularioEnviarPedido">
   		<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedido;?>">
		<div id="resultadoBusqueda" align="center"></div>
   		<div align="center">
   			<button id="enviarPedido" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-check"></span> Enviar Pedido</button>
   			<button class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span> Cancelar Pedido</button>
   		</div>
   	</form>
   	</div>
   	<div class="col-md-2">
   		<br><br><br>
   		<img src="img/lista.png" width="80%">
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