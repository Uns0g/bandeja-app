<?php/*
	include("classeConexao.php");
	
	class Cadastro{
		/*public function autenticar($dados){
			// Verifica dados enviados pelo POST
			foreach ($dados as $chave => $valor) {
				if(empty($valor)){
					$this->erro = $this->erro.$chave." não contem nada";
				}
			}

			if(empty($this->erro)){
				$this->verificarSeUsuarioExiste($dados["nome"]);
			}
			else{
				return $this->erro;
			}
		}

		public function verificarSeUsuarioExiste($nomeDigitado){
			$SQL = "SELECT * FROM usuarios WHERE nome = '$nomeDigitado'";

			$bancoDeDados = new Conexao();
			$resultadoDaRequisicao = $bancoDeDados->selecionar($SQL);
			return $SQL;
			
			// se houver algum usuario com esse nome
			empty($resultadoDaRequisicao) ? false : true;
		}

		public function criarUsuario($dados){
			$nomeDigitado = $dados["nome"];
			$senhaDigitada = $dados["senha"];
			$urlDaFoto = 'imgs/usuarios/'.str_replace(' ','_',$nomeDigitado).strval(rand());

			return $urlDaFoto;
		}
	}*/
?>