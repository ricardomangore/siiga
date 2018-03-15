<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Orden de Pedido</title>
<meta name="viewport" content="width=device-width, initial-escale=1.0">
<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/login.css" rel="stylesheet" media="screen">
</head>
<body background="img/papel.jpg"><br>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="profile-img" src="img/usuario.png">
                <form action="php/control.php" class="form-signin" method="post">
                <input type="text" class="form-control" placeholder="Correo" name="usuario" required autofocus>
                <input type="password" class="form-control" placeholder="Password" name="pass" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                	Iniciar Sesion
                </button>
               
                </form>
            </div>
           
        </div>
    </div>
</div>
</body>
</html>
