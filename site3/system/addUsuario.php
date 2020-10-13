<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["frase"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();

	$nomeu = $_POST["nome"];
	$email = $_POST["email"];
	$senha = $_POST["senha"];
	$frase = $_POST["frase"];

	$sql = "INSERT INTO usuario VALUES (null, ?, MD5(?), ?, ?";
	$query = null;

	if(isset($_FILES["foto"])){
		$foto = $_FILES["foto"];
		$nome = $foto["name"];
		$type = $foto["type"];
		$tamanho = $foto["size"];

		if($tamanho > 0){
			$info = pathinfo($foto["name"]);

			if($info["extension"] != "jpg" && $info["extension"] != "jpeg" && $info["extension"] != "png" && $info["extension"] != "gif"){
				echo json_encode(array("status"=>"error", "message"=>"Envie apenas arquivos .jpg, .jpeg, .png ou .gif!"), JSON_UNESCAPED_UNICODE);
				return;
			}else if(strlen($info["filename"]) > 40){
				echo json_encode(array("status"=>"error", "message"=>"O nome da foto tem de ter no máximo 40 caracteres!"), JSON_UNESCAPED_UNICODE);
				return;
			}

			$sql .= ", ?, ?, ?)";

			$nome = strtotime("now").".".$info["extension"];

			$query = $con->prepare($sql);
			$query->bindParam(5, $nome);
			$query->bindParam(6, $type);
			$query->bindParam(7, $tamanho);
		}else{
			$sql .= ", null, null, null)";
			$query = $con->prepare($sql);
		}
	}else{
		$sql .= ", null, null, null)";
		$query = $con->prepare($sql);
	}
	
	$query->bindParam(1, $nomeu);
	$query->bindParam(2, $senha);
	$query->bindParam(3, $email);
	$query->bindParam(4, $frase);

	if($query->execute()){
		move_uploaded_file($foto["tmp_name"], getcwd().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."userphotos".DIRECTORY_SEPARATOR.$nome);
		echo json_encode(array("status"=>"success", "message"=>"Usuário criado com sucesso!"), JSON_UNESCAPED_UNICODE);
	}else{
		echo json_encode(array("status"=>"danger", "message"=>"Já existe um usuário com este email!"), JSON_UNESCAPED_UNICODE);
	}
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>