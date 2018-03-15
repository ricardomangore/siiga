<?php
	include("php/conexion.php");
	include("php/sesion.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
	$usuario=$_SESSION["usuario"];
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selecci&oacute;n de Equipos</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilos.css" rel="stylesheet" media="screen">
    <link href="css/menu.css" rel="stylesheet" media="screen">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
   <script>
	   $(document).ready(function() {
    			$.ajax({
    				url: "php/todosEquiposPag.php",
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
    <a class="navbar-brand" href="ordenPedido.php">Orden de Pedido</a>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="php/salir.php">
          <font color="ffffff"><?php echo $usuario;?> <span class="glyphicon glyphicon-off"></span></font>
        </a>
       
      </li>
    </ul>
  </div>
</nav>
  
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
   <ol class="breadcrumb">
  <li class="active"><span class="circulo">1</span> Selecciona Equipos</li>
  
</ol>
   <div class="row">
   		<div class="col-md-2"><br><br>
   			<table class="table table-hover">
   				<tr>
   					<td style="background: #0574AC; color: white;" colspan="2">Filtrar por Marca</td>
   				</tr>
				<tr>
					<td>
						<?php
				if($res=mysql_query("SELECT MarcaId, Marca FROM Marcas WHERE Activo=1 ORDER BY Marca")){
					while($rowMarca=mysql_fetch_array($res)){
						?>
						
							<input type="checkbox" value="<?php echo $rowMarcas["MarcaId"]?>">
							<?php echo $rowMarca["Marca"]?><br>
					
						 
						<?php
					}
				}
			
			?>
					</td>
				</tr>   			
   		
   			
			</table>
  		<div align="center">
  			<button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
  			<button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
  		</div>
   		</div>
		<div class="col-md-10">
		<div id="respuestaCargarEquipos" align="center"></div>	
			
		</div>   	
		<div id="resultadoBusqueda" align="center"></div>	
			
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