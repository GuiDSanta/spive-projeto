<?php
include_once 'verifySessionTecnico.php';
include_once 'conexaodb.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$veiculos = [];
$mensagem = "";

// --- SE A BUSCA FOI REALIZADA ---
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cpf_busca"])) {

    $cpf = trim($_POST["cpf_busca"]);

    if ($cpf === "") {
        $mensagem = "Digite um CPF para buscar.";
    } else {

        /** 1️⃣ BUSCAR ID DO USUÁRIO PELO CPF **/
        $stmt = $conn->prepare("SELECT id FROM usuario WHERE cpf = ?");
        $stmt->bind_param("s", $cpf);
        $stmt->execute();
        $resUser = $stmt->get_result();

        if ($resUser->num_rows === 0) {
            $mensagem = "Nenhum usuário encontrado com este CPF.";
        } else {

            $user = $resUser->fetch_assoc();
            $id_usuario = $user["id"];

            /** 2️⃣ BUSCAR VEÍCULOS DO USUÁRIO **/
            $stmt2 = $conn->prepare("SELECT * FROM veiculo WHERE proprietario_id = ?");
            $stmt2->bind_param("i", $id_usuario);
            $stmt2->execute();
            $resVeiculo = $stmt2->get_result();

            if ($resVeiculo->num_rows > 0) {
                $veiculos = $resVeiculo->fetch_all(MYSQLI_ASSOC);
            } else {
                $mensagem = "Usuário encontrado, mas nenhum veículo foi cadastrado para ele.";
            }
        }
    }
}

// --- SE FOI SOLICITADO EXCLUSÃO ---
if (isset($_GET["delete"])) {

    $id = intval($_GET["delete"]);

    // 1 — Apagar dispositivos vinculados ao veículo (se existirem)
    $stmtDelDisp = $conn->prepare("DELETE FROM dispositivo WHERE veiculo_id = ?");
    $stmtDelDisp->bind_param("i", $id);
    $stmtDelDisp->execute(); // não precisamos validar, pois pode não existir dispositivo

    // 2 — Agora apagar o veículo
    $stmtDelVeic = $conn->prepare("DELETE FROM veiculo WHERE id_veiculo = ?");
    $stmtDelVeic->bind_param("i", $id);

    if ($stmtDelVeic->execute()) {
        $mensagem = "Veículo excluído com sucesso! Dispositivo vinculado removido (se existia).";
    } else {
        $mensagem = "Erro ao excluir o veículo.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Buscar Veículo por CPF</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">

            <h1 class="text-center mb-4">Buscar Registro de Veículo</h1>

            <!-- CARD DE BUSCA -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="my-2">Buscar pelo CPF do Usuário</h4>
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

                        <button type="submit" class="btn btn-success w-100">
                            Buscar Veículos
                        </button>
                    </form>

                </div>
            </div>

            <!-- RESULTADO DA BUSCA -->
            <?php if (!empty($veiculos)): ?>
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white text-center">
            <h4 class="my-2">Resultados da Busca</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered text-center">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Modelo</th>
                        <th>Placa</th>
                        <th>Cor</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($veiculos as $v): ?>
                        <tr>
                            <td><?php echo $v['id_veiculo']; ?></td>
                            <td><?php echo $v['modelo']; ?></td>
                            <td><?php echo $v['placa']; ?></td>
                            <td><?php echo $v['cor']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $v["id_veiculo"]; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Tem certeza que deseja excluir este veículo?');">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>
<?php endif; ?>


            <!-- BOTÃO VOLTAR -->
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
