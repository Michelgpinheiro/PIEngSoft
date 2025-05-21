<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-usuario'])) {
        header('Location: login.php');
        exit;
    }

    if (isset($_POST['enviar-pagamento'])) {
        if (!empty($_POST['valor'] || !empty($_POST['contato'] || !empty($_POST['observation'])))) {

            $valor = $_POST['valor'];
            $contato = $_POST['contato'];
            $observacao = $_POST['observations'];

            $stmt_insert = $conn->prepare(
                "INSERT INTO lancamento (ID_USUARIO, ID_PRODUTO, ID_LEILAO, VALOR, CONTATO, OBSERVACOES) VALUES (?, ?, ?, ?, ?, ?) 

                ON DUPLICATE KEY UPDATE 
                    VALOR = VALUES(VALOR),
                    CONTATO = VALUES(CONTATO),
                    OBSERVACOES = VALUES(OBSERVACOES)
                ;
            ");
            $stmt_insert->bind_param("iiidss", $_SESSION['id-usuario-leilao'], $_SESSION['id-produto'], $_SESSION['id-leilao'], $valor, $contato, $observacao);
    
            $stmt_insert->execute();
            $stmt_insert->close();

            $stmt_update = $conn->prepare(
                "UPDATE produto 
                 SET STATUS_PRODUTO = 4 
                 WHERE ID = ? AND ID_USUARIO = ?;
            ");
            $stmt_update->bind_param("ii", $_SESSION['id-produto'], $_SESSION['id-usuario-leilao']);
            $stmt_update->execute();
            $stmt_update->close();

            $_SESSION['lance-sucesso'] = "<p><i class='material-icons'>check_circle</i> Lance dado com sucesso</p>";

            unset($_SESSION['id-usuario-leilao'], $_SESSION['id-produto'], $_SESSION['id-leilao']);

            header('Location: tela-inicial.php');
            exit;
        } else {
            $_SESSION['nao-preenchido'] = "<p><i class='material-icons'>error</i> Preencha completamente o formulário de \"Dar lance\"</p>";

            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new PhysicalPerson();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $nome_usuario = $_SESSION['nome-usuario'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if (isset($_GET['id'])) {
        $_SESSION['id-produto'] = $_GET['id'];;
    }

    $id_produto = $_SESSION['id-produto'];

    $stmt = $conn->prepare(
        "SELECT l.TITULO AS TITULO, DATE_FORMAT(l.DATA_INICIO, '%Y-%m-%d') AS DATA_INICIO, DATE_FORMAT(l.DATA_FINAL, '%Y-%m-%d') AS DATA_FINAL, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, l.FOTO_1 AS FOTO_1, l.FOTO_2 AS FOTO_2, l.FOTO_3 AS FOTO_3, l.FOTO_4 AS FOTO_4, l.DIFERENCA_PRACA AS DIFERENCA_PRACAS, l.DESCRICAO AS DESCRICAO, u.NOME AS NOME_LEILOEIRO, u.CIDADE AS LOCALIDADE, p.LANCE_INICIAL AS LANCE_INICIAL, p.ID AS ID_PRODUTO, l.ID AS ID_LEILAO, p.CATEGORIA AS CATEGORIA, u.ID AS ID_USUARIO FROM leilao AS l

        INNER JOIN produto AS p ON l.ID_PRODUTO = p.ID
        INNER JOIN usuario AS u ON p.ID_USUARIO = u.ID

        WHERE p.ID = $id_produto;"
    );

    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result->fetch_array()) {
        $id_leilao = $row['ID_LEILAO'];
        $id_produto = $row['ID_PRODUTO'];
        $id_usuario_leilao = $row['ID_USUARIO'];
        $titulo = htmlspecialchars($row['TITULO']);
        $data_inicio = $row['DATA_INICIO'];
        $data_final = $row['DATA_FINAL'];
        $diferenca_dias = $row['DIFERENCA_PRACAS'];
        $numero_pracas = $row['PRACAS'];
        $reducao_pracas = $row['REDUCAO'];
        $lance_inicial = number_format($row['LANCE_INICIAL'],2 , ',', '.');
        $valor_incremento = number_format($row['INCREMENTO'],2 ,',', '.');
        $foto_1 = $row['FOTO_1'];
        $foto_2 = $row['FOTO_2'];
        $foto_3 = $row['FOTO_3'];
        $foto_4 = $row['FOTO_4'];
        $descricao = htmlspecialchars($row['DESCRICAO']);
        $nome_leiloeiro = htmlspecialchars($row['NOME_LEILOEIRO']);
        $localidade = htmlspecialchars($row['LOCALIDADE']);
        $categoria = htmlspecialchars($row['CATEGORIA']);

        $data_inicio_1a_praca = new DateTime($data_inicio);
        $data_fim_1a_praca = new DateTime($data_final);

        $diferenca = $data_inicio_1a_praca->diff($data_fim_1a_praca);

        // Soma os dias ao fim da 1ª praça
        $data_inicio_2a_praca = clone $data_fim_1a_praca;
        $data_inicio_2a_praca->modify("+$diferenca_dias days");

        $data_fim_2a_praca = clone $data_inicio_2a_praca;
        $data_fim_2a_praca->modify("+$diferenca->days days");

        $desconto = number_format((float)$lance_inicial - ((float)$lance_inicial * ((float)$reducao_pracas)/100.0), 2, ',', '.');
    }

    $stmt_select = $conn->prepare("SELECT VALOR FROM lancamento WHERE ID_LEILAO = ? AND ID_PRODUTO = ?");
    $stmt_select->bind_param("ii", $id_leilao, $id_produto);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    $stmt_select->close();

    while ($row_select = $result_select->fetch_assoc()) {
        $ultimo_lance = number_format($row_select['VALOR'], 2, ',', '.');
    }

    if (empty($ultimo_lance)) {
        $ultimo_lance = "-";
    } 

    $_SESSION['id-usuario-leilao'] = $id_usuario_leilao;
    $_SESSION['id-leilao'] = $id_leilao;

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="css/tela-pagamento/style-tela-pagamento.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
            
                if (isset($_SESSION['nao-preenchido'])) {
                    ?>
                    <div class="mensagem-erro" id="mensagem-erro">
                        <?=$_SESSION['nao-preenchido']?>
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
                    unset($_SESSION['nao-preenchido']);
                }

            ?>
            <a href="tela-inicial.php" class="voltar voltare">
                <img src="css/svg/arrow-left-2.svg" alt="">
            </a>
            <section class="imagens">
                <figure class="imagem-principal">
                    <img src="<?=$foto_1?>" alt="">
                    <h2><?=$titulo?></h2>
                </figure>
                <div class="imagens-secundarias">
                    <figure class="img-sec-1">
                        <img src="<?=$foto_2?>" alt="">
                    </figure>
                    <figure class="img-sec-1">
                        <img src="<?=$foto_3?>" alt="">
                    </figure>
                    <figure class="img-sec-1">
                        <img src="<?=$foto_4?>" alt="">
                    </figure>
                </div>
            </section>
            <section class="produto-info">
                <div class="descricao">
                    <p><span>Descrição:</span><?=$descricao?></p>
                    <br>
                    <p style="display: flex; align-items: center; gap: 5px; color: #5e2a1e;"><i class="material-icons">info</i><span>Informações</span></p>
                    <br>
                    <p class="increment" style="text-align: right; margin-right: 20px;"><span>Incremento:</span><span class="dindin"> R$ <?=$valor_incremento?></span></p>
                    <br>
                    <nav>
                        <ul>
                            <li>Leiloeiro: <span style="font-weight: 300;"><?=$nome_leiloeiro?></span></li>
                            <li>Localidade: <span style="font-weight: 300;"><?=$localidade?></span></li>
                            <li>Leilão: <span style="font-weight: 300;"><?=$id_leilao?></span></li>
                            <li>Categoria: <span style="font-weight: 300;"><?=$categoria?></span></li>
                        </ul>
                    </nav>
                    <div class="dar-lance">
                        <a href="#" id="btn-dar-lance">Dar lance</a>
                        <!-- <a class="voltar" href="tela-inicial.php">Voltar</a> -->
                    </div>

                    <div class="popup-container popup-container-pagamento" id="popup-lance">
                        <form style="background-color: #bd6c34;" action="tela-pagamento.php?id=<?=$id_produto?>" method="POST" class="popup-content popup-pagamento">
                            <span id="close-popup" class="close-popup  close-popup-pag">&times;</span>
                                <div class="valor-contato">
                                    <div class="lance-valor">
                                        <label for="valor-lance">Valor</label>
                                        <input type="number" id="valor-lance" name="valor" step="any">
                                    </div>
                                    <div class="lance-contato">
                                        <label for="contato-lance">Contato</label>
                                        <input type="tel" id="contato-lance" name="contato">
                                    </div>
                                </div>
                                <label for="observacoes-lance">Observações</label>
                                <textarea id="observacoes-lance" rows="4" cols="30" name="observations"></textarea><br><br>
                                <button id="enviar-lance" name="enviar-pagamento">Enviar</button>
                            </div>
                        </form>
                    </div>

                </div>
                <br>
                <div class="pracas">
                    <div class="praca-1">
                        <div class="praca-1-info">
                            <h3>1ª Praça</h3>
                            <div class="praca-info-row"></div>
                            <div class="praca-inicio-fim">
                                <p><span>Início:</span> <?=$data_inicio_1a_praca->format("d/m/Y")?></p>
                                <p><span>Fim:</span> <?=$data_fim_1a_praca->format("d/m/Y")?></p>
                            </div>
                        </div>
                        <div class="praca-info-row"></div>
                        <div class="praca-1-info2">
                            <p><span>Valor inicial:</span> R$ <?=$lance_inicial?></p>
                            <p><span>Último lance:</span> R$ <?=$ultimo_lance?></p>
                        </div>  
                    </div>
                    <div class="praca-2 praca-1">
                    <div class="praca-1-info">
                            <h3>2ª Praça</h3>
                            <div class="praca-info-row"></div>
                            <div class="praca-inicio-fim">
                                <p><span>Início:</span> <?=$data_inicio_2a_praca->format("d/m/Y")?></p>
                                <p><span>Fim:</span> <?=$data_fim_2a_praca->format("d/m/Y")?></p>
                            </div>
                        </div>
                        <div class="praca-info-row"></div>
                        <div class="praca-1-info2">
                            <p><span>Valor inicial:</span> R$ <?=$desconto?></p>
                            <!-- <p style="color: transparent;">.</p> -->
                            <p><span>Último lance:</span> R$ -</p>
                        </div>  
                    </div>
                </div>
            </section>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnDarLance = document.getElementById('btn-dar-lance');
            const popupLance = document.getElementById('popup-lance');
            const closePopup = document.getElementById('close-popup');

            // Exibir o popup ao clicar no botão "Dar lance"
            btnDarLance.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance.style.display = 'block';  // Mostrar o popup
            });

            // Fechar o popup ao clicar no "X"
            closePopup.addEventListener('click', function() {
                popupLance.style.display = 'none';  // Ocultar o popup
            });

            // Fechar o popup se clicar fora dele
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>