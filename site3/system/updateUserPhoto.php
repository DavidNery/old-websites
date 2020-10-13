<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_FILES["photoContent"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();

	$foto = $_FILES["photoContent"];

	$nome = $foto["name"];
	$tamanho = $foto["size"];
	$type = $foto["type"];

	$info = pathinfo($foto["name"]);

	if($info["extension"] != "jpg" && $info["extension"] != "jpeg" && $info["extension"] != "png"){
		echo json_encode(array("status"=>"danger", "message"=>"Envie apenas arquivos .jpg, .jpeg ou .png!"), JSON_UNESCAPED_UNICODE);
		return;
	}

	if($tamanho > 0){
		if(strlen($info["filename"]) > 40){
			echo json_encode(array("status"=>"danger", "message"=>"O nome da foto tem de ter no máximo 40 caracteres!"), JSON_UNESCAPED_UNICODE);
			return;
		}
	}else{
		echo json_encode(array("status"=>"danger", "message"=>"A foto tem que ser maior que 0 Bytes!"), JSON_UNESCAPED_UNICODE);
		return;
	}

	$id = $_SESSION["usuario"];
	if(isset($_POST["user"]))
		$id = $_POST["user"];

	$query = $con->prepare("SELECT fotoName FROM usuario WHERE id=?");
	$query->bindParam(1, $id);
	$query->execute();
	
	$linha = $query->fetch(PDO::FETCH_OBJ);
	
	if($linha->fotoName != null){
		$nome = $linha->fotoName;
		$file = "..".DIRECTORY_SEPARATOR."userphotos".DIRECTORY_SEPARATOR.$nome;
		if($nome != null && file_exists($file)) unlink($file);
	}
	$nome = $id."-".$info["filename"].".".$info["extension"];
	move_uploaded_file($foto["tmp_name"], getcwd().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."userphotos".DIRECTORY_SEPARATOR.$nome);
	$query = $con->prepare("UPDATE usuario SET fotoName=?, fotoSize=?, fotoType=? WHERE id=?");
	$query->bindParam(1, $nome);
	$query->bindParam(2, $tamanho);
	$query->bindParam(3, $type);
	$query->bindParam(4, $id);
	$query->execute();
	echo json_encode(array("status"=>"success", "message"=>"Foto alterada com sucesso!"), JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>