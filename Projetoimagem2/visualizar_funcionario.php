<?php
//CONFIGURAÇÃO DO BANCO DE DADOS
$host="localhost";
$dbname="armazena_imagens";
$username="root";
$password="";   

try {    
    //CONEXÃO COM O BANCO USANDO PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET["id"])){
        $id = $_GET["id"];

        // Recupera os dados dos funcionários
     $sql = 'SELECT nome, telefone, tipo_foto, foto FROM funcionarios WHERE id = :id';
     $stmt = $pdo->prepare($sql);
     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
     $stmt->execute();

     if($stmt->rowCount()){
         $funcionario = $stmt->fetch(PDO::FETCH_ASSOC); // Busca o resultado como um array associativo
         if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['excluir_id'])) {
             $excluir_id = $_POST['excluir_id'];
             $sql_excluir = 'DELETE FROM funcionarios WHERE id = :id';
             $stmt_excluir = $pdo->prepare($sql_excluir);
             $stmt_excluir->bindParam(':id', $excluir_id, PDO::PARAM_INT);
             $stmt_excluir->execute();

             // Redireciona para evitar reenvio do formulário
             header("Location: consulta_funcionario.php");
             exit();
         }  
         ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Visualizar Funcionario</title>
    </head>
    <body>
        <h1>Dados dos Funcionarios</h1>
        <p>Nome:<?=htmlspecialchars($funcionario['nome'])?></p>
    </body>
    </html>
     } else {
         echo "Funcionário não encontrado.";
         exit();
     }
    }
}
?>