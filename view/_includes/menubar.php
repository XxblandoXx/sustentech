<?php ?>

<div class="menubar pos-fixed d-flex fw-wrap ai-center jc-center">
	<a href="inicio" class="menu-item <?php echo $current == 'home' ? 'current' : ''; ?>">
		<i class="icon-home"></i><span class="d-md-none">Home</span>
	</a>

	<div class="gap"></div>

	<a href="painel-informativo" class="menu-item <?php echo $current == 'painel-informativo' ? 'current' : ''; ?>">
		<i class="icon-info"></i><span class="d-md-none">Painel Informativo</span>
	</a>

	<div class="gap"></div>
	
	<a href="ferramentas" class="menu-item <?php echo $current == 'ferramentas' ? 'current' : ''; ?>">
		<i class="icon-tools"></i><span class="d-md-none">Ferramentas</span>
	</a>

	<div class="gap"></div>
	
	<?php if ($site->verify_session()): ?>

	<a href="painel-administrativo" class="menu-item <?php echo $current == 'perfil' ? 'current' : ''; ?>">
		<i class="icon-profile"></i><span class="d-md-none">Painel Administrativo</span>
	</a>
	
	<div class="gap"></div>

	<button type="button" value="logoff" class="menu-item open-modal confirm-logout">
		<i class="icon-logout"></i><span class="d-md-none">Logout</span>
	</button>
	
	<div id="logoff" class="modal hide">
		<div class="modal-content">
			<div class="modal-head">
				<button class="close-modal d-block" aria-label="Fechar modal" value="logoff">
					<i class="icon-close"></i>
				</button>

				<h2 class="tt-uppercase ta-center">Deseja sair do sistema?</h2>
			</div>

			<hr>

			<div class="modal-body mt-60">
				<form action="conta/logout" method="post" class="d-flex jc-flex-end ai-flex-end gap-24">
					<button type="button" class="close-modal cta cta-light" value="logoff">Cancelar</button>
					<button type="submit" class="cta">Sair</button>
				</form>
			</div>
		</div>
	</div>
		
	<?php else: ?>
		
		<a href="" class="menu-item">
			<i class="icon-logout"></i><span class="d-md-none">Logout</span>
		</a>

	<?php endif; ?>

</div>