<?php
// Conexão com o banco de dados
require "conexaodb.php";

// Inicia sessões
session_start();

// Recupera o login
$login = isset($_POST["email"]) ? trim($_POST["email"]) : FALSE;
// Recupera a senha sem criptografar (será verificada com password_verify)
$senha = isset($_POST["password"]) ? trim($_POST["password"]) : FALSE;

// Usuário não forneceu a senha ou o login
if (!$login || !$senha) {
    echo "Você deve digitar sua senha e login!";
    exit;
}

/**
 * Executa a consulta no banco de dados.
 * Caso o número de linhas retornadas seja 1 o login é válido,
 * caso 0, inválido.
 */
// Usando mysqli com prepared statements para evitar SQL injection
// A verificação de erro de conexão foi movida para conexaodb.php para melhor separação de responsabilidades.

$stmt = $conn->prepare("SELECT id, nome, sobrenome, email, senha FROM usuario WHERE email = ?");
//$stmt = $conn->prepare("SELECT id, nome, email, senha FROM usuario WHERE email = ?");

$stmt->bind_param("s", $login);
$stmt->execute();
$result_id = $stmt->get_result();
$total = $result_id->num_rows;

// Caso o usuário tenha digitado um login válido o número de linhas será 1..
if ($total) {
    // Obtém os dados do usuário, para poder verificar a senha e passar os demais dados para a sessão
    $dados = $result_id->fetch_assoc();

    // Agora verifica a senha usando password_verify
    if (password_verify($senha, $dados["senha"])) {
        // TUDO OK! Agora, passa os dados para a sessão e redireciona o usuário
        // Armazena o ID do usuário logado na sessão
        $_SESSION["id_usuario"] = $dados["id"];
        // Armazena o nome do usuário logado na sessão
        $_SESSION["nome_usuario"] = stripslashes($dados["nome"]);
        // Armazena o sobrenome do usuário logado na sessão
        $_SESSION["sobrenome_usuario"] = stripslashes($dados["sobrenome"]);
        // Armazena o email do usuário logado na sessão
        $_SESSION["email_usuario"] = stripslashes($dados["email"]);
        header("Location: telainicial.php");
        $_SESSION["erro_login"] = "";
        exit;
    }
    // Senha inválida
    else {
        $_SESSION["erro_login"] = "Usuário ou senha inválida!";
        echo "<script> location.assign('index.php');</script>";
        exit;
    }
}
// Login inválido
else {
    $_SESSION["erro_login"] = "Usuário ou senha inválida!";
    echo "<script> location.assign('index.php');</script>";
    exit;
}
?>