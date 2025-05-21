<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty(trim($_POST['atualizar-senha']))) {
            $email = trim($_POST['atualizar-senha']);
    
            require_once "connection.php";
    
            $stmt = $conn->prepare("SELECT ID FROM usuario WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows === 1) {
                // O e-mail existe, redirecionar para o formulário de nova senha
                session_start();
                $_SESSION['email_para_redefinir'] = $email;
                header("Location: nova-senha.php");
                exit;
            } else {
                $_SESSION['email-nao-encontrado'] = "<p><i class='material-icons'>error</i> E-mail não encontrado</p>";
                header('Location: recuperar-senha.php');
                exit;
                // echo "<script>alert('E-mail não encontrado!'); window.location.href='recuperar-senha.php';</script>";
            }
    
            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['preencha-os-campos'] = "<p><i class='material-icons'>error</i> Preencha os campo</p>";
            header('Location: nova-senha.php');
            exit;
        }
    }
?>