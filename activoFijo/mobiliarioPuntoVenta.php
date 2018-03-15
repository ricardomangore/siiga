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
//select de categoria	
function fetch_select(val)
{
 $.ajax({
 type: 'post',
 url: 'php/selectCategoria.php',
 data: {
  get_option:val
 },
 success: function (response) {
  document.getElementById("new_select").innerHTML=response; 
 }
 });
}
	</script>
</head>

<body>
<!--Modal para agregar Elementos de Seguridad-->
   <!-- Modal -->
  <div class="modal fade" id="seguridad" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #000000; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Agregar Elementos de Seguridad</h4>
        </div>
        <div class="modal-body">
        <form action="php/subirClasificacion.php" method="post">
        <table class="table table-striped">
        	<tr>
        		<td align="right"><b>Elemento de seguridad: </b></td>
        		<td>
        			         <select class="form-control" name="clasificacion">
         <option>--Selecciona Elemento de Seguridad--</option>
         	<?php
				$querySeguridad="SELECT * FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=5 AND Activo=1 ORDER BY ClasificacionActivoFijo";
				if($resSeguridad=mysql_query($querySeguridad)){
					while($rowSeguridad=mysql_fetch_array($resSeguridad)){
						?>
						<option value="<?php echo $rowSeguridad['ClasificacionActivoFijoId'];?>"><?php echo $rowSeguridad['ClasificacionActivoFijo'];?></option>
						<?php
						
					}
				}
			
			?>
         </select>
        			
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Fecha: </b></td>
        		<td><input type="date" name="fecha" required></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Cantidad: </b></td>
        		<td><input class="form-control" type="number" name="cantidad" value="0"></td>
        	</tr>
        	<tr>
        		<td align="right">
        			<b>Descripci&oacute;n:</b>
        		</td>
        		<td>
        			<textarea class="form-control" rows="5" required name="comentarios"></textarea>
        		</td>
        	</tr>
        	<tr>
        	<td align="right"><b>Propiedad AT&T :</b></td>
        		<td> <input type="checkbox" name="propiedad" ></td>
        	</tr>
        </table>
         <input type="hidden" name="puntoId" value="<?php echo $puntoId; ?>">
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del modal para elementos de seguridad-->

  
  <!--Modal para agregar Elementos de Computo-->
   <!-- Modal -->
  <div class="modal fade" id="computo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #000000; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Agregar Elementos de Computaci&oacute;n</h4>
        </div>
        <div class="modal-body">
        <form action="php/subirComputacion.php" method="post">
        <table class="table table-striped">
        	<tr>
        		<td align="right"><b>Elemento de seguridad: </b></td>
        		<td>
        			         <select class="form-control" name="clasificacion">
         <option>--Selecciona Elemento de Computo--</option>
         	<?php
				$queryComputo="SELECT * FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=3 AND Activo=1 ORDER BY ClasificacionActivoFijo";
				if($resComputo=mysql_query($queryComputo)){
					while($rowComputo=mysql_fetch_array($resComputo)){
						?>
						<option value="<?php echo $rowComputo['ClasificacionActivoFijoId'];?>"><?php echo $rowComputo['ClasificacionActivoFijo'];?></option>
						<?php
						
					}
				}
			
			?>
         </select>
        			
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Fecha: </b></td>
        		<td><input type="date" name="fecha" required></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Marca: </b></td>
        		<td><select class="form-control" name="marca">
        		<option value="0">--Seleccionar Marca--</option>
        			<?php
						$queryMarcas="SELECT MarcaId, Marca FROM Marcas WHERE Activo=1 ORDER BY Marca";
						if($resMarca=mysql_query($queryMarcas)){
						
							while($rowMarca=mysql_fetch_array($resMarca)){
								?>
								<option value="<?php echo $rowMarca['MarcaId'];?>"><?php echo $rowMarca["Marca"];?></option>
								<?php
							}
						}
					?>
       		</select>
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Modelo</b></td>
        		<td><input type="text" name="modelo" class="form-control"></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Serie: </b></td>
        		<td><input type="text" name="serie" class="form-control"></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Cantidad: </b></td>
        		<td><input class="form-control" type="number" name="cantidad" value="0"></td>
        	</tr>
        	<tr>
        		<td align="right">
        			<b></b>
        		</td>
        		<td>
        			<textarea class="form-control" rows="5" required name="comentarios"></textarea>
        		</td>
        	</tr>
        	<tr>
        	<td align="right"><b>Propiedad AT&T :</b></td>
        		<td> <input type="checkbox" name="propiedad" ></td>
        	</tr>
        </table>
        
         <input type="hidden" name="puntoId" value="<?php echo $puntoId; ?>" >
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del modal para elementos de Computo-->
  
  
  <!--Modal para agregar Elementos de Adicional-->
   <!-- Modal -->
  <div class="modal fade" id="adicional" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #000000; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Agregar Mobiliario Adicional</h4>
        </div>
        <div class="modal-body">
        <form action="php/subirAdicional.php" method="post">
        <table class="table table-striped">
        	<tr>
        		<td align="right"><b>Mobiliario Adicional: </b></td>
        		<td>
        			         <select class="form-control" name="clasificacion">
         <option>--Seleccionar Mobiliario Adicional--</option>
         	<?php
				$querySeguridad="SELECT * FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=2 AND Activo=1 ORDER BY ClasificacionActivoFijo";
				if($resSeguridad=mysql_query($querySeguridad)){
					while($rowSeguridad=mysql_fetch_array($resSeguridad)){
						?>
						<option value="<?php echo $rowSeguridad['ClasificacionActivoFijoId'];?>"><?php echo $rowSeguridad['ClasificacionActivoFijo'];?></option>
						<?php
						
					}
				}
			
			?>
         </select>
        			
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Fecha: </b></td>
        		<td><input type="date" name="fecha" required></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Cantidad: </b></td>
        		<td><input class="form-control" type="number" name="cantidad" value="0"></td>
        	</tr>
        	<tr>
        		<td align="right">
        			<b>Descripci&oacute;n:</b>
        		</td>
        		<td>
        			<textarea class="form-control" rows="5" required name="comentarios"></textarea>
        		</td>
        	</tr>
        	<tr>
        	<td align="right"><b>Propiedad AT&T :</b></td>
        		<td> <input type="checkbox" name="propiedad" ></td>
        	</tr>
        </table>
         <input type="hidden" name="puntoId" value="<?php echo $puntoId; ?>">
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del modal para elementos de Adicional-->

  <!--Modal para agregar Elementos de Exhibicion-->
   <!-- Modal -->
  <div class="modal fade" id="exhibicion" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #000000; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Agregar Mobiliario Exhibicion</h4>
        </div>
        <div class="modal-body">
        <form action="php/subirAdicional.php" method="post">
        <table class="table table-striped">
        	<tr>
        		<td align="right"><b>Mobiliario Exhibicion: </b></td>
        		<td>
        			         <select class="form-control" name="clasificacion">
         <option>--Selecciona Mobiliario de Exhibicion--</option>
         	<?php
				$querySeguridad="SELECT * FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=1 AND Activo=1 ORDER BY ClasificacionActivoFijo";
				if($resSeguridad=mysql_query($querySeguridad)){
					while($rowSeguridad=mysql_fetch_array($resSeguridad)){
						?>
						<option value="<?php echo $rowSeguridad['ClasificacionActivoFijoId'];?>"><?php echo $rowSeguridad['ClasificacionActivoFijo'];?></option>
						<?php
						
					}
				}
			
			?>
         </select>
        			
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Fecha: </b></td>
        		<td><input type="date" name="fecha" required></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Cantidad: </b></td>
        		<td><input class="form-control" type="number" name="cantidad" value="0"></td>
        	</tr>
        	<tr>
        		<td align="right">
        			<b>Descripci&oacute;n:</b>
        		</td>
        		<td>
        			<textarea class="form-control" rows="5" required name="comentarios"></textarea>
        		</td>
        	</tr>
        	<tr>
        	<td align="right"><b>Propiedad AT&T :</b></td>
        		<td> <input type="checkbox" name="propiedad" ></td>
        	</tr>
        </table>
         <input type="hidden" name="puntoId" value="<?php echo $puntoId; ?>">
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del modal para elementos de Exhibicion-->
  
  <!--Modal para agregar Elementos de Posicion-->
   <!-- Modal -->
  <div class="modal fade" id="posicion" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #000000; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><span class="glyphicon glyphicon-plus"></span> Agregar Mobiliario por Posicion</h4>
        </div>
        <div class="modal-body">
        <form action="php/subirAdicional.php" method="post">
        <table class="table table-striped">
        	<tr>
        		<td align="right"><b>Mobiliario Posicion: </b></td>
        		<td>
        			         <select class="form-control" name="clasificacion">
         <option>--Selecciona Mobiliario de Exhibicion--</option>
         	<?php
				$querySeguridad="SELECT * FROM ClasificacionActivoFijo WHERE CategoriaActivoFijoId=4 AND Activo=1 ORDER BY ClasificacionActivoFijo";
				if($resSeguridad=mysql_query($querySeguridad)){
					while($rowSeguridad=mysql_fetch_array($resSeguridad)){
						?>
						<option value="<?php echo $rowSeguridad['ClasificacionActivoFijoId'];?>"><?php echo $rowSeguridad['ClasificacionActivoFijo'];?></option>
						<?php
						
					}
				}
			
			?>
         </select>
        			
        		</td>
        	</tr>
        	<tr>
        		<td align="right"><b>Fecha: </b></td>
        		<td><input type="date" name="fecha" required></td>
        	</tr>
        	<tr>
        		<td align="right"><b>Cantidad: </b></td>
        		<td><input class="form-control" type="number" name="cantidad" value="0"></td>
        	</tr>
        	<tr>
        		<td align="right">
        			<b>Descripci&oacute;n:</b>
        		</td>
        		<td>
        			<textarea class="form-control" rows="5" required name="comentarios"></textarea>
        		</td>
        	</tr>
        	<tr>
        	<td align="right"><b>Propiedad AT&T :</b></td>
        		<td> <input type="checkbox" name="propiedad" ></td>
        	</tr>
        </table>
         <input type="hidden" name="puntoId" value="<?php echo $puntoId; ?>">
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
           </form>
        </div>
      </div>
      
    </div>
  </div>
  
