<?php
	session_start();
	include "../../../classes/classeConexao.php";
	$bancoDeDados = new BancoDeDados();

	$idDoUsuario = $_SESSION["usuario"]["ID"];
?>