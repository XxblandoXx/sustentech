function ClickEvents() {

    // Abrir e fechar acordeon
    $('.accordions .accordion button').on('click', function () {
        $(this).parent().toggleClass('active'); // alterna a cada click a adição ou remoção da classe active no Elemento Pai
    });

    // Abrir modal
    $('.open-modal').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será aberto
        $('.modal#'+reference).css('display', 'flex').hide().fadeIn().removeClass('hide'); // Transição para abrir modal
    });

    // Fechar modal
    $('.close-modal').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será fechado
        $('.modal#'+reference).fadeOut().addClass('hide'); // Transição para fechar modal

        if ($('.result').length) $('.result').html('');
    });

    // Abrir modal para atualizar consumo
    $('.monitoramento .table-view .cta.update').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var id = $(this).data('id');
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será aberto

        $('[name="edit-consumption-id"]').val(id);
        $('[name="edit-line-reference"]').val($(`#cons-id-${id} .reference`).data('original'));
        $('[name="edit-line-value"]').val($(`#cons-id-${id} .value`).data('original'));
        $('[name="edit-line-reuse"]').val($(`#cons-id-${id} .reuse`).data('original'));
        $('[name="edit-line-cost"]').val($(`#cons-id-${id} .cost`).data('original'));

        $(`.modal#${reference}`).fadeIn().removeClass('hide'); // Transição para abrir modal
    });

    // Abrir modal para apagar consumo
    $('.monitoramento .table-view .cta.delete').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var id = $(this).data('id');
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será aberto

        $('[name="delete-consumption-id"]').val(id);
        $('p span.reference').html($(`#cons-id-${id} .reference`).html());
        $('p span.value').html($(`#cons-id-${id} .value`).html());

        $(`.modal#${reference}`).fadeIn().removeClass('hide'); // Transição para abrir modal
    });

    // Trocar visualização de tabela para gráfico e vice versa
    $('.change-view').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão

        $('.table-view, .chart-view').removeClass('d-block').addClass('d-none');

        $('.change-view').removeClass('d-none');
        $(this).addClass('d-none');
        $('.'+$(this).val()).removeClass('d-none');

        google.charts.load('current', {
            'packages': ['corechart', 'controls'],
            'language': 'pt-BR'
        });
        google.charts.setOnLoadCallback(drawChartMonitoramento);
    });

    // Função para exibir - ocultar senha
    $('.password').on('click', function(event) {
        event.preventDefault();

        var input = $('.change-pass input');
        var type = $(input).attr('type');

        if(type === 'password') {
            $(input).attr('type', 'text');
            $(this).find('i').attr('class', 'icon-eye-off');
        }
        else {
            $(input).attr('type', 'password')
            $(this).find('i').attr('class', 'icon-eye');
        }
    });

    $('.filters-projections button').on('click', function() {
        $('.filters-projections button').removeClass('cta-dark');
        $(this).addClass('cta-dark');
        filterPeriod(parseInt($(this).val()))
    });
}

function ChangeEvent() {
    $('form.add-new-company [name="company-reuse"], :not(.hide) form.update-company [name="company-reuse"]').on('change', function() {
        $('form.add-new-company .choices').addClass('d-none')
        $('form.add-new-company .choices[reference="' + $(this).val() + '"]').removeClass('d-none')
    });

    $('[name="new-line-type-file"]').on('change', function() {
        if (this.checked) {
            $('.has-file').removeClass('d-none').addClass('d-block');
            $('.no-file').removeClass('d-block').addClass('d-none');
        }
        else {
            $('.no-file').removeClass('d-none').addClass('d-block');
            $('.has-file').removeClass('d-block').addClass('d-none');
        }
    });

    $('[name="new-line-file"]').on('change', function() {
        var filename = $(this)[0].files.length ? $(this)[0].files[0].name : 'Escolher Arquivo';
       $('.has-file label').html('<i class="icon-paperclip"></i> ' + filename); 
    });
}

