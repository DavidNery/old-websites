<?php

if(!isset($_GET["id"]))
	header("Location: /site4");

require_once "system/config.php";

$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM postagem WHERE id=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

if($query->rowCount() == 0)
	header("Location: /site4");

session_start();
if(!isset($_SESSION["view".$_GET["id"]])){
	$query = $con->prepare("UPDATE postagem SET views=views+1 WHERE id=?");
	$query->bindParam(1, $_GET["id"]);
	$query->execute();
	$_SESSION["view".$_GET["id"]] = time();
}

$query = $con->prepare("SELECT p.*, u.nome, c.nome categoria FROM postagem p, usuario u, postagemcategoria pc, categoria c WHERE p.id=? AND u.id=p.usuario AND pc.postagem=p.id AND pc.categoria=c.id");
$query->bindParam(1, $_GET["id"]);
$query->execute();

$linha = $query->fetch(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Site</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/site4/css/style.css">
		<style>
			.img-postagem {
				float: left; 
				margin-right: 10px;
				width: 75px;
				height: 75px;
			}

			@media screen and (max-width: 425px) {
				.img-postagem {
					width: 100%;
					height: 100%;
					margin: 0;
					float: none;
				}
			}
		</style>
	</head>

	<body style="background-color: black">
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="/site4">Início</a></li>
				<li><a href="/site4/equipe">Equipe</a></li>
				<?php

				if(isset($_SESSION["usuario"]))
					echo '<li class="direita"><a href="/site4/painel">Painel</a></li>';
				else
					echo '<li class="direita"><a href="/site4/login">Login</a></li>';

				?>
			</ul>
		</div>
		<div id="postagens">
			<div class="container">
				<div class="card">
					<div class="card-title" style="background: url('/site4/src/navbg.png') repeat; color: white">
						<img class="img-postagem" src="/site4/foto/<?php echo $linha->id; ?>" alt="postado"/>
						<p style="margin: 0"><?php echo $linha->titulo; ?></p>
						<p class="post-info">
							<span class="post-key">Postado por:</span>
							<span class="post-value"><?php echo $linha->nome; ?></span>
						</p>
						<p class="post-info">
							<span class="post-key">Views:</span>
							<span class="post-value"><?php echo $linha->views; ?></span>
						</p>
						<p class="post-info">
							<span class="post-key">Categorias:</span>
							<span class="post-value">
								<?php

								$conteudo = $linha->conteudo;
								echo $linha->categoria;
								while($linha = $query->fetch(PDO::FETCH_OBJ))
									echo ", ".$linha->categoria;

								?>
							</span>
						</p>
					</div>
					<div class="card-body">
						<?php

						echo $conteudo;

						?>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<span>Todos os direitos reservados &copy; Prisma</span>
			<span class="right">Desenvolvido por David Nery</span>
		</footer>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="/site4/js/main.js"></script>
		<script type="application/javascript">

			$(document).ready(function() {
				$(".card-body").first().find("img").each(function(i, e) {
					if(!$(e).hasClass("img-responsive")) $(e).addClass("img-responsive");
				});
			});

		</script>
	</body>

</html>