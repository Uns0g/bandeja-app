<?php
	include("classeConexao.php");
	
	class Usuario{
		// Atributos
		private $usuarioID;
		private $nome;
		private $urlFoto;
		private $senha;
	
		// Método Construtor
		function __construct($idInserido,$nomeInserido,$urlInserida,$senhaInserida){
			$this->usuarioID = $idInserido;
			$this->nome = $nomeInserido;
			$this->senha = $senhaInserida;
			$this->urlFoto = $urlInserida;
		}
	
		// Métodos CRUD
	}
?>