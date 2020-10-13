<?php

session_start();
if(isset($_POST["nick"]) && isset($_POST["senha"])){
	require_once "config/conexao.php";
	$conexao = new Conexao();
	$con = $conexao->connectServidor();

	if($con){
		$nick = $_POST["nick"];
		$senha = $_POST["senha"];

		$query = $con->prepare("SELECT * FROM login WHERE player=? AND senha=MD5(?)");
		$query->bindParam(1, $nick);
		$query->bindParam(2, $senha);
		$query->execute();
		if($query->rowCount() > 0){
			$_SESSION["usuario"] = $query->fetch(PDO::FETCH_OBJ)->player;
			header("Location: loja.php");
		}else{
			$_SESSION["erro"] = "Informe um usuário e senha válidos!";
		}
	}else{
		$_SESSION["erro"] = "Não foi possível validar seu login!";
	}
}else{
	$_SESSION["erro"] = "Informe o usuário e a senha!";
}
header("Location: loja.php");

?>