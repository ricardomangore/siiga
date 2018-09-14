<?php

class Log{
	
	public static function messageLog($message,$method){
		$date = date("Y-m-d h:i:sa");
		$log = "\n". $date . ": [$method] : $message \n";
		error_log($log, 3, "comparativo_ventas/logs/comparativo-ventas-log.txt");
	}
}

?>