<?php
// Dados de conexão com o banco de dados
$host = "localhost";
$dbname = "DB_PROVA01";
$username = "root";
$password = "";

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se houve erro de conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Valida os campos
    if (empty($nome) || empty($email)) {
        echo "<script>alert('Erro: Todos os campos devem ser preenchidos.');</script>";
    } else {
        // Prepara e insere os dados na tabela TBL_USUARIO
        $stmt = $conn->prepare("INSERT INTO TBL_USUARIO (NOME, EMAIL) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $email); // "ss" significa que são duas strings

        // Verifica se a inserção foi bem-sucedida
        if ($stmt->execute()) {
            // Redireciona para a página de cadastro de usuários após o sucesso
            header("Location: cadastro_usuarios.php");
            exit;
        } else {
            // Caso de erro na inserção, redireciona para página de erro
            header("Location: erro.php");
            exit;
        }
    }
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuários</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-2 v-center">
        <div class="header">
            <h1>Cadastro de Usuários</h1>
            <div class="buttons-container">
                <a class="button" href="cadastro_usuarios.php">Cadastro de Usuários</a>
                <a class="button" href="cadastro_tarefas.php">Cadastro de Tarefas</a>
                <a class="button" href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
            </div>
        </div>

        <!-- Formulário de cadastro de usuário -->
        <div class="form-container">
            <h2>Preencha os dados do novo usuário</h2>
            <form action="cadastro_usuarios.php" method="POST"> <!-- A ação deve chamar o próprio arquivo PHP -->
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Cadastrar Usuário</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
