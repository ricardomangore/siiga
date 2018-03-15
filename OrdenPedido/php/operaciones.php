<?php 
	//$puntoVentaId=12;
	function precioEquipo($equipo,$puntoVentaId){
		$equipoId=$equipo;
		$puntoVenta=$puntoVentaId;
		$queryPrecio=mysql_query("SELECT CostoEquipo FROM Equipos WHERE EquipoId=$equipoId");
		$resultado=mysql_fetch_array($queryPrecio);
		$precio=$resultado["CostoEquipo"];
		$iva=($precio)*(0.16);
		//echo "EquipoId: ".$equipoId."Precio Equipo: ".$precio." Iva: ".$iva." Total: ".($precio+$iva)."<br>";
		return ($precio+$iva);
	}

	function precioEquipoIva($equipo){
		$equipoId=$equipo;
		$queryPrecio=mysql_query("SELECT Costo FROM OrdenesCompra WHERE EquipoId=$equipoId AND Costo!=0 AND Iva!=0");
		$resultado=mysql_fetch_array($queryPrecio);
		$precio=$resultado["Costo"];
		return $precio;
	}


	function inventarioActual($puntoVentaId){
		$queryInventario="SELECT DISTINCT I.Serie FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND E.MarcaId!=13";
		if($resultado=mysql_query($queryInventario)){
			$totalInventario=mysql_num_rows($resultado);
			$queryInvTR="SELECT DISTINCT I.Serie FROM Inventario AS I INNER JOIN TRSalidas AS TR ON I.MovimientoId=TR.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad>0 AND TR.PuntoVentaIdD=$puntoVentaId AND TR.EstatusTraspasoId=1 AND E.MarcaId!=13";
			$resTR=mysql_query($queryInvTR);
			$totalTR=mysql_num_rows($resTR);
			$queryInvOC="SELECT DISTINCT OC.Serie AS Serie FROM OrdenesCompra AS OC INNER JOIN Equipos AS E ON E.EquipoId=OC.EquipoId WHERE OC.Recibido=0 AND OC.PuntoVentaId=$puntoVentaId AND E.EquipoId!=13";
			$resOC=mysql_query($queryInvOC);
			$totalOc=mysql_num_rows($resOC);
			$totalInventario=$totalInventario+($totalOc+$totalTR);
			return $totalInventario;
		}else{
			echo "Error al consultar: ".$queryInventario.mysql_error();
		}
	}
		function inventarioActualSims($puntoVentaId){
		$queryInventario="SELECT DISTINCT I.Serie FROM Inventario AS I INNER JOIN Recepciones AS R ON I.MovimientoId=R.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad>0 AND R.PuntoVentaId=$puntoVentaId AND E.MarcaId=13";
		if($resultado=mysql_query($queryInventario)){
			$totalInventario=mysql_num_rows($resultado);
			$queryInvTR="SELECT DISTINCT I.Serie FROM Inventario AS I INNER JOIN TRSalidas AS TR ON I.MovimientoId=TR.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad>0 AND TR.PuntoVentaIdD=$puntoVentaId AND TR.EstatusTraspasoId=1 AND E.MarcaId=13";
			$resTR=mysql_query($queryInvTR);
			$totalTR=mysql_num_rows($resTR);
			$queryInvOC="SELECT DISTINCT OC.Serie AS Serie FROM OrdenesCompra AS OC INNER JOIN Equipos AS E ON E.EquipoId=OC.EquipoId WHERE OC.Recibido=0 AND OC.PuntoVentaId=$puntoVentaId AND E.EquipoId=13";
			$resOC=mysql_query($queryInvOC);
			$totalOc=mysql_num_rows($resOC);
			$totalInventario=$totalInventario+($totalOc+$totalTR);
			return $totalInventario;
		}else{
			echo "Error al consultar: ".$queryInventario.mysql_error();
		}
	}
	








	function precioTotal($puntoVentaId){
		$costo=0;
		$iva=0;
		$costoTotalInv=0;
		$queryInventario="SELECT DISTINCT OC.Costo AS CostoEquipo, I.Serie AS Serie FROM Inventario AS I INNER JOIN OrdenesCompra AS OC ON I.Serie=OC.Serie INNER JOIN Recepciones AS R ON R.MovimientoId=I.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad=1 AND R.PuntoVentaId=$puntoVentaId AND E.MarcaId!=13";
		if($resultado=mysql_query($queryInventario)){
			while($rowPrecio=mysql_fetch_array($resultado)){
				$costo=$costo+$rowPrecio["CostoEquipo"];
			}
			$queryInvTR="SELECT DISTINCT OC.Costo AS CostoEquipo, I.Serie AS Serie FROM Inventario AS I INNER JOIN TRSalidas AS TR ON I.MovimientoId=TR.MovimientoId INNER JOIN  Equipos AS E ON E.EquipoId=I.EquipoId  INNER JOIN OrdenesCompra AS OC ON OC.Serie=I.Serie WHERE I.Cantidad>0 AND TR.PuntoVentaIdD=$puntoVentaId AND TR.EstatusTraspasoId=1 AND E.MarcaId!=13";
			if($resultadoTR=mysql_query($queryInvTR)){
				while($rowPrecioTR=mysql_fetch_array($resultadoTR)){
					$costo=$costo+$rowPrecioTR["CostoEquipo"];
				}
				$queryInvOC="SELECT OC.Costo AS CostoEquipo FROM OrdenesCompra AS OC INNER JOIN Equipos AS E ON E.EquipoId=OC.EquipoId WHERE OC.Recibido=0 AND OC.PuntoVentaId=$puntoVentaId  AND E.MarcaId!=13";
				if($resultadoOC=mysql_query($queryInvOC)){
					while($rowPrecioOC=mysql_query($resultadoOC)){
						$costo=$costo+$rowPrecioOC["CostoEquipo"];
					}
				}
			}
			
			$iva=$costo*0.16;
			return $costoTotalInv=$costo+$iva;
		}else{
			echo "Error al consultar: ".$queryInventario.mysql_error();
		}
	}

	function precioTotalSims($puntoVentaId){
		$costo=0;
		$iva=0;
		$costoTotalInv=0;
		$queryInventario="SELECT DISTINCT OC.Costo AS CostoEquipo, I.Serie AS Serie FROM Inventario AS I INNER JOIN OrdenesCompra AS OC ON I.Serie=OC.Serie INNER JOIN Recepciones AS R ON R.MovimientoId=I.MovimientoId INNER JOIN Equipos AS E ON E.EquipoId=I.EquipoId WHERE I.Cantidad=1 AND R.PuntoVentaId=$puntoVentaId AND E.MarcaId=13";
		if($resultado=mysql_query($queryInventario)){
			while($rowPrecio=mysql_fetch_array($resultado)){
				$costo=$costo+$rowPrecio["CostoEquipo"];
			}
			$queryInvTR="SELECT DISTINCT OC.Costo AS CostoEquipo, I.Serie AS Serie FROM Inventario AS I INNER JOIN TRSalidas AS TR ON I.MovimientoId=TR.MovimientoId INNER JOIN  Equipos AS E ON E.EquipoId=I.EquipoId  INNER JOIN OrdenesCompra AS OC ON OC.Serie=I.Serie WHERE I.Cantidad>0 AND TR.PuntoVentaIdD=$puntoVentaId AND TR.EstatusTraspasoId=1 AND E.MarcaId=13";
			if($resultadoTR=mysql_query($queryInvTR)){
				while($rowPrecioTR=mysql_fetch_array($resultadoTR)){
					$costo=$costo+$rowPrecioTR["CostoEquipo"];
				}
				$queryInvOC="SELECT OC.Costo AS CostoEquipo FROM OrdenesCompra AS OC INNER JOIN Equipos AS E ON E.EquipoId=OC.EquipoId WHERE OC.Recibido=0 AND OC.PuntoVentaId=$puntoVentaId  AND E.MarcaId=13";
				if($resultadoOC=mysql_query($queryInvOC)){
					while($rowPrecioOC=mysql_query($resultadoOC)){
						$costo=$costo+$rowPrecioOC["CostoEquipo"];
					}
				}
			}
			
			$iva=$costo*0.16;
			return $costoTotalInv=$costo+$iva;
		}else{
			echo "Error al consultar: ".$queryInventario.mysql_error();
		}
	}






	function usuarios(){
			$queryUsuario="SELECT U.UsuarioId AS UsuarioId FROM Usuarios AS U INNER JOIN HistorialPuestosEmpleados AS HPE ON U.EmpleadoId=HPE.EmpleadoId WHERE (HPE.PuestoId=13 OR HPE.PuestoId=17 OR HPE.PuestoId=23 OR HPE.PuestoId=55 OR HPE.PuestoId=54) AND HPE.FechaBaja='0000-00-00' AND U.Activo=1 ORDER BY Rand() LIMIT 0,1";
			if($resultado=mysql_query($queryUsuario)){
				$rowUsuario=mysql_fetch_array($resultado);
				return $rowUsuario["UsuarioId"];
			}else{
				echo "Error al consultar: ".$queryUsuario.mysql_error();
			}
			
			
	}

	function PuntoVenta($usuarioId){
			$queryPuntoVenta="SELECT HPE.PuntoVentaId AS PuntoVentaId FROM Usuarios AS U INNER JOIN HistorialPuntosEmpleados AS HPE ON U.EmpleadoId=HPE.EmpleadoId WHERE HPE.FechaBaja='0000-00-00' AND HPE.Fisico=1 AND U.UsuarioId=$usuarioId";
			if($resultado=mysql_query($queryPuntoVenta)){
				$rowPuntoVenta=mysql_fetch_array($resultado);
				return $rowPuntoVenta["PuntoVentaId"];
			}else{
				echo "Error al consultar: ".$queryPuntoVenta.mysql_error();
			}
			
			
	}
	function Poliza($puntoVentaId){
		$queryPoliza="SELECT Monto FROM PolizasPuntos WHERE PuntoVentaId=$puntoVentaId";
		if($resultado=mysql_query($queryPoliza)){
			$rowPoliza=mysql_fetch_array($resultado);
			return( $rowPoliza["Monto"]);
		}else{
			echo "Error al consultar: ".$queryPoliza.mysql_error();
		}
		
		
	}
	function menu($activo, $ordenPedidoId,$puntoVentaId,$admin){
		date_default_timezone_set('America/Mexico_City');
		$time=time();
		$fecha=date("Y-m-d", $time);
		$hora=date("H:i:s", $time);
		$activarMenu=0;
		$query="SELECT HoraInicio, HoraFin FROM AperturaOrdenPedido WHERE (FechaInicio>='$fecha' AND FechaFin<='$fecha') AND Activo=1";

		
		if(mysql_num_rows($res=mysql_query($query))==1){
			$rowHora=mysql_fetch_array($res);
			$horaInicial=$rowHora["HoraInicio"];
			$horaFin=$rowHora["HoraFin"];
			$activarMenu=1;
			if(($hora>=$horaInicial) && ($hora<=$horaFin)){
				//echo "Correcto: Activar Menu";
				$activarMenu=1;
			}else{
				$activarMenu=0;
			}
			
		}
		$query2="SELECT HoraInicio, HoraFin FROM AperturaOrdenPedidoPunto WHERE (FechaInicio>='$fecha' AND FechaFin<='$fecha') AND Activo=1 AND PuntoVentaId='$puntoVentaId'";
		if(mysql_num_rows($res2=mysql_query($query2))==1){
			$rowHora=mysql_fetch_array($res2);
			$horaInicial=$rowHora["HoraInicio"];
			$horaFin=$rowHora["HoraFin"];
			if(($hora>=$horaInicial) && ($hora<=$horaFin)){
				//echo "Correcto: Activar Menu";
				$activarMenu=1;
			}else{
				$activarMenu=0;
			}
		}
		
		//$equiposCarrito=equiposCarrito($puntoVentaId,$ordenPedidoId);
		//$precioCarrito=precioCarrito($puntoVentaId,$ordenPedidoId);
		$equiposCarrito=equiposCarrito($ordenPedidoId,$puntoVentaId);
		$precioCarrito=precioCarrito($ordenPedidoId,$puntoVentaId);
		$precioCarrito=number_format(($precioCarrito),2,'.',',');
		echo '  <nav class="navbar navbar-default" role="navigation">
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
      <a class="navbar-brand" href="ordenPedido.php"><span class="glyphicon glyphicon-list-alt"></span> Ordenes de Pedido</a>
    </div>
  
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
         otro elemento que se pueda ocultar al minimizar la barra -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav">';
		if($activo=="index"){
			echo '<li class="active"><a href="ordenPedido.php"><span class="glyphicon glyphicon-eye-open"></span> &Oacute;rdenes</a></li>';
		}else{
			echo '<li><a href="ordenPedido.php"><span class="glyphicon glyphicon-eye-open"></span> &Oacute;rdenes</a></li>';
		}
			
		if($activo=="orden" && $activarMenu==1){
			echo '<li class="active"><a href="equipos3.php"><span class="glyphicon glyphicon-plus"></span> Nueva &Oacute;rden</a></a></li>';
		}elseif($activarMenu==1){
			echo '<li><a href="equipos3.php"><span class="glyphicon glyphicon-plus"></span> Nueva &Oacute;rden</a></a></li>';
		}
		if($admin==1){
			if($activo=="herramientas"){
				echo '<li class="active"><a href="herramientas.php"><span class="glyphicon glyphicon-wrench"></span> Herramientas</a></li>';
			}else{
				echo'<li><a href="herramientas.php"><span class="glyphicon glyphicon-wrench"></span> Herramientas</a></li>';
			}
			
			if($activo=="reporte"){
				echo '<li class="active"><a href="reportes.php"><span class="glyphicon glyphicon-list-alt"></span> Reportes</a></li>';
			}else{
				echo'<li><a href="reportes.php"><span class="glyphicon glyphicon-list-alt"></span> Reportes</a></li>';
			}
			
			
			
			
		}else{
			
		}
		
		echo '
      </ul>
      <ul class="nav navbar-nav navbar-right">';
		if($activo=="carrito"  && $activarMenu==1){
			echo '<li class="active"><a href="carritoCompras.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito ('.$equiposCarrito.') MXN $'.$precioCarrito.' </a></li>';
		}elseif($activarMenu==1){
			echo '<li><a href="carritoCompras.php"><span class="glyphicon glyphicon-shopping-cart"></span> Carrito ('.$equiposCarrito.') MXN $'.$precioCarrito.' </a></li>';
		}
        echo'
		<li><a href="php/salir.php"><span class="glyphicon glyphicon-off"></span> Cerrar Sesi&oacute;n</a></li>
        
      </ul>
    </div>
  </nav>';
	}

	
