<h1 class="for-sreader">Página inicial - Sustentech</h1>
<?php $current = 'home'; ?>

<div class="container">	
	<div class="wrapper sm-margin">
		<h2 class="ta-center">Resumo</h2><hr>

		<?php $empresas = $empresa->getAllCompanies(); ?>

		<div class="navigation d-flex fw-wrap fd-md-column ai-md-center jc-center">
			<div class="notify d-flex fd-column ai-center jc-center">
				<h3>Empresas cadastradas:</h3>
				<strong><?php echo count($empresas); ?></strong>
			</div>

			<div class="notify d-flex fd-column ai-center jc-center">
				<h3>Quantidade total reutilizada:</h3>
				<?php foreach ($empresas as $em): ?>
					<p class="ta-center"><strong><?php echo $em['nome'] .': '. $consumo->TotalReuseCompany($em['id']); ?> m³</strong></p>
				<?php endforeach ?>
			</div>
		</div>
	</div>
</div>