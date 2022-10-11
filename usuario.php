<?php
	session_start();
	include "classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$id = $_GET["uID"];

	$SQL = "SELECT nome,fotoURL FROM usuarios WHERE usuarioID=$id";
	$dadosDoUsuario = $bancoDeDados->selecionar($SQL);
		if($dadosDoUsuario){?>
			<html>
				<head>
					<meta charset="UTF-8">
					<meta name="keywords" content="bandeja, receitas, ingredientes">
					<meta name="description" content="Página de cadastro de Bandeja">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
					<link href="estilos/core.css" rel="stylesheet">
					<link href="estilos/usuario.css" rel="stylesheet">
					<link href="estilos/elemento_receita.css" rel="stylesheet">
					<title>Página De <?php echo $dadosDoUsuario[0]["nome"];?></title>
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
								<div class="usuario-card__imagem" style="background-image: url('<?php echo $dadosDoUsuario[0]["fotoURL"];?>');"></div>
								<h2 class="usuario-card__nome"><?php echo $dadosDoUsuario[0]["nome"];?></h2>
							</div>
							<div class="acao">
								<div></div>
								<button class="acao__botao acao__botao--inativo">
									<i class="ri-star-fill acao__icone"></i>
									<span class="acao__descricao">
									<?php
										$SQL = "SELECT COUNT(receita_ID) AS numFavoritos 
												FROM favoritos
												INNER JOIN receitas ON favoritos.receita_ID=receitas.receitaID
												WHERE receitas.autor_ID=$id";
										$totalDeFavoritos = $bancoDeDados->selecionar($SQL)[0]["numFavoritos"];
										if($totalDeFavoritos == 1){
											echo '1 Favorito';
										}
										else{
											echo $totalDeFavoritos.' Favoritos';
										}
									?>
									</span>
								</button>
								<div></div>
							</div>
						</section>
						<section class="secao">
							<p class="secao__titulo"><span>Últimas Receitas de <?php echo $dadosDoUsuario[0]["nome"];?></span> <i class="ri-arrow-down-s-line secao__seta"></i></p>
							<div class="secao__container">
						<?php
								$nome = $_SESSION["usuario"]["NOME"];
								$SQL = "SELECT receita_ID
										FROM favoritos
										INNER JOIN usuarios ON favoritos.usuario_ID=usuarios.usuarioID
										WHERE usuarios.nome='$nome'";
								$resultado = $bancoDeDados->selecionar($SQL);

								$listaDeFavoritos = [];
								for($i = 0; $i<sizeof($resultado); $i++){
									array_push($listaDeFavoritos,$resultado[$i]["receita_ID"]);
								}
								
								$SQL = "SELECT * FROM receitas 
										WHERE autor_ID=$id";
								$receitas = $bancoDeDados->selecionar($SQL);
								if($receitas){
									foreach ($receitas as $receita){?>
										<div class="receita-container" id="<?php echo $receita["receitaID"];?>">
											<div class="receita">
												<div class="receita__imagem" style="background-image: url('<?php echo $receita["imagemURL"];?>');"></div>
												<div class="receita__descricao">
													<h3 class="receita__nome"><?php echo $receita["titulo"];?></h3>
													<p class="receita__texto"><?php echo $receita["descricao"];?></p>
												</div>
												<div class="receita__acoes">
													<button class="receita__acao-favorito">
													<?php
															if(!in_array($receita["receitaID"],$listaDeFavoritos)){?>
																<i class="ri-star-fill receita__favorito-icone"></i>
																<span class="receita__acao-texto">
																<?php
																	if($receita["favoritos_numeros"] == 1){
																		echo '1 Favorito';
																	}
																	else{
																		echo $receita["favoritos_numeros"].' Favoritos';
																	}?>
																</span>
													<?php 	}
															else{?>
																<i class="ri-star-fill receita__favorito-icone receita__favorito-icone--ativo"></i>
																<span class="receita__acao-texto">
																	Retirar Favorito
																</span>
													<?php  	}?>
														</span>
													</button>
												</div>
												<div class="receita__informacoes">
												<?php
													if(in_array($receita["receitaID"],$listaDeFavoritos)){?>
														<div class="receita__info-container">
															<i class="ri-star-s-fill receita__info-icone receita__info-icone--favorito"></i>
															<span class="receita__info-box">
																<em class="receita__total-favoritos">
																<?php 
																	if($receita["favoritos_numeros"] != 1){
																		echo $receita["favoritos_numeros"].' Favoritos';
																	}
																	else{
																		echo '1 Favorito';
																	}
																?>
																</em>
															</span>
														</div>
											<?php	}?>
													<div class="receita__info-container">
														<i class="ri-timer-line receita__info-icone"></i>
														<span class="receita__info-box">
															<em class="receita__tempo">
																<?php echo $receita["tempo"];?>	
															</em>
														</span>
													</div>
													<div class="receita__info-container">
														<i class="ri-pie-chart-2-line receita__info-icone"></i>
														<span class="receita__info-box">
															<em class="receita__porcoes">
																<?php echo $receita["rendimento"];?>
															</em>
														</span>
													</div>
												</div>
											</div>
										</div>
							<?php 	}?>
						<?php 	}?>

								
								
							</div>
						</section>
					</main>
					<nav class="menu">
						<div class="menu__botoes-container">
							<div class="menu__botao" onClick="window.location.href='pesquisa.php';">
								<i class="ri-search-line"></i>
							</div>
							<div class="menu__botao menu__botao--ativo" onClick="window.location.href='seu_usuario.php';">
								<i class="ri-user-3-fill"></i>
							</div>
						</div>
					</nav>
				</body>
				<script type="text/javascript" src="scripts/js/usuario.js"></script>
			</html>
<?php
		}
?>