<h1 class="for-sreader">Monitoramento - Sustentech</h1>

<?php 

$current = 'ferramentas';
$companies = $empresa->getAllCompanies();
$params = $site->getParams();

if (count($companies) == 1) $params['company'] = $companies[0]['id'];

?>

<?php if (isset($params['company'])): ?>
	<div class="container-fluid">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Monitoramento</h2><hr>

			<div class="monitoramento-table">
				<button class="cta create open-modal cta-small mb-20" value="add-new-line">Adicionar <i class="icon-plus"></i></button>

				<?php $consumption = $consumo->getAllConsumption($params['company']); ?>

				<?php if ($consumption): ?>
					<table>
						<thead>
							<tr>
								<th>Data de Referência</th>
								<th>Consumo</th>
								<th>Última Atualização</th>
								<th class="ta-center">---</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($consumption as $cons): ?>
							<tr>
								<td><?php echo date_format(date_create($cons['referencia']), 'd/m/Y') ?></td>
								<td><?php echo $cons['valor'] ?>m³</td>
								<td><?php echo date_format(date_create($cons['updated']), 'd/m/Y H:s') ?></td>
								<td>
									<div class="d-flex jc-center gap-12">
										<button class="cta update" aria-label="Editar linha de consumo"><i class="icon-edit"></i></button>
										<button class="cta delete" aria-label="Remover linha de consumo"><i class="icon-trash"></i></button>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				<?php else: ?>
					<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado.</h3>
				<?php endif ?>
				
				<div class="modal hide" id="add-new-line">
					<div class="modal-content">
						<div class="modal-head">
							<button class="close-modal d-block" aria-label="Fechar modal" value="add-new-line">
								<i class="icon-close"></i>
							</button>

							<h2 class="tt-uppercase ta-center">Adicionar novo consumo</h2>
						</div>

						<hr>

						<div class="modal-body mt-60">
							<form action="#" method="post" class="add-new-consumption" novalidate>
								<legend>(<span>*</span>) Campos obrigatórios</legend>

		                        <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>
		                        <div class="message success d-none">Dados de empresa atualizados com sucesso!</div>

		                        <input type="hidden" name="new-line-company" value="<?php echo $params['company']; ?>">

		                        <div class="group">
		                        	<label for="new-line-type-file" class="d-flex ai-center gap-12">
		                        		<input type="checkbox" class="switch" id="new-line-type-file" name="new-line-type-file" value="sim">
		                        		Adicionar por planilha
		                        	</label>
		                        </div>

	                        	<div class="has-file group pos-relative d-none mt-45 mb-20">
	                        		<label for="new-line-file"><i class="icon-paperclip"></i> Escolher Arquivo</label>
	                        		<input type="file" name="new-line-file" id="new-line-file">
	                        	</div>

		                        <div class="no-file d-block">
		                        	<div class="group">
			                            <label for="new-line-reference">Data de referência *</label>
			                            <input type="date" id="new-line-reference" name="new-line-reference">
			                        </div>

			                        <div class="group pos-relative">
			                            <label for="new-line-value">Valor do consumo *</label>
			                            <input type="text" id="new-line-value" name="new-line-value">
			                            <div class="placeholder final">m³</div>
			                        </div>
		                        </div>
								
								<div class="d-flex jc-flex-end ai-flex-end gap-24 mt-45">
									<button type="button" class="close-modal cta cta-light" value="add-new-line">Cancelar</button>
									<button type="submit" class="cta">Salvar</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="container">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Monitoramento</h2><hr>

			<?php if (count($companies) > 1): ?>
				<div class="list-companies">
					<h3 class="ta-center mb-20">Selecione a empresa:</h3>

					<div class="navigation d-flex fw-wrap fd-md-column ai-md-center jc-center">
				        <?php foreach ($companies as $company): ?>
				        <a href="ferramentas/monitoramento?company=<?php echo $company['id']; ?>" class="cta cta-light">
				            <?php echo $company['nome']; ?>
				        </a>
				        <?php endforeach ?>
				    </div>
				</div>
			<?php endif; ?>			
		</div>
	</div>
<?php endif ?>