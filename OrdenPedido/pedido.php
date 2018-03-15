<?php 
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	$usuario=$_SESSION["usuario"];
	$ordenPedidoId=0;
	$ordenPedidoId=$_POST["OrdenPedido"];
	$usuario=$_SESSION["usuario"];
	$usuarioId=$_SESSION["usuarioId"];
	$puestoId=$_SESSION["puestoId"];
	$puntoVentaId=PuntoVenta($usuarioId);





	if($ordenPedidoId==0){
		$ordenPedidoId=$_GET["id"];
	}
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma, OP.Equipos AS Equipos, OP.Comentario AS Comentario FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.OrdenPedidoId=$ordenPedidoId";
	if($res=mysql_query($query)){
		$rowEquipos=mysql_fetch_array($res);
	}else{
		echo "error al consultar:".$query.mysql_error();
	}
	
	
	
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
		 
		    
	  
		
			$(document).ready(function() {
    $.ajax({
    url: "php/pedidoUsuarios.php?id=+<?php echo $ordenPedidoId;?>",
    type: "POST",
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
        $("#resultadoBusqueda2").html("<img src='img/cargando.gif' />");
    }
    }).done(function(echo){
        $("#resultadoBusqueda2").html(echo);
    });
});
		
		
		
		
		
		
		
		
	$(document).ready(function() {
    $.ajax({
    url: "php/respuestasPedido.php?id=+<?php echo $ordenPedidoId;?>",
    type: "POST",
    dataType: "html",
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function() {
        $("#resultadoRespuestas2").html("<img src='img/cargando.gif' />");
    }
    }).done(function(echo){
        $("#resultadoRespuestas2").html(echo);
    });
});

	</script>
  </head>
  <body>
    <!--Menu-->
 <?php
	  $activo="index";
	  menu($activo,$ordenPedido, $puntoVentaId);
	  
	  ?>
  
  <!--fin de Menu-->
   <div class="well" style=" background:#FFFFFF;">
	  <?php
	   $plataforma=$rowEquipos["Plataforma"];
	   if(trim($plataforma)==('AVS Azul')){
		 $fondo='style="background: #009EDB; color: #FFFFFF;"';
	   }elseif(trim($plataforma)==('NOE Naranja')){
		   $fondo='style="background: #E05206; color: #FFFFFF;"';
	   }elseif(trim($plataforma)==('PVS Rojo')){
		   $fondo='style="background: #E30412; color: #FFFFFF;"';
	   }
	   ?>
	   <?php 
	   $comentario=$rowEquipos["Comentario"];
			if(!is_null($comentario)){
				
				?>
				<div class="alert alert-danger"><h5>Orden Cancelada </h5><br><b>Comentarios: <?php echo $comentario;?> </b></div>
			
				<?php
			}
		
		?>
    
  <div class="alert alert-info"  align="center" <?php echo $fondo;?> ><h4>Orden de Pedido: <?php echo $rowEquipos["Plataforma"];?></h4></div>
      
    
	   <h4><b>Punto de Venta: </b><?php echo $rowEquipos["PuntoVenta"]; ?></h4>


	
  

 	
 	<?php 
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma, OP.Equipos AS Equipos FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.OrdenPedidoId=$ordenPedidoId";
	if($res=mysql_query($query)){
		$rowEquipos=mysql_fetch_array($res);
	}else{
		echo "error al consultar:".$query.mysql_error();
	}
	
	
	
?>
  
    
	  <?php
	   $plataforma=$rowEquipos["Plataforma"];
	   if(trim($plataforma)==('AVS azul')){
		 $fondo='style="background: #009EDB; color: #FFFFFF;"';
	   }elseif(trim($plataforma)==('NOE naranja')){
		   $fondo='style="background: #E05206; color: #FFFFFF;"';
	   }elseif(trim($plataforma)==('PVS rojo')){
		   $fondo='style="background: #E30412; color: #FFFFFF;"';
	   }
	   ?>

  
    
	   

   <div class="row">
	<div class="col-md-6">
		<div align="center"><h4><span class="glyphicon glyphicon-shopping-cart"> </span> Informaci&oacute;n de Pedido Solicitado</h4></div>
		<div id="resultadoBusqueda2" align="center">
			
		</div>
		<div align="center"><br><br><br>
		<?php
			if($rowEquipos["Estatus"]=="Finalizado"){
				?>
				<button class="btn btn-primary" disabled><span class="glyphicon glyphicon-flag"></span> Finalizar Pedido</button>
				<?php
			}else{
				?>
				<a href="finOrdenPedido.php?id=<?php echo $ordenPedidoId;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-flag"></span> Finalizar Pedido</button></a>
				<?php
			}
			
			?>
			
		</div>
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	</div>
		<div class="col-md-6">
		<?php
			if($resEstatus=mysql_query("SELECT Estatus FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId")){
				$rowEstatus=mysql_fetch_array($resEstatus);
			}else{
				echo "Error: ".mysql_error();
			}
			
			?>
		<div align="center"><h4><span class="glyphicon glyphicon-ok-circle"></span> Estatus del Pedido: <?php echo $rowEstatus["Estatus"];?></h4></div>
		<form action="php/finOrdenPedido.php" method="post">
			<input type="hidden" name="OrdenPedidoId" value="<?php echo $ordenPedidoId;?>">
			<div id="resultadoRespuestas2" align="center">
			
			</div>
			
		</form>
		</div>
	</div>
	<div align="left">
		
	</div>
<ul class="pager">
  <li class="previous"><a href="ordenPedido.php">&larr; Regresar</a></li>
</ul>
		

   
	  </div>
   
   
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>