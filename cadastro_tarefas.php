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

// Consulta para pegar os usuários cadastrados
$sql_usuarios = "SELECT ID_USU, NOME FROM TBL_USUARIO";
$result_usuarios = $conn->query($sql_usuarios);

// Verificar se o formulário foi enviado e se todos os campos foram preenchidos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : null;
    $setor = isset($_POST['setor']) ? $_POST['setor'] : null;
    $usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : null;
    $prioridade = isset($_POST['prioridade']) ? $_POST['prioridade'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Verificar se todos os campos foram preenchidos
    if (empty($descricao) || empty($setor) || empty($usuario_id) || empty($prioridade) || empty($status)) {
        echo "Erro: Todos os campos devem ser preenchidos.";
        exit; // Interrompe o script se algum campo estiver vazio
    }

    // Prevenir SQL Injection usando Prepared Statements
    $sql = "INSERT INTO TBL_TAREFAS (TAR_USUARIO, TAR_SETOR, TAR_PRIORIDADE, TAR_STATUS, ID_USU) 
            VALUES (?, ?, ?, ?, ?)";

    // Preparando a declaração SQL
    if ($stmt = $conn->prepare($sql)) {
        // Bind dos parâmetros para a consulta preparada
        $stmt->bind_param("ssssi", $descricao, $setor, $prioridade, $status, $usuario_id);

        // Executar a declaração
        if ($stmt->execute()) {
            // Se a tarefa for cadastrada com sucesso, redireciona de volta para o cadastro de tarefas
            header("Location: cadastro_tarefas.php");
            exit; // Evita que o código continue executando
        } else {
            // Caso haja um erro ao cadastrar a tarefa
            echo "Erro ao cadastrar tarefa: " . $stmt->error;
        }

        // Fechar a declaração
        $stmt->close();
    } else {
        echo "Erro ao preparar a consulta: " . $conn->error;
    }
}

// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-2 v-center">
        <!-- Cabeçalho com os botões -->
        <div class="header">
            <h1>Cadastro de Tarefas</h1>
            <div class="buttons-container">
                <a class="button" href="cadastro_usuarios.php">Cadastro de Usuários</a>
                <a class="button" href="cadastro_tarefas.php">Cadastro de Tarefas</a>
                <a class="button" href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
            </div>
        </div>

        <!-- Formulário de cadastro de tarefas -->
        <div class="form-container">
            <h2>Preencha os dados da nova tarefa</h2>
            <form action="cadastro_tarefas.php" method="POST">
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <input type="text" id="descricao" name="descricao" required>
                </div>
                <div class="form-group">
                    <label for="setor">Setor:</label>
                    <input type="text" id="setor" name="setor" required>
                </div>
                <div class="form-group">
                    <label for="usuario_id">Usuário:</label>
                    <select id="usuario_id" name="usuario_id" required>
                        <option value="">Selecione um usuário</option>
                        <?php 
                        // Verifica se há usuários cadastrados e exibe na lista
                        if ($result_usuarios->num_rows > 0) {
                            while ($usuario = $result_usuarios->fetch_assoc()) {
                                echo "<option value='{$usuario['ID_USU']}'>{$usuario['ID_USU']} - {$usuario['NOME']}</option>";
                            }
                        } else {
                            echo "<option value=''>Nenhum usuário encontrado</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="prioridade">Prioridade:</label>
                    <select id="prioridade" name="prioridade" required>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="A Fazer">A Fazer</option>
                        <option value="Fazendo">Fazendo</option>
                        <option value="Pronto">Pronto</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Cadastrar Tarefa</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
