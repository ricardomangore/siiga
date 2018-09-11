<?php

class Connect{

	private $link;

	public function __construct () {
		$this->link =  new mysqli("SERVER", "USER", "PASSWORD", "DB_NAME");
		if (mysqli_connect_errno()) {
			throw new Exception('Error de conexión a base de datos: ' . mysqli_connect_error() );
		}
	}

	public function getLink () {
		return $this->link;
	}

}