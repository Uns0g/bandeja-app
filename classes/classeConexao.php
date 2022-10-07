<?php
	class BancoDeDados{
		private $servidor = "localhost";
		private $usuario = "root";
		private $senha = "pass";
		private $banco = "bandeja";

		function conectar(){
			$conexao = mysqli_connect($this->servidor,$this->usuario,$this->senha,$this->banco);
			return $conexao;
		}

		function selecionar($sql){
			$con = $this->conectar();
			
			$query = mysqli_query($con,$sql);
			if(!$query){
				return false;
			}
			else{
				$dados = false;
				while($registro = mysqli_fetch_assoc($query)){
					$dados[] = $registro;
				}
				return $dados;
			}
		}

		// Create Update Delete
		function executar($sql){
			$con = $this->conectar();

			$query = mysqli_query($con,$sql);
			if(!$query){
				return false;
			}
			else{
				return true;
			}
		}
	}
?>