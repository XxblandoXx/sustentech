<h1 class="for-sreader">Monitoramento - Sustentech</h1>
<?php $current = 'ferramentas'; ?>
<?php $companies = $empresa->ListarEmpresas(); ?>

<?php $params = $site->getParams(); ?>

<div class="wrapper sm-margin">
	<h2 class="ta-center">Área de Monitoramento</h2>

	<hr>

	<?php if (count($companies) > 1): ?>
		<?php if (isset($params['company'])): ?>
			<table>
				<thead>
					<tr>
						<th>Campo</th>
						<th>Campo</th>
						<th>Campo</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>dado 1</td>
						<td>dado 2</td>
						<td>dado 3</td>
						<td>actions</td>
					</tr>
				</tbody>
			</table>
		<?php else: ?>
		<h3 class="ta-center mb-20">Selecione a empresa:</h3>
		<div class="navigation d-flex fw-wrap fd-md-column ai-md-center jc-center">
	        <?php foreach ($companies as $company): ?>
	        <a href="ferramentas/monitoramento/?company=<?php echo $company['id']; ?>" class="cta cta-light">
	            <?php echo $company['nome']; ?>
	        </a>
	        <?php endforeach ?>
	    </div>
		<?php endif; ?>
	<?php else: ?>
		<table>
			<thead>
				<tr>
					<th>Campo</th>
					<th>Campo</th>
					<th>Campo</th>
					<th>Campo</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
	<?php endif; ?>
</div>