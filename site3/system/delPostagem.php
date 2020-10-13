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

	$query = $con->prepare("DELETE FROM postagemcategoria WHERE postagem=?");
	$query->bindParam(1, $id);
	$query->execute();
	
	$query = $con->prepare("SELECT fotoName FROM postagem WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();

	$file = "..".DIRECTORY_SEPARATOR."postagemphotos".DIRECTORY_SEPARATOR.$query->fetch(PDO::FETCH_OBJ)->fotoName;
	if(file_exists($file)) unlink($file);

	$query = $con->prepare("DELETE FROM postagem WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	header("Location: /site4/painel/postagens");
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>