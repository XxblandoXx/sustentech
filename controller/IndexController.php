<?php


class IndexController extends Controller {

    public function index() {
        $site = new System();

        if ($site->verify_session()) {
            header('Location: inicio');
        } 
        else {
            require(PATH_VIEW . '_includes/header.php');
            require(PATH_VIEW . 'index.php');
            require(PATH_VIEW . '_includes/footer.php');
        }

    }
    
}