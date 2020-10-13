<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_GET["cargoid"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("DELETE FROM equipe WHERE cargo=?");
	$query->bindParam(1, $_GET["cargoid"]);
	$query->execute();
	$query = $con->prepare("DELETE FROM cargos WHERE id=?");
	$query->bindParam(1, $_GET["cargoid"]);
	$query->execute();
}

header("Location: /admin");

?>