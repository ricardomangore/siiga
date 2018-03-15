<?php
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
	$ordenPedido=0;
	$usuario=$_SESSION["usuario"];
	$puestoId=$_SESSION["puestoId"];
	$usuarioId=$_SESSION["usuarioId"];
	$puntoVentaId=PuntoVenta($usuarioId);
	$ordenPedido=ordenPedido($usuarioId,$puntoVentaId);
		$numeroSemana = date("W"); 
	$semanaFin=$numeroSemana-1;
	$querySemana="SELECT Semana FROM OrdenPedido WHERE Semana=$semanaFin AND PuntoVentaId=$puntoVentaId AND Finalizado=0";
	/*if($resSemana=mysql_query($querySemana)){
		if(mysql_num_rows($resSemana)){
			echo "
				<script>
alert('No se ha Finalizado la orden anterior, para continuar finaliza la orden de Pedido de la semana ".$semanaFin."');
window.location.href='ordenPedido.php';
</script>
			
			";
		}
	}*/
	
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrito de Compras</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script>
	   	 $(document).ready(function() {
    $.ajax({
    url: "php/analisisCarrito.php?id=+<?php echo $ordenPedido;?>",
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
   <li class="active"><span class="circulo">2</span> Revisi&oacute;n de Pedido</li>
	   
  
</ol>
  <div class="row">

  	<div class="col-md-10">
  	<form action="php/reCargar.php" method="post" enctype="multipart/form-data">
  	<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedido;?>">
  	<label> Plataforma:</label>
  	<select name="plataforma">
  	<option>--Seleccionar Plataforma--</option>
  	<option>AVS Azul</option>
  	<?php
		$plataforma="";
		$query="SELECT ClasificacionPersonalVenta FROM PuntosVenta WHERE PuntoVentaId=$puntoVentaId";
		if($res=mysql_query($query)){
			$row=mysql_fetch_array($res);
			
			if($row["ClasificacionPersonalVenta"]==1 || $row["ClasificacionPersonalVenta"]==5){
				echo "<option>PVS Rojo</option>";
			}elseif($row["ClasificacionPersonalVenta"]==7){
				echo "<option>PVS Rojo</option>";
			}
		}
		
		?>
  	
  	</select><br>
  	
  		<div align="center">
  			<div id="resultadoBusqueda"></div>
  			<?php
				if($ordenPedido==0){
					echo "<h1>Aun no existen equipos en El carrito</h1>";
				}else{
						if(equiposPedido($ordenPedido)==0){
					?>
					<button class="btn btn-info btn-sm" name="recalcular"><span class="glyphicon glyphicon-refresh"></span> Recalcular</button>
  			<button class="btn btn-primary btn-sm" name="finalizar"><span class="glyphicon glyphicon-arrow-right"></span> Finalizar</button>
  			<button class="btn btn-danger btn-sm" type="reset"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
					<?php
				}
				}
			
			
			?>
  			
  		</div>
	</form>
  	</div>
  	<div class="col-md-2">
  		<div align="center">
  		<br><br><br><br><br><br>
  			<img src="img/carrito.png" width="80%">
  			
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