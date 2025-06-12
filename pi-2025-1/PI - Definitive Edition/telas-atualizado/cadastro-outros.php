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

    if (isset($_SESSION['nome-usuario'])) {
        $nome_usuario = $_SESSION['nome-usuario'];
    } else {
        $nome_usuario = $_SESSION['nome-fantasia'];
    }
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $_SESSION['old'] = $_POST;

        if ((!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK)) {
            $_SESSION['foto-nao-definida'] = "<p><i class='material-icons'>warning</i> Anexe uma foto antes de prosseguir</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        // Receber dados do formulário
        $usuario = new PhysicalPerson();

        $nome = $_POST['nome'] ?? '';
        $marca = $_POST['marca'] ?? '';
        $dimensoes = $_POST['dimensoes'] ?? '';
        $cor = $_POST['cor'] ?? '';
        $materiais = $_POST['materiais'] ?? '';
        $lance_inicial = $_POST['lanceinicial'] ?? '';
        $condicao = $_POST['condicao'] ?? '';
        $informacoes = $_POST['informacoes'] ?? '';
        $categoria = "Outros";

        $stmt = $conn->prepare("INSERT INTO produto (NOME, ID_USUARIO, MARCA, DIMENSOES, COR, MATERIAL, LANCE_INICIAL, CONDICAO, DADOS_ADICIONAIS, STATUS_PRODUTO, CATEGORIA) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");

        $stmt->bind_param("sissssdsss", $nome, $id_usuario, $marca, $dimensoes, $cor, $materiais, $lance_inicial, $condicao, $informacoes, $categoria);

        if ($stmt->execute()) {

            if ($stmt->affected_rows > 0) {
                $id_usuario = $stmt->insert_id;

                if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                    $fotoTmp = $_FILES['foto']['tmp_name'];

                    $nomeOriginal = $_FILES['foto']['name'];
                    $nomeFoto = "produtos_" . $id_usuario . ".jpg";
                    $caminhoDestino = "imagens/produtos/" . $nomeFoto;

                    // Salvar a imagem
                    move_uploaded_file($fotoTmp, $caminhoDestino);

                    // 3. Atualizar usuário com o caminho da foto
                    $stmtFoto = $conn->prepare("UPDATE produto SET FOTO = ? WHERE ID = ?");
                    $stmtFoto->bind_param("si", $caminhoDestino, $id_usuario);
                    $stmtFoto->execute();
                    $stmtFoto->close();
                }
            } 

            $tipo = "Produto Cadastrado";

            $stmt_movimentacao = $conn->prepare("INSERT INTO movimentacao (ID_USUARIO, TIPO_MOVIMENTACAO, VALOR, NOME_PRODUTO) VALUES (?, ?, ?, ?)");
            $stmt_movimentacao->bind_param("isds", $_SESSION['id-usuario'], $tipo, $lance_inicial, $nome);
            $stmt_movimentacao->execute();
            $stmt_movimentacao->close();

            $_SESSION['cadastro-sucesso'] = "<p><i class='material-icons'>check_circle</i> Cadastro de produto realizado com sucesso</p>";

            unset($_SESSION['old']);

            header('Location: tela-produtos.php');
            exit;
        } else {
            $_SESSION['erro-cadastro'] = "<p><i class='material-icons'>error</i> Ocorreu um ao cadastrar</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        $stmt->close();
    }

    //$conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de outros</title>
    <link rel="stylesheet" href="css/cadastro-movel/-style-cadastro-movel.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leileão</h1>
            <form action="tela-inicial.php" method="POST" class="barra-busca">
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
            <figure style="width: 40px; margin-right: -80px;"  class="perfil-configs">
                <p><?=htmlspecialchars($primeiro_nome)?></p>
                <?php if (is_null($foto_existe)) {?>
                    <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/03/150313105721-pi-day-graphic.jpg?w=1115" alt="">
                <?php } else {                   ?>
                    <img src="imagens/perfis/perfil_<?=$id_usuario?>.jpg" alt="Foto de Perfil">
                <?php }                          ?>
            </figure>
            <?php 

                $stmt = $conn->prepare(
                    "SELECT DIAS_DESATIVAR AS DESATIVAR FROM usuario
                    WHERE ID = ? 
                ");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                
                $row = $result->fetch_assoc();
                $dias_desativar = $row['DESATIVAR'];
            
            ?>
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
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" class="cadastro-produtos formulario-cadastros form-cadastros">
                <h2>Cadastro de produtos</h2>
                <?php 
                
                    if (isset($_SESSION['foto-nao-definida'])) {
                        ?>
                        <div class="mensagem-sem-foto" id="mensagem-sem-foto">
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
                <div class="nav-produtos">
                    <nav>
                        <ul>
                            <li><a class="not-selected" href="cadastro-produtos-eletronicos.php">Eletrônico</a></li>
                            <li><a class="not-selected" href="cadastro-veiculos.php">Veículos</a></li>
                            <li><a class="not-selected" href="cadastro-antiguidades.php">Antiguidade</a></li>
                            <li><a class="not-selected" href="cadastro-roupas.php">Roupas</a></li>
                            <li><a class="not-selected" href="cadastro-movel.php">Móvel</a></li>
                            <li style="margin-bottom: -1px;"><a class="selected-nav-produto">Outros</a></li>
                        </ul>
                    </nav>
                    <div class="nav-produtos-row"></div>
                </div>
                <div class="divisoria-1">
                    <div class="nome-marca-quantidade-modelo-lanceinicial">
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" value="<?=$_SESSION['old']['nome'] ?? ''?>" required>
                        </div>
                        <div class="mqml">
                            <div class="marca-quantidade">
                                <div class="marca">
                                    <label for="marca">Marca</label>
                                    <input type="text" name="marca" id="marca" value="<?=$_SESSION['old']['marca'] ?? ''?>" required>
                                </div>
                                <div class="quantidade">
                                    <label for="dimensoes">Dimensões</label>
                                     <select name="dimensoes" id="condicao-select" required>
                                        <option value="" <?=!isset($_SESSION['old']['dimensoes']) ? 'selected' : ''?> disabled></option>
                                        <option value="Grande" <?= ($_SESSION['old']['dimensoes'] ?? '') === 'Grande' ? 'selected' : '' ?>>Grande</option>
                                        <option value="Médio" <?= ($_SESSION['old']['dimensoes'] ?? '') === 'Médio' ? 'selected' : '' ?>>Médio</option>
                                        <option value="Pequeno" <?= ($_SESSION['old']['dimensoes'] ?? '') === 'Pequeno' ? 'selected' : '' ?>>Pequeno</option>
                                    </select>
                                </div>
                                <div class="quantidade">
                                    <label for="cor">Cor</label>
                                    <input type="text" name="cor" id="cor" value="<?=$_SESSION['old']['cor'] ?? ''?>" required>
                                </div>
                            </div>
                            <div class="modelo-lanceinicial">
                                <div class="modelo">
                                    <label for="materiais">Materiais</label>
                                    <input type="text" name="materiais" id="materias" value="<?=$_SESSION['old']['materiais'] ?? ''?>" required>
                                </div>
                                <div class="lanceinicial">
                                    <label for="lanceinicial">Lance inicial (R$)</label>
                                    <input type="number" name="lanceinicial" id="lanceinicial" value="<?=$_SESSION['old']['lanceinicial'] ?? ''?>" required step="any" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="condicao-imagem">
                        <div class="condicao">
                            <label for="condicao">Condição</label>
                             <select name="condicao" id="condicao-select" required>
                                <option value="" <?=!isset($_SESSION['old']['condicao']) ? 'selected' : ''?> disabled></option>
                                <option value="Novo" <?= ($_SESSION['old']['condicao'] ?? '') === 'Novo' ? 'selected' : '' ?>>Novo</option>
                                <option value="Usado (seminovo)" <?= ($_SESSION['old']['condicao'] ?? '') === 'Usado (seminovo)' ? 'selected' : '' ?>>Usado (seminovo)</option>
                                <option value="Recondicionado" <?= ($_SESSION['old']['condicao'] ?? '') === 'Recondicionado' ? 'selected' : '' ?>>Recondicionado</option>
                                <option value="Com defeito" <?= ($_SESSION['old']['condicao'] ?? '') === 'Com defeito' ? 'selected' : '' ?>>Com defeito</option>
                            </select>
                        </div>
                        <label for="foto" class="imagem imagem-resto" style="cursor: pointer;">
                            <img id="preview" src="css/svg/plus-2.svg">
                            <p style="text-align: center; font-weight: bold;">Clique para alterar a imagem</p>
                            <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" onchange="previewImagem(event)">
                        </label>
                        <script>
                            function previewImagem(event) {
                                const img = document.getElementById('preview');
                                img.src = URL.createObjectURL(event.target.files[0]);
                            }
                        </script>
                    </div>
                </div>
                <div class="divisoria-2">
                    <div class="informacoes-salvar-cancelar">
                        <div class="informacoes">
                            <label for="informacoes">Informações adicionais</label>
                            <textarea name="informacoes" id="informacoes"><?=$_SESSION['old']['informacoes'] ?? ''?></textarea>
                        </div>
                        <div class="salvar-cancelar">
                            <div class="salvar">
                                <button type="submit">Salvar</button>
                            </div>
                            <div class="cancelar">
                                <a href="tela-produtos.php">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>
</html>