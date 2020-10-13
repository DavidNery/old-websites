<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["titulo"]) && isset($_POST["conteudo"]) && isset($_POST["descricao"]) && isset($_POST["categoria"]) && isset($_FILES["foto"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$titulo = $_POST["titulo"];
	$conteudo = $_POST["conteudo"];
	$descricao = $_POST["descricao"];
	$categorias = $_POST["categoria"];
	$foto = $_FILES["foto"];

	$nome = $foto["name"];
	$type = $foto["type"];
	$tamanho = $foto["size"];

	$info = pathinfo($foto["name"]);

	if($info["extension"] != "jpg" && $info["extension"] != "jpeg" && $info["extension"] != "png" && $info["extension"] != "gif"){
		echo json_encode(array("status"=>"error", "message"=>"Envie apenas arquivos .jpg, .jpeg, .png ou .gif!"), JSON_UNESCAPED_UNICODE);
		return;
	}

	if($tamanho > 0){
		if(strlen($info["filename"]) > 40){
			echo json_encode(array("status"=>"error", "message"=>"O nome da foto tem de ter no máximo 40 caracteres!"), JSON_UNESCAPED_UNICODE);
			return;
		}
	}else{
		echo json_encode(array("status"=>"error", "message"=>"A foto tem que ser maior que 0 Bytes!"), JSON_UNESCAPED_UNICODE);
		return;
	}

	$nome = strtotime("now").".".$info["extension"];

	$query = $con->prepare("INSERT INTO postagem VALUES (null, ?, ?, ?, NOW(), 0, ?, ?, ?, ?)");
	$query->bindParam(1, $titulo);
	$query->bindParam(2, $conteudo);
	$query->bindParam(3, $descricao);
	$query->bindParam(4, $nome);
	$query->bindParam(5, $type);
	$query->bindParam(6, $tamanho);
	$query->bindParam(7, $_SESSION["usuario"]);
	if($query->execute()){
		$id = $con->lastInsertId();
		$sql = "INSERT INTO postagemcategoria VALUES ";
		foreach($categorias as $categoria){
			$sql .= "($id, $categoria), ";
		}
		$sql = substr($sql, 0, strlen($sql)-2);

		$query = $con->prepare($sql);
		if($query->execute()){
			move_uploaded_file($foto["tmp_name"], getcwd().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."postagemphotos".DIRECTORY_SEPARATOR.$nome);
			echo json_encode(array("status"=>"success", "message"=>"Post criado com sucesso!"), JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(array("status"=>"danger", "message"=>"Não foi possível postar!"), JSON_UNESCAPED_UNICODE);
		}
	}else{
		echo json_encode(array("status"=>"danger", "message"=>"Já existe um post com este título!".addslashes(json_encode($con->errorInfo()))), JSON_UNESCAPED_UNICODE);
	}
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!".json_encode($_POST)), JSON_UNESCAPED_UNICODE);
}

?>