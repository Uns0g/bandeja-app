<?php
	include('../../../classes/classeConexao.php');

	$ingrediente = filter_input(INPUT_GET, "ingredienteNome", FILTER_SANITIZE_STRING);
	if(!empty($ingrediente)){
		$bancoDeDados = new BancoDeDados();
		$SQL = "SELECT nome FROM ingredientes WHERE nome LIKE '$ingrediente%' LIMIT 8";
		$resposta = $bancoDeDados->selecionar($SQL);
		if($resposta){
			$dados = $resposta;
		}
		else{
			$dados = ['erro' => true, 'mensagem' => "INGREDIENTE NÃO ENCONTRADO"];
		}
	}
	else{
		$dados = ['erro' => true, 'mensagem' => "NENHUM INGREDIENTE PODE SER VAZIO"];
	}

	echo json_encode($dados);
?>