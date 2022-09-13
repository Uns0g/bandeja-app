<?php
	session_start(); 
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="keywords" content="bandeja, receitas, ingredientes">
		<meta name="description" content="Página de cadastro de Bandeja">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
		<link href="estilos/core.css" rel="stylesheet">
		<link href="estilos/forms.css" rel="stylesheet">
		<link href="estilos/usuario.css" rel="stylesheet">
		<link href="estilos/elemento_receita.css" rel="stylesheet">
		<title>Seu Usuário</title>
	</head>
	<body>
		<header class="header">
			<div class="header__logo-container">
				<div class="header__icone">
					<svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="65.625000pt" height="51.562500pt" viewBox="0 0 700.000000 551.000000" preserveAspectRatio="xMidYMid meet">
						<metadata>
							Created by potrace 1.12, written by Peter Selinger 2001-2015
						</metadata>
						<g transform="translate(0.000000,551.000000) scale(0.100000,-0.100000)" fill="#F28705" stroke="none">
							<path d="M3550 5411 c-94 -31 -168 -100 -203 -189 -14 -35 -18 -66 -15 -121 2
							-58 0 -75 -12 -81 -8 -5 -69 -16 -135 -25 -114 -15 -159 -24 -312 -61 -76 -19
							-321 -98 -368 -119 -16 -8 -59 -26 -95 -40 -128 -53 -306 -151 -476 -263 -207
							-136 -483 -390 -643 -590 -155 -195 -336 -493 -401 -662 -11 -30 -25 -64 -30
							-75 -38 -84 -96 -261 -123 -380 -30 -129 -46 -210 -51 -255 -21 -183 -29 -226
							-44 -237 -11 -9 -68 -13 -199 -13 l-183 0 0 -28 c0 -70 64 -190 129 -241 85
							-67 118 -75 328 -79 106 -2 193 -8 193 -12 0 -17 -13 -40 -22 -40 -20 0 -167
							-95 -282 -183 -200 -152 -549 -461 -544 -482 5 -24 1166 -1195 1184 -1195 7 0
							103 54 213 120 l200 120 1213 0 c1156 0 1214 1 1241 18 15 10 391 384 836 830
							488 490 817 813 832 816 13 3 231 7 484 8 l460 3 55 26 c90 42 190 153 190
							210 0 9 7 22 15 29 8 7 15 28 15 46 l0 34 -188 0 c-136 0 -193 3 -204 12 -9 8
							-18 37 -22 68 -4 30 -11 93 -16 140 -6 47 -17 117 -26 155 -26 118 -56 237
							-64 259 -4 12 -18 55 -30 96 -13 41 -26 80 -30 85 -4 6 -15 33 -25 60 -116
							321 -350 678 -630 961 -235 236 -466 408 -750 555 -294 153 -630 260 -950 304
							-66 9 -127 20 -135 25 -12 6 -14 24 -12 87 3 69 0 88 -21 134 -28 61 -84 119
							-142 150 -44 22 -163 34 -205 20z m1543 -3467 c13 -14 -9 -36 -81 -79 -43 -25
							-113 -71 -157 -102 -103 -73 -472 -353 -551 -418 -271 -225 -334 -273 -367
							-276 -18 -2 -288 -2 -602 1 l-570 5 -50 25 c-114 57 -410 281 -410 311 0 12
							81 15 565 20 543 5 568 6 635 27 84 26 212 91 269 135 74 58 170 163 216 237
							25 40 55 83 67 96 l22 24 504 0 c277 0 506 -3 510 -6z"></path>
						</g>
					</svg>
				</div>
				<h1 class="header__titulo">Bandeja</h1>
			</div>
		</header>
		<main>
			<section class="secao">
				<div class="usuario-card">
					<div class="usuario-card__imagem" style="background-image: url('<?php echo $_SESSION["usuario"]["IMAGEM"];?>');"></div>
					<h2 class="usuario-card__nome"><?php echo $_SESSION["usuario"]["NOME"];?></h2>
				</div>
				<div class="acao">
					<button class="acao__botao acao__botao--inativo">
						<i class="ri-star-fill acao__icone"></i>
						<span class="acao__descricao"><b class="acao__contador-favoritos">0</b> Favoritos</span>
					</button>
					<button class="acao__botao" id="cadastrar-ingrediente">
						<i class="ri-leaf-fill acao__icone"></i>
						<span class="acao__descricao">Cadastrar Ingrediente</span>
					</button>
					<button class="acao__botao" onclick="window.location.href = 'cadastrar_receita.php';">
						<i class="ri-add-circle-fill acao__icone"></i>
						<span class="acao__descricao">Criar Receita</span>
					</button>
					<div class="acao acao--com-menu">
						<button class="acao__botao" id="sua-conta-botao">
							<i class="ri-user-fill acao__icone"></i>
							<span class="acao__descricao">Sua Conta</span>
						</button>
						<ul class="menu-conta menu-conta--escondido">
							<li  
								class="menu-conta__botao"
								onClick="window.location.href='index.php';">
								<i class="menu-conta__icone ri-logout-box-line"></i> Sair Da Conta
							</li>
							<li 
								class="menu-conta__botao"
								onClick="window.location.href='editar_usuario.php';">
								<i class="menu-conta__icone ri-edit-box-line"></i> Editar Conta
							</li>
							<li class="menu-conta__botao" id="excluir-conta">
								<i class="menu-conta__icone ri-delete-bin-line"></i> Excluir Conta
							</li>
						</ul>
					</div>
				</div>
			</section>
			<section class="secao">
				<p class="secao__titulo"><span>Minhas Receitas</span> <i class="ri-arrow-down-s-line secao__seta"></i></p>
				<div class="secao__container">
					<div class="receita">
						<div class="receita__imagem"></div>
						<div class="receita__descricao">
							<h3 class="receita__nome">Cachorro Quente</h3>
							<p class="receita__texto">
								Dignissimos sed voluptatem ad veritatis. Porro aut quo minus sed blanditiis ex sit. Vero architecto eius rerum molestiae totam quia voluptatum harum.
							</p>
						</div>
						<div class="receita__acoes">
							<button class="receita__acao-remove">
								<i class="ri-close-line receita__remove-icone"></i>
							</button>
							<button class="receita__acao-edita">
								<i class="ri-edit-box-line receita__edita-icone"></i>
								<span class="receita__acao-texto">Editar Receita</span>
							</button>
						</div>
						<div class="receita__informacoes">
							<div class="receita__info-container">
								<i class="ri-star-s-fill receita__info-icone"></i>
								<span class="receita__info-box"><em class="receita__total-favoritos">0 Favoritos</em></span>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="secao secao--direita">
				<p class="secao__titulo"><span>Meus Favoritos</span> <i class="ri-arrow-down-s-line secao__seta"></i></p>
				<div class="secao__container">
					<div class="receita">
						<div class="receita__imagem" style="background-image: url('');"></div>
						<div class="receita__descricao">
							<h3 class="receita__nome">Lili Ipsumni</h3>
							<p class="receita__texto">
								Error sequi reiciendis iusto dignissimos sit consequatur. Eius consequatur sed similique cumque. Et eius ea accusantium temporibus.
							</p>
						</div>
						<div class="receita__acoes">
							<button class="receita__acao-favorito">
								<i class="ri-star-fill receita__favorito-icone receita__favorito-icone--active"></i>
								<span class="receita__acao-texto">Retirar Favorito</span>
							</button>
						</div>
						<div class="receita__informacoes">
							<div class="receita__info-container">
								<i class="ri-star-s-fill receita__info-icone"></i>
								<span class="receita__info-box"><em class="receita__total-favoritos">0 Favoritos</em></span>
							</div>
							<div class="receita__info-container">
								<i class="ri-timer-line receita__info-icone"></i>
								<span class="receita__info-box"><em class="receita__tempo">15 min.</em></span>
							</div>
							<div class="receita__info-container">
								<i class="ri-pie-chart-2-line receita__info-icone"></i>
								<span class="receita__info-box"><em class="receita__porcoes">1 Porção</em></span>
							</div>
							<div class="receita__info-container">
								<i class="ri-user-fill receita__info-icone"></i>
								<span class="receita__info-box"><strong class="receita__autor">Ipsum Lorem</strong></span>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>	
