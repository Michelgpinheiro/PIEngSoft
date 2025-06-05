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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - administrador</title>
    <link rel="stylesheet" href="css/tela-inicial-adm/-style-tela-inicial-adm.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leileão</h1>
            <a style="padding: 0px 20px; letter-spacing: 1px;" class="a-suspenso" href="javascript:history.back()">Voltar</a> 
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
                <?php } else {                    ?>
                    <img src="imagens/perfis/perfil_<?=$id_usuario?>.jpg" alt="Foto de Perfil">
                <?php }                           ?>
            </figure>
        </div>
    </header>
    <main>
        <nav class="nav-movel" style="height: 100vh; box-shadow: 10px 0px 2px rgb(238, 238, 238);">
            <ul>
                <li><a class="selected-page">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos-adm.php" style="font-size: 13px;">Mensagens</a></li>
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
            <?php 
            
                if (isset($_SESSION['leilao-editado'])) {
                    ?>
                    <div class="mensagem-sucesso" id="mensagem-sucesso">
                        <?=$_SESSION['leilao-editado']?>
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
                    unset($_SESSION['leilao-editado']);
                }

                if (isset($_SESSION['leilao-suspenso'])) {
                    ?>
                    <div class="mensagem-sucesso" id="mensagem-sucesso">
                        <?=$_SESSION['leilao-suspenso']?>
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
                    unset($_SESSION['leilao-suspenso']);
                }

            
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
                
                if (isset($_SESSION['leilao-excluido'])) {
                    ?>
                    <div class="mensagem-sucesso" id="mensagem-sucesso">
                        <?=$_SESSION['leilao-excluido']?>
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
                    unset($_SESSION['leilao-excluido']);
                }
            ?>
           

        <div class="cards-section-1" style="flex-wrap: wrap; gap: 10px;">
                
                <?php 
                
                    $stmt = $conn->prepare(
                        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, p.FOTO AS FOTO, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.ID AS ID_LEILAO, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, p.STATUS_PRODUTO AS STATUS_PRODUTO, u.ID AS ID_USER FROM leilao AS l

                        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
                        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID
                        -- INNER JOIN lancamento AS la ON la.ID_PRODUTO = p.ID
                        -- la.VALOR AS ULTIMO_LANCE ,

                        WHERE p.STATUS_PRODUTO = 6 AND u.ID <> $id_usuario;
                    ");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();

                    if ($result->num_rows === 0) {
                        echo '
                        <div class="sem-leilao">
                            <p><i class="material-icons">gavel</i> Não há leilões suspensos no momento</p>
                        </div>

                        ';
                    } else {
                        while ($row = $result->fetch_array()) {
                            $id_produto = $row['ID_PRODUTO'];
                            $id_user = $row['ID_USER'];
                            $id_leilao = $row['ID_LEILAO'];
                            $titulo = htmlspecialchars($row['TITULO']);
                            $data_inicio = $row['DATA_INICIO'];
                            // $ultimo_lance = $row['ULTIMO_LANCE'];
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
                            $ultimo_lance_aparece = '-';
    
                            $data_inicio_1a_praca = new DateTime($data_inicio);
                            $data_fim_1a_praca = new DateTime($data_final);
    
                            $diferenca = $data_inicio_1a_praca->diff($data_fim_1a_praca);
    
                            // Soma os dias ao fim da 1ª praça
                            $data_inicio_2a_praca = clone $data_fim_1a_praca;
                            $data_inicio_2a_praca->modify("+$diferenca_dias days");
    
                            $data_fim_2a_praca = clone $data_inicio_2a_praca;
                            $data_fim_2a_praca->modify("+$diferenca->days days");
    
                            $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    
                            if ($status_produto == 6) {
                                $stmt_select = $conn->prepare(
                                    "SELECT VALOR FROM lancamento
                                     WHERE ID_PRODUTO = ? AND ID_LEILAO = ?; 
                                ");
                                $stmt_select->bind_param("ii", $id_produto, $id_leilao);
                                $stmt_select->execute();
                                $result_select = $stmt_select->get_result();
                                $stmt_select->close();
    
                                while ($row_select = $result_select->fetch_assoc()) {
                                    $ultimo_lance_aparece = number_format($row_select['VALOR'], 2, ',', '.');
                                }
                            }

                            $botao = '
                                    <a style="margin: 10px auto;" href="voltar-leilao.php?id='. $id_produto .'">Ver leilão</a>
                            ';
                            
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
                                                <p><span>Ultimo lance:</span> R$ '.  $ultimo_lance_aparece .' </p>
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
                                                <p><span>Valor inicial:</span> R$ '.$desconto.'</p>
                                                <p><span>Ultimo lance:</span> R$ - </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding-left: 0px;" class="dar-lance">'. $botao .'</div>
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
                                                <p><span>Ultimo lance:</span> R$ '.  $ultimo_lance_aparece .'</p>
                                            </div>
                                        </div>
                                        <div class="card-informations-row"></div>
                                    </div>
                                    <div style="padding-left: 0px;" class="dar-lance">'. $botao .'</div>
                                </div>
                            
                                
                                ';
    
                            }
                        }
                    }

                
                ?>
            </div>
        </section>
    </main>
</body>
</html>
