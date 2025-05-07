<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contate-nos</title>
    <link rel="stylesheet" href="css/contate-nos-adm/style-contate-nos-adm.css">
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
                <li><a href="tela-inicial-adm.php">Início</a></li>
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Contate-nos</a></li>
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
            <div class="entre-em-contato">
                <h2>Entre em contato com a gente</h2>
                <div class="descricao-mensagem-enviar">
                    <p><span>Descrição:</span> Lorem ipsum dolor, sit amet consectetur adipisicing elit. Accusantium at modi, neque facilis saepe tempora! Est rem distinctio minus asperiores ducimus sapiente beatae tempora blanditiis temporibus, mollitia recusandae dolor sunt ipsum alias dolore. Aliquam provident nesciunt omnis non laboriosam debitis saepe assumenda enim velit voluptatum, in porro maxime voluptates cupiditate asperiores molestiae accusantium. Quas sint facere dignissimos impedit eveniet sed, illo voluptates totam reiciendis dolorum natus hic est, odit error omnis unde eum numquam tempore? Minus iste, eum accusantium soluta debitis inventore facere doloribus sapiente rerum consequuntur, perspiciatis repudiandae perferendis quia unde ex quibusdam corrupti. Perferendis officiis maxime id impedit.</p>
                    <div class="mensagem">
                        <label for="mensagem">Envie sua mensagem aqui</label>
                        <textarea name="mensagem" id="mensagem"></textarea>
                    </div>
                    <div class="button">
                        <button type="submit">Enviar</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>