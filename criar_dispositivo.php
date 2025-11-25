<?php
include_once 'verifySessionTecnico.php';
include_once 'conexaodb.php';


ini_set('display_errors', 1);
error_reporting(E_ALL);

define('RECEIVE_URL', 'http://localhost/T2DEV-T1/spive-projeto/recieve_data.php'); // <<--- ajuste aqui

$response = null;
$curl_error = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validação mínima no servidor (garante campos preenchidos)
    $required = ['vidro_aberto', 'temperatura', 'umidade', 'presenca', 'oxigenio', 'perigo_temp', 'perigo_oxi', 'ar_ligado', 'veiculo_id'];
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
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                                <label class="form-label">ID Veículo</label>
                                <input type="number" name="veiculo_id" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                Enviar JSON
                            </button>
                        </form>

                    </div>
                </div>
                <div class="text-center mt-3">
                <a href="areatecnico.php" class="btn btn-outline-dark">
                    Voltar para área técnica
                </a>
            </div>
            </div>
        </div>
    </div>


<script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>