<?php 
	include("php/conexion.php");
	$ordenPedidoId=$_GET["id"];
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma, OP.Equipos AS Equipos FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.OrdenPedidoId=$ordenPedidoId";
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
    <title>Plantilla básica de Bootstrap</title>
 
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
    url: "php/analisis2.php?id=+<?php echo $ordenPedidoId;?>",
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
    url: "php/respuestas2.php?id=+<?php echo $ordenPedidoId;?>",
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
		
		
		
		
		
		
		
		
		
		 
		 
		  /*Funcion para buscar pendientes*/
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarTicketPendiente.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else {
	 
	 //funcion para mostrar todos los datos de la tabla
       $.ajax({
    url: "php/todosDatos.php",
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
	  
		
$(function(){
 $("#ajusteEquipos").click(function(){
 var url = "php/ajusteEquipos.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioAjusteEquipos").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#resultadoRespuestas2").html(data); // Mostrar la respuestas del script PHP.
           }
         });
    return false; // Evitar ejecutar el submit del formulario.
 });
});
	</script>
  </head>
  <body>
    <!--Menu-->
  <nav class="navbar navbar-default" role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="ordenPedido.php"><font color="#ffffff">Orden de Pedido</font></a>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#">
          <font color="#ffffff"><b><?php echo $usuario;?> <span class="glyphicon glyphicon-off"></span></b></font>
        </a>
       
      </li>
    </ul>
  </div>
</nav>
  
  <!--fin de Menu-->
   <div class="well" style=" background:#FFFFFF;">
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
  <div class="alert alert-info"  align="center" <?php echo $fondo;?> ><h4>Orden de Pedido: <?php echo $rowEquipos["Plataforma"];?></h4></div>
  
    
	   <h5><b>Punto de Venta: </b><?php echo $rowEquipos["PuntoVenta"]; ?></h5>
	   <h5><b>Solicitante: </b><?php echo $rowEquipos["Usuario"]; ?></h5>

   <div class="row">
	<div class="col-md-6">
	<form id="formularioAjusteEquipos" method="post">
		
		<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId; ?>">
		<div id="resultadoBusqueda2" align="center">
			
		</div>
		<div align="center">
			<button id="ajusteEquipos" class="btn btn-primary"><span class="glyphicon glyphicon-hand-right"></span>  Procesar</button>
			<button class="btn btn-danger" onClick=""><span class="glyphicon glyphicon-remove-circle"></span>  Cancelar</button>
			</form>	
			
	
		</div>
	</div>
		<div class="col-md-6">
		<form action="php/guardar.php" method="post">
			<input type="hidden" name="OrdenPedidoId" value="<?php echo $ordenPedidoId;?>">
			<div id="resultadoRespuestas2" align="center">
			
			</div>
			
		</form>
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