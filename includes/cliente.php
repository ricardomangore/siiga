<?php
      require_once('lib/nusoap.php');
    $cliente = new nusoap_client('localhost/siiga/includes/EnviarContacto.php');
    $resultado = $cliente->call('calculadora', array('x' => '3', 'y' => 4, 'operacion' => 'multiplica'));
    echo $resultado;
?>