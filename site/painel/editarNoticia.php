<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["content"]))){
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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para editar notícias!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("UPDATE noticias SET title=?, content=? WHERE id=?");
$query->bindParam(1, $_POST["title"]);
$query->bindParam(2, $_POST["content"]);
$query->bindParam(3, $_POST["id"]);
$query->execute();

if($query->rowCount() > 0)
	echo json_encode(array("status"=>"success", "message"=>"Notícia atualizada com sucesso!"), JSON_UNESCAPED_UNICODE);
else
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível atualizae a notícia"), JSON_UNESCAPED_UNICODE);

?>