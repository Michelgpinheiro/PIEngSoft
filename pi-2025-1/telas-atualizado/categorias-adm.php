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
    <title>Categorias</title>
    <link rel="stylesheet" href="css/categorias-adm/style-categorias-adm.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leilão</h1>
            <a class="a-suspenso" href="lista-leilao-suspenso.php">Leilões suspensos</a>
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
                <form action="">
                    <input style="text-indent: 10px;" type="text" name="buscar" id="buscar" placeholder="Pesquisar...">
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
                <li><a class="selected-page">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
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
            <div class="categoria-row">
                <h2>Eletrônicos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Eletrônico' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                            $reducao_pracas = $row['REDUCAO'];
                            $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
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
                                    <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ; height: 35px">Em leilão</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
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
                                                <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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

                
                ?>
            </div>
            <div class="categoria-row">
                <h2>Veículos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Veículo' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                            $reducao_pracas = $row['REDUCAO'];
                            $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
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
                                    <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ; height: 35px">Em leilão</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
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
                                                <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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
                
                ?>
            </div>
            <div class="categoria-row">
                <h2>Antiguidades</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Antiguidade' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                            $reducao_pracas = $row['REDUCAO'];
                            $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
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
                                    <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ; height: 35px">Em leilão</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
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
                                                <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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

                
                ?>
            </div>
            <div class="categoria-row">
                <h2>Roupas</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Roupa' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                            $reducao_pracas = $row['REDUCAO'];
                            $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
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
                                    <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ; height: 35px">Em leilão</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
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
                                                <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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

                
                ?>
            </div>
            <div class="categoria-row">
                <h2>Móvel</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Móvel' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                        $reducao_pracas = $row['REDUCAO'];
                        $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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

                        $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');

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
                                <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                    <img src="css/svg/edit.svg" alt="">
                                </a>
                                <a class="pause-button" href="#">
                                    <img src="css/svg/pause.svg" alt="">
                                </a>
                                <a class="pause-button delete-button" href="#">
                                    <img src="css/svg/garbage.svg" alt="">
                                </a>
                            ';
                        } else {
                            $botao = '
                                <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                ; height: 35px">Em leilão</a>
                                <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                    <img src="css/svg/edit.svg" alt="">
                                </a>
                                <a class="pause-button" href="#">
                                    <img src="css/svg/pause.svg" alt="">
                                </a>
                                <a class="pause-button delete-button" href="#">
                                    <img src="css/svg/garbage.svg" alt="">
                                </a>
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
                                            <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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
                
                ?>
            </div>
            <div class="categoria-row">
                <h2>Outros</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">

                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

                        WHERE (p.STATUS_PRODUTO = 2 OR p.STATUS_PRODUTO = 4) AND p.CATEGORIA = 'Outros' AND l.VERIFICADO = 1;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao" style="margin-bottom: 15px;">
                            <p><i class="material-icons">gavel</i> Não há leilões em andamento no momento nessa categoria</p>
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
                            $reducao_pracas = $row['REDUCAO'];
                            $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
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
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
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
                                    <a class="cat-dar-lan" href="tela-pagamento-adm.php?id='. $id_produto .'">Dar lance</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
                                ';
                            } else {
                                $botao = '
                                    <a class="em-leilao" href="#" onclick="return false" style="background-color:grey; border-color: black; color: black
                                    ; height: 35px">Em leilão</a>
                                    <a style="" class="pause-button edit-button" href="editar-leilao-adm.php?id='. $id_produto .'">
                                        <img src="css/svg/edit.svg" alt="">
                                    </a>
                                    <a class="pause-button" href="#">
                                        <img src="css/svg/pause.svg" alt="">
                                    </a>
                                    <a class="pause-button delete-button" href="#">
                                        <img src="css/svg/garbage.svg" alt="">
                                    </a>
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
                                                <p><span>Valor inicial:</span> R$ '. $desconto .'</p>
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
                
                ?>
            </div>

            <!--
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://images.tcdn.com.br/img/img_prod/1124863/controle_original_ps5_sem_fio_dualsense_sony_starlight_blue_12972_1_9293d13567c3479519bcb59e9bfc673a.jpg" alt="">
                        </figure>
                        <h3>Dual Sense</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$350,00</p>
                                <p><span>Ultimo lance:</span> R$410,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 30/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> 300,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://m.media-amazon.com/images/I/71xZUkl5dyL.jpg" alt="">
                        </figure>
                        <h3>ASUS Zenbook Duo Laptop</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 08/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$18.500,00</p>
                                <p><span>Ultimo lance:</span> R$18.750,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/05/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$16.500,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://imgs.casasbahia.com.br/55067621/1g.jpg?imwidth=1000" alt="">
                        </figure>
                        <h3>Apple Iphone 16 128GB</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 28/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$12.400,00</p>
                                <p><span>Ultimo lance:</span> R$13.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/06/2025</p>
                                <p><span>Fim:</span> 15/06/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$10.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>-->
        </section>
    </main>
</body>
</html>