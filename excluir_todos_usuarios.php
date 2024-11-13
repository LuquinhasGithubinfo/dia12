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

// Verifica se o formulário foi enviado
if (isset($_POST['excluir_todos'])) {
    // 1. Excluir todas as tarefas associadas aos usuários
    $sql_delete_tarefas = "DELETE FROM TBL_TAREFAS WHERE ID_USU IS NOT NULL";
    if ($conn->query($sql_delete_tarefas) === TRUE) {
        // 2. Excluir todos os usuários
        $sql_delete_usuarios = "DELETE FROM TBL_USUARIO";
        if ($conn->query($sql_delete_usuarios) === TRUE) {
            echo "Todos os usuários e suas tarefas foram excluídos com sucesso.";
        } else {
            echo "Erro ao excluir os usuários: " . $conn->error;
        }
    } else {
        echo "Erro ao excluir as tarefas: " . $conn->error;
    }
}

// Fecha a conexão
$conn->close();

// Redireciona após a execução
header("Location: gerenciar_tarefas.php");
exit;
?>
