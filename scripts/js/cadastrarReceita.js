import { manipularInput, excluirListaDeSugestoes } from "./buscarIngredientes.js";

const LISTA_DE_INGREDIENTES_EL = document.querySelector(".ingredientes__lista");
const INGREDIENTE_ELS = LISTA_DE_INGREDIENTES_EL.querySelectorAll(".ingredientes__linha");
INGREDIENTE_ELS.forEach(INGREDIENTE_EL => aplicarFuncoesNosElementos(INGREDIENTE_EL));

const ADICIONAR_INGREDIENTE_EL = document.querySelector(".adicionar-ingrediente__botao");
ADICIONAR_INGREDIENTE_EL.addEventListener('click', () =>{
	excluirListaDeSugestoes();
	let outroIngrediente = adicionarOutroIngrediente();
	LISTA_DE_INGREDIENTES_EL.appendChild(outroIngrediente);

	aplicarFuncoesNosElementos(outroIngrediente);
});

function aplicarFuncoesNosElementos(elementoPai){
	let campoIngrediente = elementoPai.querySelector(".campo__texto-ingrediente");
	campoIngrediente.addEventListener('input', function(){ manipularInput(this)});

	let botaoRemoverIngrediente = elementoPai.querySelector(".campo__icone-x");
	botaoRemoverIngrediente.addEventListener('click', () =>{ elementoPai.remove()});
}

const PRIMEIRO_ELEMENTO_INGREDIENTE = LISTA_DE_INGREDIENTES_EL.querySelector(".ingredientes__linha");
function adicionarOutroIngrediente(){
	let outroIngrediente = PRIMEIRO_ELEMENTO_INGREDIENTE.cloneNode(true);
	
	let campos = outroIngrediente.querySelectorAll('input');
	campos.forEach(campo => campo.value = '');

	return outroIngrediente;
}