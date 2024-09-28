<?php 

	$current = 'perfil';

    $url = $_SERVER['REQUEST_URI'];
    $query = parse_url($url, PHP_URL_QUERY);
    parse_str($query, $params);

?>
<h1 class="for-sreader">Perfil - Sustentech</h1>

<div class="container">
    <div class="wrapper sm-margin">
    	<h2 class="ta-center">Editar dados da conta</h2>

    	<form method="post" action="conta/editar" class="form" novalidate>
            <div class="group">
                <label for="username">Nome *</label>
                <input type="email" id="username" name="username" value="<?php echo $_SESSION['user']['nome']; ?>">
            </div>

            <div class="group">
                <label for="usermail">E-mail *</label>
                <input type="email" id="usermail" name="usermail" value="<?php echo $_SESSION['user']['email']; ?>">
            </div>

            <div class="group change-pass">
                <label for="userpass">Senha *</label>
                <input type="password" id="userpass" name="userpass" placeholder="***********">
                <button type="button" class="password"><i class="icon-eye"></i></button>
                <small>Deixe o campo vazio caso queira manter a senha</small>
            </div>

            <?php if (isset($params['update'])): ?>
                <?php if ($params['update'] == 'success'): ?>
                    <div class="message success">Conta atualizada</div>
                <?php else: ?>
                    <div class="message invalid">Erro ao atualizar conta</div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="group d-flex jc-flex-end ai-center">
                <a href="painel-administrativo" class="cta cta-light">Voltar</a>                
                <button class="cta" type="submit">Salvar</button>
            </div>
        </form>
    </div>
</div>