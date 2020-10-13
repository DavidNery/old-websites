<?php

session_start();
if(!isset($_SESSION["usuario"]))
	header("Location: ../login");

?>

<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Site</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/site4/css/style.css">
		<link rel="stylesheet" href="/site4/painel/css/painel.css">
	</head>

	<body>
		<div class="nav lateral">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<span class="perfil">
					<span class="foto"><img src="/site4/foto/<?php echo $_SESSION["usuario"]; ?>" alt="perfil"/></span>
					<p>Bem vindo(a), <?php echo $_SESSION["nome"]; ?></p>
				</span>
				<li><a href="/site4/painel"><i class="fa fa-home fa-fw"></i> Início</a></li>
				<li><a href="/site4/painel/categorias"><i class="fa fa-list fa-fw"></i> Categorias</a></li>
				<li><a href="/site4/painel/postagens"><i class="fa fa-cubes fa-fw"></i> Postagens</a></li>
				<li><a href="/site4/painel/equipe"><i class="fa fa-users fa-fw"></i> Equipe</a></li>
				<li><a href="/site4/painel/logout"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
			</ul>
		</div>
		<div id="content">
			<div class="card">
				<p class="card-title">Categorias</p>
				<div class="card-body">
					<?php

					require_once "../system/config.php";
					$conexao = new Conexao();
					$con = $conexao->connect();

					$query = $con->prepare("SELECT c.*, (SELECT COUNT(*) FROM postagemcategoria WHERE categoria=c.id) quantidade FROM categoria c");
					$query->execute();

					if($query->rowCount() > 0):

					?>
					<ul class="item-list">
						<?php

						while($linha=$query->fetch(PDO::FETCH_OBJ)):

						?>
						<li class="item">
							<span><?php echo $linha->nome; ?></span>
							<i class="fa fa-angle-down fa-fw right"></i>
							<form class="item-content" method="post" action="">
								<div class="information">
									<span class="key">Postagens nessa categoria: </span>
									<span class="value"><?php echo $linha->quantidade; ?></span>
								</div>
								<input name="id" type="hidden" value="<?php echo $linha->id; ?>"/>
								<input name="nome" type="text" class="max-width" value="<?php echo $linha->nome; ?>" placeholder="Informe o nome da categoria."/>
								<div class="row">
									<div class="col-6"><button type="submit" class="btn btn-blue max-width">Salvar</button></div>
									<div class="col-6"><a href="apagarcategoria/<?php echo $linha->id; ?>" class="btn btn-red max-width">Apagar</a></div>
								</div>
							</form>
						</li>
						<?php

						endwhile;
						echo '</ul>';
						else:

						?>
						<span class="nada">Sem categorias :(</span>
						<?php

						endif;

						?>
						<a href="addcategoria" class="btn btn-blue max-width"><i class="fa fa-plus"></i> Nova categoria</a>
					</div>
				</div>
				<footer>
					<span>Todos os direitos reservados &copy; Prisma</span>
					<span class="right">Desenvolvido por David Nery</span>
				</footer>
			</div>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
			<script src="/site4/js/main.js"></script>
			<script src="/site4/painel/js/painel.js"></script>
			<script type="application/javascript">
				$(document).ready(function() {

					$("#content").css("width", "calc(100% - "+$(".nav").first().outerWidth()+"px)");
					if($(window).width() >= 769) $(".nav").first().css("height", $("#content").outerHeight() + "px");

					$(window).resize(function() {
						if($(window).width() >= 769){
							$("#content").css("width", "calc(100% - "+$(".nav").first().outerWidth()+"px)");
							$(".nav").first().css("height", $("#content").outerHeight() + "px");
						}else{
							$(".nav").first().css("height", "auto");
						}
					});

				});
			</script>
			</body>

		</html>