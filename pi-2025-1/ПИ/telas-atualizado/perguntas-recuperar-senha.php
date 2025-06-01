<?php 
    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['email_para_redefinir'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        function removerAcentos($string) {
            return preg_replace(
                array(
                    '/[áàãâä]/u', '/[ÁÀÃÂÄ]/u',
                    '/[éèêë]/u', '/[ÉÈÊË]/u',
                    '/[íìîï]/u', '/[ÍÌÎÏ]/u',
                    '/[óòõôö]/u', '/[ÓÒÕÔÖ]/u',
                    '/[úùûü]/u', '/[ÚÙÛÜ]/u',
                    '/[ç]/u',    '/[Ç]/u'
                ),
                array(
                    'a', 'A',
                    'e', 'E',
                    'i', 'I',
                    'o', 'O',
                    'u', 'U',
                    'c', 'C'
                ),
                $string
            );
        }

        $pergunta_1 = mb_strtolower(removerAcentos($_POST['pergunta-1']), "UTF-8");
        $pergunta_2 = mb_strtolower(removerAcentos($_POST['pergunta-2']), "UTF-8");
        $pergunta_3 = mb_strtolower(removerAcentos($_POST['pergunta-3']), "UTF-8");

        $email_usuario = $_SESSION['email_para_redefinir'];

        $stmt = $conn->prepare("SELECT PERGUNTA_1, PERGUNTA_2, PERGUNTA_3 FROM usuario WHERE EMAIL = ?");
        $stmt->bind_param("s", $email_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($row = $result->fetch_assoc()) {
            $pergunta_banco1 = $row['PERGUNTA_1'];
            $pergunta_banco2 = $row['PERGUNTA_2'];
            $pergunta_banco3 = $row['PERGUNTA_3'];

            if (
                password_verify($pergunta_1, $pergunta_banco1) &&
                password_verify($pergunta_2, $pergunta_banco2) &&
                password_verify($pergunta_3, $pergunta_banco3)
            ) {
                header('Location: nova-senha.php');
                exit;
            } else {
                $_SESSION['resposta-pergunta-errada'] = "<p><i class='material-icons'>error</i> Você errou uma ou algumas perguntas, tente novamente</p>";
                header('Location: '. $_SERVER['PHP_SELF']);
                exit;
            }
        } else {
            $_SESSION['resposta-pergunta-errada'] = "<p><i class='material-icons'>error</i> Usuário não encontrado</p>";
            header('Location: '. $_SERVER['PHP_SELF']);
            exit;
        }
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

            if (isset($_SESSION['resposta-pergunta-errada'])) {
                ?>
                <div class="mensagem-erro" id="mensagem-erro">
                    <?=$_SESSION['resposta-pergunta-errada']?>
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
                unset($_SESSION['resposta-pergunta-errada']);
            } 

            ?>
            <form action="perguntas-recuperar-senha.php" method="POST">
                <div class="label-input1 label-input">
                    <label for="atualizar-senha">
                        Informe qual cidade sua mãe nasceu.
                    </label>
                    <input type="text" name="pergunta-1" id="atualizar-senha" placeholder="Cidade..." required>
                </div>
                <div class="label-input1 label-input">
                    <label for="atualizar-senha">
                        Informe o nome do seu primeiro animal de estimação.
                    </label>
                    <input type="text" name="pergunta-2" id="atualizar-senha" placeholder="Animal..." required>
                </div>
                <div class="label-input1 label-input">
                    <label for="atualizar-senha">
                        Informe o nome do seu professor favorito.
                    </label>
                    <input type="text" name="pergunta-3" id="atualizar-senha" placeholder="Professor..." required>
                </div>
                <div class="div-button">
                    <button type="submit">Continuar</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>