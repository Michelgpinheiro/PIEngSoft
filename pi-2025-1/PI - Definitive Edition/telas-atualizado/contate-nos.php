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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty(trim($_POST['mensagem']))) {
            $_SESSION['mensagem-vazia'] = "<p><i class='material-icons'>error</i> O campo de mensagem não pode ser enviado vazio</p>";
    
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
        
        $mensagem = trim($_POST['mensagem']);
    
        $stmt = $conn->prepare("INSERT INTO mensagem (ID_USUARIO, MENSAGEM, VERIFICADO, VISTO, MSG_SUSPENSAO) VALUES (?, ?, 0, 0, 0)");
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
                        <?php 
                        
                            $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM mensagem WHERE VERIFICADO = 1");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $stmt->close();
                            if ($row['total'] > 0):
                        ?>
                            <a style="margin-right: 10px; color: #ffd980; text-decoration: none; font-weight: bold; border: 2px solid #ffd980; padding: 8px; border-radius: 10px;" href="mensagem-respondida.php?">Ver Respostas</a>
                        <?php endif; ?>
                        <button type="submit" class="enviar-cadastro" id="enviar-contato">Enviar</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>