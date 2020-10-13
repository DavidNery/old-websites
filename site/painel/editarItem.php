<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["descricao"]) && isset($_POST["modaltitle"]) && isset($_POST["modalcontent"]))){
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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para editar items!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("UPDATE lojaitems SET nome=?, descricao=? WHERE id=?");
$query->bindParam(1, $_POST["title"]);
$query->bindParam(2, $_POST["descricao"]);
$query->bindParam(3, $_POST["id"]);
$query->execute();

$query = $con->prepare("UPDATE modalitems SET titulo=?, conteudo=? WHERE itemId=?");
$query->bindParam(1, $_POST["modaltitle"]);
$query->bindParam(2, $_POST["modalcontent"]);
$query->bindParam(3, $_POST["id"]);
$query->execute();
if($query->rowCount() > 0)
	echo json_encode(array("status"=>"success", "message"=>"Item editado com sucesso!"), JSON_UNESCAPED_UNICODE);
else
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível editar este item!"), JSON_UNESCAPED_UNICODE);

?>