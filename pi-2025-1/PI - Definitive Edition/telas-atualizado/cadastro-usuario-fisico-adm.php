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

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $_SESSION['old'] = $_POST;

        if ((!isset($_FILES['foto']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK)) {
            $_SESSION['foto-nao-definida'] = "<p><i class='material-icons'>warning</i> Anexe uma foto antes de prosseguir</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmarsenha'] ?? '';

        // Verificar se o email a ser cadastrado já foi cadastrado
        $stmt_email = $conn->prepare("SELECT ID FROM usuario WHERE EMAIL = ?");
        $stmt_email->bind_param("s", $email);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();

        if ($result_email->num_rows > 0) {
            $_SESSION['email-ja-cadastrado'] = "<p><i class='material-icons'>error</i> Esse email já está cadastrado</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        $stmt_email->close();

        // Validar senha
        if ($senha !== $confirmarSenha) {
            $_SESSION['senhas-nao-coincidem'] = "<p><i class='material-icons'>error</i> As senhas não coincidem</p>";
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {

             function removerAcentos($string) {
                return preg_replace(
                    array(
                        '/[áàãâä]/u', '/[ÁÀÃÂÄ]/u',
                        '/[éèêë]/u', '/[ÉÈÊË]/u',
                        '/[íìîï]/u', '/[ÍÌÎÏ]/u',
                        '/[óòõôö]/u', '/[ÓÒÕÔÖ]/u',
                        '/[úùûü]/u', '/[ÚÙÛÜ]/u',
                        '/[ç]/u',    '/[Ç]/u'
                    ),
                    array(
                        'a', 'A',
                        'e', 'E',
                        'i', 'I',
                        'o', 'O',
                        'u', 'U',
                        'c', 'C'
                    ),
                    $string
                );
            }

            if(isset($_POST['e-adm'])) {

                $usuario = new LegalEntity();

                $usuario->setCnpj($_POST['cpf'] ?? '');

                $stmt_cpf = $conn->prepare("SELECT ID FROM usuario WHERE CPF = ?");
                $stmt_cpf->bind_param("s", $usuario->getCnpj());
                $stmt_cpf->execute();
                $result_cpf = $stmt_cpf->get_result();

                if ($result_cpf->num_rows > 0) {
                    $_SESSION['cpf-igual'] = "<p><i class='material-icons'>error</i> O CPF já pertence a uma conta cadastrada</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }

                $nome_fantasia = $_POST['nome-completo'] ?? '';
                $telefone = $_POST['telefone'] ?? '';
                $estado = $_POST['estado'] ?? '';
                $cep = $_POST['cep'] ?? '';
                $bairro = $_POST['bairro'] ?? '';
                $numero = $_POST['numero'] ?? '';
                $endereco = $_POST['endereco'] ?? '';
                $complemento = $_POST['complemento'] ?? ''; // não usado no banco
                $cidade = $_POST['cidade'] ?? '';
                $usuario->setEmail($_POST['email'] ?? '');
                $usuario->setPassword(password_hash($senha, PASSWORD_DEFAULT));
                $pergunta_senha1 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-cidade-mae-nasceu']))
                    ), PASSWORD_DEFAULT
                );
                $pergunta_senha2 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-estimacao-primeiro-nome']))
                    ), PASSWORD_DEFAULT
                );
                $pergunta_senha3 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-professor-favorito']))
                    ), PASSWORD_DEFAULT
                );

                $stmt = $conn->prepare("INSERT INTO usuario (ID_TP_USU, ID_USU_PAI, NOME, CPF, FONE, LOGRADOURO, BAIRRO, NUMERO, UF, CIDADE, EMAIL, SENHA, PERGUNTA_1, PERGUNTA_2, PERGUNTA_3, ST_USUARIO) VALUES (2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

                $stmt->bind_param("isssssssssssss", $id_usuario, $nome_fantasia, $usuario->getCnpj(), $telefone, $endereco, $bairro, $numero, $estado, $cidade, $usuario->getEmail(), $usuario->getPassword(), $pergunta_senha1, $pergunta_senha2, $pergunta_senha3);

                if ($stmt->execute()) {

                    if ($stmt->affected_rows > 0) {
                        $id_usuario = $stmt->insert_id;

                        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                            $fotoTmp = $_FILES['foto']['tmp_name'];
        
                            $nomeOriginal = $_FILES['foto']['name'];
                            $nomeFoto = "perfil_" . $id_usuario . ".jpg";
                            $caminhoDestino = "imagens/perfis/" . $nomeFoto;
        
                            // Salvar a imagem
                            move_uploaded_file($fotoTmp, $caminhoDestino);
        
                            // 3. Atualizar usuário com o caminho da foto
                            $stmtFoto = $conn->prepare("UPDATE usuario SET FOTO = ? WHERE ID = ?");
                            $stmtFoto->bind_param("si", $caminhoDestino, $id_usuario);
                            $stmtFoto->execute();
                            $stmtFoto->close();
                        }
                    } 

                    $tipo = "Cadastro de usuário";

                    $stmt_movimentacao = $conn->prepare("INSERT INTO movimentacao (ID_USUARIO, TIPO_MOVIMENTACAO, NOME_CADASTRADO, GRAU) VALUES (?, ?, ?, 2)");
                    $stmt_movimentacao->bind_param("iss", $_SESSION['id-usuario'], $tipo, $nome);
                    $stmt_movimentacao->execute();
                    $stmt_movimentacao->close();

                    $_SESSION['cadastro-sucesso'] = "<p><i class='material-icons'>check_circle</i> Cadastro de usuário realizado com sucesso</p>";

                    unset($_SESSION['old']);

                    header('Location: listagem-usuarios-adm.php');
                    exit;
                } else {
                    $_SESSION['erro-cadastro'] = "<p><i class='material-icons'>error</i> Ocorreu um ao cadastrar</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            } else {

                $usuario = new PhysicalPerson();

                $usuario->setCpf($_POST['cpf'] ?? '');

                $stmt_cpf = $conn->prepare("SELECT ID FROM usuario WHERE CPF = ?");
                $stmt_cpf->bind_param("s", $usuario->getCpf());
                $stmt_cpf->execute();
                $result_cpf = $stmt_cpf->get_result();

                if ($result_cpf->num_rows > 0) {
                    $_SESSION['cpf-igual'] = "<p><i class='material-icons'>error</i> O CPF já pertence a uma conta cadastrada</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
    
                $nome = $_POST['nome-completo'] ?? '';
                $telefone = $_POST['telefone'] ?? '';
                $estado = $_POST['estado'] ?? '';
                $cep = $_POST['cep'] ?? '';
                $bairro = $_POST['bairro'] ?? '';
                $numero = $_POST['numero'] ?? '';
                $endereco = $_POST['endereco'] ?? '';
                $complemento = $_POST['complemento'] ?? ''; // não usado no banco
                $cidade = $_POST['cidade'] ?? '';
                $usuario->setCpf($_POST['cpf'] ?? '');
                $usuario->setRg($_POST['rg'] ?? '');
                $usuario->setEmail($_POST['email'] ?? '');
                $usuario->setPassword(password_hash($senha, PASSWORD_DEFAULT));
                $pergunta_senha1 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-cidade-mae-nasceu']))
                    ), PASSWORD_DEFAULT
                );
                $pergunta_senha2 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-estimacao-primeiro-nome']))
                    ), PASSWORD_DEFAULT
                );
                $pergunta_senha3 = password_hash(
                    htmlspecialchars(
                        mb_strtolower(removerAcentos($_POST['recuperar-senha-professor-favorito']))
                    ), PASSWORD_DEFAULT
                );
    
                $stmt = $conn->prepare("INSERT INTO usuario (ID_TP_USU, ID_USU_PAI, NOME, CPF, RG, FONE, LOGRADOURO, BAIRRO, NUMERO, UF, CIDADE, EMAIL, SENHA, PERGUNTA_1, PERGUNTA_2, PERGUNTA_3, ST_USUARIO)
                    VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    
                $stmt->bind_param("issssssssssssss", $id_usuario, $nome, $usuario->getCpf(), $usuario->getRg(), $telefone, $endereco, $bairro, $numero, $estado, $cidade, $usuario->getEmail(), $usuario->getPassword(), $pergunta_senha1, $pergunta_senha2, $pergunta_senha3);
    
                if ($stmt->execute()) {
    
                    if ($stmt->affected_rows > 0) {
                        $id_usuario = $stmt->insert_id;
    
                        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                            $fotoTmp = $_FILES['foto']['tmp_name'];
        
                            $nomeOriginal = $_FILES['foto']['name'];
                            $nomeFoto = "perfil_" . $id_usuario . ".jpg";
                            $caminhoDestino = "imagens/perfis/" . $nomeFoto;
        
                            // Salvar a imagem
                            move_uploaded_file($fotoTmp, $caminhoDestino);
        
                            // 3. Atualizar usuário com o caminho da foto
                            $stmtFoto = $conn->prepare("UPDATE usuario SET FOTO = ? WHERE ID = ?");
                            $stmtFoto->bind_param("si", $caminhoDestino, $id_usuario);
                            $stmtFoto->execute();
                            $stmtFoto->close();
                        }
                    } 

                    $tipo = "Cadastro de usuário";

                    $stmt_movimentacao = $conn->prepare("INSERT INTO movimentacao (ID_USUARIO, TIPO_MOVIMENTACAO, NOME_CADASTRADO, GRAU) VALUES (?, ?, ?, 1)");
                    $stmt_movimentacao->bind_param("iss", $_SESSION['id-usuario'], $tipo, $nome);
                    $stmt_movimentacao->execute();
                    $stmt_movimentacao->close();
    
                    $_SESSION['cadastro-sucesso'] = "<p><i class='material-icons'>check_circle</i> Cadastro de usuário realizado com sucesso</p>";
    
                    // $_SESSION['cadastro-sucesso'] = true;
                    $_SESSION['email-usuario'] = $usuario->getEmail();
                    $_SESSION['senha-usuario'] = $senha;
                    $_SESSION['nome-usuario'] = $nome;
    
                    unset($_SESSION['old']);
    
                    header('Location: listagem-usuarios-adm.php');
                    exit;
                } else {
                    $_SESSION['erro-cadastro'] = "<p><i class='material-icons'>error</i> Ocorreu um ao cadastrar</p>";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                }
            }

            $stmt->close();
        } 
    }

    $conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário físico</title>
    <link rel="stylesheet" href="css/cadastro-usuario-fisico-adm/-style-cadastro-usuario-fisico-adm.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/-estilizacao-geral.css??v=<?=time()?>">
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
                <!-- <li><a href="tela-produtos-adm.php">Produtos</a></li> -->
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
            <section class="secao-principal">
                <section style="margin-bottom: 30px;" class="formulario formulario-cadastros">
                <div class="cabecalho">
                    <h2>Cadastro de usuário</h2>
                    <?php 
                        if (isset($_SESSION['senhas-nao-coincidem'])) {
                            ?>
                            <div class="mensagem-erro" id="mensagem-erro">
                                <?=$_SESSION['senhas-nao-coincidem']?>
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
                            unset($_SESSION['senhas-nao-coincidem']);
                        }

                        if (isset($_SESSION['erro-cadastro'])) {
                            ?>
                            <div class="mensagem-erro" id="mensagem-erro">
                                <?=$_SESSION['erro-cadastro']?>
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
                            unset($_SESSION['erro-cadastro']);
                        }
                        
                        if (isset($_SESSION['email-ja-cadastrado'])) {
                            ?>
                            <div class="mensagem-erro" id="mensagem-erro">
                                <?=$_SESSION['email-ja-cadastrado']?>
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
                            unset($_SESSION['email-ja-cadastrado']);
                        }

                        if (isset($_SESSION['cpf-igual'])) {
                            ?>
                            <div class="mensagem-erro" id="mensagem-erro">
                                <?=$_SESSION['cpf-igual']?>
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
                            unset($_SESSION['cpf-igual']);
                        }

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
                    <div class="pessoa-juridica-fisica">
                        <a class="juridica juridica-fisica" href="cadastro-usuario-juridico-adm.php">Pessoa jurídica</a>
                        <div class="fisica juridica-fisica">Pessoa física</div>
                    </div>
                    <div class="separador"></div>
                </div>
                <form style="background-color: #8a3e2c;" action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" class="form-cadastros" id="form-cadastros">

                    <div class="div1">
                        <div class="nome-telefone-cpf">
                            <div class="nome">
                                <label for="nome-completo">Nome Completo</label>
                                <input type="text" name="nome-completo" id="nome-completo" value="<?=$_SESSION['old']['nome-completo'] ?? ''?>" required>
                            </div>
                            <div class="cpf-telefone">
                                <div class="cpf">
                                    <label for="cpf">CPF</label>
                                    <input type="text" name="cpf" id="cpf" value="<?=$_SESSION['old']['cpf'] ?? ''?>" required>
                                </div>
                                <div class="telefone phone">
                                    <label for="telefone">Telefone</label>
                                    <input type="tel" name="telefone" id="telefone" value="<?=$_SESSION['old']['telefone'] ?? ''?>" required>
                                </div>
                            </div>
                        </div>
                            <label for="foto" class="imagem-perfil cpf-img" style="cursor: pointer; height: 135px;">
                            <img id="preview" src="imagens/Pi-symbol.svg.png" alt="Imagem de Perfil">
                            <p style="text-align: center; font-weight: bold; margin-top: 3px;">Clique para alterar a imagem</p>
                            <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" onchange="previewImagem(event)">
                        </label>
                        <script>
                            function previewImagem(event) {
                                const img = document.getElementById('preview');
                                img.src = URL.createObjectURL(event.target.files[0]);
                            }
                        </script>
                    </div>
                    <div class="div3">
                        <div class="estado-cep-bairro-numero">
                            <div class="estado-cep">
                                <div class="estado">
                                    <label for="estado">Estado</label>
                                    <select name="estado" id="estado" style="background-color: #fff0ce;  padding: 7px; border-radius: 12px; border-color: #fff0ce;" required>
                                        <option value="" <?=!isset($_SESSION['old']['estado']) ? 'selected' : ''?>></option>
                                        <option value="Acre" <?= ($_SESSION['old']['estado'] ?? '') === 'Acre' ? 'selected' : '' ?>>Acre</option>
                                        <option value="Alagoas" <?= ($_SESSION['old']['estado'] ?? '') === 'Alagoas' ? 'selected' : '' ?>>Alagoas</option>
                                        <option value="Amapá" <?= ($_SESSION['old']['estado'] ?? '') === 'Amapá' ? 'selected' : '' ?>>Amapá</option>
                                        <option value="Amazonas" <?= ($_SESSION['old']['estado'] ?? '') === 'Amazonas' ? 'selected' : '' ?>>Amazonas</option>
                                        <option value="Bahia" <?= ($_SESSION['old']['estado'] ?? '') === 'Bahia' ? 'selected' : '' ?>>Bahia</option>
                                        <option value="Ceará" <?= ($_SESSION['old']['estado'] ?? '') === 'Ceará' ? 'selected' : '' ?>>Ceará</option>
                                        <option value="Distrito Federal" <?= ($_SESSION['old']['estado'] ?? '') === 'Distrito Federal' ? 'selected' : '' ?>>Distrito Federal</option>
                                        <option value="Espírito Santo" <?= ($_SESSION['old']['estado'] ?? '') === 'Espírito Santo' ? 'selected' : '' ?>>Espírito Santo</option>
                                        <option value="Goiás" <?= ($_SESSION['old']['estado'] ?? '') === 'Goiás' ? 'selected' : '' ?>>Goiás</option>
                                        <option value="Maranhão" <?= ($_SESSION['old']['estado'] ?? '') === 'Maranhão' ? 'selected' : '' ?>>Maranhão</option>
                                        <option value="Mato Grosso" <?= ($_SESSION['old']['estado'] ?? '') === 'Mato Grosso' ? 'selected' : '' ?>>Mato Grosso</option>
                                        <option value="Mato Grosso do Sul" <?= ($_SESSION['old']['estado'] ?? '') === 'Mato Grosso do Sul' ? 'selected' : '' ?>>Mato Grosso do Sul</option>
                                        <option value="Minas Gerais" <?= ($_SESSION['old']['estado'] ?? '') === 'Minas Gerais' ? 'selected' : '' ?>>Minas Gerais</option>
                                        <option value="Pará" <?= ($_SESSION['old']['estado'] ?? '') === 'Pará' ? 'selected' : '' ?>>Pará</option>
                                        <option value="Paraíba" <?= ($_SESSION['old']['estado'] ?? '') === 'Paraíba' ? 'selected' : '' ?>>Paraíba</option>
                                        <option value="Paraná" <?= ($_SESSION['old']['estado'] ?? '') === 'Paraná' ? 'selected' : '' ?>>Paraná</option>
                                        <option value="Pernambuco" <?= ($_SESSION['old']['estado'] ?? '') === 'Pernambuco' ? 'selected' : '' ?>>Pernambuco</option>
                                        <option value="Piauí" <?= ($_SESSION['old']['estado'] ?? '') === 'Piauí' ? 'selected' : '' ?>>Piauí</option>
                                        <option value="Rio de Janeiro" <?= ($_SESSION['old']['estado'] ?? '') === 'Rio de Janeiro' ? 'selected' : '' ?>>Rio de Janeiro</option>
                                        <option value="Rio Grande do Norte" <?= ($_SESSION['old']['estado'] ?? '') === 'Rio Grande do Norte' ? 'selected' : '' ?>>Rio Grande do Norte</option>
                                        <option value="Rio Grande do Sul" <?= ($_SESSION['old']['estado'] ?? '') === 'Rio Grande do Sul' ? 'selected' : '' ?>>Rio Grande do Sul</option>
                                        <option value="Rondônia" <?= ($_SESSION['old']['estado'] ?? '') === 'Rondônia' ? 'selected' : '' ?>>Rondônia</option>
                                        <option value="Roraima" <?= ($_SESSION['old']['estado'] ?? '') === 'Roraima' ? 'selected' : '' ?>>Roraima</option>
                                        <option value="Santa Catarina" <?= ($_SESSION['old']['estado'] ?? '') === 'Santa Catarina' ? 'selected' : '' ?>>Santa Catarina</option>
                                        <option value="São Paulo" <?= ($_SESSION['old']['estado'] ?? '') === 'São Paulo' ? 'selected' : '' ?>>São Paulo</option>
                                        <option value="Sergipe" <?= ($_SESSION['old']['estado'] ?? '') === 'Sergipe' ? 'selected' : '' ?>>Sergipe</option>
                                        <option value="Tocantins" <?= ($_SESSION['old']['estado'] ?? '') === 'Tocantins' ? 'selected' : '' ?>>Tocantins</option>
                                    </select>
                                </div>
                                <div class="cep">
                                    <label for="cep">CEP</label>
                                    <input type="text" name="cep" id="cep" value="<?=$_SESSION['old']['cep'] ?? ''?>" required>
                                </div>
                            </div>
                            <div class="bairro-numero">
                                <div class="bairro">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" id="bairro" value="<?=$_SESSION['old']['bairro'] ?? ''?>" required>
                                </div>
                                <div class="numero">
                                    <label for="numero">Número</label>
                                    <input type="text" name="numero" id="numero" value="<?=$_SESSION['old']['numero'] ?? ''?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="endereco-complemento-cidade">
                            <div class="endereco">
                                <label for="endereco">Endereço</label>
                                <input type="text" name="endereco" id="endereco" value="<?=$_SESSION['old']['endereco'] ?? ''?>" required>
                            </div>
                            <div class="complemento-cidade">
                                <div class="complemento">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" name="complemento" id="complemento" value="<?=$_SESSION['old']['complemento'] ?? ''?>">
                                </div>
                                <div class="cidade">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" name="cidade" id="cidade" value="<?=$_SESSION['old']['cidade'] ?? ''?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="div4">
                        <div class="email-senha-confirmarsenha">
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="<?=$_SESSION['old']['email'] ?? ''?>" required>
                            </div>
                            <div class="senha-confirmarsenha">
                                <div class="senha">
                                    <label for="senha">Senha</label>
                                    <input type="password" name="senha" id="senha" value="<?=$_SESSION['old']['senha'] ?? ''?>" required>
                                </div>
                                <div class="confirmarsenha">
                                    <label for="confirmarsenha">Confirmar senha</label>
                                    <input type="password" name="confirmarsenha" id="confirmarsenha" value="<?=$_SESSION['old']['confirmarsenha'] ?? ''?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="avancar-cancelar salvar-cancelar">
                            <label for="e-adm" class="e-admin">
                                <input type="checkbox" name="e-adm" id="e-adm">
                                <p>Administração</p>
                            </label>
                            <button class="enviar-cadastro" id="btn-abrir-popup" type="button">Avançar</button>
                            <a class="cancelar-cadastro" href="listagem-usuarios-adm.php">Cancelar</a>
                        </div>

                        <div id="popup" class="popup">
                            <div class="popup-conteudo">
                                <span id="btn-fechar-popup" class="fechar">&times;</span>
                                <h2>Preencha essas informações</h2>
                                <p style="margin-bottom: 20px; text-align: center; font-size: 15px; color: #fff0ce;">Elas servirão para recuperar a senha do usuário cadastrado caso o mesmo esqueça eventualmente</p>

                                <form action="#" method="POST">
                                    <label for="recuperar-senha-cidade-mae-nasceu">Em qual cidade a mãe dele nasceu?</label>
                                    <input required type="text" name="recuperar-senha-cidade-mae-nasceu" value="<?=$_SESSION['old']['recuperar-senha-cidade-mae-nasceu'] ?? ''?>"><br>
                                    <label for="recuperar-senha-estimacao-primeiro-nome">Qual o nome do primeiro animal de estimação dele?</label>
                                    <input required type="text" name="recuperar-senha-estimacao-primeiro-nome" value="<?=$_SESSION['old']['recuperar-senha-estimacao-primeiro-nome'] ?? ''?>"><br>
                                    <label for="recuperar-senha-professor-favorito">Qual nome do professor favorito dele?</label>
                                    <input required type="text" name="recuperar-senha-professor-favorito" value="<?=$_SESSION['old']['recuperar-senha-professor-favorito'] ?? ''?>"><br><br>
                                    
                                    <button class="enviar-cadastro1" type="submit">Cadastrar</button>
                                </form>
                            </div>
                        </div>
                        <div id="popup-cep2" style="
                            display: flex;
                            align-items: center;
                            position: fixed;
                            top: 40px;
                            right: 480px;
                            background-color: yellow;
                            color: darkgoldenrod;
                            border: 2px solid darkgoldenrod;
                            gap: 8px;
                            padding: 10px;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0,0,0,0.3);
                            z-index: 9999;
                            display: none;
                            font-weight: bold;
                        ">
                            <i style="transform: scale(1.2);" class='material-icons'>warning</i>
                            <span id="pop-up-message2"></span>
                        </div>
                        <div id="popup-cep3" style="
                            display: flex;
                            align-items: center;
                            position: fixed;
                            top: 90px; 
                            left: 600px;
                            background-color: yellow;
                            color: darkgoldenrod;
                            border: 2px solid darkgoldenrod;
                            gap: 8px;
                            padding: 10px;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0,0,0,0.3);
                            z-index: 9999;
                            display: none;
                            font-weight: bold;
                        ">
                            <i style="transform: scale(1.2);" class='material-icons'>warning</i>
                            <span id="pop-up-message3"></span>
                        </div>
                        <div id="popup-cep" style="
                            display: flex;
                            align-items: center;
                            position: fixed;
                            top: 90px;
                            right: 400px;
                            background-color: yellow;
                            color: darkgoldenrod;
                            border: 2px solid darkgoldenrod;
                            gap: 8px;
                            padding: 10px;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0,0,0,0.3);
                            z-index: 9999;
                            display: none;
                            font-weight: bold;
                        ">
                            <i style="transform: scale(1.2);" class='material-icons'>warning</i>
                            <span id="pop-up-message"></span>
                        </div>
                        <script>
                            const btnAbrir = document.getElementById('btn-abrir-popup');
                            const popup = document.getElementById('popup');
                            const btnFechar = document.getElementById('btn-fechar-popup');

                            btnAbrir.onclick = function() {
                                popup.style.display = "block";
                            }

                            btnFechar.onclick = function() {
                                popup.style.display = "none";
                            }

                            // Fechar clicando fora do popup
                            window.onclick = function(event) {
                                if (event.target == popup) {
                                    popup.style.display = "none";
                                }
                            }

                            function validarCPF(cpf) {
                            cpf = cpf.replace(/[^\d]+/g, ''); // Remove tudo que não for número

                            if (cpf.length !== 11) return false;

                            // Elimina CPFs inválidos conhecidos (todos iguais)
                            if (/^(\d)\1{10}$/.test(cpf)) return false;

                            // Validação do primeiro dígito verificador
                            let soma = 0;
                            for (let i = 0; i < 9; i++) {
                                soma += parseInt(cpf.charAt(i)) * (10 - i);
                            }
                            let resto = (soma * 10) % 11;
                            if (resto === 10 || resto === 11) resto = 0;
                            if (resto !== parseInt(cpf.charAt(9))) return false;

                            // Validação do segundo dígito verificador
                            soma = 0;
                            for (let i = 0; i < 10; i++) {
                                soma += parseInt(cpf.charAt(i)) * (11 - i);
                            }
                            resto = (soma * 10) % 11;
                            if (resto === 10 || resto === 11) resto = 0;
                            if (resto !== parseInt(cpf.charAt(10))) return false;

                            return true;
                        }

                        document.getElementById('cpf').addEventListener('blur', function() {
                            const cpf = this.value;
                            if (!validarCPF(cpf)) {
                                showPopupErroCPF('CPF inválido!');
                            }
                        });

                        function showPopupErroCep(message) {
                            const popup = document.getElementById('popup-cep2');
                            const messageSpan = document.getElementById('pop-up-message2');

                            messageSpan.textContent = message;
                            popup.style.display = 'flex';
                            popup.style.opacity = '1';
                            popup.style.transition = 'opacity 1s ease';

                            setTimeout(() => {
                                popup.style.opacity = '0';
                                setTimeout(() => {
                                    popup.style.display = 'none';
                                }, 300); // Espera o fade-out (1 segundo) antes de sumir completamente
                            }, 3000); // Mantém visível por 3 segundos antes de começar o fade-out
                        }

                        function showPopup(message) {
                            const popup = document.getElementById('popup-cep');
                            const messageSpan = document.getElementById('pop-up-message');

                            messageSpan.textContent = message;
                            popup.style.display = 'flex';
                            popup.style.opacity = '1';
                            popup.style.transition = 'opacity 1s ease';

                            setTimeout(() => {
                                popup.style.opacity = '0';
                                setTimeout(() => {
                                    popup.style.display = 'none';
                                }, 300); // Espera o fade-out (1 segundo) antes de sumir completamente
                            }, 3000); // Mantém visível por 3 segundos antes de começar o fade-out
                        }

                        function showPopupErroCPF(message) {
                            const popup = document.getElementById('popup-cep3');
                            const messageSpan = document.getElementById('pop-up-message3');

                            messageSpan.textContent = message;
                            popup.style.display = 'flex';
                            popup.style.opacity = '1';
                            popup.style.transition = 'opacity 1s ease';

                            setTimeout(() => {
                                popup.style.opacity = '0';
                                setTimeout(() => {
                                    popup.style.display = 'none';
                                }, 300); // Espera o fade-out (1 segundo) antes de sumir completamente
                            }, 3000); // Mantém visível por 3 segundos antes de começar o fade-out
                        }

                        const estados = {
                            'AC': 'Acre',
                            'AL': 'Alagoas',
                            'AP': 'Amapá',
                            'AM': 'Amazonas',
                            'BA': 'Bahia',
                            'CE': 'Ceará',
                            'DF': 'Distrito Federal',
                            'ES': 'Espírito Santo',
                            'GO': 'Goiás',
                            'MA': 'Maranhão',
                            'MT': 'Mato Grosso',
                            'MS': 'Mato Grosso do Sul',
                            'MG': 'Minas Gerais',
                            'PA': 'Pará',
                            'PB': 'Paraíba',
                            'PR': 'Paraná',
                            'PE': 'Pernambuco',
                            'PI': 'Piauí',
                            'RJ': 'Rio de Janeiro',
                            'RN': 'Rio Grande do Norte',
                            'RS': 'Rio Grande do Sul',
                            'RO': 'Rondônia',
                            'RR': 'Roraima',
                            'SC': 'Santa Catarina',
                            'SP': 'São Paulo',
                            'SE': 'Sergipe',
                            'TO': 'Tocantins'
                        };

                        let cep_valido = false;

                        document.getElementById('cep').addEventListener('blur', function() {
                            const cep = this.value.replace(/\D/g, '');

                            if (cep.length !== 8) {
                                showPopup("CEP inválido. Insira 8 dígitos.");
                                cep_valido = false;
                                return;
                            }

                            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.erro) {
                                        showPopup('CEP não encontrado!');
                                        cep_valido = false;
                                        return;
                                    }
                                    document.getElementById('endereco').value = data.logradouro;
                                    document.getElementById('bairro').value = data.bairro;
                                    document.getElementById('cidade').value = data.localidade;
                                    document.getElementById('estado').value = estados[data.uf];
                                    cep_valido = true;
                                })
                            .catch(() => {
                                showPopup('Erro ao buscar o CEP. Verifique sua conexão.');
                                cep_valido = false;
                            });
                        });

                        document.getElementById('form-cadastros').addEventListener('submit', function(event) {
                            if (!cep_valido) {
                                event.preventDefault();
                                showPopupErroCep('Insira um CEP válido antes de cadastrar');
                            }
                        });

                        document.getElementById('form-cadastros').addEventListener('submit', function(event) {
                            const cpf = document.getElementById('cpf').value;

                            if (!validarCPF(cpf)) {
                                event.preventDefault(); // Impede o envio do formulário
                                showPopupErroCep('Insira um CPF válido antes de cadastrar');
                                // document.getElementById('cpf').focus();
                            }
                        });
                        
                        </script>
                    </div>
                </form>
            </section>
        </section>
    </main>
</body>
</html>