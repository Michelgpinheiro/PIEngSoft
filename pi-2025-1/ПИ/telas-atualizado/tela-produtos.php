<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-usuario']) && !isset($_SESSION['nome-fantasia'])) {
        header('Location: login.php');
        exit;
    }

    if (isset($_GET['ex'])) {
        $excluir = $_GET['ex'];

        $stmt = $conn->prepare("DELETE FROM produto WHERE ID = ?");
        $stmt->bind_param("i", $excluir);
        $stmt->execute();
        $stmt->close();

        $_SESSION['produto-deletado'] = "<p><i class='material-icons'>check_circle</i> Produto removido com sucesso</p>";
    }

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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/tela-produtos/---style-tela-produtos.css">
    <link rel="stylesheet" href="css/logout/style-logout.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/-estilizacao-geral.css?v=<?=time()?>">
    <link rel="stylesheet" href="css/estilizacao-geral.css?v=<?=time()?>">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leilão</h1>
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
        <nav class="nav-movel" style="padding-top: 31.5px;">
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
            <div class="categoria-row categoria-row-produtos">
                <h2>Seus Produtos</h2>
                <div class="row row-produtos"></div>
                <?php 

                if (isset($_SESSION['cadastro-sucesso'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso" style="margin-top: 10px;">
                            <?=$_SESSION['cadastro-sucesso']?>
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
                        unset($_SESSION['cadastro-sucesso']);
                    }

                    if (isset($_SESSION['produto-deletado'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso" style="margin-top: 10px;">
                            <?=$_SESSION['produto-deletado']?>
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
                        unset($_SESSION['produto-deletado']);
                    }
                
                    if (isset($_SESSION['leilao-analise'])) {
                        ?>
                        <div class="mensagem-sucesso" id="mensagem-sucesso">
                            <?=$_SESSION['leilao-analise']?>
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
                        unset($_SESSION['leilao-analise']);
                    }

                ?>
            </div>
            <div class="cards-section-1">
            <?php 
            
                $stmt = $conn->prepare("SELECT ID, NOME, LANCE_INICIAL, FOTO, STATUS_PRODUTO FROM produto WHERE ID_USUARIO = ?");
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                // $tem_produto_analise = false;

                while ($row = $result->fetch_assoc()) {
                    $nome = htmlspecialchars($row['NOME']);
                    $valor = number_format($row['LANCE_INICIAL'], 2, ',', '.');
                    $imagem = $row['FOTO'] ?: 'img/imagem-padrao.png'; // imagem padrão se não tiver
                    $id_produto = $row['ID'];
                    // $_SESSION['id-produto'] = $row['ID'];
                    $status = $row['STATUS_PRODUTO'];
                    // $_SESSION['nome-produto'] = $nome;

                    $id_unico = $id_produto;

                    switch ($status) {
                        case 1: {

                            $botao = '<div class="dar-lance leiloar">
                            <a style="background-color: green; margin-bottom: -20px; border-color: lightgreen; color: lightgreen;" href="tela-produtos-2.php?id=' . $id_produto . '">Leiloar</a></div>

                            <a style="display: inline-block;" class="pause-button delete-button btn-excluir-' . $id_unico . '" href="#">
                                <img style="margin-top: -100px;" src="css/svg/garbage.svg" alt="Excluir">
                            </a>

                            <div id="modalExcluir-' . $id_unico . '" class="modal">
                                <div class="modal-content">
                                    <p>Tem certeza de que deseja excluir este produto?</p>
                                    <button style="
                                        background-color: #BD6C34;
                                        color: #FFD980;
                                        border: 2px solid #FFD980;
                                        font-size: 16px;
                                        width: 100px;
                                    " id="confirmarExcluir-' . $id_unico . '" class="confirmar-sair">Sim</button>
                                    <button style="
                                        background-color: #FFD980;
                                        color: #BD6C34;
                                        border: 2px solid #BD6C34;
                                        font-size: 16px;
                                    " id="cancelarExcluir-' . $id_unico . '" class="cancelar-sair">Cancelar</button>
                                </div>
                            </div>

                            <script>
                                document.querySelector(".btn-excluir-' . $id_unico . '").addEventListener("click", function(e) {
                                    e.preventDefault();
                                    document.getElementById("modalExcluir-' . $id_unico . '").style.display = "flex";
                                });

                                document.getElementById("cancelarExcluir-' . $id_unico . '").addEventListener("click", function() {
                                    document.getElementById("modalExcluir-' . $id_unico . '").style.display = "none";
                                });

                                document.getElementById("confirmarExcluir-' . $id_unico . '").addEventListener("click", function() {
                                    window.location.href = "tela-produtos.php?ex=' . $id_unico . '";
                                });
                            </script>
                            
                            ';
                            break;
                        } case 2: {
                            $botao = '<div style="margin-bottom: -30px;" class="dar-lance leiloar">
                            <a href="#" onclick="return false">Em leilão</a></div>
                            
                            <a style="display: inline-block;" class="pause-button delete-button" href="tela-produtos.php?ex='. $id_produto .'">
                                <img style="margin-top: -100px;" src="css/svg/garbage.svg" alt="">
                            </a>
                            
                            ';
                            break;
                        } case 3: {
                            $stmt_recusa = $conn->prepare("SELECT MOTIVO_RECUSA FROM leilao WHERE ID_PRODUTO = ?");
                            $stmt_recusa->bind_param("i", $id_produto);
                            $stmt_recusa->execute();
                            $result_recusa = $stmt_recusa->get_result();
                            $stmt_recusa->close();

                            while ($row_rec = $result_recusa->fetch_assoc()) {
                                $recusa = htmlspecialchars($row_rec['MOTIVO_RECUSA']);
                            }

                            $botao = '
                                <div class="dar-lance leiloar" style="position: static;">
                                    <a style="background-color: darkred; margin-bottom: -20px; border-color: red; color: red;" href="#" id="btn-dar-lance-'.$id_unico.'">Recusado</a>

                                    <a style="display: inline-block;" class="pause-button delete-button" href="tela-produtos.php?ex='. $id_produto .'">
                                        <img style="margin-top: -100px;" src="css/svg/garbage.svg" alt="">
                                    </a>

                                    <div class="popup-container popup-container-recusa" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup">&times;</span>
                                            <label for="motivo-recusa">Motivo da recusa</label>
                                            <p style="background-color: #fff0ce;" class="popup-motivo-recusa">' . $recusa . '</p>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const popup = document.getElementById("popup-lance-'.$id_unico.'");
                                        const closeBtn = document.getElementById("close-popup-'.$id_unico.'");
                                        const openBtn = document.getElementById("btn-dar-lance-'.$id_unico.'");

                                        openBtn.addEventListener("click", function (e) {
                                            e.preventDefault();
                                            popup.style.display = "block";
                                        });

                                        closeBtn.addEventListener("click", function () {
                                            popup.style.display = "none";
                                        });
                                    });
                                </script> ';
                            
                            
                            break;
                        } case 4: {
                            $stmt_select = $conn->prepare(
                                "SELECT VALOR, CONTATO, OBSERVACOES FROM lancamento WHERE ID_PRODUTO = ?;
                            ");
                            $stmt_select->bind_param("i", $id_produto);
                            $stmt_select->execute();
                            $result_select = $stmt_select->get_result();

                            while ($row = $result_select->fetch_assoc()) {
                                $valor_leilao = $row['VALOR'];
                                $contato_leilao = $row['CONTATO'];
                                $observacoes_leilao = $row['OBSERVACOES'];
                            }
                            
                            $botao = '
                                <div class="dar-lance leiloar" style="position: static;">
                                    <a style="background-color: darkblue; border-color: cyan; color: cyan;" href="#" id="btn-dar-lance-'.$id_unico.'">Resultado</a>

                                    <div class="popup-container popup-container-pagamento leiloar-result" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content popup-pagamento" style="background-color: #bd6c34;">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup close-popup-pag">&times;</span>
                                            <div class="valor-contato">
                                                <div class="lance-valor">
                                                    <label for="valor-lance-'.$id_unico.'">Valor</label>
                                                    <p style="margin-top: 3px; width: 110px; background-color: #fff0ce;" id="valor-lance-'.$id_unico.'">R$ '. number_format($valor_leilao, 2, ',', '.') .'</p>
                                                    
                                                    
                                                </div>
                                                <div class="lance-contato">
                                                    <label for="contato-lance-'.$id_unico.'">Contato</label>
                                                    <p style="margin-top: 3px; width: 130px; background-color: #fff0ce;" id="valor-lance-'.$id_unico.'">'. $contato_leilao .'</p>
                                                </div>
                                            </div>
                                            <label for="observacoes-lance-'.$id_unico.'">Observações</label>
                                            <p style="margin-top: 3px;width: fit-content; background-color: #fff0ce;" id="valor-lance-'.$id_unico.'">'. $observacoes_leilao .'</p>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const popup = document.getElementById("popup-lance-'.$id_unico.'");
                                        const closeBtn = document.getElementById("close-popup-'.$id_unico.'");
                                        const openBtn = document.getElementById("btn-dar-lance-'.$id_unico.'");

                                        openBtn.addEventListener("click", function (e) {
                                            e.preventDefault();
                                            popup.style.display = "flex";
                                        });

                                        closeBtn.addEventListener("click", function () {
                                            popup.style.display = "none";
                                        });
                                    });
                                </script>


                            ';

                            break;
                        } case 5: {
                            $botao = '<div class="dar-lance leiloar">
                            <a href="#">Em análise</a></div>';
                            break;
                        } case 6: {
                            $stmt_recusa = $conn->prepare("SELECT MOTIVO_SUSPENSAO FROM produto WHERE ID = ?");
                            $stmt_recusa->bind_param("i", $id_produto);
                            $stmt_recusa->execute();
                            $result_recusa = $stmt_recusa->get_result();
                            $stmt_recusa->close();

                            while ($row_rec = $result_recusa->fetch_assoc()) {
                                $recusa = htmlspecialchars($row_rec['MOTIVO_SUSPENSAO']);
                            }

                            $botao = '
                                <div class="dar-lance leiloar" style="position: static; margin-bottom: -30px;">
                                    <a style="background-color: brown; border-color: orange; margin-bottom: -20px; color: orange;" href="#" id="btn-dar-lance-'.$id_unico.'">Suspenso</a>

                                    <a style="display: inline-block;" class="pause-button delete-button" href="tela-produtos.php?ex='. $id_produto .'">
                                        <img style="margin-top: -100px;" src="css/svg/garbage.svg" alt="">
                                    </a>

                                    <div class="popup-container popup-container-recusa" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup">&times;</span>
                                            <label for="motivo-recusa">Motivo da suspensão</label>
                                            <p style="background-color: #fff0ce;" class="popup-motivo-recusa">' . $recusa . '</p>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const popup = document.getElementById("popup-lance-'.$id_unico.'");
                                        const closeBtn = document.getElementById("close-popup-'.$id_unico.'");
                                        const openBtn = document.getElementById("btn-dar-lance-'.$id_unico.'");

                                        openBtn.addEventListener("click", function (e) {
                                            e.preventDefault();
                                            popup.style.display = "block";
                                        });

                                        closeBtn.addEventListener("click", function () {
                                            popup.style.display = "none";
                                        });
                                    });
                                </script> ';

                            break;
                            
                        } case 7: {
                            

                            $stmt_recusa = $conn->prepare("SELECT MOTIVO_EXCLUSAO FROM produto WHERE ID = ?");
                            $stmt_recusa->bind_param("i", $id_produto);
                            $stmt_recusa->execute();
                            $result_recusa = $stmt_recusa->get_result();
                            $stmt_recusa->close();

                            while ($row_rec = $result_recusa->fetch_assoc()) {
                                $recusa = htmlspecialchars($row_rec['MOTIVO_EXCLUSAO']);
                            }

                            $botao = '
                                <div class="dar-lance leiloar" style="position: static;">
                                    <a style="background-color: red; margin-bottom: -20px; border-color: darkred; color: darkred;" href="#" id="btn-dar-lance-'.$id_unico.'">Excluido</a>

                                    <a style="display: inline-block;" class="pause-button delete-button" href="tela-produtos.php?ex='. $id_produto .'">
                                        <img style="margin-top: -100px;" src="css/svg/garbage.svg" alt="">
                                    </a>

                                    <div class="popup-container popup-container-recusa" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup">&times;</span>
                                            <label for="motivo-recusa">Motivo da Exclusão</label>
                                            <p style="background-color: #fff0ce;" class="popup-motivo-recusa">' . $recusa . '</p>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const popup = document.getElementById("popup-lance-'.$id_unico.'");
                                        const closeBtn = document.getElementById("close-popup-'.$id_unico.'");
                                        const openBtn = document.getElementById("btn-dar-lance-'.$id_unico.'");

                                        openBtn.addEventListener("click", function (e) {
                                            e.preventDefault();
                                            popup.style.display = "block";
                                        });

                                        closeBtn.addEventListener("click", function () {
                                            popup.style.display = "none";
                                        });
                                    });
                                </script> ';

                            break;
                        } default: {
                            $botao = '<div class="dar-lance leiloar"><a href="#">Status indefinido</a></div>';
                            break;
                        }
                    }

                    echo '
                    <div class="card card-produtos">
                        <div class="inner-card inner-card-produtos">
                            <figure style="width: 250px; height: 150px">
                                <img src="' . $imagem . '" alt="">
                            </figure>
                            <h3>' . $nome . '</h3>
                            <div class="card-informations-row"></div>
                            <h4><span>Valor:</span> R$ ' . $valor . '</h4>
                        </div>
                        ' . $botao . '
                    </div>';
                }

                ?>
                <div class="adicionar-produto">
                    <a href="cadastro-produtos-eletronicos.php">
                        <figure style="max-width: 30%; margin-top: 50px; margin-left: 70px;">
                            <img src="./css/svg/add.svg" alt="">
                            <p>Adicionar</p>
                        </figure>
                    </a>
                </div>
            </div>
        </section>
    </main> 
</body>
</html>