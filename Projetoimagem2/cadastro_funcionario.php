<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Funcionario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastro</h1>
        <h2>funcionario</h2>
        <!-- Formulario para Cadastro de Funcionarios -->
        <form action="cadastro_funcionario.php" method="POST" enctype="multipart/form-data">
            <label for="name">Nome: </label>
            <input type="text" id="nome" name="nome" required>
            <br>

            <label for="name">Telefone: </label>
            <input type="text" id="telefone" name="telefone" required>
            <br>

            <label for="name">Foto: </label>
            <input type="file" id="foto" name="foto" required>
            <br>

            <button type="submit">Cadastra Funcionario</button>
    </div>
</body>
</html>