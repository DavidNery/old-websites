<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["nome"]) && isset($_POST["id"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();

	$nome = $_POST["nome"];
	$id = $_POST["id"];
	
	$query = $con->prepare("SELECT * FROM categoria WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	if($query->rowCount() == 0){
		echo json_encode(array("status"=>"danger", "message"=>"Esta categoria não existe!"), JSON_UNESCAPED_UNICODE);
		return;
	}

	$query = $con->prepare("UPDATE categoria SET nome=? WHERE id=?");
	$query->bindParam(1, $nome);
	$query->bindParam(2, $id);
	if($query->execute())
		echo json_encode(array("status"=>"success", "message"=>"Categoria salva com sucesso!"), JSON_UNESCAPED_UNICODE);
	else
		echo json_encode(array("status"=>"danger", "message"=>"Já existe uma categoria com este nome!"), JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>