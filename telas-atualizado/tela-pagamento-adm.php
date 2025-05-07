<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento</title>
    <link rel="stylesheet" href="css/tela-pagamento-adm/style-tela-pagamento-adm.css">
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
                <li><a href="categorias-adm.php">Categorias</a></li>
                <li><a href="tela-produtos-adm.php">Produtos</a></li>
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
            <a href="tela-inicial-adm.php" class="voltar">
                <img src="https://cdn-icons-png.flaticon.com/512/109/109618.png" alt="">
            </a>
            <section class="imagens">
                <figure class="imagem-principal">
                    <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/04/230418093558-01-new-lincoln-nautilus-suv.webp?w=1200&h=900&crop=1" alt="">
                    <h2>SUV Nautilus</h2>
                </figure>
                <div class="imagens-secundarias">
                    <figure class="img-sec-1">
                        <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/04/230418093843-03-new-lincoln-nautilus-suv.webp?w=1024" alt="">
                    </figure>
                    <figure class="img-sec-1">
                        <img src="https://media.lincoln.com/content/dam/lincolnmedia/lna/us/2024/10/Lincoln_2.jpg/jcr:content/renditions/cq5dam.web.374.210.jpeg" alt="">
                    </figure>
                </div>
            </section>
            <section class="produto-info">
                <div class="descricao">
                    <p><span>Descrição:</span> Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, quo perferendis quaerat ad dicta delectus voluptates tenetur id fugit perspiciatis. Repudiandae quisquam, iusto modi dicta dolore tempora harum sed illum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident porro aperiam possimus vitae, sit minima quisquam similique? Dolorem mollitia quia veritatis similique expedita dolorum velit repellendus. Consequuntur, sit! Incidunt, vero!</p>
                    <br>
                    <p><span>( ! ) Informações</span></p>
                    <p style="text-align: right; margin-right: 20px;"><span>Incremento:</span> R$500,00</p>
                    <br>
                    <nav>
                        <ul>
                            <li>Leiloeiro:</li>
                            <li>Localidade:</li>
                            <li>Leilão:</li>
                            <li>Categoria:</li>
                        </ul>
                    </nav>
                    <div class="dar-lance">
                        <a href="#" id="btn-dar-lance">Dar lance</a>
                        <!-- <a class="voltar" href="tela-inicial.php">Voltar</a> -->
                    </div>

                    <div class="popup-container" id="popup-lance">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <div class="valor-contato">
                                <div class="lance-valor">
                                    <label for="valor-lance">Valor</label>
                                    <input type="number" id="valor-lance" step="any">
                                </div>
                                <div class="lance-contato">
                                    <label for="contato-lance">Contato</label>
                                    <input type="tel" id="contato-lance">
                                </div>
                            </div>
                            <label for="observacoes-lance">Observações</label>
                            <textarea id="observacoes-lance" rows="4" cols="30"></textarea><br><br>
                            <button id="enviar-lance">Enviar</button>
                        </div>
                    </div>

                </div>
                <br>
                <div class="pracas">
                    <div class="praca-1">
                        <div class="praca-1-info">
                            <h3>1ª Praça</h3>
                            <div class="praca-inicio-fim">
                                <p><span>Início:</span> 28/03/2025</p>
                                <p><span>Fim:</span> 04/04/2025</p>
                            </div>
                        </div>
                        <div class="praca-info-row"></div>
                        <div class="praca-1-info2">
                            <p><span>Valor inicial:</span> R$1200,00</p>
                            <p><span>Último lance:</span> R$1320,00</p>
                        </div>  
                    </div>
                    <div class="praca-2 praca-1">
                    <div class="praca-1-info">
                            <h3>2ª Praça</h3>
                            <div class="praca-inicio-fim">
                                <p><span>Início:</span> 08/04/2025</p>
                                <p><span>Fim:</span> 12/04/2025</p>
                            </div>
                        </div>
                        <div class="praca-info-row"></div>
                        <div class="praca-1-info2">
                            <p><span>Valor inicial:</span> R$800,00</p>
                            <p style="color: transparent;">.</p>
                        </div>  
                    </div>
                </div>
            </section>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnDarLance = document.getElementById('btn-dar-lance');
            const popupLance = document.getElementById('popup-lance');
            const closePopup = document.getElementById('close-popup');

            // Exibir o popup ao clicar no botão "Dar lance"
            btnDarLance.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance.style.display = 'block';  // Mostrar o popup
            });

            // Fechar o popup ao clicar no "X"
            closePopup.addEventListener('click', function() {
                popupLance.style.display = 'none';  // Ocultar o popup
            });

            // Fechar o popup se clicar fora dele
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>