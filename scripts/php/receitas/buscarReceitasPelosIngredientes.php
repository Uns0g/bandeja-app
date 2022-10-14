<?php
	session_start();
	$nome = $_SESSION["usuario"]["NOME"];

	include "../../../classes/classeConexao.php";

	$ingredientes = explode(',',$_GET['ingredientes']);
	if(!empty($ingredientes)){
		$bancoDeDados = new BancoDeDados();
		/* Buscando favoritos do usuario */
		$SQL = "SELECT receita_ID
			FROM favoritos
			INNER JOIN usuarios ON favoritos.usuario_ID=usuarios.usuarioID
			WHERE usuarios.nome='$nome'";
		$resultado = $bancoDeDados->selecionar($SQL);

		$listaDeFavoritos = [];
		if($resultado){
			for($i = 0; $i<sizeof($resultado); $i++){
				array_push($listaDeFavoritos,$resultado[$i]["receita_ID"]);
			}
		}

		/* Buscando Receitas */
		$SQL = "SELECT COUNT(receitaID) AS numIngredientes, receitas.*, usuarios.nome AS autor
			FROM ingredientes_receitas 
			INNER JOIN receitas ON ingredientes_receitas.receita_ID=receitas.receitaID
			INNER JOIN ingredientes ON ingredientes_receitas.ingrediente_ID=ingredientes.ingredienteID 
			INNER JOIN usuarios ON receitas.autor_ID=usuarios.usuarioID  
			WHERE ingredientes.nome='$ingredientes[0]'";
		for($i = 1; $i < sizeof($ingredientes); $i++){
			$SQL.= "OR ingredientes.nome='$ingredientes[$i]'";
		}
		$SQL.= "GROUP BY receitaID ORDER BY COUNT(receitaID) DESC, COUNT(favoritos_numeros) DESC 
				LIMIT 40";
		$resposta = $bancoDeDados->selecionar($SQL);

		if($resposta){
			if(!empty($listaDeFavoritos)){
				for($i = 0; $i < sizeof($resposta); $i++){
					if(in_array($resposta[$i]["receitaID"], $listaDeFavoritos)){
						$resposta[$i]["favoritado"] = true;
					}
				}
			}
			$dados = $resposta;
		}
		else{
			$dados = ['erro' => true, 'mensagem' => "NÃO EXISTE NENHUMA RECEITA COM ESSES INGREDIENTES"];
		}
	}
	else{
		$dados = ['erro' => true, 'mensagem' => "NENHUM INGREDIENTE FOI INFORMADO"];
	}

	echo json_encode($dados);
?>