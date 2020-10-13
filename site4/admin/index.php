<?php

session_start();

require "../config/conexao.php";
$con = null;

if(isset($_POST["usuario"]) && isset($_POST["senha"])){

	if(isset($_SESSION["tentativaslogin"]) && $_SESSION["tentativaslogin"] > 3 && 
	   (isset($_SESSION["novatentativa"]) ? ($_SESSION["novatentativa"]>time()) : true)){
		if($_SESSION["tentativaslogin"] == 4){
			$_SESSION["novatentativa"] = time() + 600;
			$_SESSION["tentativaslogin"]++;
		}

		function getTime($time) {
			$minutos = floor($time / 60);
			$segundos = floor($time % 60);

			return ($minutos > 0 ? $minutos." minutos e " : "") . $segundos . " segundos";
		}

		$_SESSION["error"] = "Aguarde para logar novamente em " . getTime($_SESSION["novatentativa"]-time()) . " segundos!";
	}else{
		if(isset($_SESSION["tentativaslogin"]) && $_SESSION["tentativaslogin"] > 3){
			unset($_SESSION["tentativaslogin"]);
			unset($_SESSION["novatentativa"]);
		}
		$con = Conexao::returnConnection();

		$query = $con->prepare("SELECT * FROM usuarios WHERE nome=? AND senha=MD5(?)");
		$query->bindParam(1, $_POST["usuario"]);
		$query->bindParam(2, $_POST["senha"]);
		$query->execute();

		echo $query->rowCount();

		if($query->rowCount() > 0){
			$_SESSION["usuario"] = $query->fetch(PDO::FETCH_OBJ)->nome;
		}else{
			$_SESSION["tentativaslogin"] = (isset($_SESSION["tentativaslogin"]) ? $_SESSION["tentativaslogin"]+1 : 2);
			$_SESSION["error"] = "Usuário / senha incorretos!";
		}
	}

}

?>


<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php require "../config/site_config.php"; echo $config["titulo"]; ?></title>

		<script src="../js/fontawesome-all.js"></script>

		<link rel="shortcut icon" href="../src/logo.png">

		<link rel="stylesheet" href="../css/style.css">
	</head>

	<body>
		<div class="container">
			<div id="content">
				<header>
					<div class="container">
						<img width="75px" height="75px" src="../src/logo.png" alt="logo.png">
						<nav class="nav">
							<button class="toggle"><i class="fas fa-bars fa-2x"></i></button>
							<ul class="navbar">
								<?php if(isset($_SESSION["usuario"])): ?>
								<li><a class="active" href="#"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
								<li><a href="sair"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
								<?php else: ?>
								<li><a href="/"><i class="fas fa-home"></i> Início</a></li>
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a href="equipe"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
								<?php endif; ?>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Painel do Admin</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<div style="padding: 20px">
					<div class="container">
						<?php 

						if(isset($_SESSION["usuario"])):
						if(isset($_SESSION["tentativaslogin"])){
							unset($_SESSION["tentativaslogin"]);
							if($_SESSION["novatentativa"] > 3) unset($_SESSION["novatentativa"]);
						}

						if($con == null) $con = Conexao::returnConnection();
						$query = $con->prepare("SELECT * FROM cargos");
						$query->execute();
						
						$cargos = array();

						if($query->rowCount() == 0):
						echo '<p class="subtitle"><span>Sem cargos criados :(</span></p>';
						else:
						echo '<p class="subtitle"><span>Cargos</span></p>';

						while($row = $query->fetch(PDO::FETCH_OBJ)):
							$cargos[] = array($row->id, $row->nome);
						?>
						<div class="card<?php echo ($row->cor != "" ? " card-".$row->cor : ""); ?>">
							<div class="card-title">
								<p class="title">
									<?php echo $row->nome; ?>
								</p>
								<a href="apagarcargo.php?cargoid=<?php echo $row->id; ?>" class="right">Apagar</a>
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
									<a href="apagarusuario.php?userid=<?php echo $row2->id; ?>" class="btn btn-<?php echo ($row->cor != "" ? $row->cor : "orange"); ?> block">Remover</a>
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
						echo '<button target-type="modal" target="modalnovousuario" class="btn btn-blue block">Cadastrar usuário</button>';
						echo '<button target-type="modal" target="modalnovocargo" class="btn btn-green block">Criar cargo</button>';
						else: 

						?>
						<div style="display: inline-block" class="subtitle"><span>Sem acesso</span></div>
						<div class="card">
							<div class="card-title">
								<p class="title">Faça login com seu usuário e senha de admin</p>
							</div>
							<div class="card-body">
								<form method="post" action="">
									<input type="text" name="usuario" class="form-control block" placeholder="Informe seu usuário de admin" required autofocus autocomplete="off"/>
									<input type="password" name="senha" class="form-control block" placeholder="Informe sua senha de admin" required/>
									<?php if(isset($_SESSION["error"])): ?>
									<div class="alert alert-danger"><?php echo $_SESSION["error"]; ?></div>
									<?php 

									unset($_SESSION["error"]);
									endif;

									?>
									<input type="submit" class="btn btn-orange block" value="Logar"/>
								</form>
							</div>
						</div>
						<?php endif; ?>
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

		<?php if(isset($_SESSION["usuario"])): ?>
		<div id="modalnovousuario" class="modal">
			<div class="modal-content">
				<div class="modal-title">
					<p class="title">Cadastrar novo usuário</p>
				</div>
				<div class="modal-body">
					<form method="post" action="novousuario">
						<input type="text" name="usuario" class="form-control block" placeholder="Informe o nome do staff" required autofocus autocomplete="off"/>
						<select name="cargo" class="form-control block" required>
							<?php
							
							if(count($cargos) > 0){
								foreach($cargos as $cargo)
										echo '<option value='.$cargo[0].'>'.$cargo[1].'</option>';
							}else{
								echo 'Sem cargos :(';
							}
							
							?>
						</select>
						<input type="submit" class="btn btn-orange block" value="Cadastrar"/>
					</form>
				</div>
			</div>
		</div>
		<div id="modalnovocargo" class="modal">
			<div class="modal-content">
				<div class="modal-title">
					<p class="title">Cadastrar novo cargo</p>
				</div>
				<div class="modal-body">
					<form method="post" action="novocargo">
						<input type="text" name="nome" class="form-control block" placeholder="Informe o nome do cargo" required autofocus autocomplete="off"/>
						<select name="cor" class="form-control block" required>
							<option value="">Laranja</option>
							<option value="green">Verde</option>
							<option value="red">Vermelho</option>
							<option value="yellow">Amarelo</option>
							<option value="blue">Azul</option>
							<option value="purple">Roxo</option>
						</select>
						<input type="submit" class="btn btn-orange block" value="Cadastrar"/>
					</form>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/main.js"></script>

	</body>

</html>