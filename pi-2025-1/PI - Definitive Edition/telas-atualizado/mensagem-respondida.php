<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-usuario']) && !isset($_SESSION['nome-fantasia'])) {
        header('Location: login.php');
        exit;
    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new PhysicalPerson();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

     if (isset($_SESSION['nome-usuario'])) {
        $nome_usuario = $_SESSION['nome-usuario'];
    } else {
        $nome_usuario = $_SESSION['nome-fantasia'];
    }
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if (isset($_GET['id'])) {
        $id_remover = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM mensagem WHERE ID = ?");
        $stmt->bind_param("i", $id_remover);
        $stmt->execute();
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty(trim($_POST['mensagem']))) {
            $_SESSION['mensagem-vazia'] = "<p><i class='material-icons'>error</i> O campo de mensagem não pode ser enviado vazio</p>";
    
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        $mensagem = trim($_POST['mensagem']);
    
        $stmt = $conn->prepare("INSERT INTO mensagem (ID_USUARIO, MENSAGEM) VALUES (?, ?)");
        $stmt->bind_param("is", $id_usuario ,$mensagem);
        $stmt->execute();
        $stmt->close();
        //$conn->close();
    
        $_SESSION['mensagem-sucesso'] = "<p><i class='material-icons'>check_circle</i> Mensagem enviada com sucesso</p>";
    
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contate-nos</title>
    <link rel="stylesheet" href="css/contate-nos/style-contate-nos.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leileão</h1>
            <form action="tela-inicial.php" method="POST" class="barra-busca">
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
            <figure style="width: 40px; margin-right: -80px;"  class="perfil-configs">
                <p><?=htmlspecialchars($primeiro_nome)?></p>
                <?php if (is_null($foto_existe)) {?>
                    <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/03/150313105721-pi-day-graphic.jpg?w=1115" alt="">
                <?php } else {                   ?>
                    <img src="imagens/perfis/perfil_<?=$id_usuario?>.jpg" alt="Foto de Perfil">
                <?php }                          ?>
            </figure>
            <?php 

                $stmt = $conn->prepare(
                    "SELECT DIAS_DESATIVAR AS DESATIVAR FROM usuario
                    WHERE ID = ? 
                ");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                
                $row = $result->fetch_assoc();
                $dias_desativar = $row['DESATIVAR'];
            
            ?>
            <div style="width: 40px; margin-top: -5px; visibility: <?=($dias_desativar >= 30) ? "visible" : "hidden"?>;" class="settings">
                <?php if ($dias_desativar >= 30):?>
                    <a href="tela-inicial.php?off=<?=$id_usuario?>">
                        <figure>     
                            <img src="css/svg/warn.svg" alt="">
                        </figure>
                    </a>
                <?php endif; ?>
            </div>
            <div id="modalSetting" class="modal">
                <div class="modal-content">
                    <p>Nosso sistema detectou que você não teve nenhum leilão ativo nos últimos 30 dias.<br> Deseja desativar sua conta por isso? Fazendo isso:</p>
                    <nav style="text-align: left; margin: 10px 0px 10px 100px; line-height: 1.5; color: #FFD980; font-weight: bold; text-shadow: 0px 0px 2px black;">
                        <ul>
                            <li>A conta continua existindo no banco de dados.</li>
                            <li>Seus dados serão mantidos (histórico, transações, etc).</li>
                            <li>Você não conseguirá mais acessar ou usar funcionalidades.</li>
                            <li>É reversível — você pode reativar a conta depois.</li>
                        </ul>
                    </nav>
                    <button id="confirmarSairSetting" class="confirmar-sair">Sim</button>
                    <button id="cancelarSairSetting" class="cancelar-sair">Cancelar</button>
                </div>
            </div>
            <script>
                document.querySelector('.settings').addEventListener('click', function(e) {
                e.preventDefault(); // Impede a navegação imediata
                document.getElementById('modalSetting').style.display = 'flex';
                });

                document.getElementById('cancelarSairSetting').addEventListener('click', function() {
                document.getElementById('modalSetting').style.display = 'none';
                });

                document.getElementById('confirmarSairSetting').addEventListener('click', function() {
                window.location.href = 'tela-inicial.php?off=<?=$id_usuario?>'; // Redireciona para logout
                });
            </script>
        </div>
    </header>
    <main>
        <nav class="nav-movel">
            <ul>
                <li><a href="tela-inicial.php">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="tela-produtos.php">Produtos</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos.php">Sobre nós</a></li>
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
            <div style="margin: auto; margin-top: 20px; width: 800px; border-radius: 10px;" class="listagem-usuarios solicitacoes-usuario">
                <a class="voltar" href="contate-nos.php">
                    <img style="margin-left: 20px; margin-top: 7px;" src="css/svg/arrow-left.svg" alt="">
                </a>
                <h2 style="margin-top: -45px;">Mensagens</h2>
                <?php 
            
                    if (isset($_SESSION['solicitacao-aprovada'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['solicitacao-aprovada']?>
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
                        unset($_SESSION['solicitacao-aprovada']);
                    }

                    if (isset($_SESSION['mensagem-sucesso'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['mensagem-sucesso']?>
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
                        unset($_SESSION['mensagem-sucesso']);
                    }

                    if (isset($_SESSION['solicitacao-recusa'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['solicitacao-recusa']?>
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
                        unset($_SESSION['solicitacao-recusa']);
                    }
                    
                ?>
                <div class="usuario-cards">
                <?php
                
                    $stmt = $conn->prepare (
                        "SELECT u.ID AS ID, u.NOME AS NOME, u.NOME_FANTASIA AS NOME_FANTASIA, u.ID_TP_USU AS TP_USUARIO, u.FOTO AS FOTO, m.MENSAGEM AS MENSAGEM, m.ID AS ID_MENSAGEM, m.ID_ADMIN AS ID_ADMIN, m.VISTO AS VISTO 
                        FROM usuario u 
                        INNER JOIN mensagem as m ON m.ID_USUARIO = u.ID
                        WHERE m.VERIFICADO = 1 AND u.ID = ?;
                        
                    ");
                    $stmt->bind_param("i", $id_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows == 0) {
                        echo '
                            
                            <div class="sem-leilao">
                                <p><i class="material-icons">question_mark</i> Nenhuma mensagem no momento</p>
                            </div>
                            
                        ';
                    } else {
                        while ($row = $result->fetch_assoc()) {
                            $user_id = $row['ID'];
                            $nome_usuario_logado = $row['NOME_FANTASIA'];
                            $tipo_usuario = $row['TP_USUARIO'];
                            $username = htmlspecialchars($row['NOME']);
                            $user_photo = $row['FOTO'];
                            $id_mensagem = $row['ID_MENSAGEM'];
                            $id_admin = $row['ID_ADMIN'];
                            $visto = $row['VISTO'];

                            $stmt_admin = $conn->prepare("SELECT NOME, FOTO FROM usuario WHERE ID = ?");
                            $stmt_admin->bind_param("i", $id_admin);
                            $stmt_admin->execute();
                            $result_admin = $stmt_admin->get_result();
                            $stmt_admin->close();

                            if ($row_admin = $result_admin->fetch_assoc()) {
                                $nome_admin = $row_admin['NOME'];
                                $foto_admin = $row_admin['FOTO'];
                            }

                            if ($tipo_usuario == 1) {
                                $nome = $username ?? $nome_usuario_logado;
                            } else {
                                $nome = $username;
                            }

                            if ($visto) {

                                $lixo = '
                                
                                    <div style="width: 10px; margin-left: 250px;" class="pause-view">
                                            <a href="mensagem-respondida.php?id=' . $id_mensagem . '"class="pause verificar-usuario" style="    display: block;
                                                margin-top: 8px;
                                                text-align: center;
                                                text-decoration: none;
                                                border-radius: 10px;
                                                padding: 0px 29px;
                                                font-size: 16px;
                                                font-weight: bold;
                                                margin-right: -10px;
                                                height: 38px;">
                                                <img style="margin-top: -6px; margin-left: -12px;" src="css/svg/garbage-white.svg" alt="lixo">
                                            </a>
                                        </div>
                                
                                ';
                            } else {
                                $lixo = '';
                            }
    
                            echo '
                            
                                <div class="user-card" style="display: flex; justify-content: space-between; border-radius: 10px; margin: 10px 0px; padding: 10px 0px; height: 75px;">
                                    <div class="card-start" style="display: flex; justify-content: space-between;">
                                        <figure class="perfil-configs user-img">
                                            <img style="margin-left: 10px;" src="' . $foto_admin . '" alt="">
                                        </figure>
                                        <p style="margin-right: 60px; margin-left: -120px; margin-top: 19px; font-size: 17px; font-weight: bold;" class="nome">' . $nome_admin . '</p>
                                    </div>
                                    '. $lixo .'
                                    
                                    <div class="card-end">
                                        <div style="visibility: hidden; margin-top: -10px;" class="pause-view">
                                            <button class="pause">
                                                <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                            </button>
                                            <button class="view">
                                                <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                            </button>
                                        </div>
                                        <div style="margin-right: 0px;"  class="pause-view">
                                            <a href="ver-mensagem-respondida.php?id=' . $id_mensagem . '"class="pause verificar-usuario" style=" display: block; margin-top: -38px; text-align: center; text-decoration: none; border-radius: 10px; padding: 10px 30px; font-size: 16px; font-weight: bold; margin-right: 15px;">
                                                Verificar
                                            </a>
                                        </div>
                                    </div>
                                </div>
    
                            ';
                        }
                    }
                
                
                ?> 
                </div>
            </div>
        </section>
    </main>
</body>
</html>