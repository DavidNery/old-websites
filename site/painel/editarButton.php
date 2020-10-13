<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["id"]) &&  isset($_POST["btnText"]) && isset($_POST["btnColor"]) && isset($_POST["btnLink"]))){
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
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para editar botões!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("UPDATE buttonsitems SET texto=?, link=?, cor=? WHERE id=?");
$query->bindParam(1, $_POST["btnText"]);
$query->bindParam(2, $_POST["btnLink"]);
$query->bindParam(3, $_POST["btnColor"]);
$query->bindParam(4, $_POST["id"]);
$query->execute();

if($query->rowCount() > 0)
	echo json_encode(array("status"=>"success", "message"=>"Botão editado com sucesso!"), JSON_UNESCAPED_UNICODE);
else
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível editar este botão!"), JSON_UNESCAPED_UNICODE);

?>