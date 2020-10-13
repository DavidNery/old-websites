<?php

class Conexao {
	
	private $host, $database, $user, $pass;
	
	public function __construct() {
		$this->host = "127.0.0.1";
		$this->database = "site";
		$this->user = "root";
		$this->pass = "";
	}
	
	public function connect() {
		$conexao = null;
		try{
			$conexao = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->pass);
			$conexao->exec("SET NAMES UTF8");
			return $conexao;
		}catch(PDOException $e){return false;}
	}
	
}

?>