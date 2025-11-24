<?php
include("verifySession.php");
include("conexaodb.php");

$acao = $_GET['acao'] ?? '';
$id_veiculo = $_GET['id'] ?? 0;

switch ($acao) {

    case 'abrir_vidro':
        $sql = "UPDATE dispositivo 
                SET vidro_aberto = 1 
                WHERE veiculo_id = ?
                ORDER BY id DESC 
                LIMIT 1";
        break;

    case 'fechar_vidro':
        $sql = "UPDATE dispositivo 
                SET vidro_aberto = 0 
                WHERE veiculo_id = ?
                ORDER BY id DESC 
                LIMIT 1";
        break;

    case 'ligar_ar':
        $sql = "UPDATE dispositivo 
                SET ar_ligado = 1 
                WHERE veiculo_id = ?
                ORDER BY id DESC 
                LIMIT 1";
        break;

    case 'desligar_ar':
        $sql = "UPDATE dispositivo 
                SET ar_ligado = 0 
                WHERE veiculo_id = ?
                ORDER BY id DESC 
                LIMIT 1";
        break;

    case 'sos':
        $sql = "UPDATE dispositivo 
                SET perigo_temp = 1, perigo_oxi = 1 
                WHERE veiculo_id = ?
                ORDER BY id DESC 
                LIMIT 1";
        break;

    default:
        die("Ação inválida.");
}


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_veiculo);

if ($stmt->execute()) {
    header("Location: acoesVeiculos.php?id=" . $id_veiculo);
    exit;
} else {
    echo "Erro ao atualizar.";
}

?>