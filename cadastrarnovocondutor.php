<?php
$voltar_para = 'telainicial.php'; // página padrão se não houver referer
include("verifySession.php");
include("conexaodb.php"); // conexão com o banco

$id = $_SESSION['id_usuario'];
$sql_check = "SELECT * FROM proprietario WHERE id = ?"; 
$stmt_check = $conn->prepare($sql_check);

if ($stmt_check === false) {
    // Trata erro de preparação da query, se necessário
    die('Erro na preparação da query de proprietário: ' . $conn->error);
}

$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 1) {
    // SE NÃO HOUVER PROPRIETÁRIO CADASTRADO, REDIRECIONA
    $stmt_check->close();
    $conn->close();
    header("Location: cadastrarnovoveiculo.php");
    exit; // Crucial para interromper a execução após o redirecionamento
}
?>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $cnh = trim($_POST['cnh'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');

    $cpf = preg_replace('/\D+/', '', $cpf);
    $cnh = preg_replace('/\D+/', '', $cnh);

if(preg_match('/\d/', $nome)) {
    echo "<script>alert('Erro: O nome não pode conter números.'); history.back();</script>";
    exit;
}

if(!preg_match('/^\d{11}$/', $cpf)) {
    echo "<script>alert('Erro: O CPF deve conter 11 dígitos numéricos.'); history.back();</script>";
    exit;
}

if(!preg_match('/^\d{9}$/', $cnh)) {
    echo "<script>alert('Erro: A CNH deve conter 9 dígitos numéricos.'); history.back();</script>";
    exit;
}

if(empty($categoria)|| $categoria === 'Selecione a categoria da CNH:') {
    echo "<script>alert('Erro: A categoria não pode estar vazia.'); history.back();</script>";
    exit;
}

    // exemplo de insert (ajuste nomes de tabela/colunas e $conn)
    // certifique-se de ter $conn = new mysqli(...);
    $stmt = $conn->prepare("INSERT INTO proprietario (id,nome, cpf, cnh, categoria) VALUES (?,?, ?, ?, ?)");
    if (!$stmt) {
        echo "<script>alert('Erro no servidor. Tente mais tarde.'); history.back();</script>";
        exit;
    }

    $stmt->bind_param('issss', $id, $nome, $cpf, $cnh, $categoria);
    if (!$stmt->execute()) {
        echo "<script>alert('Erro ao salvar: " . addslashes($stmt->error) . "'); history.back();</script>";
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
    $conn->close();

    echo "<script>alert('Condutor cadastrado com sucesso!'); window.location.href='meusveiculos.php';</script>";
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
                            <a href="#" class="nav-link link-dark" aria-current="page">
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
                            <img src="img/3364044.png" alt="" width="16" height="16" class="icones4 rounded-circle me-2">
                            <strong><?php echo ($_SESSION['nome_usuario']) . " " . ($_SESSION['sobrenome_usuario']); ?></strong>
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <div class="text-center">
            <img src="img/Spive (2048 x 2048 px) (1).png" alt="" class="" width="180px" height="180px">
        </div>
    </div>
    <main class="container">
        <div class="form p-md-3">
            <br>
            
            <h1 class="text-center mb-3" style="font-family: madetommyM;">CADASTRO DE PROPRIETÁRIO</h1>
            <h6 class="text-center mb-3 " style="font-family: madetommyM;">É necessário ser um condutor para registrar um veículo</h6>
            <form id="formCondutor" class="text-center" method="post" novalidate action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Nome Completo -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="nome" value="<?php echo $_SESSION['nome_usuario'] . " " . $_SESSION['sobrenome_usuario']; ?>" id="nome" minlength="3" required/>
                    <div class="invalid-feedback">Por favor, preencha este campo.</div>
                </div>

                <!-- CPF -->
                <div class="mb-3">
                    <input type="text" class="form-control" name="cpf" id="cpf" value="<?php echo stripslashes($_SESSION['cpf_usuario']); ?>" required>
                    <div class="invalid-feedback">Por favor, insira um CPF válido.</div>
                </div>

                <!-- Número da CNH -->
                <div class="mb-3">
                    <input type="text" maxlength="9" class="form-control" name="cnh" id="cnh" minlength="9"
                         placeholder="Número da CNH" required>
                    <div class="invalid-feedback">Por favor, insira o número da CNH corretamente.</div>
                </div>

                <!-- Categoria da CNH -->
                <div class="form-group" id="campo-categoria">
                    <select class="form-select"
                        style="border: solid 2px rgb(102, 102, 102); color:rgb(102, 102, 102);"
                        name="categoria" id="categoria" required>
                        <option>Selecione a categoria da CNH:</option>
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>C</option>
                        <option>D</option>
                        <option>E</option>
                    </select>
                    <div class="invalid-feedback">Por favor, selecione a categoria da CNH.</div>
                </div>

                <br><br>

                <div class="flex-row">
                    <button type="submit" class="btn btn-primary" onclick="
            let nome = document.getElementById('nome');
            let cpf = document.getElementById('cpf');
            let cnh = document.getElementById('cnh');
            let categoria = document.getElementById('categoria');

            if(nome.value.trim().length < 3){
                nome.classList.add('is-invalid');
                nome.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, preencha o nome completo do condutor com pelo menos 3 caracteres.');
                event.preventDefault();
                return false;
            }else{
                nome.classList.remove('is-invalid');
                nome.classList.add('is-valid');
                nome.style.border = 'solid 2px rgb(102, 102, 102)';
            }

            if(cnh.value.trim().length < 5){
                cnh.classList.add('is-invalid');
                cnh.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, preencha o número da CNH corretamente.');
                event.preventDefault();
                return false;
            }else{
                cnh.classList.remove('is-invalid');
                cnh.classList.add('is-valid');
                cnh.style.border = 'solid 2px rgb(102, 102, 102)';
            }

            if(categoria.value == 'Selecione a categoria da CNH:'){
                categoria.classList.add('is-invalid');
                categoria.style.border = 'solid 2px rgba(185, 0, 0, 1)';
                alert('Por favor, selecione a categoria da CNH.');
                event.preventDefault();
                return false;
            }else{
                categoria.classList.remove('is-invalid');
                categoria.classList.add('is-valid');
                categoria.style.border = 'solid 2px rgb(102, 102, 102)';
            }

            window.location.href='<?= $voltar_para ?>'

        ">Cadastrar</button>
                
            </form>

            <button type="button" class="btn text-light " onclick="window.location.href='<?= $voltar_para ?>'">Voltar</button>
        </div>
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
    </script>
</body>
<script src="js/bootstrap.min.js"></script>
<script>
    placa.addEventListener("input", function() {
        placa = document.getElementById('placa');
        placavalue = document.getElementById('placa').value;
        placareg = /^[A-Z]{3}-[0-9][A-Z0-9][0-9]{2}$/;

        if (placavalue.length == 4 && placavalue[3] != "-") {
            placa.value = placavalue[0] + placavalue[1] + placavalue[2] + "-" + placavalue[3];
        }

        if (placavalue.length == 8) {
            if (placavalue.match(/^[A-Z]{3}-[0-9][A-Z0-9][0-9]{2}$/) || placavalue.match(/^[a-zA-Z]{3}[0-9][A-Za-z0-9][0-9]{2}$/)) {
                placa.classList.remove("is-invalid");
            } else {
                placa.classList.add("is-invalid");
                placa.nextElementSibling.textContent = "Placa inválida. (ABC-1234 ou ABC-1D23)";
            }

        }

    });
</script>



</html>