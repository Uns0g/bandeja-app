const FORM_COMENTARIO_EL = document.querySelector(".comentario--seu");
const COMENTARIO_TEXTO_EL = document.querySelector(".comentario--seu .comentario__texto");

const CONTEUDO_COMENTARIO = COMENTARIO_TEXTO_EL.value;

if(FORM_COMENTARIO_EL.action.includes('excluirComentario.php')){
	let botaoRemover = FORM_COMENTARIO_EL.querySelector('.comentario__botao--remove');
	let botaoEditar = FORM_COMENTARIO_EL.querySelector('#botao-editar');
	let botaoEnviar = FORM_COMENTARIO_EL.querySelector('#botao-enviar');
	let botaoVoltar = FORM_COMENTARIO_EL.querySelector('#botao-voltar');

	botaoEditar.addEventListener('click', function(){
		botaoRemover.classList.add('comentario__botao--escondido');
		this.classList.add('comentario__botao--escondido');
		botaoVoltar.classList.remove('comentario__botao--escondido');
		botaoEnviar.classList.remove('comentario__botao--escondido');

		COMENTARIO_TEXTO_EL.removeAttribute('disabled');

		FORM_COMENTARIO_EL.action = 'scripts/php/comentarios/editarComentario.php';
	});

	botaoVoltar.addEventListener('click', function(){
		this.classList.add('comentario__botao--escondido');
		botaoEnviar.classList.add('comentario__botao--escondido');
		botaoRemover.classList.remove('comentario__botao--escondido');
		botaoEditar.classList.remove('comentario__botao--escondido');

		COMENTARIO_TEXTO_EL.value = CONTEUDO_COMENTARIO;
		COMENTARIO_TEXTO_EL.disabled = true;

		FORM_COMENTARIO_EL.action = 'scripts/php/comentarios/excluirComentario.php';
	});
}