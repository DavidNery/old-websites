<?php

require_once "config/conexao.php";
$conexao = new Conexao();
$con = $conexao->connect();

session_start();
$query = null;
if(isset($_SESSION["usuario"])){
	$query = $con->prepare("SELECT * FROM permitidos WHERE nick=?");
	$query->bindParam(1, $_SESSION["usuario"]);
	$query->execute();
}

?>

<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Meu Servidor</title>

		<link rel="stylesheet" href="css/main.css">
	</head>

	<body>
		<div id="bgd"></div>
		<img class="logo" src="src/logo.png"/>
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="#">Início</a></li>
				<li><a href="loja">Loja</a></li>
				<li><a href="punicoes">Punições</a></li>
				<li><a href="#">Fórum</a></li>
				<?php 

				if($query != null && $query->rowCount() > 0)
					echo '<li class="direita"><a href="painel/">Painel</a></li>';

				?>
			</ul>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-8">
					<?php

					$query = $con->prepare("SELECT * FROM noticias ORDER BY id DESC");
					$query->execute();
					if($query->rowCount() > 0){
						while($linha = $query->fetch(PDO::FETCH_OBJ)){
							echo '<div class="noticia">
						<div class="noticia-body">
							<p class="title">'.$linha->title.'</p>
							<div class="noticia-content">'.$linha->content.'</div>
							<p class="posted">Postado por '.$linha->author.' em '.date_format(date_create($linha->data), "d/m/Y").'</p>
						</div>
					</div>';
						}
					}else{
					?>

					<h3 class="text-information-big text-center text-upper">Sem notícias</h3>

					<?php
					}

					?>
				</div>
				<div class="col-4">
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Players ON</p>
							Temos <span id="playerson">0/100</span> players on!
							<button class="btn btn-green btn-block text-upper" tooltip-text="Clique para copiar o IP do servidor!" onclick="copyIp($(this), 'jogar.biglandia.com')">Copiar IP</button>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Um card</p>
							Escrevemos qualquer coisa aqui, VDC!
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<p class="title text-center">TOP Money</p>
							<div class="responsive">
								<table>
									<thead>
										<tr>
											<th>#</th>
											<th>Nick</th>
											<th>Money</th>
										</tr>
									</thead>
									<tbody>
										<?php

										require_once "config/conexao.php";
										$conexao = new Conexao();
										$con = $conexao->connectServidor();

										$pos = 1;
										$query = $con->prepare("SELECT mb.balance, ma.name FROM money_account ma, money_balance mb WHERE ma.id=mb.username_id ORDER BY mb.balance DESC LIMIT 10");
										$query->execute();

										while($linha = $query->fetch(PDO::FETCH_OBJ)){
											echo "<tr>
										<td>$pos</td>
										<td>{$linha->name}</td>
										<td>".number_format($linha->balance, 2, ",", ".")."</td>
									</tr>";
											$pos++;
										}

										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="developed">Desenvolvido por <a href="#">David Nery</a></div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				"use strict";

				var playerson = $("#playerson");
				var http = new XMLHttpRequest();

				http.onreadystatechange = function() {
					if(this.status == 200 && this.readyState == 4){
						var json = JSON.parse(this.responseText).players;
						if(json != undefined) playerson.html(json.online + "/" + json.max);
					}
				};

				function requestPlayers() {
					http.abort();
					http.open("GET", "https://mcapi.ca/query/jogar.rocketmc.com.br/players", true);
					http.send();
					setTimeout(requestPlayers, 5000);
				}

				requestPlayers();
			});
		</script>
		<script src="js/main.js"></script>
	</body>

</html>