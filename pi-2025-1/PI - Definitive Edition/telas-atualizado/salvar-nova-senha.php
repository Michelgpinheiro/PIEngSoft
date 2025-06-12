<?php

    session_start();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (!empty($_POST['nova_senha']) && !empty($_POST['confirma_senha'])) {
            $email = $_POST['email'];
            $senha = $_POST['nova_senha'];
            $confirma = $_POST['confirma_senha'];
    
            if ($senha !== $confirma) {
                $_SESSION['senhas-nao-coincidem'] = "<p><i class='material-icons'>error</i> Senhas não coincidem</p>";
                header('Location: nova-senha.php');
                exit;
            }
    
            require_once "connection.php";
    
           // Buscar senha atual
            $stmt = $conn->prepare("SELECT SENHA FROM usuario WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($senhaAtual);
            $stmt->fetch();
            $stmt->close();
    
            // Verifica se a nova senha é igual à antiga
            if (password_verify($senha, $senhaAtual)) {
                $_SESSION['senha-igual-anterior'] = "<p><i class='material-icons'>error</i> A nova senha não pode ser igual à anterior</p>";
                header('Location: nova-senha.php');
                exit;
            }
    
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    
            $stmt = $conn->prepare("UPDATE usuario SET SENHA = ? WHERE EMAIL = ?");
            $stmt->bind_param("ss", $senha_hash, $email);
            if ($stmt->execute()) {
                session_start();
                unset($_SESSION['email_para_redefinir']);
    
                $_SESSION['senha-refinida-sucesso'] = "<p><i class='material-icons'>check_circle</i> Senha atualizada com sucesso</p>";
                header('Location: login.php');
            } else {
                $_SESSION['erro-atualizar-senha'] = "<p><i class='material-icons'>error</i> Erro ao atualizar senha</p>";
                header('Location: login.php');
                exit;
            }
    
            $stmt->close();
            $conn->close();
        } else {
            $_SESSION['preencha-os-campos'] = "<p><i class='material-icons'>error</i> Preencha os campos</p>";
            header('Location: nova-senha.php');
            exit;
        }
    }
?>
