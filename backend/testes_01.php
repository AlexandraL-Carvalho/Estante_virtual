// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
else
    echo "Conexão bem sucedida!";

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
    echo "Cadastro realizado com sucesso! Agora faça login para acessar sua estante.";
    echo "<br><a href='login.html'>Ir para Login</a>";
} else {
    echo "Erro ao cadastrar usuário: " . $stmt->error;
}

$conn->close();
?>