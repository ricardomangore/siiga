<?php
	include("php/conexion.php");
	include("php/sesion.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
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
   <ol class="breadcrumb">
  <li><a href="#"><span class="circulo">1</span> Selecciona Marcas</a></li>
  <li class="active"><span class="circulo">2</span> Selecciona Equipos</li>
</ol>
   
   
   
   
   
   <div id="respuestaCargarEquipos" align="center"></div>
   <form id="formularioCargarEquipos" method="post">
   <div align="center">
   	   <table class="table table-hover" style="width: 80%">
   <tr>
   	<td>Id del Producto</td>
   	<td>Descripcion</td>
   	<td>Precio sin Iva</td>
   	<td>Cantidad</td>
   </tr>
   	<?php
		$pagina= new PHPPaging;
		 $pagina->agregarConsulta("SELECT * FROM Marcas WHERE Activo=1 ORDER BY Marca");
		 $pagina->ejecutar();
		 while($res=$pagina->fetchResultado()){
			 echo $res["Marca"]."<br>";
		 }
		    echo 'Paginas'.$pagina->fetchNavegacion();
		$queryMarcas="SELECT * FROM Marcas WHERE Activo=1 ORDER BY Marca";   	
	   	if($resMarcas=mysql_query($queryMarcas)){
			while($rowMarcas=mysql_fetch_array($resMarcas)){
				$marcaId=$rowMarcas["MarcaId"];
				?>
				<tr align="center">
					<td colspan="4" style="background:#000000; color: white"><b><?php echo($rowMarcas["Marca"]);?></b></td>
				</tr>
				<?php
				$queryEquipos="SELECT EquipoId, Equipo FROM Equipos WHERE MarcaId=$marcaId AND Activo=1 ORDER BY Equipo";
				if($resEquipos=mysql_query($queryEquipos)){
					while($rowEquipos=mysql_fetch_array($resEquipos)){
						$equipoId=$rowEquipos["EquipoId"];
						$equipo=$rowEquipos["Equipo"];
						$costo=0;
						?>
						<tr>
							<td><?php echo $equipoId; ?></td>
							<td><?php echo $equipo; ?></td>
							<?php
								$queryCosto="SELECT Costo FROM OrdenesCompra WHERE EquipoId=$equipoId AND Costo>0";
								if($resCosto=mysql_query($queryCosto)){
									$rowCosto=mysql_fetch_array($resCosto);
									$costo=$rowCosto["Costo"];
									$costo=number_format(($costo),2,'.',',');
								}
							?>
							<td>$ <?php echo $costo; ?> MXN</td>
							<td align="center"><input type="number" style="width: 60px;" value="0"></td>
							
						</tr>
						<?php
					}
					
				}
				
			}
		}
	   
	 ?>
   </table>
   </div>
<div align="center">
	<button class="btn btn-info"><span class="glyphicon glyphicon-shopping-cart"></span> A&ntilde;adir al Carrito</button>
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