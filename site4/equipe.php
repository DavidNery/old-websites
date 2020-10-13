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
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a class="active" href="equipe"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Equipe oficial</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<div style="padding: 20px">
					<div class="container">
						<div class="row">
							<div class="col-9">
								<?php

								require "config/conexao.php";
								$con = Conexao::returnConnection();
								$query = $con->prepare("SELECT * FROM cargos c");
								$query->execute();

								if($query->rowCount() == 0):
								echo '<p class="subtitle"><span>Sem cargos criados :(</span></p>';
								else:

								while($row = $query->fetch(PDO::FETCH_OBJ)):
								?>
								<div class="card<?php echo ($row->cor != "" ? " card-".$row->cor : ""); ?>">
									<div class="card-title">
										<p class="title"><?php echo $row->nome; ?></p>
									</div>
									<div class="card-body">
										<?php

										$query2 = $con->prepare("SELECT * FROM equipe WHERE cargo=".$row->id);
										$query2->execute();

										if($query2->rowCount() == 0):
										echo "Sem usuários";
										else:
										while($row2 = $query2->fetch(PDO::FETCH_OBJ)):

										?>
										<div class="user">
											<img src="https://minotar.net/helm/<?php echo $row2->usuario; ?>/100.png" alt="<?php echo $row2->usuario; ?>.png">
											<p class="nick"><?php echo $row2->usuario; ?></p>
										</div>
										<?php

										endwhile;
										endif;

										?>
									</div>
								</div>
								<?php

								endwhile;
								endif;

								?>
							</div>
							<div class="col-3">
								<div class="card">
									<div class="card-title">
										<p class="title">Faça parte!</p>
									</div>
									<div class="card-body">
										Já pensou em fazer parte da nossa equipe? Você pode!
										<a href="#" class="btn btn-orange block">Clique aqui!</a>
									</div>
								</div>
							</div>
						</div>
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