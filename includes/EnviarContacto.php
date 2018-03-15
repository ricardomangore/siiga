<?php
    require_once('lib/nusoap.php');
    require_once('calculadora.php');
      
    $server = new nusoap_server();
    $server->register('calculadora');
      
    $HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
    $server->service($HTTP_RAW_POST_DATA);

?>