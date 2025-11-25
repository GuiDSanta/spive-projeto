<?php
include("verifySession.php");
include("conexaodb.php");

$id_veiculo = $_GET['id'] ?? 0;

// busca o dispositivo do veículo
$sql = "SELECT * FROM dispositivo 
        WHERE veiculo_id = ?
        ORDER BY id DESC 
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_veiculo);
$stmt->execute();
$dispositivo = $stmt->get_result()->fetch_assoc();

$sqlveu = "SELECT * FROM veiculo WHERE id_veiculo = ?";
$stmtveu = $conn->prepare($sqlveu);
$stmtveu->bind_param("i", $id_veiculo);
$stmtveu->execute();
$veiculo = $stmtveu->get_result()->fetch_assoc();


$voltar_para = $_SERVER['HTTP_REFERER'] ?? 'index.php';

$sqlpro = "SELECT * FROM proprietario WHERE id = ?";
$stmtpro = $conn->prepare($sqlpro);
$stmtpro->bind_param("i", $_SESSION['id_usuario']);
$stmtpro->execute();
$resultpro = $stmtpro->get_result();

// Se não encontrar veículo = erro ou tentativa de acessar veículo de outro usuário
if ($resultpro->num_rows == 0) {
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
<div id="acoesveiculo" class="justify-content-evenly flex-column">
    <!-- ========================== VIDROS ========================== -->
        <h6 class="text-secondary" style="font-size: 14px; margin-top: 20px;"><?php echo "Ultima atualização: " . $dispositivo['data_hora']; ?></h6>
    <hr>
    <div class="linha">
        <h5 class="mt-2">Abaixar vidros:</h5>

        <?php if ($dispositivo['vidro_aberto'] == 1): ?>
            <button class="btn1 bg-danger mt-3"
                data-bs-toggle="modal"
                data-bs-target="#modalConfirmacao"
                data-acao="fechar_vidro"
                data-texto="Deseja realmente levantar os vidros?">Levantar</button>

        <?php else: ?>
            <button class="btn1 bg-success mt-3"
                data-bs-toggle="modal"
                data-bs-target="#modalConfirmacao"
                data-acao="abrir_vidro"
                data-texto="Deseja realmente abaixar os vidros?">Abaixar</button>
        <?php endif; ?>
    </div>

    <p>Controle dos vidros do veículo.</p>
    <hr>

    <!-- ========================== AR CONDICIONADO ========================== -->
    <div class="linha">
        <h5 class="mt-2">Ar condicionado:</h5>

        <?php if ($dispositivo['ar_ligado'] == 1): ?>
            <button class="btn1 bg-danger mt-3"
                data-bs-toggle="modal"
                data-bs-target="#modalConfirmacao"
                data-acao="desligar_ar"
                data-texto="Deseja realmente desligar o ar condicionado?">Desligar</button>

        <?php else: ?>
            <button class="btn1 bg-success mt-3"
                data-bs-toggle="modal"
                data-bs-target="#modalConfirmacao"
                data-acao="ligar_ar"
                data-texto="Deseja realmente ligar o ar condicionado?">Ligar</button>
        <?php endif; ?>

    </div>

    <p>Controle do Ar condicionado.</p>
    <hr>

    <!-- ========================== SOS ========================== -->
    <div class="linha">
        <div class="sos">
            <h5 class="mt-2 SOS">SOS :</h5>
        </div>

        <button class="btn2 bg-danger mt-3"
            data-bs-toggle="modal"
            data-bs-target="#modalConfirmacao"
            data-acao="sos"
            data-texto="⚠️ SOS é uma ação de emergência. Tem certeza que deseja continuar?">EMERGÊNCIA</button>
    </div>

    <p class="sos">Aciona a emergência.</p>
    <hr>

</div>