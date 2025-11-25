<?php
// Inicie a sessão
include 'verifySessionTecnico.php';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Criar registro (JSON)</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Evita cache no celular -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <link rel="stylesheet" href="css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="text-center mb-5">Área Técnico SPIVE</h1>
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="text-secondary"><?php echo "Bem-vindo, " . $_SESSION['nome_tecnico'] . " " . $_SESSION['sobrenome_tecnico']; ?></h4>
                    <a href="logout.php" class="nav-link link-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-box-arrow-left mb-1" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                            <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                        </svg>
                        Sair
                    </a>
                </div>
                <div class="card shadow-sm my-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="my-2">Criar Registro (Simulação ESP-32)</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center text-center">
                        <button onclick="window.location.href='criar_dispositivo.php'" class=" btn btn-success">Criar Registro</button>
                    </div>
                </div>
                <div class="card shadow-sm my-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="my-2">Verificação de Veículo (Busca ID)</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center text-center">
                        <button onclick="window.location.href='buscar_veiculo.php'" class=" btn btn-success">Realizar Busca</button>
                    </div>
                </div>
                <div class="card shadow-sm my-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h4 class="my-2">Desativação dispositivo</h4>
                    </div>
                    <div class="card-body d-flex justify-content-center text-center">
                        <button onclick="window.location.href='desativar_dispositivo.php'" class=" btn btn-success">Realizar Busca</button>
                    </div>
                </div>
            </div>
        </div>

    </div>



</body>
<script src="js/bootstrap.bundle.min.js"></script>


</html>