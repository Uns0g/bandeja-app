const SECAO_TITULO_EL = document.querySelector(".secao__titulo");
SECAO_TITULO_EL.addEventListener('click', function(){
	this.lastElementChild.classList.toggle('secao__seta--subir');
	this.nextElementSibling.classList.toggle('secao__container--abrir');
});


const RECEITA_CONTAINER_ELS = document.querySelectorAll('.receita-container');
RECEITA_CONTAINER_ELS.forEach((RECEITA_CONTAINER_EL) =>{
	RECEITA_CONTAINER_EL.addEventListener('click', function(){
		let urlParaReceita = 'ver_receita.php?rID='+this.id;
		window.location.href = urlParaReceita;
	})

	let botaoFavorito = RECEITA_CONTAINER_EL.querySelector('.receita__acao-favorito');
	botaoFavorito.addEventListener('click', (ev) =>{
		ev.stopPropagation();

		let urlParaFavorito = 'scripts/php/atualizarFavoritos?incremento=';
	});
});