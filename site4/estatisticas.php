<?php

function getTime($millis) {
	$time = $millis / 1000;

	$days = floor($time / (24*60*60));
	$hours = floor(($time - ($days*24*60*60)) / (60*60));
	$minutes = floor(($time - ($days*24*60*60)-($hours*60*60)) / 60);
	$seconds = ($time - ($days*24*60*60) - ($hours*60*60) - ($minutes*60)) % 60;

	$str = "";

	if($days > 0) $str .= $days."d, ";
	if($hours > 0) $str .= $hours."h, ";
	if($minutes > 0) $str .= $minutes."m, ";
	if($seconds > 0) $str .= $seconds."s";

	return $str;
}

?>

<!doctype html>
<html lang="br">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title><?php require "config/site_config.php"; echo $config["titulo"]; ?></title>

		<script src="js/fontawesome-all.js"></script>

		<link rel="shortcut icon" href="src/logo.png">

		<link rel="stylesheet" href="css/style.css">
		<style>
			#bans_length {
				display: inline-block;
			}

			#bans_filter {
				display: inline-block;
				float: right;
			}

			#bans_filter input {
				margin: 0 10px;
			}

			#bans_filter input, #bans_length select {
				padding: 5px 10px;
				border-radius: 5px;
			}

			.dataTables_paginate {
				padding: 15px 0;
				display: inline-block;
				float: right;
			}
			
			.paginate_button {
				cursor: pointer;
				padding: 5px 15px;
				color: white;
				background-color: #f66c15;
				font-weight: 400;
				border-radius: 5px;
				margin-right: 5px;
			}
			
			.paginate_button .next {
				margin-right: 0;
			}
			
			.ellipsis {
				margin-right: 5px;
			}
			
			.paginate_button.previous, .paginate_button.next, .paginate_button.current {
				font-weight: 800;
			}
		</style>
	</head>

	<body>
		<div class="container">
			<div id="content">
				<header>
					<div class="container">
						<img width="75px" height="75px" src="src/logo.png" alt="logo.png">
						<nav class="nav">
							<button class="toggle"><i class="fas fa-bars fa-2x"></i></button>
							<ul class="navbar">
								<li><a href="/"><i class="fas fa-home"></i> Início</a></li>
								<li><a href="loja"><i class="fas fa-shopping-cart"></i> Loja</a></li>
								<li><a href="equipe"><i class="fas fa-users"></i> Equipe</a></li>
								<li><a href="regras"><i class="fas fa-book"></i> Regras</a></li>
								<li><a class="active" href="estatisticas"><i class="fas fa-chart-line"></i> Estatísticas</a></li>
							</ul>
						</nav>
						<div class="info">
							<p class="title">Estatísticas oficiais do servidor</p>
							<p id="playerson">Carregando players...</p>
						</div>
					</div>
				</header>
				<?php

				require "config/conexao.php";

				$con = Conexao::returnConnection();

				?>
				<div style="padding: 20px">
					<div class="container">
						<div class="row">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">Mais ricos</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Quantia</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT DISTINCT name, value FROM BEconomy ORDER BY value DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->name}</td>
														<td>".number_format($linha->value, 2, ",", ".")."</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP Almas</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Quantia</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT * FROM almas ORDER BY almas DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->almas}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP Kills</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Clan</th>
														<th>Kills</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT sck.attacker player, scc.name clan, COUNT(*) kills FROM sc_kills sck, sc_players scp, sc_clans scc WHERE sck.attacker_uuid=scp.uuid AND scp.tag=scc.tag GROUP BY scp.uuid ORDER BY kills DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->clan}</td>
														<td>{$linha->kills}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP Deaths</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Clan</th>
														<th>Deaths</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT sck.victim player, scc.name clan, COUNT(*) deaths FROM sc_kills sck, sc_players scp, sc_clans scc WHERE sck.victim_uuid=scp.uuid AND scp.tag=scc.tag GROUP BY scp.uuid ORDER BY deaths DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->clan}</td>
														<td>{$linha->deaths}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP online</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Tempo</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT * FROM tempo_online ORDER BY logged_time DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>".preg_replace("/, $/", "", getTime($linha->logged_time))."</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP mcMMO - Espadas</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Level</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT mcu.user player, mcs.swords level FROM mcmmo_users mcu, mcmmo_skills mcs WHERE mcs.user_id=mcu.id ORDER BY mcs.swords DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->level}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP mcMMO - Machado</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Level</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT mcu.user player, mcs.axes level FROM mcmmo_users mcu, mcmmo_skills mcs WHERE mcs.user_id=mcu.id ORDER BY mcs.axes DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->level}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">TOP mcMMO - Mineração</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Level</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT mcu.user player, mcs.mining level FROM mcmmo_users mcu, mcmmo_skills mcs WHERE mcs.user_id=mcu.id ORDER BY mcs.mining DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player}</td>
														<td>{$linha->level}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="card">
									<div class="card-title">
										<p class="title">Players que mais votaram</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table style="width: 100%">
												<thead>
													<tr>
														<th>#</th>
														<th>Player</th>
														<th>Votos</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT * FROM vr_voters ORDER BY lifetime_votes DESC LIMIT 5");
													$query->execute();

													$i = 1;
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>$i</td>
														<td>{$linha->player_name}</td>
														<td>{$linha->lifetime_votes}</td>
													</tr>";
														$i++;
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-title">
										<p class="title">Últimos banimentos</p>
									</div>
									<div class="card-body">
										<div style="overflow-x: auto">
											<table id="bans" style="width: 100%">
												<thead>
													<tr>
														<th>Player</th>
														<th>Staff</th>
														<th>Data</th>
														<th>Expira</th>
													</tr>
												</thead>
												<tbody>
													<?php

													$query = $con->prepare("SELECT * FROM bans ORDER BY time DESC");
													$query->execute();
													
													while($linha = $query->fetch(PDO::FETCH_OBJ)){
														echo "<tr>
														<td>{$linha->name}</td>
														<td>{$linha->banner}</td>
														<td>".date("d/m/Y H:m:i", $linha->time/1000)."</td>
														<td>".($linha->expires == 0 ? "Nunca" : date("d/m/Y H:m:i", $linha->expires))."</td>
													</tr>";
													}

													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
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


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/datatables.min.js"></script>
		<script type="text/javascript">
			$("#bans").first().DataTable({
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
				},
				"ordering": false
			});
		</script>

	</body>

</html>