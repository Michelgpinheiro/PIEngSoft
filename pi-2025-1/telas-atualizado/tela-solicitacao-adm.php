<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia'])) {
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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de administrador</title>
    <link rel="stylesheet" href="css/tela-solicitacao-adm/-style-tela-solicitacao-adm.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leilão</h1>
            <div class="barra-busca">
                <select name="categorias" id="categorias">
                    <option value="valor0" selected disabled>Categorias</option>
                    <option value="valor1">Eletrônicos</option>
                    <option value="valor2">Veículos</option>
                    <option value="valor3">Antiguidades</option>
                    <option value="valor4">Roupas</option>
                    <option value="valor5">Móvel</option>
                    <option value="valor6">Outros</option>
                </select>
                <form class="form-buscar" style="border-radius: 0px 10px 10px 0px;" action="">
                    <input style="border-radius: 0px; text-indent: 4px;" type="text" name="buscar" id="buscar" placeholder="Pesquisar...">
                    <button type="submit"></button>
                </form>
            </div>
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
                <li><a class="selected-page" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos-adm.php" style="font-size: 13px;">Contate-nos</a></li>
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
            <div class="listagem-usuarios solicitacoes-usuario">
                <h2>Listagem de usuários</h2>
                <div class="adicionar-buscar">
                    <div class="barra-busca busca-user">
                        <form class="form-buscar" action="">
                            <input type="text" name="buscar" id="buscar" placeholder="Buscar usuário...">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
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
                    
                ?>
                <div class="usuario-cards">
                <?php
                
                    $stmt = $conn->prepare (
                        "SELECT u.ID AS ID, u.NOME AS NOME, u.NOME_FANTASIA AS NOME_FANTASIA, u.ID_TP_USU AS TP_USUARIO, u.FOTO AS FOTO, p.ID AS ID_PRODUTO, l.VERIFICADO AS VERIFICADO 
                        FROM usuario u 
                        INNER JOIN produto p ON p.ID_USUARIO = u.ID
                        INNER JOIN leilao l ON l.ID_PRODUTO = p.ID
                        WHERE p.STATUS_PRODUTO = 5;
                        ;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        $user_id = $row['ID'];
                        $nome_usuario_logado = $row['NOME_FANTASIA'];
                        $tipo_usuario = $row['TP_USUARIO'];
                        $username = htmlspecialchars($row['NOME']);
                        $user_photo = $row['FOTO'];
                        $product_id = $row['ID_PRODUTO'];
                        $verificado = $row['VERIFICADO'];
                        $_SESSION['id-produto'] = $product_id;

                        if ($tipo_usuario == 1) {
                            $nome = $username;
                        } else {
                            $nome = $nome_usuario_logado;
                        }

                        if (!$verificado) {

                            echo '
                            
                                <div class="user-card">
                                    <div class="card-start">
                                        <figure class="perfil-configs user-img">
                                            <img src="' . $user_photo . '" alt="">
                                        </figure>
                                        <p class="nome">' . $nome . '</p>
                                        <p class="id">Id: ' . $user_id . '</p>
                                    </div>
                                    <div class="card-end">  
                                        <div style="visibility: hidden;" class="pause-view">
                                            <button class="pause">
                                                <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                            </button>
                                            <button class="view">
                                                <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                            </button>
                                        </div>
                                        <div class="pause-view">
                                            <a href="solicitacao-adm.php?id=' . $product_id . '"class="pause verificar-usuario" style="text-decoration: none; padding-top: 11px;">
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
                    