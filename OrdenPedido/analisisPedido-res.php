<?php 
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	$usuario=$_SESSION["usuario"];
	$puestoId=$_SESSION["puestoId"];
	$ordenPedidoId=0;
	$ordenPedidoId=$_POST["OrdenPedido"];
	if($ordenPedidoId==0){
		$ordenPedidoId=$_GET["id"];
	}
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, OP.Semana AS Semana, OP.Folio AS Folio, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma, OP.Equipos AS Equipos, OP.Comentario AS Comentario FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.OrdenPedidoId=$ordenPedidoId";
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
    <title>An&aacute;lisis del Pedido</title>
 
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
    url: "php/analisis1.php?id=+<?php echo $ordenPedidoId;?>",
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
		
		<?php
		if($rowEquipos["Estatus"]=='Finalizado'){
			?>
		
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

		<?php
		}else{
			?>
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
		
		<?php
		}
		?>


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
         <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancelar Orden de Pedido</h4>
        </div>
        <div class="modal-body">
          <h3><b>¿Esta seguro de cancerlar la Orden ?</b></h3>
          <form action="php/cancelarPedido.php" method="post">
          <input type="hidden" name="ordenId" value="<?php echo $ordenPedidoId;?>">
          <textarea class="form-control" name="comentarios" rows="6" required></textarea>
          
          
          
        </div>
        <div class="modal-footer">
         <div align="center">
		    <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
        	<button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
        	</form>
         </div>
          
        </div>
       
      </div>
      
    </div>
  </div>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
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
  <a name="analisis1"></a>
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
  <div class="alert alert-info"  align="center" <?php echo $fondo;?> ><h4>Orden de Pedido: <?php echo $rowEquipos["Plataforma"];?></h4></div>
    <?php 
	   $comentario=$rowEquipos["Comentario"];
			if(!is_null($comentario)){
				
				?>
				<div class="alert alert-danger"><h5>Orden Cancelada </h5><br><b>Comentarios: <?php echo $comentario;?> </b></div>
			
				<?php
			}
		
		?>
       <h5><b>Folio: </b><?php echo $rowEquipos["Folio"]; ?></h5>
	   <h5><b>Punto de Venta: </b><?php echo $rowEquipos["PuntoVenta"]; ?></h5>
	   <h5><b>Solicitante: </b><?php echo $rowEquipos["Usuario"]; ?></h5>
	   <h5><b>N&uacute;mero de Semana: </b><?php echo $rowEquipos["Semana"]; ?></h5>
  <div align="right">
	   <?php
			if($rowEquipos["Estatus"]=="Finalizado"){
				?>
				<button class="btn btn-primary" disabled><span class="glyphicon glyphicon-flag"></span> Finalizar Pedido</button>
				<?php
			}else{
				?>
				<a href="finOrdenPedidoA.php?id=<?php echo $ordenPedidoId;?>"><button class="btn btn-primary"><span class="glyphicon glyphicon-flag"></span> Finalizar Pedido</button></a>
				<?php
			}
			
			?>
	   
	 
	   </div>
   <div class="row">
	
		</div>
		<div id="resultadoBusqueda" align="center">
			
		</div>
   </div>
 	<a name="analisis2"></a>
 	
 	<?php 
	$query="SELECT OP.OrdenPedidoId AS OrdenPedidoId, OP.Semana AS Semana, PV.PuntoVenta AS PuntoVenta, CONCAT(E.Nombre, ' ' , E.Paterno, ' ', E.Materno) AS Usuario, OP.Estatus AS Estatus, OP.Fecha AS Fecha, OP.Plataforma AS Plataforma, OP.Equipos AS Equipos FROM OrdenPedido AS OP INNER JOIN PuntosVenta AS PV ON PV.PuntoVentaId=OP.PuntoVentaId INNER JOIN Usuarios AS U ON U.UsuarioId=OP.UsuarioId INNER JOIN Empleados AS E ON U.EmpleadoId=E.EmpleadoId WHERE OP.OrdenPedidoId=$ordenPedidoId";
	if($res=mysql_query($query)){
		$rowEquipos=mysql_fetch_array($res);
	}else{
		echo "error al consultar:".$query.mysql_error();
	}
	
	
	
?>
  
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

  
    
	   

   <div class="row">
	<div class="col-md-6">
	<form id="formularioAjusteEquipos" method="post">
		
		<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId; ?>">
		<div id="resultadoBusqueda2" align="center">
			
		</div>
		<div align="center">
			<button id="ajusteEquipos" class="btn btn-primary"><span class="glyphicon glyphicon-hand-right"></span>  Procesar</button>
				<input type="button" class="btn btn-danger" onClick="location.href='analisisPedido.php?id=<?php echo $ordenPedidoId; ?>'" value=" x Cancelar">
			
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