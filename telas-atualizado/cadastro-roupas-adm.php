<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de roupas</title>
    <link rel="stylesheet" href="css/cadastro-roupas-adm/style-cadastro-roupas-adm.css">
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
                <li><a class="selected-page">Produtos</a></li>
                <li><a href="listagem-usuarios-adm.php">Usuários</a></li>
                <li><a href="tela-solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
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
            <div class="cadastro-produtos">
                <h2>Cadastro de produtos</h2>
                <div class="nav-produtos">
                    <nav>
                        <ul>
                            <li><a href="cadastro-produtos-eletronicos-adm.php">Eletrônico</a></li>
                            <li><a href="cadastro-veiculos-adm.php">Veículos</a></li>
                            <li><a href="cadastro-antiguidades-adm.php">Antiguidade</a></li>
                            <li style="margin-bottom: -1px;"><a  class="selected-nav-produto" style="border-bottom: 1px solid #d1d1e9;" >Roupas</a></li>
                            <li><a href="cadastro-movel-adm.php">Móvel</a></li>
                            <li><a href="cadastro-outros-adm.php">Outros</a></li>
                        </ul>
                    </nav>
                    <div class="nav-produtos-row"></div>
                </div>
                <div class="divisoria-1">
                    <div class="nome-marca-quantidade-modelo-lanceinicial">
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>
                        <div class="mqml">
                            <div class="marca-quantidade">
                                <div class="marca">
                                    <label for="marca">Marca</label>
                                    <input type="text" name="marca" id="marca">
                                </div>
                                <div class="quantidade">
                                    <label for="tamanho">Tamanho</label>
                                    <input type="text" name="tamanho" id="tamanho">
                                </div>
                                <div class="quantidade">
                                    <label for="cor">Cor</label>
                                    <input type="text" name="cor" id="cor">
                                </div>
                            </div>
                            <div class="modelo-lanceinicial">
                                <div class="modelo">
                                    <label for="materiais">Materiais</label>
                                    <input type="text" name="materiais" id="materias">
                                </div>
                                <div class="lanceinicial">
                                    <label for="lanceinicial">Lance inicial (R$)</label>
                                    <input type="number" name="lanceinicial" id="lanceinicial">
                                </div>
                                <div class="modelo">
                                    <label for="estilo">Estilo</label>
                                    <input type="text" name="estilo" id="estilo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="condicao-imagem">
                        <div class="condicao">
                            <label for="condicao">Condição</label>
                            <input type="text" name="condicao" id="condicao">
                        </div>
                        <div class="imagem">
                            <figure>
                                <img name="imagem" src="https://images.tcdn.com.br/img/img_prod/701909/casaco_bebe_marrom_com_capuz_e_botoes_premium_pre_venda_1992480275_2_612ed7f7f919001114dd8273364b9977.jpg" alt="">
                                <label for="imagem">Imagem</label>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="divisoria-2">
                    <div class="informacoes-salvar-cancelar">
                        <div class="informacoes">
                            <label for="informacoes">Informações adicionais</label>
                            <textarea name="informacoes" id="informacoes"></textarea>
                        </div>
                        <div class="salvar-cancelar">
                            <div class="salvar">
                                <button type="submit">Salvar</button>
                            </div>
                            <div class="cancelar">
                                <a href="tela-produtos-adm.php">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>