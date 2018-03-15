<?php
	include("php/conexion.php");
	include("php/sesion.php");
	include("php/operaciones.php");
	require_once("PHPPaging.lib/PHPPaging.lib.php");
	$usuario=$_SESSION["usuario"];
	$usuarioId=$_SESSION["usuarioId"];
	$puntoVentaId=PuntoVenta($usuarioId);
	$puestoId=$_SESSION["puestoId"];
	$res="SELECT OrdenPedidoId FROM OrdenPedido WHERE Pendiente=1 AND (UsuarioId='$usuarioId' OR PuntoVentaId='$puntoVentaId')";
	$resultado=mysql_query($res);
	if(mysql_num_rows(mysql_query($res))>0){
		$rowPedido=mysql_fetch_array($resultado);
		$ordenPedidoId=$rowPedido["OrdenPedidoId"];
	}else{
		if(mysql_query("INSERT INTO OrdenPedido(OrdenPedidoId, PuntoVentaId, Plataforma, Equipos, Fecha, Semana, UsuarioId, Estatus, Activo, Pendiente) VALUES (NULL, $puntoVentaId,'Pendiente', 'Pendiente', '2000-01-01',0,$usuarioId,'Pendiente', 0,1 )")){
			$puntoVentaId=mysql_insert_id();
			header("Location: equipos3.php");
		}
	}
	for($i=0;$i<20;$i++){
		$marcas[$i]=0;
	}
	$filtro="";
	$queryMarcas="SELECT * FROM Marcas WHERE Activo=1 ORDER BY Marca";
	if($resMarcas=mysql_query($queryMarcas)){
		$cont=0;
		while($rowMarcasAux=mysql_fetch_array($resMarcas)){
			$marcaAux=$rowMarcasAux["MarcaId"];
			if(isset($_REQUEST[$marcaAux])){
				$marcas[$cont]=$rowMarcasAux["MarcaId"];
				if($cont==0){
					$filtro="M.MarcaId=$marcaAux";
				}else{
					$filtro=$filtro. " OR M.MarcaId=$marcaAux ";
				}
				$cont++;
			}
		}

	}else{
		echo "Error al consultar";
	}
	if(isset($_REQUEST['todos'])){
		header("Location: equipos3.php");
	}
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
	   
	   		  /*Funcion para buscar pendientes*/
function buscar() {
    var textoBusqueda = $("input#busqueda").val();
 
     if (textoBusqueda != "") {
        $.post("php/buscarEquipos.php", {valorBusqueda: textoBusqueda}, function(mensaje) {
            $("#resultadoBusqueda").html(mensaje);
         }); 
     }
};	
   </script>
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  
  <!--inicio de modal-->
  <!-- Modal -->
  <div class="modal fade" id="buscador" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header" style="background: #0574AC; color: #FFFFFF">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div align="center"><h4 class="modal-title"><span class="glyphicon glyphicon-phone"></span> Buscador de Equipos</h4></div>
        </div>
        <div class="modal-body">
         <form action="php/cargar.php" method="post">
        	<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId;?>">
         	<span class="glyphicon glyphicon-search"></span> Buscar: <input class="login" type="text" name="busqueda" id="busqueda" value="" placeholder="" maxlength="30" autocomplete="off" onKeyUp="buscar();" />
         	<div id="resultadoBusqueda"></div>
         
        </div>
        <div class="modal-footer">
         <button class="btn btn-info"><span class="glyphicon glyphicon-shopping-cart"></span> Agregar al Carrito</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
          </form>
        </div>
      </div>
      
    </div>
  </div>
  <!--Fin del Modal-->
  <!--Menu-->
 	<?php
	  	if($puestoId==68 || $puestoId==69 || $puestoId==7 || $puestoId==22){
			$admin=1;
		}else{
			$admin=0;
		}
	  
	  $activo="orden";
	  menu($activo,$ordenPedidoId, $puntoVentaId,$admin);
	  
	  ?>
  <!--fin de Menu-->
   <div class="well" style="background:#FFFFFF">
   <ol class="breadcrumb">
  <li class="active"><span class="circulo">1</span> Selecciona Equipos</li>
  
