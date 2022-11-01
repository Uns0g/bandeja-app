<?php
	session_start();
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$erroAoAtualizar = false;
	
	$idDoUsuario = $_SESSION["usuario"]["ID"];

	$SQL = "SELECT * FROM usuarios WHERE usuarioID=$idDoUsuario";
	$usuario = $bancoDeDados->selecionar($SQL)[0];

	$novoNome = $_POST["nome"];
	$novaSenha = $_POST["senha"];
	if($_SERVER["REQUEST_METHOD"] == 'POST'){
		if($usuario["nome"] != $novoNome){
			$SQL = "UPDATE usuarios SET nome='$novoNome' WHERE usuarioID=$idDoUsuario";
			$resposta = $bancoDeDados->executar($SQL);

			if(!$resposta){
				$erroAoAtualizar = true;
				echo "<center><strong>HOUVE UM ERRO AO ATUALIZAR O NOME DO SEU USUÁRIO!</strong></center><br> Tente Novamente Mais Tarde!";
			}
			else{
				$nomeAntigoSemEspacos = str_replace(' ','_',$_SESSION["usuario"]["NOME"]);
				$novoNomeSemEspacos = str_replace(' ','_',$novoNome);

				# renomeando foto de perfil do usuário
				$novaFotoURL = str_replace($nomeAntigoSemEspacos,$novoNomeSemEspacos,$_SESSION["usuario"]["IMAGEM"]);
				rename('../../../'.$_SESSION["usuario"]["IMAGEM"], '../../../'.$novaFotoURL);
				$SQL = "UPDATE usuarios SET fotoURL='$novaFotoURL' WHERE usuarioID=$idDoUsuario";
				$alteracao = $bancoDeDados->executar($SQL);

				# alterando Sessão de usuário
				$_SESSION["usuario"]["NOME"] = $novoNome;
				$_SESSION["usuario"]["IMAGEM"] = $novaFotoURL;

				# renomeando nome das imagens de receitas do usuário
				$SQL = "SELECT receitaID AS ID, imagemURL AS URL
						FROM receitas
						WHERE autor_ID=$idDoUsuario";
				$dadosDasImagens = $bancoDeDados->selecionar($SQL);
				foreach ($dadosDasImagens as $dadosDaImagem) {
					$novaURL = str_replace($nomeAntigoSemEspacos,$novoNomeSemEspacos,$dadosDaImagem["URL"]);
					rename('../../../'.$dadosDaImagem["URL"],'../../../'.$novaURL);

					$receitaID = $dadosDaImagem["ID"];
					$SQL = "UPDATE receitas SET imagemURL='$novaURL' WHERE receitaID=$receitaID";
					$alteracao = $bancoDeDados->executar($SQL);
				}
			}
		}

		if($_FILES["foto"]["error"] == 4){
			echo "A FOTO CONTINUA A MESMA";
		}
		else{
			validar_imagem($_FILES["foto"]);

			if(!$erroAoAtualizar){
				$imagemAntiga = '../../../'.$_SESSION["usuario"]["IMAGEM"];
				unlink($imagemAntiga);
				$_SESSION["usuario"]["IMAGEM"] = 'imgs/usuarios/default.jpg';

				$nomeDoUsuario = str_replace(' ', '_', $_SESSION["usuario"]["NOME"]);
				$extensaoDaImagem = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
				$fotoURL = 'imgs/usuarios/'.$nomeDoUsuario.strval(rand(0,9999)).'.'.$extensaoDaImagem;

				$destino = '../../../'.$fotoURL;
				if(move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)){
					$SQL = "UPDATE usuarios SET fotoURL='$fotoURL' WHERE usuarioID=$idDoUsuario";
					$alteracao = $bancoDeDados->executar($SQL);

					if(!$alteracao){
						echo "NÃO FOI POSSÍVEL ENVIAR A IMAGEM AO SERVIDOR";
					}
				}
				else{
					echo "NÃO FOI POSSÍVEL ENVIAR A IMAGEM";
				}

				$_SESSION["usuario"]["IMAGEM"] = $fotoURL;
			}
			else{
				echo "ENVIE UMA IMAGEM MENOR QUE 2MB E COM EXTENSÃO VÁLIDA";
			}
		}

		if($usuario["senha"] != $novaSenha){
			$SQL = "UPDATE usuarios SET senha='$novaSenha' WHERE usuarioID=$idDoUsuario";
			$resposta = $bancoDeDados->executar($SQL);

			if(!$resposta){
				$erroAoAtualizar = true;
				echo "<center><strong>OCORREU UM ERRO AO ATUALIZAR A SUA SENHA!</strong></center><br> Tente Novamente Mais Tarde!";
			}
		}

		if(!$erroAoAtualizar){
			header('Location: ../../../seu_usuario.php');
		}
	}

	// função de validação da imagem
	function validar_imagem($dadosDaImagem){
		$nomeDaImagemEnviada = $dadosDaImagem["name"];
		$extensaoDaImagem = strtolower(pathinfo($nomeDaImagemEnviada, PATHINFO_EXTENSION));
		$extensoesValidas = array('gif','png','jpg','jpeg','jpe','jfif','heif','heic');

		if(!in_array($extensaoDaImagem,$extensoesValidas)){ 
			$erroAoAtualizar = true;
			echo "Erro na extensão</br>";
		}

		$tamanhoDaImagem = $dadosDaImagem["size"]/1024; # pega o tamanho da imagem em KB
		if($tamanhoDaImagem > 2048 || $dadosDaImagem["error"] == 1){
			$erroAoAtualizar = true;
			echo "Imagem é muito grande</br>";
		}
	}
?>