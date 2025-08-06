<?php
//INCLUI O ARQUIVO DE CONEXÂO COM O BANCODE DADOS
require_once('conecta.php');

//CRIA A CONSULTA SQL PARA SELECIONAR OS DADOS PRINCIPAIS (sem acoluna imagem)
$querySelecao = "SELECT codigo, evento, descricao, nome_imagem, tamanho_imagem FROM tabela_imagens";

$resultado = mysqli_query($conexao, $querySelecao);

if(!$resultado) {
    die("Erro na consulta: " . mysqli_error($conexao));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Armazenado Imagens no BD MySQL</title>
</head>
<body>
    <h2>Selecione um Novo Arquivo de Imagem</h2>
    <form enctype="multipart/form-data" method="POST" action="upload.php">
        <input type="hidden" name="MAX_FILE_SIZE" value="9999999999" >
        <input type="text" name="evento" placeholder="Nome do Evento">
        <input type="text" name="descricao" placeholder="Descricção">
        <input type="file" name="imagem" >
        <input type="submit" name="Salvar" >
        </form>
        <br>
        <table border = "1">
            <tr>
                <td aling="center">Código</td>
                <td aling="center">Evento</td>
                <td aling="center">Descrição</td>
                <td aling="center">Nome_Imagem</td>
                <td aling="center">Tamanho</td>
                <td aling="center">visualizar Imagem</td>
                <td aling="center">Excluir Imagem</td>
            </tr>
        </table>
<?php
    while($arquivos = mysqli_fetch_array($resultado)){ ?>
        <tr>
            <td aling="center"><?php echo $arquivos['codigo'];?>Código</td>
            <td aling="center"><?php echo $arquivos['evento'];?>Evento</td>
            <td aling="center"><?php echo $arquivos['descricao'];?>Descrição</td>
            <td aling="center"><?php echo $arquivos['nome_imagem'];?>Nome_Imagem</td>
            <td aling="center"><?php echo $arquivos['tamanho_imagem'];?>Tamanho</td>

            <td aling="center">
                <a href="ver_imagens.php?id=<?php echo $arquivos['codigo'];?>">    
            Visualizar Imagens</td>
                
            <td aling="center">
                <a href="excluir_imagem.php?id=<?php echo $arquivos['codigo'];?>">    
            Excluir Imagens</td>
        </tr>
        <?php
    }?>
    
          
?>
</body>
</html>