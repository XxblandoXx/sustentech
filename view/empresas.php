<?php 

	$current = 'perfil';
    $companies = $empresa->getAllCompanies();

?>
<h1 class="for-sreader">Painel Administrativo - Sustentech</h1>

<div class="container-fluid">
    <div class="wrapper sm-margin">
    	<h2 class="ta-center">Gerenciar Empresas</h2>

        <hr>

        <?php if ($companies): ?>
        <div class="navigation d-flex fw-wrap fd-md-column ai-md-center jc-center">
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>Razão social</th>
                        <th>Última Atualização</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($companies as $key => $comp): ?>
                    <tr>
                        <td class="ta-center"><i class="icon-gear"></i></td>
                        <td><?php echo $comp['nome']; ?></td>
                        <td><?php echo date_format(date_create($comp['updated']), 'd/m/Y H:s') ?></td>
                        <td>
                            <div class="d-flex jc-center gap-12">
                                <button class="cta update open-modal" value="update-company-<?php echo $key; ?>" aria-label="Editar empresa">
                                    <i class="icon-edit"></i>
                                </button>
                                <button class="cta delete open-modal" value="delete-company-<?php echo $key; ?>" aria-label="Remover empresa">
                                    <i class="icon-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php foreach ($companies as $key => $company): ?>
            <div id="update-company-<?php echo $key; ?>" class="modal hide">
                <div class="modal-content">
                    <div class="modal-head">
                        <button class="close-modal d-block" aria-label="Fechar modal" value="update-company-<?php echo $key; ?>">
                            <i class="icon-close"></i>
                        </button>

                        <h2 class="tt-uppercase ta-center">Editar empresa <?php echo $company['nome']; ?></h2>
                    </div>

                    <hr>

                    <div class="modal-body mt-60">
                        <form action="#" method="post" class="update-company">
                            <legend>(<span>*</span>) Campos obrigatórios</legend>

                            <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>
                            <div class="message success d-none">Dados de empresa atualizados com sucesso!</div>

                            <input type="hidden" name="company-id" value="<?php echo $company['id']; ?>">

                            <div class="group">
                                <label for="company-name-<?php echo $key; ?>">Nome *</label>
                                <input type="text" id="company-name-<?php echo $key; ?>" name="company-name" value="<?php echo $company['nome']; ?>">
                            </div>

                            <div class="group">
                                <label for="company-segment-<?php echo $key; ?>">Segmento *</label>
                                <input type="text" id="company-segment-<?php echo $key; ?>" name="company-segment" value="<?php echo $company['segmento']; ?>">
                            </div>

                            <div class="group d-flex fw-wrap">
                                <label class="col-12">Tipo de reutilização *</label>

                                <div class="d-flex gap-12">
                                    <input type="radio" name="company-reuse" id="agua-cinza-<?php echo $key; ?>" value="agua-cinza"<?php echo $company['tipo_reuso'] == 'agua-cinza' ? ' checked' : ''; ?>>
                                    <label for="agua-cinza-<?php echo $key; ?>">Água Cinza</label>
                                </div>
                                <div class="d-flex gap-12">
                                    <input type="radio" name="company-reuse" id="reaproveitamento-da-chuva-<?php echo $key; ?>" value="reaproveitamento-da-chuva"<?php echo $company['tipo_reuso'] == 'reaproveitamento-da-chuva' ? ' checked' : ''; ?>>
                                    <label for="reaproveitamento-da-chuva-<?php echo $key; ?>">Reaproveitamento da Chuva</label>
                                </div>
                            </div>

                            <div class="group columns2">
                                <label for="company-maintenance-cost-<?php echo $key; ?>">Valor de manutenção</label>
                                <label for="company-maintenance-period-<?php echo $key; ?>" class="for-sreader">Período para pagamento de manutenção</label>

                                <div class="select-field pos-relative">
                                    <select name="company-maintenance-period" id="company-maintenance-period-<?php echo $key; ?>">
                                        <option value="">Selecione...</option>
                                        <option value="Mensal"<?php echo $company['periodo_manutencao'] == 'Mensal' ? ' selected' : ''; ?>>Mensal</option>
                                        <option value="Semestral"<?php echo $company['periodo_manutencao'] == 'Semestral' ? ' selected' : ''; ?>>Semestral</option>
                                        <option value="Anual"<?php echo $company['periodo_manutencao'] == 'Anual' ? ' selected' : ''; ?>>Anual</option>
                                    </select>

                                    <i class="icon-arrow"></i>
                                </div>

                                <div class="money-field pos-relative">
                                    <strong class="d-block pos-absolute">R$</strong>
                                    <input type="tel" name="company-maintenance-cost" id="company-maintenance-cost" mask-money value="<?php echo $company['custo_manutencao']; ?>">
                                </div>
                            </div>

                            <div class="choices<?php echo $company['tipo_reuso'] == 'reaproveitamento-da-chuva' ? ' d-none' : ''; ?>" reference="agua-cinza">
                                <div class="group">
                                    <label for="company-water-origin">Origem da água *</label>
                                    <input type="text" id="company-water-origin" name="company-water-origin" value="<?php echo $company['origem']; ?>">
                                </div>

                                <div class="group">
                                    <label for="company-processing">Tecnologia de tratamento *</label>
                                    <input type="text" id="company-processing" name="company-processing" value="<?php echo $company['tratamento']; ?>">
                                </div>
                            </div>

                            <div class="choices<?php echo $company['tipo_reuso'] == 'agua-cinza' ? ' d-none' : ''; ?>" reference="reaproveitamento-da-chuva">
                                <div class="group">
                                    <label for="company-escoamento">Coeficiente de Escoamento *</label>
                                    <input type="text" id="company-escoamento" name="company-escoamento" value="<?php echo $company['escoamento']; ?>">
                                </div>
                            </div>

                            <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>
                            <div class="message success d-none">Dados de empresa atualizados com sucesso!</div>

                            <div class="d-flex fw-wrap jc-flex-end gap-16 mt-45">
                                <button type="button" class="close-modal cta cta-light" value="update-company-<?php echo $key; ?>">Cancelar</button>
                                <button type="submit" class="cta">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="delete-company-<?php echo $key; ?>" class="modal hide">
                <div class="modal-content">
                    <div class="modal-head">
                        <button class="close-modal d-block" aria-label="Fechar modal" value="delete-company-<?php echo $key; ?>">
                            <i class="icon-close"></i>
                        </button>

                        <h2 class="tt-uppercase ta-center">Apagar empresa <?php echo $company['nome']; ?></h2>
                    </div>

                    <hr>

                    <div class="modal-body mt-60">
                        <form action="#" method="post" class="delete-company">
                            <div class="message invalid d-none"></div>
                            <div class="message success d-none"></div>

                            <p class="ta-center">Tem certeza que deseja apagar essa empresa?</p>

                            <input type="hidden" name="delete-company-id" value="<?php echo $company['id']; ?>">

                            <div class="d-flex fw-wrap jc-flex-end gap-16 mt-45">
                                <button type="button" class="close-modal cta cta-light cta-small" value="delete-company-<?php echo $key; ?>">Cancelar</button>
                                <button type="submit" class="cta cta-small">Apagar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
        <?php else: ?>
            <p class="ta-center">Não há empresas vinculadas a esse perfil.</p>
        <?php endif; ?>


        <div id="add-company" class="modal hide">
            <div class="modal-content">
                <div class="modal-head">
                    <button class="close-modal d-block" aria-label="Fechar modal" value="add-company">
                        <i class="icon-close"></i>
                    </button>

                    <h2 class="tt-uppercase ta-center">Cadastrar empresa</h2>
                </div>

                <hr>

                <div class="modal-body mt-60">
                    <form action="#" method="post" class="add-new-company">
                        <legend>(<span>*</span>) Campos obrigatórios</legend>

                        <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>

                        <div class="message success d-none">Nova empresa cadastrada com sucesso!</div>

                        <div class="group">
                            <label for="company-name">Nome *</label>
                            <input type="text" id="company-name" name="company-name">
                        </div>

                        <div class="group">
                            <label for="company-segment">Segmento *</label>
                            <input type="text" id="company-segment" name="company-segment">
                        </div>

                        <div class="group d-flex fw-wrap">
                            <label class="col-12">Tipo de reutilização *</label>

                            <div class="d-flex gap-12">
                                <input type="radio" name="company-reuse" id="agua-cinza" value="agua-cinza">
                                <label for="agua-cinza">Água Cinza</label>
                            </div>
                            <div class="d-flex gap-12">
                                <input type="radio" name="company-reuse" id="reaproveitamento-da-chuva" value="reaproveitamento-da-chuva">
                                <label for="reaproveitamento-da-chuva">Reaproveitamento da Chuva</label>
                            </div>
                        </div>

                        <div class="group columns2">
                            <label for="company-maintenance-cost">Valor de manutenção</label>
                            <label for="company-maintenance-period" class="for-sreader">Período para pagamento de manutenção</label>

                            <div class="select-field pos-relative">
                                <select name="company-maintenance-period" id="company-maintenance-period">
                                    <option value="">Selecione...</option>
                                    <option value="Mensal">Mensal</option>
                                    <option value="Semestral">Semestral</option>
                                    <option value="Anual">Anual</option>
                                </select>

                                <i class="icon-arrow"></i>
                            </div>

                            <div class="money-field pos-relative">
                                <strong class="d-block pos-absolute">R$</strong>
                                <input type="tel" name="company-maintenance-cost" id="company-maintenance-cost" mask-money>
                            </div>
                        </div>

                        <div class="d-none choices" reference="agua-cinza">
                            <div class="group">
                                <label for="company-water-origin">Origem da água *</label>
                                <input type="text" id="company-water-origin" name="company-water-origin">
                            </div>

                            <div class="group">
                                <label for="company-processing">Tecnologia de tratamento *</label>
                                <input type="text" id="company-processing" name="company-processing">
                            </div>
                        </div>

                        <div class="d-none choices" reference="reaproveitamento-da-chuva">
                            <div class="group">
                                <label for="company-escoamento">Coeficiente de Escoamento *</label>
                                <input type="text" id="company-escoamento" name="company-escoamento">
                            </div>
                        </div>

                        <div class="d-flex fw-wrap jc-flex-end gap-16 mt-45">
                            <button type="button" class="close-modal cta cta-light" value="add-company">Cancelar</button>
                            <button type="submit" class="cta">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="d-flex fw-wrap jc-space-between gap-16 mt-45">
            <a href="painel-administrativo" class="cta cta-light cta-small">Voltar</a>                
            <button class="cta cta-small open-modal" type="button" value="add-company">Adicionar empresa</button>
        </div>
    </div>
</div>