function equiposCarrito($ordenPedidoId, $puntoVentaId){
$equipostotalPedido=0;
$precioTotalPedido=0;
$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
$resultado=mysql_query($query);
if($resultado){
	$cont=0;	
	$resultados = mysql_fetch_assoc($resultado);
	$cont++;
	$equipos=explode(",",$resultados["Equipos"]);
	$tam=count($equipos);
	for($i=0;$i<($tam-1);$i++){
		$prueba=explode("-",$equipos[$i]);
		$queryEquipos="SELECT M.Marca AS Marca, E.Equipo AS Equipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$prueba[0]";
		$rowEquipos=mysql_query($queryEquipos);
		$resEquipos=mysql_fetch_array($rowEquipos);
		$cantidad=$prueba[1];
		$equipostotalPedido=$equipostotalPedido+$cantidad;
		}
}
	return($equipostotalPedido);
}

	
function precioCarrito($ordenPedidoId, $puntoVentaId){
$equipostotalPedido=0;
$precioTotalPedido=0;
$query="SELECT * FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedidoId";
$resultado=mysql_query($query);
if($resultado){
	$cont=0;	
	$resultados = mysql_fetch_assoc($resultado);
	$cont++;
	$equipos=explode(",",$resultados["Equipos"]);
	$tam=count($equipos);
	for($i=0;$i<($tam-1);$i++){
		$prueba=explode("-",$equipos[$i]);
		$queryEquipos="SELECT M.Marca AS Marca, E.Equipo AS Equipo FROM Equipos AS E INNER JOIN Marcas AS M ON M.MarcaId=E.MarcaId WHERE E.EquipoId=$prueba[0]";
		$rowEquipos=mysql_query($queryEquipos);
		$resEquipos=mysql_fetch_array($rowEquipos);
		$auxPrecio=(precioEquipo($prueba[0],$puntoVentaId))*($prueba[1]);
		$precioTotalPedido=$precioTotalPedido+$auxPrecio;
		}
}
	return($precioTotalPedido);
}
function ordenPedido($usuarioId, $puntoVentaId){
	$ordenPedidoId=0;
	$query="SELECT OrdenPedidoId FROM OrdenPedido WHERE (UsuarioId='$usuarioId' OR PuntoVentaId='$puntoVentaId') AND Pendiente=1";
	if($res=mysql_query($query)){
		$row=mysql_fetch_array($res);
		$ordenPedidoId=$row["OrdenPedidoId"];
	}else{
		echo "Error: ".$query.mysql_error();
	}
	return($ordenPedidoId);
	
}

	function NombrePuntoVenta($puntoVentaId){
			$queryPuntoVenta="SELECT PuntoVenta FROM PuntosVenta WHERE PuntoVentaId=$puntoVentaId";
			if($resultado=mysql_query($queryPuntoVenta)){
				$rowPuntoVenta=mysql_fetch_array($resultado);
				return $rowPuntoVenta["PuntoVenta"];
			}else{
				echo "Error al consultar: ".$queryPuntoVenta.mysql_error();
			}
			
			
	}

		function equiposPedido($ordenPedido){
			$queryPedido="SELECT Equipos FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido";
			if($resultado=mysql_query($queryPedido)){
				$rowPedido=mysql_fetch_array($resultado);
				if($rowPedido["Equipos"]=="Pendiente"){
					return 1;
				}
				return 0;
			}else{
				echo "Error al consultar: ".$queryPuntoVenta.mysql_error();
			}
			
			
	}
		function totalEquiposPedido($ordenPedido){
		$queryTotalEquipos="SELECT EquiposInicial FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido";
		if($resultadoEquipos=mysql_query($queryTotalEquipos)){
			$rowEquipos=mysql_fetch_array($resultadoEquipos);
			$totalEquipos=explode(",",$rowEquipos["EquiposInicial"]);
			$tamEquipos=count($totalEquipos);
			$total=0;
			for($i=0;$i<($tamEquipos-1);$i++){
				$auxCantidad=explode("-",$totalEquipos[$i]);
				$total=$total+$auxCantidad[1];
			}
			return($total);
		}else{
			echo "error al consultar: ".$queryTotalEquipos.mysql_error();
		}
		
		
	}


	function totalEquiposAutorizado($ordenPedido){
		$queryTotalEquipos="SELECT Equipos FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido";
		if($resultadoEquipos=mysql_query($queryTotalEquipos)){
			$rowEquipos=mysql_fetch_array($resultadoEquipos);
			$totalEquipos=explode(",",$rowEquipos["Equipos"]);
			$tamEquipos=count($totalEquipos);
			$total=0;
			for($i=0;$i<($tamEquipos-1);$i++){
				$auxCantidad=explode("-",$totalEquipos[$i]);
				$total=$total+$auxCantidad[1];
			}
			return($total);
		}else{
			echo "error al consultar: ".$queryTotalEquipos.mysql_error();
		}
	}


	function totalEquiposEntregados($ordenPedido){
		$queryTotalEquipos="SELECT EquiposFinal FROM OrdenPedido WHERE OrdenPedidoId=$ordenPedido";
		if($resultadoEquipos=mysql_query($queryTotalEquipos)){
			$rowEquipos=mysql_fetch_array($resultadoEquipos);
			$totalEquipos=explode(",",$rowEquipos["EquiposFinal"]);
			$tamEquipos=count($totalEquipos);
			$total=0;
			for($i=0;$i<($tamEquipos-1);$i++){
				$auxCantidad=explode("-",$totalEquipos[$i]);
				$total=$total+$auxCantidad[1];
			}
			return($total);
		}else{
			echo "error al consultar: ".$queryTotalEquipos.mysql_error();
		}
	}

	
?>