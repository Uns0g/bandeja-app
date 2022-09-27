<?php
	class Receita{
		/* Atributos públicos */
		public $titulo;
		public $imagemURL;
		public $tempo;
		public $autor;
		public $rendimento;
		public $descricao;
		public $preparo;

		// Método Construtor
		function __construct($nome,$comoFazer,$nomeDoAutor){
			$this->titulo = $nome;
			$this->imagemURL = "imgs/receitas/default.jpg";
			$this->tempo = 'Não Informado';
			$this->autor = $nomeDoAutor;
			$this->rendimento = 'Não Informado';
			$this->descricao = 'Não Informado';
			$this->preparo = $comoFazer;
		}

		/* Getters */
		function get_imagemURL(){
			return $this->imagemURL;
		}

		function get_autor(){
			return $this->autor;
		}

		/* Setters */
		function set_imagemURL($fotoURL){
			$this->imagemURL = $fotoURL;
		}

		function set_autor($valor){
			$this->autor = $valor;
		}

		function set_tempo($tempoDePreparo){
			$this->tempo = $tempoDePreparo;
		}

		function set_rendimento($porcoes){
			$this->rendimento = $porcoes;
		}

		function set_descricao($descricao){
			$this->descricao = $descricao;
		}

		/* Outras Funções */
		# tentar colocar static
		function gerar_url_para_imagem($extensaoDaImagem){
			$nomeDoAutorNaURL = strtolower(str_replace(' ','-',$this->autor));
			$tituloNaURL = $this->tirar_caracteres_latinos(strtolower(str_replace(' ','_',$this->titulo)));

			$this->imagemURL = 'imgs/receitas/'.$nomeDoAutorNaURL.'__'.$tituloNaURL.strval(rand(0,9999)).$extensaoDaImagem;
			return $this->imagemURL;
		}

		// colocar como private depois
		function tirar_caracteres_latinos($texto){
			return strtr(utf8_decode($texto),utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûü'),'aaaaaceeeeiiiinooooouuuu');
		}
	}
?>