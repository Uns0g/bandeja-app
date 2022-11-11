/* alterando descricoes */
let descricoes = document.querySelectorAll('.receita__texto');
descricoes.forEach(descricao =>{
	descricao.innerHTML = descricao.innerHTML.replaceAll('\t','');
});

const SECAO_TITULO_EL = document.querySelector(".secao__titulo");
SECAO_TITULO_EL.addEventListener('click', function(){
	this.lastElementChild.classList.toggle('secao__seta--subir');
	this.nextElementSibling.classList.toggle('secao__container--abrir');
});

const RECEITA_CONTAINER_ELS = document.querySelectorAll('.receita-container');
RECEITA_CONTAINER_ELS.forEach((RECEITA_CONTAINER_EL) =>{
	let receitaDescricao = RECEITA_CONTAINER_EL.querySelector('.receita__texto');
	receitaDescricao.innerHTML = receitaDescricao.innerHTML.replaceAll('\t','');

	let receitaID = RECEITA_CONTAINER_EL.id;

	RECEITA_CONTAINER_EL.addEventListener('click', function(){
		let urlParaReceita = 'receita.php?rID='+receitaID;
		window.location.href = urlParaReceita;
	})

	let botaoFavorito = RECEITA_CONTAINER_EL.querySelector('.receita__acao-favorito');
	botaoFavorito.addEventListener('click', (ev) =>{
		ev.stopPropagation();

		let visitanteID = botaoFavorito.dataset.visitanteid;
		let urlParaAlterarFavorito = `scripts/php/receitas/atualizarFavoritos.php?rID=${receitaID}&uID=${visitanteID}&inc=`;
		if(botaoFavorito.firstElementChild.className.includes('receita__favorito-icone--ativo')){
			urlParaAlterarFavorito += '-1';
		}
		else{
			urlParaAlterarFavorito += '1';
		}

		window.location.href = urlParaAlterarFavorito;
	});
});