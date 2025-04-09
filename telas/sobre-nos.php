<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nós</title>
    <link rel="stylesheet" href="css/sobre-nos/-style-sobre-nos.css">
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
                <form action="">
                    <input type="text" name="buscar" id="buscar">
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
                <li><a href="contate-nos.php" style="font-size: 13px;">Contrate-nos</a></li>
                <li><a class="selected-page">Sobre nós</a></li>
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
            <div class="quem-somos-qual-objetivo">
                <div class="quem-somos">
                    <h2>Quem somos?</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, nam natus ipsum excepturi repellendus aliquid accusamus sunt, saepe labore maiores atque, veritatis iste minima. Quis nisi, rerum aperiam sunt, dolorem et veniam placeat maiores quibusdam voluptatibus eveniet dolorum nam voluptatum harum quaerat! Consequuntur deserunt reiciendis minus molestias ullam quo eius ipsam. Perspiciatis ea debitis totam error molestias nesciunt soluta aut porro repellendus dolorum. Eaque fuga, voluptatibus, magnam minima beatae et dolores at aliquam dolor harum quam ratione quis, recusandae nesciunt eveniet quod mollitia voluptas iste ipsum sed asperiores temporibus odit. Suscipit autem dolore earum minus sequi aliquid optio, tempore unde.</p>
                </div>
                <div class="qual-objetivo">
                    <h2>Qual o nosso objetivo?</h2>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Modi temporibus atque perspiciatis, numquam maiores minus alias molestias repellat esse. Iure, aliquam. Rerum perspiciatis, suscipit sit amet quos officiis quod laboriosam nihil libero facere, iusto dolor ea nesciunt repellat maxime minima vero illum quidem blanditiis ratione molestiae harum? Repudiandae cupiditate dicta illo molestiae minus. Sunt eligendi, quas enim eius animi molestiae perspiciatis doloribus excepturi, nostrum fuga quisquam ab delectus, quibusdam ipsa consequatur. Officiis culpa commodi maxime, nulla tempora esse asperiores dolores nemo porro similique cupiditate molestiae reprehenderit voluptatum iure soluta fuga aut. Voluptatum ipsa tempora ut sed eum consequuntur maiores autem ea velit adipisci nisi quaerat sint architecto, est debitis accusantium itaque molestias quas molestiae et animi hic? Magnam, nostrum dicta autem similique temporibus voluptate quia ex eveniet molestias libero fugit neque sint? At provident odio, quo voluptatum voluptatem molestiae fugiat delectus, ullam ab modi perspiciatis eveniet atque asperiores, amet blanditiis!</p>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="espacar-header"></div>
        <div class="inner-header">
            <div class="contatar-mensagem-enviar">
                <h3>Como nos contatar?</h3>
                <div class="mensagem-enviar">
                    <div class="mensagem">
                        <label for="mensagem">Envie sua mensagem aqui</label>
                        <textarea name="mensagem" id="mensagem"></textarea>
                    </div>
                    <button type="submit">Enviar</button>
                </div>
            </div>
            <div class="redes-socias">
                <h4>Nossas outras redes</h4>
                <nav class="redes">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="https://www.svgrepo.com/show/118710/email.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="https://www.svgrepo.com/show/303615/github-icon-1-logo.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="https://www.svgrepo.com/show/45932/whatsapp.svg" alt="">
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>
</body>
</html>