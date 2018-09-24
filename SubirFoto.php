<?php
  include("includes/Conectar.php");
  include("includes/Security.php");
  include("includes/Tools.php");
  include("includes/ToolsHtml.php");
  include("includes/Menu.php");

  $Seguridad=new Security();
  if(!$Seguridad->SesionExiste())
    header("Location: index.php");
  
  $Menu= new Menu($_SESSION['UsuarioId']);
  $Herramientas= new Tools($_SESSION['UsuarioId']);
  $HerramientasHtml= new ToolsHtml($_SESSION['UsuarioId']); 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;" />
<?php $HerramientasHtml->getTituloWeb(); ?>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link href="style/tabla.css" rel="stylesheet" type="text/css" />
<link href="style/jquery-ui.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script>
  function existeFoto(form){
    if(form.userfile.value=="")
    {
      alert("Debes esperar a que el archivo se identifique");
      return false;
    }
    return true;
  }

</script>

<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="js/menu.js"></script>
<script type="text/javascript" src="js/general.js"></script>
<script type="text/javascript" src="js/control.js"></script>
<script type="text/javascript" src="js/combos.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

</head>
</head>
<body>
    <form action="EditPicture.php" method="post" enctype="multipart/form-data" name="InfoFoto" id="InfoFoto" onsubmit="return existeFoto(this);">
    <span class="etiqueta">Foto Personal.</span>
    <br>
    <br>
        <img src="img/Foto.png" width="128" height="128" />
       <label for="fileField"></label>
       <input type="file" name="userfile" id="userfile" />
       <input type="hidden" name="EmpleadoId" id="EmpleadoId" value="<?php echo $_SESSION['UsuarioId'].'123'; ?>" />
       <input type="submit" name="Adjuntar" id="Adjuntar" value="Adjuntar" />       
    </form>
</body>
</html>