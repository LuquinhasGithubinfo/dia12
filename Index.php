<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="project-2 v-center">
        <!-- Cabeçalho com os botões -->
        <div class="header">
            <h1>Gerenciamento de Tarefas</h1>
            <div class="buttons-container">
                <a class="button" href="Index.php">Cadastro de Usuários</a>
                <a class="button" href="cadastro_tarefas.php">Cadastro de Tarefas</a>
                <a class="button" href="gerenciar_tarefas.php">Gerenciar Tarefas</a>
            </div>
        </div>

        <!-- Seção de Cadastro de Usuário (alinhada à esquerda) -->
        <div class="user-form-container">
            <h2>Cadastro de Usuário</h2>
            <form action="cadastrar_usuario.php" method="POST">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="button">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
