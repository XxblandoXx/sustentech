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
        }

        if ($('form.add-new-consumption .error').length) {
            $('form.add-new-consumption .message.invalid').removeClass('d-none');
            return;
        }

        var data = new FormData();
        data.append('file', $('[name="new-line-file"]').prop('files')[0]);
        data.append('reference', $('[name="new-line-reference"]').val());
        data.append('value', $('[name="new-line-value"]').val());
        data.append('company', $('[name="new-line-company"]').val());

        $.ajax({
            data: data,
            type: 'POST',
            dataType: 'json',
            cache : false,
            processData: false,
            contentType: false,
            url: 'ferramentas/save-consumption',
        }).done(function (response) {
            // var res = JSON.parse(response);

            if (response.status == 'success') {
                $('form.add-new-consumption .message.success').html(response.message).removeClass('d-none');

                setTimeout(function() {
                    window.location.reload()
                }, 3000);
            }
            else {
                $('form.add-new-consumption .message.invalid').html(response.message).removeClass('d-none');
            }
        });

        $('form.add-new-consumption [type="submit"]').text('Salvando...');
        $('form.add-new-consumption input, form.add-new-consumption select, form.add-new-consumption button').prop('disabled', true);
    });
})

