<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["usuarioSelecionado"]))){
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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para permitir usuários!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("INSERT INTO permitidos VALUES (null, ?)");
$query->bindParam(1, $_POST["usuarioSelecionado"]);
$query->execute();

if($query->rowCount() > 0)
	echo json_encode(array("status"=>"success", "message"=>"Usuário permitido com sucesso!"), JSON_UNESCAPED_UNICODE);
else
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível permitir este usuário!"), JSON_UNESCAPED_UNICODE);

?>