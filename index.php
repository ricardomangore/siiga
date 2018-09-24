<?php
	include("includes/Conectar.php");
	include("includes/Security.php");	
	$Seguridad = new Security();

	$Mensaje='';

	if(isset($_POST['entrar']))
	{
		if($Seguridad->SesionExiste())
			{						
			header("Location: sistema.php");
			}
		else
			if($Seguridad->CreaSesion($_POST['nip'], $_POST['pwd']))
				if( $_POST['pwd']=='12345')
				header("Location: MiSitio.php");	
					else
				header("Location: sistema.php");
			else
			$Mensaje=$Seguridad->getMensaje();
	}
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="style/acceso.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.8.1.js"></script>


</head>
<body>
	<div id="Portada" align="center">

		<div id="Login">
			<form id="foo" name="foo" method="post" onsubmit="return ValidarAcceso(this);" autocomplete="off">	
				<div id="Error"><strong><?php echo $Mensaje; ?></strong></div></br></br><br>
				<img src="img/Logo.png" id="Logo" name="Logo" title="Sistema Integral de Inventarios y Gestion Administrativa">
				<br><br>			
				<input type="text" id="nip" name="nip" placeholder="Usuario"/> 
				</br><br>
				<input type="password" id="pwd" name="pwd" placeholder="Contraseña"/>
				<br><br>
				<input type="submit" id="entrar" name="entrar" value="Ingresar" class="button">
				
			</form>
		</div>
	</div>	
		<div id="rotulo">
			<div id="marco">
			</div>
		</div>
</body>
</html>
