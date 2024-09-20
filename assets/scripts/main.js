$(function() {
    $('.accordions .accordion button').on('click', function () {
        $(this).parent().toggleClass('active'); // alterna a cada click a adição ou remoção da classe active no Elemento Pai
    });

    // Abrir modal
    $('.open-modal').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será aberto
        $('.modal#'+reference).fadeIn().removeClass('hide'); // Transição para abrir modal
    });

    // Fechar modal
    $('.close-modal').on('click', function (event) {
        event.preventDefault(); //desabilita a ação do botão
        var reference = $(this).val(); // armazena o valor do botão para referenciar o modal que será fechado
        $('.modal#'+reference).fadeOut().addClass('hide'); // Transição para fechar modal

        if ($('.result').length) $('.result').html('');
    });

    if ($('form .message.success').length) {
        setTimeout(function() {
            $('form .message.success').fadeOut();
        }, 3000);
    }

    $('[mask-money]').mask("#.##0,00", {reverse: true});

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

    $('#simulador form').on('submit', function(event) {
        event.preventDefault();

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
        var consumo = $('[name="consumo"]').val();

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

    $('form.add-new-company [name="company-reuse"], :not(.hide) form.update-company [name="company-reuse"]').on('change', function() {
        $('form.add-new-company .choices').addClass('d-none')
        $('form.add-new-company .choices[reference="' + $(this).val() + '"]').removeClass('d-none')
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
                console.log(response)
                //$(this).get(0).reset();
                //$('#contato form .success').fadeIn();
                //$('#contato form input[type="submit"]').val('Enviar');
                //$('#contato form input, #contato form select, #contato form textarea, #contato form button').prop('disabled', false);
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
})

