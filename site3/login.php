<?php

session_start();
if(isset($_SESSION["usuario"]))
	header("Location: painel");

?>

<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Site</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		<style>body{background-color: black}</style>
	</head>

	<body>
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="index">Início</a></li>
				<li><a href="equipe">Equipe</a></li>
			</ul>
		</div>
		<div id="login">
			<form id="formlogin" method="post" action="">
				<p class="form-title">Faça login para poder continuar</p>
				<input name="usuario" type="text" class="max-width" placeholder="Informe seu nome de usuário" required autofocus/>
				<input name="senha" type="password" class="max-width" placeholder="Informe sua senha" required/>
				<button class="btn btn-green max-width" type="submit">Logar</button>
			</form>
		</div>
		<footer>
			<span>Todos os direitos reservados &copy; Prisma</span>
			<span class="right">Desenvolvido por David Nery</span>
		</footer>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
	</body>

</html>