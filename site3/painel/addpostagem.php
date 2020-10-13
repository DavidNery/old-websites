<?php

session_start();
if(!isset($_SESSION["usuario"]))
	header("Location: ../login");

require_once "../system/config.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM categoria");
$query->execute();

if($query->rowCount() == 0)
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
		<link rel="stylesheet" href="/site4/painel/css/jquery-te-1.4.0.css">
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
				<p class="card-title">Nova postagem</p>
				<div class="card-body">
					<form id="novapostagem" method="post" action="" enctype="multipart/form-data">
						<input name="titulo" type="text" class="max-width" placeholder="Informe o título da postagem." required autofocus/>
						<textarea id="conteudo" name="conteudo" class="max-width" placeholder="Informe o conteúdo da postagem." required></textarea>
						<input name="descricao" type="text" class="max-width" placeholder="Informe a descrição da postagem." required/>
						<div class="input-group">
							<span class="input-group-addon">Selecione as categorias</span>
							<?php

							$query = $con->prepare("SELECT * FROM categoria");
							$query->execute();

							while($linha = $query->fetch(PDO::FETCH_OBJ)){
								echo '<input name="categoria[]" type="checkbox" value="'.$linha->id.'"/> '.$linha->nome.'<br/>';
							}

							?>
						</div>
						<div class="input-group">
							<span class="input-group-addon">Selecione a foto principal</span>
							<input name="foto" type="file" class="max-width" title="Selecione a imagem da postagem" required/>
						</div>
						<button type="submit" class="btn btn-green max-width">Adicionar</button>
					</form>
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
		<script src="/site4/painel/js/jquery-te-1.4.0.min.js"></script>
		<script type="application/javascript">
			$(document).ready(function() {

				$("#conteudo").jqte();

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