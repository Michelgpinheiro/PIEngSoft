<?php 
    session_start();

    if (!isset($_SESSION['email_para_redefinir'])) {
        header("Location: recuperar-senha.php");
        exit;
    }
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
            
                if (isset($_SESSION['senha-igual-anterior'])) {
                    ?>
                    <div class="mensagem-erro" id="mensagem-erro">
                        <?=$_SESSION['senha-igual-anterior']?>
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
                    unset($_SESSION['senha-igual-anterior']);
                }

                if (isset($_SESSION['senhas-nao-coincidem'])) {
                    ?>
                    <div class="mensagem-erro" id="mensagem-erro">
                        <?=$_SESSION['senhas-nao-coincidem']?>
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
                    unset($_SESSION['senhas-nao-coincidem']);
                }
                
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
            ?>
            <form action="salvar-nova-senha.php" method="post">
                <div class="label-input">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($_SESSION['email_para_redefinir']); ?>">
                    <label for="nova_senha" class="nova-senha" style="font-size: 20px; margin-bottom: 5px;">Nova senha</label>
                    <input type="password" name="nova_senha" placeholder="Nova senha...">
                    <label for="confirma_senha" class="confirma-senha" style="font-size: 20px; margin-bottom: 5px;">Confirmar senha</label>
                    <input type="password" name="confirma_senha" placeholder="Confirmar senha...">
                </div>
                <div class="div-button">
                    <button type="submit">Atualizar Senha</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>

                    