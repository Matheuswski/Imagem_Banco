<?php
    function redimensionarImagem($imagem, $largura, $altura) {
    //OBTEM AS DIMENSÕES ORIGINAIS DA IMAGEM
    // getimagesize() RETORNA UM A A LARGURA E ALTURA DA IMAGEM
    list($larguraOriginal, $alturaOriginal) = getimagesize($imagem);

    //CRIA UMA NOVA IMAGEM EM BRANCO COM AS NOVAS DIMENSÕES 
    //imagecreatetruecolor() CRIA UMA IMAGEM EM BRANCO COM ALTA QUALIDADE
    $novaImagem = imagecreatetruecolor($largura, $altura);

    //CARREGA A IMAGEM ORIGINAL(jpeg) A PARTIR DO ARQUIVO
    //imagecreatefromjpeg() CARREGA UMA IMAGEM JPEG
    $imagemOriginal = imagecreatefromjpeg($imagem);
    //COPIA E REDIMENSIONA A IMAGEM ORIGINAL PARA A NOVA IMAGEM
    //imagecopyresampled() COPIA E REDIMENSIONA A IMAGEM
    imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);

    //INICIA UM BUFFEER PARA GUARDAR A IMAGEM COMO TEXTO BINARIO
    //ob_start(); -- INICIA O "output buffering" GUARDANDO A SAIDA EM UM BUFFER

    ob_start();
    //imagejpeg() ENVIA A IMAGEM PARA O OUTPUT (QUE VAI PARA O BUFFER)
    imagepng($novaImagem);

    //OB_GET_CLEAN() PEGA O CONTEUDO DO BUFFER E LIMPA O BUFFER
    $dadosImagem = ob_get_clean();

    //libera a memória usada pelas imagens
    //imagedestroy($novaImagem); -- LIBERA A MEMÓRIA DA IMAGEM CRIADA
    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    //RETORNA A IMAGEM REDIMENSIONADA EM FORMATO BINÁRIO
    return $dadosImagem;
    }

    //CONFIGURAÇÃO DO BANCO DE DADOS
    $host="localhost";
    $dbname="armazena_imagens";
    $username="root";
    $password="";      

    try{    
        //CONEXÃO COM O BANCO USANDO PDO
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_FILES['foto'])) {
            if($_FILES['foto']['error'] == 0) {
                $nome = $_POST['nome'];
                $telefone = $_POST['telefone'];
                $nomeFoto = $_FILES['foto']['name']; // Pega o nome original do arquivo
                $tipoFoto = $_FILES['foto']['type']; // Pega o tipo mime do arquivo

            // Redimenciona a imagem 
            $foto = redimensionarImagem($_FILES['foto']['tmp_name'], 300, 400); // O codigo, cuja variavel é tmp_name, é o caminho temporário do arquivo enviado

            // Insere no banco de dados usando o sql prepared
            $sql='INSERT INTO funcionarios (nome, telefone, nome_foto, tipo_foto, foto) VALUES (:nome, :telefone, :nome_foto, :tipo_foto, :foto)';
            $stmt = $pdo->prepare($sql); // Responsavel por praparar a query para evitar ataque sql injection
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nome_foto', $nomeFoto);
            $stmt->bindParam(':tipo_foto', $tipoFoto);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB); // PARAM_LOB indica que o dado é um blob (binary large object)

            if($stmt->execute()) {
                echo "Funcionário cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar funcionário.";
            }
        } else {
            echo "Erro ao enviar arquivo: " . $_FILES['foto']['error'];
        }
    }
    } catch(PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
    }       
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de imagens</title>
</head>
<body>
    <h1>Lista de Imagens</h1>

    <a href="consulta_funcionario.php">Listar funcionarios</a>
</body>
</html>