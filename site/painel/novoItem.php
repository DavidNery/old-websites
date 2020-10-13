<?php

session_start();
if(!(isset($_SESSION["usuario"]) && isset($_POST["title"]) && isset($_POST["descricao"]) && isset($_POST["modaltitle"]) && isset($_POST["modalcontent"]) && isset($_POST["btnText"]) && isset($_POST["btnColor"]) && isset($_POST["btnLink"]))){
	header("Location: ../");
	return;
}

require_once "../config/conexao.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM permitidos WHERE nick=?");
$query->bindParam(1, $_SESSION["usuario"]);
$query->execute();

if($query->rowCount() == 0){
	echo json_encode(array("status"=>"error", "message"=>"Você não tem permissão para criar items!"), JSON_UNESCAPED_UNICODE);
	return;
}

$query = $con->prepare("INSERT INTO lojaitems VALUES (null, ?, ?)");
$query->bindParam(1, $_POST["title"]);
$query->bindParam(2, $_POST["descricao"]);
$query->execute();

if($query->rowCount() > 0){
	
	$query = $con->prepare("SELECT id FROM lojaitems ORDER BY id DESC LIMIT 1");
	$query->execute();
	$id = $query->fetch(PDO::FETCH_OBJ)->id;
	
	$query = $con->prepare("INSERT INTO modalitems VALUES (null, ?, ?, ?)");
	$query->bindParam(1, $id);
	$query->bindParam(2, $_POST["modaltitle"]);
	$query->bindParam(3, $_POST["modalcontent"]);
	$query->execute();
	
	$query = $con->prepare("INSERT INTO buttonsitems VALUES(null, ?, ?, ?, ?)");
	$query->bindParam(1, $id);
	$query->bindParam(2, $_POST["btnText"]);
	$query->bindParam(3, $_POST["btnLink"]);
	$query->bindParam(4, $_POST["btnColor"]);
	$query->execute();
	if($query->rowCount() > 0)
		echo json_encode(array("status"=>"success", "message"=>"Item cadastrado com sucesso!"), JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"error", "message"=>"Não foi possível criar este item!"), JSON_UNESCAPED_UNICODE);
}

?>