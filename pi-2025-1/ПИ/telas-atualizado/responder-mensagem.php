<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia']) && (!isset($_SESSION['admin']))) {
        header('Location: login.php');
        exit;
    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new LegalEntity();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $nome_usuario = $_SESSION['nome-fantasia'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if (isset($_GET['id'])) {
        $id_mensagem = $_GET['id'];
        $_SESSION['id-mensagem'] = $id_mensagem;

        $stmt = $conn->prepare("SELECT m.MENSAGEM AS MENSAGEM, u.NOME AS NOME_USUARIO, u.NOME_FANTASIA AS FANTASIA_USUARIO FROM mensagem AS m INNER JOIN usuario AS u ON u.ID = m.ID_USUARIO WHERE m.ID = ?");
        $stmt->bind_param("i", $id_mensagem);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $mensagem = $row['MENSAGEM'];
            $nome = $row['NOME_USUARIO'];
            $nome_fantasia = $row['FANTASIA_USUARIO'];
        }

        if (!empty($nome_fantasia)) {
            $nome = $nome_fantasia;
        } 
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty(trim($_POST['mensagem']))) {
            $_SESSION['mensagem-vazia'] = "<p><i class='material-icons'>error</i> O campo de mensagem não pode ser enviado vazio</p>";
    
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        $mensagem = trim(htmlspecialchars($_POST['mensagem']));
    
        $stmt = $conn->prepare("UPDATE mensagem SET RESPOSTA = ?, VERIFICADO = 1, ID_ADMIN = ? WHERE ID = ?");
        $stmt->bind_param("sii", $mensagem, $id_usuario, $_SESSION['id-mensagem']);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    
        $_SESSION['mensagem-sucesso'] = "<p><i class='material-icons'>check_circle</i> Mensagem respondida com sucesso</p>";
        
        unset($_SESSION['id-mensagem']);

        header('Location: contate-nos-adm.php');
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contate-nos</title>
    <link rel="stylesheet" href="css/contate-nos-adm/--style-contate-nos-adm.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leileão</h1>
            <form action="tela-inicial-adm.php" method="POST" class="barra-busca">
                <select name="categoria-buscar" id="categorias">
                    <option value="" selected disabled>Categorias</option>
                    <option value="Eletrônico">Eletrônicos</option>
                    <option value="Veículo">Veículos</option>
                    <option value="Antiguidade">Antiguidades</option>
                    <option value="Roupa">Roupas</option>
                    <option value="Móvel">Móvel</option>
                    <option value="Outros">Outros</option>
                </select>
                <div>
                    <input style="text-indent: 10px;" type="text" name="buscar-categoria" id="buscar" placeholder="Pesquisar...">
                    <button type="submit"></button>
                </div>
            </form>
            <figure class="perfil-configs">
                <p><?=htmlspecialchars($primeiro_nome)?></p>
                <?php if (is_null($foto_existe)) {?>
                    <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/03/150313105721-pi-day-graphic.jpg?w=1115" alt="">
                <?php } else {                   ?>
                    <img src="imagens/perfis/perfil_<?=$id_usuario?>.jpg" alt="Foto de Perfil">
                <?php }                          ?>
            </figure>
        </div>
    </header>
    <main>
        <nav class="nav-movel">
            <ul>
                <li><a href="tela-inicial-adm.php">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos-adm.php">Sobre nós</a></li>
                <li class="epc"></li>
                <li><a href="logout.php" class="sair">Sair</a></li>

                <div id="modalLogout" class="modal">
                    <div class="modal-content">
                        <p>Tem certeza de que deseja sair?</p>
                        <button id="confirmarSair" class="confirmar-sair">Sim</button>
                        <button id="cancelarSair" class="cancelar-sair">Cancelar</button>
                    </div>
                </div>
                <script>
                    document.querySelector('.sair').addEventListener('click', function(e) {
                    e.preventDefault(); // Impede a navegação imediata
                    document.getElementById('modalLogout').style.display = 'flex';
                    });

                    document.getElementById('cancelarSair').addEventListener('click', function() {
                    document.getElementById('modalLogout').style.display = 'none';
                    });

                    document.getElementById('confirmarSair').addEventListener('click', function() {
                    window.location.href = 'logout.php'; // Redireciona para logout
                    });
                </script>
            </ul>
        </nav>
        <nav class="nav-estatica">
            <ul>
                <li><a>Início</a></li>
                <li><a href="">Categorias</a></li>
                <li><a href="">Produtos</a></li>
                <li><a href="" style="font-size: 13px;">Contrate-nos</a></li>
                <li><a href="">Sobre nós</a></li>
            </ul>
        </nav>
        <section class="main-content">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="entre-em-contato">
                <a class="voltar" href="javascript:history.back()">
                    <img style="margin-left: 20px; margin-top: 10px;" src="css/svg/arrow-left.svg" alt="">
                </a>
                <h2 style="text-align: center; margin-top: -40px; margin-bottom: 30px;">Responder Usuário</h2>
                <div class="descricao-mensagem-enviar">
                    <label style="font-size: 20px; font-style: italic;">~ <?=$nome?></label>
                    <p style="font-size: 16px; margin-top: 10px;"><span>Mensagem: </span><?=$mensagem?></p>
                    <div class="mensagem">
                        <?php 
                            if (isset($_SESSION['mensagem-vazia'])) {
                                ?>
                                <div class="mensagem-erro" id="mensagem-erro" style="margin-top: -10px;">
                                    <?=$_SESSION['mensagem-vazia']?>
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
                                unset($_SESSION['mensagem-vazia']);
                            }

                        ?>
                        <label for="mensagem">Sua resposta</label>
                        <textarea required name="mensagem" id="mensagem"></textarea>
                    </div>
                    <div class="button">
                        <button type="submit" id="enviar-contato">Enviar</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>