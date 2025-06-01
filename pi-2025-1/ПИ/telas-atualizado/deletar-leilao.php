<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia']) && (!isset($_SESSION['admin']))) {
        header('Location: login.php');
        exit;
    }

    if (isset($_GET['id'])) {
        $id_produto = $_GET['id'];
        $_SESSION['id-produto'] = $id_produto;
    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new LegalEntity();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $nome_usuario = $_SESSION['nome-fantasia'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];
    $product_id = $_SESSION['id-produto'];

    $stmt = $conn->prepare(
        "SELECT l.TITULO AS NOME, l.NUMERO_PARACAS AS PRACAS, l.REDUCAO_PRACA AS REDUCAO, l.VALOR_INCREMENTO AS INCREMENTO, l.DATA_INICIO AS INICIO, l.DATA_FINAL AS FINAL, l.DIFERENCA_PRACA AS DIFERENCA, l.FOTO_1 AS FOTO_1, l.FOTO_2 AS FOTO_2, l.FOTO_3 AS FOTO_3, l.FOTO_4 AS FOTO_4, l.CONTATO AS CONTATO, l.DESCRICAO AS DESCRICAO, p.ID_USUARIO AS ID_USUARIO FROM leilao AS l

        INNER JOIN produto AS p ON p.ID = l.ID_PRODUTO
        WHERE (p.STATUS_PRODUTO = 4 OR p.STATUS_PRODUTO = 2) AND p.ID = ?;

    ");

    $stmt->bind_param("i", $id_produto);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $user_id = $row['ID_USUARIO'] ?? '';
        $titulo = $row['NOME'] ?? '';
        $numero_pracas = $row['PRACAS'] ?? '';
        $reducao_pracas = $row['REDUCAO'] ?? '';
        $valor_incremento = $row['INCREMENTO'] ?? '';
        $data_inicio = $row['INICIO'] ?? '';
        $data_final = $row['FINAL'] ?? '';
        $diferenca_pracas = $row['DIFERENCA'] ?? '';
        $foto_1 = $row['FOTO_1'] ?? '';
        $foto_2 = $row['FOTO_2'] ?? '';
        $foto_3 = $row['FOTO_3'] ?? '';
        $foto_4 = $row['FOTO_4'] ?? '';
        $contato = $row['CONTATO'] ?? '';
        $descricao = $row['DESCRICAO'] ?? '';
    }

    $_SESSION['user-id'] = $user_id;

    if (!empty($_POST['motivo-recusa']) && isset($_POST['recusar'])) {
        $exclusao = $_POST['motivo-recusa'];

        $stmt_recusa = $conn->prepare("UPDATE produto SET MOTIVO_EXCLUSAO = ?, STATUS_PRODUTO = 7 WHERE ID = ? AND ID_USUARIO = ?");
        $stmt_recusa->bind_param("sii", $exclusao, $id_produto, $user_id);
        $stmt_recusa->execute();
        $stmt_recusa->close();

        // $stmt_update_recusa = $conn->prepare("UPDATE produto SET STATUS_PRODUTO = 7 WHERE ID = ? AND ID_USUARIO = ?");
        // $stmt_update_recusa->bind_param("ii", $id_produto, $user_id);
        // $stmt_update_recusa->execute();
        // $stmt_update_recusa->close();

        $stmt_exclusao = $conn->prepare("DELETE FROM leilao WHERE ID_PRODUTO = ?");
        $stmt_exclusao->bind_param("i", $id_produto);
        $stmt_exclusao->execute();
        $stmt_exclusao->close();

        $stmt_exclusao = $conn->prepare("DELETE FROM lancamento WHERE ID_PRODUTO = ?");
        $stmt_exclusao->bind_param("i", $id_produto);
        $stmt_exclusao->execute();
        $stmt_exclusao->close();

        unset($_SESSION['id-produto'], $_SESSION['user-id']);

        $_SESSION['leilao-excluido'] = "<p><i class='material-icons'>check_circle</i> Exclusão de leilão feita com sucesso</p>";
            
        header('Location: tela-inicial-adm.php');
        exit;
    }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de administrador </title>
    <link rel="stylesheet" href="css/solicitacao-adm/--style-solicitacao-adm.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
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
                <li><a class="selected-page" style="font-size: 13px;">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php">Solicitações</a></li>
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
            <div class="categoria-row categoria-row-solicitacao">
                <!-- <h2>Produtos</h2>
                <div class="row row-solicitacao"></div> -->
            </div>
            <form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$id_produto?>" method="POST" class="iniciando-leilao" style="padding-right: 57px;" enctype="multipart/form-data">
                <h2>Excluir Leilão</h2>
                <div class="main-div-1">
                    <div class="nome-imagens-pracas-reducao-valorincremento">
                        <a class="voltar" href="javascript:history.back()">
                            <img src="css/svg/arrow-left.svg" alt="">
                        </a>
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" disabled value="<?=$titulo?>">
                        </div>
                        <label for="">Imagens</label>
                        <div class="img-prv">
                            <div class="imagens imagens-4">
                                <div class="layer-1">
                                    <label for="foto1" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview1" src="<?=$foto_1?>" alt="Imagem de Perfil">
                                    </label>
                                    <label for="foto2" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview2" src="<?=$foto_2?>" alt="Imagem de Perfil">
                                    </label>
                                </div>
                                <div class="layer-2">
                                    <label for="foto3" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview3" src="<?=$foto_3?>" alt="Imagem de Perfil">
                                    </label>
                                    <label for="foto4" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview4" src="<?=$foto_4?>" alt="Imagem de Perfil">
                                    </label>
                                </div>
                            </div>
                            <script>
                                function previewImagem(input, imgId) {
                                    const img = document.getElementById(imgId);
                                    if (input.files && input.files[0]) {
                                        img.src = URL.createObjectURL(input.files[0]);
                                    }
                                }
                            </script>
                            <div class="pracas-reducao-valorincremento">
                                <div class="pracas">
                                    <label for="pracas">Praças</label>
                                    <input type="number" name="pracas" id="pracas" max="2" disabled value="<?=$numero_pracas?>">
                                </div>
                                <div class="reducao">
                                    <label for="reducao">Redução (%)</label>
                                    <input type="number" name="reducao" id="reducao" disabled value="<?=$reducao_pracas?>">
                                </div>
                                <div class="valorincremento">
                                    <label for="valorincremento">Valor de incremento</label>
                                    <input type="number" name="valorincremento" id="valorincremento" disabled value="<?=$valor_incremento?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="data-horario-inicio-final-diferenca">
                        <div class="d-h-inicio">
                            <label for="inicio">Data/Horário de início</label>
                            <input type="datetime-local" name="inicio" id="inicio" disabled value="<?=$data_inicio?>">
                        </div>
                        <div class="d-h-final">
                            <label for="final">Data/Horário do final</label>
                            <input type="datetime-local" name="final" id="final" disabled value="<?=$data_final?>">
                        </div>
                        <div class="diferenca-dias">
                            <label for="diferenca-dias">Diferença de dias entre praça</label>
                            <input type="number" name="diferenca-dias" id="diferenca-dias" disabled value="<?=$diferenca_pracas?>">
                        </div>
                    </div>
                </div>
                <div class="main-div-2">
                    <div class="observacoes-contato">
                        <div class="observacoes">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" disabled><?=$descricao?></textarea>
                        </div>
                        <div class="contato">
                            <label for="contato">Contato</label>
                            <input type="tel" name="contato" id="contato" disabled value="<?=$contato?>">
                        </div>
                    </div>
                    <div class="aprova-recusa">
                        <button type="submit" name="aprovado" class="aprovar" style="visibility: hidden;">Aprovar</button>
                        <a href="#" id="btn-dar-lance" class="aprovar" style="background-color: #ffd980; color: #5e2a1e; padding: 10px 20px;">Excluir</a>
                    </div>

                    <div class="popup-container pop-container-recusa" id="popup-lance" style="position: absolute; bottom: -200px;">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <label for="motivo-recusa">Motivo da exclusão</label>
                            <textarea id="motivo-recusa" name="motivo-recusa" rows="4" cols="30"></textarea><br><br>
                            <button id="enviar-lance" name="recusar" type="submit" >Excluir</button>
                        </div>
                    </div>
                </div>
            </form>
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