<!--Fin del modal para elementos  por Posicion-->
   
   
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
                <a class="navbar-brand" href="puntosVenta.php"><b>Activo Fijo</b> </a>
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
  <li><a href="gastosPuntoVenta.php?id=<?php echo $puntoId;?>">Gastos Fijos</a></li>
  <li class="active"><a href="mobiliarioPuntoVenta.php?id=<?php echo $puntoId;?>">Mobiliario</a></li>
  <li><a href="contratoPuntoVenta.php?id=<?php echo $puntoId;?>">Contratos</a></li>
  <li><a href="usuarios.php?id=<?php echo $puntoId;?>">Usuarios</a></li>
</ul>	<br><br>
                 <div class="col-md-8">
                 <h4><b>Mobiliario Registrado</b></h4>
                 	<table class="table table-striped">
                 	<tr>
                 		<td><b>Categoria</b></td>
                 		<td><b>Clasificaci&oacute;n</b></td>
                 		<td><b>Descripci&oacute;n</b></td>
                 		<td><b>Cantidad</b></td>
                 		<td><b>Propietario</b></td>
                 	</tr>
                 		<?php 
							$queryMobiliario="SELECT CA.Categoria AS Categoria, CL.ClasificacionActivoFijo AS ClasificacionActivoFijo, AF.Cantidad AS Cantidad, AF.Descrpcion AS Descripcion, AF.MarcaId AS MarcaId, AF.Modelo AS Modelo, AF.Serie AS Serie, M.Marca AS Marca, AF.Propiedad AS Propiedad FROM CategoriaActivoFijo AS CA INNER JOIN ClasificacionActivoFijo AS CL ON CA.CategoriaActivoFijoId=CL.CategoriaActivoFijoId INNER JOIN ActivoFijo AS AF ON AF.ClasificacionActivoFijoId=CL.ClasificacionActivoFijoId INNER JOIN HistorialActivoFijo AS HA ON HA.ActivoFijoId=AF.ActivoFijoId INNER JOIN Marcas AS M ON M.MarcaId=AF.MarcaId WHERE HA.PuntoVentaId=$puntoId ORDER BY CA.Categoria, CL.ClasificacionActivoFijo";
							if($resMobiliario=mysql_query($queryMobiliario)){
								while($rowMobiliario=mysql_fetch_array($resMobiliario)){
									?>
									<tr>
										<td><?php echo $rowMobiliario["Categoria"]; ?></td>
										<td><?php echo $rowMobiliario["ClasificacionActivoFijo"]; ?></td>
										<td><?php echo $rowMobiliario["Descripcion"]; ?>
										<?php
											if(($rowMobiliario["MarcaId"])!=1){
												echo "<b><br>Marca: </b>".$rowMobiliario["Marca"]."<br>";
												echo "<b>Modelo: </b>".$rowMobiliario["Modelo"]."<br>";
												echo "<b>Serie: </b>".$rowMobiliario["Serie"]."<br>";
												
											}
										?>
										</td>
										<td><?php echo $rowMobiliario["Cantidad"];?></td>
										<td><?php echo $rowMobiliario["Propiedad"];?></td>
									</tr>
									<?php
								}
							}else{
								echo "Error al consultar: ".$queryMobiliario.mysql_error();
							}
						?>
                 	</table>
                 	<div align="center">
                 		<button class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Editar</button>
                 		<button class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
					</div>
                 	
			     </div>
                  <div class="col-md-4">
                  <h4><b>Agregar Mobiliario</b></h4>
              	  <div align="center">
              	  <table class="table table-striped">
              	  <tr>
              	  		<td align="center"><button class="btn btn-primary" data-toggle="modal" data-target="#seguridad"><span class="glyphicon glyphicon-plus"></span> Elementos de Seguridad</button></td>
              	  	</tr>
              	  	<tr>
              	  		<td align="center"><button class="btn btn-primary"  data-toggle="modal" data-target="#computo"><span class="glyphicon glyphicon-plus"></span>&nbsp; &nbsp;Equipos de Computo&nbsp;&nbsp;&nbsp;</button></td>
              	  	</tr>
              	  	<tr>
              	  		<td align="center"><button class="btn btn-primary" data-toggle="modal" data-target="#adicional"><span class="glyphicon glyphicon-plus"></span> &nbsp;&nbsp;Mobilidiario Adicional&nbsp;&nbsp;</button></td>
              	  	</tr>
              	  	<tr>
              	  		<td align="center"><button class="btn btn-primary"  data-toggle="modal" data-target="#exhibicion"><span class="glyphicon glyphicon-plus"></span> Mobiliario de Exhibicion</button></td>
              	  	</tr>
              	  	<tr>
              	  		<td align="center"><button class="btn btn-primary" data-toggle="modal" data-target="#posicion"><span class="glyphicon glyphicon-plus"></span> Mobiliario por Posici&oacute;n</button></td>
              	  	</tr>
              	  	<tr>
              	  		<td align="center"></td>
              	  	</tr>
              	  </table>
              	  
				  </div>
                 
                  <div align="center">
					  <img src="img/inventario.png" width="30%">
                  </div>
                  
			     </div>
                  
                  
                  
                  
                  
                 
                
                </div>
                   
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
