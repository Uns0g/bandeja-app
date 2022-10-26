<?php
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$comentarioID = $_POST["comentarioID"];
	$receitaID = $_POST["receitaID"];

	$SQL = "DELETE FROM comentarios WHERE comentarioID=$comentarioID";
	$exclusao = $bancoDeDados->executar($SQL);
	if($exclusao){
		header('Location: ../../../receita.php?rID='.$receitaID.'#comentarios');
	}
	else{
		echo "HOUVE UM ERRO AO EXCLUIR O COMENTÁRIO. TENTE NOVAMENTE MAIS TARDE!";
	}
?>