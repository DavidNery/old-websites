<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["btnText"]) && isset($_POST["btnColor"]) && isset($_POST["btnLink"]))){
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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para criar botões!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("INSERT INTO buttonsitems VALUES (null, ?, ?, ?, ?)");
$query->bindParam(1, $_POST["itemId"]);
$query->bindParam(2, $_POST["btnText"]);
$query->bindParam(3, $_POST["btnLink"]);
$query->bindParam(4, $_POST["btnColor"]);
$query->execute();

if($query->rowCount() > 0)
	echo json_encode(array("status"=>"success", "message"=>"Botão criado com sucesso!"), JSON_UNESCAPED_UNICODE);
else
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível criar este botão!"), JSON_UNESCAPED_UNICODE);

?>