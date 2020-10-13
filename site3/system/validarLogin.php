<?php

session_start();
if(isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você já está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["usuario"]) && isset($_POST["senha"])){
	require_once "config.php";
	$conexao = new Conexao();
	$con = $conexao->connect();
	
	if($con){
		$query = $con->prepare("SELECT id, nome, email FROM usuario WHERE nome=? AND senha=MD5(?)");
		$query->bindParam(1, $_POST["usuario"]);
		$query->bindParam(2, $_POST["senha"]);
		$query->execute();
		
		if($query->rowCount() > 0){
			echo json_encode(array("status"=>"success", "message"=>"Bem-vindo(a)!"), JSON_UNESCAPED_UNICODE);
			$linha = $query->fetch(PDO::FETCH_OBJ);
			$_SESSION["usuario"] = $linha->id;
			$_SESSION["nome"] = $linha->nome;
			$_SESSION["email"] = $linha->email;
		}else{
			echo json_encode(array("status"=>"danger", "message"=>"Nenhum usuário cadastrado com estes valores!"), JSON_UNESCAPED_UNICODE);
		}
	}else{
		echo json_encode(array("status"=>"danger", "message"=>"Não foi possível se conectar ao banco!"), JSON_UNESCAPED_UNICODE);
	}
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os parâmetros!"), JSON_UNESCAPED_UNICODE);
}

?>