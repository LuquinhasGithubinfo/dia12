<?php
// Dados de conexão com o banco de dados
$host = "localhost";
$dbname = "DB_PROVA01";
$username = "root";  // Ajuste para o seu usuário do banco de dados
$password = "";      // Ajuste para a senha do seu banco de dados, se houver

// Conexão com o banco de dados
$conn = new mysqli($host, $username, $password, $dbname);

// Verifica se houve erro de conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado e se todos os campos foram preenchidos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário e escapar para evitar SQL Injection
    $descricao = isset($_POST['descricao']) ? $conn->real_escape_string($_POST['descricao']) : null;
    $setor = isset($_POST['setor']) ? $conn->real_escape_string($_POST['setor']) : null;
    $usuario_id = isset($_POST['usuario_id']) ? $conn->real_escape_string($_POST['usuario_id']) : null;
    $prioridade = isset($_POST['prioridade']) ? $conn->real_escape_string($_POST['prioridade']) : null;
    $status = isset($_POST['status']) ? $conn->real_escape_string($_POST['status']) : null;

    // Verificar se todos os campos foram preenchidos
    if (empty($descricao) || empty($setor) || empty($usuario_id) || empty($prioridade) || empty($status)) {
        echo "Erro: Todos os campos devem ser preenchidos.";
        exit; // Interrompe o script se algum campo estiver vazio
    }

    // Inserir a nova tarefa no banco de dados
    $sql = "INSERT INTO TBL_TAREFAS (TAR_USUARIO, TAR_SETOR, TAR_PRIORIDADE, TAR_STATUS) 
            VALUES ('$usuario_id', '$setor', '$prioridade', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Nova tarefa cadastrada com sucesso!";
        // Redireciona para a página de sucesso
        header("Location: sucesso.php");
        exit; // Certifique-se de parar o script após o redirecionamento
    } else {
        echo "Erro ao cadastrar tarefa: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>
