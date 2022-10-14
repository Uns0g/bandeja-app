const SECAO_TITULO_EL = document.querySelector(".secao__titulo");
SECAO_TITULO_EL.addEventListener('click', function(){
	this.lastElementChild.classList.toggle('secao__seta--subir');
	this.nextElementSibling.classList.toggle('secao__container--abrir');
});

const RECEITA_CONTAINER_ELS = document.querySelectorAll('.receita-container');
RECEITA_CONTAINER_ELS.forEach((RECEITA_CONTAINER_EL) =>{
	let botaoFavorito = RECEITA_CONTAINER_EL.querySelector('.receita__acao-favorito');

	let receitaID = RECEITA_CONTAINER_EL.id;
	let usuarioID = botaoFavorito.dataset.usuarioid;

	RECEITA_CONTAINER_EL.addEventListener('click', function(){
		let urlParaReceita = 'ver_receita.php?rID='+receitaID;
		window.location.href = urlParaReceita;
	})

	botaoFavorito.addEventListener('click', (ev) =>{
		ev.stopPropagation();

		let urlParaAlterarFavorito = `scripts/php/receitas/atualizarFavoritos.php?rID=${receitaID}&uID=${usuarioID}&inc=`;
		if(botaoFavorito.firstElementChild.className.includes('receita__favorito-icone--ativo')){
			urlParaAlterarFavorito += '-1';
		}
		else{
			urlParaAlterarFavorito += '1';
		}

		window.location.href = urlParaAlterarFavorito;
	});
});