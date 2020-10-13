<?php

session_start();
if(!isset($_SESSION["usuario"])){
	echo json_encode(array("status"=>"danger", "message"=>"Você não está logado!"), JSON_UNESCAPED_UNICODE);
	return;
}

if(isset($_POST["id"]) && isset($_POST["titulo"]) && isset($_POST["conteudo"]) && isset($_POST["descricao"]) && isset($_POST["categoria"])){
	require_once "config.php";

	$conexao = new Conexao();
	$con = $conexao->connect();	

	$id = $_POST["id"];
	$titulo = $_POST["titulo"];
	$conteudo = $_POST["conteudo"];
	$descricao = $_POST["descricao"];
	$categorias = $_POST["categoria"];

	$sql = "UPDATE postagem SET titulo=?, conteudo=?, descricao=?";
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

			$sql .= ", fotoName=?, fotoType=?, fotoSize=? WHERE id=?";

			$nome = strtotime("now").".".$info["extension"];

			$query = $con->prepare("SELECT fotoName FROM postagem WHERE id=?");
			$query->bindParam(1, $id);
			$query->execute();

			$nome = $query->fetch(PDO::FETCH_OBJ)->fotoName;
			$file = "..".DIRECTORY_SEPARATOR."postagemphotos".DIRECTORY_SEPARATOR.$nome;
			if(file_exists($file)) unlink($file);

			$query = $con->prepare($sql);
			$query->bindParam(4, $nome);
			$query->bindParam(5, $type);
			$query->bindParam(6, $tamanho);
			$query->bindParam(7, $id);
		}else{
			$sql .= " WHERE id=?";
			$query = $con->prepare($sql);
			$query->bindParam(4, $id);
		}
	}else{
		$sql .= " WHERE id=?";
		$query = $con->prepare($sql);
		$query->bindParam(4, $id);
	}

	$query->bindParam(1, $titulo);
	$query->bindParam(2, $conteudo);
	$query->bindParam(3, $descricao);

	if($query->execute()){
		$sql = "INSERT IGNORE INTO postagemcategoria VALUES ";
		foreach($categorias as $categoria){
			$sql .= "($id, $categoria), ";
		}
		$sql = substr($sql, 0, strlen($sql)-2);

		$query = $con->prepare($sql);
		if($query->execute()){
			if(isset($_POST["remover"])){
				$sql = "DELETE FROM postagemcategoria WHERE postagem=? AND categoria IN (";
				foreach($_POST["remover"] as $categoria){
					$sql .= "$categoria, ";
				}
				$sql = substr($sql, 0, strlen($sql)-2).")";

				$query = $con->prepare($sql);
				$query->bindParam(1, $id);
				$query->execute();
			}
			move_uploaded_file($foto["tmp_name"], getcwd().DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."postagemphotos".DIRECTORY_SEPARATOR.$nome);
			echo json_encode(array("status"=>"success", "message"=>"Post editado com sucesso!"), JSON_UNESCAPED_UNICODE);
		}else{
			echo json_encode(array("status"=>"danger", "message"=>"Não foi possível postar!"), JSON_UNESCAPED_UNICODE);
		}
	}else{
		echo json_encode(array("status"=>"danger", "message"=>"Já existe um post com este título!".addslashes(json_encode($con->errorInfo()))), JSON_UNESCAPED_UNICODE);
	}
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Informe todos os dados!"), JSON_UNESCAPED_UNICODE);
}

?>