<?php
		if(!isset($_SESSION["ingrediente-invalido"])){?>
			<div class="form-background form-background--escondido">
				<form class="form-acao form-acao--escondido" method="POST" action="scripts/php/cadastrarIngrediente.php">
					<label for="ingrediente" class="form-acao__texto">Cadastre Um Novo Ingrediente</label>
					<input type="text" name="ingrediente" class="form-acao__input" id="input" placeholder="Nome do ingrediente">
					<div class="form-acao__botoes">
						<input type="reset" class="form-acao__cancelar" value="Cancelar">
						<input type="submit" class="form-acao__enviar" value="Enviar">
					</div>
				</form>

				<form class="form-acao form-acao--escondido" method="POST" action="">
					<label for="input" class="form-acao__texto">TEM CERTEZA QUE DESEJA EXCLUIR?</label>
					<div class="form-acao__botoes">
						<input type="button" class="form-acao__cancelar" value="NÃO">
						<input 
							type="submit" 
							class="form-acao__enviar" 
							value="SIM" 
							onClick="window.location.href='scripts/php/excluirUsuario.php?usuario=<?php echo $_SESSION["usuario"]["NOME"];?>';">
					</div>
				</form>
			</div>
<?php 	}
		else{?>
			<div class="form-background">
				<form class="form-acao" method="POST" action="scripts/php/cadastrarIngrediente.php">
					<label for="ingrediente" class="form-acao__texto">Cadastre Um Novo Ingrediente</label>
					<input type="text" name="ingrediente" class="form-acao__input form-acao__input--errado" id="input" placeholder="O ingrediente '<?php echo $_SESSION["ingrediente-invalido"];?>' já foi cadastrado!">
					<div class="form-acao__botoes">
						<input type="reset" class="form-acao__cancelar" value="Cancelar">
						<input type="submit" class="form-acao__enviar" value="Enviar">
					</div>
				</form>

				<form class="form-acao form-acao--escondido" method="POST" action="">
					<label for="input" class="form-acao__texto">TEM CERTEZA QUE DESEJA EXCLUIR?</label>
					<div class="form-acao__botoes">
						<input type="button" class="form-acao__cancelar" value="NÃO">
						<input 
							type="submit" 
							class="form-acao__enviar" 
							value="SIM" 
							onClick="window.location.href='scripts/php/excluirUsuario.php?usuario=<?php echo $_SESSION["usuario"]["NOME"];?>';">
					</div>
				</form>
			</div>
<?php 	}?>
		<nav class="menu">
			<div class="menu__botoes-container" onClick="window.location.href = 'pesquisa.php';">
				<div class="menu__botao">
					<i class="ri-search-line"></i>
				</div>
				<div class="menu__botao menu__botao--ativo">
					<i class="ri-user-3-fill"></i>
				</div>
			</div>
		</nav>
	</body>
	<script src="scripts/js/usuario.js"></script>
</html>