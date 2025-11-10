<?php
$voltar_para = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // página padrão se não houver referer
session_start();

if (!isset($_SESSION["id_usuario"]) || !isset($_SESSION["nome_usuario"]) || !isset($_SESSION["email_usuario"])) {
    $_SESSION["nome_usuario"] = "Faça Login";
    $_SESSION["sobrenome_usuario"] = "";
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
            background-color: rgb(240, 240, 240);
        }

        body {
            background-color: rgb(240, 240, 240);
            margin: 0;
        }

        .LogoSpive {
            height: 260px;
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
            margin-top: 130px;
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

        .fotoperfil {
            width: 140px;
            height: 140px;
            margin-top: 10px;
        }

        .usuario {
            color: #e9e9e9ff;
            margin-top: 160px;
        }

        .usuario2 {
            color: #437ECA;
            ;
            margin-top: 180px;
        }

        .carros {
            width: 350px;
            height: 202px;
            border-radius: 6px;
            border: 1px solid black;
        }

        .jeferson {
            margin-top: 10px;
            margin-left: 250px;
        }

        .imgcarro {
            width: 246px;
            height: 136px;
        }

        img {
            width: 256px;
            height: 226px;
        }

        hr {
            color: #000000ff;
        }

        .carros {
            max-width: 300px;
            max-height: 300px;
            width: 70%;
            height: auto;
            border: none;
            margin: 1px;
        }
    </style>
</head>

<body>
    <div class="LogoSpive">
        <div class="text-center">
            <img src="img/Spive (2048 x 2048 px) (1).png" alt="" class="carros" width="180px" height="300px">
        </div>
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
                            <a href="cadastrarnovoveiculo.php" class="nav-link link-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle mb-1" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                </svg>
                                Cadastrar Veículo
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link active" aria-current="page">
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
                            <strong><?php echo ($_SESSION['nome_usuario'])." ".($_SESSION['sobrenome_usuario']); ?></strong>
                        </a>
                    </div>


                </div>
            </div>

    </div>
    <main class="container">
        <div class="container py-5">
            <h1 class="text-center mb-5">Saiba Mais</h1>
            <div class="row g-4">


                <!-- Card sobre a aplicação -->
                <div class="col-md-6">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Sobre a Aplicação</h3>
                        <p>O <strong>Spive</strong> é uma aplicação desenvolvida com o objetivo de <strong>proteger
                                vidas dentro de veículos</strong> — sejam elas de crianças, animais de estimação ou
                            qualquer outro ser vivo que possa ser esquecido em carros, vans ou utilitários. A proposta é
                            permitir que até veículos mais simples possam integrar o sistema, ampliando a segurança de
                            forma prática e acessível.</p>
                    </div>
                </div>


                <!-- Card recursos de monitoramento -->
                <div class="col-md-6">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Recursos de Monitoramento</h3>
                        <ul>
                            <li>Monitoramento de <strong>oxigênio (O₂)</strong> e <strong>dióxido de carbono
                                    (CO₂)</strong>;</li>
                            <li>Medição da <strong>temperatura</strong> interna do veículo;</li>
                            <li><strong>Sensor de presença</strong> para detectar ocupantes ou movimentação;</li>
                            <li>Envio de <strong>notificações em tempo real</strong> ao usuário.</li>
                        </ul>
                    </div>
                </div>


                <!-- Card ações automáticas -->
                <div class="col-md-6">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Ações Automáticas</h3>
                        <p>Em situações de risco, o Spive pode acionar medidas automáticas visando reduzir o perigo para
                            o ocupante:</p>
                        <ul>
                            <li>Abertura leve das janelas para ventilação;</li>
                            <li>Acionamento do ar-condicionado (quando disponível no veículo);</li>
                            <li>Rotinas configuráveis pelo usuário.</li>
                        </ul>
                    </div>
                </div>


                <!-- Card conta de acesso -->
                <div class="col-md-6">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Conta e Acesso</h3>
                        <p>Para utilizar o Spive e receber alertas personalizados é <strong>necessário possuir uma
                                conta</strong>. A conta permite:</p>
                        <ul>
                            <li>Associar veículos e sensores ao perfil do usuário;</li>
                            <li>Configurar níveis de alerta e ações automáticas;</li>
                            <li>Receber notificações em tempo real via aplicativo ou e-mail.</li>
                        </ul>
                    </div>
                </div>


                <!-- Card segurança de dados -->
                <div class="col-md-12">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Segurança de Dados</h3>
                        <p>O Spive é um projeto acadêmico em desenvolvimento e não deve ser utilizado como meio oficial
                            de armazenamento de informações pessoais. Recomendamos fortemente que <strong>não insira
                                dados sensíveis ou reais</strong> durante o cadastro, tais como:</p>
                        <ul>
                            <li>Nome completo verdadeiro;</li>
                            <li>Documentos (CPF, RG, CNH, etc.);</li>
                            <li>Endereço residencial;</li>
                            <li>Senhas utilizadas em outros serviços;</li>
                            <li>Informações bancárias ou financeiras.</li>
                        </ul>
                        <p>Utilize <strong>informações fictícias</strong> ao interagir com o sistema. O objetivo do
                            Spive é demonstrar funcionalidades técnicas para fins de estudo, e não oferecer uma
                            plataforma de uso comercial.</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-rounded shadow-sm h-100 p-4">
                        <h3 class="h5">Equipe de Desenvolvimento</h3>
                        <p>O Spive é um projeto desenvolvido pela <strong>equipe MegaDev</strong>, formada por
                            estudantes do <strong>SENAI</strong>. Nossa missão é aplicar os conhecimentos adquiridos
                            durante a formação para criar soluções tecnológicas que tenham impacto positivo na
                            sociedade.</p>
                        <p>Este trabalho reflete o esforço colaborativo de todos os integrantes do grupo, que uniram
                            suas habilidades em programação, eletrônica e design de sistemas para construir uma
                            aplicação inovadora e acessível.</p>
                    </div>
                </div>


            </div>
            <div class="justify-content-center d-flex">
                <button type="button" class="btn btn-primary text-center mt-3 " onclick="window.location.href='<?= $voltar_para ?>'">Voltar</button>
            </div>
        </div>

</body>
<script src="js/bootstrap.min.js"></script>

</html>