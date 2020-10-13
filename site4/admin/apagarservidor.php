<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_GET["servidorid"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("DELETE FROM loja WHERE id=?");
	$query->bindParam(1, $_GET["servidorid"]);
	$query->execute();
}

header("Location: /admin/loja");

?>