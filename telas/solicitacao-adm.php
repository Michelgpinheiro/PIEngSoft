<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de administrador </title>
    <link rel="stylesheet" href="css/solicitacao-adm/style-solicitacao-adm.css">
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
                <li><a href="usuarios.php">Usuários</a></li>
                <li><a class="selected-page" style="font-size: 13px;">Solicitações</a></li>
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
            <div class="categoria-row">
                <h2>Seus Produtos</h2>
                <div class="row"></div>
            </div>
            <div class="iniciando-leilao">
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
                                        <img src="https://images.tcdn.com.br/img/img_prod/1124863/controle_original_ps5_sem_fio_dualsense_sony_starlight_blue_12972_1_9293d13567c3479519bcb59e9bfc673a.jpg" alt="">
                                    </figure>
                                    <figure>
                                        <img src="https://i.pinimg.com/736x/86/a6/c8/86a6c8fedfd94016dcddc0c72e52796b.jpg" alt="">
                                    </figure>
                                </div>
                                <div class="layer-2">
                                    <figure>
                                        <img src="https://wallpapercave.com/wp/wp12709749.jpg" alt="">
                                    </figure>
                                    <figure>
                                        <img src="https://m.media-amazon.com/images/I/518tkiWGd0L._AC_SY350_.jpg" alt="">
                                    </figure>
                                </div>
                            </div>
                            <div class="pracas-reducao-valorincremento">
                                <div class="pracas">
                                    <label for="pracas">Praças</label>
                                    <input type="number" name="pracas" id="pracas">
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
                        <button type="submit" class="aprovar">Aprovar</button>
                        <a href="#" id="btn-dar-lance" class="recusar">Recusar</a>
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