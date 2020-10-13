<?php

require_once "system/config.php";
$conexao = new Conexao();
$con = $conexao->connect();

$query = $con->prepare("SELECT c.nome, p.id, p.titulo, p.descricao, pc.categoria FROM categoria c, postagem p, postagemcategoria pc WHERE pc.postagem=p.id AND pc.categoria=c.id ORDER BY pc.categoria, p.id DESC");
$query->execute();
if($query->rowCount() > 0){
	$arrayfull = array("status"=>"success", "categorias"=>array());
	$arrayc = array();
	$c = null;
	$nome = null;
	while($linha = $query->fetch(PDO::FETCH_OBJ)){
		if($linha->categoria != $c){
			if(count($arrayc) > 0) $arrayfull["categorias"][$nome] = $arrayc;
			$arrayc = array();
			$c = $linha->categoria;
			$nome = $linha->nome;
		}
		array_push($arrayc, $linha->id);
	}
	if(count($arrayc) > 0) $arrayfull["categorias"][$nome] = $arrayc;
	echo json_encode($arrayfull, JSON_UNESCAPED_UNICODE);
}else{
	echo json_encode(array("status"=>"danger", "message"=>"Sem postagens!"), JSON_UNESCAPED_UNICODE);
}

?>