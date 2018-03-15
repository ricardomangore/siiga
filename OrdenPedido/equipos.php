<?php
	include("php/conexion.php");
	include("php/sesion.php");
	$usuario=$_SESSION["usuario"];
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
	if($cont==0){
		?>
		<script>
alert('Al menos selecciona una marca para poder continuar');
window.location.href='marcas.php';
</script>
	<?php
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
   <div id="respuestaCargarEquipos" align="center"></div>
   <form id="formularioCargarEquipos" method="post">
   <h4><span class="circulo">2</span> <b>Coloca la cantidad de equipos por modelo</b></h4>
   <label><h4>Selecciona la plataforma del pedido: </h4></label>
   <select style="width: 183px; height: 30px; font-size: 1em; margin-left: 10px;" name="plataforma">
   	<option>--Selecciona Plataforma--</option>
   	<?php
	   $resPlataforma=mysql_query("SELECT * FROM Plataformas WHERE Activo=1");
	   while($rowPlataforma=mysql_fetch_array($resPlataforma)){
		   echo "<option>".$rowPlataforma["Plataforma"]."</option>";
	   }
	   ?>
   </select>
   		
   	<div class="row">

   			<?php
				for($i=0;$i<$cont;$i++)	{
				
					?>
					<div class="col-md-3">
					
					 	
					 
					  
  	<?php
									$resMarcas=mysql_query("SELECT * FROM Marcas WHERE MarcaId=$marcas[$i]");
									$row=mysql_fetch_array($resMarcas);
									echo "<h4><b>".$row["Marca"]."</b></h4>";
									?>
  	 <div style="max-width: 100%; min-height: 200px; max-height: 200px; overflow-y: scroll; border-top-style: double; border-left-style: double; border-bottom-style: double; border-right-style: double;">
						<table class="table table-hover">
						
							
								<?php
									$resEquipos=mysql_query("SELECT EquipoId, Equipo FROM Equipos WHERE MarcaId=$marcas[$i] AND Activo=1 ORDER BY Equipo");
									$aux=0;
									while($rowEquipos=mysql_fetch_array($resEquipos)){
										$aux++;
									//	$cont++;
										$equipoId=$rowEquipos["EquipoId"];
										$queryEquipos=mysql_query("SELECT EquipoId FROM Inventario WHERE EquipoId=$equipoId AND Cantidad=1");
										if(($total=mysql_num_rows($queryEquipos))>1){
											echo "<tr>";
										echo "<td class='$clase'>".$rowEquipos["Equipo"]."</td>";
										echo "<td><input type='number' value='0' name='$equipoId' style='width:40px;height:30px'></td>";
										echo "</tr>";
										}
										
										
										
									}
									if($aux==1){
										echo "No existen Equipos Disponibles";
									}
								?>
								
							
							
						</table>
						</div>
						
					</div>
					<?php
				}
			
				?>
   			
   	</div>
   	<div align="center">
   	<br>
   		<button class="btn btn-primary" id="cargarEquipos"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
   		<button class="btn btn-danger" type="reset" onClick="window.location.replace('ordenPedido.php')"><span  class="glyphicon glyphicon-remove"></span> Cancelar</button>
   	</div>
   	</form>
   </div>
 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="http://code.jquery.com/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>