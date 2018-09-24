<!DOCTYPE html>
<?php
	include("php/conexion.php");
	include("php/complementos.php");
	include("php/sesion.php");
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

		
		function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarPunto.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusquedaPunto").html(mensaje);
         }); 
     }
};	
		
		

$(function(){
	$("#filtro").click(function(){
 	var url = "php/filtradorPuntos.php"; // El script a dónde se realizará la petición.
    $.ajax({
           type: "POST",
           url: url,
           data: $("#formularioFiltrador").serialize(), // Adjuntar los campos del formulario enviado.
           success: function(data)
           {
               $("#resultadoBusqueda").html(data); // Mostrar la respuestas del script PHP.
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
  <div class="modal fade" id="buscar" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #0574AC; color: #FFFFFF">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div align="center"><h4 class="modal-title"><span class="glyphicon glyphicon-home"></span> Buscador de Punto</h4></div>
        </div>
        <div class="modal-body">
         <form action="php/cargar.php" method="post">
        	<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId;?>">
         	<span class="glyphicon glyphicon-search"></span> Buscar: <input class="login" type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscar();" />
         	<div id="resultadoBusquedaPunto"></div>
         
        </div>
        <div class="modal-footer">
        
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>
  <!--Fin del Modal-->
   
   
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
                        <h1 class="page-header">
                            Puntos de Venta <small>Activos</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                               <a href="activoFijo.php"> <i class="fa fa-dashboard"></i> Inicio</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-home"></i> Puntos de Venta
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                
                <!-- /.row -->

                <div class="row">
                  <div class="col-md-6">
              	<form id="formularioFiltrador">
                  	<label>Filtrar por: </label>
					<select name="filtro">
						<option>--Seleccionar Filtro--</option>
						<option>Contrato</option>
						<option>Punto de Venta</option>
						<option>Region</option>
						<option>Tipo</option>
					</select>
					<button id="filtro" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-ok-circle"></span> Aceptar</button>
					<button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                  </form>
		
		
	</div>
	<div class="col-md-6">
		<div align="right">
			<button class="btn btn-primary" class="btn btn-info btn-lg" data-toggle="modal" data-target="#buscar"><span class="glyphicon glyphicon-search"></span> Buscar Punto</button>
		</div>
	</div>
                  
				</div><br>
                 <div class="row">          
                  
                  
                  
                  
                  
                  
                   <div id="resultadoBusqueda" align="center">
                
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
