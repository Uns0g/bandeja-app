<?php
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$receitaID = $_GET['rID'];
	$usuarioID = $_GET['uID'];
	$incremento = $_GET['inc'];
	
	if($incremento == 1){
		$SQL = "INSERT INTO favoritos(usuario_ID,receita_ID) VALUES($usuarioID,$receitaID)";
		$insercao = $bancoDeDados->executar($SQL);

		if($insercao){	alterarNumeroDeFavoritos($bancoDeDados,$receitaID);}
	}
	else{
		$SQL = "DELETE FROM favoritos WHERE usuario_ID=$usuarioID AND receita_ID=$receitaID";
		$exclusao = $bancoDeDados->executar($SQL);

		if($exclusao){	alterarNumeroDeFavoritos($bancoDeDados,$receitaID);}
	}
	echo "<script>history.go(-1)</script>";

	function alterarNumeroDeFavoritos($objetoBancoDeDados,$idAlvo){
		$SQL = "SELECT COUNT(usuario_ID) AS numFavoritos FROM favoritos WHERE receita_ID=$idAlvo";
		$numeroDeFavoritos = $objetoBancoDeDados->selecionar($SQL)[0]["numFavoritos"];

		$SQL = "UPDATE receitas SET favoritos_numeros=$numeroDeFavoritos WHERE receitaID=$idAlvo";
		$alteracao = $objetoBancoDeDados->executar($SQL);
	}
?>