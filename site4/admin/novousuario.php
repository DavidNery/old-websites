<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["usuario"]) && isset($_POST["cargo"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("INSERT INTO equipe VALUES(null, ?, ?)");
	$query->bindParam(1, $_POST["usuario"]);
	$query->bindParam(2, $_POST["cargo"]);
	$query->execute();
}

header("Location: /admin");

?>