<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="css/recuperar-senha/-recuperar-senha-style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
</head>
<body>
    <main>
        <div class="redefinir-senha">
            <div class="login-voltar"><a class="voltar-login" href="login.php">X</a></div>
            <h1>Atualize sua senha</h1>
            <?php 
            if (isset($_SESSION['preencha-os-campos'])) {
                ?>
                <div class="mensagem-erro" id="mensagem-erro">
                    <?=$_SESSION['preencha-os-campos']?>
                </div>
                    <script>
                        // Oculta a mensagem após 4 segundos
                        setTimeout(function() {
                            const msg = document.getElementById('mensagem-erro');
                            if (msg) {
                                msg.style.transition = 'opacity 0.5s ease';
                                msg.style.opacity = '0';
                                setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                            }
                        }, 4000);
                    </script>
                <?php
                unset($_SESSION['preencha-os-campos']);
            }
            
            if (isset($_SESSION['email-nao-encontrado'])) {
                ?>
                <div class="mensagem-erro" id="mensagem-erro">
                    <?=$_SESSION['email-nao-encontrado']?>
                </div>
                    <script>
                        // Oculta a mensagem após 4 segundos
                        setTimeout(function() {
                            const msg = document.getElementById('mensagem-erro');
                            if (msg) {
                                msg.style.transition = 'opacity 0.5s ease';
                                msg.style.opacity = '0';
                                setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                            }
                        }, 4000);
                    </script>
                <?php
                unset($_SESSION['email-nao-encontrado']);
            }
            

            ?>
            <form action="verificar-email.php" method="post">
                <div class="label-input">
                    <label for="atualizar-senha">
                        Informe seu email para atualizar sua senha.
                    </label>
                    <input type="email" name="atualizar-senha" id="atualizar-senha" placeholder="Email...">
                </div>
                <div class="div-button">
                    <button type="submit">Continuar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>