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
		<link rel="stylesheet" href="/site4/painel/css/datatables.min.css">
		<link rel="stylesheet" href="/site4/css/style.css">
		<link rel="stylesheet" href="/site4/painel/css/painel.css">
		<style>
			table.dataTable thead th {
				border-bottom: solid 3px #d9d9d9;
				padding: 15px;
			}
			
			table.dataTable.no-footer {
				border: solid 3px #d9d9d9;
			}
			
			table.dataTable thead .sorting_asc {
				background: none;
			}
			
			table.dataTable thead .sorting {
				background: none;
			}
		</style>
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

					$query = $con->prepare("SELECT p.*, u.nome FROM postagem p, usuario u WHERE p.usuario=u.id ORDER BY p.id DESC");
					$query->execute();

					if($query->rowCount() > 0):

					?>
					<div style="overflow-x: auto; margin-bottom: 10px">
						<table id="tblpostagens" style="width: 100%">
							<thead>
								<tr>
									<th>Título</th>
									<th>Views</th>
									<th>Data</th>
									<th>Postado por</th>
									<th>Editar</th>
									<th>Apagar</th>
								</tr>
							</thead>
							<tbody>
								<?php

								while($linha=$query->fetch(PDO::FETCH_OBJ)){
									echo '<tr>
								<td>'.$linha->titulo.'</td>
								<td>'.$linha->views.'</td>
								<td>'.date("H:i:s d/m/Y", strtotime($linha->postado)).'</td>
								<td>'.$linha->nome.'</td>
								<td><a href="editpostagem/'.$linha->id.'" class="btn btn-green max-width"><i class="fa fa-pencil"></i> Editar</a></td>
								<td><a href="apagarpostagem/'.$linha->id.'" class="btn btn-red max-width"><i class="fa fa-trash"></i> Apagar</a></td>
								</tr>';
								}

								?>
							</tbody>
						</table>
					</div>
					<?php

					else:

					?>
					<span class="nada">Sem postagens :(</span>
					<?php

					endif;

					$query = $con->prepare("SELECT * FROM categoria");
					$query->execute();

					if($query->rowCount() > 0)
						echo '<a href="addpostagem" class="btn btn-blue max-width"><i class="fa fa-plus"></i> Nova postagem</a>';
					else
						echo '<span class="nada">Crie uma categoria para poder criar uma postagem</span>';

					?>
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
		<script src="/site4/painel/js/datatables.min.js"></script>
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

				$("#tblpostagens").DataTable({
					language: {
						"emptyTable": "Nenhum registro encontrado",
						"info": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
						"infoEmpty": "Mostrando 0 até 0 de 0 registros",
						"infoFiltered": "(Filtrados de _MAX_ registros)",
						"infoPostFix": "",
						"infoThousands": ".",
						"lengthMenu": "Mostrar _MENU_ resultados por página",
						"loadingRecords": "Carregando...",
						"processing": "Processando...",
						"zeroRecords": "Nenhum registro encontrado",
						"search": "Pesquisar",
						"paginate": {
							"Next": "Próximo",
							"Previous": "Anterior",
							"First": "Primeiro",
							"Last": "Último"
						},
						"aria": {
							"sortAscending": ": Ordenar colunas de forma ascendente",
							"sortDescending": ": Ordenar colunas de forma descendente"
						}
					}
				});

			});
		</script>
	</body>

</html>