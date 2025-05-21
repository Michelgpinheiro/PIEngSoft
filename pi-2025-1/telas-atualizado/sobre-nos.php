<?php 

    session_start();

    require_once "connection.php";

    if (!isset($_SESSION['nome-usuario'])) {
        header('Location: login.php');
        exit;
    }

    unset($_SESSION['cadastro-sucesso'], $_SESSION['email-usuario'], $_SESSION['senha-usuario']);

    $usuario = new PhysicalPerson();
    $usuario->setId($_SESSION['id-usuario']);
    $id_usuario = $usuario->getId();
    $foto_existe = $_SESSION['foto'];

    $nome_usuario = $_SESSION['nome-usuario'];
    $primeiro_nome = explode(' ', trim($nome_usuario))[0];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre nós</title>
    <link rel="stylesheet" href="css/sobre-nos/style-sobre-nos.css">
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
                    <option value="valor1" selected disabled>Categorias</option>
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
                <li><a href="tela-inicial.php">Início</a></li>
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="tela-produtos.php">Produtos</a></li>
                <li><a href="contate-nos.php" style="font-size: 13px;">Contate-nos</a></li>
                <li><a class="selected-page">Sobre nós</a></li>
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
            <div class="quem-somos-qual-objetivo">
                <div class="quem-somos">
                    <h2 class="quem">Quem somos</h2>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, nam natus ipsum excepturi repellendus aliquid accusamus sunt, saepe labore maiores atque, veritatis iste minima. Quis nisi, rerum aperiam sunt, dolorem et veniam placeat maiores quibusdam voluptatibus eveniet dolorum nam voluptatum harum quaerat! Consequuntur deserunt reiciendis minus molestias ullam quo eius ipsam. Perspiciatis ea debitis totam error molestias nesciunt soluta aut porro repellendus dolorum. Eaque fuga, voluptatibus, magnam minima beatae et dolores at aliquam dolor harum quam ratione quis, recusandae nesciunt eveniet quod mollitia voluptas iste ipsum sed asperiores temporibus odit. Suscipit autem dolore earum minus sequi aliquid optio, tempore unde.</p>
                </div>
                <div class="qual-objetivo">
                    <h2 class="objetivo">Qual o nosso objetivo</h2>
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
                    <button type="submit" id="enviar-contato">Enviar</button>
                </div>
            </div>
            <div class="redes-socias">
                <h4>Nossas outras redes</h4>
                <nav class="redes">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="css/svg/emial.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="css/svg/github.svg" alt="">
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="css/svg/whatssap.svg" alt="">
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>
</body>
</html>