<?php

if(isset($_GET["id"]) && !empty($_GET["id"])){
	require_once "system/config.php";
	$conexao = new Conexao();
	$con = $conexao->connect();

	if($con){
		$query = $con->prepare("SELECT fotoName, fotoSize, fotoType FROM postagem WHERE id=?");
		$query->bindParam(1, $_GET["id"]);
		$query->execute();
		$linha = $query->fetch(PDO::FETCH_OBJ);
		header("Content-type: " . $linha->fotoType);
		header("Content-length: " . $linha->fotoSize);
		echo file_get_contents("postagemphotos/".$linha->fotoName);
	}
}else{
	header("Location: /");
}

?>