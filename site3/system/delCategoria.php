<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_GET["id"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$id = $_GET["id"];

	$query = $con->prepare("DELETE FROM postagemcategoria WHERE categoria=?");
	$query->bindParam(1, $id);
	$query->execute();

	$query = $con->prepare("DELETE FROM categoria WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	header("Location: /site4/painel/categorias");
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>