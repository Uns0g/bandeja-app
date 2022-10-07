import { manipularInput, excluirListaDeSugestoes } from "./buscarIngredientes.js";

const LISTA_DE_INGREDIENTES_EL = document.querySelector(".ingredientes__lista");
const INGREDIENTE_EL = LISTA_DE_INGREDIENTES_EL.querySelector(".ingredientes__linha");

const INGREDIENTE_CAMPO_EL = LISTA_DE_INGREDIENTES_EL.querySelector('.campo__texto-ingrediente');
INGREDIENTE_CAMPO_EL.addEventListener('input', function(){ manipularInput(this)});
INGREDIENTE_CAMPO_EL.addEventListener('keydown', (ev) =>{
	// será usado para manipular as sugestões
	/*if(ev.key == 'ArrowDown'){
		console.log(ev.key);
	}
	else if(ev.key == 'ArrowUp'){
		console.log(ev.key);
	}*/
});

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