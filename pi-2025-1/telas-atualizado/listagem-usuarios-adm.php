<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia'])) {
        header('Location: login.php');
        exit;
    }

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
    <title>Listagem de usuários</title>
    <link rel="stylesheet" href="css/listagem-usuarios-adm/style-listagem-usuarios-adm.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
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
                <form class="form-listagem" style="border-radius: 0px 10px 10px 0px;" action="">
                    <input style="border-radius: 0px; text-indent: 3px;" type="text" name="buscar" id="buscar" placeholder="Pesquisar...">
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
                <li><a class="selected-page">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
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
            <div class="listagem-usuarios">
                <h2>Listagem de usuários</h2>
                <?php 
                
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

                ?>
                <div class="adicionar-buscar">
                    <div class="adicionar-usuario">
                        <a href="cadastro-usuario-juridico-adm.php">
                            <figure>
                                <img src="css/svg/add-listagem.svg" alt="">
                                <p>Adicionar</p>
                            </figure>
                        </a>
                    </div>
                    <div class="barra-busca busca-user">
                        <form class="form-buscar" method="POST" action="listagem-usuarios-adm.php">
                            <input type="text" name="buscar-usuario" id="buscar" placeholder="Buscar usuário...">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="usuario-cards">
                    <?php 

                        $usuario_que_busco = isset($_POST['buscar-usuario']) ? htmlspecialchars($_POST['buscar-usuario']) : '';

                        if (!empty($usuario_que_busco)) {
                            $stmt = $conn->prepare("SELECT * FROM usuario WHERE NOME LIKE ? OR NOME_FANTASIA LIKE ?");
                            $like = "%$usuario_que_busco%";
                            $stmt->bind_param("ss", $like, $like);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows == 0) {
                                echo '
                                
                                <div class="sem-leilao">
                                    <p><i class="material-icons">question_mark</i> Nenhum usuário com nome "'. $usuario_que_busco .'" encontrado</p>
                                </div>
                                
                                ';
                            }
                        } else {       
                            $stmt = $conn->prepare("SELECT ID, ID_TP_USU, NOME_FANTASIA, NOME, FOTO FROM usuario WHERE ID_USU_PAI = ? OR (ID_TP_USU = 1 OR ID_TP_USU = 2) AND ID <> ?");
                            $stmt->bind_param("ii", $id_usuario, $id_usuario);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        }
                        $stmt->close();

                        while ($row = $result->fetch_assoc()) {
                            $id = $row['ID'];
                            if ($row['ID_TP_USU'] === 1) {
                                $nome = htmlspecialchars($row['NOME'] ?? '<sem nome>');
                                $icone = "person";
                                $pause = '
                                     <button class="pause">
                                        <img src="css/svg/pause.svg" alt="">
                                    </button>
                                ';
                            } else {
                                $nome = htmlspecialchars($row['NOME_FANTASIA'] ?? '<sem nome>');
                                $icone = "manage_accounts";
                                $pause = '
                                    <button class="pause" style="visibility: hidden;">
                                        <img src="css/svg/pause.svg" alt="">
                                    </button>
                                ';
                            }

                            if (isset($row['FOTO'])) {
                                $foto = $row['FOTO'];    
                            } else {
                                $foto = "css/svg/user-icon.svg";
                            }

                            
                            echo '
                            <div class="user-card">
                                <div class="card-start">
                                    <figure class="perfil-configs user-img">
                                        <img src="' . $foto . '" alt="">
                                    </figure>
                                    <p class="nome" style="width: 280px; display: flex; align-items: left;"><i class="material-icons">'. $icone .'</i>' . $nome  . '</p>
                                    <p class="id" style="width: 40px;">Id: ' . $id . '</p>
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
                                        '. $pause .'
                                        <a href="historico-usuario.php?id='. $id .'" class="view">
                                            <img src="css/svg/visibility.svg" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>';
                        }

                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>