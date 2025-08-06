<?php
require_once ('conecta.php');

//OBTEM OS DADOS ENVIADOS PELO FORMULARIO
$evento = $_POST['evento'];
$descricao = $_POST['descricao'];
$imagem = $_FILES['imagem']['tmp_name'];
$tamanho = $_FILES['imagem']['size'];
$tipo = $_FILES['imagem']['type'];
$nome = $_FILES['imagem']['name'];

//VERIFICA SE O ARQUIVO FOI ENVIADO CORRETAMENTE    
if(!empty($imagem) && $tamanho >0){
    //LÊ O CONTEUDO DO ARQUIVO
    $fp = fopen($imagem, "rb");
    $conteudo = fread($fp, filesize($imagem));
    fclose($fp);

    //PROTEGE CONTRA PROBLEMAS DE CARACTERES NO SQL
    $conteudo = mysqli_real_escape_string($conexao, $conteudo);


    //DADOS DE CARACTERES NO SQL        
    $querySelecao = "INSERT INTO tabela_imagens (evento, descricao, nome_imagem, tamanho_imagem, tipo_imagem, imagem)
    VALUES ('$evento', '$descricao', '$nome', '$tamanho', '$tipo', '$conteudo')";
    $resultado = mysqli_query($conexao, $querySelecao);

    //VERIFICA SE A INSERÇÃO FO BEM SUSSEDIDA
    if($resultado ){
        echo"Registro inserido com sucesso!";
        header("Location: index.php");
        exit();
    } else {
        die("Erro ao inserir no banco: " . mysqli_error($conexao));
    }
} else {
    echo "Erro nenhuma imagem foi enviada.";
}
?> 