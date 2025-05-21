<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - administrador</title>
    <link rel="stylesheet" href="css/tela-inicial-adm/style-tela-inicial-adm.css">
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
                <p>Fulano de Tal</p>
                <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/03/150313105721-pi-day-graphic.jpg?w=1115" alt="">
            </figure>
        </div>
    </header>
    <main>
        <nav class="nav-movel">
            <ul>
                <li><a class="selected-page">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="tela-produtos.php">Produtos</a></li>
                <li><a href="">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos.php" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos.php">Sobre nós</a></li>
                <li class="epc"></li>
                <li><a href="login.php" class="sair">Sair</a></li>
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
        <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/04/230418093558-01-new-lincoln-nautilus-suv.webp?w=1200&h=900&crop=1" alt="">
                        </figure>
                        <h3>SUV Nautilus</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 17/03/2025</p>
                                <p><span>Fim:</span> 02/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$430.000,00</p>
                                <p><span>Ultimo lance:</span> R$520.000,00</p>
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
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$380.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://kawasaki.m3parts.com.br/arquivos/1705004947_24ex400l_44sgn1drf3cg_a.jpg" alt="">
                        </figure>
                        <h3>Kawasaki Ninja 400 2024 KRT</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 02/03/2025</p>
                                <p><span>Fim:</span> 05/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$54.000,00</p>
                                <p><span>Ultimo lance:</span> R$61.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 10/04/2025</p>
                                <p><span>Fim:</span> 26/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$47.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://down-br.img.susercontent.com/file/br-11134207-7r98o-lyzb5framu1hbc" alt="">
                        </figure>
                        <h3>PlayStation 5</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 07/03/2025</p>
                                <p><span>Fim:</span> 01/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$4.560,00</p>
                                <p><span>Ultimo lance:</span> R$5.000,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 02/04/2025</p>
                                <p><span>Fim:</span> 30/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$4.200,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://http2.mlstatic.com/D_NQ_NP_686929-MLA46546580100_062021-O.webp" alt="">
                        </figure>
                        <h3>Armadura de Stormtrooper</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 09/03/2025</p>
                                <p><span>Fim:</span> 10/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$1.200,00</p>
                                <p><span>Ultimo lance:</span> R$1.320,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 21/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$1.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://martinelloeletrodomesticos.fbitsstatic.net/img/p/lavadora-de-roupas-electrolux-led14-14kg-cesto-inox-11-programas-de-lavagem-110v-76698/263289-25.jpg?w=482&h=482&v=no-change&qs=ignore" alt="">
                        </figure>
                        <h3>Lavadora Eletrolux LED14</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 16/03/2025</p>
                                <p><span>Fim:</span> 08/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$2.300,00</p>
                                <p><span>Ultimo lance:</span> R$2.310,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 23/04/2025</p>
                                <p><span>Fim:</span> 15/05/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$2.000,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://72380.cdn.simplo7.net/static/72380/sku/ferramentas-manuais-outros-kit-ferramentas-para-mecanico-176-pcs-44952176-tramontinapro-1717183025549.jpg" alt="">
                        </figure>
                        <h3>Kit de Ferramentas Completo</h3>
                        <div class="card-informations-1">
                            <div class="card-info-1">
                                <h4>1ª Praça</h4>
                                <p><span>Início:</span> 01/03/2025</p>
                                <p><span>Fim:</span> 01/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$1.700,00</p>
                                <p><span>Ultimo lance:</span> R$1.820,00</p>
                            </div>
                        </div>
                        <div class="card-informations-row"></div>
                        <div class="card-informations-2">
                            <div class="card-info-1">
                                <h4>2ª Praça</h4>
                                <p><span>Início:</span> 09/04/2025</p>
                                <p><span>Fim:</span> 19/04/2025</p>
                            </div>
                            <div class="card-info-2">
                                <p style="color: white;">.</p>
                                <p><span>Valor inicial:</span> R$1.450,00</p>
                            </div>
                        </div>
                    </div>
                    <div class="dar-lance">
                        <a href="tela-pagamento.php">Dar lance</a>
                        <button class="view">
                            <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>