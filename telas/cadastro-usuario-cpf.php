<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuario CPF</title>
    <link rel="stylesheet" href="css/cadastro-usuario-cpf/style-cadastro-usuario-cpf.css">
</head>
<body>
    <section class="banner-esquerdo">
        <h1>Seja bem-vindo</h1>
    </section>
    <section class="secao-principal">
        <section class="formulario">
            <div class="cabecalho">
                <h2>Cadastro de usuário</h2>
                <div class="pessoa-juridica-fisica">
                    <a class="juridica juridica-fisica" href="cadastro-usuario-cnpj.php">Pessoa jurídica</a>
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
                        <p style="text-align: center;">Imagem de perfil</p>
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
                        <a href="login.php">Cancelar</a>
                    </div>
                </div>
            </form>
        </section>
    </section>
</body>
</html>