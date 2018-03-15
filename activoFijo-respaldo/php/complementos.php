<?php
	function menuHeader(){
		include("sesion.php");
		$usuario=$_SESSION["usuario"];
		echo '
		 <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> '.$usuario.' <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                       
                        
                        <li>
                            <a href="php/salir.php"><i class="fa fa-fw fa-power-off"></i> Cerrar Sesi&oacute;n</a>
                        </li>
                    </ul>
                </li>
            </ul>
		
		';
	}
	function menu(){
		echo '
		 <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="activoFijo.php"><i class="fa fa-fw fa-dashboard"></i> Inicio</a>
                    </li>
                    <li>
                        <a href="puntosVenta.php"><i class="fa fa-fw fa-home"></i> Puntos de Venta</a>
                    </li>
					<!-- <li>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Reportes</a>
                    </li>
                    <li>
                        <a href="forms.html"><i class="fa fa-fw fa-wrench"></i> Herramientas</a>
                    </li>-->
                    <li>
                        <a href="php/salir.php"><span class="glyphicon glyphicon-off"></span> Cerrar Sesi&oacute;n</a>
                    </li>
                    
                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
		
		
		';
	}

	function modalSeguridad(){
		echo '';
	}

?>