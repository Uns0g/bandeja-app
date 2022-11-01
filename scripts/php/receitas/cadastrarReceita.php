<?php
	session_start();

	include "../../../classes/classeReceita.php";
	$receita = new Receita($_POST["titulo"],$_POST["preparo"],$_SESSION["usuario"]["NOME"]);

	/* Conexão com o banco de dados */ 
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$autorID = $_SESSION["usuario"]["ID"];

	/* Variáveis opcionais ou indefinidas */
	$medidas = $ingredientes = $fotoURL = NULL;

	# se houver uma sessão de usuário ativa
	if(isset($_SESSION["usuario"])){
		// preenchendo variáveis opcionais
		if(!empty($_POST["tempo"])){ $receita->set_tempo($_POST["tempo"]);}

		if(!empty($_POST["porcoes"])){ $receita->set_rendimento($_POST["porcoes"]);}

		if(!empty($_POST["descricao"])){ $receita->set_descricao($_POST["descricao"]);}

		#print_r($receita);
		verificar_validade_da_imagem($_FILES["imagem"], $receita);

		if(isset($_POST["medidas"]) && isset($_POST["ingredientes"])){
			$medidas = $_POST["medidas"];
			$ingredientes = $_POST["ingredientes"];
		}
		else{
			voltar_para_pagina_anterior("cadastro-invalido",'NENHUM INGREDIENTE FOI CADASTRADO');
		}

		# inserindo receita no banco de dados
		$SQL = "INSERT INTO receitas(titulo,imagemURL,tempo,autor_ID,rendimento,descricao,preparo) 
				VALUES('$receita->titulo','$receita->imagemURL','$receita->tempo',$autorID,'$receita->rendimento','$receita->descricao','$receita->preparo')";
		$insercao = $bancoDeDados->executar($SQL);

		# se houve inserção
		if($insercao){
			# selecionando o ID da última receita que o usuário cadastrou (receita correta)
			$SQL = "SELECT receitaID FROM receitas WHERE autor_ID=$autorID ORDER BY receitaID DESC LIMIT 1";
			$resposta = $bancoDeDados->selecionar($SQL);
			$receitaID = $resposta[0]["receitaID"];

			# pegando ids dos ingredientes informados
			$ingredientes = buscar_IDs_dos_ingredientes($bancoDeDados,$ingredientes);

			# inserindo em ingredientes_receitas
			$SQL = "INSERT INTO ingredientes_receitas(unidades,ingrediente_ID,receita_ID) VALUES";
			for ($i=0; $i < sizeof($ingredientes); $i++) { 
				if($i != sizeof($ingredientes)-1){
					$SQL.="('$medidas[$i]',$ingredientes[$i],$receitaID),";
				}
				else{
					$SQL.="('$medidas[$i]',$ingredientes[$i],$receitaID);";
				}
			}
			$insercao = $bancoDeDados->executar($SQL);

			if(!$insercao){
				voltar_para_pagina_anterior("erro-na-insercao",'OCORREU ALGUM ERRO INESPERADO COM "$medidas[$i] $ingredientes[$i]"!');
			}
			else{
				# SE TUDO DER CERTO
				header('Location: ../../../seu_usuario.php#ultima-receita');
			}
		}
		else{
			echo "<strong style='color: #8C0303; text-align: center; display: block; font-size: 1.6em;'>OCORREU UM ERRO INESPERADO AO ENVIAR PARA O BANCO DE DADOS!</strong><br/>";
		}
	}
	else{
		header('Location: ../../../erro/nenhum_usuario.php');
	}

	function verificar_validade_da_imagem($arquivoImagem, $objetoReceita){
		if($arquivoImagem["error"] == 0){
			$extensao = strtolower(pathinfo($arquivoImagem["name"], PATHINFO_EXTENSION));
			$extensoesValidas = array('gif','png','jpg','jpeg','jpe','jfif','heif','heic');

			# se o tamanho não for adeq	uado
			if($arquivoImagem["size"]/1024 > 3072){
				voltar_para_pagina_anterior("imagem-invalida", 'O ARQUIVO NÃO PODE SER MAIOR QUE 3MB!');
			}
			else if(!in_array($extensao, $extensoesValidas)){ # se a extensão não for válida
				voltar_para_pagina_anterior("imagem-invalida", 'O ARQUIVO DEVE TER UMA EXTENSÃO VÁLIDA!');
			}
			else{ # caso tudo esteja certo
				$fotoURL = $objetoReceita->gerar_url_para_imagem('.'.$extensao);
				if(move_uploaded_file($_FILES["imagem"]["tmp_name"], '../../../'.$fotoURL)){
					$objetoReceita->set_imagemURL($fotoURL);
					echo "IMAGEM ENVIADA COM SUCESSO!<br/>";
				}
				else{
					echo "<strong style='color: #8C0303; text-align: center; display: block; font-size: 1.6em;'>OCORREU UM ERRO INESPERADO E A FOTO NÃO PÔDE SER ENVIADA AO SERVIDOR DE DESTINO!</strong><br/>";
					echo $objetoReceita->get_imagemURL();
				}
			}
		}
		else{
			voltar_para_pagina_anterior("imagem-invalida", 'OCORREU ALGUM ERRO AO ENVIAR A IMAGEM');
		}
	}

	function voltar_para_pagina_anterior($sessaoDeErro, $mensagem){
		$_SESSION[$sessaoDeErro] = $mensagem;
		echo '<b>'.$mensagem.'</b><br/>';
		// header('Location: ../../../cadastrar_receita.php');
	}

	function buscar_IDs_dos_ingredientes($objetoDoBancoDeDados,$nomesDosIngredientes){
		$listaDeIDs = array();
		for ($i=0; $i < sizeof($nomesDosIngredientes); $i++) { 
			$SQL = "SELECT ingredienteID FROM ingredientes WHERE nome = '$nomesDosIngredientes[$i]';";
			$resposta = $objetoDoBancoDeDados->selecionar($SQL);
			
			array_push($listaDeIDs, $resposta[0]["ingredienteID"]);
		}

		return $listaDeIDs;
	}
?>