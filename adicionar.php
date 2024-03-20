<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['id']) || !$_SESSION['admin']) {
    header("Location: login.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    try {
        $stmt = $conn->prepare("INSERT INTO informacoes (titulo, descricao) VALUES (?, ?)");
        $stmt->execute([$titulo, $descricao]);
        
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error = "Erro ao adicionar informação: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Informação</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar Informação</h2>

        <form method="post" action="adicionar.php">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" rows="4" required></textarea>

            <button type="submit">Adicionar</button>
        </form>

        <?php if(!empty($error)) echo "<p class='error'>$error</p>"; ?>


        <a href="index.php"><button class='btnVoltar'>Voltar</button></a> 
    </div>
</body>
</html>
