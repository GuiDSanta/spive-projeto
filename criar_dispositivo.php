<?php
// criar_dispositivo.php
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

            <!-- Exibição da resposta -->
            <?php if (isset($response) && $response !== null): ?>
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-info text-white">
                        <strong>Resposta do servidor</strong>
                    </div>
                    <div class="card-body">
                        <pre class="bg-light p-3 border rounded"><?php echo htmlspecialchars($response); ?></pre>
                        <p><strong>Código HTTP:</strong> <?php echo isset($http_code) ? $http_code : 'n/a'; ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Erro CURL -->
            <?php if (!empty($curl_error)): ?>
                <div class="alert alert-danger mt-4">
                    <strong>Erro cURL:</strong><br>
                    <?php echo htmlspecialchars($curl_error); ?>
                    <hr>
                    Verifique se <strong>RECEIVE_URL</strong> está correto e se o servidor está rodando.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>