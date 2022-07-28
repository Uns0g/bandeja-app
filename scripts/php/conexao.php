<?php
	define('SERVIDOR', 'localhost');
	define('USUARIO', 'root');
	define('SENHA', 'pass'); // deve mudar depois para ''
	define('BANCO', 'bandeja');

	try{
		$PDO = new PDO("mysql:host=".SERVIDOR.";dbname=".BANCO, USUARIO, SENHA);
	}
	catch (PDOException $erro){
		echo "";
	}
?>