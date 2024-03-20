<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$info = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $infoId = $_POST['info_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    try {
        $stmt = $conn->prepare("UPDATE informacoes SET titulo = ?, descricao = ? WHERE id = ?");
        $stmt->execute([$titulo, $descricao, $infoId]);
        
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error = "Erro ao modificar informação: " . $e->getMessage();
    }
}

if (isset($_GET['id'])) {
    $infoId = $_GET['id'];
    try {
        $stmt = $conn->prepare("SELECT * FROM informacoes WHERE id = ?");
        $stmt->execute([$infoId]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verificar se $info não é nulo antes de usá-lo
        if (!$info) {
            $error = "Nenhuma informação encontrada para o ID especificado.";
        }
    } catch (PDOException $e) {
        $error = "Erro ao recuperar informação: " . $e->getMessage();
    }
} else {
    $error = "ID da informação não especificado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Modificar Informação</title>
    <link rel="stylesheet" href="style.css">
  
</head>
<body>
    <div class="container">
        <h2>Modificar Informação</h2>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (isset($info['id'])) : ?>
            <form method="post" action="modificar.php">
                <input type="hidden" name="info_id" value="<?php echo $info['id']; ?>">

                <label for="titulo">Título:</label>
                <input type="text" name="titulo" value="<?php echo $info['titulo']; ?>" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" rows="4" required><?php echo $info['descricao']; ?></textarea>

                <button type="submit">Modificar</button>
            </form>
       
        <?php endif; ?>

  

        <a href="index.php"><button class='btnVoltar'>Voltar</button></a> 
        
    
    </div>
</body>
</html>

