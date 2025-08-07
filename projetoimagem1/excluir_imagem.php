<?php
require_once('conecta.php');

//OBTEM O ID VIA GET GARANTIDO QUE SEJA UM NUEMERO INTEIRO
$id_imagem = isset($_GET['id']) ? intval($_GET['id']) : 0;

//VERIFICA SE O ID É VÁLIDO(maior que zero)
if ($id_imagem > 0) {
    //CRIA UMA QUERY SEGURA USANDO PREPARED STATEMENT
    $queryExcluir = "DELETE FROM tabela_imagens WHERE codigo = ?";
    
    //PREPARA A QUERY
    $stmt = $conexao->prepare($queryExclusao);
    $stmt->bind_param("i", $id_imagem);  //DEFINE O id COMO UM INTEIRO
    
    //EXECUTA A EXCLUSÃO
    if ($stmt->execute()) {
        echo "Imagem excluída com sucesso!";
    } else {
        die("Erro ao excluir a imagem: " . $stmt->error);
    }
    
    //FECHA A CONSULTA
    $stmt->close();
} else {
    echo "ID inválido.";
}

//REDIRECIONA PARA O INDEX.PHP E GARANTE SCRIPTPARE
header("Location: index.php");
exit();
?>