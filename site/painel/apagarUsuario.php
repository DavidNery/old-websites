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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para apagar usuários!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("DELETE FROM permitidos WHERE id=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

header("Location: ./");

?>