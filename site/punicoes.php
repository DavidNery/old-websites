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

		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
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
				<li><a href="loja.php">Loja</a></li>
				<li><a href="#">Punições</a></li>
				<li><a href="#">Fórum</a></li>
				<?php 

				if($query != null && $query->rowCount() > 0)
					echo '<li class="direita"><a href="painel/">Painel</a></li>';

				?>
			</ul>
		</div>
		<div class="container">
			<div class="card">
				<div class="card-body">
					<p class="title text-center">Punições</p>
					<div id="punicoes">
						<table>
							<thead>
								<tr>
									<th>Player</th>
									<th>Staff</th>
									<th>Motivo</th>
									<th>Data</th>
									<th>Tempo</th>
								</tr>
							</thead>
							<tbody>
								<?php

								$conexao = new Conexao();
								$con = $conexao->connectServidor();

								if($con){
									$query = $con->prepare("SELECT * FROM bans");
									$query->execute();
									while($linha = $query->fetch(PDO::FETCH_OBJ)){
										echo "<tr>
										<td class=\"text-center\"><img src=\"http://cravatar.eu/avatar/{$linha->name}/40.png\"><br/>{$linha->name}</td>
										<td class=\"text-center\"><img src=\"http://cravatar.eu/avatar/{$linha->banner}/40.png\"><br/>{$linha->banner}</td>
										<td>{$linha->reason}</td>
										<td class=\"text-center\">".date("H:i:s d/m/Y", $linha->time/1000)."</td>
										<td class=\"text-center\">".(($linha->expires > 0) ? date("H:i:s d/m/Y", $linha->expires/1000) : "Permanente")."</td>
									</tr>";
									}
								}

								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div id="developed">Desenvolvido por <a href="#">David Nery</a></div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$("table").first().DataTable({
				info: false,
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
						"next": "Próximo",
						"previous": "Anterior",
						"Ffrst": "Primeiro",
						"last": "Último"
					},
					"aria": {
						"sortAscending": ": Ordenar colunas de forma ascendente",
						"sortDescending": ": Ordenar colunas de forma descendente"
					}
				}
			});
		</script>
		<script src="js/main.js"></script>
	</body>

</html>