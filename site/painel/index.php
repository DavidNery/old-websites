<?php

session_start();
if(!isset($_SESSION["usuario"])){
	header("Location: ../");
	return;
}

require_once "../config/conexao.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT * FROM permitidos WHERE nick=?");
$query->bindParam(1, $_SESSION["usuario"]);
$query->execute();

if($query->rowCount() == 0){
	header("Location: ../");
	return;
}

?>
<!doctype html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Meu Servidor - Painel</title>

		<link rel="stylesheet" href="../css/main.css">
		<link rel="stylesheet" href="css/jquery-te-1.4.0.css">
	</head>

	<body>
		<div id="bgd"></div>
		<img class="logo" src="../src/logo.png"/>
		<div class="nav">
			<button class="toggle direita">
				<span></span>
				<span></span>
				<span></span>
			</button>
			<ul class="navbar">
				<li><a href="../index.php">Início</a></li>
				<li><a href="../loja.php">Loja</a></li>
				<li><a href="../punicoes.php">Punições</a></li>
				<li><a href="#">Fórum</a></li>
			</ul>
		</div>
		<div class="container">
			<?php

			echo '<div class="card"><div class="card-body">Logado como '.$_SESSION["usuario"].'<a href="../logout.php" class="right">Sair</a></div></div>';

			?>
			<div class="row">
				<div class="col-6">
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Items da loja</p>
							<button class="btn btn-green btn-block" data-modal="novoItem">Adicionar item</button>
							<table>
								<thead>
									<tr>
										<th>Nome</th>
										<th>Editar</th>
										<th>Apagar</th>
									</tr>
								</thead>
								<tbody>
									<?php

									$query = $con->prepare("SELECT i.id, i.nome, i.descricao, m.titulo, m.conteudo FROM lojaitems i, modalitems m WHERE m.itemId=i.id ORDER BY i.id");
									$query->execute();

									while($linha = $query->fetch(PDO::FETCH_OBJ)){
										echo '<tr><td>'.$linha->nome.'</td>';
										echo '<td><a href="#" class="editItem">Editar</a>';
										echo '<input type="hidden" value="'.$linha->id.'"/>';
										echo '<input type="hidden" value="'.$linha->nome.'"/>';
										echo '<input type="hidden" value="'.$linha->descricao.'"/>';
										echo '<input type="hidden" value="'.$linha->titulo.'"/>';
										echo '<input type="hidden" value="'.str_replace("\"", "'", $linha->conteudo).'"/></td>';
										echo '<td><a href="apagarItem.php?id='.$linha->id.'">Apagar</a></td></tr>';
									}

									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Botões criados</p>
							<button class="btn btn-green btn-block" data-modal="novoButton">Adicionar botão</button>
							<table>
								<thead>
									<tr>
										<th>Item</th>
										<th>Texto</th>
										<th>Editar</th>
										<th>Apagar</th>
									</tr>
								</thead>
								<tbody>
									<?php

									$query = $con->prepare("SELECT i.nome, b.* FROM buttonsitems b, lojaitems i WHERE b.itemId=i.id ORDER BY i.id, b.id");
									$query->execute();

									while($linha = $query->fetch(PDO::FETCH_OBJ)){
										echo '<tr><td>'.$linha->nome.'</td><td>'.$linha->texto.'</td>';
										echo '<td><a href="#" class="editButton">Editar</a>';
										echo '<input type="hidden" value="'.$linha->id.'"/>';
										echo '<input type="hidden" value="'.str_replace("\"", "'", $linha->texto).'"/>';
										echo '<input type="hidden" value="'.$linha->cor.'"/>';
										echo '<input type="hidden" value="'.$linha->link.'"/></td>';
										echo '<td><a href="apagarButton.php?id='.$linha->id.'">Apagar</a></td></tr>';
									}

									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-8">
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Gerenciar notícias</p>

							<?php

							$query = $con->prepare("SELECT * FROM noticias ORDER BY id DESC");
							$query->execute();
							if($query->rowCount() > 0):
							echo '<button class="btn btn-green btn-block" data-modal="novanoticia">Nova noticia</button>';
							while($linha = $query->fetch(PDO::FETCH_OBJ)):
							?>

							<div class="noticia">
								<div class="noticia-body">
									<input type="hidden" value="<?php echo $linha->id ?>"/>
									<p class="title"><?php echo $linha->title ?></p>
									<input type="hidden" value="<?php echo str_replace("\"", "'", $linha->content) ?>"/>
									<p class="posted painel">Postado por <?php echo $linha->author ?> em <?php echo date_format(date_create($linha->data), "d/m/Y") ?></p>
									<div class="row">
										<div class="col-6"><button class="btn btn-green btn-block editNoticia">Editar</button></div>
										<div class="col-6"><a href="apagarNoticia.php?id=<?php echo $linha->id ?>" class="btn btn-dark btn-block">Apagar</a></div>
									</div>
								</div>
							</div>

							<?php
	endwhile;
										   else:
							?>

							<h3 class="text-information-big text-center text-upper">Sem notícias</h3>
							<button class="btn btn-green btn-block" data-modal="novanoticia">Nova noticia</button>

							<?php
							endif;

							?>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="card">
						<div class="card-body">
							<p class="title text-center">Usuários que podem acessar o painel</p>
							<button class="btn btn-green btn-block" data-modal="novoUsuario">Adicionar usuário</button>
							<table>
								<thead>
									<tr>
										<th>ID</th>
										<th>Nome</th>
										<th>Deletar</th>
									</tr>
								</thead>
								<tbody>
									<?php

									$query = $con->prepare("SELECT * FROM permitidos");
									$query->execute();
									if($query->rowCount() > 0){
										while($linha = $query->fetch(PDO::FETCH_OBJ)){
											echo "<tr><td>{$linha->id}</td><td>{$linha->nick}</td><td><a href=\"apagarUsuario.php?id=".$linha->id."\">Apagar</a></td></tr>";
										}
									}

									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="developed">Desenvolvido por <a href="#">David Nery</a></div>

		<div class="modal" id="novanoticia">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Postar nova notícia</span>
				</div>
				<div class="modal-body">
					<form id="formNovaNoticia" method="POST">
						<input name="title" type="text" class="maxwidth" placeholder="Coloque o título aqui" required autofocus/>
						<textarea id="content" name="content" class="maxwidth" placeholder="Coloque a notícia aqui" required></textarea>
						<input type="submit" class="btn btn-green btn-block" value="Postar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="novoItem">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Adicionar novo item à loja</span>
				</div>
				<div class="modal-body">
					<form id="formNovoItem" method="POST">
						<input name="title" type="text" class="maxwidth" placeholder="Informe o nome do item"/>
						<input name="descricao" type="text" class="maxwidth" placeholder="Informe a descrição do item"/>
						<input name="modaltitle" type="text" class="maxwidth" placeholder="Informe o título do modal do item"/>
						<textarea id="itemModal" name="modalcontent" type="text" class="maxwidth resize-vertical" placeholder="Informe o conteúdo do modal do item"></textarea>
						<input name="btnText" type="text" class="maxwidth" placeholder="Informe o nome do botão"/>
						<select name="btnColor" class="maxwidth">
							<option value="green">Verde</option>
							<option value="dark">Preto</option>
							<option value="red">Vermelho</option>
						</select>
						<input name="btnLink" type="text" class="maxwidth" placeholder="Informe o link do botão"/>
						<input type="submit" class="btn btn-green btn-block" value="Adicionar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="novoButton">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Adicionar novo botão à loja</span>
				</div>
				<div class="modal-body">
					<form id="formNovoButton" method="POST">
						<select name="itemId" class="maxwidth">
							<?php

							$query = $con->prepare("SELECT id, nome FROM lojaitems");
							$query->execute();

							while($linha = $query->fetch(PDO::FETCH_OBJ)){
								echo '<option value="'.$linha->id.'">'.$linha->nome.'</option>';
							}

							?>
						</select>
						<input name="btnText" type="text" class="maxwidth" placeholder="Informe o nome do botão"/>
						<select name="btnColor" class="maxwidth">
							<option value="green">Verde</option>
							<option value="dark">Preto</option>
							<option value="red">Vermelho</option>
						</select>
						<input name="btnLink" type="text" class="maxwidth" placeholder="Informe o link do botão"/>
						<input type="submit" class="btn btn-green btn-block" value="Criar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="novoUsuario">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Adicionar novo usuário</span>
				</div>
				<div class="modal-body">
					<form id="formNovoUsuario" method="POST">
						<select class="maxwidth" name="usuarioSelecionado">
							<?php

							$con = $conexao->connectServidor();
							$query = $con->prepare("SELECT player FROM login");
							$query->execute();

							while($linha = $query->fetch(PDO::FETCH_OBJ)){
								echo '<option value="'.$linha->player.'">'.$linha->player.'</option>';
							}

							?>
						</select>
						<input type="submit" class="btn btn-green btn-block" value="Postar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="editarNoticia">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Editar notícia</span>
				</div>
				<div class="modal-body">
					<form id="formEditarNoticia" method="POST">
						<input name="id" type="hidden"/>
						<input name="title" type="text" class="maxwidth" placeholder="Coloque o título aqui" required autofocus/>
						<textarea id="editContent" name="content" class="maxwidth" placeholder="Coloque a notícia aqui" required></textarea>
						<input type="submit" class="btn btn-green btn-block" value="Salvar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="editarItem">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Editar item da loja</span>
				</div>
				<div class="modal-body">
					<form id="formEditarItem" method="POST">
						<input name="id" type="hidden"/>
						<input name="title" type="text" class="maxwidth" placeholder="Informe o nome do item"/>
						<input name="descricao" type="text" class="maxwidth" placeholder="Informe a descrição do item"/>
						<input name="modaltitle" type="text" class="maxwidth" placeholder="Informe o título do modal do item"/>
						<textarea id="editItemModal" name="modalcontent" type="text" class="maxwidth resize-vertical" placeholder="Informe o conteúdo do modal do item"></textarea>
						<input type="submit" class="btn btn-green btn-block" value="Salvar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>
		<div class="modal" id="editarButton">
			<div class="modal-content">
				<div class="modal-head">
					<span class="modal-title">Editar botão da loja</span>
				</div>
				<div class="modal-body">
					<form id="formEditarButton" method="POST">
						<input name="id" type="hidden"/>
						<input name="btnText" type="text" class="maxwidth" placeholder="Informe o nome do botão"/>
						<select name="btnColor" class="maxwidth">
							<option value="green">Verde</option>
							<option value="dark">Preto</option>
							<option value="red">Vermelho</option>
						</select>
						<input name="btnLink" type="text" class="maxwidth" placeholder="Informe o link do botão"/>
						<input type="submit" class="btn btn-green btn-block" value="Salvar"/>
					</form>
					<div class="alert" style="display: none"></div>
				</div>
			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="../js/main.js"></script>
		<script src="js/jquery-te-1.4.0.min.js"></script>
		<script src="js/painel.js"></script>
	</body>

</html>