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
	else{
		excluirListaDeSugestoes();
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
	let inputDePesquisa = listaDeSugestoes.parentElement.querySelector('input');

	listaItem.addEventListener('click', () => transferirNomeParaInput(listaItem.textContent,inputDePesquisa));
}

function transferirNomeParaInput(nome, input){
	excluirListaDeSugestoes();
	
	nome = nome.replaceAll('"','');
	input.value = nome;
	input.focus();
}

function removerSugestoesAnteriores(){
	let sugestoesAnteriores = document.querySelectorAll('.sugestoes__item:nth-child(n+2)');
	sugestoesAnteriores.forEach(sugestaoAnterior => sugestaoAnterior.remove());
}

/* Assíncrona */
async function procurarIngrediente(valor){
	// para assegurar que será convertido para upper na consulta ao banco
	let nomeDoIngrediente = valor.toUpperCase();
	
	let listaDeIngredientes = await buscarIngredientesNoBanco(nomeDoIngrediente);
	if(listaDeIngredientes.length > 0){
		listaDeIngredientes.forEach((ingrediente) => adicionarSugestao(ingrediente.nome));
	}
	else{
		let primeiroItem = document.querySelector('.sugestoes__item-digitado');
		criarOpcaoParaCadastrarIngrediente(primeiroItem);
		primeiroItem.innerHTML += ' <small class="sugestoes__mensagem-de-erro">INGREDIENTE NÃO CADASTRADO</small>';
		primeiroItem.classList.add('sugestoes__item-digitado--errado');
	}
}

async function buscarIngredientesNoBanco(nomeDoIngrediente){
	let resposta = await fetch('./scripts/php/ingredientes/buscarIngrediente.php?ingredienteNome='+nomeDoIngrediente);
	let dados = await resposta.json();
	return dados;
}

function criarOpcaoParaCadastrarIngrediente(elementoIngredienteErrado){
	let listaDeSugestoes = elementoIngredienteErrado.parentElement;

	let formularioIngrediente = document.createElement('form');
	formularioIngrediente.style.display = 'none';
	formularioIngrediente.action = 'scripts/php/ingredientes/cadastrarIngrediente.php';
	formularioIngrediente.method = 'POST';

	let inputIngrediente = document.createElement('input');
	let nomeDoIngrediente = elementoIngredienteErrado.textContent.replaceAll('"','');
	inputIngrediente.value = nomeDoIngrediente;
	inputIngrediente.name = 'ingrediente';
	console.log(inputIngrediente.value);

	let opcaoCadastrarIngrediente = elementoIngredienteErrado.cloneNode(false);
	opcaoCadastrarIngrediente.classList.remove('sugestoes__item-digitado');
	opcaoCadastrarIngrediente.classList.add('sugestoes__item--cadastrar');
	opcaoCadastrarIngrediente.innerText = 'CADASTRAR ESTE INGREDIENTE';

	formularioIngrediente.appendChild(inputIngrediente);
	opcaoCadastrarIngrediente.appendChild(formularioIngrediente);
	listaDeSugestoes.appendChild(opcaoCadastrarIngrediente);

	opcaoCadastrarIngrediente.addEventListener('click', () => formularioIngrediente.submit());
}

export { manipularInput, excluirListaDeSugestoes, procurarIngrediente, buscarIngredientesNoBanco }