<?php
header('Content-Type: application/json');
include 'conexaodb.php'; // sua conexão ao banco de dados

$cpf = $_POST['cpf'] ?? '';

$stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode(['existe' => $result->num_rows > 0]);

?>