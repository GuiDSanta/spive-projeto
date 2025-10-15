<?php

$host = '127.0.0.1:3306'; // altera para a porta correta do seu MySQL //na maquina do lab usar 3307 //na maquina pessoal usar 3306
$user = 'root';
$password = '';
$dbname = 'spive';

$conn = mysqli_connect($host, $user, $password, $dbname);

if ($conn === false) {
    die('Falha na conexão: ' . mysqli_connect_error());
}else{
    //echo('Conexão bem sucedida.');
}

?>