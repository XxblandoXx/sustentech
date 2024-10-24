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
			        <button class="cta" value="0">3 meses</button>
			        <button class="cta" value="1">6 meses</button>
			        <button class="cta cta-dark" value="2">12 meses</button>
			    </div>

				<div class="chart-projections d-flex ai-center jc-center" style="width: 850px; height: 450px; max-width: 100%;"></div>

				<script>
					var dataDrawChart = <?php echo $consumo->getProjections($params['company']); ?>;
					dataDrawChart.unshift(['Período', 'Reutilização (m³)', 'Consumo (m³)', 'Custo (R$)']);
				</script>
				

				<small class="ta-center d-block mt-45">Quantidade total reutilizada: <strong><?php echo $consumo->TotalReuseCompany($params['company']); ?> m³</strong></small>
			<?php else: ?>
				<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado, volta para a <a href="ferramentas/monitoramento">área de monitoramento</a> e faça o cadastro.</h3>
			<?php endif ?>
		</div>
	</div>
<?php else: ?>
	<div class="container">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Projeções</h2><hr>

			<?php if (count($companies) > 1): ?>
				<div class="list-companies">
					<h3 class="ta-center mb-20">Selecione a empresa:</h3>

					<div class="navigation d-flex fw-wrap fd-md-column ai-md-center jc-center">
				        <?php foreach ($companies as $company): ?>
				        <a href="ferramentas/projecoes?company=<?php echo $company['id']; ?>" class="cta cta-light">
				            <?php echo $company['nome']; ?>
				        </a>
				        <?php endforeach ?>
				    </div>
				</div>
			<?php else: ?>
				<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado.</h3>
			<?php endif; ?>	
		</div>
	</div>
<?php endif ?>