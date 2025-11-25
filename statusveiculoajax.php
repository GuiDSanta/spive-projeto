 <?php
include("verifySession.php");
include("verifyRegister.php");

$voltar_para = 'meusveiculos.php';

// Verifica se veio o ID na URL
if (!isset($_GET['id'])) {
    die("Veículo não informado.");
}

$id_veiculo = intval($_GET['id']);

// Conexão com o banco
include("conexaodb.php");

// Busca o veículo selecionado
$sql = "SELECT * FROM veiculo WHERE id_veiculo = ? AND condutor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_veiculo, $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();

// Se não encontrar veículo = erro ou tentativa de acessar veículo de outro usuário
if ($result->num_rows == 0) {
    die("Veículo não encontrado ou você não tem permissão para acessá-lo.");
}

$veiculo = $result->fetch_assoc();

// Aqui você pode buscar os dados do dispositivo. Exemplo:
// $dispositivo = pegar dados do sensor...

$sql_disp = "SELECT * FROM dispositivo WHERE veiculo_id = ? ORDER BY id DESC 
        LIMIT 1";
$stmt_disp = $conn->prepare($sql_disp);
$stmt_disp->bind_param("i", $id_veiculo);
$stmt_disp->execute();
$result_disp = $stmt_disp->get_result();

$dispositivoExiste = $result_disp->num_rows > 0;

if ($dispositivoExiste) {
    $dispositivo = $result_disp->fetch_assoc();
}


$sqlpro = "SELECT * FROM proprietario WHERE id = ?";
$stmtpro = $conn->prepare($sqlpro);
$stmtpro->bind_param("i", $_SESSION['id_usuario']);
$stmtpro->execute();
$resultpro = $stmtpro->get_result();

// Se não encontrar veículo = erro ou tentativa de acessar veículo de outro usuário
if ($result->num_rows == 0) {
    die("Veículo não encontrado ou você não tem permissão para acessá-lo.");
}

$proprietario = $resultpro->fetch_assoc();
$cnh = $proprietario['cnh']; // Ex: 123456789

// Pega o primeiro e o último dígito
$primeiro = substr($cnh, 0, 1);
$ultimo = substr($cnh, -1);

// Gera asteriscos para o meio (tamanho total - 2)
$cnh = $primeiro . str_repeat('*', strlen($cnh) - 2) . $ultimo;

?>
 
 <div id="statusveiculo">
            <?php if (!$dispositivoExiste): ?>
                <div class="alert alert-warning mt-3">
                    Nenhum dispositivo está cadastrado para este veículo.<br>
                    Entre em contato com o suporte para ativação.
                </div>
            <?php endif; ?>



            <div style="height: 420px; padding: 15px; margin-bottom: 20px;">

                <?php if ($dispositivoExiste): ?>
                    <h6 class="text-secondary" style="font-size: 14px; margin-top: 20px;"><?php echo "Ultima atualização: " . $dispositivo['data_hora']; ?></h6>
                <?php endif; ?>
                <!-- TEMPERATURA -->
                <h5 class="mt-3">
                    Temperatura Interna:
                    <?= $dispositivoExiste ? $dispositivo['temperatura'] . " °C" : "—" ?>
                </h5>
                <hr>

                <h5 class="mt-3">Status Temperatura:
                    <?php if ($dispositivoExiste): ?>
                        <?php if ($dispositivo['temperatura'] >= 38): ?>
                            <span class="text-danger">Alto Risco!</span>
                        <?php else: ?>
                            <span class="text-success">Normal</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </h5>
                <hr>

                <!-- OXIGÊNIO -->
                <h5 class="mt-3">
                    Nível de Oxigênio:
                    <?= $dispositivoExiste ? $dispositivo['oxigenio'] . " p.p.m." : "—" ?>
                </h5>
                <hr>

                <h5 class="mt-3">Status Oxigênio:
                    <?php if ($dispositivoExiste): ?>
                        <?php if ($dispositivo['oxigenio'] < 2499): ?>
                            <span class="text-danger">Alto Risco!</span>
                        <?php else: ?>
                            <span class="text-success">Normal</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-muted">—</span>
                    <?php endif; ?>
                </h5>
                <hr>

                <!-- UMIDADE -->
                <h5 class="mt-3">
                    Nível de Umidade:
                    <?= $dispositivoExiste ? $dispositivo['umidade'] . "%" : "—" ?>
                </h5>
                <hr>

                <!-- PRESENÇA -->
                <h5 class="mt-3">Carro Vazio:
                    <?php
                    if (!$dispositivoExiste) {
                        echo "—";
                    } else {
                        echo ($dispositivo['presenca'] == 0 ? "Sim" : "Não");
                    }
                    ?>
                </h5>
                <hr>

            </div>

            <div class="alinhar text-center mt-3">

                <?php if (!$dispositivoExiste): ?>
                    <a class="btn btn-secondary disabled" tabindex="-1" aria-disabled="true">Ações</a>
                <?php else: ?>
                    <a class="btn btn-primary" href="acoesVeiculos.php?id=<?= $id_veiculo ?>">Ações</a>
                <?php endif; ?>

                <button type="button" class="btn text-light" onclick="window.location.href='<?= $voltar_para ?>'">Voltar</button>
            </div>
        </div>