<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_POST["nome"]) && isset($_POST["link"]) && isset($_POST["imagem"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("INSERT INTO loja VALUES(null, ?, ?, ?)");
	$query->bindParam(1, $_POST["nome"]);
	$query->bindParam(2, $_POST["link"]);
	$query->bindParam(3, $_POST["imagem"]);
	$query->execute();
}

header("Location: /admin/loja");

?>