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

    if (isset($_GET['id'])) {
        $id_usuario_visto = $_GET['id'];
    }

    $stmt = $conn->prepare(
        "SELECT * FROM usuario 
        --  INNER JOIN movimentacao ON movimentacao.ID_USUARIO = usuario.ID
         WHERE ID = ?
    ");
    $stmt->bind_param("i", $id_usuario_visto);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    while ($row = $result->fetch_assoc()) {
        $nome_completo_usuario = $row['NOME'];
        $nome_fantasia_usuario = $row['NOME_FANTASIA'];
        $razao_social_usuario = $row['RAZAO_SOCIAL'];
        $cnpj_usuario = $row['CNPJ'];
        $cpf_usuario = $row['CPF'];
        $telefone_usuario = $row['FONE'];
        $logradouro_usuario = $row['LOGRADOURO'];
        $bairro_usurio = $row['BAIRRO'];
        $numero_usuario = $row['NUMERO'];
        $uf_usuario = $row['UF'];
        $cidade_usuario = $row['CIDADE'];
        $email_usuario = $row['EMAIL'];
        $situacao_usuario = $row['ST_USUARIO'];
        $foto_usuario = $row['FOTO'];
        $id_usuario_pai = $row['ID_USU_PAI'];
    }

    if (isset($id_usuario_pai)) {
        $stmt = $conn->prepare("SELECT NOME FROM usuario WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario_pai);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $nome_usuario_pai = $row['NOME'];
        }
    }

    if ($situacao_usuario == 1) {
        $situacao_usuario_string = "Ativo";
    } else {
        $situacao_usuario_string = "Suspenso";
    }

    // $conn->close();

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
                <section class="formulario formulario-cadastros historico">
                <div class="cabecalho">
                    <h2>Informações do Usuário</h2>
                    <a class="voltar" href="listagem-usuarios-adm.php">
                        <img style="margin-top: -80px; margin-left: 20px;" src="css/svg/arrow-left.svg" alt="">
                    </a>
                    <div class="info-gerais-usuario-foto-movimentacoes">
                        <div class="info-gerais-usuario">
                            <div class="nome-cpf-telefone-usuario">
                                <?php if (!empty($nome_fantasia_usuario)): ?>
                                <div class="nome">
                                    <label for="nome-completo-usuario">Nome Fantasia do Usuário</label>
                                    <p><?=$nome_fantasia_usuario?></p>
                                </div>
                                <?php else: ?>
                                <div class="nome">
                                    <label for="nome-completo-usuario">Nome Completo do Usuário</label>
                                    <p><?=$nome_completo_usuario?></p>
                                </div>
                                <?php endif; ?>
                                <div class="cpf-telefone-usuario">
                                    <?php if (!empty($cnpj_usuario)): ?>
                                    <div class="cpf-usuario">
                                        <label for="cnpj">CNPJ</label>
                                        <p><?=$cnpj_usuario?></p>
                                    </div>
                                    <?php else: ?>
                                    <div class="cpf-usuario">
                                        <label for="cpf">CPF</label>
                                        <p><?=$cpf_usuario?></p>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (isset($razao_social_usuario)): ?>
                                    <div class="nome" style="margin-top: 20px;">
                                        <label for="nome-completo-usuario">Razão Social</label>
                                        <p><?=$razao_social_usuario?></p>
                                    </div>
                                    <?php endif; ?>
                                    <div class="telefone-usuario">
                                        <label for="telefone">Telefone</label>
                                        <p><?=$telefone_usuario?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="logradoura-bairro-numero-uf-usuario">
                                <div class="logradouro-bairro-usuario">
                                    <div class="logradouro-usuario">
                                        <label for="logradouro">Logradouro</label>
                                        <p><?=$logradouro_usuario?></p>
                                    </div>
                                    <div class="bairro-usuario">
                                        <label for="bairro">Bairro</label>
                                        <p><?=$bairro_usurio?></p>
                                    </div>
                                </div>
                                <div class="numero-uf-usuario">
                                    <div class="numero-usuario">
                                        <label for="numero">Número</label>
                                        <p><?=$numero_usuario?></p>
                                    </div>
                                    <div class="uf-usuario">
                                        <label for="uf">UF</label>
                                        <p><?=$uf_usuario?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="cidade-email-senha-situacao-usuario">
                                <div class="cidade-email-usuario">
                                    <div class="cidade-usuario">
                                        <label for="cidade">Cidade</label>
                                        <p><?=$cidade_usuario?></p>
                                    </div>
                                    <div class="email-usuario">
                                        <label for="email">E-mail</label>
                                        <p><?=$email_usuario?></p>
                                    </div>
                                </div>
                                <div class="senha-situacao-usuario">
                                    <div class="situacao-usuario">
                                        <label for="situacao">Situação</label>
                                        <p><?=$situacao_usuario_string?></p>
                                    </div>
                                </div>
                                <?php if (isset($id_usuario_pai)):?>
                                <div class="usuario-cadastroda-por">
                                    <label for="usuario-cadastroda-por">Usuário administrador que o cadastrou</label>
                                    <p><?=$nome_usuario_pai?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="foto-movimentacao-usuario">
                            <div class="foto-usuario">
                                <figure>
                                    <img src="<?=$foto_usuario?>" alt="Foto de perfil do usuário">
                                    <label for="foto-usuario">Foto de Perfil</label>
                                </figure>
                            </div>
                            <div class="movimentacao-usuario">
                                <h2>Movimentações do usuário</h2>
                                <div class="rolagem-movimentacoes">
                                    <?php 
                                    
                                    $stmt_movimentacao = $conn->prepare("SELECT * FROM movimentacao WHERE ID_USUARIO = ?");
                                    $stmt_movimentacao->bind_param("i", $id_usuario_visto);
                                    $stmt_movimentacao->execute();
                                    $result = $stmt_movimentacao->get_result();
                                    $stmt_movimentacao->close();

                                    if ($result->num_rows == 0) {
                                        echo '

                                        <div class="sem-leilao">
                                            <p style="font-size: 15px; width: fit-content;"><i class="material-icons">question_mark</i> Nenhuma movimentação feita </p>
                                        </div>

                                        ';
                                    }

                                    while ($row = $result->fetch_assoc()) {
                                        $nome_produto_historico = htmlspecialchars($row['NOME_PRODUTO']);
                                        $titulo_historico = htmlspecialchars($row['TIPO_MOVIMENTACAO']);
                                        $valor_hitorico = $row['VALOR'];
                                        $nome_cadastrado_historico = htmlspecialchars($row['NOME_CADASTRADO']);
                                        $grau_cadastrado_historico = $row['GRAU'];

                                        $li = '
                                            <li><label>Valor: </label>R$ '. number_format($valor_hitorico, 2, ',', '.') .'</li>
                                        ';

                                        if (isset($nome_cadastrado_historico) && isset($grau_cadastrado_historico)) {

                                            if ($grau_cadastrado_historico == 1) {
                                                $grau = "Padrão";
                                            } else {
                                                $grau = "Administrador";
                                            }
    
                                            $li = '
                                            <li><label>Grau de Acesso: </label> '. $grau .'</li>
                                            ';
                                        }

                                        echo '
                                        <div class="movimentacoes">
                                            <h3>'. $titulo_historico .'</h3>
                                            <nav>
                                                <ul>
                                                    <li><label>Nome: </label>'. (!empty($nome_cadastrado_historico) ?$nome_cadastrado_historico : $nome_produto_historico) .'</li>
                                                    '. $li .'
                                                </ul>
                                            </nav>
                                        </div>
                                        ';
                                    }


                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </section>
    </main>
</body>
</html>                                   
                                    