<?php
$voltar_para = 'telainicial.php';
include("verifySession.php");
include("conexaodb.php");
include("verifyProprietario.php");

// Conexão com banco (caso esteja faltando)
// $conn = new mysqli("localhost","root","","spive");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new mysqli("127.0.0.1:3307", "root", "", "spive");

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO veiculo (foto, modelo, placa, marca, cor, proprietario_id, condutor_id) VALUES (?, ?, ?, ?, ?, ?, ?)");

    function erro($msg)
    {
        echo "<script>alert('$msg'); history.back();</script>";
        exit;
    }

    // FOTO
    $foto = $_FILES['foto'] ?? null;

    // CAMPOS (transforma tudo em maiúsculas)
    $modelo = strtoupper(trim($_POST['modelo'] ?? ''));
    $placa  = strtoupper(trim($_POST['placa'] ?? ''));
    $marca  = strtoupper(trim($_POST['marca'] ?? ''));
    $cor    = trim($_POST['corveiculo'] ?? '');
    $proprietario_id = $_SESSION['id_usuario'];
    $condutor_id = $_SESSION['id_usuario'];

    /* ---------------------------------------------------------
        VALIDAÇÃO DE MODELO
    ----------------------------------------------------------*/
    if (strlen($modelo) < 3 || !preg_match('/^[A-Za-z0-9À-ÖØ-öø-ÿ ]+$/', $modelo)) {
        erro("O modelo deve conter ao menos 3 caracteres e não pode conter símbolos.");
    }

    /* ---------------------------------------------------------
        VALIDAÇÃO DE MARCA
    ----------------------------------------------------------*/
    if (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', $marca)) {
        erro("A marca deve conter apenas letras.");
    }

    /* ---------------------------------------------------------
        VALIDAÇÃO DE PLACA
    ----------------------------------------------------------*/
    $padraoAntigo    = "/^[A-Z]{3}-[0-9]{4}$/";      // ABC-1234
    $padraoMercosul  = "/^[A-Z]{3}-[0-9][A-Z][0-9]{2}$/"; // ABC-1D23

    if (!preg_match($padraoAntigo, $placa) && !preg_match($padraoMercosul, $placa)) {
        erro("Placa inválida! Use o formato ABC-1234 ou ABC-1D23.");
    }

    /* ---------------------------------------------------------
        VALIDAÇÃO DE COR
    ----------------------------------------------------------*/
    $cores_validas = ['Azul', 'Amarelo', 'Branco', 'Cinza', 'Laranja', 'Marrom', 'Vinho', 'Verde', 'Vermelho', 'Roxo'];

    // Se escolheu "Outra"
    if ($cor === 'Outra') {
        erro("Digite a cor no campo indicado.");
    }

    // Convertendo cor para padrão
    $cor = ucfirst(strtolower($cor));

    if ($cor === "Selecione a cor do veículo:" || $cor === "") {
        erro("Por favor, selecione uma cor válida.");
    }

    if (!in_array($cor, $cores_validas)) {
        if (!preg_match('/^[A-Za-zÀ-ÖØ-öø-ÿ ]+$/', $cor)) {
            erro("O campo cor deve conter apenas letras.");
        }
    }

    /* ---------------------------------------------------------
        UPLOAD DA FOTO
    ----------------------------------------------------------*/
    $nomeFinal = null;

    if ($foto && $foto['error'] === 0) {

        if ($foto['size'] > 5 * 1024 * 1024) {
            erro("A foto não pode exceder 5MB.");
        }

        $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extensao, $permitidos)) {
            erro("Formato de imagem inválido! Envie JPG, PNG ou WEBP.");
        }

        $nomeFinal = "uploads/" . uniqid("foto_") . "." . $extensao;
        move_uploaded_file($foto['tmp_name'], $nomeFinal);
    }

    /* ---------------------------------------------------------
        INSERÇÃO NO BANCO
    ----------------------------------------------------------*/

    // IMPORTANTE: seu código não mostra a preparação do $stmt
    // então este trecho assume que você já fez:
    //
    // $stmt = $conn->prepare("INSERT INTO veiculos (foto, modelo, placa, marca, cor) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param('sssssii', $nomeFinal, $modelo, $placa, $marca, $cor, $proprietario_id, $condutor_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "<script>alert('Veículo cadastrado com sucesso!'); window.location.href='telainicial.php';</script>";
    exit;
}
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spive</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="shortcut icon" href="img/Spive (2048 x 2048 px) (1).png">
    <style>
        @font-face {
            font-family: 'madetommy';
            /* Nome que vai usar no CSS */
            src: url('font/madetommyfontR.otf') format('opentype');
            /* ou italic */
        }

        @font-face {
            font-family: 'madetommyM';
            /* Nome que vai usar no CSS */
            src: url('font/madetommyfontM.otf') format('opentype');
            /* ou italic */
        }

        .container {
            font-family: madetommy, sans-serif;
            background-color: white;
        }

        .icones {
            width: 32px;
            height: 32px;
            margin: 10px;
        }

        .icones2 {
            width: 36px;
            height: 32px;
            margin: 8px;
        }

        .icones3 {
            width: 80px;
            height: 80px;
            margin: 8px;
            margin-top: 35px;
        }

        .icones4 {
            width: 32px;
            height: 32px;
        }

        body {
            background-color: rgb(240, 240, 240);
            margin: 0;
        }

        .LogoSpive {
            height: 160px;
            background-color: #16427F;
        }

        .form {
            height: 675px;
            align-items: center;
            text-align: center;
            display: flex;
            flex-direction: column;
        }

        .form input {
            height: 48px;
            width: 304px;
            border: solid 2px rgb(102, 102, 102);
            box-shadow: 2px 2px 3px 0px grey;
        }

        .btn {
            width: 144px;
            height: 40px;
            background-color: #16427F;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.25s;
        }

        .btn:active {
            background-color: #1c519c;
            transition: 0.25s;
            transform: scale(1.1);
        }

        h1 {
            font-size: 40px;
            color: #16427F;
        }

        a {
            color: #437ECA;
            text-decoration: none;
        }

        .esqueci {
            margin-top: 30px;
        }

        select {
            height: 48px;
            width: 304px;
            border: solid 2px rgb(102, 102, 102);
            box-shadow: 2px 2px 3px 0px grey;
        }
    </style>
