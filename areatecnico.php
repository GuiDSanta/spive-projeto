<?php
// Inicie a sessão
include_once 'verifySessionTecnico.php';
include_once 'conexaodb.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);

define('RECEIVE_URL', 'http://localhost/T2DEV-T1/spive-projeto/recieve_data.php'); // <<--- ajuste aqui

$response = null;
$curl_error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validação mínima no servidor (garante campos preenchidos)
    $required = ['vidro_aberto', 'temperatura', 'umidade', 'presenca', 'oxigenio', 'perigo_temp', 'perigo_oxi', 'ar_ligado', 'id_esp', 'veiculo_id'];
    foreach ($required as $f) {
        if (!isset($_POST[$f]) || $_POST[$f] === '') {
            $response = json_encode(['status' => 'erro', 'mensagem' => "Campo $f é obrigatório"]);
            goto render;
        }
    }

    $data = [
        'vidro_aberto' => (int)$_POST['vidro_aberto'],
        'temperatura'   => (int)$_POST['temperatura'],
        'umidade'       => (int)$_POST['umidade'],
        'presenca'      => (int)$_POST['presenca'],
        'oxigenio'      => (int)$_POST['oxigenio'],
        'perigo_temp'   => (int)$_POST['perigo_temp'],
        'perigo_oxi'    => (int)$_POST['perigo_oxi'],
        'ar_ligado'     => (int)$_POST['ar_ligado'],
        'id_esp'        => (int)$_POST['id_esp'],
        'veiculo_id'    => (int)$_POST['veiculo_id']
    ];

    $json = json_encode($data);

    // Envia via POST (JSON) para receive_data.php
    $ch = curl_init(RECEIVE_URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Content-Length: ' . strlen($json)]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);
    if ($response === false) {
        $curl_error = curl_error($ch);
    }
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
}
render:
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Criar registro (JSON)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="text-center mb-5">Área Técnico</h1>
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="my-2">Criar Registro do Dispositivo (JSON)</h4>
                </div>
                <div class="card-body">

                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

                        <div class="mb-3">
                            <label class="form-label">Vidro aberto</label>
                            <select name="vidro_aberto" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Temperatura</label>
                            <input type="number" name="temperatura" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Umidade</label>
                            <input type="number" name="umidade" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Presença</label>
                            <select name="presenca" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Oxigênio</label>
                            <input type="number" name="oxigenio" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Perigo Temperatura</label>
                            <select name="perigo_temp" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Perigo Oxigênio</label>
                            <select name="perigo_oxi" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ar ligado</label>
                            <select name="ar_ligado" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ID ESP</label>
                            <input type="number" name="id_esp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ID Veículo</label>
                            <input type="number" name="veiculo_id" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Enviar JSON
                        </button>
                    </form>

                </div>
            </div>
            <div>
                <a href="logout.php" class="nav-link link-dark text-center mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-box-arrow-left mb-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                Sair
                            </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>