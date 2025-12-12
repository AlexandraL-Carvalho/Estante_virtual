<?php
session_start();

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

// Conexão com o banco
$servername = "127.0.0.1:3307";
$username = "root";   
$password = "";       
$dbname = "estante_virtual";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Pega o ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];

// LISTAR livros do usuário
$sql = "SELECT * FROM livros WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Minha Estante - CRUD</title>
  <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
  <header>
    <nav>
      <h1 class="logo">Entre Páginas 📚</h1>
      <ul>
        <li><a href="../index.html">Início</a></li>
        <li><a href="../about.html">Sobre</a></li>
        <li><a href="../backend/logout.php">Sair</a></li>
      </ul>
    </nav>
  </header>

  <main class="container">
    <h2>Bem-vindo(a), <?php echo $_SESSION['usuario_nome']; ?>!</h2>
    <h3>Seus livros cadastrados:</h3>

    <table border="1" cellpadding="8">
      <tr>
        <th>Título</th>
        <th>Autor</th>
        <th>Ano</th>
        <th>Editora</th>
        <th>Ações</th>
      </tr>
      <?php while ($livro = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $livro['titulo']; ?></td>
          <td><?php echo $livro['autor']; ?></td>
          <td><?php echo $livro['ano']; ?></td>
          <td><?php echo $livro['editora']; ?></td>
          <td>
            <a href="editar.php?id=<?php echo $livro['id']; ?>">Editar</a> |
            <a href="excluir.php?id=<?php echo $livro['id']; ?>">Excluir</a>
          </td>
        </tr>
      <?php } ?>
    </table>

    <h3>Adicionar novo livro</h3>
    <form action="inserir.php" method="POST">
      <label>Título:</label>
      <input type="text" name="titulo" required>
      <label>Autor:</label>
      <input type="text" name="autor" required>
      <label>Ano:</label>
      <input type="number" name="ano" required>
      <label>Editora:</label>
      <input type="text" name="editora">
      <button type="submit">Adicionar</button>
    </form>
  </main>
</body>
</html>