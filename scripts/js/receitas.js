const TITULO_EL = document.querySelector('.receitas__titulo');
const CONTAINER_EL = document.querySelector('.receitas__container');

TITULO_EL.addEventListener('click', function(){
	this.lastElementChild.classList.toggle('receitas__seta--girar');
	CONTAINER_EL.classList.toggle('receitas__container--abrir');
});

