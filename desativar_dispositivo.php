<?php
include_once 'verifySessionTecnico.php';
include_once 'conexaodb.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$veiculos = [];
$mensagem = "";

/* ============================
   1️⃣ BUSCAR VEÍCULOS PELO CPF
   ============================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cpf_busca"])) {

    $cpf = trim($_POST["cpf_busca"]);

    if ($cpf === "") {
        $mensagem = "Digite um CPF para buscar.";
    } else {

        // Buscar ID do usuário
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $resUser = $stmt->get_result();

        if ($resUser->num_rows === 0) {
            $mensagem = "Nenhum usuário encontrado com este CPF.";
        } else {
            $user = $resUser->fetch_assoc();
            $id_usuario = $user["id"];

            // Buscar veículos do usuário
            $stmt2 = $conn->prepare("SELECT * FROM veiculo WHERE proprietario_id = ?");
            $stmt2->bind_param("i", $id_usuario);
            $stmt2->execute();
            $resVeiculo = $stmt2->get_result();

            if ($resVeiculo->num_rows > 0) {
                $veiculos = $resVeiculo->fetch_all(MYSQLI_ASSOC);
            } else {
                $mensagem = "Usuário encontrado, mas nenhum veículo foi cadastrado.";
            }
        }
    }
}

/* ============================
   2️⃣ APAGAR APENAS O DISPOSITIVO
   ============================ */
if (isset($_GET["apagar_disp"])) {

    $id_veiculo = intval($_GET["apagar_disp"]);

    // Excluir dispositivo
    $stmtDel = $conn->prepare("DELETE FROM dispositivo WHERE veiculo_id = ?");
    $stmtDel->bind_param("i", $id_veiculo);

    if ($stmtDel->execute()) {
        $mensagem = "Dispositivo apagado com sucesso! (Veículo preservado).";
    } else {
        $mensagem = "Erro ao apagar o dispositivo.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Apagar Dispositivo</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <h1 class="text-center mb-4">Desativar Dispositivo</h1>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white text-center">
                    <h4 class="my-2">Buscar veículo pelo CPF</h4>
                </div>

                <div class="card-body">

                    <?php if ($mensagem != ""): ?>
                        <div class="alert alert-info text-center"><?php echo $mensagem; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">CPF do Usuário</label>
                            <input type="text" name="cpf_busca" class="form-control" placeholder="Digite o CPF" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Buscar Veículos</button>
                    </form>
                </div>
            </div>

            <?php if (!empty($veiculos)): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="my-2">Dispositivos encontrados</h4>
                    </div>
                    <div class="card-body table-responsive overflow-scroll">
                        <table class="table overflow-scroll table-bordered text-center">
                            <thead class="table-secondary">
                            <tr>
                                <th>ID</th>
                                <th>Modelo</th>
                                <th>Placa</th>
                                <th>Dispositivo</th>
                                <th>Ação</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach ($veiculos as $v): ?>

                                <?php  
                                // Verificar se o veículo possui dispositivo
                                $stmtCheck = $conn->prepare("SELECT veiculo_id FROM dispositivo WHERE veiculo_id = ?");
                                $stmtCheck->bind_param("i", $v['id_veiculo']);
                                $stmtCheck->execute();
                                $resCheck = $stmtCheck->get_result();
                                $temDispositivo = $resCheck->num_rows > 0;
                                ?>

                                <tr>
                                    <td><?= $v['id_veiculo']; ?></td>
                                    <td><?= $v['modelo']; ?></td>
                                    <td><?= $v['placa']; ?></td>
                                    <td><?= $temDispositivo ? "Cadastrado" : "Nenhum" ?></td>
                                    <td>
                                        <?php if ($temDispositivo): ?>
                                            <a href="?apagar_disp=<?= $v['id_veiculo']; ?>"
                                               onclick="return confirm('Tem certeza que deseja APAGAR somente o dispositivo deste veículo?');"
                                               class="btn btn-danger btn-sm">
                                                Apagar Dispositivo
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Sem dispositivo</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            <?php endif; ?>


            <div class="text-center mt-3">
                <a href="areatecnico.php" class="btn btn-outline-dark">Voltar</a>
            </div>

        </div>
    </div>
</div>
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