function SubmitEvent() {
    $('#simulador form').on('submit', function(event) {
        event.preventDefault();

        if (! $('[name="consumo"]').val()) {
            $('[name="consumo"]').parent().addClass('error');
            return;
        }

        var content = '';
        var periods = [
            {
                "value": 1,
                "label": "1 mês"
            },
            {
                "value": 3,
                "label": "3 meses"
            }
        ];
        var consumo = parseFloat($('[name="consumo"]').val().replace(',', '.'));

        periods.forEach(function(month) {
            content += `
            <div class="item">
                <h3>Estimativa de ${month.label}</h3>
                <p>Reutilização: <strong>${([consumo * 0.6] * month.value).toFixed(2)}m³</strong></p>
                <p>Retorno obtido: <strong>R$  ${([consumo * 0.31]  * month.value).toFixed(2)}</strong></p>
            </div>
            `;
        });

        $('#simulador .result').html(content);
    });

    $('form.add-new-company').on('submit', function(event) {
        event.preventDefault();

        $('.error').removeClass('error');
        $('.message.invalid').addClass('d-none');

        if (! $('[name="company-name"]').val()) $('[name="company-name"]').parent().addClass('error');
        if (! $('[name="company-segment"]').val()) $('[name="company-segment"]').parent().addClass('error');
        if (! $('[name="company-reuse"]').val()) $('[name="company-reuse"]').parent().addClass('error');

        if ($('[name="company-reuse"]').is() == 'agua-cinza') {
            if (! $('[name="company-water-origin"]').val()) $('[name="company-water-origin"]').parent().addClass('error');
            if (! $('[name="company-processing"]').val()) $('[name="company-processing"]').parent().addClass('error');
        }

        if ($('[name="company-reuse"]').val() == 'reaproveitamento-da-chuva') {
            if (! $('[name="company-escoamento"]').val()) $('[name="company-escoamento"]').parent().addClass('error');
        }

        if ($('.error').length) {
            $('.message.invalid').removeClass('d-none');
            return;
        }

        $.post('conta/cadastrar-empresa', $(this).serialize())
            .done(function(response) {
                var res = JSON.parse(response);

                if (res.status == 'success') {
                    $('.message.success').html(res.message).removeClass('d-none');

                    setTimeout(function() {
                        window.location.reload()
                    }, 3000);
                }
                else {
                    $('.message.invalid').html(res.message).removeClass('d-none');
                }
            });
    });

    $('form.update-company').on('submit', function(event) {
        event.preventDefault();

        $('.error').removeClass('error');
        $('.message.invalid').addClass('d-none');

        if (! $('[name="company-name"]').val()) $('[name="company-name"]').parent().addClass('error');
        if (! $('[name="company-segment"]').val()) $('[name="company-segment"]').parent().addClass('error');
        if (! $('[name="company-reuse"]').val()) $('[name="company-reuse"]').parent().addClass('error');

        if ($('[name="company-reuse"]').is() == 'agua-cinza') {
            if (! $('[name="company-water-origin"]').val()) $('[name="company-water-origin"]').parent().addClass('error');
            if (! $('[name="company-processing"]').val()) $('[name="company-processing"]').parent().addClass('error');
        }

        if ($('[name="company-reuse"]').val() == 'reaproveitamento-da-chuva') {
            if (! $('[name="company-escoamento"]').val()) $('[name="company-escoamento"]').parent().addClass('error');
        }

        if ($('.error').length) {
            $('.message.invalid').removeClass('d-none');
            return;
        }

        $.post('conta/editar-empresa', $(this).serialize())
            .done(function(response) {
                var res = JSON.parse(response);

                if (res.status == 'success') {
                    $('.message.success').html(res.message).removeClass('d-none');

                    setTimeout(function() {
                        window.location.reload()
                    }, 3000);
                }
                else {
                    $('.message.invalid').html(res.message).removeClass('d-none');
                }

                //$(this).get(0).reset();
                $('form.update-company [type="submit"]').text('Salvar');
                $('form.update-company input, form.update-company select, form.update-company button').prop('disabled', false);
            });

        $('form.update-company [type="submit"]').text('Salvando...');
        $('form.update-company input, form.update-company select, form.update-company button').prop('disabled', true);
    });

    $('form.delete-company').on('submit', function(event) {
        event.preventDefault();

        $('form.delete-company .message.invalid').addClass('d-none');

        $.post('conta/deletar-empresa', $(this).serialize())
            .done(function(response) {
                var res = JSON.parse(response);

                if (res.status == 'success') {
                    $('form.delete-company .message.success').html(res.message).removeClass('d-none');

                    setTimeout(function() {
                        window.location.reload()
                    }, 3000);
                }
                else {
                    $('form.delete-company .message.invalid').html(res.message).removeClass('d-none');
                }

                $('form.delete-company button').prop('disabled', false);
            });

        $('form.delete-company button').prop('disabled', false);
    });

    // Adicionar consumo
    $('form.add-new-consumption').on('submit', function(event) {
        event.preventDefault();

        $('form.add-new-consumption .error').removeClass('error');
        $('form.add-new-consumption .message.invalid').addClass('d-none');

        if ($('[name="new-line-type-file"]').prop('checked')) {
            if (! $('[name="new-line-file"]').val()) $('[name="new-line-file"]').parent().addClass('error');
        }
        else {
            if (! $('[name="new-line-reference"]').val()) $('[name="new-line-reference"]').parent().addClass('error');
            if (! $('[name="new-line-value"]').val()) $('[name="new-line-value"]').parent().addClass('error');
            if (! $('[name="new-line-cost"]').val()) $('[name="new-line-cost"]').parent().addClass('error');
            if (! $('[name="new-line-reuse"]').val()) $('[name="new-line-reuse"]').parent().addClass('error');
        }

        if ($('form.add-new-consumption .error').length) {
            $('form.add-new-consumption .message.invalid').removeClass('d-none');
            return;
        }

        var data = new FormData();
        data.append('new-line-company', $('[name="new-line-company"]').val());
        if ($('[name="new-line-file"]').prop('files')[0]) data.append('new-line-file', $('[name="new-line-file"]').prop('files')[0]);
        data.append('new-line-reference', $('[name="new-line-reference"]').val());
        data.append('new-line-value', $('[name="new-line-value"]').val());
        data.append('new-line-cost', $('[name="new-line-cost"]').val());
        data.append('new-line-reuse', $('[name="new-line-reuse"]').val());

        $.ajax({
            data: data,
            type: 'POST',
            dataType: 'json',
            cache : false,
            processData: false,
            contentType: false,
            url: 'ferramentas/save-consumption',
        }).done(function (response) {
            if (response.status == 'success') {
                $('form.add-new-consumption .message.success').html(response.message).removeClass('d-none');

                setTimeout(function() {
                    window.location.reload()
                }, 2500);
            }
            else if (response.status == 'warning') {
                $('form.add-new-consumption .message.warning').html(response.message).removeClass('d-none');

                setTimeout(function() {
                    window.location.reload()
                }, 2500);
            }
            else {
                $('form.add-new-consumption .message.invalid').html(response.message).removeClass('d-none');
            }

            $('form.add-new-consumption [type="submit"]').text('Salvar');
            $('form.add-new-consumption input, form.add-new-consumption select, form.add-new-consumption button').prop('disabled', false);
        });

        $('form.add-new-consumption [type="submit"]').text('Salvando...');
        $('form.add-new-consumption input, form.add-new-consumption select, form.add-new-consumption button').prop('disabled', true);
    });

    // Atualizar dados do consumo
    $('form.update-cons').on('submit', function(event) {
        event.preventDefault();

        $('form.update-cons .error').removeClass('error');
        $('form.update-cons .message.invalid').addClass('d-none');


        if (! $('[name="edit-line-reference"]').val()) $('[name="edit-line-reference"]').parent().addClass('error');
        if (! $('[name="edit-line-value"]').val()) $('[name="edit-line-value"]').parent().addClass('error');
        if (! $('[name="edit-line-cost"]').val()) $('[name="edit-line-cost"]').parent().addClass('error');
        if (! $('[name="edit-line-reuse"]').val()) $('[name="edit-line-reuse"]').parent().addClass('error');


        if ($('form.update-cons .error').length) {
            $('form.update-cons .message.invalid').removeClass('d-none');
            return;
        }

        $.post('ferramentas/update-consumption', $(this).serialize())
            .done(function(response) {
                var res = JSON.parse(response);

                if (res.status == 'success') {
                    $('form.update-cons .message.success').html(res.message).removeClass('d-none');

                    setTimeout(function() {
                        window.location.reload()
                    }, 2500);
                }
                else {
                    $('form.update-cons .message.invalid').html(res.message).removeClass('d-none');
                }

                $('form.update-cons input, form.update-cons select, form.update-cons button').prop('disabled', false);
                $('form.update-cons button').html('Salvar');
            });

        $('form.update-cons input, form.update-cons select, form.update-cons button').prop('disabled', true);
        $('form.update-cons button').html('Salvando...');
    });

    // Apagar dados do consumo
    $('.delete-cons').on('submit', function(event) {
        event.preventDefault();

        $.post('ferramentas/delete-consumption', $(this).serialize())
            .done(function(response) {
                var res = JSON.parse(response);

                if (res.status == 'success') {
                    $('.delete-cons .message.success').html(res.message).removeClass('d-none');

                    setTimeout(function() {
                        window.location.reload()
                    }, 2500);
                }
                else {
                    $('.delete-cons .message.invalid').html(res.message).removeClass('d-none');
                }

                $('.delete-cons input, .delete-cons button').prop('disabled', false);
                $('.delete-cons button').html('Apagar');
            });

        $('.delete-cons input, .delete-cons button').prop('disabled', true);
        $('.delete-cons button').html('Apagando...');
    });
}

