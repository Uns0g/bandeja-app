<?php
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$conteudo = $_POST["conteudo"];
	$comentarioID = $_POST["comentarioID"];
	$receitaID = $_POST["receitaID"];

	$SQL = "UPDATE comentarios SET conteudo='$conteudo' WHERE comentarioID=$comentarioID";
	$alteracao = $bancoDeDados->executar($SQL);
	if($alteracao){
		header('Location: ../../../receita.php?rID='.$receitaID.'#comentarios');
	}	
	else{
		echo "HOUVE UM ERRO AO ALTERAR O COMENTÁRIO. TENTE NOVAMENTE MAIS TARDE!";
	}
?>