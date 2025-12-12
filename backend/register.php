<?php
// Conexão com o banco

$servername = "127.0.0.1:3307";
$username = "root";   
$password = "";       
$dbname = "estante_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
  <header>
    <nav>
      <div class="logo">Estante Virtual</div>
      <ul>
        <li><a href="../index.html">Início</a></li>
        <li><a href="../login.html">Login</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <?php
    // Verifica conexão
    if ($conn->connect_error) {
        echo "<p>Falha na conexão: " . $conn->connect_error . "</p>";
        exit;
    }

    // Recebe dados do formulário
    $primeiro_nome = $_POST['pnome'];
    $ultimo_nome   = $_POST['lnome'];
    $email         = $_POST['email'];
    $usuario       = $_POST['usuario'];
    $senha         = $_POST['senha'];

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere usuário
    $sql_usuario = "INSERT INTO usuarios (primeiro_nome, ultimo_nome, email, usuario, senha)
                    VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_usuario);
    $stmt->bind_param("sssss", $primeiro_nome, $ultimo_nome, $email, $usuario, $senha_hash);

    if ($stmt->execute()) {
        echo "<h2>Cadastro realizado com sucesso!</h2>";
        echo "<p>Agora faça login para acessar sua estante.</p>";
        echo "<a href='login.html' class='btn'>Ir para Login</a>";
    } else {
        echo "<h2>Erro ao cadastrar usuário</h2>";
        echo "<p>" . $stmt->error . "</p>";
    }

    $conn->close();
    ?>
  </div>

  <footer>
    <p>&copy; 2025 Estante Virtual</p>
  </footer>
</body>
</html>