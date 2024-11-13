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

// Consulta as tarefas do banco de dados
$sql = "SELECT TBL_TAREFAS.ID_TAR, TBL_TAREFAS.TAR_SETOR, TBL_TAREFAS.TAR_USUARIO, 
               TBL_TAREFAS.TAR_PRIORIDADE, TBL_TAREFAS.TAR_STATUS, TBL_USUARIO.NOME 
        FROM TBL_TAREFAS
        JOIN TBL_USUARIO ON TBL_TAREFAS.ID_USU = TBL_USUARIO.ID_USU";
$result = $conn->query($sql);

// Verifica se há tarefas cadastradas
$tarefas = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $tarefas[] = $row;
    }
} else {
    echo "Nenhuma tarefa encontrada no banco de dados.";  // Exibe mensagem se não houver tarefas
}

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tarefas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-2 v-center">
        <!-- Cabeçalho com os botões -->
        <div class="header">
            <h1>Gerenciamento de Tarefas</h1>
            <div class="buttons-container">
                <a class="button" href="cadastro_usuarios.php">Cadastro de Usuários</a>
                <a class="button" href="cadastro_tarefas.php">Cadastro de Tarefas</a>
                <a class="button" href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
            </div>
        </div>

        <!-- Lista de tarefas -->
        <div class="tasks-container">
            <h2>Tarefas</h2>

            <!-- Tarefas A Fazer -->
            <div class="task-status">
                <h3>A Fazer</h3>
                <?php
                // Filtra tarefas com o status 'A Fazer'
                $tarefas_a_fazer = array_filter($tarefas, function($tarefa) {
                    return trim(strtolower($tarefa['TAR_STATUS'])) == 'a fazer';
                });

                if (empty($tarefas_a_fazer)) {
                    echo "<p><strong>Nenhuma tarefa cadastrada.</strong></p>";
                } else {
                    foreach ($tarefas_a_fazer as $tarefa): ?>
                        <div class="task-item">
                            <p><strong>Descrição:</strong> <?= $tarefa['TAR_USUARIO'] ?> (Prioridade: <?= $tarefa['TAR_PRIORIDADE'] ?>)</p>
                            <p><strong>Setor:</strong> <?= $tarefa['TAR_SETOR'] ?></p>
                            <p><strong>Vinculado a:</strong> <?= $tarefa['NOME'] ?></p>
                            <div class="task-actions">
                                <a href="editar_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Editar</a>
                                <a href="excluir_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Excluir</a>
                                <a href="alterar_status.php?id=<?= $tarefa['ID_TAR'] ?>&status=fazendo" class="button">Alterar Status para Fazendo</a>
                                <a href="alterar_status.php?id=<?= $tarefa['ID_TAR'] ?>&status=pronto" class="button">Alterar Status para Pronto</a>
                            </div>
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>

            <!-- Tarefas Fazendo -->
            <div class="task-status">
                <h3>Fazendo</h3>
                <?php
                // Filtra tarefas com o status 'Fazendo'
                $tarefas_fazendo = array_filter($tarefas, function($tarefa) {
                    return trim(strtolower($tarefa['TAR_STATUS'])) == 'fazendo';
                });

                if (empty($tarefas_fazendo)) {
                    echo "<p><strong>Nenhuma tarefa cadastrada.</strong></p>";
                } else {
                    foreach ($tarefas_fazendo as $tarefa): ?>
                        <div class="task-item">
                            <p><strong>Descrição:</strong> <?= $tarefa['TAR_USUARIO'] ?> (Prioridade: <?= $tarefa['TAR_PRIORIDADE'] ?>)</p>
                            <p><strong>Setor:</strong> <?= $tarefa['TAR_SETOR'] ?></p>
                            <p><strong>Vinculado a:</strong> <?= $tarefa['NOME'] ?></p>
                            <div class="task-actions">
                                <a href="editar_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Editar</a>
                                <a href="excluir_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Excluir</a>
                                <a href="alterar_status.php?id=<?= $tarefa['ID_TAR'] ?>&status=pronto" class="button">Alterar Status para Pronto</a>
                            </div>
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>

            <!-- Tarefas Pronto -->
            <div class="task-status">
                <h3>Pronto</h3>
                <?php
                // Filtra tarefas com o status 'Pronto'
                $tarefas_pronto = array_filter($tarefas, function($tarefa) {
                    return trim(strtolower($tarefa['TAR_STATUS'])) == 'pronto';
                });

                if (empty($tarefas_pronto)) {
                    echo "<p><strong>Nenhuma tarefa cadastrada.</strong></p>";
                } else {
                    foreach ($tarefas_pronto as $tarefa): ?>
                        <div class="task-item">
                            <p><strong>Descrição:</strong> <?= $tarefa['TAR_USUARIO'] ?> (Prioridade: <?= $tarefa['TAR_PRIORIDADE'] ?>)</p>
                            <p><strong>Setor:</strong> <?= $tarefa['TAR_SETOR'] ?></p>
                            <p><strong>Vinculado a:</strong> <?= $tarefa['NOME'] ?></p>
                            <div class="task-actions">
                                <a href="editar_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Editar</a>
                                <a href="excluir_tarefa.php?id=<?= $tarefa['ID_TAR'] ?>" class="button">Excluir</a>
                            </div>
                        </div>
                    <?php endforeach;
                }
                ?>
            </div>

        </div>
    </div>
</body>
</html>
