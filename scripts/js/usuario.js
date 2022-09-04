if(window.location.href.includes('seu_usuario.html')){
	const USUARIO_BOX_EL = document.querySelector('.usuario--seu');
	const USUARIO_EXCLUIR_BTN_EL = document.getElementById('botao-excluir');
	
	const CADASTRAR_INGREDIENTE_BTN_EL = document.getElementById('cadastrar-ingrediente-botao');
	
	const FORM_BACKGROUND_EL = document.querySelector('.form-background');
	const CANCELAR_ACAO_BTN_ELS = document.querySelectorAll('.form-acao__cancelar');
	
	let rotate = 0;
	USUARIO_BOX_EL.addEventListener('click', ()=>{
		rotate -= 180
		USUARIO_BOX_EL.firstElementChild.style = `transform: rotateY(${rotate}deg);`;
	});
	
	USUARIO_EXCLUIR_BTN_EL.addEventListener('click', (ev) =>{
		ev.stopPropagation();
		
		FORM_BACKGROUND_EL.classList.remove('form-background--hidden');
		FORM_BACKGROUND_EL.firstElementChild.classList.add('form-acao--hidden');
		FORM_BACKGROUND_EL.lastElementChild.classList.remove('form-acao--hidden');
	});
	
	CADASTRAR_INGREDIENTE_BTN_EL.addEventListener('click', () => {
		FORM_BACKGROUND_EL.classList.remove('form-background--hidden');
		FORM_BACKGROUND_EL.firstElementChild.classList.remove('form-acao--hidden');
		FORM_BACKGROUND_EL.lastElementChild.classList.add('form-acao--hidden');
	});
	
	CANCELAR_ACAO_BTN_ELS.forEach((CANCELAR_ACAO_BTN) =>{
		CANCELAR_ACAO_BTN.addEventListener('click', ()=> FORM_BACKGROUND_EL.classList.add('form-background--hidden'));
	});
}
const SECAO_TITULO_ELS = document.querySelectorAll('.secao__titulo');

SECAO_TITULO_ELS.forEach(SECAO_TITULO_EL => {
	SECAO_TITULO_EL.addEventListener('click', function(){
		this.lastElementChild.classList.toggle('secao__seta--subir');
		this.nextElementSibling.classList.toggle('secao__container--abrir')
	});
});