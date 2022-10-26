import { manipularInput, excluirListaDeSugestoes, buscarIngredientesNoBanco } from './buscarIngredientes.js';

/* seção de ingredientes */
const PESQUISA_INGREDIENTE_EL = document.getElementById('pesquisa-ingrediente');
window.onload = () => {
	PESQUISA_INGREDIENTE_EL.value = '';
};

PESQUISA_INGREDIENTE_EL.addEventListener('input', function(){ manipularInput(this);});
PESQUISA_INGREDIENTE_EL.addEventListener('keydown', async (ev) =>{
	if(ev.key == 'Enter'){
		await criarElementoDeIngrediente(ev.target.value.toUpperCase());
		await exibirReceitas();
	}
});

const BOTAO_PESQUISA_EL = document.querySelector('.pesquisa__botao');
BOTAO_PESQUISA_EL.addEventListener('click', async () =>{
	await criarElementoDeIngrediente(PESQUISA_INGREDIENTE_EL.value.toUpperCase());
	await exibirReceitas();
});

const INGREDIENTES_CONTAINER_EL = document.querySelector(".ingredientes__container");
async function criarElementoDeIngrediente(nome){
	let elementoIngrediente = document.createElement('div');
	elementoIngrediente.classList.add('ingredientes__elemento');
	elementoIngrediente.textContent = nome;
	elementoIngrediente.onclick = async function(){
		this.remove();
		await exibirReceitas();
	}; 

	let ingredienteExiste = await buscarIngredientesNoBanco(nome);
	if(ingredienteExiste.erro){	elementoIngrediente.classList.add('ingredientes__elemento--errado')}

	INGREDIENTES_CONTAINER_EL.appendChild(elementoIngrediente);
}

async function exibirReceitas(){
	excluirListaDeSugestoes();
	abrirContainerReceitas();
	PESQUISA_INGREDIENTE_EL.value = '';
	let receitas = await buscarReceitas();
	receitas.forEach((receita) => criarElementoReceita(receita));
}

const SETA_EL = document.querySelector('.receitas__seta');
const CONTAINER_EL = document.querySelector('.receitas__container');
function abrirContainerReceitas(){
	CONTAINER_EL.innerHTML = null;

	SETA_EL.classList.add('receitas__seta--girar');
	CONTAINER_EL.classList.add('receitas__container--abrir');
}

async function buscarReceitas(){
	let urlParaBusca = 'scripts/php/receitas/buscarReceitasPelosIngredientes.php?ingredientes=';

	let elementosIngredientes = document.querySelectorAll('.ingredientes__elemento');
	elementosIngredientes.forEach((elemento) => urlParaBusca += elemento.textContent+',');

	urlParaBusca = urlParaBusca.slice(0,-1);

	let resposta = await fetch(urlParaBusca);
	let dados = await resposta.json();
	return dados;
}

function criarElementoReceita(receita){
	let receitaContainer = document.createElement('div');
	receitaContainer.className = 'receita-container';

	receitaContainer.innerHTML = 
	`<div class="receita" data-receitaid="${receita.receitaID}">
		<div class="receita__imagem" style="background-image: url('${receita.imagemURL}');"></div>
		<div class="receita__descricao">
			<h3 class="receita__nome">${receita.titulo}</h3>
			<p class="receita__texto">
				${receita.descricao}
			</p>
		</div>
		<div class="receita__acoes">
			<button class="receita__acao-favorito">
				<i class="ri-star-fill receita__favorito-icone"></i>
				<strong class="receita__acao-texto">Favoritar</strong>
			</button>
		</div>
		<div class="receita__informacoes">
			<div class="receita__info-container">
				<i class="ri-star-s-fill receita__info-icone receita__info-icone--favorito"></i>
				<span class="receita__info-box">
					<em class="receita__total-favoritos">
						${(receita.favoritos_numeros != 1) ? receita.favoritos_numeros + ' Favoritos' : '1 Favorito'}
					</em>
				</span>
			</div>
			<div class="receita__info-container">
				<i class="ri-timer-line receita__info-icone"></i>
				<span class="receita__info-box"><em class="receita__tempo">${receita.tempo}</em></span>
			</div>
			<div class="receita__info-container">
				<i class="ri-pie-chart-2-line receita__info-icone"></i>
				<span class="receita__info-box"><em class="receita__porcoes">${receita.rendimento}</em></span>
			</div>
			<div class="receita__info-container receita__botao-autor" data-usuarioID="${receita.autor_ID}">
				<i class="ri-user-fill receita__info-icone receita__info-icone--autor"></i>
				<span class="receita__info-box"><strong class="receita__autor">${receita.autor}</strong></span>
			</div>
		</div>
	</div>`;

	receitaContainer.addEventListener('click', () =>{
		let urlParaReceita = 'receita.php?rID='+receitaContainer.firstElementChild.dataset.receitaid;
		window.location.href = urlParaReceita;
	});

	if(receita.favoritado){
		let botaoFavorito = receitaContainer.querySelector('.receita__acao-favorito');

		botaoFavorito.firstElementChild.classList.add('receita__favorito-icone--ativo');
		botaoFavorito.lastElementChild.textContent = 'Retirar Favorito';
	}
	adicionarFuncoesAosBotoes(receitaContainer);
	
	CONTAINER_EL.appendChild(receitaContainer);
}

function adicionarFuncoesAosBotoes(elementoReceita){
	let receitaID = elementoReceita.firstElementChild.dataset.receitaid;

	let botaoAutor = elementoReceita.querySelector('.receita__botao-autor');
	botaoAutor.addEventListener('click', (ev) => {
		ev.stopPropagation();

		let usuarioID = botaoAutor.dataset.usuarioid;
		let urlParaUsuario = `usuario.php?uID=${usuarioID}`;
		window.location.href = urlParaUsuario;
	});

	let botaoFavorito = elementoReceita.querySelector('.receita__acao-favorito');
	botaoFavorito.addEventListener('click', (ev) =>{
		ev.stopPropagation();

		let visitanteID = PESQUISA_INGREDIENTE_EL.dataset.pesquisador;
		let urlParaAlterarFavorito = `scripts/php/receitas/atualizarFavoritos.php?rID=${receitaID}&uID=${visitanteID}&inc=`;
		if(botaoFavorito.firstElementChild.className.includes('receita__favorito-icone--ativo')){
			urlParaAlterarFavorito += '-1';
		}
		else{
			urlParaAlterarFavorito += '1';
		}

		window.location.href = urlParaAlterarFavorito;
	});
}

/* seção de receitas */
const TITULO_EL = document.querySelector(".receitas__titulo");
TITULO_EL.addEventListener('click', () => {
	SETA_EL.classList.toggle('receitas__seta--girar');
	CONTAINER_EL.classList.toggle('receitas__container--abrir');
});