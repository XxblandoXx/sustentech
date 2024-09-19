<h1 class="for-sreader">Recuperar senha - Sustentech</h1>
<?php $hasFooter = true; ?>

<div class="container">
    <img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85" class="m-auto mb-45">

    <div class="wrapper">
        <h2 class="ta-left">Recuperar Senha</h2>

        <form method="post" action="conta/cadastrar" class="form" novalidate>
            <div class="group">
                <label for="usermail">E-mail *</label>
                <input type="email" id="usermail" name="usermail" placeholder="exemplo@sustentech.com.br">
            </div>

            <div class="group d-flex jc-flex-end ai-center">
                <a href="" class="cta cta-light">Voltar</a>                
                <button class="cta" type="submit">Enviar</button>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="message success">Uma mensagem foi enviada para o seu e-mail com as instruções para recuperar sua senha.</div>
            <?php endif; ?>
        </form>
    </div>
</div>