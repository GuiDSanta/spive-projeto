<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

include_once('conexaodb.php');

// ESP32 envia x-www-form-urlencoded, então usamos $_POST
if (empty($_POST)) {
    echo json_encode(['status'=>'erro','mensagem'=>'Nenhum dado recebido via POST']);
    exit;
}

$data = $_POST;

// Lista de campos obrigatórios
$required = [
    'vidro_aberto','temperatura','umidade','presenca',
    'oxigenio','perigo_temp','perigo_oxi','ar_ligado','veiculo_id'
];

foreach ($required as $f) {
    if (!isset($data[$f])) {
        echo json_encode(['status'=>'erro','mensagem'=>"Campo faltando: $f"]);
        exit;
    }
}

// PREPARE CORRETO (temperatura e oxigenio são float)
$sql = "INSERT INTO dispositivo 
   (vidro_aberto, temperatura, umidade, presenca, oxigenio, perigo_temp, perigo_oxi, ar_ligado, veiculo_id)
   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "idiiiiiii",
    $data['vidro_aberto'],
    $data['temperatura'], // float
    $data['umidade'],
    $data['presenca'],
    $data['oxigenio'],    // float/decimal? Se for inteiro, mude "d" para "i"
    $data['perigo_temp'],
    $data['perigo_oxi'],
    $data['ar_ligado'],
    $data['veiculo_id']
);

if ($stmt->execute()) {
    echo json_encode(['status'=>'ok','insert_id'=>$stmt->insert_id]);
} else {
    echo json_encode(['status'=>'erro','mensagem'=>$stmt->error]);
}

$stmt->close();
$conn->close();
