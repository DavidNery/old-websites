<?php

session_start();
if(!isset($_SESSION["usuario"]) || !isset($_GET["id"]))
	header("Location: ../login");

require_once "../system/config.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM usuario WHERE id=?");
$query->bindParam(1, $_GET["id"]);
$query->execute();

if($query->rowCount() == 0)
	header("Location: equipe");

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
				<div class="card-title">Editando usuario <?php echo $linha->nome; ?></div>
				<div class="card-body">
					<div class="row">
						<div class="col-6">
							<div class="foto-change" data-user="<?php echo $linha->id; ?>">
								<img src="/site4/foto/<?php echo $linha->id; ?>" alt="Foto perfil"/>
								<span class="foto-click">Alterar</span>
								<input class="userphoto" type="file" accept=".jpg,.jpeg,.png"/>
							</div>
						</div>
						<div class="col-6">
							<form id="formEditarUsuario" class="no-style" method="post" action="">
								<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>"/>
								<div class="input-group">
									<span class="input-group-addon">Nome</span>
									<input name="nome" type="text" value="<?php echo $linha->nome; ?>" class="max-width" placeholder="Informe o nome do usuário" required autofocus/>
								</div>
								<div class="input-group">
									<span class="input-group-addon">Email</span>
									<input name="email" type="email" value="<?php echo $linha->email; ?>" class="max-width" placeholder="Informe o email do usuário" required/>
								</div>
								<div class="input-group">
									<span class="input-group-addon">Senha</span>
									<input name="senha" type="password" value="<?php echo $linha->senha; ?>" class="max-width" placeholder="Informe a senha do usuário" required/>
								</div>
								<div class="input-group">
									<span class="input-group-addon">Frase</span>
									<input name="frase" type="text" value="<?php echo $linha->frase; ?>" class="max-width" placeholder="Informe a frase do usuário" required/>
								</div>
								<button type="submit" class="btn max-width btn-green">Salvar</button>
							</form>
						</div>
					</div>
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