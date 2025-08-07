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

//CRIA A SEGURANÇA UTILIZANDO PREPARED PARA MAIOR SEGURANÇA
$stmt = $conexao->prepare($querySelecionaPorCodigo);
$stmt->bind_param("i", $id_imagem,);
$stmt->execute();
$resultado = $stmt->get_result();

//VERIFICA SE A IMAGEM EXISTE NO BANCO DE DADOS
if($resultado->num_rows > 0) {
$imagem = $resultado->fetch_object();

//DEFINE O TIPO CORRETO DA IMAGEM (FALBACK PARA JPEG CASO ESTEJA VEZIO)
$tipoImagem = !empty($imagem->tipo_imagem) ? $imagem->tipo_imagem : 'image/jpeg';
header('Content-Type: ' . $tipoImagem);

//EXIBE A IMAGEM ARMAZENADA NO BANCO DE DADOS
echo $imagem->imagem;
} else {
    echo "Imagem não encontrada.";
}

//FECHA A CONSULTA
$stmt->close();
?>