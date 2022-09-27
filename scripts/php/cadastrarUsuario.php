<?php
session_start();
include("../../classes/classeConexao.php");

$dadosColetados = $_POST;
$nomeDigitado = $fotoURL = $senhaDigitada = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	# verificando se algum campo obrigatório está vazio
	foreach ($dadosColetados as $chave => $valor) {
		if($chave == "nome"){
			if(empty($valor)){
				$contemErro = true;
				$_SESSION["nome-invalido"] = true;
				header('Location: ../../index.php');
			}

			$nomeDigitado = $valor;
		}

		if($chave == "senha"){
			if(empty($valor)){
				$contemErro = true;
				$_SESSION["senha-invalida"] = true;
				header('Location: ../../index.php');
			}

			$senhaDigitada = $valor;
		}
	}

	# verificando a imagem enviada
	if($_FILES["foto"]["error"] == 4){
		$fotoURL = 'imgs/usuarios/default.jpg';
	}
	else{
		$quantidadeDeErros = validarImagem($_FILES["foto"]);
		if($quantidadeDeErros > 0){
			$_SESSION['imagem-invalida'] = true;
			header('Location: ../../index.php');
		}
		else{
			$nomeDoUsuario = str_replace(' ', '_', $nomeDigitado);
			$extensaoDaImagem = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
			$fotoURL = 'imgs/usuarios/'.$nomeDoUsuario.strval(rand(0,9999)).'.'.$extensaoDaImagem;

			$destino = '../../'.$fotoURL;
			if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)){
				
				$bancoDeDados = new BancoDeDados();

				$SQL = "SELECT * FROM usuarios WHERE nome = '$nomeDigitado'";
				
				$usuarioExistente = $bancoDeDados->selecionar($SQL);
				if(!$usuarioExistente){
					$SQL = "INSERT INTO usuarios(nome,fotoURL,senha) VALUES('$nomeDigitado','$fotoURL','$senhaDigitada')";
					$insercao = $bancoDeDados->inserir($SQL);

					if($insercao){ 
						$_SESSION["usuario"] = array(
							"NOME" => $nomeDigitado,
							"IMAGEM" => $fotoURL,
						);

						header('Location: ../../seu_usuario.php');
					}
					else{ echo "HOUVE UM ERRO AO CADASTRAR O USUÁRIO! TENTE NOVAMENTE MAIS TARDE.";}
				}
				else{
					$_SESSION["nome-invalido"] = true;
					header('Location: ../../index.php');
				}
			}
			else{
				echo "<strong style='color: #8C0303; text-align: center; display: block; font-size: 1.6em;' data-message='Não foi possível enviar a foto ao servidor de destino'>OCORREU UM ERRO INESPERADO! TENTE SE CADASTRAR MAIS TARDE</strong>";
			}
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
	if($tamanhoDaImagem > 2048 || $dadosDaImagem["error"] == 1){
		$numeroDeErros++;
		echo "Imagem é muito grande";
	}

	return $numeroDeErros;
}
?>