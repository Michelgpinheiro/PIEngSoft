<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-usuario'])) {
        header('Location: login.php');
        exit;
    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new PhysicalPerson();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];
    $nome_produto = '';

    if (isset($_GET['id'])) {
        $id_produto = $_GET['id'];
        $_SESSION['produto-id'] = $id_produto;

        $stmt_produto = $conn->prepare("SELECT NOME, LANCE_INICIAL FROM produto WHERE ID = ?");
        $stmt_produto->bind_param("i", $id_produto);
        $stmt_produto->execute();
        $result = $stmt_produto->get_result();
        if ($row = $result->fetch_assoc()) {
            $nome_produto = $row['NOME'];
            $lance = $row['LANCE_INICIAL'];
        }
        $stmt_produto->close();
    }

    $nome_usuario = $_SESSION['nome-usuario'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $_SESSION['old'] = $_POST;

        // Verifica se pelo menos 1 imagem foi enviada
        if (!isset($_FILES['foto1']) || $_FILES['foto1']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['foto-nao-definida'] = "<p><i class='material-icons'>warning</i> Anexe pelo menos uma foto antes de prosseguir</p>";
            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $id_produto);
            exit;
        }

        // Dados do formulário
        $inicio = $_POST['inicio'] ?? '';
        $final = $_POST['final'] ?? '';
        $data_inicio = new DateTime($inicio);
        $data_fim = new DateTime($final);

        if ($data_inicio >= $data_fim) {
            $_SESSION['ini-fim-invalidas'] = "<p><i class='material-icons'>warning</i> A data e horário final do leilão deve ser posterior ao inicial</p>";

            header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $id_produto);
            exit;
        }

        $titulo = $_POST['nome'] ?? '';
        $pracas = $_POST['pracas'] ?? '';
        $reducao = $_POST['reducao'] ?? '';
        $valor_incremento = $_POST['valorincremento'] ?? '';
        $diferenca_dias = $_POST['diferenca-dias'] ?? '';
        $contato = $_POST['contato'] ?? '';
        $observacoes = $_POST['observacoes'] ?? '';
        $id_produto = $_SESSION['produto-id']; 



        // Inserir o produto
        $stmt = $conn->prepare("INSERT INTO leilao (TITULO, ID_USUARIO, ID_PRODUTO, DATA_INICIO, DATA_FINAL, NUMERO_PARACAS, REDUCAO_PRACA, DIFERENCA_PRACA, VALOR_INCREMENTO, CONTATO, DESCRICAO, VERIFICADO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");

        $stmt->bind_param("siissiiidss", $titulo, $id_usuario, $id_produto,  $inicio, $final, $pracas, $reducao, $diferenca_dias, $valor_incremento, $contato, $observacoes);

        if ($stmt->execute()) {
            // Manipula as imagens
            $caminhos = [];

            for ($i = 1; $i <= 4; $i++) {
                if (isset($_FILES["foto$i"]) && $_FILES["foto$i"]['error'] === UPLOAD_ERR_OK) {
                    $tmp = $_FILES["foto$i"]['tmp_name'];
                    $nomeFoto = "foto_{$id_produto}_$i.jpg";
                    $destino = "imagens/leilao/" . $nomeFoto;

                    if (move_uploaded_file($tmp, $destino)) {
                        $caminhos[$i] = $destino;
                    } else {
                        $caminhos[$i] = "imagens/leilao/no-image.svg";
                    }
                } else {
                    $caminhos[$i] = "imagens/leilao/no-image.svg";
                }
            }

            // Atualizar as colunas de imagem
            $stmtUpdate = $conn->prepare("UPDATE leilao SET FOTO_1 = ?, FOTO_2 = ?, FOTO_3 = ?, FOTO_4 = ? WHERE ID_PRODUTO = ?");
            $stmtUpdate->bind_param(
                "ssssi",
                $caminhos[1],
                $caminhos[2],
                $caminhos[3],
                $caminhos[4],
                $id_produto
            );
            $stmtUpdate->execute();
            $stmtUpdate->close();

            $stmt_produto = $conn->prepare("UPDATE produto SET STATUS_PRODUTO = 5 WHERE ID = $id_produto");
            $stmt_produto->execute();
            $stmt_produto->close();

            $tipo_movimentacao = "Solicitação de leilão";
            $stmt_movimentacao = $conn->prepare("INSERT INTO movimentacao (TIPO_MOVIMENTACAO, ID_USUARIO, VALOR, NOME_PRODUTO) VALUES (?, ?, ?, ?)");
            $stmt_movimentacao->bind_param("sids", $tipo_movimentacao,$id_usuario, $lance, $nome_produto);
            $stmt_movimentacao->execute();
            $stmt_movimentacao->close();

            $_SESSION['leilao-analise'] = "<p><i class='material-icons'>check_circle</i>Solicitação de leilão enviada com sucesso, o mesmo será analisado por um moderador antes de ir ao ar</p>";

            unset($_SESSION['old'], $_SESSION['produto-id']);

            header('Location: tela-produtos.php');
            exit;
        } else {
            $_SESSION['erro-leiloar'] = "<p><i class='material-icons'>error</i> Ocorreu um erro ao iniciar o leilao</p>";
            header('Location:' . $_SERVER['PHP_SELF'] . '?id=' . $id_produto);
            exit;
        }

        $stmt->close();
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="style.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/tela-produtos-2/-style-tela-produtos-2.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/estilizacao-geral.cssv=<?=time()?>">
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
                <li><a href="tela-inicial.php">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a class="selected-page">Produtos</a></li>
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
            <div class="categoria-row">
                <!-- <h2 class="tp2">Seus Produtos</h2>
                <div class="row tp2"></div> -->
            </div>
            <form action="<?=$_SERVER['PHP_SELF']?>?id=<?=$id_produto?>" method="POST" class="iniciando-leilao cadastro-produtos formulario-cadastros form-cadastros" style="padding-right: 57px;" enctype="multipart/form-data">
                <h2>Iniciando Leilão</h2>
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
                
                    if (isset($_SESSION['erro-leiloar'])) {
                        ?>
                        <div class="mensagem-erro" id="mensagem-erro">
                            <?=$_SESSION['erro-leiloar']?>
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
                        unset($_SESSION['erro-leiloar']);
                    }

                    if (isset($_SESSION['foto-nao-definida'])) {
                        ?>
                        <div class="mensagem-sem-foto" id="mensagem-sem-foto" style="margin-top: 20px;">
                            <?=$_SESSION['foto-nao-definida']?>
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
                        unset($_SESSION['foto-nao-definida']);
                    }

                ?>
                <div class="main-div-1">
                    <div class="nome-imagens-pracas-reducao-valorincremento">
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" value="<?=$nome_produto?>" required>
                        </div>
                        <label for="">Imagens</label>
                        <div class="img-prv">
                            <div class="imagens imagens-4">
                                <div class="layer-1">
                                    <label for="foto1" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview1" src="css/svg/plus-2.svg" alt="Imagem de Perfil">
                                        <input type="file" id="foto1" name="foto1" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview1')">
                                    </label>
                                    <label for="foto2" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview2" src="css/svg/plus-2.svg" alt="Imagem de Perfil">
                                        <input type="file" id="foto2" name="foto2" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview2')">
                                    </label>
                                </div>
                                <div class="layer-2">
                                    <label for="foto3" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview3" src="css/svg/plus-2.svg" alt="Imagem de Perfil">
                                        <input type="file" id="foto3" name="foto3" accept="image/*" style="display: none;" onchange="previewImagem(this, 'preview3')">
                                    </label>
                                    <label for="foto4" class="imagem imagem-resto imagens-leilao" style="cursor: pointer;">
                                        <img id="preview4" src="css/svg/plus-2.svg" alt="Imagem de Perfil">
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
                                        <option value=1 <?= ($_SESSION['old']['pracas'] ?? '') === 1 ? 'selected' : '' ?>>1</option>
                                        <option value=2 <?= ($_SESSION['old']['pracas'] ?? '') === 2 ? 'selected' : '' ?>>2</option>
                                    </select>
                                </div>
                                <div class="reducao">
                                    <label for="reducao">Redução (%)</label>
                                    <input type="number" name="reducao" id="reducao" value="<?=$_SESSION['old']['reducao'] ?? ''?>" min=0>
                                </div>
                                <div class="valorincremento">
                                    <label for="valorincremento">Valor de incremento</label>
                                    <input type="number" name="valorincremento" id="valorincremento" value="<?=$_SESSION['old']['valorincremento'] ?? ''?>" min=0>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="data-horario-inicio-final-diferenca">
                        <div class="d-h-inicio">
                            <label for="inicio">Data/Horário de início</label>
                            <input type="datetime-local" name="inicio" id="inicio" value="<?=$_SESSION['old']['inicio'] ?? ''?>">
                        </div>
                        <div class="d-h-final">
                            <label for="final">Data/Horário do final</label>
                            <input type="datetime-local" name="final" id="final" value="<?=$_SESSION['old']['final'] ?? ''?>">
                        </div>
                        <div class="diferenca-dias">
                            <label for="diferenca-dias">Diferença de dias entre praça</label>
                            <input type="number" name="diferenca-dias" id="diferenca-dias" value="<?=$_SESSION['old']['diferenca-dias'] ?? ''?>" min=0>
                        </div>
                    </div>
                </div>
                <div class="main-div-2">
                    <div class="observacoes-contato">
                        <div class="observacoes">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes"><?=$_SESSION['old']['observacoes'] ?? ''?></textarea>
                        </div>
                        <div class="contato">
                            <label for="contato">Contato</label>
                            <input type="tel" name="contato" id="contato" value="<?=$_SESSION['old']['contato'] ?? ''?>">
                        </div>
                    </div>
                    <div class="aprova-recusa salvar-cancelar">
                        <input type="hidden" name="id_produto" value="<?= htmlspecialchars($id_produto) ?>">
                        <button type="submit" class="salvar">Enviar</button>
                        <a href="tela-produtos.php" class="recusar cancelar">Cancelar</a>
                    </div>

                    <div class="popup-container" id="popup-lance">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <label for="motivo-recusa">Motivo da recusa</label>
                            <textarea id="motivo-recusa" name="motivo-recusa" rows="4" cols="30"></textarea><br><br>
                            <button id="enviar-lance">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
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