</head>

<body>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>


    <div class="LogoSpive">
        <div class="row">

            <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><img src="img/menu_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="icones position-absolute top-0 start-0 bg-transparent" width="32px" height="32px" alt=""></a>
            <div class="offcanvas offcanvas-start" style="max-width: 400px;
                width: 70%;" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                    <img src="img/Spive (2048 x 2048 px) (1).png" class="icones3" width="32px" height="32px" alt="">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">MENU SPIVE</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <hr>
                <div class="offcanvas-body ajustamento">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="telainicial.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house mb-1" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                                </svg>
                                Tela Inicial
                            </a>
                        </li>
                        <li>
                            <a href="meusveiculos.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill mb-1" viewBox="0 0 16 16">
                                    <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679q.05.242.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.8.8 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17s3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z" />
                                </svg>
                                Meus Veículos
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link active" aria-current="page">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle mb-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                                Cadastrar Veículo
                            </a>
                        </li>
                        <li>
                            <a href="saibamais.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-right" viewBox="0 0 16 16">
                                    <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                </svg>
                                Saiba Mais
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left mb-1" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                Sair
                            </a>
                        </li>
                    </ul>
                    <hr>


                    <div>
                        <a class="d-flex align-items-center link-dark" type="button" href="perfil.php">
                            <img src="<?php if($_SESSION['foto_perfil'] == 'img/account_circle_140dp_FFFFFF_FILL0_wght400_GRAD0_opsz48.png'){echo 'img/3364044.png';} else {echo $_SESSION['foto_perfil'];} ?>" alt="" width="16" height="16" class="icones4 rounded-circle me-2">
                            <strong><?php echo ($_SESSION['nome_usuario']) . " " . ($_SESSION['sobrenome_usuario']); ?></strong>
                        </a>
                    </div>

                </div>
            </div>
        </div>
