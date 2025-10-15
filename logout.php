<?php
session_start();
session_unset();  // remove todas as variáveis de sessão
session_destroy(); // destrói a sessão

// redireciona para a página de login
header("Location: index.php");
exit;
?>