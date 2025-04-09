<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitações de administrador</title>
    <link rel="stylesheet" href="css/tela-solicitacao-adm/-style-tela-solicitacao-adm.css">
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Leilão</h1>
            <div class="barra-busca">
                <select name="categorias" id="categorias">
                    <option value="valor1" selected disabled>categorias</option>
                    <option value="valor1">Eletrônicos</option>
                    <option value="valor2">Veículos</option>
                    <option value="valor3">Antiguidades</option>
                    <option value="valor4">Roupas</option>
                    <option value="valor5">Móvel</option>
                    <option value="valor6">Outros</option>
                </select>
                <form style="border-radius: 0px 10px 10px 0px;" action="">
                    <input style="border-radius: 0px;" type="text" name="buscar" id="buscar">
                    <button type="submit"></button>
                </form>
            </div>
            <figure class="perfil-configs">
                <p>Fulano de Tal</p>
                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
            </figure>
        </div>
    </header>
    <main>
        <nav class="nav-movel">
            <ul>
                <li><a href="tela-inicial.php">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="tela-produtos.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Solicitações</a></li>
                <li><a href="contate-nos.php" style="font-size: 13px;">Contate-nos</a></li>
                <li><a href="sobre-nos.php">Sobre nós</a></li>
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
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="user-card">
                        <div class="card-start">
                            <figure class="perfil-configs user-img">
                                <img src="imagens/profile_user_account_icon_190938.webp" alt="">
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
                                <button class="pause">
                                    Verificar
                                </button>
                            </div>
                        </div>
                    </div>                   
                </div>
            </div>
        </section>
    </main>
</body>
</html>