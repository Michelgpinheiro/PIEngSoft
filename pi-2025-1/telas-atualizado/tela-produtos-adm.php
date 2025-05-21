<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-fantasia'])) {
        header('Location: login.php');
        exit;
    }
    // unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new LegalEntity();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $_SESSION['nome-fantasia-adm'] = $_SESSION['nome-fantasia'];
    $nome_usuario = $_SESSION['nome-fantasia'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/tela-produtos-adm/-style-tela-produtos-adm.css">
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
        <nav class="nav-movel" style="padding-top: 31.5px;">
            <ul>
                <li><a href="tela-inicial-adm.php">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a class="selected-page">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos-adm.php" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos-adm.php">Sobre nós</a></li>
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

                    switch ($status) {
                        case 1: {

                            $botao = '<div class="dar-lance leiloar">
                            <a style="background-color: green; border-color: lightgreen; color: lightgreen;" href="tela-produtos-2-adm.php?id=' . $id_produto . '">Leiloar</a></div>';
                            break;
                        } case 2: {
                            $botao = '<div class="dar-lance leiloar">
                            <a href="#">Em leilão</a></div>';
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

                            $id_unico = $id_produto;
                            $botao = '
                                <div class="dar-lance leiloar" style="position: static;">
                                    <a style="background-color: darkred; border-color: red; color: red;" href="#" id="btn-dar-lance-'.$id_unico.'">Recusado</a>

                                    <div class="popup-container popup-container-recusa" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup">&times;</span>
                                            <label for="motivo-recusa">Motivo da recusa</label>
                                            <p class="popup-motivo-recusa">' . $recusa . '</p>
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
                            
                            $id_unico = $id_produto;
                            $botao = '
                                <div class="dar-lance leiloar" style="position: static;">
                                    <a style="background-color: darkblue; border-color: cyan; color: cyan;" href="#" id="btn-dar-lance-'.$id_unico.'">Resultado</a>

                                    <div class="popup-container popup-container-pagamento" id="popup-lance-'.$id_unico.'" style="display: none;">
                                        <div class="popup-content popup-pagamento" style="background-color: #bd6c34;">
                                            <span id="close-popup-'.$id_unico.'" class="close-popup close-popup-pag">&times;</span>
                                            <div class="valor-contato">
                                                <div class="lance-valor">
                                                    <label for="valor-lance-'.$id_unico.'">Valor</label>
                                                    <input type="number" id="valor-lance-'.$id_unico.'" step="any" disabled style="background-color:#fff0ce;" value="'. $valor_leilao .'">
                                                </div>
                                                <div class="lance-contato">
                                                    <label for="contato-lance-'.$id_unico.'">Contato</label>
                                                    <input type="tel" id="contato-lance-'.$id_unico.'" disabled value="'. $contato_leilao .'" style="background-color:#fff0ce;">
                                                </div>
                                            </div>
                                            <label for="observacoes-lance-'.$id_unico.'">Observações</label>
                                            <textarea id="observacoes-lance-'.$id_unico.'" rows="4" cols="30" disabled>'. $observacoes_leilao .'</textarea><br><br>
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
                        } default: {
                            $botao = '<div class="dar-lance leiloar"><a href="#">Status indefinido</a></div>';
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
                    <a href="cadastro-produtos-eletronicos-adm.php">
                        <figure style="max-width: 30%; margin-top: 50px; margin-left: 70px;">
                            <img src="css/svg/add.svg" alt="">
                            <p>Adicionar</p>
                        </figure>
                    </a>
                </div>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnDarLance = document.getElementById('btn-dar-lance');
            const popupLance = document.getElementById('popup-lance');
            const closePopup = document.getElementById('close-popup');

            const btnDarLance2 = document.getElementById('btn-dar-lance2');
            const popupLance2 = document.getElementById('popup-lance2');
            const closePopup2 = document.getElementById('close-popup2');

            // Exibir o popup ao clicar no botão "Dar lance"
            btnDarLance.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance.style.display = 'block';  // Mostrar o popup
            });
            btnDarLance2.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance2.style.display = 'block';  // Mostrar o popup
            });


            // Fechar o popup ao clicar no "X"
            closePopup.addEventListener('click', function() {
                popupLance.style.display = 'none';  // Ocultar o popup
            });
            closePopup2.addEventListener('click', function() {
                popupLance2.style.display = 'none';  // Ocultar o popup
            });
            

            // Fechar o popup se clicar fora dele
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance.style.display = 'none';
                }
            });
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance2.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
                <!-- <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://cabralmotor.fbitsstatic.net/img/p/cg-160-titan-70286/257551-6.jpg?w=1000&h=1000&v=202504071324&qs=ignore" alt="">
                        </figure>
                        <h3>Honda GC 160 Titan</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$14.500,00</h4>
                    </div>
                    <div class="dar-lance leiloar">
                        <a href="tela-produtos-2-adm.php">Leiloar</a>
                    </div>
                </div>  -->
                <!-- <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://images.tcdn.com.br/img/img_prod/1124863/controle_original_ps5_sem_fio_dualsense_sony_starlight_blue_12972_1_9293d13567c3479519bcb59e9bfc673a.jpg" alt="">
                        </figure>
                        <h3>Dual Sense</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$350,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: white;" href="tela-pagamento-adm.php">Em Leilão</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTntDd8XR-7U4ox3JNkIgC5q12fE2D3cMyjPQ&s" alt="">
                        </figure>
                        <h3>Taurus 92 9mm</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$2350,00</h4>
                    </div>
                    <div class="dar-lance recusado">
                        <a style="color: white;" href="#" id="btn-dar-lance">Recusado</a>
                    </div>

                    <div class="popup-container popup-container-recusa" id="popup-lance">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <label for="motivo-recusa">Motivo da recusa</label>
                            <p class="popup-motivo-recusa">Você não pode leiloar uma arma com numeração raspada</p>
                        </div>
                    </div>
                </div> 
            </div> -->
            <div class="cards-section-1">
                <!-- <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://s2-autoesporte.glbimg.com/PhjGqvSsrjhXhcRaiQPVcGl-L1Y=/0x0:1980x1204/924x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_cf9d035bf26b4646b105bd958f32089d/internal_photos/bs/2024/w/r/ln4uNrTKiFAf9XmqHtaQ/fiat-titano-ambientadas-007.jpg" alt="">
                        </figure>
                        <h3>Fiat Titano</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$213.000,00</h4>
                    </div>
                    <div class="dar-lance resultado">
                        <a id="btn-dar-lance2" href="#">Resultado</a>
                    </div>

                    <div class="popup-container popup-container-resultado" id="popup-lance2">
                        <div class="popup-content">
                        <span id="close-popup2" class="close-popup">&times;</span>
                            <div class="valor-contato">
                                <div class="lance-valor">
                                    <label for="valor-lance">Valor</label>
                                    <p>R$213.000,00</p>
                                </div>
                                <div class="lance-contato">
                                    <label for="contato-lance">Contato</label>
                                    <p>(88)91234-5678</p>
                                </div>
                            </div>
                            <label for="observacoes-lance">Observações</label>
                            <p>Achei o produto muito bom, tão bom que quero arremata-lo o mais rápido possível!</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://www.artesintonia.com.br/cdn/shop/files/ANN03-escultura-bronze-buda-bali-indonesia-importado-casa-budismo-decoracao-1-01.jpg?v=1708638636" alt="">
                        </figure>
                        <h3 style="font-size: 14px;">Escultura Buldista de Bronze</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance em-analise">
                        <a href="tela-pagamento-adm.php">Em análise</a>
                    </div>
                </div> --> 
