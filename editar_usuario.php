<?php
	include "classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();
	session_start();

	$nomeDoUsuario = $_SESSION["usuario"]["NOME"];

	$SQL = "SELECT senha FROM usuarios WHERE nome = '$nomeDoUsuario'";
	$senha = $bancoDeDados->selecionar($SQL)[0]["senha"];
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
		<title>Editando Perfil De <?php echo $nomeDoUsuario;?></title>
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
			<h2 class="titulo">Alterar Seu Usuário</h2>
			<form action="scripts/php/usuarios/editarUsuario.php" class="form form--editar" enctype="multipart/form-data" method="POST">
				<input type="number" name="usuarioID" style="display: none;">
				<input type="text" name="nome" class="form__input" placeholder="Mudar de nome de usuário" value="<?php echo $nomeDoUsuario;?>">
				<label class="form__input form__input--foto" style="background-image: url('<?php echo $_SESSION["usuario"]["IMAGEM"];?>');">
					<input type="file" name="foto">
					<span class="form__input-botao-enviar-foto">Envie uma nova foto (opcional)</span>
				</label>
				<input type="password" name="senha" class="form__input" placeholder="Crie uma nova senha" value="<?php echo $senha;?>">
				<input type="submit" class="form__botao" value="Enviar">
			</form>
			<p class="aviso">Mudou de ideia? <a href="seu_usuario.php" class="aviso__link">Voltar</a></p>
		</main>
	</body>
</html>
