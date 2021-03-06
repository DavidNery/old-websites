<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php require "config/site_config.php"; echo $config["titulo"]; ?></title>

		<script src="js/fontawesome-all.js"></script>

		<link rel="shortcut icon" href="src/logo.png">

		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="container">
			<div id="content">
				<header>
					<div class="container">
						<img width="75px" height="75px" src="src/logo.png" alt="logo.png">
						<nav class="nav">
							<button class="toggle"><i class="fas fa-bars fa-2x"></i></button>
							<ul class="navbar">
								<li><a href="/"><i class="fas fa-home"></i> Início</a></li>
								<li><a class="active" href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a href="equipe"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Loja oficial!</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<div style="padding: 20px">
					<div class="container">
						<?php

						require "config/conexao.php";
						$con = Conexao::returnConnection();
						$query = $con->prepare("SELECT * FROM loja");
						$query->execute();

						if($query->rowCount() == 0):
						echo '<p class="subtitle"><span>Sem servidores :(</span></p>';
						else:
						echo '<div style="display: inline-block" class="subtitle"><span>Escolha um servidor</span></div>';
						echo '<div class="row" style="text-align: center">';

						while($row = $query->fetch(PDO::FETCH_OBJ)):
						?>
						<div class="col-6">
							<div class="card">
								<div class="card-title">
									<?php
									
									if($row->imagem != ""):
									
									?>
									<img class="img-responsive" src="<?php echo $row->imagem; ?>" alt="<?php echo $row->nome; ?>"/><br/>
									<?php endif; ?>
									<p class="title"><?php echo $row->nome; ?></p>
								</div>
								<div class="card-body">
									<a href="<?php echo $row->link; ?>" style="text-align: center" class="btn btn-orange block">Ir a loja</a>
								</div>
							</div>
						</div>
						<?php

						endwhile;
						echo '</div>';
						endif;
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


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>

	</body>

</html>