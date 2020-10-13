<?php

class Conexao {
	
	private $hostServidor, $databaseServidor, $userServidor, $passServidor;
	private $host, $database, $user, $pass;
	
	public function __construct() {
		$this->hostServidor = "127.0.0.1";
		$this->databaseServidor = "servidor";
		$this->userServidor = "root";
		$this->passServidor = "";
		
		$this->host = "127.0.0.1";
		$this->database = "site";
		$this->user = "root";
		$this->pass = "";
	}
	
	public function connectServidor() {
		$con = null;
		try {
			$con = new PDO("mysql:host=".$this->hostServidor.";dbname=".$this->databaseServidor, $this->userServidor, $this->passServidor);
			$con->exec("SET NAMES UTF8");
		}catch(PDOException $e){return false;}
		return $con;
	}
	
	public function connect() {
		$con = null;
		try {
			$con = new PDO("mysql:host=".$this->host.";dbname=".$this->database, $this->user, $this->pass);
			$con->exec("SET NAMES UTF8");
		}catch(PDOException $e){return false;}
		return $con;
	}
	
}

?>