const MINHAS_RECEITAS_ELS = document.querySelectorAll("#minhas-receitas .receita-container");

MINHAS_RECEITAS_ELS.forEach(MINHA_RECEITA_EL => {
	/* receita */
	let receita = MINHA_RECEITA_EL.firstElementChild;
	let receitaID = receita.dataset.receitaid;

	let formularioReceita = MINHA_RECEITA_EL.querySelector('.receita-form');

	let botaoAparecerFormulario = receita.querySelector(".receita__acao-remove");
	botaoAparecerFormulario.addEventListener('click', () => {
		formularioReceita.action = `scripts/php/receitas/excluirReceita.php?receitaID=${receitaID}`;
		formularioReceita.method = 'GET';

		mudarDeTelaParaReceita(receita,formularioReceita);
	});

	let botaoEditarReceita = receita.querySelector(".receita__acao-edita");
	botaoEditarReceita.addEventListener('click', () => formularioReceita.submit());

	/* formulario */
	let botarCancelarFormulario = formularioReceita.querySelector(".receita-form__botao--cancelar");
	botarCancelarFormulario.addEventListener('click', () => {
		formularioReceita.action = 'editar_receita.php';
		formularioReceita.method = 'POST';

		mudarDeTelaParaReceita(formularioReceita,receita);
	});

	let botaoExcluirReceita = formularioReceita.querySelector('.receita-form__botao--excluir');
	botaoExcluirReceita.addEventListener('click', () => formularioReceita.submit());
});

function mudarDeTelaParaReceita(elementoParaApagar,elementoParaAparecer){
	let alturaDoElemento = elementoParaApagar.offsetHeight;

	elementoParaApagar.setAttribute('style', 'display: none; min-height: 0');
	elementoParaAparecer.setAttribute('style', `display: grid; min-height: ${alturaDoElemento}px;`);
}