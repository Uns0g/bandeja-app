<?php
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$conteudo = $_POST["conteudo"];
	$autorID = $_POST["autorID"];
	$receitaID = $_POST["receitaID"];

	$SQL = "INSERT INTO comentarios(conteudo,autor_ID,receita_ID) VALUES('$conteudo',$autorID,$receitaID)";
	$insercao = $bancoDeDados->executar($SQL);
	if($insercao){
		header('Location: ../../../receita.php?rID='.$receitaID.'#comentarios');
	}
	else{
		echo "<b>HOUVE UM ERRO AO PUBLICAR O COMENTÁRIO</b>";
	}
?>