<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia']) && (!isset($_SESSION['admin']))) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $_SESSION['old'] = $_POST;

        $inicio = $_POST['inicio'];
        $final = $_POST['final'];

        $data_inicio = new DateTime($inicio);
        $data_fim = new DateTime($final);

        if ($data_inicio >= $data_fim) {
            $_SESSION['ini-fim-invalidas'] = "<p><i class='material-icons'>warning</i> A data e horário final do leilão deve ser posterior ao inicial</p>";

            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['id-produto']);
            exit;
        }

        $nome = $_POST['nome'];
        $pracas = $_POST['pracas'];
        $reducao = $_POST['reducao'];
        $valor_incremento = $_POST['valorincremento'];
        $diferenca_pracas = $_POST['diferenca-dias'];
        $observacao = $_POST['observacoes'];
        $contato = $_POST['contato'];

        $stmt = $conn->prepare("UPDATE leilao SET TITULO = ?, DATA_INICIO = ?, DATA_FINAL = ?, NUMERO_PARACAS = ?, REDUCAO_PRACA = ?, DIFERENCA_PRACA = ?, VALOR_INCREMENTO = ?, CONTATO = ?, DESCRICAO = ? WHERE ID_PRODUTO = ?");
        $stmt->bind_param("sssiiidssi", $nome, $inicio, $final, $pracas, $reducao, $diferenca_pracas, $valor_incremento, $contato, $observacao, $_SESSION['id-produto']);

        if ($stmt->execute()) {
            // Manipula as imagens
            // Busca as imagens atuais do banco
            $stmtImgs = $conn->prepare("SELECT FOTO_1, FOTO_2, FOTO_3, FOTO_4 FROM leilao WHERE ID_PRODUTO = ?");
            $stmtImgs->bind_param("i", $_SESSION['id-produto']);
            $stmtImgs->execute();
            $resultImgs = $stmtImgs->get_result();
            $imagensAtuais = $resultImgs->fetch_assoc();
            $stmtImgs->close();

            $caminhos = [];

            for ($i = 1; $i <= 4; $i++) {
                if (isset($_FILES["foto$i"]) && $_FILES["foto$i"]['error'] === UPLOAD_ERR_OK) {
                    $tmp = $_FILES["foto$i"]['tmp_name'];
                    $nomeFoto = "foto_" . $_SESSION['id-produto'] . "_$i.jpg";
                    $destino = "imagens/leilao/" . $nomeFoto;

                    if (move_uploaded_file($tmp, $destino)) {
                        $caminhos[$i] = $destino;
                    } else {
                        // Se o upload falhar, mantém a imagem atual
                        $caminhos[$i] = $imagensAtuais["FOTO_$i"];
                    }
                } else {
                    // Se não foi enviado um novo arquivo, mantém a imagem atual
                    $caminhos[$i] = $imagensAtuais["FOTO_$i"];
                }
            }

            // Atualizar as colunas de imagem
            $stmtUpdate = $conn->prepare(
                "UPDATE leilao SET FOTO_1 = ?, FOTO_2 = ?, FOTO_3 = ?, FOTO_4 = ? WHERE ID_PRODUTO = ?"
            );
            $stmtUpdate->bind_param(
                "ssssi",
                $caminhos[1],
                $caminhos[2],
                $caminhos[3],
                $caminhos[4],
                $_SESSION['id-produto']
            );
            $stmtUpdate->execute();
            $stmtUpdate->close();

            $_SESSION['leilao-editado'] = "<p><i class='material-icons'>check_circle</i>Informações referentes ao leilão editadas com sucesso</p>";

            unset($_SESSION['old'], $_SESSION['id-produto']);

          
            header('Location: tela-inicial-adm.php');
            exit;
        } else {
            $_SESSION['erro-editar'] = "<p><i class='material-icons'>error</i> Ocorreu um erro ao editar o leilao</p>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?id=' . $_SESSION['id-produto']);
            exit;
        }

    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new LegalEntity();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $nome_usuario = $_SESSION['nome-fantasia'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];
    // $product_id = $_SESSION['id-produto'];

    if (isset($_GET['id'])) {
        $id_produto = $_GET['id'];
        $_SESSION['id-produto'] = $id_produto;
    }


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
                <!-- <h2>Produtos</h2> -->
                <div class="row row-solicitacao"></div>
            </div>
            <form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$id_produto?>" method="POST" class="iniciando-leilao" style="padding-right: 57px;" enctype="multipart/form-data">
                <h2>Editar Leilão</h2>
                <?php 
                
                    if (isset($_SESSION['ini-fim-invalidas'])) {
                        ?>
                        <div class="mensagem-sem-foto" id="mensagem-sem-foto" style="margin-top: 20px;">
                            <?=$_SESSION['ini-fim-invalidas']?>
                        </div>
                            <script>
                                // Oculta a mensagem após 4 segundos
                                setTimeout(function() {
                                    const msg = document.getElementById('mensagem-sem-foto');
                                    if (msg) {
                                        msg.style.transition = 'opacity 0.5s ease';
                                        msg.style.opacity = '0';
                                        setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                                    }
                                }, 4000);
                            </script>
                        <?php
                        unset($_SESSION['ini-fim-invalidas']);
                    }
                    
                
                ?>
                <div class="main-div-1">
                    <div class="nome-imagens-pracas-reducao-valorincremento">
                        <a class="voltar" href="javascript:history.back()">
                            <img src="css/svg/arrow-left.svg" alt="">
                        </a>
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome"  value="<?=$_SESSION['old']['nome'] ?? $titulo?>">
                        </div>
                        <label for="">Imagens</label>
                        <div class="img-prv">
                            <div class="imagens imagens-4">
                                <div class="layer-1">
                                    <label for="foto1" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview1" src="<?=$foto_1?>" alt="Imagem de Perfil">
                                        <input type="file" id="foto1" name="foto1" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview1')">
                                    </label>
                                    <label for="foto2" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview2" src="<?=$foto_2?>" alt="Imagem de Perfil">
                                        <input type="file" id="foto2" name="foto2" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview2')">
                                    </label>
                                </div>
                                <div class="layer-2">
                                    <label for="foto3" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview3" src="<?=$foto_3?>" alt="Imagem de Perfil">
                                        <input type="file" id="foto3" name="foto3" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview3')">
                                    </label>
                                    <label for="foto4" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview4" src="<?=$foto_4?>" alt="Imagem de Perfil">
                                        <input type="file" id="foto4" name="foto4" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview4')">
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
                                    <select name="pracas" id="condicao-select" style="width: fit-content;" required>
                                        <option value="" <?=!isset($_SESSION['old']['pracas']) ? 'selected' : ''?> disabled></option>
                                        <option value="1" <?= (int) ($_SESSION['old']['pracas'] ?? $numero_pracas) === 1 ? 'selected' : '' ?>>1</option>
                                        <option value="2" <?= (int) ($_SESSION['old']['pracas'] ?? $numero_pracas) === 2 ? 'selected' : '' ?>>2</option>
                                    </select>
                                </div>
                                <div class="reducao">
                                    <label for="reducao">Redução (%)</label>
                                    <input type="number" name="reducao" id="reducao"  value="<?=$_SESSION['old']['reducao'] ?? $reducao_pracas?>" min="0">
                                </div>
                                <div class="valorincremento">
                                    <label for="valorincremento">Valor de incremento</label>
                                    <input type="number" name="valorincremento" id="valorincremento" value="<?=$_SESSION['old']['valorincremento'] ?? $valor_incremento?>" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="data-horario-inicio-final-diferenca">
                        <div class="d-h-inicio">
                            <label for="inicio">Data/Horário de início</label>
                            <input type="datetime-local" name="inicio" id="inicio"  value="<?=$_SESSION['old']['inicio'] ?? $data_inicio?>">
                        </div>
                        <div class="d-h-final">
                            <label for="final">Data/Horário do final</label>
                            <input type="datetime-local" name="final" id="final"  value="<?=$_SESSION['old']['final'] ?? $data_final?>">
                        </div>
                        <div class="diferenca-dias">
                            <label for="diferenca-dias">Diferença de dias entre praça</label>
                            <input type="number" name="diferenca-dias" id="diferenca-dias"  value="<?=$_SESSION['old']['diferenca-dias'] ?? $diferenca_pracas?>" min="1">
                        </div>
                    </div>
                </div>
                <div class="main-div-2">
                    <div class="observacoes-contato">
                        <div class="observacoes">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" ><?=$_SESSION['old']['observacoes'] ?? $descricao?></textarea>
                        </div>
                        <div class="contato">
                            <label for="contato">Contato</label>
                            <input type="tel" name="contato" id="contato"  value="<?=$_SESSION['old']['contato'] ?? $contato?>">
                        </div>
                    </div>
                    <div class="aprova-recusa">
                        <button style="padding: 8px 40px;" type="submit" name="aprovado" class="aprovar">Editar</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>