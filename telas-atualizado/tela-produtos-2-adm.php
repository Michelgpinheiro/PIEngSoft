<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="css/tela-produtos-2-adm/-style-tela-produtos-2-adm.css">
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
            <div class="categoria-row">
                <h2>Seus Produtos</h2>
                <div class="row"></div>
            </div>
            <div class="iniciando-leilao" style="padding-right: 57px;">
                <h2>Iniciando Leilão</h2>
                <div class="main-div-1">
                    <div class="nome-imagens-pracas-reducao-valorincremento">
                        <div class="nome">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>
                        <label for="">Imagens</label>
                        <div class="img-prv">
                            <div class="imagens">
                                <div class="layer-1">
                                    <figure>
                                        <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/04/230418093558-01-new-lincoln-nautilus-suv.webp?w=1024" alt="">
                                    </figure>
                                    <figure>
                                        <img src="https://images.cars.com/cldstatic/wp-content/uploads/lincoln-nautilus-2024-05-exterior-rear-angle-red-scaled.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="layer-2">
                                    <figure>
                                        <img src="https://www.edmunds.com/assets/m/cs/blteebe6f0d6ebd7869/6621fc35b8b5cee09edbf5a2/2024_lincoln_nautilus_front.jpg" alt="">
                                    </figure>
                                    <figure>
                                        <img src="https://www.cnnbrasil.com.br/wp-content/uploads/sites/12/2023/04/230418093843-03-new-lincoln-nautilus-suv.webp?w=1024" alt="">
                                    </figure>
                                </div>
                            </div>
                            <div class="pracas-reducao-valorincremento">
                                <div class="pracas">
                                    <label for="pracas">Praças</label>
                                    <input type="number" name="pracas" id="pracas" max="2">
                                </div>
                                <div class="reducao">
                                    <label for="reducao">Redução (%)</label>
                                    <input type="number" name="reducao" id="reducao">
                                </div>
                                <div class="valorincremento">
                                    <label for="valorincremento">Valor de incremento</label>
                                    <input type="number" name="valorincremento" id="valorincremento">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="data-horario-inicio-final-diferenca">
                        <div class="d-h-inicio">
                            <label for="inicio">Data/Horário de início</label>
                            <input type="datetime-local" name="inicio" id="inicio">
                        </div>
                        <div class="d-h-final">
                            <label for="final">Data/Horário do final</label>
                            <input type="datetime-local" name="final" id="final">
                        </div>
                        <div class="diferenca-dias">
                            <label for="diferenca-dias">Diferença de dias entre praça</label>
                            <input type="number" name="diferenca-dias" id="diferenca-dias">
                        </div>
                    </div>
                </div>
                <div class="main-div-2">
                    <div class="observacoes-contato">
                        <div class="observacoes">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes"></textarea>
                        </div>
                        <div class="contato">
                            <label for="contato">Contato</label>
                            <input type="tel" name="contato" id="contato">
                        </div>
                    </div>
                    <div class="aprovar-recusar">
                        <button type="submit">Enviar</button>
                        <a href="tela-produtos-adm.php" class="recusar">Cancelar</a>
                    </div>

                    <div class="popup-container" id="popup-lance">
                        <div class="popup-content">
                        <span id="close-popup" class="close-popup">&times;</span>
                            <label for="motivo-recusa">Motivo da recusa</label>
                            <textarea id="motivo-recusa" name="motivo-recusa" rows="4" cols="30"></textarea><br><br>
                            <button id="enviar-lance">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
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