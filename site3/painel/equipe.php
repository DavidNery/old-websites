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
				<li><a href="/site4/painel/"><i class="fa fa-home fa-fw"></i> Início</a></li>
				<li><a href="/site4/painel/categorias"><i class="fa fa-list fa-fw"></i> Categorias</a></li>
				<li><a href="/site4/painel/postagens"><i class="fa fa-cubes fa-fw"></i> Postagens</a></li>
				<li><a href="/site4/painel/equipe"><i class="fa fa-users fa-fw"></i> Equipe</a></li>
				<li><a href="/site4/painel/logout"><i class="fa fa-sign-out fa-fw"></i> Sair</a></li>
			</ul>
		</div>
		<div id="content">
			<div class="card">
				<p class="card-title">Equipe</p>
				<div class="card-body">
					<?php

					require_once "../system/config.php";
					$conexao = new Conexao();
					$con = $conexao->connect();

					$query = $con->prepare("SELECT id, nome, email FROM usuario");
					$query->execute();

					?>
					<div style="overflow-x: auto; margin-bottom: 10px">
						<table style="width: 100%">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Email</th>
									<th>Editar</th>
									<th>Apagar</th>
								</tr>
							</thead>
							<tbody>
								<?php

								while($linha = $query->fetch(PDO::FETCH_OBJ)):

								?>
								<tr>
									<td><?php echo $linha->nome; ?></td>
									<td><?php echo $linha->email; ?></td>
									<td><a href="editusuario/<?php echo $linha->id; ?>" class="btn max-width btn-green">Editar</a></td>
									<td><a href="apagarusuario/<?php echo $linha->id; ?>" class="btn max-width btn-red">Deletar</a></td>
								</tr>
								<?php

								endwhile;

								?>
							</tbody>
						</table>
					</div>
					<a href="addusuario" class="btn btn-blue max-width"><i class="fa fa-plus"></i> Novo membro</a>
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