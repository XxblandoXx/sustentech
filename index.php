<?php


require_once('config.php');


spl_autoload_register(function ($classname) {

    if (str_contains($classname, 'PhpOffice') or str_contains($classname, 'PHPMailer')) {
        require_once __DIR__ . '/vendor/autoload.php';
        return;
    }
    
    $path = [PATH_CONTROLLER, PATH_HELPER, PATH_MODEL];
    $is_class = null;

    foreach($path as $p) {
        if (!$is_class and file_exists("$p$classname.php") and !is_dir("$p$classname.php")) {
            include_once("$p$classname.php");
            $is_class = true;
        }
    }

    if (!$is_class)
        die("Classe $classname não encontrada!");
});

$site = new System();
$site->session_init();
$site->getPage();