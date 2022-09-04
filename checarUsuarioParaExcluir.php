<?php
session_start();
if($_SESSION["usuario"]){ echo "A sessão está rodando";}

include("../../classes/classeConexao.php");
$bancoDeDados = new BancoDeDados();

}
?>