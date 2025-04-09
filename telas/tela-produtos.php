<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/tela-produtos/style-tela-produtos.css">
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
                <li><a class="selected-page">Produtos</a></li>
                <li><a href="contate-nos.php" style="font-size: 13px;">Contrate-nos</a></li>
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
            <div class="categoria-row">
                <h2>Seus Produtos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.meumoveldemadeira.com.br/cdn/shop/files/G0A4130_600x400.jpg?v=1734975217" alt="">
                        </figure>
                        <h3>Mesa de madeira</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: black;" href="tela-pagamento.php">Leiloar</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.meumoveldemadeira.com.br/cdn/shop/files/G0A4130_600x400.jpg?v=1734975217" alt="">
                        </figure>
                        <h3>Mesa de madeira</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: white;" href="tela-pagamento.php">Em Leilão</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.meumoveldemadeira.com.br/cdn/shop/files/G0A4130_600x400.jpg?v=1734975217" alt="">
                        </figure>
                        <h3>Mesa de madeira</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: white;" href="#" id="btn-dar-lance">Recusado</a>
                    </div>

                    <div class="popup-container popup-container-recusa" id="popup-lance">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <label for="motivo-recusa">Motivo da recusa</label>
                            <p class="popup-motivo-recusa">Você não pode leiloar uma arma com numeração raspada</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.meumoveldemadeira.com.br/cdn/shop/files/G0A4130_600x400.jpg?v=1734975217" alt="">
                        </figure>
                        <h3>Mesa de madeira</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: black;" id="btn-dar-lance2" href="#">Resultado</a>
                    </div>

                    <div class="popup-container popup-container-resultado" id="popup-lance2">
                        <div class="popup-content">
                        <span id="close-popup2" class="close-popup">&times;</span>
                            <div class="valor-contato">
                                <div class="lance-valor">
                                    <label for="valor-lance">Valor</label>
                                    <p>R$2500,00</p>
                                </div>
                                <div class="lance-contato">
                                    <label for="contato-lance">Contato</label>
                                    <p>(88)91234-5678</p>
                                </div>
                            </div>
                            <label for="observacoes-lance">Observações</label>
                            <p>Achei o produto muito bom, tão bom que quero arremata-lo o mais rápido possível!</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure>
                            <img src="https://www.meumoveldemadeira.com.br/cdn/shop/files/G0A4130_600x400.jpg?v=1734975217" alt="">
                        </figure>
                        <h3>Mesa de madeira</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: black;" href="tela-pagamento.php">Em análise</a>
                    </div>
                </div>
                <div class="adicionar-produto">
                    <a href="">
                        <figure>
                            <img src="https://cdn-icons-png.flaticon.com/512/2661/2661440.png" alt="">
                            <p>Adicionar</p>
                        </figure>
                    </a>
                </div>
            </div>
        </section>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnDarLance = document.getElementById('btn-dar-lance');
            const popupLance = document.getElementById('popup-lance');
            const closePopup = document.getElementById('close-popup');

            const btnDarLance2 = document.getElementById('btn-dar-lance2');
            const popupLance2 = document.getElementById('popup-lance2');
            const closePopup2 = document.getElementById('close-popup2');

            // Exibir o popup ao clicar no botão "Dar lance"
            btnDarLance.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance.style.display = 'block';  // Mostrar o popup
            });
            btnDarLance2.addEventListener('click', function(event) {
                event.preventDefault();  // Prevenir o comportamento padrão do link
                popupLance2.style.display = 'block';  // Mostrar o popup
            });


            // Fechar o popup ao clicar no "X"
            closePopup.addEventListener('click', function() {
                popupLance.style.display = 'none';  // Ocultar o popup
            });
            closePopup2.addEventListener('click', function() {
                popupLance2.style.display = 'none';  // Ocultar o popup
            });
            

            // Fechar o popup se clicar fora dele
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance.style.display = 'none';
                }
            });
            window.addEventListener('click', function(event) {
                if (event.target === popupLance) {
                    popupLance2.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>