<h1 class="for-sreader">Login - Sustentech</h1>
<?php $hasFooter = true; ?>

<div class="container">
	<img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85" class="m-auto mb-45">

	<div class="wrapper">
		<h2 class="ta-center">Seja bem-vindo(a) ao nosso sistema</h2>

		<form method="post" action="conta/conectar">
			<div class="group">
                <label for="username">E-mail*</label>
                <input type="email" id="username" name="username" placeholder="exemplo@sustentech.com.br">
            </div>

            <div class="group change-pass">
                <label for="password">Senha*</label>
                <input type="password" id="password" name="password" placeholder="***********">
                <button type="button" class="password" aria-label="Ver senha"><i class="icon-eye"></i></button>
            </div>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'failed'): ?>
                <div class="message invalid">Usuário e/ou senha inválidos.</div>
            <?php endif; ?>

            <div class="group margin">
                <p>Esqueceu a senha? <a href="conta/redefinir-senha">Clique aqui.</a></p>
                <p>Deseja realizar o cadastro? <a href="conta/registre-se">Cadastre-se aqui.</a></p>
            </div>

            <div class="group"><span></span></div>

			<div class="d-flex ai-center jc-flex-end gap-24">
				<a href="inicio" class="cta-simple">acessar sem conta</a>
				<button type="submit" class="cta">Conectar</button>
			</div>
		</form>
	</div>
</div>