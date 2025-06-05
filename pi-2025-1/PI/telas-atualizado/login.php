<?php 

    session_start();

    require_once "connection.php";
    
    if (isset($_SESSION['cadastro-sucesso'])) {
        $email = $_SESSION['email-usuario'];
        $senha = $_SESSION['senha-usuario'];

        $stmt_login = $conn->prepare("SELECT * FROM usuario WHERE EMAIL = ?");
        $stmt_login->bind_param("s", $email);
        $stmt_login->execute();
        $result = $stmt_login->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

           if ($row['ID_TP_USU'] == 2) {
                $_SESSION['admin'] = true;
            }

            if (password_verify($senha, $row['SENHA'])) {

                $_SESSION['id-usuario'] = $row['ID'];
                $_SESSION['foto'] = $row['FOTO'];

                if ($_SESSION['admin']) {
                    $_SESSION['nome-fantasia'] = $row['NOME'];
                    header('Location: tela-inicial-adm.php');
                } else {
                    if (is_null($row['CNPJ'])) {
                        $_SESSION['nome-usuario'] = $row['NOME']; 
                    } else {
                        $_SESSION['nome-fantasia'] = $row['NOME_FANTASIA'];  
                    }
                    header('Location: tela-inicial.php');
                }
                exit;

            }
        }

        $stmt_login->close();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST['email']) && !empty($_POST['senha'])) {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);

            $stmt = $conn->prepare("SELECT * FROM usuario WHERE EMAIL = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                if ($row['ID_TP_USU'] == 2) {
                    $_SESSION['admin'] = true;
                }

                if (password_verify($senha, $row['SENHA'])) {

                    $_SESSION['id-usuario'] = $row['ID'];
                    $_SESSION['foto'] = $row['FOTO'];

                    if ($_SESSION['admin']) {
                        $_SESSION['nome-fantasia'] = $row['NOME'];
                        header('Location: tela-inicial-adm.php');
                    } else {
                        if (is_null($row['CNPJ'])) {
                            $_SESSION['nome-usuario'] = $row['NOME']; 
                        } else {
                            $_SESSION['nome-fantasia'] = $row['NOME_FANTASIA']; 
                        }
                        header('Location: tela-inicial.php');
                    }
                    exit;
                } else {
                    $_SESSION['senha-incorreta'] = "<p><i class='material-icons'>error</i> Senha incorreta</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            } else {
                $_SESSION['usuario-nao-encontrado'] = "<p><i class='material-icons'>error</i> Usuário não encotrado</p>";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            $stmt->close();
        } else {
            $_SESSION['preencha-os-campos'] = "<p><i class='material-icons'>error</i> Preencha os campos</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    $conn->close();


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login/style-login.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
</head>
<body>
    <main>
        <section class="section-titulo section">
            <h1><span class="h1-span-1">Sua plataforma</span><br><span class="h1-span-2">de leilões online</span></h1>
        </section>
        <section class="section-login section">
            <div class="formulario">
                <?php 
                    
                    if (isset($_SESSION['senha-incorreta'])) {
                        ?>
                        <div class="mensagem-erro" id="mensagem-erro">
                            <?=$_SESSION['senha-incorreta']?>
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
                        unset($_SESSION['senha-incorreta']);
                    }

                    if (isset($_SESSION['usuario-nao-encontrado'])) {
                        ?>
                        <div class="mensagem-erro" id="mensagem-erro">
                            <?=$_SESSION['usuario-nao-encontrado']?>
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
                        unset($_SESSION['usuario-nao-encontrado']);
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

                    if (isset($_SESSION['cadastro-sucesso'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['cadastro-sucesso']?>
                        </div>
                            <script>
                                // Oculta a mensagem após 4 segundos
                                setTimeout(function() {
                                    const msg = document.getElementById('mensagem-sucesso');
                                    if (msg) {
                                        msg.style.transition = 'opacity 0.5s ease';
                                        msg.style.opacity = '0';
                                        setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                                    }
                                }, 4000);
                            </script>
                        <?php
                        unset($_SESSION['cadastro-sucesso']);
                    }
                    
                    if (isset($_SESSION['senha-refinida-sucesso'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['senha-refinida-sucesso']?>
                        </div>
                            <script>
                                // Oculta a mensagem após 4 segundos
                                setTimeout(function() {
                                    const msg = document.getElementById('mensagem-sucesso');
                                    if (msg) {
                                        msg.style.transition = 'opacity 0.5s ease';
                                        msg.style.opacity = '0';
                                        setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                                    }
                                }, 4000);
                            </script>
                        <?php
                        unset($_SESSION['senha-refinida-sucesso']);
                    }

                    if (isset($_SESSION['erro-atualizar-senha'])) {
                        ?>
                        <div class="mensagem-erro" id="mensagem-erro">
                            <?=$_SESSION['erro-atualizar-senha']?>
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
                        unset($_SESSION['erro-atualizar-senha']);
                    }
                ?>
                <h2>Bem-vindo</h2>
                <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
                    <div class="inputs input-login">
                        
                        <input type="text" name="email" id="email" placeholder="Email..." class="input-login input">
                        
                        <input type="password" name="senha" id="senha" placeholder="Senha..." class="input-senha input">
                        
                    </div>
                    <a class="esqueceu-senha" href="recuperar-senha.php">Esqueceu a senha?</a>
                    <div class="button-entrar">
                        <button type="submit" class="entrar">Entrar</button>
                    </div>
                    <a class="cadastrar-conta" href="cadastro-usuario-cpf.php">Não tem uma conta? Cadastre-se aqui</a>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
                        
                        
