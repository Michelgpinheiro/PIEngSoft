<?php 

    session_start();

    require_once "connection.php";

    $deu_certo = false;

    if (($_SERVER['REQUEST_METHOD'] === "POST") && (isset($_SESSION['id-suspenso']))) {
        $mensagem_suporte = htmlspecialchars($_POST['mensagem_suporte']);
        $id_usuario = $_SESSION['id-suspenso'];

        $stmt = $conn->prepare("INSERT INTO mensagem (ID_USUARIO, MENSAGEM) VALUES (?, ?)");
        $stmt->bind_param("is", $id_usuario, $mensagem_suporte);

        if ($stmt->execute()) {
            $deu_certo = true;
            unset($_SESSION['id-suspenso']);
        } else {
            die("Houve um erro no envio da mensagem.");
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
</head>
<body>
    <div class="pseudo-body">
        <form method="POST" action="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>" class="suspensao-container">
            <?php if ($deu_certo): ?>
                <h1 style="margin-top: -0px;">Mensagem Enviada</h1>
                <label>Sua mensagem foi enviada com sucesso. Aguarde até que nossa equipe analise-a e dê um retorno.</label>
                <div class="log-msg">
                    <a href="logout.php">Sair</a>
                </div>
            <?php else: ?>
                <h1 style="margin-top: -0px;">Contatar Suporte</h1>
                <label>Envie sua mensagem aqui. Nossa equipe analisa minuciosamente todas as mesagens enviadas com período de retorno estimado de 2 a 3 dias!</label>
                <textarea required name="mensagem_suporte" id="mensagem-suporte"></textarea>
                <div class="log-msg">
                    <a href="logout.php">Sair</a>
                    <button type="submit" class="msg-sup">Enviar</button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>