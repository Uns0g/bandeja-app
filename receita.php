<?php
	session_start();
	include "classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$id = $_GET["rID"];

	$SQL = "SELECT *, usuarios.nome AS autor
			FROM receitas
			INNER JOIN usuarios ON receitas.autor_ID=usuarios.usuarioID
			WHERE receitaID=$id";
	$resposta = $bancoDeDados->selecionar($SQL);
		if($resposta){?>
			<html>
				<head>
					<meta charset="UTF-8">
					<meta name="keywords" content="bandeja, receitas, ingredientes">
					<meta name="description" content="Página de cadastro de Bandeja">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
					<link href="estilos/core.css" rel="stylesheet">
					<link href="estilos/receita.css" rel="stylesheet">
					<title><?php echo $resposta[0]["titulo"].' - '.$resposta[0]["autor"];?></title>
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
					<main class="receita">
						<h2 class="titulo"><?php echo $resposta[0]["titulo"];?></h2>
						<div class="receita__foto" style="background-image: url('<?php echo $resposta[0]["imagemURL"];?>');"></div>
						<section class="informacao">
						<?php
							$visitanteID = $_SESSION["usuario"]["ID"];
							$SQL = "SELECT receita_ID FROM favoritos WHERE receita_ID=$id AND usuario_ID=$visitanteID";
							$receitaFavorita = $bancoDeDados->selecionar($SQL)[0]["receita_ID"];
							if(empty($receitaFavorita)){?>
								<div class="informacao__box" onclick="window.location.href='scripts/php/receitas/atualizarFavoritos.php?rID=<?php echo $id;?>&uID=<?php echo $visitanteID;?>&inc=1'">
									<i class="ri-star-fill informacao__icone informacao__icone--favorito"></i>
									<span class="informacao__texto">
										<strong class="receita__numero-favoritos">
											<?php echo $resposta[0]["favoritos_numeros"];?>	
										</strong>
									<?php
										if($resposta[0]["favoritos_numeros"] == 1){
											echo ' Favorito';
										}
										else{
											echo ' Favoritos';
										}
									?>
									</span>
								</div>
						<?php
							}
							else{?>
								<div class="informacao__box" onclick="window.location.href='scripts/php/receitas/atualizarFavoritos.php?rID=<?php echo $id;?>&uID=<?php echo $visitanteID;?>&inc=-1'">
									<i class="ri-star-fill informacao__icone informacao__icone--favorito-ativo"></i>
									<span class="informacao__texto">
										<strong class="receita__numero-favoritos">
											Retirar Favorito
										</strong>
									</span>
								</div>
						<?php
							}
						?>
							<div class="informacao__box" onclick="window.location.href='usuario.php?uID=<?php echo $resposta[0]["autor_ID"];?>';">
								<i class="ri-user-fill informacao__icone informacao__icone--autor"></i>
								<span class="informacao__texto">
									<strong class="receita__autor"><?php echo $resposta[0]["autor"];?></strong>
								</span>
							</div>
							<div class="informacao__box">
								<i class="ri-timer-line informacao__icone"></i>
								<span class="informacao__texto"><?php echo $resposta[0]["tempo"];?></span>
							</div>
							<div class="informacao__box">
								<i class="ri-pie-chart-2-line informacao__icone"></i>
								<span class="informacao__texto"><?php echo $resposta[0]["rendimento"];?></span>
							</div>
						</section>
						<hr class="receita__divisoria">
				<?php
						if($resposta[0]["descricao"]){?>
							<div class="campo">
								<h3 class="campo__titulo">Descrição</h3>
								<div class="campo__conteudo">
									<?php echo $resposta[0]["descricao"];?>
								</div>
								<div class="campo__bandeja"></div>
							</div>
				<?php
						}
				?>
						<div class="campo">
							<h3 class="campo__titulo">Ingredientes</h3>
							<div class="campo__conteudo">
								<ul class="campo__lista">
								<?php
									$SQL = "SELECT unidades, ingredientes.nome FROM ingredientes_receitas
										 	INNER JOIN ingredientes ON ingredientes_receitas.ingrediente_ID=ingredientes.ingredienteID
										 	WHERE receita_ID=$id";
									$ingredientes = $bancoDeDados->selecionar($SQL);
									foreach ($ingredientes as $ingrediente){?>
										<li class="campo__item">
											<?php echo $ingrediente["unidades"].' '.$ingrediente["nome"];?>
										</li>
								<?php
									}
								?>
								</ul>
							</div>
							<div class="campo__bandeja"></div>
						</div>
						<hr class="receita__divisoria">
						<div class="campo">
							<h3 class="campo__titulo">Como Fazer</h3>
							<div class="campo__conteudo">
								<?php echo $resposta[0]["preparo"];?>
							</div>
							<div class="campo__bandeja"></div>
						</div>
						<hr class="receita__divisoria">
						<section class="secao-comentarios" id="comentarios">
							<h3 class="secao-comentarios__titulo">Comentários <i class="secao-comentarios__icone ri-arrow-up-s-line"></i></h3>
							<?php
								$SQL = "SELECT * FROM comentarios WHERE receita_ID=$id AND autor_ID=$visitanteID";
								$resposta = $bancoDeDados->selecionar($SQL);
								if(empty($resposta)){?>
									<form action="scripts/php/comentarios/criarComentario.php" method="POST" class="comentario comentario--seu">
										<div class="comentario__usuario">
											<div class="comentario__usuario-foto" style="background-image: url('<?php echo $_SESSION["usuario"]["IMAGEM"];?>');"></div>
											<span class="comentario__usuario-nome"><?php echo $_SESSION["usuario"]["NOME"];?></span>
										</div>
										<textarea class="comentario__texto" name="conteudo" placeholder="Comente o que achou da receita!"></textarea>
										<div style="display: none;">
											<input type="number" name="autorID" value="<?php echo $visitanteID;?>">
											<input type="number" name="receitaID" value="<?php echo $id;?>">
										</div>
										<div class="comentario__acoes">
											<button class="comentario__botao" id="botao-enviar">
												<i class="ri-send-plane-fill comentario__botao-icone"></i>
												<span class="comentario__botao-texto">Enviar</span>
											</button>
										</div>
									</form>
							<?php
								}
								else{?>
									<form action="scripts/php/comentarios/excluirComentario.php" method="POST" class="comentario comentario--seu">
										<div class="comentario__usuario">
											<div class="comentario__usuario-foto" style="background-image: url('<?php echo $_SESSION["usuario"]["IMAGEM"];?>');"></div>
											<span class="comentario__usuario-nome"><?php echo $_SESSION["usuario"]["NOME"];?></span>
										</div>
										<textarea class="comentario__texto" name="conteudo" placeholder="Edite seu comentário" disabled><?php echo $resposta[0]["conteudo"];?></textarea>
										<div style="display: none;">
											<input type="number" name="comentarioID" value="<?php echo $resposta[0]["comentarioID"];?>">
											<input type="number" name="receitaID" value="<?php echo $id;?>">
										</div>
										<div class="comentario__acoes">
											<button type="button" class="comentario__botao" id="botao-editar">
												<i class="ri-edit-box-line comentario__botao-icone"></i>
												<span class="comentario__botao-texto">Editar</span>
											</button>
											<button type="button" class="comentario__botao comentario__botao--escondido" id="botao-voltar">
												<i class="ri-arrow-go-back-fill comentario__botao-icone"></i>
												<span class="comentario__botao-texto">Voltar</span>
											</button>
											<button class="comentario__botao comentario__botao--escondido" id="botao-enviar">
												<i class="ri-send-plane-fill comentario__botao-icone"></i>
												<span class="comentario__botao-texto">Enviar</span>
											</button>
										</div>
										<button class="comentario__botao comentario__botao--remove">
											<i class="ri-close-line comentario__botao-icone"></i>
										</button>
									</form>
							<?php
								}

								$SQL = "SELECT conteudo, usuarios.nome AS autor, usuarios.fotoURL AS foto
										FROM comentarios
										INNER JOIN usuarios ON comentarios.autor_ID=usuarios.usuarioID
										WHERE receita_ID=$id AND autor_ID<>$visitanteID";
								$resposta = $bancoDeDados->selecionar($SQL);

								if(!empty($resposta)){?>
									<section class="outros-comentarios">
							<?php
									foreach ($resposta as $receita) {?>
										<div class="comentario">
											<div class="comentario__usuario">
												<div class="comentario__usuario-foto" style="background-image: url('<?php echo $receita["foto"];?>');"></div>
												<span class="comentario__usuario-nome"><?php echo $receita["autor"];?></span>
											</div>
											<textarea class="comentario__texto" disabled>
												<?php echo $receita["conteudo"];?>
											</textarea>
										</div>
							<?php
									}
								}
							?>
									</section>
						</section>
					</main>
					<nav class="menu">
						<div class="menu__botoes-container">
							<div class="menu__botao  menu__botao--ativo" onClick="window.location.href='pesquisa.php';">
								<i class="ri-search-line"></i>
							</div>
							<div class="menu__botao" onClick="window.location.href='seu_usuario.php';">
								<i class="ri-user-3-fill"></i>
							</div>
						</div>
					</nav>
				</body>
				<script type="text/javascript" src="scripts/js/receita.js"></script>
			</html>
<?php
		}
?>
					<!--<div class="comentario comentario--seu" id="seu-comentario">
						<div class="comentario__usuario">
							<div class="comentario__usuario-foto" style="background-image: url('https://images.unsplash.com/photo-1564564321837-a57b7070ac4f?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1176&q=80');"></div>
							<span class="comentario__usuario-nome">Lorem Ipsum Hello man</span>
						</div>
						<textarea class="comentario__texto" name="comentario-do-usuario" placeholder="Edite seu comentário" disabled>
Cum tacent clament, Cum tacent clament, Serva ne, Servan tuter,Servan servan tuter

[Interlude]

Dum inter homines, Sumus colamus Humanitatem, Cum tacent clame.
						</textarea>
						<button class="comentario__botao comentario__botao--remove">
							<i class="ri-close-line comentario__botao-icone"></i>
						</button>
						<div class="comentario__acoes">
							<button class="comentario__botao">
								<i class="ri-edit-box-line comentario__botao-icone"></i>
								<span class="comentario__botao-texto">Editar</span>
							</button>
							<button class="comentario__botao comentario__botao--escondido">
								<i class="ri-send-plane-fill comentario__botao-icone"></i>
								<span class="comentario__botao-texto">Enviar</span>
							</button>
						</div>
					</div>-->