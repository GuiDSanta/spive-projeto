<?php
$voltar_para = $_SERVER['HTTP_REFERER'] ?? 'index.php'; // página padrão se não houver referer
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
            padding-bottom: 9vh;
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
    </style>
</head>

<body>
    <div class="LogoSpive">
        <div class="text-center">
            <img src="img/Spive (2048 x 2048 px) (1).png" alt="" class="" width="180px" height="180px">
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