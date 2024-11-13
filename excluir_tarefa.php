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

// Recupera o ID da tarefa para exclusão
if (isset($_GET['id'])) {
    $id_tarefa = $_GET['id'];

    // Exclui a tarefa do banco de dados
    $sql = "DELETE FROM TBL_TAREFAS WHERE ID_TAR = $id_tarefa";
    if ($conn->query($sql) === TRUE) {
        header("Location: gerenciar_tarefas.php");  // Redireciona para a lista de tarefas
        exit;
    } else {
        die("Erro ao excluir a tarefa: " . $conn->error);
    }
} else {
    die("ID de tarefa não fornecido.");
}

$conn->close();
?>