function SiteBoot() {
    if ($('form .message.success').length) {
        setTimeout(function() {
            $('form .message.success').fadeOut();
        }, 3000);
    }

    $('[mask-money]').mask("#.##0,00", {reverse: true});

    setTimeout(function() {
        if ($('[data-subpage="projecoes"]').length) {
            google.charts.load('current', {packages: ['corechart', 'controls']});
            google.charts.setOnLoadCallback(drawChartProjecoes);
        }
    }, 500)
}

function drawChartMonitoramento () {
    var data = new google.visualization.arrayToDataTable(dataDrawChart);

    // Formatação de moeda
    var formatter = new google.visualization.NumberFormat({
        prefix: 'R$ ', 
        negativePrefix: 'R$ -', 
        fractionDigits: 2
    });
    formatter.format(data, 4); // Formata a coluna 'Valor Pago'
    
    var options = {
        title: 'Gráfico de monitoramento',
        vAxes: {
            0: {title: 'Consumo / Quantidade Reutilizada'},  // Eixo para Consumo e Água Reutilizada
            1: {title: 'Valor Pago', format: 'currency'} // Eixo para Valor Pago
        },
        series: {
            0: {type: 'bars', targetAxisIndex: 0}, // Consumo
            1: {type: 'bars', targetAxisIndex: 0}, // Água Reutilizada
            2: {type: 'bars', targetAxisIndex: 1}  // Valor Pago
        },
        legend: { position: 'bottom' },
        width: 800,
        height: 450,
        bars: 'vertical',
        colors: ['#45B583', '#354F52', '#F4A261'],
    }

    var chart = new google.visualization.ComboChart(document.querySelector('.chart-consumption'));
    chart.draw(data, options);
}


