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

// Recebe o ID da tarefa e o novo status
$id_tarefa = $_GET['id'];
$status = $_GET['status'];

// Verifica se o status é válido
if (!in_array($status, ['a fazer', 'fazendo', 'pronto'])) {
    die('Status inválido.');
}

// Converte o status para a forma correta (primeira letra maiúscula)
$status = ucfirst($status);

// Consulta SQL para alterar o status da tarefa
$sql = "UPDATE TBL_TAREFAS SET TAR_STATUS = ? WHERE ID_TAR = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $status, $id_tarefa); // "si" significa string e inteiro

// Executa a consulta
if ($stmt->execute()) {
    // Redireciona para a página de gerenciamento de tarefas
    header("Location: gerenciar_tarefas.php");
    exit;
} else {
    echo "Erro ao atualizar o status da tarefa.";
}

// Fecha a conexão
$conn->close();
?>
