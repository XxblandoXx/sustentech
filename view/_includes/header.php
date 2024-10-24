<?php 

    $site = new System();
    $hasFooter = false;

?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <base href="<?php echo BASE_URL; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo IMAGES; ?>favicon.png">
    <link rel="favorite icon" type="image/png" href="<?php echo IMAGES; ?>favicon.png">
    <link rel="shortcut icon" type="image/png" href="<?php echo IMAGES; ?>favicon.png">
    <link rel="stylesheet" type="text/css" href="<?php echo STYLES; ?>main.css">

    <title>Sustentech</title>
</head>
<body>

    <?php if ($site->getController() != 'index' and $site->getController() != 'conta'): ?>
    <header class="d-flex ai-center jc-center">
        <img src="<?php echo IMAGES; ?>logo-sustentech.png" alt="Logo Sustentech" width="292" height="85">
    </header>

    <div class="leaves pos-absolute mb d-none d-md-flex ai-center jc-center mobile top">
        <img src="<?php echo IMAGES; ?>folhagem.png" alt="" width="1026" height="502">
    </div>
    <?php endif ?>

    <main data-page="<?php echo $site->getController(); ?>" data-subpage="<?php echo $site->actions; ?>">