<?php

class Conexao {
	
	public static function returnConnection() {		
		require "site_config.php";
		
		$connection = null;
		
		try {
			$connection = new PDO("mysql:host=".$config["host"].":".$config["porta"].";dbname=".$config["db"], $config["usuario"], $config["senha"]);
			$connection->exec("SET NAMES UTF8");
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		return $connection;
	}
	
}

?>