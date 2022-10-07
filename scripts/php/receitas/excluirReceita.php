<?php
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$receitaID = $_GET["receitaID"];
	echo $receitaID;

	$SQL = "DELETE receitas, comentarios, favoritos FROM receitas 
			INNER JOIN comentarios ON comentarios.receita_ID = receitas.receitaID, 
			INNER JOIN favoritos ON favoritos.receita_ID = receitas.receitaID 
			WHERE receitas.receitaID = $receitaID"
	echo $SQL;
	/*$resposta = $bancoDeDados->executar($SQL);
	if($resposta){
		echo "DELETADO";
	}
	else{
		echo "DEU ERRO AQUI AMIGÃO";
	}*/
?>