
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê o corpo da requisição JSON
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);

    if (!isset($input['data'])) {
        exit;
    }

    $dados = $input['data']; // Já é um array
    if (!is_array($dados)) {
        exit;
    }

    // Validação dos dados
    function validarEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function validarCPF($cpf)
    {
        return preg_match('/^\d{11}$/', $cpf);
    }
    function validarTelefone($telefone)
    {
        return preg_match('/^\d{10,11}$/', $telefone);
    }
    function validarCEP($cep)
    {
        return preg_match('/^\d{8}$/', $cep);
    }
    function validarNascimento($nascimento)
    {
        $data = strtotime($nascimento);
        return $data && $data < time();
    }

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

    // Campos obrigatórios
    if (!$nome || !$sobrenome || !$email || !$password || !$cep || !$logradouro || !$numero || !$cpf || !$nascimento || !$telefone) {
        exit;
    }
    if (!validarEmail($email) || !validarCPF($cpf) || !validarTelefone($telefone) || !validarCEP($cep) || !validarNascimento($nascimento)) {
        exit;
    }

    // Inclui o arquivo de conexão
    require_once 'conexaodb.php'; // Certifique-se que $conn está definido neste arquivo
    if (!isset($conn) || $conn->connect_errno) {
        exit;
    }

    $login = $email;
    $testcpf = $cpf;
    // Verifica se o email já está cadastrado
    $stmt = $conn->prepare("SELECT email, cpf FROM usuario WHERE email = ?");

    $stmt->bind_param("s", $login);
    $stmt->execute();
    $result_id = $stmt->get_result();
    $totalemail = $result_id->num_rows;

    if ($totalemail > 0) {
        // Email já cadastrado
        echo "<script> alert('Email já cadastrado'); location.assign('cadastro1.php');</script>";
    } 
    
    $stmt = $conn->prepare("SELECT email, cpf FROM usuario WHERE email = ?");

    $stmt->bind_param("s", $testcpf);
    $stmt->execute();
    $result_id = $stmt->get_result();
    $totalcpf = $result_id->num_rows;

    if ($totalcpf > 0) {
        // CPF já cadastrado
        echo "<script> alert('CPF já cadastrado'); location.assign('cadastro1.php');</script>";
    } 
    
    if ($totalemail === 0 && $totalcpf === 0) {
        $stmt = $conn->prepare("INSERT INTO usuario (nome, sobrenome, email, senha, cep, logradouro, numero, cpf, nascimento, telefone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            $conn->close();
            exit;
        }
        $stmt->bind_param('ssssssssss', $nome, $sobrenome, $email, $passwordHash, $cep, $logradouro, $numero, $cpf, $nascimento, $telefone);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        exit;
    }

    // Prepared statement para inserir

}
?>