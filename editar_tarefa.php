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

// Recebe o ID da tarefa que será editada
$id_tarefa = $_GET['id'];

// Consulta SQL para pegar os dados da tarefa
$sql = "SELECT * FROM TBL_TAREFAS WHERE ID_TAR = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tarefa);
$stmt->execute();
$result = $stmt->get_result();
$tarefa = $result->fetch_assoc();

// Verifica se a tarefa foi encontrada
if (!$tarefa) {
    die("Tarefa não encontrada.");
}

// Consulta para pegar os usuários cadastrados
$sql_usuarios = "SELECT ID_USU, NOME FROM TBL_USUARIO";
$result_usuarios = $conn->query($sql_usuarios);
$usuarios = [];
while ($row = $result_usuarios->fetch_assoc()) {
    $usuarios[] = $row;
}

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $setor = $_POST['setor'];
    $usuario = $_POST['usuario'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status']; // Novo status que o usuário escolher
    
    // Atualiza a tarefa no banco de dados
    $sql_update = "UPDATE TBL_TAREFAS SET TAR_SETOR = ?, TAR_USUARIO = ?, TAR_PRIORIDADE = ?, TAR_STATUS = ? WHERE ID_TAR = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $setor, $usuario, $prioridade, $status, $id_tarefa);
    
    if ($stmt_update->execute()) {
        // Redireciona de volta para a página de gerenciamento de tarefas
        header("Location: gerenciar_tarefas.php");
        exit;
    } else {
        echo "Erro ao atualizar a tarefa.";
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
    <title>Editar Tarefa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-2 v-center">
        <div class="header">
            <h1>Editar Tarefa</h1>
            <div class="buttons-container">
                <a class="button" href="gerenciar_tarefas.php">Voltar para Gerenciamento de Tarefas</a>
            </div>
        </div>

        <form method="POST">
            <div class="form-group">
                <label for="setor">Setor:</label>
                <input type="text" id="setor" name="setor" value="<?= $tarefa['TAR_SETOR'] ?>" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuário:</label>
                <select id="usuario" name="usuario" required>
                    <option value="">Selecione um Usuário</option>
                    <?php foreach ($usuarios as $usuario_item): ?>
                        <option value="<?= $usuario_item['ID_USU'] ?>" 
                            <?= $usuario_item['ID_USU'] == $tarefa['TAR_USUARIO'] ? 'selected' : '' ?>>
                            <?= $usuario_item['NOME'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="prioridade">Prioridade:</label>
                <input type="text" id="prioridade" name="prioridade" value="<?= $tarefa['TAR_PRIORIDADE'] ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="A Fazer" <?= $tarefa['TAR_STATUS'] == 'A Fazer' ? 'selected' : '' ?>>A Fazer</option>
                    <option value="Fazendo" <?= $tarefa['TAR_STATUS'] == 'Fazendo' ? 'selected' : '' ?>>Fazendo</option>
                    <option value="Pronto" <?= $tarefa['TAR_STATUS'] == 'Pronto' ? 'selected' : '' ?>>Pronto</option>
                </select>
            </div>
            <button type="submit" class="button">Salvar Alterações</button>
        </form>
    </div>
</body>
</html>
