<!DOCTYPE html>
<?php
	include("php/conexion.php");
	include("php/complementos.php");
	include("php/sesion.php");
	$puntoId=$_GET["id"];
	$queryPunto="SELECT * FROM PuntosVenta WHERE PuntoVentaId=$puntoId";
	if($res=mysql_query($queryPunto)){
		$rowPuntos=mysql_fetch_array($res);
		$puntVenta=$rowPuntos["PuntoVenta"];
	}
?>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventario Activo Fijo</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script>
				$(document).ready(function() {
    			$.ajax({
    				url: "php/todosPuntos.php",
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
        $.post("php/buscarPunto.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     } else {
	 
	 //funcion para mostrar todos los datos de la tabla
       $.ajax({
    url: "php/todosPuntos.php",
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

	</script>
</head>

<body>
<!--Modal -->
    <!-- Modal -->
  <div class="modal fade" id="gastos" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
        	<h4><b>Agregar nuevo Gasto</b></h4>
                  <form action="php/agregarGastoFijo.php" method="post">
                  <input type="hidden" value="<?php echo $puntoId;?>" name="puntoId">
                  	<table class="table table-striped">
                  		<tr>
                  			<td align="right"><label>Categoria:</label> </td>
                  			<td>
                  			<select class="form-control" name="categoria">
                  				
                  				
                  				<?php 
									$queryCategoria="SELECT * FROM CategoriaGastoFijo WHERE Activo=1 ORDER BY Categoria";
						
									if($resCategoria=mysql_query($queryCategoria)){
										
										while($rowCategoria=mysql_fetch_array($resCategoria)){
											$option=$rowCategoria["Categoria"];
											echo "<option>".$option."</option>";
										}
									}else{
										echo "error: ".$queryCategoria.mysql_error();
									}
								?>
                  			</select>
                  			</td>
                  		</tr>
                  		<tr>
                  			<td align="right"><b>Descripci&oacute;n: </b></td>
                  			<td><textarea class="form-control" rows="5" name="descripcion"> </textarea></td>
                  		</tr>
                  		<tr>
                  			<td align="right"><b>Costo: </b> $</td>
                  			<td><input class="form-control" type="number" step="any" name="costo" value="0"></td>
                  		</tr>
                  	</table>
                  
        
        
        
        
        </div>
        <div class="modal-footer">
         	<div align="center">
                  		<button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Agregar</button>
                  		<button class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  	</div>
			</form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del Modal -->
   
   
   
   
   
   
   
   
   
   
   
   
   
   
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html"><b>Activo Fijo</b> </a>
            </div>
           
           <?php
			menuHeader();
			menu();
			
			?>
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header">
                            Punto de Venta: <?php echo $puntVenta;?>
                        </h3>
                        <ol class="breadcrumb">
                            <li>
                               <a href="activoFijo.php"> <i class="fa fa-dashboard"></i> Inicio</a>
                            </li>
                            <li>
                               <a href="puntosVenta.php"> <i class="fa fa-home"></i> Puntos de Venta</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-inbox"></i> Inventario
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                
                <!-- /.row -->

               
                 <div class="row">          
                  <ul class="nav nav-tabs">
  <li class="active"><a href="gastosPuntoVenta.php?id=<?php echo $puntoId;?>">Gastos Fijos</a></li>
  <li><a href="mobiliarioPuntoVenta.php?id=<?php echo $puntoId;?>">Mobiliario</a></li>
  <li><a href="contratoPuntoVenta.php?id=<?php echo $puntoId;?>">Contratos</a></li>
  <li><a href="usuarios.php?id=<?php echo $puntoId;?>">Usuarios</a></li>
</ul>	<br><br>
                 <div class="col-md-8">
                 <h4><b>Gastos Registrados</b></h4>
                 	<table class="table table-striped">
                 	<tr>
                 		<td><b>Concepto</b></td>
                 		<td align="center"><b>Detalles</b></td>
                 		<td><b>Costo</b></td>
                 		<td align="center"><b>Operaciones</b></td>
                 	</tr>
                 	<form action="php/quitarGasto.php" method="post">
                 	<?php
						$gastoFin=0;
						$queryGastos="SELECT CG.Categoria AS Categoria, GF.Descripcion AS Descripcion, GF.Costo AS Costo, GF.GastoFijoId AS GastoFijoId FROM GastoFijo AS GF INNER JOIN CategoriaGastoFijo AS CG ON GF.CategoriaGastoFijoId=CG.CategoriaGastoFijoId WHERE GF.Activo=1 AND CG.Activo=1 AND PuntoVentaId=$puntoId ORDER BY CG.Categoria";
						if($resGasto=mysql_query($queryGastos)){
							if(mysql_num_rows($resGasto)==0){
								echo "<div align='center'><h3><b>No hay registros</b></h3></div>";
							}else{
								while($rowGastos=mysql_fetch_array($resGasto)){
									?>
									<tr>
										<td><?php echo $rowGastos["Categoria"]; ?> </td>
										<td><?php echo $rowGastos["Descripcion"]; ?></td>
										<td align="right"> $ <?php echo number_format(($rowGastos["Costo"]),2,'.',','); ?></td>
										<td align="center"><button class="btn btn-danger btn-xs" name="<?php echo $rowGastos['GastoFijoId']; ?>"><span class="glyphicon glyphicon-remove"></span> Quitar</button></td>
									</tr>
								<?php
								$gastoFin=$gastoFin+$rowGastos["Costo"];
									
							}
								?>
								<tr>
									<td></td>
									<td></td>
									<td align="right"><b>Total: <?php echo "$ ".number_format(($gastoFin),2,'.',',');?></b></td>
								</tr>
								
								
								
								
								<?php
							}
							
						}else{
							echo "Error: ".$queryGastos.mysql_error();
						}
						
						?>
						</form>
					 </table>
			     </div>
                  <div class="col-md-4">
                  
                  <br><br>
                  <div align="center">
					  <img src="img/calcudora.png" width="40%"><br><br>
                  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#gastos"><span class="glyphicon glyphicon-plus"></span> Agregar Gastos</button>
                  </div>
                  
			     </div>
                  
                  
                  
                  
                  
                 
                
                </div>
                   <br><br><br><br>
		</div>
                <!-- /.row -->

               
                <!-- /.row -->

                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
