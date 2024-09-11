<?php 

	$current = 'perfil';

    $url = $_SERVER['REQUEST_URI'];
    $query = parse_url($url, PHP_URL_QUERY);
    parse_str($query, $params);

?>
<h1 class="for-sreader">Painel Administrativo - Sustentech</h1>

<div class="wrapper sm-margin">
	<h2 class="ta-center">Gerenciar Empresas</h2>

    <?php if ($modelo->ListarEmpresas()): ?>

    <?php else: ?>
        <p class="ta-center">Não há empresas vinculadas a esse perfil.</p>
    <?php endif; ?>

    <hr>

    <div id="add-company" class="modal hide">
        <div class="modal-content">
            <div class="modal-head">
                <button class="close-modal d-block" aria-label="Fechar modal">
                    <i class="icon-close"></i>
                </button>

                <h2 class="tt-uppercase ta-center">Cadastrar empresa</h2>
            </div>

            <hr>

            <div class="modal-body mt-60">
                <form action="#" method="post" class="add-new-company">
                    <legend>(<span>*</span>) Campos obrigatórios</legend>

                    <div class="message invalid d-none">Campos obrigátorios não foram preenchidos</div>

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
                            <input type="radio" name="company-reuse" id="agua-cinza" value="Água cinza">
                            <label for="agua-cinza">Água Cinza</label>
                        </div>
                        <div class="d-flex gap-12">
                            <input type="radio" name="company-reuse" id="reaproveitamento-da-chuva" value="Reaproveitamento da chuva">
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
                        <button type="button" class="modal-close cta cta-light">Cancelar</button>
                        <button type="submit" class="cta">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-flex fw-wrap jc-space-between gap-16">
        <a href="painel-administrativo" class="cta cta-light">Voltar</a>                
        <button class="cta open-modal" type="button" value="add-company">Adicionar empresa</button>
    </div>
</div>