<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ob_clean(); //LIMPA QUALQUER SAIDA INESPERADA ANTES DO HEADER

//INCLUI A CONEXAO COM O BANCO DE DADOS
require_once('conecta.php');

//OBTEM O ID DA IMAGEM DA URL GARANTINDO QUE SEJA UM NUMERO INTEIRO
$id_imagem = isset($_GET['id']) ? intval($_GET['id']) :0;

//CRIA A CONSULTA PARA BUSCAR A IMAGEM NO BANCO DE DADOS
$querySelecionaPorCodigo = "SELECT imagem, tipo_imagem FROM tabela_imagens WHERE codigo = ?";
