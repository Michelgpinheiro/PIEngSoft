<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário físico</title>
    <link rel="stylesheet" href="css/cadastro-usuario-fisico-adm/style-cadastro-usuario-fisico-adm.css">
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
                <form style="padding: 0px; background-color: white;" action="">
                    <input style="border-radius: 0px; text-indent: 8px;" type="text" name="buscar" id="buscar" placeholder="Pesquisar...">
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
                <li><a class="selected-page">Usuários</a></li>
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
            <section class="secao-principal">
                <section class="formulario">
                <div class="cabecalho">
                    <h2>Cadastro de usuário</h2>
                    <div class="pessoa-juridica-fisica">
                        <a class="juridica juridica-fisica" href="cadastro-usuario-juridico-adm.php">Pessoa jurídica</a>
                        <div class="fisica juridica-fisica">Pessoa física</div>
                    </div>
                    <div class="separador"></div>
                </div>
                <form action="" method="">

                    <div class="div1">
                        <div class="nome-telefone-cpf">
                            <div class="nome">
                                <label for="nome-completo">Nome Completo</label>
                                <input type="text" name="nome-completo" id="nome-completo">
                            </div>
                            <div class="cpf-telefone">
                                <div class="cpf">
                                    <label for="cpf">CPF</label>
                                    <input type="text" name="cpf" id="cpf">
                                </div>
                                <div class="telefone">
                                    <label for="telefone">Telefone</label>
                                    <input type="tel" name="telefone" id="telefone">
                                </div>
                            </div>
                        </div>
                        <div class="imagem-perfil">
                            <img src="imagens/Pi-symbol.svg.png" alt="">
                            <p style="text-align: center; font-weight: bold;">Imagem de perfil</p>
                        </div>
                    </div>


                    <div class="div2">
                        <label for="rg">RG</label>
                        <input type="text" name="rg" id="rg">
                    </div>

                    <div class="div3">
                        <div class="estado-cep-bairro-numero">
                            <div class="estado-cep">
                                <div class="estado">
                                    <label for="estado">Estado</label>
                                    <input type="text" name="estado" id="estado">
                                </div>
                                <div class="cep">
                                    <label for="cep">CEP</label>
                                    <input type="text" name="cep" id="cep">
                                </div>
                            </div>
                            <div class="bairro-numero">
                                <div class="bairro">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" id="bairro">
                                </div>
                                <div class="numero">
                                    <label for="numero">Número</label>
                                    <input type="text" name="numero" id="numero">
                                </div>
                            </div>
                        </div>
                        <div class="endereco-complemento-cidade">
                            <div class="endereco">
                                <label for="endereco">Endereço</label>
                                <input type="text" name="endereco" id="endereco">
                            </div>
                            <div class="complemento-cidade">
                                <div class="complemento">
                                    <label for="complemento">Complemento</label>
                                    <input type="text" name="complemento" id="complemento">
                                </div>
                                <div class="cidade">
                                    <label for="cidade">Cidade</label>
                                    <input type="text" name="cidade" id="cidade">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="div4">
                        <div class="email-senha-confirmarsenha">
                            <div class="email">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email">
                            </div>
                            <div class="senha-confirmarsenha">
                                <div class="senha">
                                    <label for="senha">Senha</label>
                                    <input type="password" name="senha" id="senha">
                                </div>
                                <div class="confirmarsenha">
                                    <label for="confirmarsenha">Confirmar senha</label>
                                    <input type="password" name="confirmarsenha" id="confirmarsenha">
                                </div>
                            </div>
                        </div>
                        <div class="avancar-cancelar salvar-cancelar">
                            <button type="submit">Enviar</button>
                            <a href="listagem-usuarios-adm.php">Cancelar</a>
                        </div>
                    </div>
                </form>
            </section>
            </section>
        </section>
    </main>
</body>
</html>