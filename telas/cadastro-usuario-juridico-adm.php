<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário jurídico</title>
    <link rel="stylesheet" href="css/cadastro-usuario-juridico-adm/style-cadastro-usuario-juridico-adm.css">
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
                <form style="padding: 0px;" action="">
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
                <li><a class="selected-page">Usuários</a></li>
                <li><a href="solicitacao-adm.php" style="font-size: 13px;">Solicitações</a></li>
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
            <section class="secao-principal">
                <section class="formulario">
                    <div class="cabecalho">
                        <h2>Cadastro de usuário</h2>
                        <div class="pessoa-juridica-fisica">
                            <div class="juridica juridica-fisica">Pessoa jurídica</div>
                            <a href="cadastro-usuario-fisico-adm.php" class="fisica juridica-fisica">Pessoa física</a>
                        </div>
                        <div class="separador"></div>
                    </div>
                    <form style="background-color: lightgrey;" action="" method="">

                        <div class="div1">
                            <div class="nome-telefone-cpf">
                                <div class="razao">
                                    <label for="razao-social">Razão social</label>
                                    <input class="input-form" type="text" name="razao-social" id="razao-social">
                                </div>
                                <div class="fantasia">
                                    <label for="nome-fantasia">Nome fantasia</label>
                                    <input class="input-form" type="text" name="nome-fantasia" id="nome-fantasia">
                                </div>
                            </div>
                            <div class="imagem-perfil">
                                <img src="imagens/Greek_uc_pi.svg" alt="">
                                <p style="text-align: center;">Imagem de perfil</p>
                            </div>
                        </div>


                        <div class="div2">
                            <div class="cnpj">
                                <label for="cnpj">CNPJ</label>
                                <input class="input-form" type="text" name="cnpj" id="cnpj">
                            </div>
                            <div class="telefone">
                                <label for="telefone">Telefone</label>
                                <input class="input-form" type="tel" name="telefone" id="telefone">
                            </div>
                        </div>

                        <div class="div3">
                            <div class="estado-cep-bairro-numero">
                                <div class="estado-cep">
                                    <div class="estado">
                                        <label for="estado">Estado</label>
                                        <input class="input-form" type="text" name="estado" id="estado">
                                    </div>
                                    <div class="cep">
                                        <label for="cep">CEP</label>
                                        <input class="input-form" type="text" name="cep" id="cep">
                                    </div>
                                </div>
                                <div class="bairro-numero">
                                    <div class="bairro">
                                        <label for="bairro">Bairro</label>
                                        <input class="input-form" type="text" name="bairro" id="bairro">
                                    </div>
                                    <div class="numero">
                                        <label for="numero">Número</label>
                                        <input class="input-form" type="text" name="numero" id="numero">
                                    </div>
                                </div>
                            </div>
                            <div class="endereco-complemento-cidade">
                                <div class="endereco">
                                    <label for="endereco">Endereço</label>
                                    <input class="input-form" type="text" name="endereco" id="endereco">
                                </div>
                                <div class="complemento-cidade">
                                    <div class="complemento">
                                        <label for="complemento">Complemento</label>
                                        <input class="input-form" type="text" name="complemento" id="complemento">
                                    </div>
                                    <div class="cidade">
                                        <label for="cidade">Cidade</label>
                                        <input class="input-form" type="text" name="cidade" id="cidade">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="div4">
                            <div class="email-senha-confirmarsenha">
                                <div class="email">
                                    <label for="email">Email</label>
                                    <input class="input-form" type="email" name="email" id="email">
                                </div>
                                <div class="senha-confirmarsenha">
                                    <div class="senha">
                                        <label for="senha">Senha</label>
                                        <input class="input-form" type="password" name="senha" id="senha">
                                    </div>
                                    <div class="confirmarsenha">
                                        <label for="confirmarsenha">Confirmar senha</label>
                                        <input class="input-form" type="password" name="confirmarsenha" id="confirmarsenha">
                                    </div>
                                </div>
                            </div>
                            <div class="avancar-cancelar salvar-cancelar">
                                <button type="submit">Enviar</button>
                                <a href="login.php">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </section>
            </section>
        </section>
    </main>
</body>
</html>