<?php 

    $content = json_decode(file_get_contents(UPLOADS . 'informativo.json'), true);
    $content = $content[$site->actions];
    $current = 'painel-informativo';

?>

<h1 class="for-sreader">Painel Informativo - Sustentech</h1>

<div class="wrapper sm-margin">
    <h2 class="ta-center">
        <i class="<?php echo $content['icon']; ?>"></i>
        <?php echo $content['title']; ?>
    </h2>

    <hr>

    <div class="accordions">
        <?php foreach ($content['accordion'] as $acc): ?>
        <div class="accordion">
            <button type="button" class="title">
                <?php echo $acc['label']; ?> <i class="icon-arrow"></i>
            </button>
            
            <div class="inner">
                <div>
                    <?php echo $acc['text']; ?>   
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <hr>

    <div class="tratamentos mb-45">
        <h3 class="ta-center mb-20">Formas de Tratamento</h3>

        <div class="d-flex fw-wrap gap-16 jc-center">
            <?php foreach ($content['tratamentos'] as $trt): ?>
                <a href="<?php echo $trt['url']; ?>" class="cta cta-dark ta-center"><?php echo $trt['label']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>

    <a href="painel-informativo" class="cta cta-light cta-small"><i class="icon-back"></i> Voltar</a>
</div>