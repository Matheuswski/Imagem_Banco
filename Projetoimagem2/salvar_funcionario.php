<?php
function redimensionarImagem($imagem, $largura, $altura){
    list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);


//CRIA UMA NOVA IMAGEM EM BRANCO COM NOVAS DIMENSOES
//imagecreatetruecolor() CRIA UMA NOVA IMAGEM EM BRANCO COM ALTA QUALIDADE
    $novaImagem = imagecreatetruecolor($largura, $altura);
    
    //CARREGA A IMAGEM ORIGINAL(JPEG) APARTIR DO AQUIVO
    //imagecreatefromjpeg() CRIA A IMAGEM PHP A PARTIR DE UM JPEG
    $imagemOriginal = imagecreatefromjpeg($imagem);
    
    // COPIA E REDIMENSIONA A IMAGEM ORIGINAL PARA A NOVA 
    //imagecopyresampled() COPIA E REDIMENSIONAMENTO E SUAVIZAÇÃO
    imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
    
    //INICIA UM BUFFER PARA GUARDAR A IMAGEM COMO TEXTO BINARIO
    // ob_start() INICIA O "output buffering" GUARDANDO A SAIDA
    ob_start();
    //imagejep()ENVIA A IMAGEM PARA O OUTPUT(QUEVAI PRO BUFFER)
    imagejpeg($novaImagem);

    //OB_GET_CLEAN() -- PEGAR O CONTEUDO DO BUFFER E LIMPA O BUFFER
    $dadosImagem = ob_get_clean();

    //LIBERA A MEMÓRIA USADA PELAS IMAGEMS
    //imagendestroy() LIBERA A MEMÓRIA USADA PELA IMAGEM
    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    //RETORNA A IMAGEM REDIMENSIONADA EM FORMATO BINARIO
    return $dadosImagem;
}
    //CONFIGURAÇÂO DO BANCO DE DADOS
    $host = "localhost";
    $dbname = "armazena_imagem";
    $dbusername = "root";
    $password = "";

    try{
        $pdo = new PDO("mysql:host=$host;dbname:$dbname", $username,)
    }
?>