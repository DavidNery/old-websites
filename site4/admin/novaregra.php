<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["nome"]) && isset($_POST["descricao"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("INSERT INTO regras VALUES(null, ?, ?)");
	$query->bindParam(1, $_POST["nome"]);
	$query->bindParam(2, nl2br($_POST["descricao"]));
	$query->execute();
}

header("Location: /admin/regras");

?>