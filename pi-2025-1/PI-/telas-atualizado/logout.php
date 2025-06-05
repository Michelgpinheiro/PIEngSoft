<?php
    session_start();              // Inicia a sessão
    session_unset();              // Remove todas as variáveis de sessão
    session_destroy();            // Destroi a sessão atual

    // Redireciona o usuário para a página de login
    header("Location: login.php");
    exit;
?>
