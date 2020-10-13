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
								<li><a class="active" href="#"><i class="fas fa-home"></i> Início</a></li>
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a href="equipe"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Bem-vindo(a)!</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<div style="padding: 20px">
					<div class="container">
						<div class="subtitle"><span>Por que jogar em nosso servidor?</span></div>
						<div class="row" style="text-align: center">
							<div class="col-4">
								<div class="card">
									<div class="card-title">
										<i class="fas fa-gamepad fa-4x"></i><br/>
										<p class="title">Jogabilidade!</p>
									</div>
									<div class="card-body">
										Contamos com máquinas potentes, capazes de fornecer o menor lag e melhor jogabilidade possível a você!
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="card">
									<div class="card-title">
										<i class="fas fa-lock fa-4x"></i><br/>
										<p class="title">Segurança!</p>
									</div>
									<div class="card-body">
										Desenvolvemos sistemas que garantem que ninguém além de você entrará em sua conta sem a sua permissão!
									</div>
								</div>
							</div>
							<div class="col-4">
								<div class="card">
									<div class="card-title">
										<i class="fas fa-heart fa-4x"></i><br/>
										<p class="title">Ajuda!</p>
									</div>
									<div class="card-body">
										Nossa staff estará sempre disposta a ajudar você no que precisar, por tanto não tenha vergonha, contate-os!
									</div>
								</div>
							</div>
						</div>
						<div class="subtitle"><span>Meios de contato</span></div>
						<div class="row" style="text-align: center">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<i class="fab fa-twitter-square fa-4x"></i><br/>
										<p class="title">Twitter</p>
									</div>
									<div class="card-body" style="text-align: center">
										<a target="_blank" href="https://twitter.com/ServidorBackMC">@ServidorBackMC</a>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<i class="fas fa-envelope-square fa-4x"></i><br/>
										<p class="title">Email</p>
									</div>
									<div class="card-body" style="text-align: center">
										<a href="mailto:servidorbackcraft@hotmail.com">servidorbackcraft@hotmail.com</a>
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