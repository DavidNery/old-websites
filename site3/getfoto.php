<?php

if(isset($_GET["usuario"]) && !empty($_GET["usuario"])){
	require_once "system/config.php";
	$conexao = new Conexao();
	$con = $conexao->connect();

	if($con){
		$query = $con->prepare("SELECT fotoName, fotoSize, fotoType FROM usuario WHERE id=?");
		$query->bindParam(1, $_GET["usuario"]);
		$query->execute();
		$linha = $query->fetch(PDO::FETCH_OBJ);
		if($query->rowCount() == 0){
			header("Content-type: image/png");
			header("Content-length: 5667");
			echo file_get_contents("src/default.png");
		}else if($linha->fotoName != null){
			header("Content-type: " . $linha->fotoType);
			header("Content-length: " . $linha->fotoSize);
			echo file_get_contents("userphotos/".$linha->fotoName);
		}else{
			header("Content-type: image/png");
			header("Content-length: 5667");
			echo file_get_contents("src/default.png");
		}
	}
}else{
	header("Content-type: image/png");
	header("Content-length: 5667");
	echo file_get_contents("src/default.png");
}

?>