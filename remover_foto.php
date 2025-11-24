<?php
include("verifySession.php");
include("conexaodb.php");

$usuarioId = $_SESSION['id_usuario'];

// Buscar foto atual para apagar arquivo
$sql = "SELECT foto_perfil FROM usuario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$fotoAtual = $result['foto_perfil'] ?? null;

// Remove arquivo físico (exceto se for o padrão)
if ($fotoAtual && $fotoAtual !== 'img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png') {
    if (file_exists($fotoAtual)) {
        unlink($fotoAtual);
    }
}

// Atualizar banco para foto padrão
$sql = "UPDATE usuario SET foto_perfil = 'img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png' WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuarioId);
$stmt->execute();

// Atualizar sessão
$_SESSION['foto_perfil'] = 'img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png';

header("Location: perfil.php");
exit;
