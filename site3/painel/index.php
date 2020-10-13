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
			<div class="row">
				<div class="col-6">
					<div class="card">
						<p class="card-title">Suas informações</p>
						<div class="card-body">
							<div class="foto-change">
								<img src="/site4/foto/<?php echo $_SESSION["usuario"]; ?>" alt="perfil"/>
								<span class="foto-click">Alterar</span>
								<input class="userphoto" type="file" accept=".jpg,.jpeg,.png"/>
							</div>
							<div class="information">
								<span class="key">Nome: </span>
								<span class="value"><?php echo $_SESSION["nome"]; ?></span>
							</div>
							<div class="information">
								<span class="key">Email: </span>
								<span class="value"><?php echo $_SESSION["email"]; ?></span>
							</div>
						</div>
					</div>
					<div class="card">
						<p class="card-title">Alterar senha</p>
						<div class="card-body">
							<form id="formcp" method="post" action="">
								<input type="password" name="csenha" class="max-width" placeholder="Informe sua senha atual" required/>
								<input type="password" name="nsenha" class="max-width" placeholder="Informe a nova senha" required/>
								<input type="password" name="nsenhan" class="max-width" placeholder="Repita a nova senha" required/>
								<button type="submit" class="btn btn-blue max-width">Alterar</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card">
						<p class="card-title">Últimas postagens</p>
						<div class="card-body">
							<?php

							require_once "../system/config.php";
							$conexao = new Conexao();
							$con = $conexao->connect();

							$query = $con->prepare("SELECT p.*, u.nome FROM postagem p, usuario u WHERE p.usuario=u.id ORDER BY p.id DESC LIMIT 3");
							$query->execute();

							if($query->rowCount() > 0):
							?>
							<div style="overflow-x: auto">
								<table style="width: 100%">
									<thead>
										<tr>
											<th>Título</th>
											<th>Views</th>
											<th>Data</th>
											<th>Postado</th>
										</tr>
									</thead>
									<tbody>
										<?php

										while($linha=$query->fetch(PDO::FETCH_OBJ)){
											echo '<tr>
										<td><a href="/site4/postagem/'.$linha->id.'">'.$linha->titulo.'</a></td>
										<td>'.$linha->views.'</td>
										<td>'.date("H:i:s d/m/Y", strtotime($linha->postado)).'</td>
										<td>'.$linha->nome.'</td>
										</tr>';
										}

										?>
									</tbody>
								</table>
							</div>
							<?php
							else:
							echo '<p class="nada">Sem postagens</p>';
							endif;

							?>
						</div>
					</div>
					<div class="card">
						<p class="card-title">Postagens mais vistas</p>
						<div class="card-body">
							<?php

							require_once "../system/config.php";
							$conexao = new Conexao();
							$con = $conexao->connect();

							$query = $con->prepare("SELECT p.*, u.nome FROM postagem p, usuario u WHERE p.usuario=u.id ORDER BY p.views DESC LIMIT 5");
							$query->execute();

							if($query->rowCount() > 0):
							?>
							<div style="overflow-x: auto">
								<table style="width: 100%">
									<thead>
										<tr>
											<th>Título</th>
											<th>Views</th>
											<th>Data</th>
											<th>Postado</th>
										</tr>
									</thead>
									<tbody>
										<?php

										while($linha=$query->fetch(PDO::FETCH_OBJ)){
											echo '<tr>
										<td><a href="/site4/postagem/'.$linha->id.'">'.$linha->titulo.'</a></td>
										<td>'.$linha->views.'</td>
										<td>'.date("H:i:s d/m/Y", strtotime($linha->postado)).'</td>
										<td>'.$linha->nome.'</td>
										</tr>';
										}

										?>
									</tbody>
								</table>
							</div>
							<?php
							else:
							echo '<p class="nada">Sem postagens</p>';
							endif;

							?>
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