<?php
session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]) || !isset($_SESSION["email_usuario"])) {
    echo "<script>alert('Acesso negado. Por favor, faça o login.');</script>";
    header("Location: logout.php");
    die('Acesso negado. Por favor, faça o login.');
}
?>