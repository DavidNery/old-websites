<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["id"]) && isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["frase"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$id = $_POST["id"];
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$senha = $_POST["senha"];
	$frase = $_POST["frase"];

	$query = $con->prepare("UPDATE usuario SET nome=?, email=?, senha=MD5(?), frase=? WHERE id=?");
	$query->bindParam(1, $nome);
	$query->bindParam(2, $email);
	$query->bindParam(3, $senha);
	$query->bindParam(4, $frase);
	$query->bindParam(5, $id);

	if($query->execute())
		echo json_encode(array("status"=>"success", "message"=>"Usuário editado com sucesso!"), JSON_UNESCAPED_UNICODE);
	else
		echo json_encode(array("status"=>"danger", "message"=>"Já existe um post com este título!".addslashes(json_encode($con->errorInfo()))), JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!".json_encode($_POST)), JSON_UNESCAPED_UNICODE);
}

?>