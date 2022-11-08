<?php
	session_start();

	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	include "../../../classes/classeReceita.php";
	$receitaNova = new Receita($_POST["nome"],$_POST["preparo"],$_SESSION["usuario"]["NOME"]);
	$receitaNova->set_tempo($_POST["tempo"]);
	$receitaNova->set_rendimento($_POST["porcoes"]);
	$receitaNova->set_descricao($_POST["descricao"]);

	$autorID = $_SESSION["usuario"]["ID"];
	$receitaID = $_POST["receitaID"];

	$SQL = "SELECT * FROM receitas WHERE receitaID=$receitaID AND autor_ID=$autorID";
	$dadosDaReceitaAntiga = $bancoDeDados->selecionar($SQL)[0];
	$receitaAntiga = new Receita($dadosDaReceitaAntiga["titulo"],$dadosDaReceitaAntiga["preparo"],$dadosDaReceitaAntiga["autor_ID"]);
	$receitaAntiga->set_imagemURL($dadosDaReceitaAntiga["imagemURL"]);
	$receitaAntiga->set_tempo($dadosDaReceitaAntiga["tempo"]);
	$receitaAntiga->set_rendimento($dadosDaReceitaAntiga["rendimento"]);
	$receitaAntiga->set_descricao($dadosDaReceitaAntiga["descricao"]);

	# começo do comando de alterãção
	$SQLAlteracao = "UPDATE receitas SET ";

	// Campos obrigatórios
	if($receitaNova->titulo != $receitaAntiga->titulo){
		$SQLAlteracao.="titulo='$receitaNova->titulo', ";
	}
	if($receitaNova->preparo != $receitaAntiga->preparo){
		$SQLAlteracao.="preparo='$receitaNova->preparo', ";
	}

	// Tratando a imagem
	switch($_FILES["imagem"]["error"]){
		case 0: 
			unlink('../../../'.$receitaAntiga->imagemURL);
			verificar_validade_da_imagem($_FILES["imagem"],$receitaNova);

			$SQLAlteracao.="imagemURL='$receitaNova->imagemURL', ";

			if(!empty($_POST["ingredientes"])){
				atualizando_medidas_ingredientes($bancoDeDados,$receitaID);
			}
			break;
		case 1:
			echo "O ARQUIVO EXCEDE O TAMANHO PERMITIDO <br>";
			break;
		case 3: 
			echo "A IMAGEM FOI PARCIALMENTE ENVIADA <br>";
			break;
		case 4:
			if(!empty($_POST["ingredientes"])){
				atualizando_medidas_ingredientes($bancoDeDados,$receitaID);
			}
			break;
		case 6:
			echo "NÃO FOI ENCONTRADO NENHUM DIRETÓRIO TEMPORÁRIO PARA ARMAZENAR A IMAGEM <br>";
			break;
		case 7:
			echo "A IMAGEM NÃO PÔDE SER ESCRITA NO DISCO <br>";
			break;
		default:
			echo "HOUVE UM ERRO DESCONHECIDO AO ENVIAR A IMAGEM <br>";
			break;
	}

	function verificar_validade_da_imagem($arquivoImagem,$objetoReceita){
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
				echo $objetoReceita->get_imagemURL();
				voltar_para_pagina_anterior("imagem-invalida", "OCORREU UM ERRO INESPERADO E A FOTO NÃO PÔDE SER ENVIADA AO SERVIDOR DE DESTINO!");
			}
		}
	}

	function atualizando_medidas_ingredientes($objetoBancoDeDados,$idDoAlvo){
		$IDsDosIngredientes = buscar_IDs_dos_ingredientes($objetoBancoDeDados,$_POST["ingredientes"]);
		$medidas = $_POST["medidas"]; 

		$SQL = "DELETE FROM ingredientes_receitas WHERE receita_ID=$idDoAlvo";
		$resposta = $objetoBancoDeDados->executar($SQL);

		if($resposta){
			$SQL = "INSERT INTO ingredientes_receitas(unidades,ingrediente_ID,receita_ID) VALUES";
			
			for($i=0; $i < sizeof($IDsDosIngredientes); $i++){
				if($i != sizeof($IDsDosIngredientes)-1){
					$SQL.="('$medidas[$i]',$IDsDosIngredientes[$i],$idDoAlvo),";
				}
				else{
					$SQL.="('$medidas[$i]',$IDsDosIngredientes[$i],$idDoAlvo);";
				}
			}

			$insercao = $objetoBancoDeDados->executar($SQL);
			if(!$insercao){
				voltar_para_pagina_anterior("erro-na-insercao",'OCORREU UM ERRO INESPERADO AO ATUALIZAR OS INGREDIENTES');
			}
			else{
				header('Location: ../../../seu_usuario.php#ultima-receita');
			}
		}
		else{
			echo "OCORREU UM ERRO";
		}
	}

	function buscar_IDs_dos_ingredientes($objetoBancoDeDados,$nomes){
		$listaDeIDs = array();
		for($i=0; $i<sizeof($nomes); $i++){
			$SQL = "SELECT ingredienteID AS ID FROM ingredientes WHERE nome='$nomes[$i]'";
			$idDoIngrediente = $objetoBancoDeDados->selecionar($SQL)[0]["ID"];

			array_push($listaDeIDs,$idDoIngrediente);
		}

		return $listaDeIDs;
	}

	function voltar_para_pagina_anterior($nomeDaSessão,$mensagem){
		echo "$nomeDaSessão => $mensagem<br>";
	}

	// Campos opcionais
	if($receitaNova->tempo != $receitaAntiga->tempo){
		empty($receitaNova->tempo) ? $SQLAlteracao.='tempo=NULL, ' : $SQLAlteracao.="tempo='$receitaNova->tempo', ";
	}
	if($receitaNova->rendimento != $receitaAntiga->rendimento){
		empty($receitaNova->rendimento) ? $SQLAlteracao.='rendimento=NULL, ' : $SQLAlteracao.="rendimento='$receitaNova->rendimento', ";
	}
	if($receitaNova->descricao != $receitaAntiga->descricao){
		empty($receitaNova->descricao) ? $SQLAlteracao.='descricao=NULL, ' : $SQLAlteracao.="descricao='$receitaNova->descricao', ";
	}

	// Fazendo o update 
	$SQLAlteracao = substr($SQLAlteracao, 0, -2);
	$SQLAlteracao.=" WHERE receitaID=$receitaID AND autor_ID=$autorID";
	$alteracao = $bancoDeDados->executar($SQLAlteracao);

	if($alteracao){
		header('Location: ../../../seu_usuario.php#minhas-receitas');
	}
	else{
		echo "<br><b>NÃO FOI POSSÍVEL ALTERAR A RECEITA</b>";
	}
?>