</ol>
   <div class="row">
   		<div class="col-md-2"><br><br>
			<form action="equiposFiltro.php" method="post">
   			<table class="table table-hover">
   				<tr>
   					<td style="background: #0574AC; color: white;" colspan="2">Filtrar por Marca</td>
   				</tr>
				<tr>
					<td>
						<?php
				if($res=mysql_query("SELECT MarcaId, Marca FROM Marcas WHERE Activo=1 ORDER BY Marca")){
					$aux=0;
					while($rowMarca=mysql_fetch_array($res)){
						if($rowMarca["MarcaId"]==$marcas[$aux]){
							
						?>
						<input type="checkbox" name="<?php echo $rowMarca["MarcaId"]?>" checked>
							<?php echo $rowMarca["Marca"]?><br>
						<?php
							$aux++;
						}else{
						?>
						
							<input type="checkbox" name="<?php echo $rowMarca["MarcaId"]?>">
							<?php echo $rowMarca["Marca"]?><br>
					
						 
						<?php
						}
							
					}
					
				}
			
			?><input type="checkbox" name="todos"> Ver Todos
					</td>
				</tr>   			
   		
   			
			</table>
  		<div align="center">
  			<button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
  			<button class="btn btn-danger btn-xs" type="reset"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
  		</div>
				</form>
   		</div>
		<div class="col-md-10">
			<div id="respuestaCargarEquipos" align="center"></div>	
			<form action="php/cargar.php" method="post">
			<input type="hidden" name="ordenPedido" value="<?php echo $ordenPedidoId;?>">
   <div align="right">
   		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buscador"><span class="glyphicon glyphicon-search"></span> Buscar Equipos</button><br><br>	
   </div>
   <div align="center">
   		<table class="table table-hover" style="width: 90%">
   		<tr style="background: #0574AC; color: white">
   			<td><b>Id Producto</b></td>
   			<td><b>Clave Producto</b></td>
   			<td><b>Descripci&oacute;n Equipos</b></td>
   			<td><b>Precio sin Iva</b></td>
   			<td><b>Cantidad</b></td>
   			
   		</tr>
   			<?php
				$band1=0;
				$band2=0;
				$band3=0;
				$band4=0;
				$band5=0;
				$band6=0;
				$band7=0;
				$band8=0;
				$band9=0;
				$band10=0;
				$band11=0;
				$band12=0;
				$band13=0;
				$band14=0;
				$band15=0;
			
		
		 $resultado=mysql_query("SELECT E.MarcaId AS MarcaId, E.EquipoId AS EquipoId, E.CostoEquipo AS CostoEquipo, E.Equipo AS Equipo, E.NombreConsigna AS NombreConsigna FROM Equipos AS E INNER JOIN Marcas AS M ON E.MarcaId=M.MarcaId WHERE M.Activo=1 AND E.Activo=1 AND E.OrdenPedido=1 AND ($filtro) ORDER BY M.Marca");
		$cont=0;
		 while($row=mysql_fetch_array($resultado)){
			 if($cont%2==1){
				 $clase='class="alert alert-info"';
			 }else{
				  $clase='class="alert alert-primary"';
			 }
			 $cont++;
			 			if($row["MarcaId"]==2 && $band1==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "ALCATEL";?></b></td>
							</tr>
							<?php
							$band1=1;
						}elseif($row["MarcaId"]==3 && $band2==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "APPLE";?></b></td>
							</tr>
							<?php
							$band2=1;
						}elseif($row["MarcaId"]==5 && $band3==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "HTC";?></b></td>
							</tr>
							<?php
							$band3=1;
						}elseif($row["MarcaId"]==6 && $band4==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "HUAWEI";?></b></td>
							</tr>
							<?php
							$band4=1;
						}elseif($row["MarcaId"]==7 && $band5==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "LG";?></b></td>
							</tr>
							<?php
							$band5=1;
						}elseif($row["MarcaId"]==8 && $band6==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "MOTOROLA";?></b></td>
							</tr>
							<?php
							$band6=1;
						}elseif($row["MarcaId"]==10 && $band7==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "SAMSUNG";?></b></td>
							</tr>
							<?php
							$band7=1;
						}elseif($row["MarcaId"]==11 && $band8==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "SONY";?></b></td>
							</tr>
							<?php
							$band8=1;
						}elseif($row["MarcaId"]==12 && $band9==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "ZTE";?></b></td>
							</tr>
							<?php
							$band9=1;
						}elseif($row["MarcaId"]==13 && $band10==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "SIMCARD";?></b></td>
							</tr>
							<?php
							$band10=1;
						}elseif($row["MarcaId"]==16 && $band11==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "WSA";?></b></td>
							</tr>
							<?php
							$band11=1;
						}elseif($row["MarcaId"]==20 && $band12==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "TRENDNET";?></b></td>
							</tr>
							<?php
							$band12=1;
						}elseif($row["MarcaId"]==23 && $band13==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "LENOVO";?></b></td>
							</tr>
							<?php
							$band13=1;
						}elseif($row["MarcaId"]==24 && $band14==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "HISENSE";?></b></td>
							</tr>
							<?php
							$band14=1;
						}elseif($row["MarcaId"]==25 && $band15==0){
							?>
							<tr align="center">
							<td colspan="5" style="background:#01B1FA; color: white"><b><?php echo "AFFIX";?></b></td>
							</tr>
							<?php
							$band15=1;
						}	
			 				$equipo=$row["Equipo"];
			 				$equipoId=$row["EquipoId"];
			 				$consigna=$row["NombreConsigna"];
			 ?>
			 		<tr <?php echo $clase; ?>>
							<td style="color: black;"><?php echo $equipoId; ?></td>
							<td style="color: black;"><?php echo $consigna; ?></td>
							<td style="color: black;"><?php echo $equipo; ?></td>
							<?php
			 					$costo=$row["CostoEquipo"];
								$costo=number_format(($costo),2,'.',',');
								
							?>
							<td style="color: black;"> MXN $ <?php echo $costo; ?></td>
							<td style="color: black;"><input type="number" style="width: 60px;" name="<?php echo $equipoId?>" value="0"></td>
							
						</tr>
			 
			 <?php
		 }
		    
			
			
			
				
			?>
   			
   			
   		</table>
   		<div style="width: 90%;">
   			<div align="right">
   				<button class="btn btn-info btn-xs"><span class="glyphicon glyphicon-shopping-cart"></span> A&ntilde;adir al Carrito</button>
   			</div>
   				
   		</div>
   	
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