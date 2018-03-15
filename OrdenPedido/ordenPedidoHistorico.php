<?php 
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	$usuario=$_SESSION["usuario"];
	$usuarioId=$_SESSION["usuarioId"];
	$puestoId=$_SESSION["puestoId"];
	$puntoVentaId=PuntoVenta($usuarioId);
	$ordenPedido=ordenPedido($usuarioId,$puntoVentaId);
?>
<!DOCTYPE html>
<html lang="es"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orden de Pedido</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
 
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
	<?php
		if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
			?>
				$(document).ready(function() {
    			$.ajax({
    				url: "php/todosDatosHistorico.php",
    				type: "POST",
    				dataType: "html",
    				cache: false,
    				contentType: false,
    				processData: false,
    				beforeSend: function() {
        				$("#resultadoBusqueda").html("<img src='img/cargando.gif' width='100' height='100' />");
    				}
    				}).done(function(echo){
        				$("#resultadoBusqueda").html(echo);
    				});
				});
				function buscarOrden() {
    var textoBusqueda = $("input#busquedaOrden").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarOrdenHistorico.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else {
	 
	 //funcion para mostrar todos los datos de la tabla
       $.ajax({
    url: "php/todosDatosHistorico.php",
    type: "POST",
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
    //Opcional, mostrar una imagen de carga mientras se obtienen los datos
    beforeSend: function() {
        $("#resultadoBusqueda").html("<img src='img/cargando.gif' width='30' height='30' />");
    }
    }).done(function(echo){
        $("#resultadoBusqueda").html(echo);
    });
	//fin de la funcion para mostrar todos los datos
        };
};

		
		
		
		
		
		
		
		
		
		
		
		
		
		<?php
		}else{
			?>
				$(document).ready(function() {
    			$.ajax({
    				url: "php/todosDatos2.php?id=+<?php echo $usuarioId;?>",
    				type: "POST",
    				dataType: "html",
    				cache: false,
    				contentType: false,
    				processData: false,
    				beforeSend: function() {
        				$("#resultadoBusqueda").html("<img src='img/cargando.gif'  />");
    				}
    				}).done(function(echo){
        				$("#resultadoBusqueda").html(echo);
    				});
				});
		
				
		<?php
		}
		
		?>

		 
		 
		  /*Funcion para buscar pendientes*/
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarEquipos.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else {
	 
	 //funcion para mostrar todos los datos de la tabla
       $.ajax({
    url: "php/todosEquiposPag.php",
    type: "POST",
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
    //Opcional, mostrar una imagen de carga mientras se obtienen los datos
    beforeSend: function() {
        $("#resultadoBusqueda").html("<img src='../img/load.gif' width='30' height='30' />");
    }
    }).done(function(echo){
        $("#resultadoBusqueda").html(echo);
    });
	//fin de la funcion para mostrar todos los datos
        };
};		   
	  
	</script>
  </head>
  <body>
    <!--Menu-->
 <?php
	  	if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
			$admin=1;
		}else{
			$admin=0;
		}
	  
	  $activo="index";
	  menu($activo,$ordenPedido, $puntoVentaId,$admin);
	  
	  ?>
  <!--fin de Menu-->
   <div class="well" style=" background:#FFFFFF;">
   	<b>Bienvenido: <?php echo $usuario;?></b><br><br>
	<div class="row">
	
		<!--<div align="left">
			
				Filtrar por:
				<select>
					<option>--Selecciona una opci&oacute;n--</option>
					<option>Nuevo</option>
					<option>En Proceso</option>
					<option>Revisado</option>
				</select>
			
			<button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
			<button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Quitar</button>
		</div>
	-->
	<div class="col-md-12">
	<div align="center">
		<ul class="nav nav-tabs">
			<li><a href="ordenPedido.php"><b>Pedidos Semana Actual</b></a></li>
			<li class="active"><a href="ordenPedidoHistorico.php"><b>Pedidos en Hist&oacute;rico</b></a></li>
		</ul>
		
	</div>

	</div>
	<br><br><br>
		<div class="col-md-5">
		
			<div align="right">
				<!--<a href="equipos3.php">
					<button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> Nueva Orden</button>
				</a>-->
			</div>
		</div>
		<?php
			
			if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
				?>
				
				<form action="analisisPedido.php" method="post">
			<?php
			}else{
			?>
				<form action="pedido.php" method="post">
			<?php
			}
		?>
		
		<div class="col-md-4">
				<button class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-eye-open"></span> Ver Orden</button>
				<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
		</div>
		
			
		
		<div align="right">
		<span class="glyphicon glyphicon-search"></span> Buscar: <input class="login" type="text" name="busquedaOrden" id="busquedaOrden" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscarOrden();" /><br>
		</div>
		<br>
	
		<div id="resultadoBusqueda" align="center">
		</div>
		</form>
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