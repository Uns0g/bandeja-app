<?php
	include('../../../classes/classeConexao.php');
	session_start();

	$bancoDeDados = new BancoDeDados();

	$nomeDoIngrediente = strtoupper($_POST["ingrediente"]);
	$SQL = "SELECT * FROM ingredientes WHERE nome = '$nomeDoIngrediente'";
	$resposta = $bancoDeDados->selecionar($SQL);

	# Se tiver erro
	if(is_array($resposta[0])){
		$_SESSION["ingrediente-invalido"] = $nomeDoIngrediente;

		header('Location: ../../../seu_usuario.php');
	}
	else{
		$SQL = "INSERT INTO ingredientes(nome) VALUES('$nomeDoIngrediente')";
		$resposta = $bancoDeDados->executar($SQL);

		if($resposta){
			unset($_SESSION["ingrediente-invalido"]);
			echo "<script>history.back()</script>";
		}
		else{ echo "HOUVE ALGUM ERRO NO MOMENTO DA INSERÇÃO";}
	}
?>