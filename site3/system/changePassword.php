<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["csenha"]) && isset($_POST["nsenha"]) && isset($_POST["nsenhan"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$current = $_POST["csenha"];
	$new = $_POST["nsenha"];
	$newagain = $_POST["nsenhan"];
	
	$query = $con->prepare("SELECT senha FROM usuario WHERE id=?");
	$query->bindParam(1, $_SESSION["usuario"]);
	$query->execute();

	if(md5($current) != $query->fetch(PDO::FETCH_OBJ)->senha){
		echo json_encode(array("status"=>"danger", "message"=>"A senha atual não coincide com a cadastrada!"), JSON_UNESCAPED_UNICODE);
		return;
	}else if($new != $newagain){
		echo json_encode(array("status"=>"danger", "message"=>"As senhas não coincidem!"), JSON_UNESCAPED_UNICODE);
		return;
	}
	
	$query = $con->prepare("UPDATE usuario SET senha=MD5(?) WHERE id=?");
	$query->bindParam(1, $new);
	$query->bindParam(2, $_SESSION["usuario"]);
	$query->execute();
	echo json_encode(array("status"=>"success", "message"=>"Senha alterada com sucesso!"), JSON_UNESCAPED_UNICODE);
	session_destroy();
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>