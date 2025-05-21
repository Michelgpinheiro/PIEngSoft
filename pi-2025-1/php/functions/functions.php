<?php 
    // Não funciona
    function exibirMensagem($mensagem) {
        if (isset($mensagem)) {
            ?>
            <div class="mensagem-erro" id="mensagem-erro">
                <?=$mensagem?>
            </div>
            <script>
                // Oculta a mensagem após 4 segundos
                setTimeout(function() {
                    const msg = document.getElementById('mensagem-erro');
                    if (msg) {
                        msg.style.transition = 'opacity 0.5s ease';
                        msg.style.opacity = '0';
                        setTimeout(() => msg.remove(), 500); // Remove do DOM após o fade-out
                    }
                }, 4000);
            </script>
            <?php
            unset($mensagem);
        }
    }

?>