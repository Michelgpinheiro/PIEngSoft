<?php 

    session_start();

    require_once "connection.php";

    $deu_certo = false;
    $ver_mensagem = false;
    $tem_resposta = false;

    if ((isset($_POST['ver-mensagem'])) && (isset($_SESSION['id-suspenso']))) {
        $id_suspenso = $_SESSION['id-suspenso'];

        $stmt = $conn->prepare("SELECT RESPOSTA FROM mensagem WHERE ID_USUARIO = ? AND MSG_SUSPENSAO = 1");
        $stmt->bind_param("i", $id_suspenso);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $ver_mensagem = true;
            if ($row = $result->fetch_assoc()) {
                $resposta = $row['RESPOSTA'];
            }
        } else {
            die("Houve um erro ao acessar a última mensagem enviado por um moderador respondendo você.");
        }
    } 

    if ((isset($_POST['enviar-mensagem'])) && (isset($_SESSION['id-suspenso']))) {
        if ((!empty($_POST['mensagem_suporte']))) {
            $mensagem_suporte = htmlspecialchars($_POST['mensagem_suporte']);
            $id_usuario = $_SESSION['id-suspenso'];

            $stmt = $conn->prepare("SELECT * FROM mensagem WHERE MSG_SUSPENSAO = 1 AND ID_USUARIO = ?");
            $stmt->bind_param("i", $id_usuario);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if ($result->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO mensagem (ID_USUARIO, MENSAGEM, MSG_SUSPENSAO, VERIFICADO, VISTO) VALUES (?, ?, 1, 0, 0)");
                $stmt->bind_param("is", $id_usuario, $mensagem_suporte);
        
                if ($stmt->execute()) {
                    $deu_certo = true;
                    unset($_SESSION['id-suspenso']);
                } else {
                    $stmt->close();
                    die("Houve um erro no envio da mensagem.");
                }

                $stmt->close();
            } else {
                $stmt = $conn->prepare("UPDATE mensagem SET MENSAGEM = ?, VERIFICADO = 0, VISTO = 0 WHERE ID_USUARIO = ? AND MSG_SUSPENSAO = 1");
                $stmt->bind_param("si", $mensagem_suporte, $id_usuario);
                
                if ($stmt->execute()) {
                    $deu_certo = true;
                    unset($_SESSION['id-suspenso']);
                } else {
                    $stmt->close();
                    die("Houve um erro no envio da mensagem.");
                }

                $stmt->close();
            }
        } else {
            $_SESSION['mensagem-vazia'] = "<k style='display: flex; align-items: center; gap: 10px; font-family: Arial, Helvetica, Sans-serif;'><i class='material-icons'>warning</i> Você não pode enviar uma mensagem vazia</k>";

            header('Location: '. $_SERVER['PHP_SELF']);
            exit;
        }
    } 

    $stmt = $conn->prepare("SELECT RESPOSTA FROM mensagem WHERE MSG_SUSPENSAO = 1 AND ID_USUARIO = ?");
    $stmt->bind_param("i", $_SESSION['id-suspenso']);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $stmt->close();
        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                $tem_resposta = ($row['RESPOSTA'] == NULL) ? 0 : 1;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatar Suporte</title>
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <div class="pseudo-body">
        <form method="POST" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" class="suspensao-container">
            <?php 
                if (isset($_SESSION['mensagem-vazia'])) {
                    ?>
                    <div class="mensagem-sem-foto" id="mensagem-sem-foto" style="margin-top: 20px;">
                        <?=$_SESSION['mensagem-vazia']?>
                    </div>
                        <script>
                            // Oculta a mensagem após 4 segundos
                            setTimeout(function() {
                                const msg = document.getElementById('mensagem-sem-foto');
                                if (msg) {
                                    msg.style.transition = 'opacity 0.5s ease';
                                    msg.style.opacity = '0';
                                    setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                                }
                            }, 4000);
                        </script>
                    <?php
                    unset($_SESSION['mensagem-vazia']);
                }
            ?>
            <?php if ($deu_certo): ?>
                <h1 style="margin-top: -0px;">Mensagem Enviada</h1>
                <label>Sua mensagem foi enviada com sucesso. Aguarde até que nossa equipe analise-a e dê um retorno.</label>
                <div class="log-msg">
                    <a href="logout.php">Sair</a>
                </div>
            <?php elseif ($ver_mensagem): ?>
                <h1 style="margin-top: -0px;">Última mensagem do suporte</h1>
                <label>Esta foi a última resposta que nossa equipe respondeu a você</label>
                <p style="width: 570px; overflow-x: auto;" ><?=$resposta?></p>
                <div class="log-msg">
                    <a href="javascript:history.back()">Voltar</a>
                    <a class="msg-sup" href="mensagem-suporte.php">Contatar suporte</a>
                </div>
            <?php else: ?>
                <h1 style="margin-top: -0px;">Contatar Suporte</h1>
                <label>Envie sua mensagem aqui. Nossa equipe analisa minuciosamente todas as mesagens enviadas com período de retorno estimado de 2 a 3 dias!</label>
                <textarea name="mensagem_suporte" id="mensagem-suporte"></textarea>
                <div class="log-msg">
                    <?php if ($tem_resposta): ?>
                        <button name="ver-mensagem" style="background-color: #8A3E2C; color: #FFD980;" type="submit" class="msg-sup">Ver última mensagem do suporte</button>
                    <?php endif; ?>
                    <a style="background-color: #8A3E2C; color: #FFD980;" href="tela-inicial.php">Voltar</a>
                    <button name="enviar-mensagem" type="submit" class="msg-sup">Enviar</button>
                </div>
            <?php endif;?>
        </form>
    </div>
</body>
</html>