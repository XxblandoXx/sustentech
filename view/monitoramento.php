<h1 class="for-sreader">Monitoramento - Sustentech</h1>

<?php 

$current = 'ferramentas';
$companies = $empresa->getAllCompanies();
$params = $site->getParams();

if (count($companies) == 1) $params['company'] = $companies[0]['id'];

?>

<?php if (isset($params['company'])): ?>
	<div class="monitoramento container-fluid-x">
		<div class="wrapper sm-margin">
			<h2 class="ta-center">Área de Monitoramento</h2><hr>
			<?php $consumption = $consumo->getAllConsumption($params['company']); ?>

			<div class="monitoramento-table">
				<div class="d-flex fw-wrap jc-space-between">
					<button class="cta create open-modal cta-small mb-20" value="add-new-line">Adicionar <i class="icon-plus"></i></button>

					<?php if ($consumption): ?>
					<button class="cta cta-dark cta-small mb-20 change-view" value="chart-view">
						Visualizar gráfico <i class="icon-chart-bar"></i>
					</button>

					<button class="cta cta-dark cta-small mb-20 change-view d-none" value="table-view">
						Visualizar tabela <i class="icon-table"></i>
					</button>
					<?php endif; ?>
				</div>


				<?php if ($consumption): ?>
					<div class="table-view d-block">
						<table>
							<thead>
								<tr>
									<th>Data de Referência</th>
									<th>Consumo</th>
									<th>Reuso</th>
									<th>Valor pago</th>
									<th>Última Atualização</th>
									<th class="ta-center">---</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($consumption as $cons): ?>
								<tr id="cons-id-<?php echo $cons['id']; ?>">
									<td>
										<div class="reference" data-original="<?php echo $cons['referencia']; ?>">
											<?php echo date('d/m/Y', strtotime($cons['referencia'])); ?>
										</div>
									</td>

									<td>
										<div class="value" data-original="<?php echo $cons['valor']; ?>">
											<?php echo $cons['valor']; ?> m³
										</div>
									</td>

									<td>
										<div class="reuse" data-original="<?php echo $cons['reuso']; ?>">
											<?php echo $cons['reuso']; ?> m³
										</div>
									</td>

									<td>
										<div class="cost" data-original="<?php echo $cons['custo']; ?>">
											R$ <?php echo $cons['custo']; ?>
										</div>
									</td>

									<td>
										<div class="updated" data-original="<?php echo $cons['updated']; ?>">
											<?php echo date('d/m/Y H:s', strtotime($cons['updated'])); ?>
										</div>
									</td>

									<td>
										<div class="d-flex jc-center gap-12">
											<button class="cta update" aria-label="Editar linha de consumo" data-id="<?php echo $cons['id']; ?>" value="update-consumption"><i class="icon-edit"></i></button>
											<button class="cta delete" aria-label="Remover linha de consumo" data-id="<?php echo $cons['id']; ?>" value="delete-consumption"><i class="icon-trash"></i></button>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>

						<?php
						date_default_timezone_set('America/Sao_Paulo');
						$formatter = new IntlDateFormatter('pt_BR', null, null, 'America/Sao_Paulo', IntlDateFormatter::GREGORIAN, 'MMMM');
						?>

						<script>
							var dataDrawChart = [
								['Mês', 'Consumo', 'Reuso', { role: 'annotation' }, 'Custo'],
								<?php foreach ($consumption as $cons): ?>
								[
									'<?php echo ucfirst($formatter->format(new DateTime($cons['referencia']))); ?>', 
									parseFloat("<?php echo $cons['valor']; ?>"),
									parseFloat("<?php echo $cons['reuso']; ?>"),
									null,
									parseFloat("<?php echo $cons['custo']; ?>".replace(',', '.'))
								],
								<?php endforeach; ?>
							];
						</script>

						<div id="update-consumption" class="modal hide">
			                <div class="modal-content">
			                    <div class="modal-head">
			                        <button class="close-modal d-block" aria-label="Fechar modal" value="update-consumption">
			                            <i class="icon-close"></i>
			                        </button>

			                        <h2 class="tt-uppercase ta-center">Atualizar consumo</h2>
			                    </div>

			                    <hr>

			                    <div class="modal-body mt-60">
			                        <form action="#" method="post" class="update-cons">
			                            <legend>(<span>*</span>) Campos obrigatórios</legend>

			                            <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>
			                            <div class="message warning d-none"></div>
			                            <div class="message success d-none"></div>

			                            <input type="hidden" name="edit-consumption-id" value="">

			                            <div class="group">
				                            <label for="edit-line-reference">Data de referência *</label>
				                            <input type="date" id="edit-line-reference" name="edit-line-reference">
				                        </div>

				                        <div class="group columns2">
				                        	<div class="group pos-relative has-placeholder final">
				                        		<label for="edit-line-value">Consumo *</label>
				                        		<input type="text" id="edit-line-value" name="edit-line-value">
				                        		<div class="placeholder final">m³</div>
				                        	</div>

				                        	<div class="group pos-relative has-placeholder final">
				                        		<label for="edit-line-reuse">Quantidade reutilizada *</label>
				                        		<input type="text" id="edit-line-reuse" name="edit-line-reuse">
				                        		<div class="placeholder final">m³</div>
				                        	</div>
				                        </div>

				                        <div class="group pos-relative has-placeholder start">
			                        		<label for="edit-line-cost">Valor pago *</label>
			                        		<div class="placeholder start">R$</div>
			                        		<input type="tel" id="edit-line-cost" name="edit-line-cost" mask-money>
			                        	</div>

			                            <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>
			                            <div class="message warning d-none"></div>
			                            <div class="message success d-none"></div>

			                            <div class="d-flex fw-wrap jc-flex-end gap-16 mt-45">
			                                <button type="button" class="close-modal cta cta-light cta-small" value="update-consumption">Cancelar</button>
			                                <button type="submit" class="cta cta-small">Salvar</button>
			                            </div>
			                        </form>
			                    </div>
			                </div>
			            </div>

			            <div id="delete-consumption" class="modal hide">
			                <div class="modal-content">
			                    <div class="modal-head">
			                        <button class="close-modal d-block" aria-label="Fechar modal" value="delete-consumption">
			                            <i class="icon-close"></i>
			                        </button>

			                        <h2 class="tt-uppercase ta-center">Deletar consumo</h2>
			                    </div>

			                    <hr>

			                    <div class="modal-body mt-60">
			                        <form action="#" method="post" class="delete-cons">
			                        	<div class="message invalid d-none"></div>
			                            <div class="message success d-none"></div>

			                        	<p class="ta-center">
			                            	Tem certeza que deseja apagar esse dado de consumo?
			                        		<br>
			                        		<br>
			                        		<strong>Data:</strong> <span class="reference"></span>
			                        		<br>
			                        		<strong>Consumo:</strong> <span class="value"></span>
			                        	</p>
			                        	

			                            <input type="hidden" name="delete-consumption-id" value="">

			                            <div class="d-flex fw-wrap jc-flex-end gap-16 mt-45">
			                                <button type="button" class="close-modal cta cta-light cta-small" value="delete-consumption">Cancelar</button>
			                                <button type="submit" class="cta cta-small">Apagar</button>
			                            </div>
			                        </form>
			                    </div>
			                </div>
			            </div>
					</div>

					<div class="chart-view d-none">
						<div class="chart-consumption d-flex ai-center jc-center jc-md-flex-start"></div>

						<small class="d-block ta-center">Quantidade total reutilizada: <strong><?php echo $consumo->TotalReuseCompany($params['company']); ?> m³</strong></small>
					</div>
				<?php else: ?>
					<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado.</h3>
				<?php endif; ?>
				
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
		                        <div class="message warning d-none"></div>
		                        <div class="message success d-none"></div>

		                        <input type="hidden" name="new-line-company" value="<?php echo $params['company']; ?>">

		                        <div class="group">
		                        	<label for="new-line-type-file" class="d-flex ai-center gap-12">
		                        		<input type="checkbox" class="switch" id="new-line-type-file" name="new-line-type-file" value="sim">
		                        		Adicionar por planilha
		                        	</label>
		                        </div>


	                        	<div class="has-file group pos-relative d-none mt-45 mb-20">
		                        	<p>Não sabe como preencher a planilha? <a href="<?php echo UPLOADS; ?>modelo.xlsx" download target="_blank" rel="noopener">Clique aqui</a> e baixe o modelo.</p>

	                        		<label for="new-line-file"><i class="icon-paperclip"></i> Escolher Arquivo</label>
	                        		<input type="file" name="new-line-file" id="new-line-file">
	                        	</div>

		                        <div class="no-file d-block">
		                        	<div class="group">
			                            <label for="new-line-reference">Data de referência *</label>
			                            <input type="date" id="new-line-reference" name="new-line-reference">
			                        </div>

			                        <div class="group columns2">
			                        	<div class="group pos-relative has-placeholder final">
			                        		<label for="new-line-value">Consumo *</label>
			                        		<input type="text" id="new-line-value" name="new-line-value">
			                        		<div class="placeholder final">m³</div>
			                        	</div>

			                        	<div class="group pos-relative has-placeholder final">
			                        		<label for="new-line-reuse">Quantidade reutilizada *</label>
			                        		<input type="text" id="new-line-reuse" name="new-line-reuse">
			                        		<div class="placeholder final">m³</div>
			                        	</div>
			                        </div>

			                        <div class="group pos-relative has-placeholder start">
		                        		<label for="new-line-cost">Valor pago *</label>
		                        		<div class="placeholder start">R$</div>
		                        		<input type="tel" id="new-line-cost" name="new-line-cost" mask-money>
		                        	</div>
		                        </div>
								
								<div class="d-flex jc-flex-end ai-flex-end gap-24 mt-45">
									<button type="button" class="close-modal cta cta-light cta-small" value="add-new-line">Cancelar</button>
									<button type="submit" class="cta cta-small">Salvar</button>
								</div>
							</form>

						</div>
					</div>
				</div>

				<div class="d-flex fw-wrap gap-12 mt-45">
					<a href="ferramentas" class="cta cta-light cta-small"><i class="icon-back"></i> Voltar</a>
					<a href="ferramentas/projecoes" class="cta cta-dark cta-small d-flex ai-center jc-center">Área de projeções</a>
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

					<div class="navigation d-flex fw-wrap fd-column gap-16">
				        <?php foreach ($companies as $company): ?>
				        <a href="ferramentas/monitoramento?company=<?php echo $company['id']; ?>" class="d-flex ai-center gap-12 jc-space-between">
				        	<span class="d-flex ai-center gap-12"><i class="icon-gear"></i><?php echo $company['nome']; ?></span>
				            <button class="cta cta-small cta-light tt-uppercase ml-15">Selecionar</button>
				        </a>
				        <?php endforeach ?>
				    </div>
				</div>
			<?php else: ?>
				<h3 class="message">Você ainda não tem nenhum dado de consumo cadastrado.</h3>
			<?php endif; ?>	

			<div class="d-flex fw-wrap gap-12 mt-45">
				<a href="ferramentas" class="cta cta-light cta-small"><i class="icon-back"></i> Voltar</a>
				<a href="ferramentas/projecoes" class="cta cta-dark cta-small d-flex ai-center jc-center">Área de projeções</a>
			</div>
		</div>
	</div>
<?php endif ?>