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

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="css/categorias-adm/style-categorias-adm.css">
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
                <li><a href="tela-inicial-adm.php">Início</a></li>
                <li><a class="selected-page">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
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
            <div class="categoria-row">
                <h2>Eletrônicos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://images.tcdn.com.br/img/img_prod/1124863/controle_original_ps5_sem_fio_dualsense_sony_starlight_blue_12972_1_9293d13567c3479519bcb59e9bfc673a.jpg" alt="">
                        </figure>
                        <h3>Dual Sense</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$350,00</p>
                                <p><span>Ultimo lance:</span> R$410,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 30/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> 300,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://m.media-amazon.com/images/I/71xZUkl5dyL.jpg" alt="">
                        </figure>
                        <h3>ASUS Zenbook Duo Laptop</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 08/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$18.500,00</p>
                                <p><span>Ultimo lance:</span> R$18.750,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/05/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$16.500,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://imgs.casasbahia.com.br/55067621/1g.jpg?imwidth=1000" alt="">
                        </figure>
                        <h3>Apple Iphone 16 128GB</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 28/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$12.400,00</p>
                                <p><span>Ultimo lance:</span> R$13.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/06/2025</p>
                                <p><span>Fim:</span> 15/06/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$10.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
            <div class="categoria-row">
                <h2>Veículos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://lh5.googleusercontent.com/proxy/n0xEMt3C1mCQHvmwPO85WnKC9D07NazayP86x7ADPNjOs8O70fCf4FJYkgBS95LRxxQ9BL-kKXtEo3DKCN4KUhxhNMtax86iEokK4CSL6XfFtKVIWLmV" alt="">
                        </figure>
                        <h3>Chevrolet Camaro</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 05/03/2025</p>
                                <p><span>Fim:</span> 30/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$142.000,00</p>
                                <p><span>Ultimo lance:</span> R$152.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 04/05/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$133.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://cabralmotor.fbitsstatic.net/img/p/cg-160-titan-70286/257551-6.jpg?w=1000&h=1000&v=202504071324&qs=ignore" alt="">
                        </figure>
                        <h3>Honda GC 160 Titan</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 12/03/2025</p>
                                <p><span>Fim:</span> 24/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$14.500,00</p>
                                <p><span>Ultimo lance:</span> R$16.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 30/04/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$12.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://s2-autoesporte.glbimg.com/PhjGqvSsrjhXhcRaiQPVcGl-L1Y=/0x0:1980x1204/924x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_cf9d035bf26b4646b105bd958f32089d/internal_photos/bs/2024/w/r/ln4uNrTKiFAf9XmqHtaQ/fiat-titano-ambientadas-007.jpg" alt="">
                        </figure>
                        <h3>Fiat Titano</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 18/03/2025</p>
                                <p><span>Fim:</span> 04/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$212.000,00</p>
                                <p><span>Ultimo lance:</span> R$213.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 05/05/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$190.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
            <div class="categoria-row">
                <h2>Antiguidades</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://i.pinimg.com/736x/86/a6/c8/86a6c8fedfd94016dcddc0c72e52796b.jpg" alt="">
                        </figure>
                        <h3>Vaso Meso-americano</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 19/03/2025</p>
                                <p><span>Fim:</span> 05/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$4.200,00</p>
                                <p><span>Ultimo lance:</span> R$5.320,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 05/04/2025</p>
                                <p><span>Fim:</span> 15/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$3.750,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.artesintonia.com.br/cdn/shop/files/ANN03-escultura-bronze-buda-bali-indonesia-importado-casa-budismo-decoracao-1-01.jpg?v=1708638636" alt="">
                        </figure>
                        <h3>Escultura de Bronze Buldista</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 24/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$3.400,00</p>
                                <p><span>Ultimo lance:</span> R$4.020,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/05/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$2.900,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://down-br.img.susercontent.com/file/1321f0bdf1f03b8091a0c605659c5f49" alt="">
                        </figure>
                        <h3>Quadro de Óleo - Quedas D'àgua</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 09/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$200,00</p>
                                <p><span>Ultimo lance:</span> R$320,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 09/05/2025</p>
                                <p><span>Fim:</span> 19/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$160,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
            <div class="categoria-row">
                <h2>Roupas</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://shoppingcity.com.br/media/catalog/product/cache/51a80c9da94f85ac42b65ba251e9fd91/j/a/jaqueta_masculina_laranja_detachable.jpg" alt="">
                        </figure>
                        <h3>Casaco Laranja</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 18/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$400,00</p>
                                <p><span>Ultimo lance:</span> R$420,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 19/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$340,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://i.pinimg.com/474x/47/9d/8b/479d8b4f6de70b02e4b0ed7e70799125.jpg" alt="">
                        </figure>
                        <h3>Vestido Estampado com Flores</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 19/03/2025</p>
                                <p><span>Fim:</span> 07/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$270,00</p>
                                <p><span>Ultimo lance:</span> R$300,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 09/04/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$200,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://rivierawear.com.br/cdn/shop/files/S7818ae00b9084262835f54fff6d61f1fU.jpg?v=1688494129" alt="">
                        </figure>
                        <h3>Calça Jeans</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 14/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$300,00</p>
                                <p><span>Ultimo lance:</span> R$310,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 05/04/2025</p>
                                <p><span>Fim:</span> 15/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$250,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
            <div class="categoria-row">
                <h2>Móvel</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.colchaocostarica.com.br/produtos/imagens/42198-det-Cama-de-Queen-de-Monaco---Tcil-Moveis.jpg" alt="">
                        </figure>
                        <h3>Cama de Casal Queen Mônaco</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$436,50</p>
                                <p><span>Ultimo lance:</span> R$500,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 15/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$410,50</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://abracasa.vteximg.com.br/arquivos/ids/195834/2025_cadeira_malai_mesa_jantar_dadi.jpg.jpg?v=638733234462200000" alt="">
                        </figure>
                        <h3>Mesa de Jantar Redonda</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 26/03/2025</p>
                                <p><span>Fim:</span> 01/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$3.200,00</p>
                                <p><span>Ultimo lance:</span> R$4.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 19/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$2750,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://cdn.leroymerlin.com.br/products/cadeira_balanco_ninho_suspenso_gota_tramado_com_suporte_e_alm_1571679380_d5a2_600x600.jpg" alt="">
                        </figure>
                        <h3>Cadeira de Balança Ninho Gota</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 10/03/2025</p>
                                <p><span>Fim:</span> 16/03/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$193,00</p>
                                <p><span>Ultimo lance:</span> R$200,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 01/04/2025</p>
                                <p><span>Fim:</span> 28/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$170,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
            <div class="categoria-row">
                <h2>Outros</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://m.media-amazon.com/images/I/518tkiWGd0L._AC_SY350_.jpg" alt="">
                        </figure>
                        <h3>Lâminas do Caos (chaveiro)</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$600,00</p>
                                <p><span>Ultimo lance:</span> R$650,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 07/04/2025</p>
                                <p><span>Fim:</span> 09/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$499,90</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://img.joomcdn.net/db0ef987d244ede0a325f677c0916af327bcb688_original.jpeg" alt="">
                        </figure>
                        <h3>Pás de Ferro Inoxidável</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 09/03/2025</p>
                                <p><span>Fim:</span> 12/03/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$120,00</p>
                                <p><span>Ultimo lance:</span> R$130,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 16/03/2025</p>
                                <p><span>Fim:</span> 20/03/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$90,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.bagaggio.com.br/arquivos/ids/2343108_2/0160819588001---GARRAFA-TERM-500ML-HOLOGRAFICA--ROXO-U--1-.jpg" alt="">
                        </figure>
                        <h3>Garrafa Térmica (650ml)</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 09/03/2025</p>
                                <p><span>Fim:</span> 09/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$60,00</p>
                                <p><span>Ultimo lance:</span> R$70,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 10/04/2025</p>
                                <p><span>Fim:</span> 15/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p class="inicial-lance-padding-top">.</p>
                                <p><span>Valor inicial:</span> R$40,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento-adm.php">Dar lance</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>