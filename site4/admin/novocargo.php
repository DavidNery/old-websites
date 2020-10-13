<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["nome"]) && isset($_POST["cor"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("INSERT INTO cargos VALUES(null, ?, ?)");
	$query->bindParam(1, $_POST["nome"]);
	$query->bindParam(2, $_POST["cor"]);
	$query->execute();
}

header("Location: /admin");

?>