<?php
session_start();
include("../../classes/classeConexao.php");

$dadosColetados = $_POST;
$nomeDigitado = $senhaDigitada = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	# checa se algum campo obrigat�rio est� vazio
	foreach ($dadosColetados as $chave => $valor) {
		if($chave == "nome"){
			if(empty($valor)){
				$_SESSION["nome-invalido"] = true;
				header('Location: ../../login.php');
			}

			$nomeDigitado = $valor;
		}

		if($chave == "senha"){
			if(empty($valor)){
				$_SESSION["senha-invalida"] = true;
				header('Location: ../../login.php');
			}

			$senhaDigitada = $valor;
		}
	}
	
	# checa se usu�rio j� existe
	$bancoDeDados = new BancoDeDados();
	
	$SQL = "SELECT * FROM usuarios WHERE nome = '$nomeDigitado'";
	$usuarioJaExistente = $bancoDeDados->selecionar($SQL);
	if(!$usuarioJaExistente){
		$_SESSION["nome-invalido"] = $nomeDigitado;
		header('Location: ../../login.php');
	}
	else{
		$SQL = "SELECT senha FROM usuarios WHERE nome = '$nomeDigitado'";

		$resposta = $bancoDeDados->selecionar($SQL);
		if($resposta[0]["senha"] == $senhaDigitada){
			$SQL = "SELECT * FROM usuarios WHERE nome = '$nomeDigitado'";
		
			$resposta = $bancoDeDados->selecionar($SQL);
			$_SESSION["usuario"] = array(
				"NOME" => $resposta[0]["nome"],
				"IMAGEM" => $resposta[0]["fotoURL"],
			);

			header('Location: ../../seu_usuario.php');
		}
		else{
			$_SESSION["senha-invalida"] = true;
			echo "A SENHA N�O CORRESPONDE AO QUE EST� NO BANCO DE DADOS";
			header('Location: ../../login.php');
		}
	}
}

?>