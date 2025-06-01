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
        $conn->close();
    
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
                <li><a class="selected-page" style="font-size: 13px;">Mensagens</a></li>
                <!-- <li><a href="sobre-nos-adm.php">Sobre nós</a></li> -->
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
                <h2 style="margin-top: 15px;">Mensagens</h2>
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
                        "SELECT u.ID AS ID, u.NOME AS NOME, u.NOME_FANTASIA AS NOME_FANTASIA, u.ID_TP_USU AS TP_USUARIO, u.FOTO AS FOTO, m.MENSAGEM AS MENSAGEM, m.ID AS ID_MENSAGEM 
                        FROM usuario u 
                        INNER JOIN mensagem as m ON m.ID_USUARIO = u.ID
                        WHERE m.VERIFICADO <> 1 AND u.ID <> ?;
                        
                    ");
                    $stmt->bind_param("i", $id_usuario);
                    $stmt->execute();
                    $result = $stmt->get_result();
                

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

                            if ($tipo_usuario == 1) {
                                if (!empty($nome_usuario_logado)) {
                                    $nome = $nome_usuario_logado;
                                } else {
                                    $nome = $username;
                                }
                            } else {
                                $nome = $username;
                            }
    
                            echo '
                            
                                <div class="user-card" style="display: flex; justify-content: space-between; border-radius: 10px; margin: 10px 0px; padding: 10px 0px;">
                                    <div class="card-start" style="display: flex; justify-content: space-between;">
                                        <figure class="perfil-configs user-img">
                                            <img style="margin-left: 10px;" src="' . $user_photo . '" alt="">
                                        </figure>
                                        <p style="margin-right: 60px; margin-left: -120px; margin-top: 17px; font-size: 16px; font-weight: bold;" class="nome">' . $nome . '</p>
                                        <p style="margin-top: 17px; font-size: 16px; font-weight: bold;" class="id">Id: ' . $user_id . '</p>
                                    </div>
                                    <div class="card-end">  
                                        <div style="visibility: hidden; margin-top: -10px;" class="pause-view">
                                            <button class="pause">
                                                <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                            </button>
                                            <button class="view">
                                                <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                            </button>
                                        </div>
                                        <div class="pause-view">
                                            <a href="responder-mensagem.php?id=' . $id_mensagem . '"class="pause verificar-usuario" style=" display: block; margin-top: -40px; text-align: center; text-decoration: none; border-radius: 10px; padding: 10px 30px; font-size: 16px; font-weight: bold; margin-right: 10px;">
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
        <!-- <section class="main-content">
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="entre-em-contato">
                <h2>Entre em contato com a gente</h2>
                <div class="descricao-mensagem-enviar">
                    <p><span>Descrição:</span> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium at modi, neque facilis saepe tempora! Est rem distinctio minus asperiores ducimus sapiente beatae tempora blanditiis temporibus, mollitia recusandae dolor sunt ipsum alias dolore. Aliquam provident nesciunt omnis non laboriosam debitis saepe assumenda enim velit voluptatum, in porro maxime voluptates cupiditate asperiores molestiae accusantium. Quas sint facere dignissimos impedit eveniet sed, illo voluptates totam reiciendis dolorum natus hic est, odit error omnis unde eum numquam tempore? Minus iste, eum accusantium soluta debitis inventore facere doloribus sapiente rerum consequuntur, perspiciatis repudiandae perferendis quia unde ex quibusdam corrupti. Perferendis officiis maxime id impedit.</p>
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

                            if (isset($_SESSION['mensagem-sucesso'])) {
                                ?>
                                <div class="mensagem-sucesso" id="mensagem-sucesso" style="margin-top: -10px;">
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
                        ?>
                        <label for="mensagem">Envie sua mensagem aqui</label>
                        <textarea name="mensagem" id="mensagem"></textarea>
                    </div>
                    <div class="button">
                        <button type="submit" id="enviar-contato">Enviar</button>
                    </div>
                </div>
            </form>
        </section> -->
    </main>
</body>
</html>