var dataChartProjection, chartProjection, optionChartProjection;
function drawChartProjecoes () {
    dataChartProjection = new google.visualization.arrayToDataTable(dataDrawChart);

    var formatMeters = new google.visualization.NumberFormat({suffix: ' m³'});
    var formatCurrency = new google.visualization.NumberFormat({prefix: 'R$ '});

    formatMeters.format(dataChartProjection, 1);
    formatMeters.format(dataChartProjection, 2);
    formatCurrency.format(dataChartProjection, 3);
    formatCurrency.format(dataChartProjection, 4);

    optionChartProjection = {
        title: 'Gráfico de Projeções',
        curveType: 'function',
        legend: { position: 'bottom' },
        width: 950,
        height: 450,
        lineWidth: 4,
        pointSize: 10,
        hAxis: { title: 'Período' },
        vAxis: { 
            title: 'Consumo/ Reutilização', 
            baseline: 0,
            viewWindow: { min: 0 }
        },
        gridlines: { count: 4 },
        series: {
            0: { color: '#45B583' },
            1: { color: '#354F52' },
            2: { color: '#ae2012' },
            3: { color: '#F4A261' }
        }
    };

    chartProjection = new google.visualization.LineChart(document.querySelector('.chart-projections'));
    filterPeriod(3);
}

function filterPeriod(period) {
    var view = new google.visualization.DataView(dataChartProjection);
    view.setRows(0, period);

    chartProjection.draw(view, optionChartProjection);
}

$(function() {

    ClickEvents()
    ChangeEvent()
    SubmitEvent()
    SiteBoot()

});