const LISTA_DE_INGREDIENTES_EL = document.querySelector(".ingredientes__lista");
const INGREDIENTE_EL = LISTA_DE_INGREDIENTES_EL.querySelector(".ingredientes__linha");

const INGREDIENTE_CAMPO_EL = LISTA_DE_INGREDIENTES_EL.querySelector('.campo__texto-ingrediente');
INGREDIENTE_CAMPO_EL.addEventListener('input', function(){ manipularInput(this)});

const BOTAO_REMOVER_EL = INGREDIENTE_EL.querySelector(".campo__icone-x");
BOTAO_REMOVER_EL.addEventListener('click', () => INGREDIENTE_EL.remove());

const ADICIONAR_INGREDIENTE_EL = document.querySelector(".adicionar-ingrediente__botao");
ADICIONAR_INGREDIENTE_EL.addEventListener('click', () =>{
	excluirListaDeSugestoes();
	let outroIngrediente = adicionarOutroIngrediente();
	LISTA_DE_INGREDIENTES_EL.appendChild(outroIngrediente);

	let campoIngrediente = outroIngrediente.querySelector('.campo__texto-ingrediente');
	campoIngrediente.addEventListener('input', function(){ manipularInput(this)});

	let botaoRemoverIngrediente = outroIngrediente.querySelector(".campo__icone-x");
	botaoRemoverIngrediente.addEventListener('click', () => outroIngrediente.remove());
});

function adicionarOutroIngrediente(){
	let outroIngrediente = INGREDIENTE_EL.cloneNode(true);
	
	let campos = outroIngrediente.querySelectorAll('input');
	campos.forEach(campo => campo.value = '');

	return outroIngrediente;
}

function manipularInput(input){
	input.value = input.value.toUpperCase();

	if(input.value.length >= 3){
		excluirListaDeSugestoes();
		let lista = document.createElement("optiongroup");
		lista.className = 'sugestoes';

		input.parentElement.appendChild(lista);

		adicionarSugestao('"'+input.value+'"');

		let ultimoItem = lista.querySelector("option");
		ultimoItem.classList.add('sugestoes__item-digitado');

		removerSugestoesAnteriores();
		procurarIngrediente(input.value);
	}
}

function excluirListaDeSugestoes(){
	let lista = document.querySelector('.sugestoes');
	if(lista){ lista.remove();}
}

function adicionarSugestao(sugestao){
	let listaDeSugestoes = document.querySelector('.sugestoes');

	let listaItem = document.createElement("option");
	listaItem.className = 'sugestoes__item';
	listaItem.textContent = sugestao;

	listaDeSugestoes.appendChild(listaItem);

	listaItem.addEventListener('click', () => transferirNomeParaInput(listaItem.textContent, listaDeSugestoes.previousElementSibling));
}

function transferirNomeParaInput(nome, input){
	excluirListaDeSugestoes();
	
	nome = nome.replaceAll('"','');
	input.value = nome;
}

function removerSugestoesAnteriores(){
	let sugestoesAnteriores = document.querySelectorAll('.sugestoes__item:nth-child(n+2)');
	sugestoesAnteriores.forEach(sugestaoAnterior => sugestaoAnterior.remove());
}

/* Assíncrona */
async function procurarIngrediente(valor){
	// para assegurar que será convertido para upper na consulta ao banco
	let nomeDoIngrediente = valor.toUpperCase();
	
	let resposta = await fetch('./scripts/php/buscarIngrediente.php?nome='+nomeDoIngrediente);
	let dados = await resposta.json();
	if(dados.length > 0){
		dados.forEach((dado) => adicionarSugestao(dado.nome));
	}
	else{
		let primeiroItem = document.querySelector('.sugestoes__item-digitado');
		primeiroItem.innerHTML += ' <small class="sugestoes__mensagem-de-erro">INGREDIENTE NÃO CADASTRADO</small>';
		primeiroItem.classList.add('sugestoes__item-digitado--errado');
	}
}