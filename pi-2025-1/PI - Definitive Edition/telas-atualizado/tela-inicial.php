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

    if (isset($_GET['onaccount'])) {
        $id_reativar = $_GET['onaccount'];

        $stmt = $conn->prepare("UPDATE usuario SET ST_USUARIO = 1, DESAT_VOLUNTARIO = NULL WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();

        $_SESSION['conta-reativada'] = "<p><i class='material-icons'>check_circle</i> Conta reativada com sucesso</p>";

        header('Location: '. $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_GET['off'])) {
        $id_desativar = $_GET['off'];

        $stmt = $conn->prepare("UPDATE usuario SET ST_USUARIO = 0, DESAT_VOLUNTARIO = 1 WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_SESSION['nome-usuario'])) {
        $nome_usuario = $_SESSION['nome-usuario'];
    } else {
        $nome_usuario = $_SESSION['nome-fantasia'];
    }

    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if (!empty($_POST['categoria-buscar']) || !empty($_POST['buscar-categoria'])) {
        $_SESSION['categoria-buscar'] = htmlspecialchars($_POST['categoria-buscar']);
        $_SESSION['produto-buscar'] = htmlspecialchars($_POST['buscar-categoria']);

        header('Location: tela-inicial.php');
        exit;
    }

    $stmt = $conn->prepare(
        "SELECT l.ID, p.STATUS_PRODUTO, u.ID, u.DIAS_DESATIVAR AS DESATIVAR FROM leilao AS l 
         INNER JOIN usuario AS u ON l.ID_USUARIO = u.ID
         INNER JOIN produto AS p ON p.ID_USUARIO = u.ID
        WHERE u.ID = ? AND (p.STATUS_PRODUTO = 4 OR p.STATUS_PRODUTO = 2)
    ");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        if ($row = $result->fetch_assoc()) {
            $dias_desativar = $row['DESATIVAR'];
        }
        
        $stmt = $conn->prepare("UPDATE usuario SET DIAS_DESATIVAR = 0, DATA_SEM_LEILAO = NULL WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
    } else {

        $stmt = $conn->prepare("SELECT DATA_SEM_LEILAO, DIAS_DESATIVAR FROM usuario WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $dias_desativar = $row['DIAS_DESATIVAR'];

        $data_atual = new DateTime();
        $data_str = $data_atual->format('Y-m-d');

        if (is_null($row['DATA_SEM_LEILAO'])) {

            $stmt = $conn->prepare("UPDATE usuario SET DATA_SEM_LEILAO = ?, DIAS_DESATIVAR = 0 WHERE ID = ?");
            $stmt->bind_param("si", $data_str, $id_usuario);
            $stmt->execute();
        } else {

            $data_sem_leilao = new DateTime($row['DATA_SEM_LEILAO']);
            $intervalo = $data_sem_leilao->diff($data_atual);
            
            if ($intervalo->days >= 1) {
                // Já passou pelo menos 1 dia
                $stmt = $conn->prepare("UPDATE usuario SET DIAS_DESATIVAR = (DIAS_DESATIVAR + 1) WHERE ID = ?");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();

                // Atualiza a DATA_SEM_LEILAO para hoje, para evitar múltiplos incrementos no mesmo dia
                $stmt = $conn->prepare("UPDATE usuario SET DATA_SEM_LEILAO = ? WHERE ID = ?");
                $stmt->bind_param("si", $data_str, $id_usuario);
                $stmt->execute();
            }
        }
    }

    $stmt->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/tela-inicial/style-tela-inicial.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <?php 
        
        $stmt = $conn->prepare("SELECT ST_USUARIO, DESAT_VOLUNTARIO, MOTIVO_SUSPENSAO_CONTA FROM usuario WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $st_usuario = $row['ST_USUARIO'] ?? NULL;
        $motivo_suspensao_conta = $row['MOTIVO_SUSPENSAO_CONTA'] ?? NULL;
        $desativou_porque_quis = $row['DESAT_VOLUNTARIO'] ?? NULL;

        if ($st_usuario === 0) {
            if ($desativou_porque_quis !== NULL) {

                $_SESSION['id-suspenso'] = $id_usuario;
                ?>
                    <div class="pseudo-body">
                        <div class="suspensao-container">
                            <h1>Conta Desativada Voluntariamente</h1>
                            <label>Sua conta foi desativa por você devido a ausência de leilões ativos na sua conta. <br> Caso queira reativá-la, clique no botão "Reativar conta" logo abaixo.</label>
                            <div class="log-msg">
                                <a href="logout.php">Sair</a>
                                <a class="msg-sup" href="tela-inicial.php?onaccount=<?=$id_usuario?>">Reativar conta</a>
                            </div>
                        </div>
                    </div>
                <?php
                exit;
            } else {

                $_SESSION['id-suspenso'] = $id_usuario;
                ?>
                    <div class="pseudo-body">
                        <div class="suspensao-container">
                            <h1>Conta Suspensa</h1>
                            <label>Sua conta foi suspendida devido ao seguinte motivo apurado pelos administradores do nosso sistema:</label>
                            <p style="width: 570px; overflow-x: auto;"><?=htmlspecialchars($motivo_suspensao_conta)?></p>
                            <div class="log-msg">
                                <a href="logout.php">Sair</a>
                                <a class="msg-sup" href="mensagem-suporte.php">Contatar suporte</a>
                            </div>
                        </div>
                    </div>
                <?php
                exit;
            }
        }
        
    ?>
    <header>
        <div class="header-container">
            <h1>Leileão</h1>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="barra-busca">
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
            <figure style="width: 40px; margin-right: -80px;" class="perfil-configs">
                <p><?=htmlspecialchars($primeiro_nome)?></p>
                <?php if (is_null($foto_existe)) {?>
                    <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/03/150313105721-pi-day-graphic.jpg?w=1115" alt="">
                <?php } else {                   ?>
                    <img src="imagens/perfis/perfil_<?=$id_usuario?>.jpg" alt="Foto de Perfil">
                <?php }                          ?>
            </figure>
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
                <li><a class="selected-page">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="tela-produtos.php">Produtos</a></li>
                <li><a href="contate-nos.php" style="font-size: 13px;">Contate-nos</a></li>
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
        <nav class="nav-estatica" style="height: auto;">
            <ul>
                <li><a>Início</a></li>
                <li><a href="">Categorias</a></li>
                <li><a href="">Produtos</a></li>
                <li><a href="" style="font-size: 13px;">Contrate-nos</a></li>
                <li><a href="">Sobre nós</a></li>
            </ul>
        </nav>
        <section class="main-content">
            <?php 
            
                if (isset($_SESSION['lance-sucesso'])) {
                    ?>
                    <div class="mensagem-sucesso" id="mensagem-sucesso">
                        <?=$_SESSION['lance-sucesso']?>
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
                    unset($_SESSION['lance-sucesso']);
                }

                if (isset($_SESSION['conta-reativada'])) {
                    ?>
                    <div class="mensagem-sucesso" id="mensagem-sucesso">
                        <?=$_SESSION['conta-reativada']?>
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
                    unset($_SESSION['conta-reativada']);
                }
            
            ?>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 

                    $categoria = $_SESSION['categoria-buscar'] ?? '';
                    $produto = $_SESSION['produto-buscar'] ?? '';
                    $produto = trim($produto); // Remove espaços em branco no input

                    $status = '';

                    // Adiciona os % só se o produto não estiver vazio
                    $produto_like = !empty($produto) ? '%' . $produto . '%' : '';
                
                    if (!empty($categoria) && !empty($produto)) {
                        // Busca por categoria e produto (título)
                        $stmt = $conn->prepare(
                            "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER

                            FROM leilao AS l
                            INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                            INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID
                            WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) 
                            AND p.CATEGORIA = ? 
                            AND l.TITULO LIKE ? 
                            AND l.VERIFICADO = 1;"
                        );
                        $stmt->bind_param("ss", $categoria, $produto_like);
                        $status = 1;

                    } elseif (!empty($categoria)) {
                        // Busca apenas pela categoria
                        $stmt = $conn->prepare(
                            "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER

                            FROM leilao AS l
                            INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                            INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID
                            WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) 
                            AND p.CATEGORIA = ? 
                            AND l.VERIFICADO = 1;"
                        );
                        $stmt->bind_param("s", $categoria);
                        $status = 2;

                    } elseif (!empty($produto)) {
                        // Busca apenas pelo título
                        $stmt = $conn->prepare(
                            "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER

                            FROM leilao AS l
                            INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                            INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID
                            WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) 
                            AND l.TITULO LIKE ? 
                            AND l.VERIFICADO = 1;"
                        );
                        $stmt->bind_param("s", $produto_like);
                        $status = 3;

                    } else {
                        // Busca geral (se desejar)
                        $stmt = $conn->prepare(
                            "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER

                            FROM leilao AS l
                            INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                            INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID
                            WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) 
                            AND l.VERIFICADO = 1;"
                        );
                        // Sem bind_param nesse caso
                    }

                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0 && empty($status)) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento</p>
                        </div>

                        ';
                    } else if ($result->num_rows === 0 && $status === 1) {
                        $produto = str_replace('%', '', $produto);
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Nenhum leilão de "'. $produto .'" da categoria "'. $categoria .'" encontrado</p>
                        </div>

                        ';
                    } else if ($result->num_rows === 0 && $status === 2) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Nenhum leilão da categoria "'. $categoria .'" encontrado</p>
                        </div>

                        ';
                    } else if ($result->num_rows === 0 && $status === 3) {
                         $produto = str_replace('%', '', $produto);
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Nenhum leilão de "'. $produto .'" encontrado</p>
                        </div>

                        ';
                    } else {
                        while ($row = $result->fetch_array()) {
                            $id_produto = $row['ID_PRODUTO'];
                            $id_user = $row['ID_USER'];
                            $id_leilao = $row['ID_LEILAO'];
                            $titulo = htmlspecialchars($row['TITULO']);
                            $data_inicio = $row['DATA_INICIO'];
                            $data_final = $row['DATA_FINAL'];
                            $diferenca_dias = $row['DIFERENCA_PRACAS'];
                            $numero_pracas = $row['PRACAS'];
                            $reducao_pracas = floatval($row['REDUCAO']);
                            $lance_inicial = floatval($row['LANCE_INICIAL']);
                            $valor_incremento = number_format($row['INCREMENTO'],2 ,',', '.');
                            $foto = $row['FOTO'];
                            $descricao = htmlspecialchars($row['DESCRICAO']);
                            $nome_leiloeiro = htmlspecialchars($row['NOME_LEILOEIRO']);
                            $localidade = htmlspecialchars($row['LOCALIDADE']);
                            $status_produto = $row['STATUS_PRODUTO'];
                            $ultimo_lance = '-';
    
                            $data_inicio_1a_praca = new DateTime($data_inicio);
                            $data_fim_1a_praca = new DateTime($data_final);
    
                            $diferenca = $data_inicio_1a_praca->diff($data_fim_1a_praca);
    
                            // Soma os dias ao fim da 1ª praça
                            $data_inicio_2a_praca = clone $data_fim_1a_praca;
                            $data_inicio_2a_praca->modify("+$diferenca_dias days");
    
                            $data_fim_2a_praca = clone $data_inicio_2a_praca;
                            $data_fim_2a_praca->modify("+$diferenca->days days");
    
                            $desconto = $lance_inicial - ($lance_inicial * ($reducao_pracas/100));

                            $lance_inicial = number_format($lance_inicial, 2 ,',', '.');

                            if ($status_produto == 4) {
                                $stmt_select = $conn->prepare(
                                    "SELECT VALOR FROM lancamento
                                     WHERE ID_PRODUTO = ? AND ID_LEILAO = ?; 
                                ");
                                $stmt_select->bind_param("ii", $id_produto, $id_leilao);
                                $stmt_select->execute();
                                $result_select = $stmt_select->get_result();
                                $stmt_select->close();
    
                                while ($row_select = $result_select->fetch_assoc()) {
                                    $ultimo_lance = number_format($row_select['VALOR'], 2, ',', '.');
                                }
                            }
    
                            if ($id_user !== $id_usuario) {
                                $botao = '
                                    <a href="tela-pagamento.php?id='. $id_produto .'">Dar lance</a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ;">Em leilão</a>
                                ';
                            }
                            
                            if ($numero_pracas == 2) {
                                echo '
                                
                                <div class="card">
                                    <div class="inner-card">
                                        <figure>
                                            <img src="' . $foto . '" alt="">
                                        </figure>
                                        <h3>'. $titulo .'</h3>
                                        <div class="card-informations-1">
                                            <div class="card-info-1">
                                                <h4>1ª Praça</h4>
                                                <p><span>Início:</span> '.$data_inicio_1a_praca->format('d/m/Y').'</p>
                                                <p><span>Fim:</span> '.$data_fim_1a_praca->format('d/m/Y').'</p>
                                            </div>
                                            <div class="card-info-2">
                                                <p class="inicial-lance-padding-top">.</p>
                                                <p><span>Valor inicial:</span> R$ '.$lance_inicial.'</p>
                                                <p><span>Ultimo lance:</span> R$ '. $ultimo_lance .' </p>
                                            </div>
                                        </div>
                                        <div class="card-informations-row"></div>
                                        <div class="card-informations-2">
                                            <div class="card-info-1">
                                                <h4>2ª Praça</h4>
                                                <p><span>Início:</span> '. $data_inicio_2a_praca->format('d/m/Y') .'</p>
                                                <p><span>Fim:</span> '. $data_fim_2a_praca->format('d/m/Y') .'</p>
                                            </div>
                                            <div class="card-info-2">
                                                <p class="inicial-lance-padding-top">.</p>
                                                <p><span>Valor inicial:</span> R$ '. number_format($desconto, 2 , ',', '.') .'</p>
                                                <p><span>Ultimo lance:</span> R$ - </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dar-lance"> '. $botao .' </div>
                                </div>
                            
                                
                                ';
                            } else {
                                    
                                echo '
                                
                                <div class="card">
                                    <div class="inner-card">
                                        <figure>
                                            <img src="'.$foto.'" alt="">
                                        </figure>
                                        <h3>'.$titulo.'</h3>
                                        <div class="card-informations-1">
                                            <div class="card-info-1">
                                                <h4>1ª Praça</h4>
                                                <p><span>Início:</span> '. $data_inicio_1a_praca->format('d/m/Y') .'</p>
                                                <p><span>Fim:</span> '. $data_fim_1a_praca->format('d/m/Y') .'</p>
                                            </div>
                                            <div class="card-info-2">
                                                <p class="inicial-lance-padding-top">.</p>
                                                <p><span>Valor inicial:</span> R$ '. $lance_inicial .'</p>
                                                <p><span>Ultimo lance:</span> R$ '. $ultimo_lance .'</p>
                                            </div>
                                        </div>
                                        <div class="card-informations-row"></div>
                                    </div>
                                    <div class="dar-lance">
                                        <div class="dar-lance"> '. $botao .' </div>
                                    </div>
                                </div>
                            
                                
                                ';
    
                            }
                        }
                    }
                    unset($_SESSION['produto-buscar'], $_SESSION['categoria-buscar']);
                ?>
            </div>
        </section>
    </main>
</body>
</html>
                