<?php


class inicioController extends Controller {

    public function index() {
        require(PATH_VIEW . '_includes/header.php');
        require(PATH_VIEW . 'inicio.php');
        require(PATH_VIEW . '_includes/menubar.php');
        require(PATH_VIEW . '_includes/footer.php');
    }
    
}