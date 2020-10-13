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
	
	
	$query = $con->prepare("DELETE FROM postagemcategoria WHERE postagem IN (SELECT id FROM postagem WHERE usuario=?)");
	$query->bindParam(1, $id);
	$query->execute();

	$query = $con->prepare("DELETE FROM postagem WHERE usuario=?");
	$query->bindParam(1, $id);
	$query->execute();
	
	$query = $con->prepare("SELECT fotoName FROM usuario WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	
	$linha = $query->fetch(PDO::FETCH_OBJ);
	
	if($linha->fotoName != null){
		$nome = $linha->fotoName;
		$file = "..".DIRECTORY_SEPARATOR."userphotos".DIRECTORY_SEPARATOR.$nome;
		if(file_exists($file)) unlink($file);
	}

	$query = $con->prepare("DELETE FROM usuario WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	header("Location: /site4/painel/equipe");
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>