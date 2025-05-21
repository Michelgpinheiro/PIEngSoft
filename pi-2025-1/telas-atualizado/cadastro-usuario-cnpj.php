<?php

    session_start();

    require_once "connection.php";

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
            // Receber dados do formulário
            $usuario = new LegalEntity();

            $razao_social = $_POST['razao-social'] ?? '';
            $nome_fantasia = $_POST['nome-fantasia'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $estado = $_POST['estado'] ?? '';
            $cep = $_POST['cep'] ?? '';
            $bairro = $_POST['bairro'] ?? '';
            $numero = $_POST['numero'] ?? '';
            $endereco = $_POST['endereco'] ?? '';
            $complemento = $_POST['complemento'] ?? ''; // não usado no banco
            $cidade = $_POST['cidade'] ?? '';
            $usuario->setCnpj($_POST['cnpj'] ?? '');
            $usuario->setEmail($_POST['email'] ?? '');
            $usuario->setPassword(password_hash($senha, PASSWORD_DEFAULT));

            $stmt = $conn->prepare("INSERT INTO usuario (ID_TP_USU, RAZAO_SOCIAL, NOME_FANTASIA, CNPJ, FONE, LOGRADOURO, BAIRRO, NUMERO, UF, CIDADE, EMAIL, SENHA, ST_USUARIO) VALUES (2, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");

            $stmt->bind_param("sssssssssss", $razao_social, $nome_fantasia, $usuario->getCnpj(), $telefone, $endereco, $bairro, $numero, $estado, $cidade, $usuario->getEmail(), $usuario->getPassword());

            if ($stmt->execute()) {

                if ($stmt->affected_rows > 0) {
                    $id_usuario = $stmt->insert_id;

                    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                        $fotoTmp = $_FILES['foto']['tmp_name'];
    
                        $nomeOriginal = $_FILES['foto']['name'];
                        // $ext = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
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

                // $_SESSION['cadastro-sucesso'] = "<p><i class='material-icons'>check_circle</i> Cadastro realizado com sucesso</p>";

                $_SESSION['cadastro-sucesso'] = true;
                $_SESSION['email-usuario'] = $usuario->getEmail();
                $_SESSION['senha-usuario'] = $senha;
                $_SESSION['nome-fantasia'] = $nome_fantasia;

                unset($_SESSION['old']);

                header('Location: login.php');
                exit;
            } else {
               $_SESSION['erro-cadastro'] = "<p><i class='material-icons'>error</i> Ocorreu um ao cadastrar</p>";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
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
    <title>Cadastro Usuario CNPJ</title>
    <link rel="stylesheet" href="css/cadastro-usuario-cnpj/style-cadastro-usuario-cnpj.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/estilizacao-geral.css">
    <link rel="stylesheet" href="css/-estilizacao-geral.css">
</head>
<body>
    <section class="banner-esquerdo">
        <h1>Seja bem-vindo</h1>
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

            if (isset($_SESSION['foto-nao-definida'])) {
                ?>
                <div class="mensagem-sem-foto" id="mensagem-sem-foto" style="margin-top: 10px;">
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
    </section>
    <section class="secao-principal">
        <section class="formulario formulario-cadastros form-cadastros">
            <div class="cabecalho">
                <h2>Cadastro de usuário</h2>
                <div class="pessoa-juridica-fisica">
                    <div class="juridica juridica-fisica cnpj">Pessoa jurídica</div>
                    <a href="cadastro-usuario-cpf.php" class="fisica juridica-fisica cpf">Pessoa física</a>
                </div>
                <div class="separador"></div>
            </div>
            <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" class="form-cadastros">

                <div class="div1">
                    <div class="nome-telefone-cpf">
                        <div class="razao">
                            <label for="razao-social">Razão social</label>
                            <input type="text" name="razao-social" id="razao-social"  value="<?=$_SESSION['old']['razao-social'] ?? ''?>" required>
                        </div>
                        <div class="fantasia">
                            <label for="nome-fantasia">Nome fantasia</label>
                            <input type="text" name="nome-fantasia" id="nome-fantasia" value="<?=$_SESSION['old']['nome-fantasia'] ?? ''?>" required>
                        </div>
                    </div>
                    <!-- <div class="imagem-perfil">
                        <img src="imagens/Greek_uc_pi.svg" alt="">
                        <p style="text-align: center; font-weight:bold;">Imagem de perfil</p>
                    </div> -->

                    <label for="foto" class="imagem-perfil" style="cursor: pointer;">
                        <img id="preview" src="imagens/Greek_uc_pi.svg" alt="Imagem de Perfil">
                        <p style="text-align: center; font-weight: bold; margin-top: -25px;">Clique para alterar a imagem</p>
                        <input type="file" id="foto" name="foto" accept="image/*" style="display: none;" onchange="previewImagem(event)">
                    </label>
                    <script>
                        function previewImagem(event) {
                            const img = document.getElementById('preview');
                            img.src = URL.createObjectURL(event.target.files[0]);
                        }
                    </script>
                </div>

                <div class="div2">
                    <div class="cnpj">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" value="<?=$_SESSION['old']['cnpj'] ?? ''?>" required>
                    </div>
                    <div class="telefone">
                        <label for="telefone">Telefone</label>
                        <input type="tel" name="telefone" id="telefone" value="<?=$_SESSION['old']['telefone'] ?? ''?>" required>
                    </div>
                </div>

                <div class="div3">
                    <div class="estado-cep-bairro-numero">
                        <div class="estado-cep">
                            <div class="estado">
                                <label for="estado">Estado</label>
                                <!-- <input type="text" name="estado" id="estado" value="<?=$_SESSION['old']['estado'] ?? ''?>" required> -->
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
                        <button class="enviar-cadastro" type="submit">Avançar</button>
                        <a class="cancelar-cadastro" href="login.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </section>
    </section>
</body>
</html>