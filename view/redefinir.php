<h1 class="for-sreader">Recuperar senha - Sustentech</h1>
<?php $hasFooter = true; ?>
<?php $params = $site->getParams(); ?>

<?php if (isset($params['success'])): ?>
<div class="container">
    <img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85" class="m-auto mb-45">

    <div class="wrapper">
        <h2 class="ta-center">Recuperar Senha</h2>

        <hr>
        
        <div class="d-flex fd-column ai-center jc-center">
            <p class="ta-center mb-60">Enviamos para o seu e-mail uma senha temporária. Com ela você poderá acessar sua conta e atualizar a senha no nosso sistema.</p>

            <a href="" class="cta cta-light cta-small">Fazer o login</a>
        </div>
    </div>
</div>
<?php else: ?>
<div class="container">
    <img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85" class="m-auto mb-45">

    <div class="wrapper">
        <h2 class="ta-center">Recuperar Senha</h2>

        <hr>

        <form method="post" action="conta/redefinir" class="form" novalidate>
            <div class="group">
                <label for="usermail">E-mail *</label>
                <input type="email" id="usermail" name="usermail" placeholder="exemplo@sustentech.com.br">
            </div>

            <div class="group d-flex jc-flex-end ai-center">
                <a href="" class="cta cta-light">Voltar</a>                
                <button class="cta" type="submit">Enviar</button>
            </div>

            <?php if (isset($params['error'])): ?>
                <div class="message invalid">O e-mail informado não foi encontrado em nossa base de dados, por favor verifique se o e-mail está correto ou crie uma conta.</div>
            <?php endif; ?>
        </form>
    </div>
</div>
<?php endif; ?>