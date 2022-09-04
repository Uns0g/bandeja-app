<?php
session_start();
include("../../classes/classeConexao.php");

$dadosColetados = $_POST;
$nomeDigitado = $fotoURL = $senhaDigitada = '';

$contemErro = false;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	foreach ($dadosColetados as $chave => $valor) {
		if($chave == "nome"){
			if(empty($valor)){
				$contemErro = true;
				$_SESSION["nome-invalido"] = true;
				header('Location: ../../index.html');
			}

			$nomeDigitado = $valor;
		}

		if($chave == "senha"){
			if(empty($valor)){
				$contemErro = true;
				$_SESSION["senha-invalida"] = true;
				header('Location: ../../index.html');
			}

			$senhaDigitada = $valor;
		}
	}

	# verificando a imagem enviada
	if(!empty($_FILES["foto"]["error"])){
		$fotoURL = 'imgs/usuarios/default.jpg';
	}
	else{
		$quantidadeDeErros = validarImagem($_FILES["foto"]);
		if($quantidadeDeErros > 0){
			$_SESSION['imagem-invalida'] = true;
			header('Location: ../../index.html');
		}
		else{
			$nomeDoUsuario = str_replace(' ', '_', $nomeDigitado);
			$extensaoDaImagem = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
			$fotoURL = 'imgs/usuarios/'.$nomeDoUsuario.strval(rand()).'.'.$extensaoDaImagem;

			$destino = $_SERVER["DOCUMENT_ROOT"].'/'.$fotoURL;
			if(!move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)){
				echo "OCORREU UM ERRO INESPERADO! TENTE SE CADASTRAR MAIS TARDE";
			}
		}
	}

	if(!$contemErro){
		$bancoDeDados = new BancoDeDados();

		$SQL = "SELECT * FROM usuarios WHERE nome = '$nomeDigitado'";
		$usuarioExistente = $bancoDeDados->selecionar($SQL);
		if(!$usuarioExistente){
			$SQL = "INSERT INTO usuarios(nome,fotoURL,senha) VALUES('$nomeDigitado','$fotoURL','$senhaDigitada')";
			$insercao = $bancoDeDados->inserir($SQL);

			if($insercao){ 
				header('Location: ../../seu_usuario.html');
			}
			else{ echo "HOUVE UM ERRO AO CADASTRAR O USUÁRIO! TENTE NOVAMENTE MAIS TARDE.";}
		}
		else{
			$_SESSION["nome-invalido"] = true;
			header('Location: ../../index.html');
		}
	}
}
else{ echo "<b>HOUVE ERRO NA REQUISIÇÃO AO SERVIDOR</b>";}

function validarImagem($dadosDaImagem){
	$numeroDeErros = 0;

	$nomeDaImagemEnviada = $dadosDaImagem["name"];
	$extensaoDaImagem = strtolower(pathinfo($nomeDaImagemEnviada, PATHINFO_EXTENSION));
	$extensoesValidas = array('gif','png','jpg','jpeg','jpe','jfif','heif','heic');

	if(!in_array($extensaoDaImagem,$extensoesValidas)){ 
		$numeroDeErros++;
		echo "Erro na extensão</br>";
	}

	$tamanhoDaImagem = $dadosDaImagem["size"]/1024; # pega o tamanho da imagem em KB
	if($tamanhoDaImagem > 2048){
		$numeroDeErros++;
		echo "Imagem é muito grande";
	}

	return $erro;
}