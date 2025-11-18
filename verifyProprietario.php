<?php // Garanta que a sessão esteja iniciada para usar $_SESSION
include("conexaodb.php"); // Conexão com o banco
include("verifySession.php"); // Verifica se o usuário está logado
// 1. Obter o ID do usuário logado
$id_usuario = $_SESSION['id_usuario'];
// 2. VERIFICAR SE O USUÁRIO JÁ ESTÁ CADASTRADO COMO PROPRIETÁRIO/CONDUTOR
// Altere 'proprietario' para o nome real da sua tabela de condutores
$sql_check = "SELECT * FROM proprietario WHERE id = ?"; 
$stmt_check = $conn->prepare($sql_check);

if ($stmt_check === false) {
    // Trata erro de preparação da query, se necessário
    die('Erro na preparação da query de proprietário: ' . $conn->error);
}

$stmt_check->bind_param("i", $id_usuario);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    // SE NÃO HOUVER PROPRIETÁRIO CADASTRADO, REDIRECIONA
    $stmt_check->close();
    $conn->close();
    header("Location: cadastrarnovocondutor.php");
    exit; // Crucial para interromper a execução após o redirecionamento
}

// ... o restante do seu código original aqui ...
?>