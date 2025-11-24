<?php
session_start();
include("conexaodb.php");

if (isset($_FILES['foto'])) {

    $file = $_FILES['foto'];

    $pasta = "uploads/";
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $nomeFoto = uniqid() . ".jpg";
    $caminhoFinal = $pasta . $nomeFoto;

    move_uploaded_file($file['tmp_name'], $caminhoFinal);

    $id_usuario = $_SESSION['id_usuario'];
    $sql = "UPDATE usuario SET foto_perfil = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $caminhoFinal, $id_usuario);
    $stmt->execute();

    // Atualiza também a sessão para mostrar a nova foto sem recarregar
    $_SESSION['foto_perfil'] = $caminhoFinal;

    echo "OK";
}
?>