<a href="telainicial.php"><img src="img/home_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" class="icones2 position-absolute top-0 end-0 bg-transparent" width="32px" height="32px" alt=""></a>

        <div class="text-center">
            <img src="img/Spive (2048 x 2048 px) (1).png" alt="" class="" width="180px" height="180px">
        </div>
    </div>
    <main class="container">
        <div class="form p-md-3">
            <br>
            <h1 class="text-center mb-3" style="font-family: madetommyM;">CADASTRO DE VEÍCULO</h1>
            <form id="meuFormulario" class="text-center" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate onsubmit="return verificaCadastro(event);" enctype="multipart/form-data">


                <div class="mb-3">
                    <div class="justify-content-start text-start mb-1">
                        <label for="foto">Foto do Veículo</label>
                    </div>
                    <input type="file" class="form-control" name="foto" id="foto"
                        accept="image/*" required />
                    <div class="invalid-feedback">Por favor, faça o envio da foto do veículo.</div>
                </div>


                <div class="mb-3">
                    <input type="text" class="form-control" name="modelo" id="modelo" minlength="3" placeholder="Modelo do Veículo"
                        required onkeyup="
                        modelo = document.getElementById('modelo');
                        modelotext = modelo.value.toUpperCase();
                        modelo.value = modelotext;"
                        onchange="
                        modelo = document.getElementById('modelo');
                        modelotext = modelo.value.toUpperCase();
                        modelo.value = modelotext;" />

                    <div class="invalid-feedback">Por favor, preencha o modelo do veículo.</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="placa" id="placa" minlength="3" maxlength="8"
                        placeholder="Placa do Veículo" required onkeyup="
                        placa = document.getElementById('placa');
                        placatext = placa.value.toUpperCase();
                        placa.value = placatext;"
                        onchange="
                        placa = document.getElementById('placa');
                        placatext = placa.value.toUpperCase();
                        placa.value = placatext;" oninput=" 
                        placavalue = document.getElementById('placa').value;
                        placareg = /^[A-Z]{3}-[0-9][A-Z0-9][0-9]{2}$/;

                        if (placavalue.length == 4 && placavalue[3] != '-') {
                            placa.value = placavalue[0] + placavalue[1] + placavalue[2] + '-' + placavalue[3];
                        }

                        if (placavalue.length == 8) {
                            if (placavalue.match(/^[A-Z]{3}-[0-9][A-Z0-9][0-9]{2}$/) || placavalue.match(/^[a-zA-Z]{3}[0-9][A-Za-z0-9][0-9]{2}$/)) {
                                placa.classList.remove('is-invalid');
                            } else {
                                placa.classList.add('is-invalid');
                                placa.nextElementSibling.textContent = 'Placa inválida. (ABC-1234 ou ABC-1D23)';
                            }

                        }" />
                    <div class="invalid-feedback">Placa inválida. (ABC-1234 ou ABC-1D23).</div>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" name="marca" id="marca" minlength="3"
                        placeholder="Marca do Veículo" required onkeyup="
                        marca = document.getElementById('marca');
                        marcatext = marca.value.toUpperCase();
                        marca.value = marcatext;"
                        onchange="
                        marca = document.getElementById('marca');
                        marcatext = marca.value.toUpperCase();
                        marca.value = marcatext;" />
                    <div class="invalid-feedback">Por favor, preencha a marca do veículo.</div>
                </div>

                <div class="form-group" id="campo-cor">
                    <select class="form-select"
                        style="border: solid 2px rgb(102, 102, 102); color:rgb(102, 102, 102);"
                        name="corveiculo" id="corveiculo">
                        <option>Selecione a cor do veículo:</option>
                        <option>Azul</option>
                        <option>Amarelo</option>
                        <option>Branco</option>
                        <option>Cinza</option>
                        <option>Laranja</option>
                        <option>Marrom</option>
                        <option>Vinho</option>
                        <option>Verde</option>
                        <option>Vermelho</option>
                        <option>Roxo</option>
                        <option>Outra</option>
                    </select>
                    <div class="invalid-feedback">Por favor, preencha a cor do veículo.</div>
                </div>

                <div class="mt-3">
                    <a href="informacoes.php">Onde encontrar essas informações?</a>
                </div>
                <br>
                <br>
                <div class="flex-row">
                    <button type="submit" class="btn btn-primary">Cadastrar</button>

            </form>
            <button type="button" class="btn text-light " onclick="window.location.href='<?= $voltar_para ?>'">Voltar</button>
        </div>
        </div>

    </main>
    <script>
        const campoCor = document.getElementById('campo-cor');

        // Função que cria o select novamente
        function criarSelectCor() {
            campoCor.innerHTML = `
      <select class="form-select" 
        style="border: solid 2px rgb(102, 102, 102); color:rgb(102, 102, 102);" 
        name="corveiculo" id="corveiculo">
        <option>Selecione a cor do veículo:</option>
        <option>Azul</option>
        <option>Amarelo</option>
        <option>Branco</option>
        <option>Cinza</option>
        <option>Laranja</option>
        <option>Marrom</option>
        <option>Vinho</option>
        <option>Verde</option>
        <option>Vermelho</option>
        <option>Roxo</option>
        <option>Outra</option>
      </select>
      <div class="invalid-feedback">Por favor, preencha a cor do veículo.</div>
    `;

            // Reanexa o evento ao novo select
            const selectCor = document.getElementById('corveiculo');
            selectCor.addEventListener('change', handleCorChange);
        }

        // Função que lida com a escolha de cor
        function handleCorChange(event) {
            if (event.target.value === 'Outra') {
                campoCor.innerHTML = `
        <input type="text" class="form-control" id="corveiculo" name="corveiculo"
          placeholder="Digite a cor do veículo" required
          style="border: solid 2px rgb(102, 102, 102); color:rgb(102, 102, 102); box-shadow: 2px 2px 3px 0px grey;">
        <div class="invalid-feedback">Por favor, preencha a cor do veículo.</div>
        <small><a href="#" id="voltarSelect"><br>⬅️ Voltar para lista de cores</a></small>
      `;

                // Reanexa o botão "voltar"
                document.getElementById('voltarSelect').addEventListener('click', function(e) {
                    e.preventDefault();
                    criarSelectCor();
                });
            }
        }

        // Ativa pela primeira vez
        document.getElementById('corveiculo').addEventListener('change', handleCorChange);


        function verificaCadastro(event) {
            let corveiculo = document.getElementById('corveiculo');
            let marca = document.getElementById('marca');
            let modelo = document.getElementById('modelo');
            let placa = document.getElementById('placa');
            // ---- Validação foto ----
            let foto = document.getElementById('foto');

            if (!foto.files || foto.files.length === 0) {
                alert('Por favor, envie a foto do veículo.');
                foto.classList.add('is-invalid');
                foto.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                event.preventDefault();
                return false;
            } else {
                foto.classList.remove('is-invalid');
                foto.style.border = 'solid 2px rgba(50, 122, 21, 1)';
            }


            // Expressões regulares de validação da placa
            const padraoAntigo = /^[A-Z]{3}-\d{4}$/; // ABC-1234
            const padraoMercosul = /^[A-Z]{3}-\d[A-Z]\d{2}$/; // ABC-1D23

            // ---- Validação modelo ----
            if (modelo.value.trim().length < 3) {
                modelo.classList.add('is-invalid');
                modelo.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, preencha o modelo do veículo com pelo menos 3 caracteres.');
                event.preventDefault();
                return false;
            } else {
                modelo.classList.remove('is-invalid');
                modelo.style.border = 'solid 2px rgba(50, 122, 21, 1)';
            }

            // ---- Validação placa ----
            let valorPlaca = placa.value.trim().toUpperCase();

            if (!padraoAntigo.test(valorPlaca) && !padraoMercosul.test(valorPlaca)) {
                placa.classList.add('is-invalid');
                placa.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Placa inválida! Use o formato ABC-1234 ou ABC-1D23.');
                event.preventDefault();
                return false;
            } else {
                placa.classList.remove('is-invalid');
                placa.style.border = 'solid 2px rgba(50, 122, 21, 1)';
                placa.value = valorPlaca; // força maiúsculas
            }

            // ---- Validação marca ----
            if (marca.value.trim().length < 3) {
                marca.classList.add('is-invalid');
                marca.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, preencha a marca do veículo com pelo menos 3 caracteres.');
                event.preventDefault();
                return false;
            } else {
                marca.classList.remove('is-invalid');
                marca.style.border = 'solid 2px rgba(50, 122, 21, 1)';
            }

            // ---- Validação cor ----
            if (corveiculo.value === 'Selecione a cor do veículo:') {
                corveiculo.classList.add('is-invalid');
                corveiculo.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, selecione a cor do veículo.');
                event.preventDefault();
                return false;
            } else {
                corveiculo.classList.remove('is-invalid');
                corveiculo.style.border = 'solid 2px rgba(50, 122, 21, 1)';
            }

            return true;


        }
    </script>
</body>
<script src="js/bootstrap.min.js"></script>


</html>