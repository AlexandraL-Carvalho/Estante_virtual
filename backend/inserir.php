<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit;
}

$servername = "127.0.0.1:3307";
$username = "root";   
$password = "";       
$dbname = "estante_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$titulo  = $_POST['titulo'];
$autor   = $_POST['autor'];
$ano     = $_POST['ano'];
$editora = $_POST['editora'];
$usuario_id = $_SESSION['usuario_id'];

$sql = "INSERT INTO livros (titulo, autor, ano, editora, usuario_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisi", $titulo, $autor, $ano, $editora, $usuario_id);

if ($stmt->execute()) {
    header("Location: crud.php");
    exit;
} else {
    echo "Erro ao inserir livro: " . $stmt->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Erro ao inserir livro</title>
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

  <main class="container">
    <h2>Erro ao inserir livro</h2>
    <p style="color: red;"><?php echo $erro; ?></p>
    <a href="crud.php" class="btn">Voltar para a estante</a>
  </main>

  <footer>
    <p>&copy; 2025 Estante Virtual</p>
  </footer>
</body>
</html>