/* Aparecer e desaparecer menu */
const SUA_CONTA_EL = document.getElementById('sua-conta-botao');
const MENU_CONTA_EL = document.querySelector('.menu-conta');

SUA_CONTA_EL.addEventListener('click', () => MENU_CONTA_EL.classList.toggle('menu-conta--escondido'))

/* Aparecer formulários*/
const FORM_CONTAINER_EL = document.querySelector('.form-background');

const CADASTRAR_INGREDIENTE_EL = document.getElementById('cadastrar-ingrediente');
CADASTRAR_INGREDIENTE_EL.addEventListener('click', () =>{
	FORM_CONTAINER_EL.classList.remove('form-background--escondido');

	FORM_CONTAINER_EL.firstElementChild.classList.remove('form-acao--escondido');
});
const EXCLUIR_CONTA_EL = document.getElementById('excluir-conta');
EXCLUIR_CONTA_EL.addEventListener('click', function(){
	this.parentElement.classList.add('menu-conta--escondido');

	FORM_CONTAINER_EL.classList.remove('form-background--escondido');

	FORM_CONTAINER_EL.lastElementChild.classList.remove('form-acao--escondido');
});

/* Desaparecer formulários */
const CANCELAR_ACAO_ELS = document.querySelectorAll('.form-acao__cancelar');
CANCELAR_ACAO_ELS.forEach(BTN => BTN.addEventListener('click', () =>{
	FORM_CONTAINER_EL.firstElementChild.classList.add('form-acao--escondido');
	FORM_CONTAINER_EL.lastElementChild.classList.add('form-acao--escondido');

	FORM_CONTAINER_EL.classList.add('form-background--escondido');
}));
	

/* Seções de receitas */
const SECAO_TITULO_ELS = document.querySelectorAll('.secao__titulo');
SECAO_TITULO_ELS.forEach(SECAO_TITULO_EL => {
	SECAO_TITULO_EL.addEventListener('click', function(){
		this.lastElementChild.classList.toggle('secao__seta--subir');
		this.nextElementSibling.classList.toggle('secao__container--abrir')
	});
});

/* Elementos De Minhas Receitas */
const MINHAS_RECEITAS_ELS = document.querySelectorAll("#minhas-receitas .receita-container");
MINHAS_RECEITAS_ELS.forEach(MINHA_RECEITA_EL => {
	/* receita */
	let receita = MINHA_RECEITA_EL.firstElementChild;
	let receitaID = receita.dataset.receitaid;
	receita.addEventListener('click', function(){
		let urlParaReceita = `ver_receita.php?rID=${receitaID}`;
		window.location.href = urlParaReceita;
	});

	let formularioReceita = MINHA_RECEITA_EL.querySelector('.receita-form');

	let botaoAparecerFormulario = receita.querySelector(".receita__acao-remove");
	botaoAparecerFormulario.addEventListener('click', (ev) => {
		ev.stopPropagation();

		formularioReceita.action = `scripts/php/receitas/excluirReceita.php?receitaID=${receitaID}`;
		formularioReceita.method = 'GET';

		mudarDeTelaParaReceita(receita,formularioReceita);
	});

	let botaoEditarReceita = receita.querySelector(".receita__acao-edita");
	botaoEditarReceita.addEventListener('click', (ev) =>{
		ev.stopPropagation(); 
		formularioReceita.submit();
	});

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

/* Elementos De Receitas Favoritas */
const RECEITAS_FAVORITAS_ELS = document.querySelectorAll('#favoritos .receita-container');
RECEITAS_FAVORITAS_ELS.forEach((RECEITA_FAVORITA_EL) =>{
	let receitaID = RECEITA_FAVORITA_EL.dataset.receitaid;

	RECEITA_FAVORITA_EL.addEventListener('click', () =>{
		let urlParaReceita = `ver_receita.php?rID=${receitaID}`;
		window.location.href = urlParaReceita;
	});

	let botaoAutor = RECEITA_FAVORITA_EL.querySelector('.receita__botao-autor');
	botaoAutor.addEventListener('click', (ev) =>{
		ev.stopPropagation();

		let urlParaUsuario = `usuario.php?uID=${botaoAutor.dataset.autorid}`;
		window.location.href = urlParaUsuario;
	});

	let botaoFavorito = RECEITA_FAVORITA_EL.querySelector('.receita__acao-favorito');
	botaoFavorito.addEventListener('click', (ev) =>{
		ev.stopPropagation();
		// adicionar 
	});
});