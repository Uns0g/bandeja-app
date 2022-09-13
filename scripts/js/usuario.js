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