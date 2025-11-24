<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
// Verifica se o usuário está logado
if (!isset($_SESSION["id_tecnico"]) || !isset($_SESSION["nome_tecnico"]) || !isset($_SESSION["email_tecnico"])) {
    echo "<script>alert('Acesso negado. Por favor, faça o login.');</script>";
    header("Location: logout.php");
    die('Acesso negado. Por favor, faça o login.');
}
?>