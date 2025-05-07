<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de administrador</title>
    <link rel="stylesheet" href="css/tela-solicitacao-adm/style-tela-solicitacao-adm.css">
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
                <form style="border-radius: 0px 10px 10px 0px;" action="">
                    <input style="border-radius: 0px; text-indent: 4px;" type="text" name="buscar" id="buscar" placeholder="Pesquisar...">
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
                <li><a href="tela-inicial-adm.php">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos-adm.php" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos-adm.php">Sobre nós</a></li>
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
            <div class="listagem-usuarios">
                <h2>Listagem de usuários</h2>
                <div class="adicionar-buscar">
                    <div class="barra-busca busca-user">
                        <form action="">
                            <input type="text" name="buscar" id="buscar" placeholder="Buscar usuário...">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="usuario-cards">
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4a/Capital_Greek_letter_qoppa.svg/1200px-Capital_Greek_letter_qoppa.svg.png" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 1</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php"class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfDumRHWwwq4KuO37B7B4sGKOGgMe4pvDq_Q&s" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 2</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php" class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://img.freepik.com/vetores-premium/simbolo-do-alfabeto-grego-theta_875240-773.jpg" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 3</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php"class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://img.freepik.com/vetores-premium/simbolo-do-alfabeto-grego-rho_875240-895.jpg" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 4</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php"class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://informaticacero.com/wp-content/uploads/2020/11/letra-p-mayuscula.png" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 5</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php"class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="https://andrebona.com.br/wp-content/uploads/2019/02/alpha.png" alt="">
                            </figure>
                            <p class="nome">Fulano de Tal</p>
                            <p class="id">Id: 6</p>
                        </div>
                        <div class="card-end">  
                            <div style="visibility: hidden;" class="pause-view">
                                <button class="pause">
                                    <img src="https://www.svgrepo.com/show/336067/pause.svg" alt="">
                                </button>
                                <button class="view">
                                    <img src="https://www.svgrepo.com/show/2179/eye.svg" alt="">
                                </button>
                            </div>
                            <div class="pause-view">
                                <a href="solicitacao-adm.php"class="pause" style="text-decoration: none; padding-top: 11px;">
                                    Verificar
                                </a>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </section>
    </main>
</body>
</html>