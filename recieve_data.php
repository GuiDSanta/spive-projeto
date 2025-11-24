<?php
// receive_data.php
ini_set('display_errors',1); error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

include_once('conexaodb.php'); // ajuste caminho se necessário

// Lê JSON bruto
$raw = file_get_contents('php://input');
if (!$raw) {
    echo json_encode(['status'=>'erro','mensagem'=>'Nenhum conteúdo recebido']);
    exit;
}

$data = json_decode($raw, true);
if ($data === null) {
    echo json_encode(['status'=>'erro','mensagem'=>'JSON inválido']);
    exit;
}

// Verifica campos necessários
$required = ['vidro_aberto','temperatura','umidade','presenca','oxigenio','perigo_temp','perigo_oxi','ar_ligado','id_esp','veiculo_id'];
foreach ($required as $f) {
    if (!isset($data[$f])) {
        echo json_encode(['status'=>'erro','mensagem'=>"Campo faltando: $f"]);
        exit;
    }
}

// Prepara insert
$sql = "INSERT INTO dispositivo
    (vidro_aberto, temperatura, umidade, presenca, oxigenio, perigo_temp, perigo_oxi, ar_ligado, id_esp, veiculo_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(['status'=>'erro','mensagem'=>'Erro no prepare: '.$conn->error]);
    exit;
}

$stmt->bind_param(
    "iiiiiiiiii",
    $data['vidro_aberto'],
    $data['temperatura'],
    $data['umidade'],
    $data['presenca'],
    $data['oxigenio'],
    $data['perigo_temp'],
    $data['perigo_oxi'],
    $data['ar_ligado'],
    $data['id_esp'],
    $data['veiculo_id']
);

if ($stmt->execute()) {
    echo json_encode(['status'=>'ok','mensagem'=>'Inserido','insert_id'=>$stmt->insert_id]);
} else {
    echo json_encode(['status'=>'erro','mensagem'=>'Falha ao inserir: '.$stmt->error]);
}

$stmt->close();
$conn->close();
