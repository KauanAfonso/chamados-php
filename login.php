<?php
session_start();
require_once('conexao.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        // Verificar o número de linhas
        $rowCount = $stmt->rowCount();

        if ($rowCount == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['id'] = $row['id'];
            $_SESSION['nome'] = $row['nome'];
            $_SESSION['admin'] = $row['admin'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Credenciais inválidas";
        }
    } catch (PDOException $e) {
        echo "Erro na consulta: " . $e->getMessage();
    }
}
?>

<!-- Formulário de login HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script src='script.js'></script>
   
</head>

<style>
    
</style>
</style>
<body>
    <main>
        <div id='container'>
        <img src="perfil-de-usuario.png" alt=""><br>
        <form method="post" action="login.php">
    
        
        
        <label for="email">Email:</label><br>
        <input type="email" name="email"  placeholder="Username" ><br>

        <label for="senha">Senha:</label><br>
        <input type="password" name="senha"  placeholder="Password" ><br>

        

        <br><button type="submit" name="login" class="">Login</button><br><br>
      
        <?php if(isset($error)) echo "<p class='error' style='color:red;'>$error</p>"; ?></div>
        <p>©copyrigth 2024</p>
   
            
        </form>
        

    </div>

    <p>Copyright</p>
    
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
