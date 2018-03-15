<?php 
	include("php/conexion.php");
	include("php/sesion.php");
	$usuario=$_SESSION["usuario"];
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
          <font color="ffffff"><?php echo $usuario;?><span class="glyphicon glyphicon-off"></span></font>
        </a>
       
      </li>
    </ul>
  </div>
</nav>
  
  <!--fin de Menu-->
   <div class="well">
	<h4><span class="circulo">1</span><b> Selecciona una o m&aacute;s marcas</b></h4>
   	<div class="row">
   
   		<div class="col-md-6">
   		<form action="equipos.php" method="post">
   		<table class="table table-hover">
   		<tr style=" background: #00A0DE; color: #FFFFFF;">
   			<td><b>ID</b></td>
   			<td><b>Marca</b></td>
   			<td align="center"><b>Selecciona</b></td>
   		</tr>
   		<?php
		$i=0;
			$query="SELECT * FROM Marcas WHERE Activo=1 ORDER BY Marca";
			if($res=mysql_query($query)){
				while($row=mysql_fetch_array($res)){
					$i++;
					if($i%2==0){
						$clase="info";
					}else{
						$clase="primary";
					}
				?>
				<tr class="<?php echo $clase;?>">
					<td><?php echo $i;?></td>
					<td><?php echo $row['Marca'];?></td>
					<td align="center"><input type="checkbox" name="<?php echo($row['Marca']);?>" value="<?php echo $row['MarcaId'];?>"></td>
				</tr>
				<?php	
				}
			}else{
				echo "Error al consultar".$query.mysql_error();
			}
		?>
  		</table>
   		</div>
   		<div class="col-md-6">
   		<div align="center">
   			<img src="img/seleccionar.png" width="50%">
   		</div>
   		<br><br>
   		<div align="center">
   			<button class="btn btn-info">Siguiente <span class="glyphicon glyphicon-arrow-right"></span></button>
   			</form>
   			<a href="ordenPedido.php"><button class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancelar</button></a>
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