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

// Recebe os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];

// Insere os dados na tabela TBL_USUARIO
$sql = "INSERT INTO TBL_USUARIO (NOME, EMAIL) VALUES ('$nome', '$email')";

if ($conn->query($sql) === TRUE) {
    // Redireciona para uma página de sucesso ou de cadastro novamente
    header("Location: sucesso.php"); // Ou para o mesmo formulário: header("Location: cadastro_usuario.php");
    exit; // Evita que o script continue executando
} else {
    // Em caso de erro, redireciona para a página de erro ou exibe uma mensagem
    header("Location: erro.php"); // Ou pode retornar para o formulário com um erro
    exit;
}

// Fecha a conexão
$conn->close();
?>
