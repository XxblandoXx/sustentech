<h1 class="for-sreader">Projeções - Sustentech</h1>

<?php 

$current = 'ferramentas';
$companies = $empresa->getAllCompanies();
$params = $site->getParams();

if (count($companies) == 1) $params['company'] = $companies[0]['id'];

?>

<?php if (isset($params['company'])): ?>
	<div class="projecoes-container container-fluid">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Projeções</h2><hr>
			<?php $consumption = $consumo->getAllConsumption($params['company']); ?>

			<?php if ($consumption): ?>
				<div class="filters-projections gap-12 d-flex fw-wrap fd-md-column ai-md-center jc-center">
			        <button class="cta" value="1">3 meses</button>
			        <button class="cta" value="2">6 meses</button>
			        <button class="cta cta-dark" value="3">12 meses</button>
			    </div>

				<div class="chart-projections d-flex ai-center jc-flex-start"></div>

				<script>
					var dataDrawChart = <?php echo $consumo->getProjections($params['company']); ?>;
					dataDrawChart.unshift(['Período', 'Reutilização (m³)', 'Consumo (m³)', 'Custo de manutenção (R$)', 'Lucro (R$)']);
				</script>
				
			<?php else: ?>
				<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado, volta para a <a href="ferramentas/monitoramento">área de monitoramento</a> e faça o cadastro.</h3>
			<?php endif ?>

			<div class="d-flex fw-wrap gap-12 mt-45">
				<a href="ferramentas/projecoes" class="cta cta-light cta-small"><i class="icon-back"></i> Voltar</a>
				<a href="ferramentas/monitoramento" class="cta cta-dark cta-small d-flex ai-center jc-center">Área de monitoramento</a>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="container">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Projeções</h2><hr>

			<?php if (count($companies) > 1): ?>
				<div class="list-companies">
					<h3 class="mb-20">Selecione a empresa:</h3>

					<div class="navigation d-flex fw-wrap fd-column gap-16">
				        <?php foreach ($companies as $company): ?>
				        <a href="ferramentas/projecoes?company=<?php echo $company['id']; ?>" class="d-flex ai-center gap-12 jc-space-between">
				        	<span class="d-flex ai-center gap-12"><i class="icon-gear"></i><?php echo $company['nome']; ?></span>
				            <button class="cta cta-small cta-light tt-uppercase ml-15">Selecionar</button>
				        </a>
				        <?php endforeach ?>
				    </div>
				</div>
			<?php else: ?>
				<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado.</h3>
			<?php endif; ?>	

			<div class="d-flex fw-wrap gap-12 mt-60">
				<a href="ferramentas" class="cta cta-light cta-small"><i class="icon-back"></i> Voltar</a>
				<a href="ferramentas/monitoramento" class="cta cta-dark cta-small d-flex ai-center jc-center">Área de monitoramento</a>
			</div>
		</div>
	</div>
<?php endif ?>