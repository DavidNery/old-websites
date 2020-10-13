<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Site</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
		<style>body {background-color: black}</style>
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
				<li><a href="#">Equipe</a></li>
				<?php

				session_start();
				if(isset($_SESSION["usuario"]))
					echo '<li class="direita"><a href="painel">Painel</a></li>';
				else
					echo '<li class="direita"><a href="login">Login</a></li>';

				?>
			</ul>
		</div>
		<div id="equipe">
			<img src="src/nuvem.png" alt="img" class="nuvem" style="top: 20%; left: 10%"/>
			<img src="src/nuvem.png" alt="img" class="nuvem" style="top: 25%; right: 10%"/>

			<h1>Equipe</h1>
			<p>A equipe do Prisma Build Team é composta por integrantes bastante qualificados, todos prontos para lhe ajudar no que der e vier! Que tal nos conhecer? Veja-nos abaixo!</p>
			<?php

			require_once "system/config.php";
			$conexao = new Conexao();
			$con = $conexao->connect();

			$query = $con->prepare("SELECT * FROM usuario");
			$query->execute();

			if($query->rowCount() > 0):
			echo '<div class="integrantes">';
			while($linha=$query->fetch(PDO::FETCH_OBJ)):

			?>
				<div class="integrante">
					<p class="nome"><?php echo $linha->nome; ?></p>
					<span class="foto"><img src="foto/<?php echo $linha->id; ?>" alt="integrante"/></span>
					<p class="sobre"><?php echo $linha->frase; ?></p>
				</div>

			<?php

			endwhile;
			echo '</div>';
			else:

			?>
			<img src="src/creeper.png" alt="nada"/>
			<h3>Ninguém cadastrado :(</h3>
			<?php

			endif;

			?>
		</div>
		<footer>
			<span>Todos os direitos reservados &copy; Prisma</span>
			<span class="right">Desenvolvido por David Nery</span>
		</footer>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
	</body>

</html>