<?php
 //CONFIGURAÇÃO DO BANCO DE DADOS
 $host="localhost";
 $dbname="armazena_imagem";
 $username="root";
 $password="";      

 try {    
     //CONEXÃO COM O BANCO USANDO PDO
     $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // Recupera os dados dos funcionários
     $sql = 'SELECT id, nome FROM funcionario';
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
     $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC); // Busca todos os resultados como um array associativo

     // Verifica se foi solicitado a exclusão de um funcionário
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir_id'])) {
            $excluir_id = $_POST['excluir_id'];
            $sql_excluir = 'DELETE FROM funcionario WHERE id = :id';
            $stmt_excluir = $pdo->prepare($sql_excluir);
            $stmt_excluir->bindParam(':id', $excluir_id, PDO::PARAM_INT);
            $stmt_excluir->execute();

            // Redireciona para evitar reenvio do formulário
            header("Location: ".$_SERVER["PHP_SELF"]);
            exit();
        }
    } catch (PDOException $e) {
        echo "Erro de conexão: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de funcionarios</title>
</head>
<body>
    <h1>Consulta de funcionarios</h1>

    <ul>
        <?php foreach ($funcionarios as $funcionario): ?> :
            <li>
                <!-- Codigo abaixo cria link para visualizar detalhes do funcionário -->
                <a href="visualizar_funcionario.php?id=<?= $funcionario['id']?>">
                    <?= htmlspecialchars($funcionario['nome']) ?>
                </a>
                <!-- Formulário para excluir o funcionário -->
                <form method="post" style="display:inline;">
                    <input type="hidden" name="excluir_id" value="<?= $funcionario['id'] ?>">
                    <button type="submit">Excluir</button>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>