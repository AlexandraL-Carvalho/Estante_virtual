<?php
session_start();

// Conexão com o banco
$servername = "127.0.0.1:3307";
$username = "root";   
$password = "";       
$dbname = "estante_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Recebe dados do formulário
$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

// Busca usuário no banco
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verifica senha
    if (password_verify($senha, $user['senha'])) {
        // Cria sessão
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['primeiro_nome'];

        // Redireciona para área protegida
        header("Location: crud.php");
        exit;
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Usuário não encontrado!";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Estante Virtual</title>
  <link rel="stylesheet" href="../estilos/style_register.css">
</head>
<body>
  <header>
    <nav>
      <div class="logo">Entre páginas!📚</div>
      <ul>
        <li><a href="../index.html">Início</a></li>
        <li><a href="../login.html">Login</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <div class="container">
      <?= $mensagem ?>
    </div>
  </main>

  <footer>
    <p>&copy; 2025 Estante Virtual</p>
  </footer>
</body>
</html>