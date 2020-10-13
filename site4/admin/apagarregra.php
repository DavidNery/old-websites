<?php

session_start();
if(isset($_SESSION["usuario"]) && isset($_GET["regraid"])){
	require "../config/conexao.php";
	
	$con = Conexao::returnConnection();
	$query = $con->prepare("DELETE FROM regras WHERE id=?");
	$query->bindParam(1, $_GET["regraid"]);
	$query->execute();
}

header("Location: /admin/regras");

?>