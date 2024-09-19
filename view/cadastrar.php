<h1 class="for-sreader">Cadastro - Sustentech</h1>
<?php $hasFooter = true; ?>

<div class="container">
    <img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85" class="m-auto mb-45">

    <div class="wrapper">
        <h2 class="ta-left">Cadastrar</h2>

        <form method="post" action="conta/cadastrar" class="form" novalidate>
            <div class="group">
                <label for="username">Nome *</label>
                <input type="email" id="username" name="username" placeholder="nome completo">
            </div>

            <div class="group">
                <label for="usermail">E-mail *</label>
                <input type="email" id="usermail" name="usermail" placeholder="exemplo@sustentech.com.br">
            </div>

            <div class="group change-pass">
                <label for="userpass">Senha *</label>
                <input type="password" id="userpass" name="userpass" placeholder="***********">
                <button type="button" class="password"><i class="icon-eye"></i></button>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="message invalid"><?php echo $_GET['error'] == 'nocreate' ? 'Falha ao cadastrar novo usuário.' : 'E-mail informado já possui cadastro.'; ?></div>
            <?php endif; ?>

            <div class="group d-flex jc-flex-end ai-center">
                <a href="" class="cta cta-light">Voltar</a>                
                <button class="cta" type="submit">Salvar</button>
            </div>
        </form>
    </div>
</div>