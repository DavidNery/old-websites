<?php

session_start();
if(!isset($_SESSION["usuario"])) header("Location: /");

?>


<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php require "../config/site_config.php"; echo $config["titulo"]; ?></title>

		<script src="../js/fontawesome-all.js"></script>

		<link rel="shortcut icon" href="../src/logo.png">

		<link rel="stylesheet" href="../css/style.css">
	</head>

	<body>
		<div class="container">
			<div id="content">
				<header>
					<div class="container">
						<img width="75px" height="75px" src="../src/logo.png" alt="logo.png">
						<nav class="nav">
							<button class="toggle"><i class="fas fa-bars fa-2x"></i></button>
							<ul class="navbar">
								<li><a href="/admin"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a class="active" href="regras"><i class="fas fa-book"></i> Regras</a></li>
								<li><a href="sair"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Painel do Admin</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<div style="padding: 20px">
					<div class="container">
						<?php
						
						require "../config/conexao.php";
						$con = Conexao::returnConnection();
						$query = $con->prepare("SELECT * FROM regras");
						$query->execute();

						if($query->rowCount() == 0):
						echo '<p class="subtitle"><span>Sem regras criadas :(</span></p>';
						else:
						echo '<p class="subtitle"><span>Regras</span></p>';
						echo '<div class="row">';

						while($row = $query->fetch(PDO::FETCH_OBJ)):
						?>
						<div class="col-6">
							<div class="card toggler">
								<div class="card-title">
									<p class="title"><?php echo $row->nome; ?></p>
									<span class="toggle"><i class="fas fa-angle-down"></i></span>
								</div>
								<div class="card-body">
									<?php echo $row->descricao; ?>
									<a href="apagarregra.php?regraid=<?php echo $row->id; ?>" class="btn btn-red block">Apagar</a>
								</div>
							</div>
						</div>
						<?php

						endwhile;
						echo '</div>';
						endif;
						echo '<button target-type="modal" target="modalnovaregra" class="btn btn-green block">Criar regra</button>';
						?>
					</div>
				</div>
				<footer>
					<div class="container">
						<span>BackNetwork &copy;, 2018. Fazendo o melhor para você!</span>
						<span class="author"><i class="fas fa-code"></i> Desenvolvido por <a target="_blank" href="https://twitter.com/davidnery_">David Nery</a></span>
					</div>
				</footer>
			</div>
		</div>

		<div id="modalnovaregra" class="modal">
			<div class="modal-content">
				<div class="modal-title">
					<p class="title">Cadastrar nova regra</p>
				</div>
				<div class="modal-body">
					<form method="post" action="novaregra">
						<input type="text" name="nome" class="form-control block" placeholder="Informe o nome da regra" required autofocus/>
						<textarea name="descricao" class="form-control block" placeholder="Informe a descrição" required></textarea>
						<input type="submit" class="btn btn-orange block" value="Cadastrar"/>
					</form>
				</div>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/main.js"></script>

	</body>

</html>