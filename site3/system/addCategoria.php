<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["nome"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$nome = $_POST["nome"];

	$query = $con->prepare("INSERT INTO categoria VALUES (null, ?)");
	$query->bindParam(1, $nome);
	if($query->execute())
		echo json_encode(array("status"=>"success", "message"=>"Categoria criada com sucesso!"), JSON_UNESCAPED_UNICODE);
	else
		echo json_encode(array("status"=>"danger", "message"=>"Já existe uma categoria com este nome!"), JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>