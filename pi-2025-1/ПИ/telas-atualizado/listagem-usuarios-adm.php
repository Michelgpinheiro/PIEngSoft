<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia']) && (!isset($_SESSION['admin']))) {
        header('Location: login.php');
        exit;
    }

    if (isset($_POST['suspen'])) {
        $id_pra_ususpender = $_POST['suspen'];
        $motivo_suspensao_conta = $_POST['motivo_suspensao_conta'] ?? '';

        // 1. Consultar o status atual
        $stmt = $conn->prepare("SELECT ST_USUARIO FROM usuario WHERE ID = ?");
        $stmt->bind_param("i", $id_pra_ususpender);
        $stmt->execute();
        $result = $stmt->get_result();
        $st_usuario = $result->fetch_assoc()['ST_USUARIO'] ?? null;
        $stmt->close();

        if ($st_usuario === null) {
            $_SESSION['erro'] = "Usuário não encontrado.";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        }

        // 2. Definir novo status
        $novo_status = ($st_usuario == 1) ? 0 : 1;

        // 3. Definir motivo se for suspender, ou NULL se for reativar
        $motivo = ($novo_status == 0) ? $motivo_suspensao_conta : null;

        // 4. Executar o update
        $stmt = $conn->prepare("UPDATE usuario SET ST_USUARIO = ?, MOTIVO_SUSPENSAO_CONTA = ? WHERE ID = ?");
        $stmt->bind_param("isi", $novo_status, $motivo, $id_pra_ususpender);

        if ($stmt->execute()) {
            if ($novo_status == 0) {
                $_SESSION['conta-suspensa'] = "<p><i class='material-icons'>check_circle</i> Usuário suspenso com sucesso</p>";
            } else {
                $_SESSION['conta-reativa'] = "<p><i class='material-icons'>check_circle</i> Usuário reativado com sucesso</p>";
            }
        } else {
            $_SESSION['erro-suspender-reativar'] = "<p><i class='material-icons'>error</i> Houve um erro ao reativar/suspender o usuário</p>";
        }

        $stmt->close();

        header("Location: ".$_SERVER['PHP_SELF']);
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
            <h1>Leileão</h1>
            <form style="padding: 0px;" action="tela-inicial-adm.php" method="POST" class="barra-busca">
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
                    <input style="text-indent: 10px; border-radius: 0px;" type="text" name="buscar-categoria" id="buscar" placeholder="Pesquisar...">
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
                <li><a class="selected-page">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos-adm.php" style="font-size: 13px;">Mensagens</a></li>
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

                    if (isset($_SESSION['erro-suspender-reativar'])) {
                        ?>
                        <div class="mensagem-erro" id="mensagem-erro">
                            <?=$_SESSION['erro-suspender-reativar']?>
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
                        unset($_SESSION['erro-suspender-reativar']);
                    }

                    if (isset($_SESSION['conta-suspensa'])) {
                        ?>
                        <div style="margin-top: -20px;" class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['conta-suspensa']?>
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
                        unset($_SESSION['conta-suspensa']);
                    }

                    if (isset($_SESSION['conta-reativa'])) {
                        ?>
                        <div style="margin-top: -20px;" class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['conta-reativa']?>
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
                        unset($_SESSION['conta-reativa']);
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
                        <form style="height: 102%;" class="form-buscar" method="POST" action="listagem-usuarios-adm.php">
                            <input type="text" name="buscar-usuario" id="buscar" placeholder="Buscar usuário...">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="usuario-cards">
                    <?php 

                        $usuario_que_busco = isset($_POST['buscar-usuario']) ? htmlspecialchars($_POST['buscar-usuario']) : '';
                        $mostrar = false;

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
                                $mostrar = true;
                            }
                        } else {       
                            $stmt = $conn->prepare("SELECT ID, ID_TP_USU, NOME_FANTASIA, NOME, FOTO, ST_USUARIO FROM usuario WHERE ID_USU_PAI = ? OR (ID_TP_USU = 1 OR ID_TP_USU = 2) AND ID <> ?");
                            $stmt->bind_param("ii", $id_usuario, $id_usuario);
                            $stmt->execute();
                            $result = $stmt->get_result();
                        }
                        $stmt->close();
                        
                        if ($result->num_rows == 0 && !$mostrar) {
                            echo '
                                
                                <div class="sem-leilao">
                                    <p><i class="material-icons">question_mark</i> Nenhum usuário cadastrado no momento</p>
                                </div>
                                
                                ';
                        } else {

                            while ($row = $result->fetch_assoc()) {
                                $id = $row['ID'];

                                if ($row['ST_USUARIO'] == 1) {
                                    $pause_icon = '
                                        <img src="css/svg/pause.svg" alt="">
                                    ';
                                    $p_suspender = '
                                        <p>Tem certeza de que deseja <b>suspender</b> este usuário?</p>
                                    ';
                                } else {
                                    $pause_icon = '
                                        <img style="margin-right: 10px;" src="css/svg/play-icon.svg" alt="">
                                    ';
                                     $p_suspender = '
                                        <p>Tem certeza de que deseja <b>reativar</b> este usuário?</p>
                                    ';
                                }

                                if ($row['ID_TP_USU'] === 1) {
                                    $nome = htmlspecialchars($row['NOME'] ?? $row['NOME_FANTASIA']);
                                        $icone = "person";
                                    if ($row['ST_USUARIO'] === 1) {

                                        
                                        $pause = '
                                        <button type="button" class="pause" id="btnSuspender_'.$id.'">
                                            '.$pause_icon.'
                                        </button>
    
                                        <!-- Modal de confirmação -->
                                        <div id="modalSuspender_'.$id.'" class="modal" style="
                                            display: none;
                                            position: fixed;
                                            z-index: 999;
                                            left: 0; top: 0;
                                            width: 100%; height: 100%;
                                            background-color: rgba(0,0,0,0.6);
                                            justify-content: center;
                                            align-items: center;
                                        ">
                                            <div class="modal-content" style="
                                                background-color: #BD6C34;
                                                padding: 20px;
                                                border-radius: 10px;
                                                max-width: 400px;
                                                width: 90%;
                                            ">
                                                '.$p_suspender.'
                                                <div class="modal-buttons" style="display: flex; justify-content: center;">
                                                    <button type="button" id="confirmarSuspender_'.$id.'" class="confirmar-sair" style="
                                                        background-color: #BD6C34;
                                                        color: #FFD980;
                                                        border: 2px solid #FFD980;
                                                        padding: 8px 16px;
                                                        cursor: pointer;
                                                        width: 120px;
                                                        font-size: 16px;
                                                    ">Sim</button>
                                                    <button type="button" id="cancelarSuspender_'.$id.'" class="cancelar-sair" style="
                                                        background-color: #FFD980;
                                                        color: #BD6C34;
                                                        border: 2px solid #BD6C34;
                                                        padding: 8px 16px;
                                                        cursor: pointer;
                                                        border: none;
                                                        width: 120px;
                                                        font-size: 16px;
                                                    ">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
    
                                        <!-- Modal para informar o motivo -->
                                        <div id="modalMotivo_'.$id.'" class="modal" style="
                                            display: none;
                                            position: fixed;
                                            z-index: 999;
                                            left: 0; top: 0;
                                            width: 100%; height: 100%;
                                            background-color: rgba(0,0,0,0.6);
                                            justify-content: center;
                                            align-items: center;
                                        ">
                                            <div class="modal-content" style="
                                                background-color: #BD6C34;
                                                padding: 20px;
                                                border-radius: 10px;
                                                max-width: 400px;
                                                width: 90%;
                                            ">
                                                <h3 style="color: #FFD980;">Informe o motivo da suspensão</h3>
                                                <form style="background-color: #BD6C34;" id="formSuspender_'.$id.'" method="POST" action="'.$_SERVER['PHP_SELF'].'">
                                                    <input type="hidden" name="suspen" value="'.$id.'">
                                                    <textarea name="motivo_suspensao_conta" required style="
                                                        width: 100%; 
                                                        padding: 10px;
                                                        height: 100px; 
                                                        border-radius: 10px;
                                                        border: none;
                                                    "></textarea>
                                                    <div class="modal-buttons" style="margin-top: 15px; display: flex; justify-content: center">
                                                        <button type="submit" class="confirmar-sair" style="
                                                            background-color: #BD6C34;
                                                            color: #FFD980;
                                                            border: 2px solid #FFD980;
                                                            padding: 8px 16px;
                                                            font-size: 16px;
                                                            cursor: pointer;
                                                            width: 120px;
                                                        ">Confirmar</button>
                                                        <button type="button" id="cancelarMotivo_'.$id.'" class="cancelar-sair" style="
                                                            background-color: #FFD980;
                                                            color: #BD6C34;
                                                            border: 2px solid #BD6C34;
                                                            padding: 8px 16px;
                                                            cursor: pointer;
                                                            width: 120px;
                                                            font-size: 16px;
                                                            border: none;
                                                        ">Cancelar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
    
                                        <script>
                                            // Abrir primeiro modal
                                            document.getElementById("btnSuspender_'.$id.'").addEventListener("click", function(e) {
                                                e.preventDefault();
                                                document.getElementById("modalSuspender_'.$id.'").style.display = "flex";
                                            });
    
                                            // Cancelar primeiro modal
                                            document.getElementById("cancelarSuspender_'.$id.'").addEventListener("click", function() {
                                                document.getElementById("modalSuspender_'.$id.'").style.display = "none";
                                            });
    
                                            // Confirmar suspensão -> abre modal do motivo
                                            document.getElementById("confirmarSuspender_'.$id.'").addEventListener("click", function() {
                                                document.getElementById("modalSuspender_'.$id.'").style.display = "none";
                                                document.getElementById("modalMotivo_'.$id.'").style.display = "flex";
                                            });
    
                                            // Cancelar modal do motivo
                                            document.getElementById("cancelarMotivo_'.$id.'").addEventListener("click", function() {
                                                document.getElementById("modalMotivo_'.$id.'").style.display = "none";
                                            });
                                        </script>
                                        ';
                                    } else {
                                        $pause = '
                                        <button type="button" class="pause" id="btnSuspender_'.$id.'">
                                            '. $pause_icon .'
                                        </button>

                                        <div id="modalSuspender_'.$id.'" class="modal">
                                            <div style="padding: 15px 20px 0px 20px;" class="modal-content">
                                                '. $p_suspender .'
                                                <div style="display: flex; justify-content: center;" class="modal-buttons">
                                                    <form style="background-color: #BD6C34;" id="formSuspender_'.$id.'" method="POST" action="'. $_SERVER['PHP_SELF'] .'">
                                                        <input type="hidden" name="suspen" value="'.$id.'">
                                                        <button style="height: 40px; margin-top: 0px; width: 100px; background-color: #BD6C34; color: #FFD980; font-size: 16px; border: 2px solid #FFD980;" type="button" id="confirmarSuspender_'.$id.'" class="confirmar-sair">Sim</button>
                                                    </form>
                                                    <button style="height: 40px; background-color: #FFD980; color: #BD6C34; font-size: 16px; border: 2px solid #BD6C34;" id="cancelarSuspender_'.$id.'" class="cancelar-sair">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            // Abrir modal
                                            document.getElementById("btnSuspender_'.$id.'").addEventListener("click", function(e) {
                                                e.preventDefault();
                                                document.getElementById("modalSuspender_'.$id.'").style.display = "flex";
                                            });

                                            // Cancelar modal
                                            document.getElementById("cancelarSuspender_'.$id.'").addEventListener("click", function() {
                                                document.getElementById("modalSuspender_'.$id.'").style.display = "none";
                                            });

                                            // Confirmar suspensão
                                            document.getElementById("confirmarSuspender_'.$id.'").addEventListener("click", function() {
                                                document.getElementById("formSuspender_'.$id.'").submit();
                                            });
                                        </script>
                                    ';
                                    }
                                } else {
                                    $nome = htmlspecialchars($row['NOME'] ?? '<sem nome>');
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
                                    <div style="gap: 0px;" class="card-start">
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
                        }

                    ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>