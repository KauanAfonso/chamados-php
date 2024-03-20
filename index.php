<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $excluirId = $_POST['excluir_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM informacoes WHERE id = ?");
        $stmt->execute([$excluirId]);
        
        // Redireciona de volta para a página após a exclusão
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $error = "Erro ao excluir informação: " . $e->getMessage();
    }
}

try {
    $stmt = $conn->query("SELECT * FROM informacoes");
    $informacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro na consulta: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
   
   
</head>
<body><body>
<div class="container">
    <h1>Bem-vindo, <?php echo $_SESSION['nome']; ?>!</h1><br>

    <?php if ($_SESSION['admin']): ?>
        <a href="adicionar.php" class="btnAdicionar">Adicionar Informação</a>
    <?php endif; ?>

    
    <a href="gerarOPdf.php"><button id="btnPdf" >Imprimir PDF</button></a>
    <a href="logout.php" ><button class="btnExcluir">Logout</button></a>

    <h2>Informações</h2>

       <ul>
        <?php foreach ($informacoes as $info): ?>
            <li>
                <div class="card">
                   
                        <h2 class="titlo"><?php echo $info['titulo']; ?></h2>
                        <h3 class="descricao"><?php echo $info['descricao']; ?></h3>
                        
                            <!-- Link para modificar -->
                         <?php if (!$_SESSION['admin']): ?>
                          <button class="btnModificar"><a href="modificar.php?id=<?php echo $info['id']; ?>" >Modificar</a></button>
                            <!-- Formulário de exclusão -->
                            
                            <?php endif; ?>
                            <div class="card-body">
                                
                            <?php if ($_SESSION['admin']): ?>

                            <form method="post" action="index.php" style="display: inline;">
                            <input type="hidden" name="excluir_id" value="<?php echo $info['id']; ?>"><br>

                            <button type="submit" class="btnExcluir">Excluir</button>
                            </form>

                        <?php endif; ?>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>


  

</div>

</body>
</html>
</body>
</html>
