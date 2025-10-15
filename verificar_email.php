<?php
header('Content-Type: application/json');
include 'conexaodb.php'; // sua conexão ao banco de dados

$email = $_POST['confemail'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['existe' => false]);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode(['existe' => $result->num_rows > 0]);

?>