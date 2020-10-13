<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_GET["userid"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("DELETE FROM equipe WHERE id=?");
	$query->bindParam(1, $_GET["userid"]);
	$query->execute();
}

header("Location: /admin");

?>