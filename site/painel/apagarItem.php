<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_GET["id"]))){
	header("Location: ../");
	return;
}

require_once "../config/conexao.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM permitidos WHERE nick=?");
$query->bindParam(1, $_SESSION["usuario"]);
$query->execute();

if($query->rowCount() == 0){
	header("Location: ../");
	return;
}

$query = $con->prepare("DELETE FROM modalitems WHERE itemId=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

$query = $con->prepare("DELETE FROM buttonsitems WHERE itemId=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

$query = $con->prepare("DELETE FROM lojaitems WHERE id=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

header("Location: index.php");

?>