<h1 class="for-sreader">Ferramentas - Sustentech</h1>
<?php $current = 'ferramentas'; ?>

<div class="container">
	<div class="wrapper sm-margin">
		<h2 class="ta-center tt-uppercase">Ferramentas</h2>

		<hr>

		<div class="navigation d-flex fw-wrap fd-md-column jc-center">
			<button type="button" value="simulador" class="open-modal cta cta-to-icon">
				<i class="icon-calculator"></i> simulador
			</button>
			
			<?php if ($site->verify_session()): ?>
			<a href="ferramentas/monitoramento" class="cta cta-to-icon">
				<i class="icon-chart-bar"></i> monitoramento
			</a>

			<a href="ferramentas/projecoes" class="cta cta-to-icon">
				<i class="icon-chart-line"></i> projeções
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>

<div id="simulador" class="modal hide">
	<div class="modal-content">
		<div class="modal-head">
			<button class="close-modal d-block" value="simulador" aria-label="Fechar modal">
				<i class="icon-close"></i>
			</button>

			<h2 class="tt-uppercase ta-center">Simulador</h2>
		</div>

		<hr>

		<div class="modal-body mt-60">
			<form action="#" method="post" class="d-flex fw-md-wrap jc-md-flex-end jc-space-between ai-center gap-12">
				<div class="group col-auto">
					<label for="consumo">Consumo m³</label>
					<input type="text" name="consumo" id="consumo">
				</div>

				<button type="submit" class="cta mt-10">Calcular</button>
			</form>

			<div class="result"></div>
		</div>
	</div>
</div>