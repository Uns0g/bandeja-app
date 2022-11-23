<?php
	session_start();
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	# excluindo os comentários feitos pelo usuário
	$idDoUsuario = $_SESSION["usuario"]["ID"];
	$SQL = "DELETE FROM comentarios WHERE autor_ID=$idDoUsuario";
	$exclusao = $bancoDeDados->executar($SQL);

	# excluindo as receitas favoritas que esse usuário tem
	$SQL = "DELETE FROM favoritos WHERE usuario_ID=$idDoUsuario";
	$exclusao = $bancoDeDados->executar($SQL);

	# excluindo todos os dados de todas as receitas que o usuário cadastrou
	$SQL = "SELECT receitaID FROM receitas WHERE autor_ID=$idDoUsuario";
	$receitasCadastradasPeloUsuario = $bancoDeDados->selecionar($SQL);
	if(!empty($receitasCadastradasPeloUsuario)){
		foreach ($receitasCadastradasPeloUsuario as $receitaCadastrada) {
			$idDaReceita = $receitaCadastrada["receitaID"];

			# excluindo favoritos da receita
			$SQL = "DELETE FROM favoritos WHERE receita_ID=$idDaReceita";
			$exclusao = $bancoDeDados->executar($SQL);

			# excluindo comentarios da receita
			$SQL = "DELETE FROM comentarios WHERE receita_ID=$idDaReceita";
			$exclusao = $bancoDeDados->executar($SQL);

			# excluindo a relação de ingredientes da receita
			$SQL = "DELETE FROM ingredientes_receitas WHERE receita_ID=$idDaReceita";
			$exclusao = $bancoDeDados->executar($SQL);

			# excluindo a imagem da receita
			$SQL = "SELECT imagemURL FROM receitas WHERE receitaID=$idDaReceita";
			$imagemDaReceita = $bancoDeDados->selecionar($SQL)[0]["imagemURL"];
			if($imagemDaReceita != 'imgs/receitas/default.jpg'){
				unlink('../../../'.$imagemDaReceita);
			}

			# excluindo a receita
			$SQL = "DELETE FROM receitas WHERE receitaID=$idDaReceita AND autor_ID=$idDoUsuario";
			$exclusao = $bancoDeDados->executar($SQL);
		}
	}

	# excluindo a imagem de perdil do usuário
	$SQL = "SELECT fotoURL FROM usuarios WHERE usuarioID=$idDoUsuario";
	$fotoURL = $bancoDeDados->selecionar($SQL)[0]["fotoURL"];
	if($imagemURL != 'imgs/usuarios/default.jpg'){
		unlink('../../../'.$fotoURL);
	}

	# excluindo o usuário;
	$nomeDoUsuario = $_SESSION["usuario"]["NOME"];
	$SQL = "DELETE FROM usuarios WHERE usuarioID=$idDoUsuario AND nome='$nomeDoUsuario'";
	$exclusao = $bancoDeDados->executar($SQL);
	if($exclusao){
		header('Location: ../../../index.php');
	}
	else{
		echo "NÃO EXCLUIU";
	}
?>