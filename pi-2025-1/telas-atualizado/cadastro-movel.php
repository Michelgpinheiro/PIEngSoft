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

    $nome_usuario = $_SESSION['nome-usuario'];
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
        $categoria = "Móvel";

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

    $conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de móveis</title>
    <link rel="stylesheet" href="css/cadastro-movel/-style-cadastro-movel.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
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
                            <li style="margin-bottom: -1px;"><a  class="selected-nav-produto">Móvel</a></li>
                            <li><a class="not-selected" href="cadastro-outros.php">Outros</a></li>
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
                                    <!-- <input type="text" name="dimensoes" id="dimensoes" value="<?=$_SESSION['old']['dimensoes'] ?? ''?>" required> -->
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
                                    <input type="number" name="lanceinicial" id="lanceinicial" step="any" value="<?=$_SESSION['old']['lanceinicial'] ?? ''?>" required step="any" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="condicao-imagem">
                        <div class="condicao">
                            <label for="condicao">Condição</label>
                            <!-- <input type="text" name="condicao" id="condicao" value="<?=$_SESSION['old']['condicao'] ?? ''?>" required> -->
                             <select name="condicao" id="condicao-select" required>
                                <option value="" <?=!isset($_SESSION['old']['condicao']) ? 'selected' : ''?> disabled></option>
                                <option value="Novo" <?= ($_SESSION['old']['condicao'] ?? '') === 'Novo' ? 'selected' : '' ?>>Novo</option>
                                <option value="Usado (seminovo)" <?= ($_SESSION['old']['condicao'] ?? '') === 'Usado (seminovo)' ? 'selected' : '' ?>>Usado (seminovo)</option>
                                <option value="Recondicionado" <?= ($_SESSION['old']['condicao'] ?? '') === 'Recondicionado' ? 'selected' : '' ?>>Recondicionado</option>
                                <option value="Com defeito" <?= ($_SESSION['old']['condicao'] ?? '') === 'Com defeito' ? 'selected' : '' ?>>Com defeito</option>
                            </select>
                        </div>
                        <label for="foto" class="imagem imagem-resto" style="cursor: pointer;">
                            <img id="preview" src="css/svg/plus-2.svg" alt="Imagem de Perfil">
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