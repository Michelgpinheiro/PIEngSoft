<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">d
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/tela-produtos-adm/--style-tela-produtos-adm.css">
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
        <nav class="nav-movel" style="padding-top: 31.5px;">
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
            <div class="categoria-row">
                <h2>Seus Produtos</h2>
                <div class="row"></div>
            </div>
            <div class="cards-section-1">
                <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://cabralmotor.fbitsstatic.net/img/p/cg-160-titan-70286/257551-6.jpg?w=1000&h=1000&v=202504071324&qs=ignore" alt="">
                        </figure>
                        <h3>Honda GC 160 Titan</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$14.500,00</h4>
                    </div>
                    <div class="dar-lance leiloar">
                        <a href="tela-produtos-2-adm.php">Leiloar</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://images.tcdn.com.br/img/img_prod/1124863/controle_original_ps5_sem_fio_dualsense_sony_starlight_blue_12972_1_9293d13567c3479519bcb59e9bfc673a.jpg" alt="">
                        </figure>
                        <h3>Dual Sense</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$350,00</h4>
                    </div>
                    <div class="dar-lance">
                        <a style="color: white;" href="tela-pagamento-adm.php">Em Leilão</a>
                    </div>
                </div>
                <div class="card">
                    <div class="inner-card">
                        <figure style="width: 250px; height: 150px">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTntDd8XR-7U4ox3JNkIgC5q12fE2D3cMyjPQ&s" alt="">
                        </figure>
                        <h3>Taurus 92 9mm</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$2350,00</h4>
                    </div>
                    <div class="dar-lance recusado">
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
                        <figure style="width: 250px; height: 150px">
                            <img src="https://s2-autoesporte.glbimg.com/PhjGqvSsrjhXhcRaiQPVcGl-L1Y=/0x0:1980x1204/924x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_cf9d035bf26b4646b105bd958f32089d/internal_photos/bs/2024/w/r/ln4uNrTKiFAf9XmqHtaQ/fiat-titano-ambientadas-007.jpg" alt="">
                        </figure>
                        <h3>Fiat Titano</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$213.000,00</h4>
                    </div>
                    <div class="dar-lance resultado">
                        <a id="btn-dar-lance2" href="#">Resultado</a>
                    </div>

                    <div class="popup-container popup-container-resultado" id="popup-lance2">
                        <div class="popup-content">
                        <span id="close-popup2" class="close-popup">&times;</span>
                            <div class="valor-contato">
                                <div class="lance-valor">
                                    <label for="valor-lance">Valor</label>
                                    <p>R$213.000,00</p>
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
                        <figure style="width: 250px; height: 150px">
                            <img src="https://www.artesintonia.com.br/cdn/shop/files/ANN03-escultura-bronze-buda-bali-indonesia-importado-casa-budismo-decoracao-1-01.jpg?v=1708638636" alt="">
                        </figure>
                        <h3 style="font-size: 14px;">Escultura Buldista de Bronze</h3>
                        <div class="card-informations-row"></div>
                        <h4>Valor: R$1600,00</h4>
                    </div>
                    <div class="dar-lance em-analise">
                        <a href="tela-pagamento-adm.php">Em análise</a>
                    </div>
                </div>
                <div class="adicionar-produto">
                    <a href="cadastro-produtos-eletronicos-adm.php">
                        <figure style="max-width: 30%; margin-top: 50px; margin-left: 70px;">
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