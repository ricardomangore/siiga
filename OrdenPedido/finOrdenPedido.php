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
    url: "php/finOrdenPedido.php?id=+<?php echo $ordenPedidoId;?>",
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
		
		
		
		   		  /*Funcion para buscar pendientes*/
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarEquipos.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     }
};		
	  
$(function(){
 $("#agregarEquipo").click(function(){
 var url = "php/agregarEquipo.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioAgregarEquipo").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#respuestaAgregarEquipo").html(data); // Mostrar la respuestas del script PHP.
           }
         });
    return false; // Evitar ejecutar el submit del formulario.
 });
});	  
	  
	  
	  
	  
	</script>
  </head>
  <body>
  <!--inicio de modal-->
  <!-- Modal -->
  <div class="modal fade" id="buscador" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #0574AC; color: #FFFFFF">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div align="center"><h4 class="modal-title"><span class="glyphicon glyphicon-phone"></span> Buscador de Equipos</h4></div>
        </div>
        <div class="modal-body">
         <form id="formularioAgregarEquipo">
        	<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId;?>">
         	<span class="glyphicon glyphicon-search"></span> Buscar: <input class="login" type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscar();" />
         	<div id="resultadoBusqueda"></div>
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-info" id="agregarEquipo"><span class="glyphicon glyphicon-plus"></span> Agregar Equipo</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>
  <!--Fin del Modal-->
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
   <form action="php/finalizarOrdenPedido.php" method="post">
	<div class="col-md-6">
		<div align="center"><h4><span class="glyphicon glyphicon-shopping-cart"> </span> Informaci&oacute;n de Pedido Solicitado</h4></div>
		<div id="global2" style="max-width: 100%; max-height: 400px; overflow-y: scroll;">
			<div id="resultadoBusqueda2" align="center">
			</div>
		
		</div>
		
		<div id="global2" style="max-width: 100%; max-height: 400px; overflow-y: scroll;">
		<div id="respuestaAgregarEquipo"></div>
		</div>
		
		<div align="center"><br><br><br>
			<button class="btn btn-primary"><span class="glyphicon glyphicon-flag"></span> Finalizar</button>
			<button class="btn btn-danger" type='reset'><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
		</div>
		<input type="hidden" name="ordenPedidoId" value="<?php echo $ordenPedidoId;?>">
		</form>
	</div>
		<div class="col-md-6">
<br><br>
			<div align="center">
				<div class="jumbotron">
  <div class="container" align="justify">
	<h2><b>Agregar Equipos</b></h2>
    <p>En Caso de Recibir un Equipo que no este registrado en la orden de pedido, favor de utilizar el buscador de equipos y agregarlos, los equipos agregados apareceran al final de la lista</p>
  </div>
  <div align="center">
  	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscador"><span class="glyphicon glyphicon-search"></span> Buscar Equipos</button>
  </div>
</div>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
				<br><br><br>
					
			</div>
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