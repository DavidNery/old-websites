<?php

require_once "config/conexao.php";
$conexao = new Conexao();
$con = $conexao->connect();

session_start();
$query = null;
if(isset($_SESSION["usuario"])){
	$query = $con->prepare("SELECT * FROM permitidos WHERE nick=?");
	$query->bindParam(1, $_SESSION["usuario"]);
	$query->execute();
}

?>

<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Meu Servidor</title>

		<link rel="stylesheet" href="css/main.css">
	</head>

	<body>
		<div id="bgd"></div>
		<img class="logo" src="src/logo.png"/>
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="index.php">Início</a></li>
				<li><a href="#">Loja</a></li>
				<li><a href="punicoes.php">Punições</a></li>
				<li><a href="#">Fórum</a></li>
				<?php 

				if($query != null && $query->rowCount() > 0)
					echo '<li class="direita"><a href="painel/">Painel</a></li>';

				?>
			</ul>
		</div>
		<div class="container">
			<?php

			if(isset($_SESSION["usuario"]))
				echo '<div class="card"><div class="card-body">Logado como '.$_SESSION["usuario"].'<a href="logout.php" class="right">Sair</a></div></div>';

			?>
			<div class="card">
				<div class="card-body">
					<p class="title text-center">Loja</p>
					<div class="row">
						<?php

						if(isset($_SESSION["usuario"])):
						$query = $con->prepare("SELECT l.nome,l.descricao,b.texto,b.link,b.cor FROM lojaitems l, buttonsitems b WHERE b.itemId=l.id ORDER BY l.id");
						$query->execute();

						if($query->rowCount() > 0):
						$ultimoitem = null;
						while($linha = $query->fetch(PDO::FETCH_OBJ)):

						?>

						<?php

						if($ultimoitem != $linha->nome):
							if($ultimoitem != null) echo "</div></div></div>";
						?>
						<div class="col-4">
							<div class="loja-item">
								<div class="loja-item-body">
									<p class="title text-center"><?php echo $linha->nome ?></p>
									<?php echo $linha->descricao ?>
									<button class="btn btn-dark btn-block" data-modal="<?php echo str_replace(" ", "", $linha->nome) ?>">Detalhes</button>	

									<?php 

	$ultimoitem = $linha->nome;
										endif;
										echo '<a class="btn btn-'.$linha->cor.' btn-block" href="'.$linha->link.'" target="_blank">'.$linha->texto.'</a>';

									?>

								<?php 

								endwhile;
								echo "</div></div></div></div>";

								else:

								?>

								<h3 class="text-information-big text-center text-upper">Sem itens</h3>

								<?php endif; ?>

								<?php else: ?>
								<p class="title text-center">Informe seu nick</p>
								<div class="container">
									<form method="post" action="validaLoja.php">
										<input name="nick" type="text" class="maxwidth" placeholder="Coloque seu nick aqui" required autofocus/>
										<input name="senha" type="password" class="maxwidth" placeholder="Coloque sua senha aqui" required/>
										<?php

										if(isset($_SESSION["erro"])){
											echo '<div class="alert alert-danger">'.$_SESSION["erro"].'</div>';
											unset($_SESSION["erro"]);
										}

										?>
										<input type="submit" class="btn btn-green btn-block text-upper" value="Continuar"/>
									</form>
								</div>
								<?php endif; ?>
				</div>
			</div>
		</div>
		<div id="developed">Desenvolvido por <a href="#">David Nery</a></div>

		<?php

		if(isset($_SESSION["usuario"])):
		$query = $con->prepare("SELECT l.nome, m.titulo, m.conteudo FROM lojaitems l, modalitems m WHERE m.itemId=l.id");
		$query->execute();

		if($query->rowCount() > 0):
		$ultimoitem = null;
		while($linha = $query->fetch(PDO::FETCH_OBJ)):

		?>
		<div class="modal" id="<?php echo str_replace(" ", "", $linha->nome) ?>">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title"><?php echo $linha->titulo; ?></span>
				</div>
				<div class="modal-body">
					<?php echo $linha->conteudo; ?>
				</div>
			</div>
		</div>
		<?php endwhile; endif; endif;?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
	</body>

</html>