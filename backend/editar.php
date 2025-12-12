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

$id = $_GET['id'];

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo  = $_POST['titulo'];
    $autor   = $_POST['autor'];
    $ano     = $_POST['ano'];
    $editora = $_POST['editora'];

    $sql = "UPDATE livros SET titulo=?, autor=?, ano=?, editora=? WHERE id=? AND usuario_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssissi", $titulo, $autor, $ano, $editora, $id, $_SESSION['usuario_id']);

    if ($stmt->execute()) {
        header("Location: crud.php");
        exit;
    } else {
        echo "Erro ao atualizar livro: " . $stmt->error;
    }
}

// Carregar dados do livro
$sql = "SELECT * FROM livros WHERE id=? AND usuario_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
$livro = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Livro</title>
  <link rel="stylesheet" href="../estilos/style.css">
</head>
<body>
  <main class="container">
    <h2>Editar Livro</h2>
    <form method="POST">
      <label>Título:</label>
      <input type="text" name="titulo" value="<?php echo $livro['titulo']; ?>" required>
      <label>Autor:</label>
      <input type="text" name="autor" value="<?php echo $livro['autor']; ?>" required>
      <label>Ano:</label>
      <input type="number" name="ano" value="<?php echo $livro['ano']; ?>" required>
      <label>Editora:</label>
      <input type="text" name="editora" value="<?php echo $livro['editora']; ?>">
      <button type="submit">Salvar</button>
    </form>
  </main>
</body>
</html>