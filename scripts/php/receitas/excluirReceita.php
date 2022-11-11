<?php
	session_start();
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$receitaID = $_POST["receitaID"];
	$autorID = $_SESSION["usuario"]["ID"];

	$SQL = "SELECT * FROM receitas WHERE receitaID=$receitaID AND autor_ID=$autorID";
	$resposta = $bancoDeDados->selecionar($SQL);
	if($resposta){
		# excluindo favoritos da receita
		$SQL = "SELECT COUNT(*) AS numFavoritosDaReceita FROM favoritos WHERE receita_ID=$receitaID";
		$numFavoritos = $bancoDeDados->selecionar($SQL)[0]["numFavoritosDaReceita"];
		if($numFavoritos != 0){
			$SQL = "DELETE FROM favoritos WHERE receita_ID=$receitaID";
			$exclusao = $bancoDeDados->executar($SQL);
		}

		# excluindo comentarios da receita
		$SQL = "SELECT COUNT(*) AS numComentariosDaReceita FROM comentarios WHERE receita_ID=$receitaID";
		$numComentarios = $bancoDeDados->selecionar($SQL)[0]["numComentariosDaReceita"];
		if($numComentarios != 0){
			$SQL = "DELETE FROM comentarios WHERE receita_ID=$receitaID";
			$exclusao = $bancoDeDados->executar($SQL);
		}

		# excluindo a relação de ingredientes da receita
		$SQL = "DELETE FROM ingredientes_receitas WHERE receita_ID=$receitaID";
		$exclusao = $bancoDeDados->executar($SQL);

		# excluindo a imagem da receita
		$SQL = "SELECT imagemURL FROM receitas WHERE receitaID=$receitaID";
		$imagemDaReceita = $bancoDeDados->selecionar($SQL)[0]["imagemURL"];
		if($imagemDaReceita != 'imgs/receitas/default.jpg'){
			unlink('../../../'.$imagemDaReceita);
		}

		$SQL = "DELETE FROM receitas WHERE receitaID=$receitaID AND autor_ID=$autorID";
		$exclusao = $bancoDeDados->executar($SQL);
		if($exclusao){
			header('Location: ../../../seu_usuario.php');
		}
		else{
			echo "OCORREU UM ERRO DESCONHECIDO AO TENTAR EXCLUIR A SUA RECEITA";
		}
	}
	else{
		echo "IMPOSSÍVEL EXCLUIR SE NÃO FOR O AUTOR DA RECEITA";
	}
?>