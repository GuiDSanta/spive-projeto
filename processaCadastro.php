<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
    exit;
}

// Lê o JSON enviado
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

if (!isset($input['data'])) {
    echo json_encode(['success' => false, 'message' => 'JSON inválido']);
    exit;
}

$dados = $input['data'];
if (!is_array($dados)) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

// Funções de validação
function validarEmail($email) { return filter_var($email, FILTER_VALIDATE_EMAIL); }
function validarCPF($cpf) { return preg_match('/^\d{11}$/', $cpf); }
function validarTelefone($telefone) { return preg_match('/^\d{10,11}$/', $telefone); }
function validarCEP($cep) { return preg_match('/^\d{8}$/', $cep); }
function validarNascimento($nascimento) { 
    $data = strtotime($nascimento);
    return $data && $data < time();
}

// Sanitização
$nome = trim($dados['nome'] ?? '');
$sobrenome = trim($dados['sobrenome'] ?? '');
$email = trim($dados['email'] ?? '');
$password = trim($dados['password'] ?? '');
$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$cep = trim($dados['cep'] ?? '');
$logradouro = trim($dados['logradouro'] ?? '');
$numero = trim($dados['numero'] ?? '');
$cpf = trim($dados['cpf'] ?? '');
$nascimento = trim($dados['nascimento'] ?? '');
$telefone = trim($dados['telefone'] ?? '');

// Verificações obrigatórias
if (!$nome || !$sobrenome || !$email || !$password || !$cep || !$logradouro || !$numero || !$cpf || !$nascimento || !$telefone) {
    echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
    exit;
}

// Validações
if (!validarEmail($email) || !validarCPF($cpf) || !validarTelefone($telefone) || !validarCEP($cep) || !validarNascimento($nascimento)) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
    exit;
}

// Conexão
require_once 'conexaodb.php';

if (!isset($conn) || $conn->connect_errno) {
    echo json_encode(['success' => false, 'message' => 'Erro na conexão com o banco']);
    exit;
}

// Verifica email
$stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email já cadastrado']);
    $url = $_SERVER['REQUEST_URI'];
    if( $url == "/cadastro2.php" ){
        //redireciona para a página de cadastro
        header('Location: cadastro1.php');
    }
    exit;
}
$stmt->close();

// Verifica CPF (AQUI estava o erro!)
$stmt = $conn->prepare("SELECT * FROM usuario WHERE cpf = ?");
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'CPF já cadastrado']);
    exit;
}
$stmt->close();

// Inserção
$stmt = $conn->prepare("
    INSERT INTO usuario (nome, sobrenome, email, senha, cep, logradouro, numero, cpf, nascimento, telefone)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Erro ao preparar SQL']);
    exit;
}

$stmt->bind_param(
    'ssssssssss',
    $nome, $sobrenome, $email, $passwordHash,
    $cep, $logradouro, $numero,
    $cpf, $nascimento, $telefone
);

$stmt->execute();
$stmt->close();
$conn->close();

// RESPOSTA FINAL PARA O FETCH
echo json_encode(['success' => true]);
exit;
?>