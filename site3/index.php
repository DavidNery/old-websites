<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Site</title>

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="#">Início</a></li>
				<li><a href="equipe">Equipe</a></li>
				<?php

				session_start();
				if(isset($_SESSION["usuario"]))
					echo '<li class="direita"><a href="painel">Painel</a></li>';
				else
					echo '<li class="direita"><a href="login">Login</a></li>';

				?>
			</ul>
		</div>
		<header>
			<div class="container">
				<div class="row center">
					<div class="col-6" style="padding: 25px 0">
						<h1>Prisma Build Team</h1>
						<p>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos. Lorem Ipsum sobreviveu não só a cinco séculos, como também ao salto para a editoração eletrônica, permanecendo essencialmente inalterado. Se popularizou na década de 60, quando a Letraset lançou decalques contendo passagens de Lorem Ipsum, e mais recentemente quando passou a ser integrado a softwares de editoração eletrônica como Aldus PageMaker.</p>
					</div>
					<div class="col-6">
						<img src="src/imgheader.png" class="img-responsive" alt="imgheader"/>
					</div>
				</div>
			</div>
		</header>
		<div id="postagens">
			<div class="container">
				<?php

				require_once "system/config.php";
				$conexao = new Conexao();
				$con = $conexao->connect();

				$query = $con->prepare("SELECT DISTINCT c.nome FROM postagemcategoria pc, categoria c WHERE pc.categoria=c.id");
				$query->execute();

				if($query->rowCount() > 0):

				$postagens = $con->prepare("SELECT p.*, c.nome FROM postagem p, categoria c, postagemcategoria pc WHERE pc.postagem=p.id AND pc.categoria=c.id ORDER BY p.id DESC");
				$postagens->execute();

				if($postagens->rowCount() > 0):

				?>
				<div class="categorias">
					<a href="#" data-categoria="all">Tudo</a>
					<?php

					while($linha = $query->fetch(PDO::FETCH_OBJ)){
						echo '<a href="#" data-categoria="'.$linha->nome.'">'.$linha->nome.'</a>';
					}

					?>
				</div>
				<div class="row">
					<?php 

					$id = null;
					while($linha = $postagens->fetch(PDO::FETCH_OBJ)):
					if($linha->id != $id):
					if($id != null) echo "</span></a></div>";
					$id = $linha->id;

					?>
					<div class="col-4">
						<a href="postagem/<?php echo $linha->id ?>" class="postagem" data-postagem-id="<?php echo $linha->id; ?>">
							<img src="pfoto/<?php echo $linha->id; ?>" alt="postagem"/>
							<div class="content">
								<p class="title"><?php echo $linha->titulo; ?></p>
								<p class="description"><?php echo $linha->descricao; ?></p>
							</div>
							<div class="statistics">
								<span class="views"><i class="fa fa-eye"></i> <?php echo $linha->views; ?></span>
							</div>
							<span class="item-categories">
								<?php

								endif;
								echo '<button data-categoria="'.$linha->nome.'">'.$linha->nome.'</button>';

								endwhile;

								?>
							</span>
						</a>
					</div>
				</div>
				<?php

				else:

				?>
				<img src="src/creeper.png" alt="nada"/>
				<h3>Sem postagens :(</h3>
				<?php

				endif;

				else:

				?>
				<img src="src/creeper.png" alt="nada"/>
				<h3>Sem categorias :(</h3>
				<?php

				endif;

				?>
			</div>
		</div>
		<footer>
			<span>Todos os direitos reservados &copy; Prisma</span>
			<span class="right">Desenvolvido por David Nery</span>
		</footer>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
		<script type="application/javascript">
			$(document).ready(function() {

				var categorias;
				$.get("listpostagens", function(response) {
					categorias = response.categorias;
				}, "json");

				$("[data-categoria]").click(function(e) {
					e.preventDefault();

					var categoria = $(this).data("categoria");

					if(categoria=="all"){
						$("[data-postagem-id]").each(function(i, e) {
							var row = $(e).parent();
							if(!$(e).is(":visible"))
								row.fadeIn(500, function() {
									row.css("display", "inline-block");
								});
						});
					}else{
						var json = JSON.stringify(categorias[categoria]);
						$("[data-postagem-id]").each(function(i, e) {
							if(json.indexOf($(e).data("postagem-id")) == -1){
								var row = $(e).parent();
								if($(e).is(":visible"))
									row.fadeOut(500, function() {
										row.css("display", "none");
									});
							}else{
								var row = $(e).parent();
								if(!$(e).is(":visible"))
									row.fadeIn(500, function() {
										row.css("display", "inline-block");
									});
							}
						});
					}

				});
			});
		</script>
	</body>

</html>