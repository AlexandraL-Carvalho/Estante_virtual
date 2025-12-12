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

$sql = "DELETE FROM livros WHERE id=? AND usuario_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $_SESSION['usuario_id']);

if ($stmt->execute()) {
    header("Location: crud.php");
    exit;
} else {
    // Exibe erro com CSS
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
      <meta charset="UTF-8">
      <title>Erro ao excluir</title>
      <link rel="stylesheet" href="../estilos/style.css">
    </head>
    <body>
      <div class="container">
        <h2>Erro ao excluir livro</h2>
        <p><?php echo $stmt->error; ?></p>
        <a href="crud.php" class="btn">Voltar</a>
      </div>
    </body>
    </html>
    <?php
}

$conn->close();
?>
